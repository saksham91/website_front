<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();

	if(isset($_POST['serial'])){
		$serial = $_POST['serial'];

		$sql = "SELECT RMA_number, li_id, serial_number, device_number, device_name, service_name, status_name FROM line_item, device, service, status WHERE serial_number = :snum AND line_item.device_number = device.part_number AND line_item.service = service.service_id AND line_item.status = status.status_id ORDER BY li_id";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':snum' => $serial));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			//array_push($result, $row);
			$num = $row['RMA_number'];
			$user = $dbh->query("SELECT company_name FROM users, rma_service WHERE RMA_number = '$num' AND rma_service.user_id = users.user_id")->fetch();
			array_push($row, $user[0]);
			array_push($result, $row);
		}
		if (count($result) > 0){
			echo json_encode($result);
		}
		else{
			echo json_encode(array('message' => 'Serial number not in the database'));
		}
	}
	else{
		echo json_encode(array('message' => 'Cannot send data to the database..'));
	}
?>