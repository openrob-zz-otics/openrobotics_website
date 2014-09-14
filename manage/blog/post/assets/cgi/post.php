<?php
	require_once("../../../../../php_include/functions.php");
	session_start();
	check_login();
	
	class genericResponse {
		public $success = false;
	}
	
	$return = new genericResponse();
	
	if (!isLoggedIn()) {
		echo json_encode($return);
		exit();
	}
	
	if (!canAddBlogPost() && !canManageAllBlogPosts()) {
		echo json_encode($return);
		exit();
	}
	
	$task = isset($_GET['task']) ? intval($_GET['task']) : 0;

	class getPostReturn {
		public $title;
		public $subtitle;
		public $content;
		public $success = true;
	}
		
	if ($task == 2) {
		$id = intval(@$_POST['id']);
		$title = @$_POST['title'];
		$sub_title = @$_POST['subtitle'];
		$content = @$_POST['content'];
		$visible = @$_POST['visible'] == 'true' ? '1' : '0';
		$return->success = true;
		
		if ($db = get_db()) {
			$query = "SELECT `created_by` FROM `blog_posts` WHERE `id`='$id';";
			if ($user_id != $db->query($query)->fetch_assoc()['created_by'] && !canManageAllBlogPosts()) {
				$return->success = false;
			} else {
				$title = $db->real_escape_string($title);
				$sub_title = $db->real_escape_string($sub_title);
				$content = $db->real_escape_string($content);
				
				$query = "UPDATE `blog_posts` SET `title`='$title', `visible`='$visible', `sub_title`='$sub_title', `content`='$content' WHERE `id`='$id';";
			
				if (!$db->query($query)) {
					$return->success = false;
				}
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 3) {
		$id = intval(@$_POST['id']);
		
		$return->success = true;
		
		if ($db = get_db()) {
			$query = "SELECT `created_by` FROM `blog_posts` WHERE `id`='$id';";
			if ($user_id != $db->query($query)->fetch_assoc()['created_by'] && !canManageAllBlogPosts()) {
				$return->success = false;
			} else {				
				$query = "UPDATE `blog_posts` SET `is_disabled`='1' WHERE `id`='$id';";
			
				if (!$db->query($query)) {
					$return->success = false;
				}
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	}
?>