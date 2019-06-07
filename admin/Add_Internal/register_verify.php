<?php 
	require_once "../../server.php";
	//include "register.php";
	if (!isset($_SESSION))
  	{
    	session_start();
  	}


	if(isset($_POST['role']) && isset($_POST['uname']) && isset($_POST['pwd'])) {
		$user_role = $_POST['role'];
		$company_name = strip_tags(trim($_POST['comp']));
		$username = $_POST['uname'];
		$phone = $_POST['phone'];
		$password = $_POST['pwd'];
		$password_confirm = $_POST['pwd_confirm'];

		//Form validation
		if(empty($company_name)) { 
			 $arr = array('error' => 'Company name is required..');
		}
		else if(empty($username)) { 
			$arr = array('error' => 'Username is required..'); 
		}
		else if(empty($password)) { 
			$arr = array('error' => 'Unable to login');
		}
		else if($password !== $password_confirm) { 
			$arr = array('error' => "Passwords don't match... Please type again.");
		}
		else if( !is_null($phone) && !preg_match("/\d{3}[\-]\d{3}[\-]\d{4}/", $phone)) { 
			$arr = array('error' => 'Invalid phone number. Please use the format: xxx-xxx-xxxx');
		}
		// password must contain a lowercase alphabet, an uppercase, a digit and must be 6 characters or more
		else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/", $password)) {
			$arr = array('error' => "Invalid password form. Please type the password again");
		}

		else if(!preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $email)) {
			$arr = array('error' => "Invalid email id. Please type the email id again");
		}
		/* Now checking the database to see whether the username is already registered
		$dbh is the PDO server connection name */
		else {
			$check_query = "SELECT username FROM users WHERE username = :username";
			$stmt = $dbh->prepare($check_query);
			$stmt->execute(array(':username' => $_POST['uname']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row) { 
				$arr = array('error' => 'Username already exists');
			}

		//If all the validation and database checks are passed, insert the info into the users table
		//$dbh is the PDO server connection name
			else{
				$safe_pwd = password_hash($password, PASSWORD_DEFAULT);
				$sql = "INSERT INTO users(perm_code, company_name, username, password, phone) 
				VALUES (:perm, :company_name, :username, :password, :phone)";
				$stmt = $dbh->prepare($sql);
				$stmt->execute(array(
					':perm' => $user_role,
					':company_name' => $company_name,
					':username' => $username,
					':password' => $safe_pwd,
					':phone' => $phone));
				$arr = array('success' => 'Registration complete');
			}
		}
		echo json_encode($arr);
	}
	else{
		echo json_encode(array('error' => "Problem sending information to the database... "));
	}

?>