<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();
	$sql = "SELECT service_id, service_name FROM service, user_service WHERE uid = :user AND service.service_id = user_service.sid";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(':user' => $_GET['user_id'])); 
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		array_push($result, $row);
	}
	if(count($result) <= 5){
		echo json_encode($result);
	}
	else {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Number of services more than available services!', 'code' => 1337)));
	}
?>