<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	if($_POST['user_id'] && $_POST['service']){
		$sql = "DELETE FROM user_service WHERE uid = :user AND sid = :service";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(
			':user' => $_POST['user_id'],
			':service' => $_POST['service'])); 
	}
	else {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Error while adding service!', 'code' => 1337)));
	}
?>