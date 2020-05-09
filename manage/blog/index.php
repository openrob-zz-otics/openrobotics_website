<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "blog";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="subcontent">
			<h2>Manage Blog</h2>
		<div>
	</div>
<?php
if (!canAddBlogPost() && !canManageAllBlogPosts()) {
	echo '<div class="row"><div class="subcontent"><h3>You do not have permission to be here</h3></div></div>';
} else {
	echo '
	<div class="row">
		<div class="subcontent">		
			<div class="col-sm-4">
				<a href="post?id=0"><button class="btn btn-default">New Post</button></a>
			</div>
			<div class="col-sm-8">
				<p>Edit Past Posts</p>
				<ul class="list">';
					if ($db = get_db()) {
						$query;
						if (canManageAllBlogPosts()) {
							$query = "SELECT * FROM `blog_posts` WHERE `is_disabled`='0' ORDER BY `publish_time` DESC;";
						} else {
							$query = "SELECT * FROM `blog_posts` WHERE `created_by`='$user_id' AND `is_disabled`='0' ORDER BY `publish_time` DESC;";
						}
						if ($result = $db->query($query)) {
							while ($row = $result->fetch_assoc()) {
								echo "<li><a href='/manage/blog/post?id=".$row['id']."'>";
								echo $row['title'].' - '.$row['publish_time'];
								echo "</li>";
							}
						}
						$db->close();
					}
				echo '
				</ul>
			</div>
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