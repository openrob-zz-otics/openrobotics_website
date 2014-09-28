<?php
	require_once("../../../../../php_include/functions.php");
	session_start();
	check_login();

	class Response {
		public $success = true;
		public $new_category_id;
	}

	$return = new Response();

	function fail() {
		$GLOBALS['return']->success = false;
		echo json_encode($GLOBALS['return']);
		exit();
	}	

	if (!isLoggedIn() || !canManageUsers()) {
		fail();	
	}

	//0: update
	//1: delete
	//2: add new category
	$task = intval(@$_GET['task']);

	if ($task == 0) {
		$id = @$_POST['id'];
		$visible = (@$_POST['visible'] == 'true') ? '1' : '0';
		$name = @$_POST['name'];
		$difficulty = @$_POST['difficulty'];
		$category = @$_POST['category'];
		$new_category = @$_POST['new_category'];
		$description = @$_POST['description'];
		$instructions = @$_POST['instructions'];

		if ($db = get_db()) {
			$id = $db->real_escape_string($id);
			$visible = $db->real_escape_string($visible);
			$name = $db->real_escape_string($name);
			$difficulty = $db->real_escape_string($difficulty);
			$category = $db->real_escape_string($category);
			$new_category = $db->real_escape_string($new_category);
			$description = $db->real_escape_string($description);
			$instructions = $db->real_escape_string($instructions);

			if ($category == 0) {
				$query = "INSERT INTO `badge_categories` (`category_name`) VALUES ('$new_category');";
				//echo $query;
				if (!$db->query($query)) {
					$db->close();
					fail();
				}
				$category = $db->insert_id;
				$return->new_category_id = $category;
			}

			$query = "UPDATE `badges` SET `visible`='$visible', `name`='$name', `difficulty`='$difficulty', `category`='$category', `description`='$description', `instructions`='$instructions' WHERE `id`='$id';";
			if (!$db->query($query)) {
				$db->close();
				fail();
			}
			$db->close();
		} else {
			fail();
		}
	} else if ($task == 1) {
		$id = @$_POST['id'];
		if ($db = get_db()) {
			$query = "UPDATE `badges` SET `is_disabled`='1';";
			if (!$db->query($query)) {
				$db->close();
				fail();
			}

		} else {
			fail();
		}
	} else if ($task == 2) {
		$id = intval(@$_POST['id']);
		if (!file_exists("../../../../../upload_content/badge_images")) {
			mkdir("../../../../../upload_content/badge_images");
		}
		if (!file_exists("../../../../../upload_content/badge_images/large")) {
			mkdir("../../../../../upload_content/badge_images/large");
		}
		if (!file_exists("../../../../../upload_content/badge_images/small")) {
			mkdir("../../../../../upload_content/badge_images/small");
		}
		$image = imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"]));
		//imagealphablending($badge_large, false);

		$width = imagesx($image);
		$height = imagesy($image);

		$badge_size_large = 1000;
		$badge_size_small = 200;

		$badge_large = imagecreatetruecolor($badge_size_large, $badge_size_large);
		$badge_small = imagecreatetruecolor($badge_size_small, $badge_size_small);

		imagealphablending($badge_large, false);
		imagealphablending($badge_small, false);
		imagesavealpha($badge_large, true);
		imagesavealpha($badge_small, true);

		// Resize and crop
		imagecopyresampled ($badge_large,
		   $image,
		   0, 0, 0, 0,
		   $badge_size_large, $badge_size_large,
		   $width, $height);
		imagecopyresampled ($badge_small,
		   $image,
		   0, 0, 0, 0,
		   $badge_size_small, $badge_size_small,
		   $width, $height);
		
		

		imagepng($badge_large, "../../../../../upload_content/badge_images/large/$id.png");
		imagepng($badge_small, "../../../../../upload_content/badge_images/small/$id.png");

		$return->success = true;
		echo json_encode($return);
	}

	echo json_encode($return);
?>