<?php
	require_once "../../server.php";
	include "../admin_header.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
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
<!--<link rel="stylesheet" type="text/css" href="scss/sb-styles.scss" media="all">-->
<title>Scheidt & Bachmann</title>
<script src="../../js/jquery.min.js"></script>
<script src="../../js/mlpushmenu.js"></script>
<script src="../../js/modernizr.custom.js"></script>  
<script src="../../js/tether.js"></script> 
<script src="../../js/popper.min.js"></script> 
<script src="../../js/bootstrap.bundle.min.js"></script> 
<script src="../../js/jquery.bootstrap-dropdown-hover.min.js"></script>
<script src="../../js/config.js"></script>
<script src="register_verify.js"></script>
</head>
<body>
	<div class="mp-pusher" id="mp-pusher">
	<div class="stage"> 
	<main class="main">
		<div class="container">
			<div class="content">
				<div class="form-row error_success" style="display: none;">						
				</div>
			    <div class="form-row">
			    	<div class="form-group col-md-4">
			      		<label for="user_role"><b>Select Role</b></label>
				      	<select class="form-control" id="user_role">
				      		<?php 
				      			$sql = "SELECT access_id, user FROM access_table";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								while($row = $stmt->fetch()){ 
									if($row['user'] != "Customer"){ ?>
										<option value="<?php echo $row['access_id']; ?>"><?php echo $row['user']; ?></option>
								<?php }
								}	
				      		?>
				      	</select> 
			    	</div>
			    	<div class="form-group col-md-4">
				      <label for="comp_name"><b>Company Name</b></label>
				      <input type="text" class="form-control" id="comp_name" name="register_company_name" required> 
				    </div>
			  	</div>
			  	<div class="form-row">
			    	<div class="form-group col-md-4">
				      	<label for="username"><b>Username</b></label>
				      	<input type="text" class="form-control" id="username" name="register_username" required>
				    </div>
				    <div class="form-group col-md-4">
				      	<label for="input_phone"><b>Phone</b></label>
				      	<input type="text" class="form-control" id="input_phone" name="register_phone" placeholder="xxx-xxx-xxxx" pattern="\d{3}[\-]\d{3}[\-]\d{4}">
				    </div>
			  	</div>

				<div class="form-row">
				    <div class="form-group col-md-4">
				    	<label for="input_password"><b>Password</b></label> <!--Password should have an Uppercase, a lowercase, a number and must be at least 6 characters long -->
				      	<input type="password" class="form-control" id="input_password" name="register_password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
				    </div>
				    <div class="form-group col-md-4">
				      	<label for="input_password_confirm"><b>Confirm Password</b></label>
				      	<input type="password" class="form-control" id="input_password_confirm" name="register_password_confirm" required>
				    </div>
				</div>

				<div class="form-row">
				 	<div class="form-group col-md-4">
				    	<button type="button" id="internal_back" class="more-dark btn more-back" onclick="window.location.href = '../admin_page.php';">Back</button>
				    </div>
				    <div class="form-group col-md-4">
				 		<button type="button" id="internal_submit" class="more-dark btn" style="float: right;">Register</button>
				    </div>
				</div>
			</div>
		</div>
		<div id="formerror" class="error"></div>
	</main>
</div>
</div>
<?php include "../../footer.php"; ?> 
</body>
</html>