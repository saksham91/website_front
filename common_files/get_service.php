<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	require_once "../server.php";

	$value = array();

	$sql = "SELECT service_id, service_name FROM service, user_service WHERE service.service_id = user_service.sid AND user_service.uid = :user";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(':user' => $_GET['user_id']));
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($value, $row);
	}
	echo json_encode($value);
?>

