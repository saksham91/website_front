<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();

	if(isset($_GET['rma'])){
		$rma_num = $_GET['rma'];
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
		array_push($result, $rma_num, $user_id);
		$sql = "SELECT submit_date, number_items FROM rma_service WHERE RMA_number = :rma";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':rma' => $rma_num));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row){
			$date = $row['submit_date'];
			$items = $row['number_items'];
			array_push($result, $date, $items);
		}
	}
	if(count($result) < 3){
		echo json_encode(array('message' => 'Please check the RMA number again..'));
	}
	else{
		echo json_encode($result);
	}
?>