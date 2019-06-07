<?php 
	require_once "../server.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
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
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/sb-styles.css" media="all">
<!-- <link rel="stylesheet" type="text/css" href="../scss/sb-styles.scss" media="all"> -->
<title>Scheidt & Bachmann</title>
<meta property="og:type" content="website" />
<meta property="og:title" content="Scheidt &amp; Bachmann" />
<meta property="og:url" content="https://www.scheidt-bachmann.de/en/" />
<meta property="og:site_name" content="Scheidt &amp; Bachmann" />
<meta property="og:image" content="img/sblogo.png" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
<meta name="twitter:creator" content="@ScheidtBachmann" />
<meta property="twitter:image" content="img/sblogo.png" />
<meta name="msapplication-square70x70logo" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon.png">
<link rel="icon" sizes="192x192" href="img/apple-touch-icon.png">
<link rel="icon" sizes="128x128" href="img/apple-touch-icon.png">

<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/mlpushmenu.js"></script>
<script src="../js/modernizr.custom.js"></script>  
<script src="../js/tether.js"></script> 
<script src="../js/popper.min.js"></script> 
<script src="../js/bootstrap.bundle.min.js"></script> 
<script src="../js/jquery.bootstrap-dropdown-hover.min.js"></script>
<script src="../js/config.js"></script>
<script src="print_order.js"></script>
<style>
@media print{
   .noprint{
       display:none;
   }
}
</style>

<body>
	<header class="header noprint">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<nav class="main-nav d-none d-xl-block ">
        <ul>
        <?php 
        	if($_SESSION['account'] == $_GET['user_id']) { ?>
          		<li><a href="../member/member_home.php?user_id=<?php echo $userid; ?>">Home</a></li>
         		<li><a href="../logout.php">Log out</a></li>
         	<?php }
         	else { ?>
         		<li><a href="../admin/admin_page.php">Home</a></li>
         		<li><a href="../logout.php">Log out</a></li>
         	<?php } ?>
        </ul>
      </nav>
      <i id="trigger-menu" class="fa fa-bars menu-trigger d-xl-none"></i>
    </div>
  </header>
  <div class="mp-pusher" id="mp-pusher">
		<div class="stage noprint"> </div>
	<main class="main">
		<div class="container">
			<div class="row">
				<div class="content col-md-6">
					<h4 id="print_rma"><b>RMA Number: </b></h4>
					<h4 id="print_date"><b>DATE: </b></h4>
				</div>
				<div class="content col-md-6">
					<h4 id="print_quantity"><b>Number of Items: </b></h4>
				</div>
			</div>
			<div class="row" style="margin-top: -60px;">
				<div class="content col-md-8">
					<address id="print_address"></address>
				</div>
			</div>
		</div>	
		<div class="container">
			<table class="table" id="print_order_table">
				<thead class="thead-light" >
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
			    <tbody id="print_table_row">
			    </tbody>
			</table>
		</div>
		<div class="container">
			<button type="button" onclick="window.print()" class="more-dark btn noprint" id="print_rma" style="float: right;">Print Order</button>
		</div>
	</main>
</div>
</body>
</html>