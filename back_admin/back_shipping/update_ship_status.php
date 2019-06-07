<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	if(isset($_POST['shipping_items'])){
		$items = $_POST['shipping_items'];
		//print_r($items);

		for($i = 0; $i < count($items); $i++){
			$sql = "UPDATE line_item SET status = 5 WHERE li_id = :line_item";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(':line_item' => $items[$i]));
		} 

		echo json_encode(array('message' => 'Status successfully changed'));

	}
	else{
		echo json_encode(array('message' => 'Could not fetch data from the database..'));
	}
?>