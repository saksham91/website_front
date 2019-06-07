<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	//include "../header.php";
	if(isset($_GET['user_id'])) {
		$userid = $_GET['user_id'];
	}
	else {
		header('Location: ../logout.php');
		return;
	}

?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/sb-styles.css" media="all">
<!-- <link rel="stylesheet" type="text/css" href="../scss/sb-styles.scss" media="all"> -->
<title>Scheidt & Bachmann</title>
<meta property="og:type" content="website" />
<meta property="og:title" content="Scheidt &amp; Bachmann" />
<meta property="og:url" content="https://www.scheidt-bachmann.de/en/" />
<meta property="og:site_name" content="Scheidt &amp; Bachmann" />
<meta property="og:image" content="../img/sblogo.png" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
<meta name="twitter:creator" content="@ScheidtBachmann" />
<meta property="twitter:image" content="../img/sblogo.png" />
<meta name="msapplication-square70x70logo" href="../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="152x152" href="../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="120x120" href="../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="76x76" href="../img/apple-touch-icon.png">
<link rel="icon" sizes="192x192" href="../img/apple-touch-icon.png">
<link rel="icon" sizes="128x128" href="../img/apple-touch-icon.png">

<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/mlpushmenu.js"></script>
<script src="../js/modernizr.custom.js"></script>  
<script src="../js/tether.js"></script> 
<script src="../js/popper.min.js"></script> 
<script src="../js/bootstrap.bundle.min.js"></script> 
<script src="../js/jquery.bootstrap-dropdown-hover.min.js"></script>
<script src="../js/config.js"></script>
<script src="view_service_desc.js"></script>

<body>
	<header class="header">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<nav class="main-nav d-none d-xl-block ">
        <ul>
        <?php 
        	if($_SESSION['account'] == "FRONTEND_ADM") { ?>
          		<li><a href="../admin/admin_page.php">Home</a></li>
         		<li><a href="../logout.php">Log out</a></li>
         	<?php }
         	else if($_SESSION['account'] == "BACKEND_ADM"){ ?>
         		<li><a href="../back_admin/back_admin_home.php?r=2">Home</a></li>
         		<li><a href="../logout.php">Log out</a></li>
         	<?php } 
        ?>
        </ul>
      </nav>
      <i id="trigger-menu" class="fa fa-bars menu-trigger d-xl-none"></i>
    </div>
  </header>
  <div class="mp-pusher" id="mp-pusher">
	<div class="stage"> </div>
	<main class="main">
		<div class="container">
			<div class="content">
				<table class="table" id="prev_rma_table">
				<thead class="thead-dark" >
				<tr>
				    <th>LI Id</th>
				    <th>Device Type</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Problem Description</th>
				    <th style="width: 8em">Status</th>
				    <th>Details</th>
			    </tr>
			    </thead>
			    <tbody id="disp_table">
				<?php 
					$rma_num = $_GET['rma'];
					$user_id = $_GET['user_id'];
					$service_name = array(null, 'Warranty','APE', 'LCM', 'OOBF', 'Non-Warranty');
					$sql = "SELECT li_id, device_name, device_number, serial_number, service, prob_desc, status_name FROM device, line_item, status 
							WHERE RMA_number = :rma AND device.part_number = line_item.device_number AND line_item.status = status.status_id";
					$stmt = $dbh->prepare($sql);
					$stmt->execute(array(':rma' => $rma_num));
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
					<tr>
			 			<td><?php echo $row['li_id']; ?></td>
			 			<td><?php echo $row['device_name']; ?></td>
			 			<td><?php echo $row['device_number']; ?></td>
			 			<td><?php echo $row['serial_number']; ?></td>
			 			<td><?php echo $service_name[(int)$row['service']]; ?></td>
			 			<td><?php echo $row['prob_desc']; ?></td>
			 			<td><?php echo $row['status_name']; ?></td>
			 			<td><button type="button" class="btn btn-outline-dark edit_li view_btn" id="<?php echo $row['li_id']; ?>">View</button></td>
					 </tr>
				<?php } ?>
			    </tbody>
				</table>
			</div>
			<div id="myModal" class="modal">
				<!-- Modal content -->
				<div class="modal-content">
					<div class="form-row">
						<div class="col-sm-6">
							<label for="prob_found"><b>Problem Found</b></label>
							<textarea rows="5" cols="40" id="prob_found" class="form-control text_in_box" readonly></textarea>
						</div>
						<div class="col-sm-3">
							<label for="date_arrived"><b>Date Arrived</b></label>
							<input type="text" id="date_arrived" class="form-control text_in_box" readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="col-sm-6">
							<label for="rep_done"><b>Repair Done</b></label>
							<textarea rows="5" cols="40" id="rep_done" class="form-control text_in_box" readonly></textarea>
						</div>
						<div class="col-sm-3">
							<label for="date_closed"><b>Date Closed</b></label>
							<input type="text" id="date_closed" class="form-control text_in_box" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
</body>
</head>
</html>