<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../server.php";

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
	$userid = $_POST['user'];
	$sql = "SELECT RMA_number, submit_date FROM rma_service WHERE user_id = $userid ORDER BY submit_date DESC LIMIT $start_from, $records_per_page";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$output .= '<div class="rma_detail">';
		$output .= '<a href="/website_front/common_files/rma_history_detail.php?user_id='.$userid.'&rma='.$row["RMA_number"].'">';
		$output .= '<p>RMA: '.$row["RMA_number"].'<span class="date" style="float: right;">'.$row["submit_date"].'</span></p>';
		$output .=	'</a></div>';
	}

	$output .= '<div class="content pagination_scroll">';
	$total_records = $dbh->query("SELECT count(RMA_number) FROM rma_service WHERE user_id = $userid ORDER BY submit_date DESC")->fetchColumn();
	$total_pages = ceil($total_records/$records_per_page);
	for($i = 1; $i <= $total_pages; $i++){
		$output .= "<span class='pagination_link' id='".$i."'>".$i."</span>";
	}
	$output .= '</div>';
	echo $output;  
 ?> 