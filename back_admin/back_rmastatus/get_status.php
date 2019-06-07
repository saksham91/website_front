<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();

	if(isset($_POST['from'])){
		$date_from = $_POST['from'];
		$date_to = $_POST['to'];
		$status = $_POST['status'];

		/* 
			status mapping
			{1: In Transit}
			{3: In Repair}
			{4: Repair Done}
			{5: Shipped}
			{6: Hold}
		*/

		//Have to check separately because for "In Transit" status, there will be no info about technician. 
		//Hence the SELECT statement needs to be altered accordingly.
		if($status == 1){
			$sql = "SELECT * FROM line_item, device, service WHERE RMA_number IN 
					(SELECT RMA_number FROM rma_service WHERE DATE(submit_date) >= :d1 AND DATE(submit_date) <= :d2) AND line_item.status = :stat AND device.part_number = line_item.device_number AND line_item.service = service.service_id ORDER BY li_id";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':d1' => $date_from,
				':d2' => $date_to,
				':stat' => $status));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				//array_push($result, $row);
				$num = $row['RMA_number'];
				$user = $dbh->query("SELECT company_name FROM users, rma_service WHERE RMA_number = '$num' AND rma_service.user_id = users.user_id")->fetch();
				array_push($row, $user['company_name']);
				array_push($result, $row);
			}
		}
		else if($status == 6){
			$sql = "SELECT * FROM hold WHERE hold.status = 1 AND DATE(date_hold) >= :d1 AND DATE(date_hold) <= :d2";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':d1' => $date_from,
				':d2' => $date_to));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$line_id = $row['li_id'];
				$sql2 = "SELECT RMA_number, serial_number, device_number, device_name, service_name FROM line_item, device, service WHERE line_item.li_id ='$line_id'AND device.part_number = line_item.device_number AND line_item.service = service.service_id";
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->execute();
				$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$rma_num = $row2['RMA_number'];
				$user = $dbh->query("SELECT company_name FROM rma_service, users WHERE RMA_number = '$rma_num' AND rma_service.user_id = users.user_id")->fetch();
				array_push($row, $row2, $user['company_name']);
				array_push($result, $row);
			}
		}
		else{
			$sql = "SELECT * FROM line_item, device, technician, service WHERE RMA_number IN 
					(SELECT RMA_number FROM rma_service WHERE DATE(submit_date) >= :d1 AND DATE(submit_date) <= :d2) AND line_item.status = :stat AND device.part_number = line_item.device_number AND line_item.technician = technician.tech_id AND line_item.service = service.service_id ORDER BY li_id";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':d1' => $date_from,
				':d2' => $date_to,
				':stat' => $status));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				//array_push($result, $row);
				$num = $row['RMA_number'];
				$user = $dbh->query("SELECT company_name FROM users, rma_service WHERE RMA_number = '$num' AND rma_service.user_id = users.user_id")->fetch();
				array_push($row, $user['company_name']);
				array_push($result, $row);
			}
		}
		if (count($result) > 0){
			echo json_encode($result);
		}
		else{
			echo json_encode(array('message' => 'Could not fetch data from the database..'));
		}
	}
?>