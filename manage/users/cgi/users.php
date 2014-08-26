<?php
	require_once("../../../php_include/functions.php");
	session_start();
	check_login();
		
	class updateReturn {
		public $update_success = true;
	}
	
	$return = new updateReturn();
	
	if (!(isLoggedIn() && canManageUsers())) {
		$return->update_success = false;
		echo json_enocde($return);
		exit();
	}

	
	$task = isset($_GET['task']) ? intval($_GET['task']) : 0;
	
	if ($task == 0) {
		$manage_user_id = intval(@$_POST['id']);
		$manage_users = @($_POST['manage_users'] == "true" ? 1 : 0);
		$add_projects = @($_POST['add_projects'] == "true" ? 1 : 0);
		$manage_all_projects = @($_POST['manage_all_projects'] == "true" ? 1 : 0);
		$add_blog_post = @($_POST['add_blog_post'] == "true" ? 1 : 0);
		$manage_all_blog_posts = @($_POST['manage_all_blog_posts'] == "true" ? 1 : 0);
		$in_contact_list = @($_POST['in_contact_list'] == "true" ? 1 : 0);
		
		if ($db = get_db()) {
			$manage_users = $db->real_escape_string($manage_users);
			$add_projects = $db->real_escape_string($add_projects);
			$manage_all_projects = $db->real_escape_string($manage_all_projects);
			$add_blog_post = $db->real_escape_string($add_blog_post);
			$manage_all_blog_posts = $db->real_escape_string($manage_all_blog_posts);
			$in_contact_list = $db->real_escape_string($in_contact_list);
		
			$query = "UPDATE `user_permissions` SET `manage_users`='$manage_users', `add_projects`='$add_projects', ";
			$query .= "`manage_all_projects`='$manage_all_projects', `add_blog_post`='$add_blog_post', ";
			$query .= "`manage_all_blog_posts`='$manage_all_blog_posts', `in_contact_list`='$in_contact_list' ";
			$query .= "WHERE `id`='$manage_user_id';";
			
			if (!$db->query($query)) {
				$return->update_success = false;
			}
			$db->close();
		} else {
			$return->update_success = false;
		}
		echo json_encode($return);
	} else if ($task == 1) {
		$manage_user_id = intval(@$_POST['id']);
		$first_name = @$_POST['first_name'];
		$middle_name = @$_POST['middle_name'];
		$last_name = @$_POST['last_name'];
		$contact_email = @$_POST['contact_email'];
		$linkedin = @$_POST['linkedin'];
		$personal_site = @$_POST['personal_site'];
		$open_robotics_position = @$_POST['open_robotics_position'];
		$education = @$_POST['education'];
		$employment = @$_POST['employment'];
		$bio = @$_POST['bio'];
		
		if ($db = get_db()) {
			$first_name = $db->real_escape_string($first_name);
			$middle_name = $db->real_escape_string($middle_name);
			$last_name =$db->real_escape_string($last_name);
			$contact_email = $db->real_escape_string($contact_email);
			$linkedin = $db->real_escape_string($linkedin);
			$personal_site = $db->real_escape_string($personal_site);
			$open_robotics_position = $db->real_escape_string($open_robotics_position);
			$education = $db->real_escape_string($education);
			$employment = $db->real_escape_string($employment);
			$bio = $db->real_escape_string($bio);
		
			$query = "UPDATE `user_info` SET `first_name`='$first_name', `middle_name`='$middle_name', `last_name`='$last_name', `contact_email`='$contact_email', ";
			$query .= "`linkedin`='$linkedin', `personal_site`='$personal_site', `open_robotics_position`='$open_robotics_position', ";
			$query .= "`education`='$education', `employment`='$employment', `bio`='$bio' WHERE `id`='$manage_user_id';";
			
			//echo $query;
			
			if (!$db->query($query)) {
				$return->update_success = false;
			}
			$db->close();
		} else {
			$return->update_success = false;
		}
		echo json_encode($return);
	} else if ($task == 2) {
		$manage_user_id = 
		$password = @$_POST['password'];
		if (strlen($password) > 1) {
			if ($db = get_db()) {
				$password = $db->real_escape_string($password);
				$query = "UPDATE `users` SET `password`=md5('$password') WHERE `id`='$manage_user_id';";
				if (!($db->query($query)))
					$return->update_success = false;
				$db->close();
			} else {
				$return->update_success = false;
			}
		} else {
			$return->update_success = false;
		}
		echo json_encode($return);
	} else if ($task == 3) {
		$manage_user_id = intval(@$_POST['id']);
		
		if ($db = get_db()) {
			$query = "DELETE FROM `users` WHERE `id`='$manage_user_id' LIMIT 1;";
			if (!($db->query($query))) 
				$return->update_success = false;
			$db->close();
		} else {
			$return->update_success = false;
		}
		
		echo json_encode($return);
	}
?>