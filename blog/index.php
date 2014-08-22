<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "blog";
	print_header($page_name);
	print_navbar();
?>
<div class="container">

	<?php
		$limit = 5;
		$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
		if ($db = get_db()) {
			$query = "SELECT * FROM `blog_posts` WHERE `visible`='1' ORDER BY `publish_time` DESC LIMIT $offset,$limit;";
			$index = 0;
			if ($result = $db->query($query)) {
				while ($row = $result->fetch_assoc()) {
					$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='".$row['created_by']."';";
					$asoc = $db->query($query)->fetch_assoc();
					$name = $asoc['first_name'].' '.$asoc['last_name'];
				
					echo '<div class="row">';
					echo '	<div class="col-lg-8">';
					if($index > 0) 
						echo '<hr>';
					echo '		<h3>'.$row['title'].'</h3>';
					echo '		<h4>'.$row['sub_title'].'</h4>';
					echo '		<h5>Published At '.$row['publish_time']. ', By <a href="/contact/user?id='.$row['created_by'].'">'.$name.'</a></h5>';
					echo '		<hr>';
					echo '		<p>'.$row['content'].'</p>';
					echo '	</div>';
					echo '</div>';
					$index++;
				}
				if ($index >= $limit) {
					echo '<div class="row">';
					echo '	<div class="col-lg-8">';
					echo '	<span style="float:right;"><a href="?offset='.($offset+5).'"><button type="button" class="btn btn-default btn-sm">Older Posts&raquo;</button></a></span>';
					echo '	</div>';
					echo '</div>';
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