<?php
require_once("../../../../php_include/functions.php");
session_start();
check_login();

class ReturnRead {
	public $first_name;
	public $middle_name;
	public $last_name;
	public $contact_email;
	public $linkedin;
	public $personal_site;
	public $education;
	public $employment;
	public $bio;
	public $db_error = false;
}

class ReturnUpdate {
	public $update_success = true;
}

class ReturnUpdatePassword {
	public $old_password_ok = true;
	public $update_success = true;
	public $db_error = false;
}

if ($logged_in) {
	$task = isset($_GET['task']) ? intval($_GET['task']) : 0;
	$return = new ReturnRead();
	if ($task == 0) {
		if ($db = get_db()) {
			$query = "SELECT * FROM `user_info` WHERE `id`='$user_id';";
			if ($result = $db->query($query)) {
				if ($row = $result->fetch_assoc()) {
					$return->first_name = $row['first_name'];
					$return->middle_name = $row['middle_name'];
					$return->last_name = $row['last_name'];
					$return->contact_email = $row['contact_email'];
					$return->linkedin = $row['linkedin'];
					$return->personal_site = $row['personal_site'];
					$return->education = $row['education'];
					$return->employment = $row['employment'];
					$return->bio = $row['bio'];
				} else {
					$return->db_error = true;
				}
			} else {
				$return->db_error = true;
			}
		} else {
			$return->db_error = true;
		}
		echo json_encode($return);
	} else if ($task == 1) {
		$return = new ReturnUpdate();
		$first_name = @$_POST['first_name'];
		$middle_name = @$_POST['middle_name'];
		$last_name = @$_POST['last_name'];
		$contact_email = @$_POST['contact_email'];
		$linkedin = @$_POST['linkedin'];
		$personal_site = @$_POST['personal_site'];
		$education = @$_POST['education'];
		$employment = @$_POST['employment'];
		$bio = @$_POST['bio'];
		if ($db = get_db()) {
			$query = "UPDATE `user_info` SET "
				."`first_name`='".$db->real_escape_string($first_name)."', "
				."`middle_name`='".$db->real_escape_string($middle_name)."', "
				."`last_name`='".$db->real_escape_string($last_name)."', "
				."`contact_email`='".$db->real_escape_string($contact_email)."', "
				."`linkedin`='".$db->real_escape_string($linkedin)."', "
				."`personal_site`='".$db->real_escape_string($personal_site)."', "
				."`education`='".$db->real_escape_string($education)."', "
				."`employment`='".$db->real_escape_string($employment)."', "
				."`bio`='".$db->real_escape_string($bio)."' "
				."WHERE `id`='".$db->real_escape_string($user_id)."';";
			if (!$db->query($query)) {
				$return->update_success = false;
			}
		} else {
			$return->update_success = false;
		}
		echo json_encode($return);
	} else if ($task == 2) {
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		imagepng(imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"])), "../../../../upload_content/user_images/" . $user_id . ".png");
        header("Location: /manage/profile");
        $page = $_SERVER['PHP_SELF'];
        $sec = "10";
        header("Refresh: $sec; url=$page");
	} else if ($task == 3) {
		$old_password = @$_POST['old_password'];
		$password = @$_POST['password'];
		$return = new ReturnUpdatePassword();
		
		if ($db = get_db()) {
			$query = "SELECT `password` FROM `users` WHERE `id`='$user_id';";
			if ($result = $db->query($query)) {
				if ($row = $result->fetch_assoc()) {
					if ($row['password'] != md5($old_password)) {
						$return->old_password_ok = false;
						$return->update_success = false;
					} else {
						$query = "UPDATE `users` SET `password`=MD5('$password') WHERE `id`='$user_id';";
						if (!$db->query($query)) {
							$return->db_error = true;
							$return->update_success = false;
						}
					}	
				} else {
					$return->db_error = true;
					$return->update_success = false;
				}
			} else {
				$return->db_error = true;
				$return->update_success = false;
			}
			$db->close();
		} else {
			$return->db_error = true;
			$return->update_success = false;
		}
		
		echo json_encode($return);
	}
}
?>