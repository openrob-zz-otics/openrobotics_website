<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "project";
	print_header($page_name);
	print_navbar();
?>
<div class="container">

	<?php
		$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if (!$project_id) {
			echo "<h2>Invalid Project ID</h2>";
		} else if ($db = get_db()) {
			$query = "SELECT * FROM `projects` WHERE `id`='$project_id';";
			if ($result = $db->query($query)) {
				if ($row = $result->fetch_assoc()) {
					echo json_encode($row);
				}
			}
			$db->close();
		}
	?>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>