<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	require_once("../php_include/client_functions.php");
	require_once("../php_include/db.php");
	require_once('../php_include/recaptchalib.php');

	$page_name = "register";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		

			<h2>Register</h2>
			
			<?php 
			
				$recaptcha_enabled = true;
			
				$public_key = "6LfNF_kSAAAAANXBwd3gJ7qqbJ1NLgRFx5jCi9Gz";
				$private_key = "6LfNF_kSAAAAAIVGRvYWR7FX2SyLRZpi_lnkZMYf";
				if(isset($_POST["submit"])) {
				
					if ($recaptcha_enabled) {
						$resp = recaptcha_check_answer ($private_key,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
					}					

					$first_name = @$_POST["first_name"];
					$middle_name = @$_POST["middle_name"];
					$last_name = @$_POST["last_name"];
					$email = @$_POST["email"];
					$password = @$_POST["password"];
					$password_check = @$_POST["password_check"];
						
					if (!$recaptcha_enabled || @$resp->is_valid) {
						
						// simplest validate
						if(isset($first_name) && isset($last_name) && isset($email) && isset($password)) {
							$mysqli = get_db();
							
							$email = $mysqli->real_escape_string($email);
							$password = $mysqli->real_escape_string($password);
							
							if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
								
								$query  = "SELECT `id` FROM `users` WHERE `email`='{$email}';";
								
								if ($result = $mysqli->query($query) && $mysqli->affected_rows >= 1 ) {
									$errors = "Email already in use. Please register using another email.";
								} else {
									$time = date("Y-m-d H:i:s");
									$ip = getClientIP(); 
									
									$insert  = "INSERT INTO `users` (";
									$insert .= "`email`, `password`, `registration_time`, `registration_ip`";
									$insert .= ") VALUES (";
									$insert .= "  '{$email}', md5('{$password}'), '{$time}', '{$ip}'";
									$insert .= ");";
									if ($result = $mysqli->query($insert) && $mysqli->affected_rows <= 1 ) {
									
										$user_id = $mysqli->insert_id;
										
										$insert = "INSERT INTO `user_permissions` (`id`) VALUES ('{$user_id}');";
										
										if($result = $mysqli->query($insert) && $mysqli->affected_rows == 1 ) {
											$first_name = $mysqli->real_escape_string($first_name);
											$middle_name = $mysqli->real_escape_string($middle_name);
											$last_name = $mysqli->real_escape_string($last_name);
											
											$insert = "INSERT INTO `user_info` (`id`, `first_name`, `middle_name`, `last_name`) ";
											$insert .= "VALUES ('{$user_id}', '{$first_name}', '".(strlen($middle_name) ? $middle_name : "") ."', '${last_name}');";
											

											if($result = $mysqli->query($insert) && $mysqli->affected_rows == 1 ) {
												
												$success = "Congratulations! You have successfully registered.";
												myMail($email, "Thank you for registering.", "Thank you for registering for UBC Open Robotics!");
											} else {
												$errors = "There were errors during registration. Please consult admin.";
											}
										} else {
											$errors = "There were errors during registration. Please consult admin.";
										}
									} else {
										$errors = "Registration failed. Please consult admin.";
									}
								}
							}
						}
					} else {
						if ($recaptcha_enabled) {
							$errors = "Incorrect CAPTCHA";// . $resp->error;
						}
					}
				}
			?>
			
			<?php 
				if(isset($errors)) {
					echo "<p class=\"bg-danger\">".$errors."</p>";
				}
				if(isset($success)) {
					echo "<p class=\"bg-success\">".$success."</p>";
				}
			?>
			<hr>

			<form action="." method="post" <?php if(isset($success)) echo "style='display:none;'"; ?>>
				<div class="form-group" id="control_first_name">
					<label for="form_first_name" class="control-label">First Name</label>
					<input type="text" name="first_name" class="form-control" placeholder="John" id="form_first_name" value="<?php echo @$first_name;?>">
					<span class="help-block with-errors"></span>
				</div>		
				
				<div class="form-group" id="control_middle_name">
					<label for="form_middle_name">(Optional) Middle Name</label>
					<input type="text" name="middle_name" class="form-control" placeholder="Paul" id="form_middle_name" value="<?php echo @$middle_name;?>">
				</div>	
				
				<div class="form-group" id="control_last_name">
					<label for="form_last_name">Last Name</label>
					<input type="text" name="last_name" class="form-control" placeholder="Smith" id="form_last_name" value="<?php echo @$last_name;?>">
					<span class="help-block with-errors"></span>
				</div>					
				
				<div class="form-group" id="control_email">
					<label for="form_contact_email">Email</label>
					<input type="email" name="email" class="form-control" placeholder="example@theworld.com" id="form_email" value="<?php echo @$email;?>">
					<span class="help-block with-errors"></span>
				</div>	
				
				<div class="form-group" id="control_password">
					<label for="form_control_password">Password</label>
					<input type="password" name="password" class="form-control" placeholder="******" id="form_password">
					<span class="help-block with-errors"></span>
				</div>	
				
				<div class="form-group" id="control_password_check">
					<label for="form_password_check">Re-Password</label>
					<input type="password" name="password_check" class="form-control" placeholder="******" id="form_password_check">
					<span class="help-block with-errors"></span>
				</div>	

				<?php 
					if ($recaptcha_enabled) {
						echo recaptcha_get_html($public_key, NULL, true);
					}
				?>
				<br />
				<div class="form-group">
					<button type="submit" class="btn btn-default" id="form_submit" name="submit" disabled>Register</button>
				</div>
			</form>	
		</div>
		
		<div class="col-md-3"></div>
	</div>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->

<?php 
	//print the footer	
	print_footer();
?>