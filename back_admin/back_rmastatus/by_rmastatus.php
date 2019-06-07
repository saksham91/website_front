<?php 
	require_once "../../server.php";
	session_start();
	
	if(!isset($_SESSION['account']) || $_SESSION['user_role'] != 2){
		die("You need to login to view this page");
	}
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
	<script src="../../js/excelexportjs.js"></script>
	<script src="status_select.js"></script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" style="margin: 30px">
			<div class="container">
				<div class="content">
					<div class="form-row align-items-center">
					    <div class="col-md-3" style="margin-right: 90px;">
					      <label for="tech_name"><b>Choose Status</b></label>
					      <select class="form-control" id="stat_select">
					      	<?php 
				    			$stmt = $dbh->query("SELECT status_id, status_name FROM status");
				    			while($row = $stmt->fetch()){
				    				if($row['status_id'] != 2) {
				    					echo '<option value="'.$row['status_id'].'">'.$row['status_name'].'</option>';
				    				}
				    			}
					    	?>
					      </select>
						</div>
						<div class="col-md-3">
						  	<label for="date_from"><b>From: </b></label>
						  	<input type="text" class="form-control datepicker" id="date_from" onfocus="this.value=''" style="padding: 5px;" required>
						</div>
						<div class="col-md-3">
						    <label for="date_to"><b>To: </b></label>
						    <input type="text" class="form-control datepicker" id="date_to" onfocus="this.value=''" style="padding: 5px;">
						</div>
				  	</div>
				  	<div class="row">
				  		<div class="col-md-3">
				  			<button type="button" class="btn more-dark" id="view_list_btn">View List</button>
				  		</div>
				  		<div class="col-md-3">
				  			<button type="button" class="btn more-dark" id="export" style="float: right;">Export Data</button>
				  		</div>
				  	</div>
				</div>
			</div>
		  	<div id="num_items" style="display: none"></div>
		  	<!-- Table to show when status "In Transit" Selected  -->
	 		<table class="table" id="li_list_table1" style="display: none">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Customer</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data1">
	    		</tbody>
			</table>
			<!-- Table to show when status "In Repair" Selected  -->
			<table class="table" id="li_list_table2" style="display: none">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Customer</th>
				    <th>Date Arrived</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data2">
	    		</tbody>
			</table>
			<!-- Table to show when status "Repair Done" or "Shipped" Selected  -->
			<table class="table" id="li_list_table3" style="display: none">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Customer</th>
				    <th>Date Arrived</th>
				    <th>Date Closed</th>
				    <th>Technician</th>
				    <th>Problem</th>
				    <th>Repair</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data3">
	    		</tbody>
			</table>
			<!-- Table to show when status "Hold" Selected  -->
			<table class="table" id="li_list_table_hold" style="display: none">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Service</th>
				    <th>Customer</th>
				    <th>Date On Hold</th>
				    <th>PO NO</th>
				    <th>ETA</th>
				    <th>DMR</th>
				    <th>Missing Part</th>
				    <th>Note</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data_hold">
	    		</tbody>
			</table>
		</main>
	</div> 
 </body>
 </html>

