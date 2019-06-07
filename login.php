<?php
	require_once "server.php";
	if (!isset($_SESSION))
  	{
    	session_start();
  	}

	if(isset($_POST['username']) && isset($_POST['password'])) {
		unset($_SESSION['account']);	//logout current user if there
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($username) || empty($password)){
			$_SESSION['error'] = "Fields cannot be empty!";
			header('Location: index.php');
			return;
		}

		if($username == 'admin' && $password == 'password'){
			$_SESSION['account'] = "FRONTEND_ADM";
			header('Location: ./admin/admin_page.php');
			return;
		}

		//Checking for login credentials
		//$dbh is the PDO server connection name 
		$check_query = "SELECT * FROM users WHERE username = :username";
		$stmt = $dbh->prepare($check_query);
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$row){
			$_SESSION['error'] = "Username doesn't exist";
			header('Location: index.php');
			return;
		}
		if($row['username'] != $username || !password_verify($password, $row['password'])){
			$_SESSION['error'] = "Wrong username or password! Please enter again";
			header('Location: index.php');
			return;
		}
		if ($row['username'] == $username && password_verify($password, $row['password'])){
			if($row['perm_code'] == 1){
				$_SESSION['account'] = "FRONTEND_ADM";
				$_SESSION['user_role'] = $row['perm_code'];
				$_SESSION['username'] = $username;
				$_SESSION['login_msg'] = "Welcome, ".$row['username'];
				header ('Location: ./admin/admin_page.php');
				return; 
			}
			else if($row['perm_code'] == 3){
				$_SESSION['account'] = $row['user_id'];
				$_SESSION['user_role'] = $row['perm_code'];
				$_SESSION['username'] = $username;
				$_SESSION['login_msg'] = "Welcome, ".$row['username'];
				header ('Location: ./member/member_home.php?user_id='.$row['user_id']);
				return; 
			}
			else if($row['perm_code'] == 2){
				$_SESSION['account'] = "BACKEND_ADM";
				$_SESSION['user_role'] = $row['perm_code'];
				$_SESSION['username'] = $username;
				$_SESSION['login_msg'] = "Welcome, ".$row['username'];
				header ('Location: ./back_admin/back_admin_home.php?r='.$row['perm_code']);
				return; 
			}
			else if($row['perm_code'] == 4){
				$_SESSION['account'] = "BACKEND_TECH";
				$_SESSION['user_role'] = $row['perm_code'];
				$_SESSION['username'] = $username;
				$_SESSION['login_msg'] = "Welcome, ".$row['username'];
				header ('Location: ./back_admin/back_admin_tech.php?r='.$row['perm_code']);
				return; 
			}
			else if($row['perm_code'] == 5){
				$_SESSION['account'] = "BACKEND_RECEIVE";
				$_SESSION['user_role'] = $row['perm_code'];
				$_SESSION['username'] = $username;
				$_SESSION['login_msg'] = "Welcome, ".$row['username'];
				header ('Location: ./back_admin/back_admin_receiving.php?r='.$row['perm_code']);
				return; 
			}
		}

	}

?>