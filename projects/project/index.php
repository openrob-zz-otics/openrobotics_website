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
				$query = "SELECT * FROM `projects` WHERE `id`='$project_id';";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {
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
			<div class="col-md-4">
		<?php
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
					}
				}
				$db->close();
			}
		?>		
		</div>
		<div class="col-md-8">
		<?php
			if (file_exists("../../upload_content/project_images/".$project_id."/")) {
				$array = scandir("../../upload_content/project_images/".$project_id."/");
				foreach ($array as $val) {
					$ext = strtolower(array_pop(explode('.', $val)));
					if ($ext == "png" || $ext == "jpg") {
						echo "<img class='img-responsive img-thumbnail' src='/upload_content/project_images/".$project_id."/$val'>";
					}
				}
			}
		?>
		</div>
	</div>
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>