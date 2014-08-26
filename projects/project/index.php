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
		?>
		<div class="row">
			<div class="col-md-12">
				<h2>
		<?php
						echo $row['name'];
		?>
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
		<?php
						$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."';";
						if ($result2 = $db->query($query)) {
							if ($row2 = $result2->fetch_assoc()) {
								echo "<p><a href='/contact/user?id='".$row['created_by']."' >";
								echo $row2['first_name'].' '.$row2['last_name']."</a></p>";
							}
						}
						echo "<p>Started: ".$row['start_time']."<br />";
						if (isset($row['finish_time'])) {
							echo "Finished: ".$row['finish_time']."</p>";
						} else {
							echo "Ongoing project</p>";
						}
						
						echo "<p>".$row['description']."</p>";
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
					$ext = array_pop(explode('.', $val));
					if ($ext == "png" || $ext == "jpg") {
						echo "<img style='max-width:500px;' src='/upload_content/project_images/".$project_id."/$val'>";
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