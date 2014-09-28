<?php
	require_once("../../../../../php_include/functions.php");
	session_start();
	check_login();

	class Response {
		public $success = true;
	}

	$return = new Response();

	function fail() {
		$return->success = false;
		echo json_encode($return);
		exit();
	}	

	if (!isLoggedIn() || !canManageUsers()) {
		fail();	
	}

	//0: update
	//1: delete
	//2: upload picture
	$task = intval(@$_GET['task']);

	if ($task == 0) {
		$id = @$_POST['id'];
		$visible = (@$_POST['visible'] == 'true') ? '1' : '0';
		$name = @$_POST['name'];
		$difficulty = @$_POST['difficulty'];
		$category = @$_POST['category'];
		$description = @$_POST['description'];
		$instructions = @$_POST['instructions'];

		if ($db = get_db()) {
			$id = $db->real_escape_string($id);
			$visible = $db->real_escape_string($visible);
			$name = $db->real_escape_string($name);
			$difficulty = $db->real_escape_string($id);
			$category = $db->real_escape_string($id);
			$description = $db->real_escape_string($id);
			$instructions = $db->real_escape_string($id);

			$query = "UPDATE `badges` SET `visible`='$visible', `name`='$name', `difficulty`='$difficulty', `category`='$category', `description`='$description', `instructions`='$instructions' WHERE `id`='$id';"
			if ($result = $db->query($query)) {

			} else {
				fail();
			}
			$db->close();
		} else {
			fail();
		}
	} else if ($task == 1) {

	} else if ($task == 2) {

	}

	echo json_encode($return);
?>