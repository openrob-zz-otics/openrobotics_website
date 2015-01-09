<?php
	//include our library and start drawing the page
	require_once("../../../php_include/functions.php");
	$page_name = "post";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Blog Post</h2>
		<div>
	</div>
<?php	
	$db = get_db();
	$post_id = intval(@$_GET['id']);
	
	if (!(canManageAllBlogPosts() || canAddBlogPost())) {
		echo '<div class="row"><div class="col-md-12"><h3 class="text-warning">You do not have permission to be here</h3></div></div>';
			print_footnote();
			echo "</div>";
			print_footer();
			exit();
	}

	if ($post_id == 0 && (canManageAllBlogPosts() || canAddBlogPost())) {
		if ($db) {
			$now = date("Y-m-d H:i:s");
			$query = "INSERT INTO `blog_posts` (`created_by`, `publish_time`) VALUES ('$user_id', '$now');";
			if ($db->query($query)) {
				$post_id = $db->insert_id;
				$db->close();
				echo '<script>location.replace("?id='.$post_id.'");</script>';
			}
		}
	} else if (!canManageAllBlogPosts()) {
		$query = "SELECT `id` FROM `blog_posts` WHERE `created_by`='$user_id' AND `id`='$post_id';";
		$db->query($query);				
		if (@$db->num_rows < 1) {
			$allow = false;
		}		

		if (!$allow) {
			echo '<div class="row"><div class="col-md-12"><h3 class="text-warning">You do not have permission to be here</h3></div></div>';
			print_footnote();
			echo "</div>";
			print_footer();
			exit();
		}
	}
	
	$query = "SELECT * FROM `blog_posts` WHERE `id`='$post_id';";
	
	$result = $db->query($query);
	$post_data = $result->fetch_assoc();

	if ($result->num_rows < 1) {
		echo '<div class="row"><div class="col-md-12"><h3 class="text-danger">Invalid ID!</h3></div></div>';
		print_footnote();
		echo "</div>";
		print_footer();
		exit();
	}
?>
	<div class="row">
		<div class="col-md-8">
			<p id="status_message"></p>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_visible" <?php if (@$post_data['visible'])echo 'checked'?>>
					Make Post Visible
				</label>
			</div>
			<div class="form-group">
				<label for="form_title">Title</label>
				<input type="text" class="form-control" placeholder="Title" id="form_title" value="<?php echo @$post_data['title'];?>">
			</div>
			<div class="form-group">
				<label for="form_subtitle">Subtitle (optional)</label>
				<input type="text" class="form-control" placeholder="Subtitle" id="form_subtitle" value="<?php echo @$post_data['sub_title'];?>">
			</div>
			<div class="form-group">
				<label for="form_short_desc">Short Description</label>
				<textarea class="form-control" placeholder="Write a short description that will show up on the list of blog posts" rows="3" id="form_short_desc"><?php echo @$post_data['short_desc'];?></textarea>
			</div>
			<div class="form-group">
				<label for="form_content">Content (You can input html!)</label>
				<textarea class="form-control" placeholder="Content" rows="5" id="form_content"><?php echo @$post_data['content'];?></textarea>
			</div>
			<button class="btn btn-default" id="form_submit">Update</button><br /><br />

			<button class="btn btn-default" id="form_delete">Delete Post</button><br /><br />
		</div>
		<div class="col-md-4">
			<a href="/blog/post?id=<?php echo $post_id;?>"><button class="btn btn-primary">View Post</button></a>
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