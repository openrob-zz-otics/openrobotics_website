<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "blog";
	print_header($page_name);
	print_navbar();
	if (!isLoggedIn()) {
		header("Location: /");
	}
?>

<!-- REMEMBER TO LOCK VIA PERMISSONS -->

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Blog</h2>
		<div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<p class="text-danger" id="status_message"></p>
			<div class="form-group">
				<label for="form_title">Title</label>
				<input type="text" class="form-control" placeholder="Title" id="form_title">
			</div>
			<div class="form-group">
				<label for="form_subtitle">Subtitle</label>
				<input type="text" class="form-control" placeholder="Subtitle" id="form_subtitle">
			</div>
			<div class="form-group">
				<label for="form_content">Content (You can input html!)</label>
				<textarea class="form-control" placeholder="Content" rows="5" id="form_content"></textarea>
			</div>
			<button class="btn btn-default" id="form_submit">Post To Blog</button>
			<button class="btn btn-default" id="form_delete" disabled>Delete Post</button><br /><br />
			<p>Click here to reset the form and return to add-post mode.</p>
			<button class="btn btn-default" id="reset_form">Reset</button>
		</div>
		<div class="col-md-4">
			<p>Edit Past Posts (refresh page to see newly added)</p>
			<ul class="list">
			<?php
				if ($db = get_db()) {
					$query;
					if (canManageAllBlogPosts()) {
						$query = "SELECT * FROM `blog_posts` ORDER BY `publish_time` DESC;";
					} else {
						$query = "SELECT * FROM `blog_posts` WHERE `created_by`='$user_id' ORDER BY `publish_time` DESC;";
					}
					if ($result = $db->query($query)) {
						while ($row = $result->fetch_assoc()) {
							echo "<li><a href='#' class='edit' data-id='".$row['id']."'>";
							echo $row['title'].' - '.$row['publish_time'];
							echo "</li>";
						}
					}
					$db->close();
				}
			?>
			</ul>
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