<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	require_once "../../server.php";
	$data = array();

	$sql = "SELECT user_id, company_name, perm_code FROM users";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array());
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($data, $row);
	}
	echo json_encode($data);
?>