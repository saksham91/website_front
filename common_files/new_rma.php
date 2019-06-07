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
<meta property="og:image" content="img/sblogo.png" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
<meta name="twitter:creator" content="@ScheidtBachmann" />
<meta property="twitter:image" content="img/sblogo.png" />
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
<script src="add_line_item.js"></script> 

<style type="text/css">
	label {
		width: 40em;
	}
	.msg_error{
		font-family: Georgia, serif;
		font-size: 24px;
		letter-spacing: 0.4px;
		word-spacing: -1px;
		font-weight: bold;
		text-decoration: none;
		font-style: normal;
		font-variant: small-caps;
		text-transform: none;
	}
</style>


<body>
	<header class="header">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<span id="display_li_add" style="float: right; text-align: center;"></span>
    </div>
  </header>
  <div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container" style="padding-top: 10px;">
				<button type="submit" class="btn more-dark" id="add_li">Add a Line Item</button>
        		<span id="error_display" class="msg_error" style="margin-left: 5em;"></span>
				<button type="submit" class="btn more-dark" id="check" style="float: right;">Check order</button>
			</div>
			<div class="container" style="padding-top: 10px;">
				<div class="accordion" id="li_add_accordion">
					
				</div>
			</div>
		</main>
	</div>

</body>
</html>