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
		$tech_id = $_POST['tech'];

		$sql = "SELECT RMA_number, li_id, serial_number, device_number, device_name, status_name, date_arrived, date_closed FROM line_item, device, status WHERE RMA_number IN 
				(SELECT RMA_number FROM rma_service WHERE DATE(submit_date) >= :d1 AND DATE(submit_date) <= :d2) AND device.part_number = line_item.device_number AND status.status_id = line_item.status AND line_item.technician = :tid ORDER BY li_id";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(
			':d1' => $date_from,
			':d2' => $date_to,
			':tid' => $tech_id));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$num = $row['RMA_number'];
			$user = $dbh->query("SELECT company_name FROM users, rma_service WHERE RMA_number = '$num' AND rma_service.user_id = users.user_id")->fetch();
			array_push($row, $user['company_name']);
			array_push($result, $row);
		}
		if (count($result) > 0){
			echo json_encode($result);
		}
		else{
			echo json_encode(array('message' => 'Could not fetch data from the database..'));
		}
	}
?>