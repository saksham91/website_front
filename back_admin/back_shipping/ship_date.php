<?php 
	require_once "../../server.php";
	session_start();
	include "../back_admin_header.php";
	
	if(!isset($_SESSION['account']) || $_SESSION['user_role'] != 2){
		die("You need to login to view this page");
	}
?>

<!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
	<script type="text/javascript" src="shipping_items.js"></script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div class="content">
					<div class="form-row align-items-center">
					    <div class="form-group col-md-3">
					    	<p><b>Select Date: </b><input type="text" class="form-control datepicker" id="select_date" autocomplete="off" onfocus="this.value=''" style="padding: 5px;" required></p>
					    </div>
				  	</div>
				  	<button type="button" class="btn more-dark" id="ship_items">View List Items</button>
					<span id="spinner_gif" style="display: none; margin-left: 40px;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
					<span class="error_success" style="display: none; margin-left: 40px;"></span>
				  	<button type="button" class="btn more-dark" id="change_multi_status" style="float: right">Change Status</button>
			 	</div>
			 	<table class="table" id="list_ship_table" style="display: none">
					<thead class="thead-light" >
					<tr>
					    <th>RMA No.</th>
					    <th>LI Id</th>
					    <th>P.No.</th>
					    <th>S.No.</th>
					    <th>Date Arrived</th>
					    <th></th>
					    <th></th>
				    </tr>
				    </thead>
		    		<tbody id="print_ship_row">
		    		</tbody>
				</table>
			</div>	
		</main>
	</div> 
 </body>
 </html>
