<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	if($_POST['dname'] && $_POST['dnum']){
		$dname = $_POST['dname'];
		$dnum = $_POST['dnum'];

		$check = $dbh->prepare("SELECT part_number FROM device WHERE part_number = ?");
		$check->execute([$dnum]);
		$exists = $check->fetchColumn();
		if($exists){
			header('HTTP/1.1 500 Internal Server Error');
        	header('Content-Type: application/json; charset=UTF-8');
        	die(json_encode(array('message' => 'Device already exists', 'code' => 1337)));
		}
		else{
			$sql = "INSERT INTO device(part_number, device_name) VALUES (:dnum, :dname)";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':dname' => $dname,
				':dnum' => $dnum));
		}
	}
	else {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Error while adding device!', 'code' => 1337)));
	}
?>