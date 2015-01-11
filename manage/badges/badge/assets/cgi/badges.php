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
		$new_difficulty = @$_POST['new_difficulty'];
		$new_difficulty_description = @$_POST['new_difficulty_description'];
		$new_category = @$_POST['new_category'];
		$description = @$_POST['description'];
		$instructions = @$_POST['instructions'];

		if ($db = get_db()) {
			$id = $db->real_escape_string($id);
			$visible = $db->real_escape_string($visible);
			$name = $db->real_escape_string($name);
			$difficulty = $db->real_escape_string($difficulty);
			$category = $db->real_escape_string($category);
			$new_difficulty = $db->real_escape_string($new_difficulty);
			$new_difficulty_description = $db->real_escape_string($new_difficulty_description);
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

			if ($difficulty == 0) {
				$query = "INSERT INTO `badge_difficulties` (`difficulty_name`,`description`) VALUES ('$new_difficulty','$new_difficulty_description');";
				if (!$db->query($query)) {
					$db->close();
					fail();
				}
				$difficulty = $db->insert_id;
				$return->new_difficulty_id = $difficulty;
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
		echo json_encode($return);
	} else if ($task == 1) {
		$id = @$_POST['id'];
		if ($db = get_db()) {
			$query = "UPDATE `badges` SET `is_disabled`='1' WHERE `id`='$id';";
			if (!$db->query($query)) {
				$db->close();
				fail();
			}

		} else {
			fail();
		}
		echo json_encode($return);
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

		$width = imagesx($image);
		$height = imagesy($image);

		//echo $width.":".$height;

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
		echo json_encode($return);
	} else if ($task == 3) {
		$search = @$_POST['search'];
		$id = intval(@$_POST['id']);

		if ($db = get_db()) {
			$search = $db->real_escape_string($search);
			$query = "SELECT * FROM `user_info` INNER JOIN `users` ON `users`.`id`=`user_info`.`id` 
				WHERE (`user_info`.`first_name` LIKE '%$search%' 
				OR `user_info`.`middle_name` LIKE '%$search%' 
				OR `user_info`.`last_name` LIKE '%$search%' 
				OR `user_info`.`contact_email` LIKE '%$search%'
				OR `users`.`email` LIKE '%$search%'
				OR CONCAT_WS(' ', `user_info`.`first_name`, `user_info`.`last_name`) LIKE '%$search%'
				OR CONCAT_WS(' ', `user_info`.`first_name`, `user_info`.`middle_name`, `user_info`.`last_name`) LIKE '%$search%'
				OR CONCAT_WS(',', `user_info`.`last_name`, `user_info`.`first_name`) LIKE '%$search%'
				OR CONCAT_WS(', ', `user_info`.`last_name`, `user_info`.`first_name`) LIKE '%$search%')
				AND `users`.`id` NOT IN (SELECT `user_id` FROM `user_badges` WHERE `badge_id`='$id');";
			//echo $query;
			if ($result = $db->query($query)) {
				if ($result->num_rows)
					echo '<p>Click on a user to give them this badge.</p>';
				echo "<ul class='list-group'>";
				while ($row = $result->fetch_assoc()) {
					echo "<li data-id='".$row['id']."' class='user_select list-group-item'>".$row['first_name']." ".$row['last_name']."</li>";
				}
				echo "</ul>";
			}
		}
	} else if ($task == 4) {
		$badge_id = intval(@$_POST['id']);
		$user_id = intval(@$_POST['user_id']);

		if ($db = get_db()) {
			$query = "INSERT INTO `user_badges` (`user_id`, `badge_id`) VALUES ('$user_id', '$badge_id');";
			if (!$db->query($query)) {
				$return->success = false;
			}
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 5) {
		$badge_id = intval(@$_POST['badge_id']);
		if ($db = get_db()) {
			$query = "SELECT * FROM `user_info` WHERE `id` IN (SELECT `user_id` FROM `user_badges` WHERE `badge_id`='$badge_id');";
			if ($result = $db->query($query)) {
				echo '<ul class="list-group">';
				if ($result->num_rows) 
					echo '<p>Click on the \'x\' beside a user\'s name to take this badge away from them.</p>';
				while ($row = $result->fetch_assoc()) {
					echo '<li class="list-group-item">';
					echo "<span class='glyphicon glyphicon-remove delete_user' style='float:right;cursor:pointer;' data-id='".$row['id']."'></span>";
					echo "<a href='/contact/user?id=".$row['id']."'>".$row['first_name'].' '.$row['last_name']."</a>";
					echo '</li>';
				}
				echo '</ul>';
			}			
		}
	} else if ($task == 6) {
		$badge_id = intval(@$_POST['id']);
		$user_id = intval(@$_POST['user_id']);

		if ($db = get_db()) {
			$query = "DELETE FROM `user_badges` WHERE `user_id`='$user_id' AND `badge_id`='$badge_id';";
			//echo $query;
			if (!$db->query($query)) {
				$return->success = false;
			}
		} else {	
			$return->success = false;
		}
		echo json_encode($return);
	}

?>