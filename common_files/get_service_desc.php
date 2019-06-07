<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();

	if(isset($_GET['li'])){
		$li = $_GET['li'];
		$sql = 'SELECT prob_found, repair_done, date_arrived, date_closed FROM line_item WHERE li_id = :li';
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':li' => $li));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			array_push($result, $row);
			echo json_encode($result);
		}
		else{
			echo json_encode(array('message' => 'Could not find the information about the Line Item.. Please contact the administration.'));
		}
	}
	else{
		echo json_encode(array('message' => 'Problem encountered in the server..'));
	}
?>