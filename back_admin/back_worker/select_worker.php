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
	<script src="worker.js"></script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" style="margin: 30px;" >
			<div class="container">
				<div class="content">
					<div class="form-row align-items-center">
					    <div class="form-group col-md-3" style="margin-right: 100px;">
					      <label for="tech_name"><b>Choose Technician</b></label>
					      <select class="form-control" id="tech_name">
					      	<option value="">Select Technician..</option>
					      	<?php 
				    			$stmt = $dbh->query("SELECT tech_id, tech_name FROM technician");
				    			while($row = $stmt->fetch()){
				    				echo '<option value="'.$row['tech_id'].'">'.$row['tech_name'].'</option>';
				    			}
					    	?>
					      </select>
						</div>
						<div class="form-group col-md-3">
						  	<label for="date_from"><b>From: </b></label>
						  	<input type="text" class="form-control datepicker" id="date_from" onfocus="this.value=''" style="padding: 5px;" required>
						</div>
						<div class="form-group col-md-3">
						    <label for="date_to"><b>To: </b></label>
						    <input type="text" class="form-control datepicker" id="date_to" onfocus="this.value=''" style="padding: 5px;">
						</div>
				  	</div>
				  	<button type="button" class="btn more-dark" id="view_list_btn">View List</button>
				  	<div id="num_items" style="display: none"></div>
				</div>
			</div>
			<!-- Two tables used: both hidden initially and displayed based on user selection
					Table 1 for when a technician is selected and only the LI's he worked on should be displayed.
					Table 2 for when no worker is selected and all the items should be shown for the selected range	-->	 	
	 		<table class="table" id="li_list_table" style="display: none;">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Customer</th>
				    <th>Technician</th>
				    <th>Status</th>
				    <th>Date Arrived</th>
				    <th>Date Closed</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data">
	    		</tbody>
			</table>
			<table class="table" id="li_list_table2" style="display: none;">
				<thead class="thead-dark" >
				<tr>
					<th>RMA</th>
				    <th>LI Id</th>
				    <th>Device Name</th>
				    <th>P.No.</th>
				    <th>S.No.</th>
				    <th>Customer</th>
				    <th>Status</th>
				    <th>Date Arrived</th>
				    <th>Date Closed</th>
			    </tr>
			    </thead>
	    		<tbody id="li_list_data2">
	    		</tbody>
			</table>
		</main>
	</div> 
 </body>
 </html>

