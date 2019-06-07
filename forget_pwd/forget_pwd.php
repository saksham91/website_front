<?php 
	session_start();
	include("../header.php");
?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="../css/sb-styles.css" media="all">
<!-- <link rel="stylesheet" type="text/css" href="scss/sb-styles.scss" media="all"> -->
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
<script src="../js/jquery.tabledit.min.js"></script>
<script src="../js/modernizr.custom.js"></script> 
<script src="../js/classie.js"></script>
<script src="../js/tether.js"></script>
<script src="change_pwd.js"></script>
</head>
<body>
	<div class="mp-pusher" id="mp-pusher">
		<div class="stage" alt=""> </div>
		<main class="main">
			<div class="container">
				<div class="content">
					<div class="form-row">
					  	<div class="form-group col-md-6">
						    <input type="text" name="username" class="form-control" id="user_confirm"  placeholder="Enter your username" required>
					  	</div>
					  	<div class="form-group col-md-6">
						    <p id="user_error" class="pwd_page_error"></p>
					  	</div>
					</div>
					<div class="form-row">
					  	<div class="form-group col-md-6">
						    <input type="password" name="new_pwd" class="form-control" id="new_password"  placeholder="Enter a new password" title="Minimum length: 6. Should contain at least one digit, one capital alphabet and one small alphabet" required>
					  	</div>
					  	<div class="form-group col-md-6">
						    <p id="new_pwd_error" class="pwd_page_error"></p>
					  	</div>
					</div>
					<div class="form-row">
					  	<div class="form-group col-md-6">
						    <input type="password" name="confirm_pwd" class="form-control" id="confirm_password"  placeholder="Confirm password" required>
					  	</div>
					  	<div class="form-group col-md-6">
						    <p id="pwd_confirm_error" class="pwd_page_error"></p>
					  	</div>
					</div>
					<div class="form-row">
					  	<div class="form-group col-md-6">
					  		<button id="fpwd_confirm" class="more-dark btn" style="float: right;">Renew Password</button>
					  		<button id="back_login" class="more-dark btn more-back" onclick="window.location.href = '../index.php';">Back</button>
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<p><strong>* All fields are required</strong></p>
						<span class="error_success" style="display: none; float: right;"></span>
					</div>
				</div>
				<div class="form-row">
					<p><strong>** Password must have:<br>Minimum 6 characters<br>At least 1 lowercase alphabet<br>At least one uppercase alphabet<br>At least one digit</strong></p>
				</div>
			</div>
		</main>
	</div>
<?php
	include ("../footer.php");
?>
</body>

</html>