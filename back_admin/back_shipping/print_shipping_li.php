<?php 
	require_once "../../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$rma = $li = $prob = $repair = $sno = $pno = $device = $service = $rec_date = $comp_date = '';

	if(isset($_GET['li'])){
		$li = $_GET['li'];
		$sql = "SELECT li_id, RMA_number, prob_desc, serial_number, device_number, device_name, service_name, repair_done, date_arrived, date_closed FROM line_item, device, service WHERE li_id = :line_id AND line_item.device_number = device.part_number AND line_item.service = service.service_id";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':line_id' => $li));
		$row = $stmt->fetch();
		$rma = $row['RMA_number'];
		$prob = $row['prob_desc'];
		$sno = $row['serial_number'];
		$pno = $row['device_number'];
		$device = $row['device_name'];
		$service = $row['service_name'];
		$repair = $row['repair_done'];
		$rec_date = $row['date_arrived'];
		$comp_date = $row['date_closed'];
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
<meta property="og:image" content="../img/sblogo.png" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
<meta name="twitter:creator" content="@ScheidtBachmann" />
<meta property="twitter:image" content="img/sblogo.png" />
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
</head>

<body>
	<div class="mp-pusher" id="mp-pusher">
		<main class="main">
			<div class="container">	
				<div class="content">
					<div>
						<button type="submit" class="more-dark btn more-back noprint" onclick="window.location.href = 'ship_date.php';">Back</button>
						<button type="submit" class="more-dark btn noprint" onclick="window.print()" style="float: right;">Print</button>
					</div>
					<hr noshade>
					<div class="div_padding">
						<?php 
							$sql = "SELECT company_name FROM RMA_service, users WHERE RMA_number =:rma AND rma_service.user_id = users.user_id";
							$stmt = $dbh->prepare($sql);
							$stmt->execute(array(':rma' => $rma));
							$row = $stmt->fetch();
						?>
						<h2><b>Shop Repair</b></h2>
						<p id="cust_name"><b>Customer: <?php echo $row['company_name']; ?></b></p>
					</div>
					<hr noshade>
					<div class="div_padding">
						<b><p id="part_num">Received Part No: <?php echo $pno; ?></p>
						<p id="rec_date" class="ship_right">Date Received: <?php echo $rec_date; ?></p>
						<p id="serial_num">Received Serial No: <?php echo $sno; ?></p>
						<p id="status" class="ship_right">Warranty Status: <?php echo $service; ?></p>
						<p id="rma_num">RMA No: <?php echo $rma; ?></p>
						<p id="dev_name">Device Name: <?php echo $device; ?></p></b>
					</div>
					<hr noshade>
					<div class="description div_padding">
						<p id="prob_found"><b>Problem Found:</b> <?php echo $prob; ?></p>
						<p id="rep_done"><b>Repair Narrative:</b> <?php echo $repair; ?></p>
					</div>
					<hr noshade>
					<div class="div_padding">
						<table class="table table-borderless">
							<tbody>
							<?php 
								$sql = "SELECT remove_p1, remove_s1, install_s1 FROM component_info WHERE li_id = :li";
								$stmt = $dbh->prepare($sql);
								$stmt->execute(array(':li' => $li));
								while($row = $stmt->fetch()){ ?>
									<tr>
										<td><b>Replaced Part:</b> <?php echo $row['remove_p1']; ?></td>
										<td><b>Replaced Serial:</b> <?php echo $row['remove_s1']; ?></td>
										<td><b>Replaced Part:</b> <?php echo $row['install_s1']; ?></td>
									</tr>
							<?php 	}
							?>
							</tbody>
						</table>
					</div>
					<hr noshade>
					<div class="div_padding">
						<?php 
							$sql = "SELECT repair FROM misc_repair, li_misc WHERE li_id = :li AND li_misc.misc_id = misc_repair.misc_id";
							$stmt = $dbh->prepare($sql);
							$stmt->execute(array(':li' => $li));
							while($row = $stmt->fetch()){ ?>
								<input type="checkbox" checked><span style="display: inline-block; width: 18%"><b><?php echo $row['repair']; ?></b></span>
						<?php 	}
						?>
					</div>
					<div class="div_padding" style="margin-top: 40px;">
						<p><b>Repair Completed:</b> <?php echo $comp_date; ?></p>
					</div>
					<hr noshade>
					<div class="div_padding" style="margin-top: 50px;">
						<label for="comments"><b>Special Comments:</b></label>
						<input id="comments" size="90%" style="height: 100px;">
					</div>
				</div>
			</div>
		</main>
	</div>
</body>