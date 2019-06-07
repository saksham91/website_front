<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	if($_POST['date_1'] == ''){
		header('Location: by_rmadate.php');
		return;
	}

	$result = array();
	$records_per_page = 15;
	$page = '';
	$output = '';
	if(isset($_POST['page'])) {  
	    $page = $_POST['page'];  
	}  
	else {  
	   $page = 1;  
	}  
	$start_from = ($page - 1) * $records_per_page;

	if(isset($_POST['date_1']) && isset($_POST['date_2']) && $_POST['date_1'] == $_POST['date_2']){
		$from = $_POST['date_1'];
		$time_from = strtotime($from);
		$formatted_time_from = date('Y-m-d', $time_from);

		$sql = "SELECT RMA_number, user_id, number_items, submit_date FROM rma_service WHERE DATE(submit_date) = :d ORDER BY submit_date DESC LIMIT $start_from, $records_per_page";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':d' => $formatted_time_from));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$output .= '<div class="rma_detail">';
			$output .= '<a href="view_rmalist_detail.php?user_id='.$row["user_id"].'&rma='.$row["RMA_number"].'">';
			$output .= '<p>RMA: '.$row["RMA_number"].'<span class="rma_status" style="float: right;">'.$row["submit_date"].'</span></p>';
			$output .=	'</a></div>';
		}
		$output .= '<div class="content pagination_scroll">';
		$stmt = $dbh->prepare("SELECT count(RMA_number) FROM rma_service WHERE DATE(submit_date) = :d ORDER BY submit_date DESC");
		$stmt->execute(array(':d' => $formatted_time_from));
		$total_records = $stmt->fetch();
		$total_pages = ceil($total_records[0]/$records_per_page);
		for($i = 1; $i <= $total_pages; $i++){
			$output .= "<span class='pagination_link' id='".$i."'>".$i."</span>";
		}
		$output .= '</div>';
		echo $output;
	}

	else if(isset($_POST['date_1']) && isset($_POST['date_2']) && $_POST['date_1'] != $_POST['date_2']){
		$from = $_POST['date_1'];
		$time_from = strtotime($from);
		$formatted_time_from = date('Y-m-d', $time_from);

		$to = $_POST['date_2'];
		$time_to = strtotime($to);
		$formatted_time_to = date('Y-m-d', $time_to);

		$sql = "SELECT RMA_number, user_id, number_items, submit_date FROM rma_service WHERE DATE(submit_date) >= :d1 AND DATE(submit_date) <= :d2 ORDER BY submit_date DESC LIMIT $start_from, $records_per_page";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(
			':d1' => $formatted_time_from,
			':d2' => $formatted_time_to));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$output .= '<div class="rma_detail">';
			$output .= '<a href="view_rmalist_detail.php?user_id='.$row["user_id"].'&rma='.$row["RMA_number"].'">';
			$output .= '<p>RMA: '.$row["RMA_number"].'<span class="rma_status" style="float: right;">'.$row["submit_date"].'</span></p>';
			$output .=	'</a></div>';
		}

		$output .= '<div class="content pagination_scroll">';
		$stmt = $dbh->prepare("SELECT count(RMA_number) FROM rma_service WHERE DATE(submit_date) >= :d1 AND DATE(submit_date) <= :d2 ORDER BY submit_date DESC");
		$stmt->execute(array(
			':d1' => $formatted_time_from,
			':d2' => $formatted_time_to));
		$total_records = $stmt->fetch();
		$total_pages = ceil($total_records[0]/$records_per_page);
		for($i = 1; $i <= $total_pages; $i++){
			$output .= "<span class='pagination_link' id='".$i."'>".$i."</span>";
		}
		$output .= '</div>';
		echo $output;  		
	}

?>