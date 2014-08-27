<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Projects</h2>	
		</div>
	</div>
<?php
	if (!canAddProjects() && !canManageAllProjects()) {
		echo '<div class="row"><div class="col-md-12"><h3>You do not have permission to be here.</h3></div></div>';
	} else {
		echo '<div class="row">
		<div class="col-md-4">
			<a href="project?id=0"><button class="btn btn-default">New Project</button></a>
		</div>
		<div class="col-md-8">
		<p>Edit Existing Projects</p>
		<ul>';
		
			if ($db = get_db()) {
				$query;
				if (canManageAllProjects()) {
					$query = "SELECT * FROM `projects`;";
				} else {
					$query = "SELECT * FROM `projects` WHERE `created_by`='$user_id` OR `id` IN (SELECT `project_id` FROM `project_contributors` WHERE `user_id`='$user_id');";
				}	
				if ($result = $db->query($query)) {
					while ($row = $result->fetch_assoc()) {
						echo "<li><a href='project?id=".$row['id']."'>".$row['name'].' - '.$row['start_time'].' - '.$row['finish_time']."</a></li>";
					}	
				}
				$db->close();
			}
		
		echo '</ul>
		</div>
	</div>';
	}
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>