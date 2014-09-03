<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "users";
	print_header($page_name, true);
	print_navbar();
	if (!isLoggedIn()) {
		header("Location: /");
	}
?>

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h2>Manage Users</h2>
			
			<?php
				if (!canManageUsers()) {
					echo '<h3>You do not have permissions to be here</h3>';
				} else {			
					if ($db = get_db()) {
						$query = "SELECT `id`, `email` FROM `users`;";
						if ($result = $db->query($query)) {
							echo '<p>Click on a user\'s row to get more settings. Note: Certain changes (eg. deleting users) may not become apparent until the page has been refreshed.</p>';
							echo '<table class="table table-hover table-bordered table-striped">';
							echo '<thead>';
							echo '<tr><th>Email</th><th>Name</th><th>Manage Users</th><th>Add Projects</th>';
							echo '<th>Manage All Projects</th><th>Add Blog Posts</th><th>Manage All Blog Posts</th>';
							echo '<th>In Contact List</th><th>Send Email</th><th>Update</th></tr>';
							echo '</thead>';
							echo '<tbody>';
							while ($row = $result->fetch_assoc()) {
								$id = $row['id'];
								$query = "SELECT * FROM `user_info` WHERE `id`='".$id."';";
								$info = $db->query($query)->fetch_assoc();
								$query = "SELECT * FROM `user_permissions` WHERE `id`='".$id."';";
								$permissions = $db->query($query)->fetch_assoc();
								echo '<tr data-id="'.$id.'" data-down="0" class="expand_tr" id="'.$id.'_perm_row">';
								echo '<td'.($id==$user_id?' style="font-weight:bold;"':'').'>'.$row['email'].'</td>';
								echo '<td>'.$info['first_name'].' '.$info['last_name'].'</td>';
								echo '<td><input type="checkbox"'.($permissions['manage_users']?'checked':'').' id="'.$id.'_manage_users" /></td>';
								echo '<td><input type="checkbox"'.($permissions['add_projects']?'checked':'').' id="'.$id.'_add_projects" /></td>';
								echo '<td><input type="checkbox"'.($permissions['manage_all_projects']?'checked':'').' id="'.$id.'_manage_all_projects" /></td>';
								echo '<td><input type="checkbox"'.($permissions['add_blog_post']?'checked':'').' id="'.$id.'_add_blog_post" /></td>';
								echo '<td><input type="checkbox"'.($permissions['manage_all_blog_posts']?'checked':'').' id="'.$id.'_manage_all_blog_posts" /></td>';
								echo '<td><input type="checkbox"'.($permissions['in_contact_list']?'checked':'').' id="'.$id.'_in_contact_list" /></td>';
								echo '<td><input type="checkbox"'.($permissions['send_email']?'checked':'').' id="'.$id.'_send_email" /></td>';
								echo '<td><button class="btn btn-default update_perms" data-id="'.$id.'">Update</button></td>';
								echo '</tr>';
								echo '<tr id="'.$id.'_row" style="display:none;"><td colspan="9">';
								echo '<form data-id="'.$id.'" action="javascript:void(0)">
								<div class="form-group" id="control_first_name">
									<label for="form_first_name">First Name</label>
									<input type="text" class="form-control" placeholder="John" id="'.$id.'_form_first_name" value="'.$info['first_name'].'">
								</div>		
								
								<div class="form-group" id="control_middle_name">
									<label for="form_middle_name">Middle Name</label>
									<input type="text" class="form-control" placeholder="Paul" id="'.$id.'_form_middle_name" value="'.$info['middle_name'].'">
								</div>
								
								<div class="form-group" id="control_last_name">
									<label for="form_last_name">Last Name</label>
									<input type="text" class="form-control" placeholder="Smith" id="'.$id.'_form_last_name" value="'.$info['last_name'].'">
								</div>
								
								<div class="form-group" id="control_contact_email">
									<label for="form_contact_email">Contact Email</label>
									<input type="email" class="form-control" placeholder="example@theworld.com" id="'.$id.'_form_contact_email" value="'.$info['contact_email'].'">
								</div>
								
								<div class="form-group" id="control_linkedin">
									<label for="form_linkedin">LinkedIn URL</label>
									<input type="text" class="form-control" placeholder="https://www.linkedin.com/pub/" id="'.$id.'_form_linkedin" value="'.$info['linkedin'].'">
								</div>
								
								<div class="form-group" id="control_personal_site">
									<label for="form_personal_site">Personal Website</label>
									<input type="text" class="form-control" placeholder="http://openrobotics.ca" id="'.$id.'_form_personal_site" value="'.$info['personal_site'].'">
								</div>
								
								<div class="form-group" id="control_open_robotics_position">
									<label for="form_open_robotics_position">Open Robotics Position</label>
									<input type="text" class="form-control" placeholder="Junior Member" id="'.$id.'_form_open_robotics_position" value="'.$info['open_robotics_position'].'">
								</div>
								
								<div class="form-group" id="control_education">
									<label for="form_education">Education</label>
									<input type="text" class="form-control" placeholder="2nd Year Electrical Engineering" id="'.$id.'_form_education" value="'.$info['education'].'">
								</div>
								
								<div class="form-group" id="control_employment">
									<label for="form_employment">Employment</label>
									<input type="text" class="form-control" placeholder="Intern at ..." id="'.$id.'_form_employment" value="'.$info['employment'].'">
								</div>
								
								<div class="form-group" id="control_bio">
									<label for="form_bio">Bio</label>
									<textarea class="form-control" rows="5" id="'.$id.'_form_bio">'.$info['bio'].'</textarea>
								</div>
								
								<button class="btn btn-default form_submit" data-id="'.$id.'">Update</button>
								
								<hr> 
								
								<div class="form-group" id="control_password">
									<label for="form_password">Password</label>
									<input type="password" class="form-control" placeholder="********" id="'.$id.'_form_password">
								</div>
								
								<button type="submit" class="btn btn-default form_update_password" data-id="'.$id.'">Change Password</button>
								</form>
								<hr>
								<div class="form-inline">
									<div class="form-group">
										<input type="checkbox" class="form-control" id="'.$id.'_form_delete_box">
									</div>
									<button class="btn btn-default form_delete_user" data-id="'.$id.'">Delete User</button>
								</div>';
								
								echo '</td></tr>';
							}
							echo '</tbody></table>';
						} else {
						
						}
						$db->close();
					} else {
					
					}
				}
			?>
		</div>
		<div class="col-md-2"></div>
	</div>

	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>