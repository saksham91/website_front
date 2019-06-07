<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	include "../back_admin_header.php";
	if(isset($_GET['user_id'])) {
		$userid = $_GET['user_id'];
	}
	else {
		header('Location: ../../logout.php');
		return;
	}

?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="../../css/sb-styles.css" media="all">
<!-- <link rel="stylesheet" type="text/css" href="../scss/sb-styles.scss" media="all"> -->
<title>Scheidt & Bachmann</title>
<meta property="og:type" content="website" />
<meta property="og:title" content="Scheidt &amp; Bachmann" />
<meta property="og:url" content="https://www.scheidt-bachmann.de/en/" />
<meta property="og:site_name" content="Scheidt &amp; Bachmann" />
<meta property="og:image" content="../../img/sblogo.png" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
<meta name="twitter:creator" content="@ScheidtBachmann" />
<meta property="twitter:image" content="../../img/sblogo.png" />
<meta name="msapplication-square70x70logo" href="../../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="152x152" href="../../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="120x120" href="../../img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="76x76" href="../../img/apple-touch-icon.png">
<link rel="icon" sizes="192x192" href="../../img/apple-touch-icon.png">
<link rel="icon" sizes="128x128" href="../../img/apple-touch-icon.png">
<script src="../../js/jquery.min.js"></script>
<script src="../../js/jquery-ui.min.js"></script>
<script src="../../js/mlpushmenu.js"></script>
<script src="../../js/modernizr.custom.js"></script>  
<script src="../../js/tether.js"></script> 
<script src="../../js/popper.min.js"></script> 
<script src="../../js/bootstrap.bundle.min.js"></script> 
<script src="../../js/jquery.bootstrap-dropdown-hover.min.js"></script>
<script src="../../js/config.js"></script>

<body>
  <div class="mp-pusher" id="mp-pusher">
	<div class="stage"> </div>
	<main class="main">
		<div class="container">
			<div class="content" id="u_name">
				<?php 
					$sql = "SELECT company_name FROM users WHERE user_id = :uid";
					$stmt = $dbh->prepare($sql);
					$stmt->execute(array(':uid' => $_GET['user_id']));
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if($row){ ?>
						<h3><b>Company: <span><?php echo $row['company_name']; ?></span></b></h3>
					<?php }
					else{
						header('Location: by_rmadate.php');
						return;
					}
				?>
				<table class="table" id="prev_rma_table">
				<thead class="thead-dark" >
				<tr>
				    <th>LI Id</th>
				    <th>Device Type</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Problem Description</th>
				    <th>Status</th>
			    </tr>
			    </thead>
			    <tbody>
				<?php 
					$rma_num = $_GET['rma'];
					$user_id = $_GET['user_id'];
					$service_name = array(null, 'Warranty','APE', 'LCM', 'OOBF', 'Non-Warranty');
					$sql = "SELECT li_id, device_name, device_number, serial_number, service, prob_desc, status_name FROM device, line_item, status 
							WHERE RMA_number = :rma AND device.part_number = line_item.device_number AND status.status_id = line_item.status";
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
					 </tr>
				<?php } ?>
			    </tbody>
				</table>
			</div>
		</div>
	</main>
</div>
</body>
</head>
</html>