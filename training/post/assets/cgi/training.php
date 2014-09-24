<?php 
	require("../../../../php_include/functions.php");
	session_start();
	check_login();

	if (!isLoggedIn()) {
		exit();
	}

	$is_checked = (@$_POST['is_checked']) == 'true' ? true: false;
	$training_id = @$_POST['training_id'];

	if ($db = get_db()) {
		if ($is_checked) {
			$query = "SELECT * FROM `training_completion` WHERE `user_id`='$user_id' AND `training_id`='$training_id';";
			if ($db->query($query)->num_rows == 0) {
				$query = "INSERT INTO `training_completion` (`user_id`, `training_id`) VALUES ('$user_id', '$training_id');";
				$db->query($query);
			}
		} else {
			$query = "DELETE FROM `training_completion` WHERE `user_id`='$user_id' AND `training_id`='$training_id';";
			$db->query($query);
		}			
		$db->close();
	}
?>