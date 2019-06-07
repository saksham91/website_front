<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	$check_string = array();
	/* if POST['info'] is set in the ajax request, means that the status is set to something other than Hold.
		So we will need to update the information in the line_item table.
		We will also need to check if this particular line item is in the hold table AND has a hold_status of 1. 
		If it has, we need to change the hold_status in the hold table to 0.

		Hold_status = 1: Item is currently on hold
		Hold_status = 0: Item is not currently in hold but was at some point
	*/
	if(isset($_POST['line_item']) && isset($_POST['info'])){

		$li = $_POST['line_item'];
		$values = $_POST['info'];
		$misc_repair = $_POST['misc'];
		$comp_info = $_POST['component'];
		
		//print_r($comp_info);

		$part = $values[0];
		$serial = $values[1];
		$tech = $values[2];
		$problem = $values[3];
		$repair = $values[4];
		$status = $values[5];
		$date1 = $values[6];
		$date2 = $values[7];
		$labor = $values[8];
		$note = $values[9];

		//check to see whether this item exists in the HOLD table.
		//If it does, change the hold_status to 0 (item no more in HOLD status)
		$sql_hold = "SELECT status FROM hold WHERE li_id = ?";
		$stmt = $dbh->prepare($sql_hold);
		$stmt->execute([$li]);
		$item_exists = $stmt->fetch();
		if($item_exists){
			$sql = "UPDATE hold SET status = 0 WHERE li_id = ?";
			$stmt = $dbh->prepare($sql);
			$stmt->execute([$li]);
		}

		//now proceeding with updating the info in the line_item table
		$sql = "UPDATE line_item SET device_number=?, serial_number=?, technician=?, prob_found=?, repair_done=?, status=?, date_arrived=?, date_closed=?, labor_hrs=?, note=? WHERE li_id=?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([$part, $serial, $tech, $problem, $repair, $status, $date1, $date2, $labor, $note, $li]);
		$num_of_rows = $stmt->rowCount();
		$confirm = "Updated ". $num_of_rows ." rows.";
		array_push($check_string, $confirm);
		
		//checking if any of the misc_repair checkboxes have been clicked. If not, no need to insert anything.
		if(count($misc_repair) > 0){
			$sql = "SELECT * FROM li_misc WHERE li_id = ?";
			$stmt = $dbh->prepare($sql);
			$stmt->execute([$li]);
			$count = $stmt->rowCount();		//if there's already information about the misc repair of this Line Item, delete that and then add the new misc_repair info
			if($count > 0){
				$sql = "DELETE FROM li_misc WHERE li_id = ?";
				$stmt = $dbh->prepare($sql);
				$stmt->execute([$li]);
				$num_of_rows = $stmt->rowCount();
				$confirm = "Deleted from li_misc " .$num_of_rows. " rows.";
				array_push($check_string, $confirm);
			}
			for($i = 0; $i < count($misc_repair); $i++){
				$sql2 = "INSERT INTO li_misc(li_id, misc_id) VALUES (?, ?)";
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->execute([$li, $misc_repair[$i]]);
				$num_of_rows = $stmt2->rowCount();
				$confirm = "Inserted into li_misc " . $num_of_rows . " rows.";
				array_push($check_string, $confirm);
			}
		}

		if(count($comp_info) > 0){
			$sql = "SELECT * FROM component_info WHERE li_id = ?";
			$stmt = $dbh->prepare($sql);
			$stmt->execute([$li]);
			$count = $stmt->rowCount();
			//if there's already information about the component replaced of this Line Item, delete that and then add the new component info
			if($count > 0){
				$sql = "DELETE FROM component_info WHERE li_id = ?";
				$stmt = $dbh->prepare($sql);
				$stmt->execute([$li]);
			}
			foreach($comp_info as $component){
				$sql2 = "INSERT INTO component_info(li_id, remove_p1, remove_s1, install_s1) VALUES (?, ?, ?, ?)";
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->execute([$li, $component['part_removed'], $component['serial_removed'], $component['serial_installed']]);
			}
		}
		echo json_encode($check_string);	
	}
	/*
		if the status is set to 'HOLD', ajax request will contain status value in the POST request
		We will update/insert the information in the HOLD table.
		INSERT if there is no row found for the selected line item id.
		UPDATE if there is a row found for the selected line_id.
		We also need to change the status value to 6(Hold) in the line_item table
	*/
	else if(isset($_POST['line_item']) && isset($_POST['status'])){
		$status = $_POST['status'];	//this is the status number for updating the status in line_item table
		$li = $_POST['line_item'];
		$po_no = $_POST['po_no'];
		$eta = $_POST['eta'];
		$dmr = $_POST['dmr'];
		$missing = $_POST['miss'];
		$hnote = $_POST['hnote'];
		$day = $_POST['day'];
		$tech_name = $_POST['tech'];
		$day_arrived = $_POST['arrived'];

		//updating the status value of the item in the line_item table to status = 6, corresponding to HOLD status
		$sql = "UPDATE line_item SET status = ?, technician = ?, date_arrived = ? WHERE li_id = ?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([$status, $tech_name, $day_arrived, $li]);
		$confirm = "Updated the status value in the LINE ITEM table.";
		array_push($check_string, $confirm);

		$sql = "SELECT date_hold FROM hold WHERE li_id = ?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([$li]);
		$li_exists = $stmt->rowCount();
		if($li_exists){	//found an id in the table so UPDATE
			$sql = "UPDATE hold SET note=?, PO_NO=?, ETA=?, dmr=?, missing_part = ? WHERE li_id = ?";
			$stmt = $dbh->prepare($sql);
			$stmt->execute([$hnote, $po_no, $eta, $dmr, $missing, $li]);
			$confirm = "Updated a row in the HOLD table.";
			array_push($check_string, $confirm);
		}
		else{	//didn't find any id so INSERT
			$sql2 = "INSERT INTO hold(status, li_id, date_hold, note, PO_NO, ETA, dmr, missing_part) VALUES (1, ?, ?, ?, ?, ?, ?, ?)";
			$stmt2 = $dbh->prepare($sql2);
			$stmt2->execute([$li, $day, $hnote, $po_no, $eta, $dmr, $missing]);
			$confirm = "Inserted a row into the HOLD table.";
			array_push($check_string, $confirm);
		}
		echo json_encode($check_string);
	}
	//error in connection 
	else{

	}
?>