<?php
require_once("db.php");
require_once("client_functions.php");

/* The following return constants describe the state of a particular return 
 * For example they can be used to describe whether a password was correct (success)
 * or wrong (fail)
 */

/* The value was never tested; it is not known whether it is valid or not */
define("RETURN_NULL", 0);

/* The value was correct */
define("RETURN_SUCCESS", 1);
define("RETURN_TRUE", 1);

/* The value was wrong in some way */
define("RETURN_FAIL", -1);
define("RETURN_FALSE", -1);

//validate_login result structure
class ValidateLoginResult {
	public $valid_user = RETURN_NULL;
	public $valid_password = RETURN_NULL;
	
	public $login_success = true;
	
	public $user_id = null;
	public $session_id = 0;
	
	public $db_error = false;
}

function validate_login($email, $password) {
	//declare response structure
	$return = new ValidateLoginResult();
	if (!($db = get_db())) {
		$return->db_error = true;
		$return->login_success = false;
		return $return;
	}
	
	//escape the email
	$email = $db->real_escape_string($email);
	
	//Select the user 
	$query = "SELECT `id`, `password` FROM `users` WHERE `email`='$email' AND `is_disabled`='0';";
	if (!($result = $db->query($query))) {
		$return->db_error = true;
		$return->login_success = false;
		$db->close();
		return $return;
	}
	
	//check that we got 1 result
	if ($result->num_rows != 1) {
		$return->valid_user = RETURN_FAIL;
		$return->login_success = false;
		$result->free();
		$db->close();
		return $return;
	}	
	$return->valid_user = RETURN_SUCCESS;
	
	$assoc = $result->fetch_assoc();
	
	//check the password
	if (strcmp(md5($password), $assoc['password'])!=0) {
		$return->valid_password = RETURN_FAIL;
		$return->login_success = false;
		$result->free();
		$db->close();
		return $return;
	}	
	$return->valid_password = RETURN_SUCCESS;
	$user_id = $assoc['id'];
	$result->free();
	//Return a session identifier and store that in the db
	$session_id = uniqid('', TRUE);
	
	//get current date/time
	$now = date('Y-m-d H:i:s');
	//get expiry time (1 week)
	$expire = date('Y-m-d H:i:s', time() + 7*24*3600);
	//get user ip
	$ip = getClientIP();
	
	$query = "INSERT INTO `sessions` "
	. "(`user_id`, `session_id`, `session_time`, `session_ip`, `session_expire`) "
    . "VALUES ('$user_id', '$session_id', '$now', '$ip', '$expire');";
	if (!$db->query($query)) {
		$return->db_error = true;
		$return->login_success = false;
		$db->close();
		return $return;
	}
	$db->close();
	
	$return->user_id = $user_id;
	$return->session_id = $session_id;
	
	
	return $return;
}

//validate_session result structure
class ValidateSessionResult {
	public $valid_user = RETURN_NULL;
	public $valid_session = RETURN_NULL;
	public $session_expired = RETURN_NULL;
	
	public $validate_success = true;
	
	public $db_error = false;
}

function validate_session($user_email, $session_id) {
	$return = new ValidateSessionResult();
	
	if (!($db = get_db())) {
		$return->db_error = true;
		$return->validate_success = false;
		return $return;
	}
	
	//escape the email
	$email = $db->real_escape_string($user_email);
	
	//Select the user 
	$query = "SELECT `id` FROM `users` WHERE `email`='$email' AND `is_disabled`='0';";
	if (!($result = $db->query($query))) {
		$return->db_error = true;
		$return->validate_success = false;
		return $return;
	}
	
	//check that we got 1 result
	if ($result->num_rows != 1) {
		$return->valid_user = RETURN_FAIL;
		$return->validate_success = false;
		$db->close();
		return $return;
	}	
	$return->valid_user = RETURN_SUCCESS;
	$assoc = $result->fetch_assoc();
	$user_id = $assoc['id'];
	$result->free();
	
	//get session_ids
	$query = "SELECT `session_id`, `session_expire` FROM `sessions` WHERE `user_id`='$user_id';";
	if (!($result = $db->query($query))) {
		$return->db_error = true;
		$return->validate_success = false;
		$db->close();
		return $return;
	}
	
	$has_matched = false;
	$expires = null;
	
	while ($row = $result->fetch_assoc()) {
		if (strcmp($session_id, $row['session_id'])==0) {
			$has_matched = true;
			$expires = strtotime($row['session_expire']);
			break;
		}
	}
	
	$result->free();
	$db->close();
	
	if (!$has_matched) {
		$return->valid_session = RETURN_FAIL;
		$return->validate_success = false;
		return $return;
	}
	
	$return->valid_session = RETURN_SUCCESS;
	if (time() >= $expires) {
		$return->session_expired = RETURN_TRUE;
		$return->validate_success = false;
		return $return;
	}
	
	$return->session_expired = RETURN_FALSE;
	
	return $return;
	
}

//returns -1 on failure (email doesn't exist)
function get_id_from_email($email, $db) {
	$query = "SELECT `id` FROM `users WHERE `email`='$email';";
	if (!($result = $db->query($query))) {
		return -1;
	}
	
	if ($result->num_rows != 1) {
		return -1;
	}	
	
	if (!($assoc = $result->fetch_assoc())) {
		return -1;
	}
	
	$id = $assoc['id'];
	$result->free();
	
	return $id;
}

//return true on success, false otherwise
function remove_session($email, $session_id) {
	if (!($db = get_db())) {
		return false;
	}
	
	$id = get_id_from_email($db->real_escape_string($email), $db);
	if ($id == -1) {
		return false;
	}	
	
	$query = "DELETE FROM `sessions` where `user_id`='$id' AND `session_id`='$session_id';";
	$result = $db->query($query);
	$db->close();
	
	return $result;
}

?>