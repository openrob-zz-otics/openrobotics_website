<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "user";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
		<?php
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			if (!$id) {
				echo "<h2>Invalid User ID</h2>";
			} else if ($db = get_db()) {
				$query = "SELECT * FROM `user_info` WHERE `id` IN (SELECT `id` FROM `users` WHERE `id`='$id' AND `is_disabled`='0');";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {
						echo '<div class="row"><div class="col-sm-4"></div><div class="col-sm-8"><h3>'.$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'].'</h3></div></div>';
						echo '<div class="row">';
						echo '<div class="col-sm-4">';
						echo '	<img src=';
						if (file_exists('../../upload_content/user_images/'.$row['id'].'.png')) {
							echo '"/upload_content/user_images/'.$row['id'].'.png"';
						} else {
							echo '"/assets/images/default_profile.png" width="150"';
						}
						echo ' alt="'.$row['first_name'].' '.$row['last_name'].'" class="img-responsive img-thumbnail">';
						$query = "SELECT `id`, `name` FROM `projects` WHERE `visible`='1' AND `is_disabled`='0' AND (`created_by`='".$row['id']."' OR `id` IN (SELECT `project_id` FROM `project_contributors` WHERE `user_id`='".$row['id']."'));";
						echo '<br /><br /><p>Involved with the following projects:</p><ul>';
						if ($result2 = $db->query($query)) {
							while ($row2 = $result2->fetch_assoc()) {
								echo "<li><a href='/projects/project?id=".$row2['id']."'>";
								echo $row2['name']."</a></li>";
							}
						}
						
						echo '</ul></div>';
						echo '<div class="col-sm-8">';
						if ($row['open_robotics_position']!="")
							echo "<p>Position: ".$row['open_robotics_position']."</p>";
						if ($row['education']!="")
							echo "<p>Education: ".$row['education']."</p>";
						if ($row['employment']!="")
							echo "<p>Employment: ".$row['employment']."</p>";
						if ($row['contact_email']!="")
							echo '<p>Contact Email: <a href="mailto:"'.$row['contact_email'].'">'.$row['contact_email'].'</a></p>';
						if ($row['linkedin']!="")
							echo '<p><a href="'.$row['linkedin'].'">LinkedIn</a></p>';
						if ($row['personal_site']!="")
							echo '<p><a href="'.$row['personal_site'].'">Personal Site</a></p>';
						if ($row['bio']!="")
							echo '<p>'.$row['bio'].'</p>';	

						// echo '<h3>Badges:</h3>';
						// echo '<div class="row">';
						// $query = "SELECT `badge_id` FROM `user_badges` WHERE `user_id`='$id' AND `badge_id` IN (SELECT `id` FROM `badges` WHERE `visible`='1' AND `is_disabled`='0');";
						// if ($result2 = $db->query($query)) {
						// 	while ($row2 = $result2->fetch_assoc()) {
						// 		echo '<div class="col-sm-2"><a href="/badge?id='.$row2['badge_id'].'">
						// 		<img class="img-responsive" src="/upload_content/badge_images/small/'.$row2['badge_id'].'.png"></a></div>';
						// 	}
						// }
						// echo '</div>';
						//echo '<div class="col-sm-3"></div><div class="col-sm-3"></div><div class="col-sm-3"></div>';
						echo '</div></div>';
					} else {
						echo '<h2>Invalid User ID</h2>';
					}
				}
				$db->close();
			}
		?>
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>