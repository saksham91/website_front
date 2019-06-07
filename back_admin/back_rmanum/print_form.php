<?php 
	session_start();
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../../server.php";
	
	if(isset($_GET['li'])){
		$li = $_GET['li'];

		$sql = "SELECT RMA_number, prob_desc, serial_number, device_number, device_name, service_name FROM line_item, device, service WHERE li_id = :li AND device.part_number = line_item.device_number AND service.service_id = line_item.service ";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':li' => $li));
		$row = $stmt->fetch();

		$sql2 = "SELECT company_name FROM line_item, rma_service, users WHERE li_id = ? AND line_item.RMA_number = rma_service.RMA_number AND rma_service.user_id = users.user_id";
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->execute([$li]);
		$row2 = $stmt2->fetch();

		$company = $row2['company_name'];
		$rma = $row['RMA_number'];
		$prob = $row['prob_desc'];
		$serial = $row['serial_number'];
		$dnumber = $row['device_number'];
		$device = $row['device_name'];
		$service = $row['service_name'];
	}

?>

<!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="../../css/sb-styles.css" media="all">
	<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css" media="all">
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
	<script src="../../js/modernizr.custom.js"></script> 
	<script src="../../js/classie.js"></script>
	<script src="../../js/tether.js"></script>
	<script src="../../js/jquery-ui.min.js"></script>
 </head>

 <body>
		<main class="main" >
				<div style="text-align: center;" >
					<h3><b>RMA's Repair Work Order</b></h3>
				</div>
			<div class="container"  style="border: solid 2px black;">
				<div class="content"> 
					<div class="form-row">
					    <div class="form-group col-md-2">
						    <p><b>Line Item</b>
						    <input type="text" class="form-control" id="li_id" value="<?php echo $li; ?>" ></p>
					    </div>

					    <div class="form-group col-md-2">
						    <p><b>RMA</b>
						    <input type="text" class="form-control" id="li_id" value="<?php echo $rma; ?>" ></p>
					    </div>
					    <div class="form-group col-md-2">
					    	<p><b>Service</b>
					    	<input type="text" class="form-control" id="serv_name" value="<?php echo $service; ?>" ></p> 
					    </div>
					    <div class="form-group col-md-2">
						    <p><b>Part Number</b>
						    <input type="text" class="form-control" id="part_num" value="<?php echo $dnumber; ?>"></p>
					    </div>
					    <div class="form-group col-md-4">
						    <p><b>Device Name</b>
						    <input type="text" class="form-control" id="device_name" value="<?php echo $device; ?>" ></p>
					    </div>
					</div>    
					<div class="form-row">
					    <div class="form-group col-md-2">  
						    <p><b>Serial Number</b>
						    <input type="text" class="form-control" id="serial_num" value="<?php echo $serial; ?>"></p> 
					    </div>
					    <div class="form-group col-md-4">
						    <p><b>Customer</b>
						    <input type="text" class="form-control" id="customer_name" value="<?php echo $company; ?>"></p>
					    </div>
					    <div class="form-group col-md-6">
						    <p><b>Problem Reported</b>
						    <input type="text" class="form-control" id="part_num" value="<?php echo $prob; ?>"></p>
					    </div>
					</div>
					<div class="form-row">
					    <div class="form-group col-md-12">
						    <label for="prob_found"><b>Problem Found</b></label>
						    <textarea class="form-control" id="prob_found" rows="6"></textarea>
					    </div>
					</div>
					<div class="form-row">
					    <div class="form-group col-md-12" >  
						    <label for="repair"><b>Repair Narrative</b></label>
						    <textarea class="form-control" id="repair" rows="6"></textarea>
					    </div>
					</div> 
					<div class="form-row">
						<div class="form-group col-md-3">
						  	<label for="date_arrive"><b>Date Arrived</b></label>
						  	<input type="text" class="form-control datepicker" id="date_arrive" onfocus="this.value=''" style="padding: 5px;" required>
						</div>
						<div class="form-group col-md-3">
						    <label for="tech"><b>Technician</b></label>
						    <input type="text" class="form-control" id="tech" style="padding: 5px;">
						</div>
						<div class="form-group col-md-3">
						    <label for="date_closed"><b>Date Closed</b></label>
						    <input type="text" class="form-control" id="date_closed" style="padding: 5px;">
						</div>
						<div class="form-group col-md-3">
						    <label for="labor_time"><b>Labor Time</b></label>
						    <input type="text" class="form-control" id="labor_time" style="padding: 5px;">
						</div>
					</div>
					<div class="misc_problems" style="margin-top: 20px;">
						<div style="width: 25%; display: inline-block;">
						    <p><input type="checkbox" name="function_test" id="function_test" value="1">
						    <b>Function Test </b></p>
						    <p><input type="checkbox" name="cleaning" id="cleaning" value="2">
						    <b>Cleaning Done </b></p>
						    <p><input type="checkbox" name="third_party" id="third_party" value="3">
						    <b>3rd Party Repair </b></p>
						    <p><input type="checkbox" name="adjustment" id="adjustment" value="4">
						    <b>Adjustment Done </b></p>
						    <p><input type="checkbox" name="PM_done" id="PM_done" value="5">
						    <b>PM Successfully Done </b></p>
						</div>
						<div style="width:66%; float:right; display: inline-block;">
							<label for="extra_note"><b>Note: </b></label>
							<textarea class="form-control" id="extra_note" rows="6"></textarea>
						</div>
					</div>
					<div class="form-row" style="margin-top: 20px;">
						<div class="form-group col-md-4">
						  	<label for="RP1"><b>Removed Part #</b></label>
						  	<input type="text" class="form-control" id="RP1" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="RS1"><b>Removed Serial #</b></label>
						  	<input type="text" class="form-control" id="RS1" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="IS1"><b>Installed Serial #</b></label>
						  	<input type="text" class="form-control" id="IS1" style="padding: 5px;">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
						  	<label for="RP2"><b>Removed Part #</b></label>
						  	<input type="text" class="form-control" id="RP1" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="RS2"><b>Removed Serial #</b></label>
						  	<input type="text" class="form-control" id="RS1" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="IS1"><b>Installed Serial #</b></label>
						  	<input type="text" class="form-control" id="IS2" style="padding: 5px;">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
						  	<label for="RP3"><b>Removed Part #</b></label>
						  	<input type="text" class="form-control" id="RP3" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="RS3"><b>Removed Serial #</b></label>
						  	<input type="text" class="form-control" id="RS3" style="padding: 5px;">
						</div>
						<div class="form-group col-md-4">
						  	<label for="IS3"><b>Installed Serial #</b></label>
						  	<input type="text" class="form-control" id="IS3" style="padding: 5px;">
						</div>
					</div>
				</div>
			</div>		
		 	<div class="container">
		 		<button type="button" onclick="window.print()" class="more-dark btn noprint" id="print_li" style="float: right;">Print</button>
		 		<button type="submit" class="more-dark btn more-back noprint" onclick="window.location.href = 'by_rmanum.php';">Back</button>
		 	</div>
		</main>
 </body>
 </html>

