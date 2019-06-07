<?php 
	session_start();
	include("header.php");
?>

<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all">
<link rel="stylesheet" type="text/css" href="css/sb-styles.css" media="all">
<!-- <link rel="stylesheet" type="text/css" href="scss/sb-styles.scss" media="all"> -->
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
</head>
<body>
	<div class="mp-pusher" id="mp-pusher">
		<div class="stage" alt=""> </div>
		<main class="main">
			<div class="container">
				<div class="content">
					<form action="login.php" method="POST">
					  <div class="form-row">
					  	<div class="form-group col-md-6">
						    <label for="login_user"><strong>Username</strong></label>
						    <input type="text" name="username" class="form-control" id="login_user"  placeholder="Enter your username" >
					  	</div>
					  </div>	
					  <div class="form-row">
					  	<div class="form-group col-md-6">
						    <label for="login_password"><strong>Password</strong></label>
						    <input type="password" name="password" class="form-control" id="login_password" placeholder="Enter your password">
					  	</div>
					  </div>		
					  <button type="submit" class="more-dark btn">Login</button>
					  <?php 
						if(isset($_SESSION['error'])) {
							echo('<p style="color:red">'.$_SESSION['error']."</p>\n");
							//echo $_SESSION['init'];
							unset($_SESSION['error']);
						}
						if(isset($_SESSION['success'])) {
							echo('<p style="color:green">'.$_SESSION['success']."</p>\n");
							unset($_SESSION['success']);
						}
					 ?>
					</form>	
				</div>
				<a href="forget_pwd/forget_pwd.php" style= "color:red";>Forgot password?</a>
			</div>
		</main>
	</div>
<?php
	include ("footer.php");
?>
</body>

</html>