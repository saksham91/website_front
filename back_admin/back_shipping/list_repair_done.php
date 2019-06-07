<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();

	if(isset($_GET['date'])){
		$dt = $_GET['date'];
		$sql = "SELECT RMA_number, li_id, serial_number, device_number, date_arrived FROM line_item WHERE status = 4 AND DATE(date_closed) = ?";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([$dt]);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			array_push($result, $row);
		}
		echo json_encode($result);
	}
	else{
		echo json_encode(array('message' => 'Could not fetch data from the database..'));
	}
?>