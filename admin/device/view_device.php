<?php 
	require_once "../../server.php";
	include "../admin_header.php";
	session_start();
	
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	$stmt = $dbh->query("SELECT * FROM device ORDER BY part_number");

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
	<script src="add_device.js"></script>
 </head>

<script>
	function myFunction() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("device_table");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those which don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) == 0) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}
</script>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div class="content">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for device number">
					<button type="button" id="add_device" class="btn more-dark btn" style="float: right">Add Device</button>
				</div>
				<div class="content">
					<span class="error_success" style="display: none"></span>
					<table class="table table-hover table-bordered table-striped" id="device_table">
						<thead>
							<tr class="service_row">
							    <th>Device Number</th>
							    <th>Device Name</th>
						    </tr>
					    </thead>
					    <tbody>
					    	<?php 
					    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					    			echo 
					    			'<tr class="service_row">
					    				<td>'.$row['part_number'].'</td>
					    				<td>'.$row['device_name'].'</td>
					    			</tr>';
					    		}
					    	?>
						</tbody>
					</table>
			 	</div>
			 	<div id="myModal" class="modal">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="form-row">
							<div class="col-sm-3">
								<label for="dev_number"><b>Device Number</b></label>
								<input type="text" class="form-control" id="dev_number" style="padding: 5px;" required>
							</div>
							<div class="col-sm-6">
								<label for="dev_name"><b>Device Name</b></label>
								<input type="text" class="form-control" id="dev_name" style="padding: 5px;" required>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-3">
								<button type="button" class="more-dark btn form-control" id="modal_btn1">ADD</button>
							</div>
							<div class="col-sm-3">
								<button type="button" class="more-dark btn form_control" id="modal_btn2">Cancel</button>	
							</div>
						</div>
					</div>
				</div>
			</div>	
		 	<div class="container">
		 		<button type="submit" class="more-dark btn more-back" onclick="window.location.href = '../admin_page.php';">Back</button><br>
		 	</div>
		</main>
	</div> 
 </body>
 </html>