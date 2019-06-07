<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	require_once "../server.php";

	$sql = "SELECT device_name FROM device WHERE part_number = :part";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(':part' => $_GET['part_number']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row){
		echo json_encode($row);
	}
?>