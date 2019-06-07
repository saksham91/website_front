<?php 
	require_once "../../server.php";
	//include "../header.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	if(isset($_GET['user_id']) && $_GET['user_id'] == $_SESSION['account']) {
		$userid = $_GET['user_id'];
	}
	else {
		header('Location: ../../logout.php');
		return;
	}
?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
<script src="../../common_files/rma_history.js"></script>

<body>
	<header class="header">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<nav class="main-nav d-none d-xl-block ">
        <ul>
          <li><a href="../member_home.php?user_id=<?php echo $userid; ?>">Home</a></li>
          <li><a href="../../logout.php">Log out</a></li>
        </ul>
      </nav>
      <i id="trigger-menu" class="fa fa-bars menu-trigger d-xl-none"></i>
    </div>
  </header>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container">
				<div class="content" id="pagination_data">
				</div>
			</div>
		</main>
	</div>
</body>
</head>  