<?php
	//include our library and start drawing the page
	require_once("../../../php_include/functions.php");
	$page_name = "manage_project";
	print_header($page_name, true);
	print_navbar();
?>

<!-- REMEMBER TO LOCK VIA PERMISSONS -->

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Project</h2>	
		</div>
	</div>
	<?php
		$project_id = intval(@$_GET['id']);
		$db = get_db();
		if ($project_id == 0) {
			if ($db) {
				$now = date("Y-m-d");
				$query = "INSERT INTO `projects` (`created_by`, `start_time`) VALUES ('$user_id', '$now');";
				if ($db->query($query)) {
					$project_id = $db->insert_id;
					echo '<script>location.replace("?id='.$project_id.'");</script>';
				}
			}
		}
		
		$query = "SELECT * FROM `projects` WHERE `id`='$project_id';";
		
		$project_data = $db->query($query)->fetch_assoc();
		
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_visible" <?php if($project_data['visible']=='1')echo "checked";?>> Make project visible
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_featured" <?php if(!canManageAllProjects())echo "disabled";?> <?php if($project_data['is_featured']=='1')echo "checked";?>> Feature Project
				</label>	
			</div>
			<div class="form-group">
				<label for="form_start_time">Project Start Date</label>
				<input type="text" class="form-control" id="form_start_time" value="<?php echo $project_data['start_time'];?>">
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_finished_project"> Finished Project
				</label>
			</div>
			<div class="form-group">
				<label for="form_finish_time">Project End Date</label>
				<input type="text" class="form-control" id="form_finish_time" value="<?php echo $project_data['finish_time'];?>">
			</div>
			<div class="form-group">
				<label for="form_name">Name</label>
				<input type="text" class="form-control" id="form_name" placeholder="Name" value="<?php echo $project_data['name'];?>">
			</div>
			<div class="form-group">
				<label for="form_description">Description/Write Up</label>
				<textarea rows="10" class="form-control" id="form_description" placeholder="Description"><?php echo $project_data['description'];?></textarea>
			</div>
			<button class="btn btn-default" id="form_submit">Update</button>
			<button class="btn btn-default" id="form_delete">Delete</button><br /><br />
		</div>		
		<div class="col-md-6">
			<p>Contributors<br />All Users are listed on the left. Add those who are involved in this project to the right.</p>
			<div class="row">
				<div class="col-md-4">
					<select multiple class="form-control" style="height:250px">
					<?php
						if ($db) {
							$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id`!='$user_id' AND `id` NOT IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
							if ($result = $db->query($query)) {
								while ($row = $result->fetch_assoc()) {
									echo "<option value='".$row['id']."'>".$row['first_name'].' '.$row['last_name']."</option>";
								}	
							}								
						}
					?>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-default" id="contributor-right"><span class="visible-lg visible-md glyphicon glyphicon-arrow-right"></span><span class="hidden-lg hidden-md glyphicon glyphicon-arrow-down"></span></button><br />
					<button class="btn btn-default" id="contributor-left"><span class="visible-lg visible-md glyphicon glyphicon-arrow-left"></span><span class="hidden-lg hidden-md glyphicon glyphicon-arrow-up"></span></button>
				</div>
				<div class="col-md-4">
					<select multiple class="form-control" style="height:250px">
					<?php
						if ($db) {
							$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id` IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
							if ($result = $db->query($query)) {
								while ($row = $result->fetch_assoc()) {
									echo "<option value='".$row['id']."'>".$row['first_name'].' '.$row['last_name']."</option>";
								}
							}
							$db->close();
						}
					?>
					</select>
				</div>
			</div>
			<br />
			<form action="/manage/projects/project/assets/cgi/project.php?task=????" method="POST" enctype="multipart/form-data">
				<label for="file">Main Picture:</label>
				<input type="file" name="file" id="file" class="form-control"><br>
				<input type="submit" name="submit" value="Upload" class="btn btn-default">
			</form><br />
			<form action="/manage/projects/project/assets/cgi/project.php?task=????" method="POST" enctype="multipart/form-data">
				<label for="file">Addition Pictures: (You can add multiple)</label>
				<input type="file" name="file" id="file" class="form-control" multiple><br>
				<input type="submit" name="submit" value="Upload" class="btn btn-default">
			</form>
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