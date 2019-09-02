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
	
	if (!canAddProjects() && !canManageAllProjects()) {
		echo json_encode($return);
		exit();
	}

	$task = isset($_GET['task']) ? intval($_GET['task']) : 0;
	
	if ($task == 0) {
		$id = intval(@$_POST['id']);
		$return->success = true;
		
		if ($db = get_db()) {
			if (!canManageAllProjects()) {
				$query = "SELECT `created_by` FROM `projects` WHERE `id`='$id';";
				if ($row = $db->query($query)->fetch_assoc()) {
					if ($row['created'] != $user_id) {
						$query = "SELECT `id` FROM `project_contributors` WHERE `project_id`='$id';";
						if ($return = $db->query($query)) {
							if ($return->num_rows < 1) {
								$return->success = false;
							}
						} else {
							$return->success = false;
						}
					}
				}
			}			
			if ($return->success) {
				$query = "UPDATE `projects` SET `is_disabled`='1' WHERE `id`='$id';";
				if (!($db->query($query))) {
					$return->sucess = false;
				}
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 1) {
		$return->success = true;
		$id = intval(@$_POST['id']);
		$visible = @$_POST['visible'] == 'true' ? '1' : '0';
		$is_featured = @$_POST['is_featured'] == 'true' ? '1' : '0';
		$start_time = @$_POST['start_time'];
		$finish_time = @$_POST['finish_time'];
		if (strlen($finish_time) == 0) {
			$finish_time = null;
		}	
		$name = @$_POST['name'];
		$description = @$_POST['description'];
		$hide_main_picture = @$_POST['hide_main_picture'] == 'true' ? '1' : '0';
		$is_upcoming_project = @$_POST['is_upcoming_project'] == 'true' ? '1' : '0';
		$display_type = intval(@$_POST['display_type']);
		$project_contributors = explode(',',@$_POST['project_contributors']);
		
		if ($db = get_db()) {
			if (!canManageAllProjects()) {
				$query = "SELECT `created_by` FROM `projects` WHERE `id`='$id';";
				if ($row = $db->query($query)->fetch_assoc()) {
					if ($row['created'] != $user_id) {
						$query = "SELECT `id` FROM `project_contributors` WHERE `project_id`='$id';";
						if ($return = $db->query($query)) {
							if ($return->num_rows < 1) {
								$return->success = false;
							}
						} else {
							$return->success = false;
						}
					}
				}
			}			
			if ($return->success) {
				//perform update
				$start_time = $db->real_escape_string($start_time);
				$finish_time = $db->real_escape_string($finish_time);
				$name = $db->real_escape_string($name);
				$description = $db->real_escape_string($description);
				$query = "UPDATE `projects` SET `visible`='$visible', `is_featured`='$is_featured', `start_time`='$start_time', `finish_time`=".($finish_time==null?"NULL":"'$finish_time'").", `name`='$name', `description`='$description', `hide_main_picture`='$hide_main_picture', `is_upcoming_project`='$is_upcoming_project', `display_type`='$display_type' WHERE `id`='$id';";
				if (!$db->query($query)) {
					$return->success = false;
				} else {
					$query = "DELETE FROM `project_contributors` WHERE `project_id`='$id';";
					$db->query($query);					
					foreach ($project_contributors as $contributor_id) {
						$query = "INSERT INTO `project_contributors` (`user_id`, `project_id`) VALUES ('$contributor_id', '$id');";
						$db->query($query);
					}
				}
			}
			$db->close();
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 2) {
		$id = intval(@$_POST['id']);
		if (!file_exists("../../../../../upload_content/project_images/$id/")) {
			mkdir("../../../../../upload_content/project_images/$id/");
		}
		$image = imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"]));
		
		$thumb_width = 1170;
		$thumb_height = 658;

		$width = imagesx($image);
		$height = imagesy($image);

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;

		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		// Resize and crop
		imagecopyresampled($thumb,
						   $image,
						   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						   0, 0,
						   $new_width, $new_height,
						   $width, $height);
		imagepng($thumb, "../../../../../upload_content/project_images/$id/0.png");
		
		$return->success = true;
		echo json_encode($return);
	} else if ($task == 3) {
		$id = intval(@$_POST['id']);
		if (!file_exists("../../../../../upload_content/project_images/$id/")) {
			mkdir("../../../../../upload_content/project_images/$id/");
		}
		
		for ($i = 0; $i < count($_FILES["files"]["tmp_name"]); $i++) {
			copy($_FILES["files"]["tmp_name"][$i], "../../../../../upload_content/project_images/$id/".$_FILES["files"]["name"][$i]);
		}
		
		
		$return->success = true;
		echo json_encode($return);
	} else if ($task == 4) {
		$id = intval(@$_POST['id']);
		$file = @$_POST['file'];
		@unlink("../../../../../upload_content/project_images/$id/$file");
	} else if ($task == 5) {
		$id = intval(@$_POST['id']);
		if (file_exists("../../../../../upload_content/project_images/$id/")) {
			$array = scandir("../../../../../upload_content/project_images/".$id."/");
			foreach ($array as $val) {
				$var = explode('.', $val);
				$ext = strtolower(array_pop($var));
				if ($ext == "png" || $ext == "jpg") {
					echo "<div class='row'><div class='col-md-6'><img class='img-responsive img-thumbnail' src='/upload_content/project_images/$id/$val?".time()."'></div>
					<div class='col-md-6'><button class='btn btn-danger image_delete' data-file='$val'>Delete</button></div></div><br /><br />";
				}
			}
		}
	} else if ($task == 6) {
		$id = intval(@$_POST['id']);
		$user_id = intval(@$_POST['user_id']);
		if ($db = get_db()) {
			$query = "UPDATE `projects` SET `created_by`='$user_id' WHERE `id`='$id';";
			if (!($db->query($query))) {
				$return->success = false;
			} else {
				$query = "DELETE FROM `project_contributors` WHERE `project_id`='$id' AND `user_id`='$user_id';";
				if (!($db->query($query))) {
					$return->success = false;
				} else {
					$return->success = true;
				}

			}
		}
		echo json_encode($return);
	}
?>