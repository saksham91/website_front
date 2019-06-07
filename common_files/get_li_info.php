<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$result = array();
	class LineItem {
		private $li_id;
		private $device_name;
		private $device_number;
		private $serial_number;
		private $service;
		private $prob;
		private $status;

		function __construct($li_id, $device_name, $device_number, $serial_number, $service, $prob, $status){
			$this->id = $li_id;
			$this->name = $device_name;
			$this->pno = $device_number;
			$this->sno = $serial_number;
			$this->serv = $service;
			$this->problem = $prob;
			$this->stat = $status;
		}
	}

	if(isset($_GET['user_id']) && isset($_GET['rma'])){
		$rma_num = $_GET['rma'];
		$user_id = $_GET['user_id'];
		$sql = "SELECT li_id, device_name, device_number, serial_number, service, prob_desc, status_name FROM device, line_item, status 
				WHERE RMA_number = :rma AND device.part_number = line_item.device_number AND line_item.status = status.status_id";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':rma' => $rma_num));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$li_id = $row['li_id'];
			$device_name = $row['device_name'];
			$device_number = $row['device_number'];
			$serial_number = $row['serial_number'];
			$service = $row['service'];
			$prob = $row['prob_desc'];
			$status = $row['status_name'];
			$item = new LineItem($li_id, $device_name, $device_number, $serial_number, $service, $prob, $status);
			$result[] = $item;
		}
		echo json_encode($result);
	}
?>