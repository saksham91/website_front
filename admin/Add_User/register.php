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
</head>
<body>
	<div class="mp-pusher" id="mp-pusher">
	<div class="stage"> 
	<main class="main">
		<div class="container">
			<div class="content">
				<?php 
					if(isset($_SESSION['error'])) {
						echo('<p style="color:red">'.$_SESSION['error']."</p>\n");
						unset($_SESSION['error']);
					}
					if(isset($_SESSION['success'])) {
						echo('<p style="color:green">'.$_SESSION['success']."</p>\n");
						unset($_SESSION['success']);
					}
				?>
				<form name="regForm" action="regVerify.php" method="POST" novalidate>
				    <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputFirstName"><b>Company Name</b></label>
				      <input type="text" class="form-control" id="inputFirstName" name="register_company_name" value="<?php if (isset($_SESSION['company_name'])) { echo htmlentities($_SESSION['company_name']); } ?>" required> 
				    </div>
				  </div>
				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputUsername"><b>Username *</b></label>
				      <input type="text" class="form-control" id="inputUsername" name="register_username" required>
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPhone"><b>Phone</b></label>
				      <input type="text" class="form-control" id="inputPhone" name="register_phone" placeholder="xxx-xxx-xxxx" pattern="\d{3}[\-]\d{3}[\-]\d{4}" value="<?php if (isset($_SESSION['phone'])) { echo htmlentities($_SESSION['phone']); } ?>">
				    </div>
				  </div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputPassword"><b>Password *</b></label> <!--Password should have an Uppercase, a lowercase, a number and must be at least 6 characters long -->
				      <input type="password" class="form-control" id="inputPassword" name="register_password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPasswordConfirm"><b>Confirm Password *</b></label>
				      <input type="password" class="form-control" id="inputPasswordConfirm" name="register_password_confirm" required>
				    </div>
				  </div>

				  <div class="form-row">
					  <div class="form-group col-md-6">
					      <label for="inputAddress"><b>Address</b></label>
					      <input type="text" class="form-control" id="inputAddress" name="register_address" placeholder="1234 Main St" value="<?php if (isset($_SESSION['address'])) { echo htmlentities($_SESSION['address']); } ?>">
					  </div>
					  <div class="form-group col-md-6">
					  	<label for="email_id"><b>Email</b></label>
					  	<input type="text" class="form-control" id="email_id" name="register_email" value="<?php if(isset($_SESSION['email'])) {echo htmlentities($_SESSION['email']); } ?>">
					  </div>
					</div>


				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputCity"><b>City</b></label>
				      <input type="text" class="form-control" id="inputCity" name="register_city" value="<?php if (isset($_SESSION['city'])) { echo htmlentities($_SESSION['city']); } ?>">
				    </div>
				    <div class="form-group col-md-4">
				      <label for="inputState"><b>State</b></label>
				      <select id="inputState" class="form-control" name="register_state">
				        <option selected>Choose...</option>
				          <option value="AL">Alabama</option>
						  <option value="AK">Alaska</option>
						  <option value="AZ">Arizona</option>
						  <option value="AR">Arkansas</option>
						  <option value="CA">California</option>
						  <option value="CO">Colorado</option>
						  <option value="CT">Connecticut</option>
						  <option value="DE">Delaware</option>
						  <option value="DC">District Of Columbia</option>
						  <option value="FL">Florida</option>
						  <option value="GA">Georgia</option>
						  <option value="HI">Hawaii</option>
						  <option value="ID">Idaho</option>
						  <option value="IL">Illinois</option>
						  <option value="IN">Indiana</option>
						  <option value="IA">Iowa</option>
						  <option value="KS">Kansas</option>
						  <option value="KY">Kentucky</option>
						  <option value="LA">Louisiana</option>
						  <option value="ME">Maine</option>
						  <option value="MD">Maryland</option>
						  <option value="MA">Massachusetts</option>
						  <option value="MI">Michigan</option>
						  <option value="MN">Minnesota</option>
						  <option value="MS">Mississippi</option>
						  <option value="MO">Missouri</option>
						  <option value="MT">Montana</option>
						  <option value="NE">Nebraska</option>
						  <option value="NV">Nevada</option>
						  <option value="NH">New Hampshire</option>
						  <option value="NJ">New Jersey</option>
						  <option value="NM">New Mexico</option>
						  <option value="NY">New York</option>
						  <option value="NC">North Carolina</option>
						  <option value="ND">North Dakota</option>
						  <option value="OH">Ohio</option>
						  <option value="OK">Oklahoma</option>
						  <option value="OR">Oregon</option>
						  <option value="PA">Pennsylvania</option>
						  <option value="RI">Rhode Island</option>
						  <option value="SC">South Carolina</option>
						  <option value="SD">South Dakota</option>
						  <option value="TN">Tennessee</option>
						  <option value="TX">Texas</option>
						  <option value="UT">Utah</option>
						  <option value="VT">Vermont</option>
						  <option value="VA">Virginia</option>
						  <option value="WA">Washington</option>
						  <option value="WV">West Virginia</option>
						  <option value="WI">Wisconsin</option>
						  <option value="WY">Wyoming</option>
				      </select>
				    </div>
				    <div class="form-group col-md-2">
				      <label for="inputZip"><b>Zip</b></label>
				      <input type="text" class="form-control" id="inputZip" name="register_zip" value="<?php if (isset($_SESSION['zip'])) { echo htmlentities($_SESSION['zip']); } ?>"pattern="(\d{5}([\-]\d{4})?)" placeholder="xxxxx or xxxxx-xxxx">
				    </div>
				  </div>
				  <p><b>(*) Required Fields</b></p>
				  <div class="form-row"><button type="submit" name="register_submit" class="more-dark btn">Register</button></div>
				  <div class="form-row"><button type="submit" name="register_back" class="more-dark btn more-back">Back</button></div>
				</form>
			</div>
		</div>
		<div id="formerror" class="error"></div>
	</main>
</div>
</div>
<?php include "../../footer.php"; ?> 
</body>
</html>