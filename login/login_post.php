<?php

require_once("../php_include/functions.php");
require_once("../php_include/login_functions.php");

if (isset($_POST['submit'])) {
	$email = isset($_POST['email']) ? $_POST['email'] : "";
	$password = isset($_POST['password']) ? $_POST['password'] : "";
	
	$login_response = validate_login($email, $password);
	
	/*
	class ValidateLoginResult {
		public $valid_user = RETURN_NULL;
		public $valid_password = RETURN_NULL;
		
		public $login_success = true;
		
		public $user_id = null;
		public $session_id = 0;
		
		public $db_error = false;
	}*/
	if (!$login_response->login_success) {
		if ($login_response->db_error) {
			$error_msg = "DB error";
		} else if ($login_response->valid_user == RETURN_FALSE) {
			$error_msg = "No such email in system.";
		} else if ($login_response->valid_password == RETURN_FALSE) {
			$error_msg = "Incorrect password";
		}
		include("index.php");
	} else {
		session_start();
		$_SESSION['email'] = $email;
		$_SESSION['session_id'] = $login_response->session_id;
		include("../manage/profile/index.php");
	}
	
} else {
	//header('Location: index.php');
}
?>