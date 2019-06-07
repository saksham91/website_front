<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../../server.php";
	include "../admin_header.php";
?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
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
<script src="../../comp_name/populate_name/populate_name.js"></script>
<script src="user_service.js"></script>
</head>


<body>
	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container">	
				<div class="content">
					<div class="form-row">
					    <div class="form-group col-md-3">
					      <label for="company_name"><b>Select Company</b></label>
					      <select class="form-control" id="company_name"></select>
					    </div>
					    <div class="form-group col-md-3" style="margin-left: 250px;">
					    	<label for="service_1"><b>Choose Service</b></label>
					      	<select class="form-control" id="service_1"></select>
					    </div>
				  	</div>
				  	<div class="form-row">
				  		<div class="form-group col-md-3">
					  		<button type="button" class="btn more-dark" id="view_service">View Services</button>
					    </div>
					    <div class="form-group col-md-3" style="margin-left: 250px;">
					    	<button type="button" class="btn more-dark" id="add_service" >Add Service</button>
					    </div>
					    <div class="form-group col-md-3">
					    	<span class="error_success" style="display: none"></span>
					    </div>
					</div>
				</div>
				<div class="content">
					<div id="service_table" style="width: 40%">
						<table class="table table-hover" id="myTable" style="display: none">
							<thead class="thead-dark" >
								<tr>
								    <th>Service ID</th>
								    <th>Service Name</th>
								    <th></th>
							    </tr>
						    </thead>
						    <tbody id="user_service">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</main>
	</div>
</body>
</html>