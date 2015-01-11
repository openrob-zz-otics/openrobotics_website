<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "project";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
		<?php
			$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


			
			if (!$project_id) {
				echo "<h2>Invalid Project ID</h2>";
			} else if ($db = get_db()) {
				$query = "SELECT * FROM `projects` WHERE `id`='$project_id' AND `is_disabled`='0';";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {

						$has_perms = ($user_id == $row['created_by']) || canManageAllProjects();

						$query = "SELECT `id` FROM `user_info` WHERE `id`='".$row['created_by']."' OR `id` IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
						//echo $query;
						if ($result2 = $db->query($query)) {
							while ($row2 = $result2->fetch_assoc()) {
								if ($row2['id'] == $user_id && canManageProjects())
									$has_perms = true;
							}
						}

						if ($row['visible'] || $has_perms) {

		?>
		<div class="row">
			<div class="col-md-12">
				<h1>
		<?php
						echo $row['name'];
		?>
				</h1>
			</div>
		</div>
		<div class="row">
		<?php
		$display_type = $row['display_type'];
		
		if ($display_type == 0)
			echo '<div class="col-md-4">';
		else if ($display_type == 2)
			echo '<div class="col-md-12">';

						$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."' OR `id` IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
						//echo $query;
						if ($result2 = $db->query($query)) {
							echo "<h4>Contributors:</h4><ul class='list'>";
							while ($row2 = $result2->fetch_assoc()) {
								echo "<li><a href='/contact/user?id=".$row2['id']."' >";
								echo $row2['first_name'].' '.$row2['last_name']."</a></li>";
							}
							echo "</ul>";
						}
						

						echo "<p>Started: ".$row['start_time']."<br />";
						if (isset($row['finish_time'])) {
							echo "Finished: ".$row['finish_time']."</p>";
						} else {
							echo "Ongoing project</p><hr>";
						}
						

						echo "<span class='disp-content'>".$row['description']."</span>";

						echo "</div>";
						if ($display_type == 0)
							echo '<div class="col-md-8">';
						else if ($display_type == 1)
							echo '<div class="row">';
	
						$counter = 0;

						if (file_exists("../../upload_content/project_images/".$project_id."/")) {
							$array = scandir("../../upload_content/project_images/".$project_id."/");
							foreach ($array as $val) {
								$ext = strtolower(array_pop(explode('.', $val)));
								if ($ext == "png" || $ext == "jpg") {

									if ($display_type == 1) 
										echo '<div class="col-md-3">';
									
									echo "<img class='img-responsive img-thumbnail' src='/upload_content/project_images/".$project_id."/$val'>";

									if ($display_type == 1) {
										echo '</div>';
										if ($counter++ == 3) {
											//echo '</div><div class="row">';
											$counter=0;
										}
									}
								}
							}
						}
						echo "</div>";
						if ($display_type == 0)
							echo "</div>";
					
					} else {
						echo "<h2 class='text-danger'>Invalid Project ID</h2>";
					}
				}
				$db->close();
			}
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