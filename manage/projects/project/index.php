<?php
	//include our library and start drawing the page
	require_once("../../../php_include/functions.php");
	$page_name = "manage_project";
	print_header($page_name, true);
	print_navbar();
?>




<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Project</h2>	
		</div>
	</div>
	<?php
	
		$db = get_db();
		$project_id = intval(@$_GET['id']);
		
		if (!(canManageAllProjects() || canAddProjects())) {
			echo '<div class="row"><div class="col-md-12"><h3 class="text-warning">You do not have permission to be here</h3></div></div>';
				print_footnote();
				echo "</div>";
				print_footer();
				exit();
		}
	
		if ($project_id == 0 && (canManageAllProjects() || canAddProjects())) {
			if ($db) {
				$now = date("Y-m-d");
				$query = "INSERT INTO `projects` (`created_by`, `start_time`) VALUES ('$user_id', '$now');";
				if ($db->query($query)) {
					$project_id = $db->insert_id;
					$db->close();
					echo '<script>location.replace("?id='.$project_id.'");</script>';
				}
			}
		} else if (!canManageAllProjects()) {
			$query = "SELECT `id` FROM `project_contributors` WHERE `user_id`='$user_id' AND `project_id`='$project_id';";
			$db->query($query);
			$allow = true;
			if (@$db->num_rows < 1) {
				$allow = false;
			} else {
				$query = "SELECT `id` FROM `projects` WHERE `user_id`='$user_id' AND `id`='$project_id';";
				$db->query($query);				
				if (@$db->num_rows < 1) {
					$allow = false;
				}
			}

			if (!$allow) {
				echo '<div class="row"><div class="col-md-12"><h3 class="text-warning">You do not have permission to be here</h3></div></div>';
				print_footnote();
				echo "</div>";
				print_footer();
				exit();
			}
		}
		
		$query = "SELECT * FROM `projects` WHERE `id`='$project_id';";
		
		$result = $db->query($query);
		$project_data = $result->fetch_assoc();
		$display_type = $project_data['display_type'];

		if ($result->num_rows < 1) {
			echo '<div class="row"><div class="col-md-12"><h3 class="text-danger">ID Invalid!</h3></div></div>';
			print_footnote();
			echo "</div>";
			print_footer();
			exit();
		}
	?>
	<div class="row">
		<div class="col-md-6">
			<p id="error-message"></p>
						
			<div class="row">
				<div class="col-md-8">
				
					<div class="checkbox">
						<label>
							<input type="checkbox" id="form_visible" <?php if($project_data['visible']=='1')echo "checked";?>> Make Project Visible
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="form_featured" <?php if(!canManageAllProjects())echo "disabled";?> <?php if($project_data['is_featured']=='1')echo "checked";?>> Featured Project
						</label>	
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="form_is_upcoming_project" <?php if($project_data['is_upcoming_project']) echo "checked";?>> Upcoming Project
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<a href="/projects/project?id=<?php echo $project_id;?>"><button class="btn btn-default">View Project</button></a>
				</div>
			</div>
			<div class="form-group">
				<label for="form_start_time">Project Start Date</label>
				<input type="text" class="form-control" id="form_start_time" value="<?php echo $project_data['start_time'];?>">
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_finished_project" <?php if(isset($project_data['finish_time']))echo "checked";?>> Finished Project
				</label>
			</div>
			<div class="form-group">
				<label for="form_finish_time">Project End Date</label>
				<input type="text" class="form-control" id="form_finish_time" value="<?php echo $project_data['finish_time'];?>" <?php if(!isset($project_data['finish_time']))echo "disabled";?>>
			</div>
			<div class="form-group">
				<label for="form_name">Name</label>
				<input type="text" class="form-control" id="form_name" placeholder="Name" value="<?php echo $project_data['name'];?>">
			</div>
			<label>Display Type
				<span id="display_what_is" class="text-danger" data-togger="popover" 
					data-content="There are multiple ways of displaying a project page. 
					Select the one that best suits your content.<br /><br />
					<ol>
						<li>Display the description in a skinny column on the left while displaying uploaded images on the left, one on top of the other. Best for just one or a few images.</li><br />
						<li>Display the entire description in full page width, with the images in a grid underneath. Best for lots of images</li>
					</ol>">
				<strong><em>What is this?</em></strong>
				</span>
			</label>
			<select class="form-control" id="form_display_type">
				<option value="1" <?php if ($display_type==1) echo "selected";?>>1. Images on right.</option>
				<option value="2" <?php if ($display_type==2) echo "selected";?>>2. Images on grid below.</option>
			</select><br />
			<div class="form-group">
				<label for="form_description">Description/Write Up</label>
				<textarea rows="10" class="form-control" id="form_description" placeholder="Description"><?php echo $project_data['description'];?></textarea>
			</div>
			<button class="btn btn-default" id="form_submit">Update</button><br /><br />
			<button class="btn btn-default" data-container="body" id="delete-popover">Delete</button><br /><br />
		</div>		
		<div class="col-md-6">
			<p>
				Project Founded By:
				<span id="created_by" style="font-weight:bold">
				<?php
					if ($db) {
						$query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id` IN (SELECT `created_by` FROM `projects` WHERE `id`='$project_id');";
						if ($result = $db->query($query)) {
							if ($row = $result->fetch_assoc()) {
								echo $row['first_name'].' '.$row['last_name'];
							}
						}					
					}
				?>
				</span>
			</p>
			<label>
				Hand Over Project
			</label>
			<div class="row">
				<div class="col-md-8">
					<select class="form-control" id="hand_over">
						<?php
							if ($db) {
								$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id`!='1' AND `id` NOT IN (SELECT `created_by` FROM `projects` WHERE `id`='$project_id');";
								if ($result = $db->query($query)) {
									while ($row = $result->fetch_assoc()) {
										echo '<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									}
								}
							}
						?>
					</select>
				</div>
				<div class="col-md-4">
					<button class="btn btn-default" id="btn_hand_over">Hand Over</button><br />
				</div>
			</div>
			<br />
			<p class="visible-lg visible-md">Contributors<br />All Users are listed on the left. Add those who are involved in this project to the right.</p>
			<p class="hidden-lg hidden-md">Contributors<br />All Users are listed on the top. Add those who are involved in this project to the bottom. (On mobiles, tap to bring up selection), then press the arrows.</p>
			<div class="row">
				<div class="col-md-4">
					<select multiple class="form-control" id="select-left">
					<?php
						if ($db) {
							$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id`!='1' AND `id` NOT IN (SELECT `user_id` FROM `project_contributors` WHERE `project_id`='$project_id');";
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
					<select multiple class="form-control" id="select-right">
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
			<br />
			<div class="checkbox">
				<label>
					<input type="checkbox" id="form_hide_main_picture" <?php if($project_data['hide_main_picture'])echo "checked";?>> Hide main project photo from project page <br />(only show it on featured projects slideshow)
				</label>
			</div>
			<p>Main Picture<p>
			<span class="btn btn-default fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Upload...</span>
				<input id="main_image_upload" type="file" name="file" data-url="/manage/projects/project/assets/cgi/project.php?task=2">
			</span>
			<br />
			<br />
			<div id="main_image_upload_progress" class="progress">
				<div class="progress-bar progress-bar-striped active"></div>
			</div>
			
			<br />
			
			<p>Addition Pictures: (You can add multiple)<p>
			<span class="btn btn-default fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Upload...</span>

				<input id="additional_image_upload" type="file" name="files[]" data-url="/manage/projects/project/assets/cgi/project.php?task=3" multiple>
			</span>
			<br />
			<br />
			<div id="additional_image_upload_progress" class="progress">
				<div class="progress-bar progress-bar-striped active"></div>
			</div>
			
			
		</div>
	</div>
	<br />
	<br />
	<div id="manage_images">
	<?php
	if (file_exists("../../../upload_content/project_images/$project_id/")) {
		$array = scandir("../../../upload_content/project_images/".$project_id."/");
		foreach ($array as $val) {
			$var = explode('.', $val);
			$ext = strtolower(array_pop($var));
			if ($ext == "png" || $ext == "jpg") {
				echo "<div class='row'><div class='col-md-6'><img class='img-responsive img-thumbnail' src='/upload_content/project_images/$project_id/$val'></div>
				<div class='col-md-6'><button class='btn btn-danger image_delete' data-file='$val'>Delete</button></div></div><br /><br />";
			}
		}
	}
	?>
	</div>
	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>