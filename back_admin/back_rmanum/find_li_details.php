<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../../server.php";

	$result = array();
	if(isset($_GET['rma'])){
		$sql = "SELECT * FROM line_item, device, service WHERE line_item.RMA_number = :rma AND device.part_number = line_item.device_number AND service.service_id = line_item.service ORDER BY li_id";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':rma' => $_GET['rma']));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			array_push($result, $row);
		}
		if(count($result) > 0){
			echo json_encode($result);
		}
		else {
			echo json_encode(array('message' => 'Please check the RMA number again..'));
		}
	}
?>