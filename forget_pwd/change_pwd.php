<?php 
	require_once "../server.php";
	session_start();

	if(isset($_POST['name']) && isset($_POST['pass'])){
		$name = $_POST['name'];
		$pwd = $_POST['pass'];
		$stmt = $dbh->prepare("SELECT 1 FROM users WHERE username = ?");
		$stmt->execute([$name]);
		$user_exists = $stmt->fetchColumn();
 		if($user_exists){
 			$safe_pwd = password_hash($pwd, PASSWORD_DEFAULT);
 			$sql = "UPDATE users SET password = :pass WHERE username = :user";
 			$stmt = $dbh->prepare($sql);
 			$stmt->execute(array(
 				':pass' => $safe_pwd,
 				':user' => $name));
 			echo json_encode(array('success_message' => 'Password Updated'));
 		}
 		else{
 			echo json_encode(array('failure_message' => 'Username not found '));
 		}
	}
	else{
		echo json_encode(array('failure_message' => 'Could not connect to the database..'));
	}
?>