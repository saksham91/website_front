<?php 
	session_start();
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../server.php";
?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/sb-styles.css" media="all">
<link rel="stylesheet" type="text/css" href="../scss/sb-styles.scss" media="all">
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
</head>
<body>
	<header class="header noprint">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<nav class="main-nav d-none d-xl-block ">
        <ul>
          <li><a href="javascript:void(0)">Home</a></li>
          <li><a href="../logout.php">Log out</a></li>
        </ul>
      </nav>
      <i id="trigger-menu" class="fa fa-bars menu-trigger d-xl-none"></i>
    </div>
  </header>
	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main">
			<div class="container">
				<div class="content">
					<div class="form-row">
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'Add_User/register.php';">Add User</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'admin_table.php';">User Table</button>
						</div>
					 </div>
					 <div class="form-row">
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'service/admin_services.php';">User Services</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'Add_RMA/admin_addrma.php';">Add RMA</button>
						</div>
					 </div>
					 <div class="form-row">
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'device/view_device.php';">Devices Table</button>
						</div>
						<div class="col-md-6">
							<button type="submit" class="more-dark btn" onclick="window.location.href = 'view_rma/admin_rma.php';">View RMA</button>
						</div>
					 </div>
					 <hr style="border-top: 1px solid #8c8b8b;">
					  <div class="form-row">
						<div class="col-md-6">
							<button type="button" class="more-dark btn" onclick="window.location.href = 'Add_Internal/internal_register.php';">Add Internal User</button>
						</div>
					 </div>
				</div>
				<div class="content">
				<span>
					<?php 
						if(isset($_SESSION['register_error'])) {
							echo('<b><p style="color:red">'.$_SESSION['register_error']."</p></b>\n");
							unset($_SESSION['register_error']);
						}
						if(isset($_SESSION['register_success'])) {
							echo('<b><p style="color:green">'.$_SESSION['register_success']."</p></b>\n");
							unset($_SESSION['register_success']);
						}
					?>
				</span>
				</div>
			</div>
		</main>
	</div>

<?php
	include ("../footer.php");
?>
</body>
</html>

