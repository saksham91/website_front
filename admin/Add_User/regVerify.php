<?php 
	require_once "../../server.php";
	//include "register.php";
	if (!isset($_SESSION))
  	{
    	session_start();
  	}
	
	if(isset($_POST['register_back'])){
		$_SESSION['company_name'] = $_SESSION['username'] = $_SESSION['email'] = $_SESSION['phone'] = $_SESSION['address'] = $_SESSION['city'] = $_SESSION['zip'] = '';
		header ('Location: ../admin_page.php');
		return;
	}


	if(isset($_POST['register_company_name']) && isset($_POST['register_username']) && isset($_POST['register_password'])) {
		$company_name = strip_tags(trim($_POST['register_company_name']));
		$username = $_POST['register_username'];
		$phone = $_POST['register_phone'];
		$password = $_POST['register_password'];
		$password_confirm = $_POST['register_password_confirm'];
		$address = $_POST['register_address'];
		$email = $_POST['register_email'];
		$city = strip_tags(trim($_POST['register_city']));
		$state = $_POST['register_state'];
		$zip = $_POST['register_zip'];

		$_SESSION['company_name'] = $company_name;
		$_SESSION['username'] = $username;
		$_SESSION['phone'] = $phone;
		$_SESSION['address'] = $address;
		$_SESSION['email'] = $email;
		$_SESSION['city'] = $city;
		$_SESSION['zip'] = $zip;


		//Form validation
		if(empty($company_name)) { 
			$_SESSION['error'] = "Company name is required";
			header('Location: register.php');
			return; 
		}
		if(empty($username)) { 
			$_SESSION['error'] = "Username is required";
			header('Location: register.php');
			return; 
		}
		if(empty($password)) { 
			$_SESSION['error'] = "Password is required";
			header('Location: register.php');
			return;
		}
		if($password !== $password_confirm) { 
			$_SESSION['error'] = "Passwords don't match. Please type again..";
			header('Location: register.php');
			return;
		}
		if( is_null($phone) && !preg_match("/\d{3}[\-]\d{3}[\-]\d{4}/", $phone)) { 
			$_SESSION['error'] = "Invalid phone number. Please use the format: xxx-xxx-xxxx";
			header('Location: register.php');
			return;
		}
		// password must contain a lowercase alphabet, an uppercase, a digit and must be 6 characters or more
		if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/", $password)) {
			$_SESSION['error'] = "Invalid password form. Please type the password again";
			header('Location: register.php');
			return;
		}

		/* Now checking the database to see whether the username is already registered
		$dbh is the PDO server connection name */

		$check_query = "SELECT username FROM users WHERE username = :username";
		$stmt = $dbh->prepare($check_query);
		$stmt->execute(array(':username' => $_POST['register_username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) { 
			$_SESSION['error'] = "Username already exists";
			header('Location: register.php');
			return;
		}

		//If all the validation and database checks are passed, insert the info into the users table
		//perm_code is the permission code of the user (perm_code is level of authorization user has)
		//$dbh is the PDO server connection name
		else{
			$safe_pwd = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users(perm_code, company_name, username, email, password, phone) 
			VALUES (:perm, :company_name, :username, :email, :password, :phone)";
			$stmt = $dbh->prepare($sql);
			$stmt->execute(array(
				':perm' => 3,
				':company_name' => $company_name,
				':username' => $username,
				':email' => $email,
				':password' => $safe_pwd,
				':phone' => $phone));
			if ($stmt){		//to check if data inserted in the database

				/* selecting the inserted row in the users table to select the user_id
				and insert the services to that user_id in the service table  */
				$check_query = "SELECT user_id FROM users WHERE username = :username";
				$stmt = $dbh->prepare($check_query);
				$stmt->execute(array(':username' => $username));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$_SESSION['register_success'] = "Successfully Registered...";

				// on registration, only non-warranty service is given to the user (non-warranty's id is 5 in the DB table)
				$sql2 = "INSERT INTO user_service(uid, sid) VALUES (:user_id, 5)";
				$stmt2 = $dbh->prepare($sql2);
				$stmt2->execute(array(':user_id' => $row['user_id']));
				if($stmt2) {
					$_SESSION['register_success'] = 'Successfully registered and Services added';
				}

				// inserting the address into the address table for the given user_id
				$sql3 = "INSERT INTO address(user_id, address, city, zip) VALUES (:user_id, :address, :city, :zip)";
				$stmt3 = $dbh->prepare($sql3);
				$stmt3->execute(array(
					':user_id' => $row['user_id'],
					':address' => $address,
					':city' => $city,
					':zip' => $zip));
				if($stmt3) {
					$_SESSION['register_success'] = 'Successfully registered, Services added and address added';
				}
				unset($_SESSION['company_name']);
				unset($_SESSION['username']);
				unset($_SESSION['phone']);
				unset($_SESSION['email']);
				unset($_SESSION['address']);
				unset($_SESSION['city']);
				unset($_SESSION['zip']);
				header ('Location: ../admin_page.php');
				return;
			}
			else{
				$_SESSION['register_error'] = "Registration not successful";
				header ('Location: ../admin_page.php');
				return;
			}
		}

	}

?>