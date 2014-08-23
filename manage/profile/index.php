<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "profile";
	print_header($page_name);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h2>Manage Profile</h2>	
			
			<form action="/manage/profile/assets/cgi/profile.php?task=2" method="POST" enctype="multipart/form-data">
				<label for="file">Profile Picture:</label>
				<?php echo '<img src="/upload_content/user_images/'.$user_id.'.png" class="img-responsive img-thumbnail">'; ?>
				<input type="file" name="file" id="file" class="btn btn-default"><br>
				<input type="submit" name="submit" value="Upload" class="btn btn-default">
			</form>
			<hr>
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<p class="text-error" id="error_message"></p>
			
				<div class="form-group" id="control_first_name">
					<label for="form_first_name">First Name</label>
					<input type="text" class="form-control" placeholder="John" id="form_first_name">
				</div>		
				
				<div class="form-group" id="control_middle_name">
					<label for="form_middle_name">Middle Name</label>
					<input type="text" class="form-control" placeholder="Paul" id="form_middle_name">
				</div>
				
				<div class="form-group" id="control_last_name">
					<label for="form_last_name">Last Name</label>
					<input type="text" class="form-control" placeholder="Smith" id="form_last_name">
				</div>
				
				<div class="form-group" id="control_contact_email">
					<label for="form_contact_email">Contact Email</label>
					<input type="email" class="form-control" placeholder="example@theworld.com" id="form_contact_email">
				</div>
				
				<div class="form-group" id="control_linkedin">
					<label for="form_linkedin">LinkedIn URL</label>
					<input type="text" class="form-control" placeholder="https://www.linkedin.com/pub/" id="form_linkedin">
				</div>
				
				<div class="form-group" id="control_personal_site">
					<label for="form_personal_site">Personal Website</label>
					<input type="text" class="form-control" placeholder="http://openrobotics.ca" id="form_personal_site">
				</div>
				
				<div class="form-group" id="control_education">
					<label for="form_education">Education</label>
					<input type="text" class="form-control" placeholder="2nd Year Electrical Engineering" id="form_education">
				</div>
				
				<div class="form-group" id="control_employment">
					<label for="form_employment">Employment</label>
					<input type="text" class="form-control" placeholder="Intern at ..." id="form_employment">
				</div>
				
				<div class="form-group" id="control_bio">
					<label for="form_bio">Bio</label>
					<textarea class="form-control" rows="5" id="form_bio"></textarea>
				</div>
				
				<button class="btn btn-default" id="form_submit">Update</button>
				<hr>
		</div>
		<div class="col-md-4"></div>
	</div>
	<div class="row"> 
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h3>Change Password</h3>
			
			<p class="text-error" id="password_error_message"></p>
			<div class="form-group" id="control_old_password">
				<label for="form_old_password">Old Password</label>
				<input type="password" class="form-control" placeholder="Old Password" id="form_old_password">
			</div>	
			<div class="form-group" id="control_password">
				<label for="form_password">New Password</label>
				<input type="password" class="form-control" placeholder="New Password" id="form_password">
			</div>		
			<div class="form-group" id="control_password_check">
				<label for="form_password_check">New Password Again</label>
				<input type="password" class="form-control" placeholder="New Password" id="form_password_check">
			</div>	
			<button class="btn btn-default" id="change_password">Change</button>
		</div>
		<div class="col-md-4"></div>
	</div>

	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>