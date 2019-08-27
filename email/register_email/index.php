<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	require_once("../../php_include/client_functions.php");
	require_once("../../php_include/db.php");
	require_once('../../php_include/recaptchalib.php');

	$page_name = "register_email";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		

			<h2>Mailing List</h2>
			
			<?php 
			
				$recaptcha_enabled = false;
			
				$private_key = "6LfNF_kSAAAAANXBwd3gJ7qqbJ1NLgRFx5jCi9Gz";
				$public_key = "6LfNF_kSAAAAAIVGRvYWR7FX2SyLRZpi_lnkZMYf";
				if(isset($_POST["submit"])) {
				
					if ($recaptcha_enabled) {
						$resp = recaptcha_check_answer ($private_key,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
					}					

					$email = @$_POST["email"];
						
					if (!$recaptcha_enabled || @$resp->is_valid) {
						
						// simplest validate
						if(isset($email)) {
							$mysqli = get_db();
							
							$email = $mysqli->real_escape_string($email);
							
							if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
								
								$query  = "SELECT `id` FROM `mailing_list_recipients` WHERE `email`='{$email}';";
								
								if ($result = $mysqli->query($query) && $mysqli->affected_rows >= 1 ) {
									$errors = "This email is already in the mailing list. Lucky you.";
								} else {
									$time = date("Y-m-d H:i:s");
									$ip = getClientIP(); 
									
									$insert  = "INSERT INTO `mailing_list_recipients` (";
									$insert .= "`email`, `registration_time`, `registration_ip`";
									$insert .= ") VALUES (";
									$insert .= "  '{$email}', '{$time}', '{$ip}'";
									$insert .= ");";
									if ($result = $mysqli->query($insert) && $mysqli->affected_rows <= 1 ) {
										$success = "Congratulations! You have successfully registered. You should receive an email from listserv@lists.ubc.ca confirming your subscription.";
										myMailFrom("OPENROBOTICS-ANNOUNCE-subscribe-request@LISTS.UBC.CA","","",$email);
									} else {
										$errors = "Registration failed. Please consult admin.";
									}
								}
							} else {
								$errors = "Invalid Email. Try again.";
							}
						}
					} else {
						if (!$recaptcha_enabled) {
							$errors = "Bad CAPTCHA: " . $resp->error;
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

				<div class="form-group" id="control_email">
					<label for="form_contact_email">Email</label>
					<input type="email" name="email" class="form-control" placeholder="example@theworld.com" id="form_email" value="<?php echo @$email;?>">
					<span class="help-block with-errors"></span>
				</div>	

				<?php 
					if ($recaptcha_enabled) {
						echo recaptcha_get_html($public_key, NULL, true);
					}
				?>

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