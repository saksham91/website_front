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
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
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
<script src="display_line_item.js"></script>

<body>
	<header class="header">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    </div>
  </header>
  <div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container" style="padding-top: 20px;">Date: <span id="display_date"></span></div>
			<div class="container" style="margin-top: 20px;">
				<table class="table table-hover" id="confirm_order_table">
					<thead class="thead-dark" >
					<tr>
					    <th>Item</th>
					    <th>Device Type</th>
					    <th>P.No.</th>
					    <th>S.No.</th>
					    <th>Service</th>
					    <th>Problem Description</th>
				    </tr>
				    </thead>
				    <tbody id="confirm_table_row">
				    </tbody>
				</table>	    		
			</div>
			<div class="container" style="padding-top: 10px;"><hr style="height:1px; border-width:1px; background-color:rgba(54,54,54,1)">
			</div>
			<div class="container">
				<span id="spinner_gif" style="display: none;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
				<button type="submit" class="more-dark btn" id="submit_rma" style="float: right">Submit RMA</button><br>
			</div>
		</main>
	</div>
</body>
</html>