<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "post";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">

	<?php
		$id = intval(@$_GET['id']);
		if ($db = get_db()) {
			$query = "SELECT * FROM `training_posts` WHERE `visible`='1' AND `is_disabled`='0' AND `id`='$id';";
			if ($result = $db->query($query)) {
				if ($result->num_rows < 1) {
					echo '<div class="row"><div class="col-sm-12"><h3 class="text-danger">Invalid ID!</h3></div></div>';
				} else {
					if ($row = $result->fetch_assoc()) {
						$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."';";
						$asoc = $db->query($query)->fetch_assoc();
						$name = $asoc['first_name'].' '.$asoc['last_name'];
					
						echo '<div class="row">';
						echo '  <div class="col-sm-2"></div>';
						echo '	<div class="col-sm-8">';
						echo '		<h3>'.$row['title'].'</h3>';
						echo '		<h4>'.$row['sub_title'].'</h4>';
						echo '		<h5>Published At '. $row['publish_time']. '</h5>';//, By <a href="/contact/user?id='.$row['created_by'].'">'.$name.'</a></h5>';
						//echo '		>';
						if (isLoggedIn() == true) { 
							$query = "SELECT * FROM `training_completion` WHERE `user_id`='$user_id' AND `training_id`='$id';";
							$result = $db->query($query);
							if ($result->num_rows > 0) 
								$checked = 'checked';
							else
								$checked = '';
							echo '<div class="checkbox">
							    <label>
							    <input type="checkbox" id="check_completed" '.$checked.'> Completed
							    </label>
							  	</div>';						
						}
						echo '		<hr>';
						echo '		<span id="disp-content">'.$row['content'].'</span>';
						echo '	</div>';
						echo '</div>';
					}
				}
			}					
			$db->close();
		} else {
			echo "<p>DB Error.</p>";
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
