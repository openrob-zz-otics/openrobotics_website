<?php
	require_once("../../../../php_include/functions.php");
	session_start();
	check_login();
		
	class generalReturn {
		public $success = true;
		public $append_data = "";
	}
	
	$return = new generalReturn();
	
	if (!(isLoggedIn() && canManageUsers())) {
		$return->success = false;
		echo json_encode($return);
		exit();
	}

	$task = intval(@$_GET['task']);

	if ($task == 0) {
		$id = intval(@$_POST['id']);
		if ($id > 0) {
			if ($db = get_db()) {
				$query = "SELECT * FROM `display_text` WHERE `text_location`='$id'";
				if ($result = $db->query($query)) {
					$return->append_data .= '<p style="font-weight:bold;" id="message_text"></p><h4>Please make changes to the text fields as neccessary and then press submit below.</h4><form id="update_form" action="javascript:void(0);">';
					while ($row = $result->fetch_assoc()) {
						$return->append_data .= 
						'<div class="form-group">
							<label for="'.$row['text_name'].'">'.$row['text_display_name'].'</label>
							<input type="text" class="form-control" id="'.$row['text_name'].'" placeholder="value" value="'.htmlspecialchars($row['text_content']).'">
						</div>';
					}
					$return->append_data .= '<button class="btn btn-default" id="submit_button">Submit</button></form>';
				}

			} else {
				$return->success = false;
			}
		} else if ($id == -1) {
			//edit home page carousel
			$return->append_data .= 
			'<p>Upload A Picture<p>
			<span class="btn btn-default fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Upload...</span>
				<input id="carousel_upload" type="file" name="file" data-url="/manage/display/assets/cgi/display.php?task=2">
			</span>
			<br />
			<br />
			<div id="carousel_upload_progress" class="progress">
				<div class="progress-bar progress-bar-striped active"></div>
			</div><br /><hr><h3>Current Images</h3>';
			if (file_exists("../../../../assets/images/carousel/")) {
				$array = scandir("../../../../assets/images/carousel/");
				foreach ($array as $val) {
					$var = explode('.', $val);
					$ext = strtolower(array_pop($var));
					if (in_array($ext, $acceptable_image_extensions)) {		
						$return->append_data .= "<div id='img_$val' class='row'><div class='col-sm-8'><img class='img-responsive' src='../../../../assets/images/carousel/$val' /></div><div class='col=sm-4'><button class='btn btn-danger delete_image' data-val='$val'>Delete Image</button></div></div><br /><hr>";
					}
				}
			}
		} else {
			$return->success = false;
		}
		echo json_encode($return);
	} else if ($task == 1) {
		$id = intval(@$_POST['id']);
		$ids = explode("_;!_", @$_POST['ids']);
		$vals = explode("_;!_", @$_POST['vals']);
		if ($db = get_db()) {
			
			for ($i = 0; $i < count($ids); $i++) {
				$query = "UPDATE `display_text` SET `text_content`='".$db->real_escape_string($vals[$i])."' WHERE `text_name`='".$db->real_escape_string($ids[$i])."';";
				if (!($db->query($query))) {
					$return->success = false;
				}
			}			
		}
		echo json_encode($return);
	} else if ($task == 2) {
		//accept upload photo, convert, store
		$image = imagecreatefromstring(file_get_contents($_FILES["file"]["tmp_name"]));

		$thumb_width = 1170;
		$thumb_height = 658;

		$width = imagesx($image);
		$height = imagesy($image);

		//echo "width: " . $width . "   height:   " . $height . "<br />";

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;

		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}

		$new_image = imagecreatetruecolor($thumb_width, $thumb_height);
		imagesavealpha($new_image, true);

		//set the background transparent
		$trans_colour = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
    	imagefill($new_image, 0, 0, $trans_colour);

		// Resize and crop
		imagecopyresampled($new_image,
						   $image,
						   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						   0, 0,
						   $new_width, $new_height,
						   $width, $height);
		$new_image_id = 0;
		while (file_exists("../../../../assets/images/carousel/$new_image_id.png"))
			$new_image_id++;
		imagepng($new_image, "../../../../assets/images/carousel/$new_image_id.png");
		echo json_encode($return);
	} else if($task == 3) {
		$val = @$_POST['val'];
		unlink("../../../../assets/images/carousel/$val");
		echo json_encode($return);
	}

?>