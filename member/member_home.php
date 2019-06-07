<?php 
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}

	require_once "../server.php";
	//include "../header.php";
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
</head>
<body>
	<header class="header">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<span style="float: right; text-align: center;">
			<?php 
				if(isset($_SESSION['login_msg'])) {
					echo('<h3 class="msg_success"><b>'.$_SESSION['login_msg']."</b></h3>\n");
					unset($_SESSION['login_msg']);
				}
			?>
    	</span>
    </div>
  </header>
	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container">	
				<div class="content">
					<?php 
					if(isset($_SESSION['success'])) {
						echo('<h4 class="msg_success">'.$_SESSION['success']."</h4>\n");
						unset($_SESSION['success']);
						}
					?>
					<button type="submit" class="more-dark btn" onclick="window.location.href = '../common_files/new_rma.php?user_id=<?php echo $userid; ?>';">Add a New RMA</button><br>
					<button type="submit" class="more-dark btn" onclick="window.location.href = 'member_info.php?user_id=<?php echo $userid; ?>';">Edit Information</button><br>
					<button type="submit" class="more-dark btn" onclick="window.location.href = 'prev_rma/rma_history.php?user_id=<?php echo $userid; ?>';">Previous RMA's</button><br>
					<button type="submit" class="more-dark btn" onclick="window.location.href = '../logout.php';">Logout</button><br>
				</div>
			</div>
			<div class="container">
				<div class="content">
				</div>
			</div>
		</main>
	</div>
</body>
<?php
	include ("../footer.php");
?>
</html>

