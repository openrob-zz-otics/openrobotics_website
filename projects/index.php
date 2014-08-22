<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name);
	print_navbar();
?>
<div class="container">

	<h2>Projects</h2>
	
	<h3>Featured Projects</h3>
	<?php
		if($db = get_db()) {
			$query = "SELECT * FROM `projects` WHERE `is_featured`='1' AND `visible`='1';";
			if ($result = $db->query($query)) {
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";
			}
		}
	?>
	
	<br />
	<h3>All Projects</h3>
	
	<?php
		if($db) {
			$query = "SELECT * FROM `projects` WHERE `visible`='1';";
			if ($result = $db->query($query)) {
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";
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