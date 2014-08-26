<?php
	require_once("../../../php_include/functions.php");
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
		
	if ($task == 0) {
		$return = new getPostReturn();
		
		$id = intval(@$_POST['id']);
		
		if ($db = get_db()) {
			$query = "SELECT * FROM `blog_posts` WHERE `id`='$id';";
			if ($row = $db->query($query)->fetch_assoc()) {
				if ($row['created_by'] != $user_id && !canManageAllBlogPosts()) {
					$return->success = false;
				} else {
					$return->title = $row['title'];
					$return->subtitle = $row['sub_title'];
					$return->content = $row['content'];
				}			
			} else {
				$return->success = false;
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 1) {
		$title = @$_POST['title'];
		$sub_title = @$_POST['subtitle'];
		$content = @$_POST['content'];
		
		$return->success = true;
		
		if ($db = get_db()) {
			$query = "INSERT INTO `blog_posts` (`visible`, `created_by`, `publish_time`, `title`, `sub_title`, `content`) ";
			$now = date("Y-m-d H:i:s");
			$title = $db->real_escape_string($title);
			$sub_title = $db->real_escape_string($sub_title);
			$content = $db->real_escape_string($content);
			$query .= "VALUES ('1', '$user_id', '$now', '$title', '$sub_title', '$content');";
		
			if (!$db->query($query)) {
				$return->success = false;
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 2) {
		$id = intval(@$_POST['id']);
		$title = @$_POST['title'];
		$sub_title = @$_POST['subtitle'];
		$content = @$_POST['content'];
		
		$return->success = true;
		
		if ($db = get_db()) {
			$query = "SELECT `created_by` FROM `blog_posts` WHERE `id`='$id';";
			if ($user_id != $db->query($query)->fetch_assoc()['created_by'] && !canManageAllBlogPosts()) {
				$return->success = false;
			} else {
				$title = $db->real_escape_string($title);
				$sub_title = $db->real_escape_string($sub_title);
				$content = $db->real_escape_string($content);
				
				$query = "UPDATE `blog_posts` SET `title`='$title', `sub_title`='$sub_title', `content`='$content' WHERE `id`='$id';";
			
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
				$query = "DELETE FROM `blog_posts` WHERE `id`='$id';";
			
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