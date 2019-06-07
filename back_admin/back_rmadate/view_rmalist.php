<?php 
	session_start();
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../../server.php";
  include "../back_admin_header.php";
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
<script src="view_rmalist.js"></script>
</head>

<body>
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
</html>

