<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "training";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Training</h2>
		<div>
	</div>
<?php
if (!canAddBlogPost() && !canManageAllBlogPosts()) {
	echo '<div class="row"><div class="col-md-12"><h3>You do not have permission to be here</h3></div></div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4">
			<a href="post?id=0"><button class="btn btn-default">New Post</button></a>
		</div>
		<div class="col-sm-8">
			<p>Edit Past Posts</p>
			<ul class="list">';
				if ($db = get_db()) {
					$query;
					if (canManageAllBlogPosts()) {
						$query = "SELECT * FROM `training_posts` WHERE `is_disabled`='0' ORDER BY `publish_time` DESC;";
					} else {
						$query = "SELECT * FROM `training_posts` WHERE `created_by`='$user_id' AND `is_disabled`='0' ORDER BY `publish_time` DESC;";
					}
					if ($result = $db->query($query)) {
						while ($row = $result->fetch_assoc()) {
							echo "<li><a href='/manage/training/post?id=".$row['id']."'>";
							echo htmlspecialchars($row['title']).' - '.$row['publish_time'];
							echo "</li>";
						}
					}
					$db->close();
				}
			echo '
			</ul>
		</div>
	</div>';

}
print_footnote();
?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>
