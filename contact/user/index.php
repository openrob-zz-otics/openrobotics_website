<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "user";
	print_header($page_name);
	print_navbar();
?>
<div class="container">
	<div class="row">
		<?php
			$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			if (!$user_id) {
				echo "<h2>Invalid User ID</h2>";
			} else if ($db = get_db()) {
				$query = "SELECT * FROM `user_info` WHERE `id`='$user_id';";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {
						echo '<div class="col-md-4">';
						echo '	<img src="/upload_content/user_images/'.$user_id.'.png" alt="'.$row['first_name'].' '.$row['last_name'].'" class="img-responsive img-thumbnail">';
						echo '</div>';
						echo '<div class="col-md-8">';
						echo "<h3>".$row['first_name'].' '.$row['middle_name'].' '.$row['last_name']."</h3>";
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
					}
				}
				$db->close();
			}
		?>
		</div>
	</div>
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>