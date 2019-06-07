<?php
	require_once "../server.php";
	include "../header.php";
	session_start();

	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	if(isset($_GET['user_id']) && $_GET['user_id'] == $_SESSION['account']) {
		$userid = $_GET['user_id'];
	}
	
	else {
		header('Location: ../logout.php');
		return;
	}

	if (isset($_POST['update_password']) && isset($_POST['update_password_confirm']) && isset($_POST['update_address'])) {
		if($_POST['update_password'] == $_POST['update_password_confirm']){
			$hpwd = password_hash($_POST['update_password'], PASSWORD_DEFAULT);
			$sql = "UPDATE users SET password = :password, email = :email, phone = :phone WHERE user_id = :user_id";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':password' => $hpwd,
				':email' => $_POST['update_email'],
				':phone' => $_POST['update_phone'],
				':user_id' => $_GET['user_id']));
			$sql2 = "UPDATE address SET address = :address, city = :city, state = :state, zip = :zip WHERE user_id = :user_id";
			$stmt2 = $dbh->prepare($sql2);
			$stmt2->execute(array(
				':address' => $_POST['update_address'],
				':city' => $_POST['update_city'],
				':state' => $_POST['update_state'],
				':zip' => $_POST['update_zip'],
				':user_id' => $_GET['user_id']));
			$_SESSION['success'] = "User info and address updated";		
			header('Location: member_home.php?user_id='.$_GET['user_id']);
			return;
		}
		else{
			$_SESSION['error'] = "Passwords don't match. Please enter again";
			header('Location: member_info.php?user_id='.$_GET['user_id']);
			return;
		}
	}

	$sql = "SELECT * FROM users WHERE user_id = :user";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(':user' => $_GET['user_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row === false){
		$_SESSION['error'] = "Wrong user!!";
		header ('Location: ../index.php');
		return;
	}
	$company = htmlentities($row['company_name']);
	$user_id = $row['user_id'];
	$username = htmlentities($row['username']);
	$phone = htmlentities($row['phone']);
	$email = htmlentities($row['email']);


	$city = $address = $zip = '';

	$sql2 = "SELECT * FROM address WHERE user_id = :user";
	$stmt2 = $dbh->prepare($sql2);
	$stmt2->execute(array(':user' => $_GET['user_id']));
	$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	if ($row2) {
		$city= htmlentities($row2['city']);
		$address= htmlentities($row2['address']);
		$zip= htmlentities($row2['zip']);
	}
	else {
		$_SESSION['error'] = "Please update your address";
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
<!--<link rel="stylesheet" type="text/css" href="scss/sb-styles.scss" media="all">-->
<title>Scheidt & Bachmann</title>
</head>
<body>
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
				<form name="update_form" method="POST">
				    <div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="inputFirstName">Company Name</label>
					      <input type="text" class="form-control" id="inputFirstName" name="update_company_name" value="<?php if (isset($_SESSION['account'])) { echo $company; } ?>" required readonly> 
					    </div>
				  	</div>
				  	<div class="form-row">
					    <div class="form-group col-md-6">
					    	<label for="inputUsername">Username</label>
					      	<input type="text" class="form-control" id="inputUsername" name="update_username" value="<?php echo $username; ?>" required readonly>
					    </div>
					    <div class="form-group col-md-6">
					      <label for="inputPhone">Phone</label>
					      <input type="text" class="form-control" id="inputPhone" name="update_phone" placeholder="xxx-xxx-xxxx" pattern="\d{3}[\-]\d{3}[\-]\d{4}" value="<?php echo $phone; ?>">
					    </div>
					</div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputPassword">Password</label> <!--Password should have an Uppercase, a lowercase, a number and must be at least 6 characters long -->
				      <input type="password" class="form-control" id="inputPassword" name="update_password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPasswordConfirm">Confirm Password</label>
				      <input type="password" class="form-control" id="inputPasswordConfirm" name="update_password_confirm" required>
				    </div>
				  </div>

				  <div class="form-group">
				      <label for="inputAddress">Address</label>
				      <input type="text" class="form-control" id="inputAddress" name="update_address" placeholder="1234 Main St" value="<?php if($address) echo $address; ?>">
				  </div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="inputCity">City</label>
				      <input type="text" class="form-control" id="inputCity" name="update_city" value="<?php if($city) echo $city; ?>">
				    </div>
				    <div class="form-group col-md-4">
				      <label for="inputState">State</label>
				      <select id="inputState" class="form-control" name="update_state">
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
				      <label for="inputZip">Zip</label>
				      <input type="text" class="form-control" id="inputZip" name="update_zip" value="<?php if($zip) echo $zip; ?>"pattern="(\d{5}([\-]\d{4})?)" placeholder="xxxxx or xxxxx-xxxx">
				      <input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" >
				    </div>
				  </div>
				  <button type="submit" name="update_memberinfo" class="more-dark btn">Update</button>
				</form>
				<button type="submit" name="back_memberhome" class="more-dark btn more-back" onclick="window.location.href = 'member_home.php?user_id=<?php echo $_GET['user_id']; ?>';">Back</button>
			</div>
		</div>
	</main>
</div>
<?php include "../footer.php"; ?> 
</body>
</html>