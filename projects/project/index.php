<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "project";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
		<?php
			//get project id and check if it is valid.
			$project_id = @intval($_GET['id']);
			if (!$project_id) {
				echo "<h2>Invalid Project ID</h2>";
			} else if ($db = get_db()) {
				//get the current project information from the database
				$query = "SELECT * FROM `projects` WHERE `id`='$project_id' AND `is_disabled`='0';";
				if ($result = $db->query($query)) {
					if ($project_data = $result->fetch_assoc()) {

						//check whether or not the current user has rights to manage the user
						$has_perms = ($user_id == $project_data['created_by']) || canManageAllProjects();

						//if the user has permissions they can see even if it is invisible (eg. while writing)
						if ($project_data['visible'] || $has_perms) {
							//include the relevant style page to draw the project
							include("assets/styles/".$project_data['display_type'].".php");
						} else {
							//pretend it is invalid project 
							echo "<h2 class='text-danger'>Invalid Project ID</h2>";
						}
				}
				$db->close();
			}
		}
		
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>