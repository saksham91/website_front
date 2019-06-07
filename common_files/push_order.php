<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	sleep(2);
	date_default_timezone_set('America/New_York');
	$mysqltime = date("Y-m-d H:i:s");

	if(isset($_POST['order']) && isset($_POST['user'])){
		$data = $_POST['order'];
		$user = json_decode($_POST['user']);
		$num_items = json_decode($_POST['items']);
	
		$sql = "INSERT INTO rma_service (user_id, submit_date, number_items) VALUES (:user, :sub_date, :items)";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(
			':user' => $user,
			':sub_date' => $mysqltime,
			':items' => $num_items
		));
		
		if($stmt){
			$lastID = $dbh->lastInsertId();
			for($i = 0; $i < $num_items; $i++){
				$sql2 = "INSERT INTO line_item (RMA_number, prob_desc, serial_number, device_number, service, status) VALUES (:rma, :prob_desc, :snum, :pnum, :service, :status)";
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->execute(array(
				':rma' => $lastID,
				':prob_desc' => $data[$i]['prob_desc'],
				':snum' => $data[$i]['serial'],
				':pnum' => $data[$i]['part'],
				':service' => $data[$i]['service'],
				':status' => 1
				));
			}
			echo json_encode($lastID);
		}
		else {
			echo json_encode("Information not inserted into the database!!");
		}
	}

?>

