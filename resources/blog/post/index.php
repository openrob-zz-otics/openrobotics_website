<?php
	//include our library and start drawing the page
	require_once("../../../php_include/functions.php");
	$page_name = "post";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">

	<?php
		$id = intval(@$_GET['id']);
		if ($db = get_db()) {
			//get data about current blod post
			$query = "SELECT * FROM `blog_posts` WHERE `visible`='1' AND `is_disabled`='0' AND `id`='$id';";
			if ($result = $db->query($query)) {
				//check that we got data
				if ($result->num_rows < 1) {
					echo '<div class="row mtt-content"><div class="col-sm-12"><h3 class="text-danger">Invalid ID!</h3></div></div>';
				} else {
					//print the blog post
					if ($row = $result->fetch_assoc()) {
						$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."';";
						$asoc = $db->query($query)->fetch_assoc();
						$name = $asoc['first_name'].' '.$asoc['last_name'];
					
						echo '<div class="row mtt-content">';
						echo '  <div class="col-sm-2"></div>';
						echo '	<div class="col-sm-8">';
						echo '		<h3>'.$row['title'].'</h3>';
						echo '		<h4>'.$row['sub_title'].'</h4>';
						echo '		<h5>Published At '.$row['publish_time']. ', By <a href="/contact/user?id='.$row['created_by'].'">'.$name.'</a></h5>';
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