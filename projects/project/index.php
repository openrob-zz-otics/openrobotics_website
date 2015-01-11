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

						//since we are iterating across all contributors now, copy the needed data 
						//so we don't have to access db again
						$contributor_ids = array();
						$first_name_array = array();
						$last_name_array = array();

						//get the list of contributors (including who created project. grab the data and check if current user can manager the project)
						$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id`='".$project_data['created_by']."' OR `id` IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
						if ($result2 = $db->query($query)) {
							while ($contributor_data = $result2->fetch_assoc()) {
								array_push($contributor_ids, $contributor_data['id']);
								array_push($first_name_array, $contributor_data['first_name']);
								array_push($last_name_array, $contributor_data['last_name']);
								if ($contributor_data['id'] == $user_id && canAddProjects())
									$has_perms = true;
							}
						}

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