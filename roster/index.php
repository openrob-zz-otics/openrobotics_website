<?php
	require_once("../php_include/functions.php");
	require_once("../php_include/PHPExcel.php");
	require_once("../php_include/PHPExcel/Writer/Excel2007.php");
	session_start();
	check_login();

	if (!isLoggedIn() || !canManageUsers()) {
		//header("Location: /");
		exit();
	}

	$excel = new PHPExcel();

	$excel->getProperties()->setCreator("Jonathan Chapple");
	$excel->getProperties()->setLastModifiedBy("Ming Xu");
	$excel->getProperties()->setTitle("Open Robotics Team Roster");
	$excel->getProperties()->setSubject("Open Robotics Team Roster");
	$excel->getProperties()->setDescription("Open Robotics Team Roster.");

	$excel->setActiveSheetIndex(0);
	//Draw Column Headers
	$excel->getActiveSheet()->SetCellValue("A1", "Name");
	$excel->getActiveSheet()->SetCellValue("B1", "Email");
	$excel->getActiveSheet()->SetCellValue("C1", "Phone");
	$excel->getActiveSheet()->SetCellValue("D1", "Year");
	$excel->getActiveSheet()->SetCellValue("E1", "Major");
	$excel->getActiveSheet()->SetCellValue("F1", "Student Number");

	$db = get_db();

	$query = "SELECT * FROM `roster`;";

	$result = $db->query($query);
	$i = 1;
	while ($row = $result->fetch_assoc()) {
		$i++;
		$excel->getActiveSheet()->SetCellValue("A".$i, $row['name']);
		$excel->getActiveSheet()->SetCellValue("B".$i, $row['email']);
		$excel->getActiveSheet()->SetCellValue("C".$i, $row['phone']);
		$excel->getActiveSheet()->SetCellValue("D".$i, $row['year']);
		$excel->getActiveSheet()->SetCellValue("E".$i, $row['major']);
		$excel->getActiveSheet()->SetCellValue("F".$i, $row['student_number']);
	}

	$excel->getActiveSheet("Open Robotics Team Roster");

	$file = "roster.xlsx";

	$writer = new PHPExcel_Writer_Excel2007($excel);
	$writer->save($file);
 	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);

	ignore_user_abort(true);
	if (connection_aborted()) {
		//unlink($file);
	}
	//unlink($file);
?>