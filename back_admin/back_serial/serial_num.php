<?php 
	require_once "../../server.php";
	session_start();
	
	if(!isset($_SESSION['account']) ){
		die("You need to login to view this page");
	}

	if($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 5){
		die("You are not authorized to view this page");
	}

	$role = $_SESSION['user_role'];
	include "../back_admin_header.php";
?>

<!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="../../css/sb-styles.css" media="all">
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
	<script src="../../js/jquery.tabledit.min.js"></script>
	<script src="../../js/modernizr.custom.js"></script> 
	<script src="../../js/classie.js"></script>
	<script src="../../js/tether.js"></script>
	<script src="search_serial.js"></script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div class="content">
					<input type="text" class="noprint" id="myInput" placeholder="Enter Serial number" style="margin-right: 20px;" autofocus>
					<button type="button" id="search_serial" class="btn more-dark btn noprint">Search</button>
					<div class="row" id="snum_detail" style="display: none">
						<div class="col-md-6">
							<h4 id="print_company"></h4>
						</div>
					</div>
					<table class="table" id="snum_table" style="display: none">
						<thead class="thead-light" >
						<tr>
							<th>RMA</th>
							<th>Customer</th>
						    <th>LI Id</th>
						    <th>Device Type</th>
						    <th>P.No.</th>
						    <th>S.No.</th>
						    <th>Service</th>
						    <th>Status</th>
					    </tr>
					    </thead>
			    		<tbody id="print_table_row">
			    		</tbody>
					</table>
			 	</div>
			</div>	
		 	<div class="container">
		 		<div class="row">
		 			<div class="col-md-6">
			 		<?php if($role == 2){ ?>
			 				<button type="submit" class="more-dark btn more-back noprint" onclick="window.location.href = '../back_admin_home.php?r=2';">Back</button><br>
			 		<?php }
			 			else if($role == 5){ ?>
			 				<button type="submit" class="more-dark btn more-back noprint" onclick="window.location.href = '../back_admin_receiving.php?r=5';">Back</button><br>
			 		<?php	} 
			 		?>
		 			</div>
		 			<div class="col-md-6">
		 				<button type="button" class="more-dark btn noprint" onclick="window.print()" style="float: right;">Print</button><br>
		 			</div>
		 		</div>
		 	</div>
		</main>
	</div> 
 </body>
 </html>

