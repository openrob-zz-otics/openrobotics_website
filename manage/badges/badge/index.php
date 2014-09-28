<?php
	//include our library and start drawing the page
	require_once("../../../php_include/functions.php");
	$page_name = "badge";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>Manage Badge</h2>
		<div>
	</div>
<?php	
	$db = get_db();
	$badge_id = intval(@$_GET['id']);
	
	if (!(canManageUsers())) {
		echo '<div class="row"><div class="col-md-12"><h3 class="text-warning">You do not have permission to be here</h3></div></div>';
			print_footnote();
			echo "</div>";
			print_footer();
			exit();
	}

	$query = "INSERT INTO `openrobotics`.`badges` (`category`, `visible`) VALUES ('1', '0',);"
	if (!$db->query($query);) {
		echo '<div class="row"><div class="col-md-12"><h3 class="text-danger">DB Error. Sorry...</h3></div></div>';
		print_footnote();
		echo "</div>";
		print_footer();
		exit();
	}

	$query = "SELECT * FROM `badges` WHERE `id`='$badge_id';";
	
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
		<div class="col-sm-8">
			<p id="status_message"></p>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_visible" <?php if (@$post_data['visible'])echo 'checked'?>>
					Make Post Visible
				</label>
			</div>
			<div class="form-group">
				<label for="form_name">Name</label>
				<input type="text" class="form-control" placeholder="Name" id="form_name" value="<?php echo @$post_data['name'];?>">
			</div>
			<div class="form-group">
				<label for="form_difficulty">Difficulty</label>
				<input type="text" class="form-control" placeholder="Difficulty" id="form_difficulty" value="<?php echo @$post_data['difficulty'];?>">
			</div>
			<label>Category</label>
			<select class="form-control" id="form_category">
				<?php
					$query = "SELECT * FROM `badge_categories`;";
					$result2 = $db->query($query);
					while ($row2 = $result2->fetch_assoc()) {
						echo '<option data-id="'.$row2['id'].'">'.ucwords(strtolower($row2['category_name'])).'</option>';
					}
				?>
				<option data-id="0">New Category</option>
			</select><br />

			<div class="form-group">
				<label for="form_description">Description</label>
				<textarea class="form-control" placeholder="Description" rows="5" id="form_description"><?php echo @$post_data['description'];?></textarea>
			</div>
			<div class="form-group">
				<label for="form_instructions">Instructions</label>
				<textarea class="form-control" placeholder="Instructions" rows="5" id="form_instructions"><?php echo @$post_data['instructions'];?></textarea>
			</div>
			<button class="btn btn-default" id="form_submit">Update</button><br /><br />

			<button class="btn btn-default" id="delete_popover">Delete Post</button><br /><br />
		</div>
		<div class="col-sm-4">
			<a href="/badge?id=<?php echo $badge_id;?>"><button class="btn btn-primary">View Badge Page</button></a>
		</div>
	</div>

<?php
$db->close();
print_footnote();
?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>