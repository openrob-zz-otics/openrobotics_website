<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	require_once('../php_include/recaptchalib.php');
	$page_name = "contact";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<!--<div class="row">		
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<h3>Here is some contact information:</h3>
			
			<p style="padding-left:25px;">
				Some email, address, phone number? <br />
				Goes here...
			</p>
		</div>
		<div class="col-lg-2"></div>
	</div>-->
	
	<?php
		
		$recaptcha_enabled = true;
		$public_key = "6LfNF_kSAAAAANXBwd3gJ7qqbJ1NLgRFx5jCi9Gz";
		$private_key = "6LfNF_kSAAAAAIVGRvYWR7FX2SyLRZpi_lnkZMYf";
		if (isset($_POST['submit'])) {			
		
			if ($recaptcha_enabled) {
				$resp = recaptcha_check_answer ($private_key,
					$_SERVER["REMOTE_ADDR"],
					$_POST["recaptcha_challenge_field"],
					$_POST["recaptcha_response_field"]);
			}			
			$email = @$_POST['email'];
			$name = @$_POST['name'];
			$message = @$_POST['message'];
			
			if (!$recaptcha_enabled || @$resp->is_valid) {		
			
			
				myMailFrom("intelligence@openrobotics.ca", "[Website] Message From $name", $message, $email);
				myMail($email, "Your recent message to Open Robotics", "Hello $name,\nWe recently received a message from you. We will attempt to reply to as soon as we can. Thank you for your patience.\n\nYour message was as follows:\n$message");
				
				if ($db = get_db()) {
					$query = "INSERT INTO `contact_form_messages` (`email`, `name`, `message`) VALUES ('$email', '$name', '$message');";
					$db->query($query);
					$db->close();
				}
				
				$message_sent = true;
				
				if (@$message_sent) {
					echo '<div class="row"><div class="col-sm-3"></div><div class="col-sm-6"><h3>Message sent</h3></div><div class="col-sm-3"></div></div>';
				}
			} else {
				if ($recaptcha_enabled) {
					$errors = "Incorrect CAPTCHA";
				}
			}
		}
	
	?>
	
	
	<div class="row" id="form_control" <?php if(@$message_sent)echo'style="display:none;"';?>>
		<div class="col-sm-2"></div>
		<div class="col-sm-6">
			<h3>Contact Form</h3>
			<?php
				if(isset($errors)) {
					echo "<p class=\"bg-danger\">".$errors."</p>";
				}
			?>
			<form role="form" action="." method="POST">
				<div class="form-group" id="control_email">
					<label for="form_email">Email</label>
					<input type="text" class="form-control" name="email" placeholder="example@theworld.com" id="form_email">
				</div>
				
				<div class="form-group" id="control_name">
					<label for="form_name">Your Name</label>
					<input type="text" class="form-control" name="name" placeholder="John Doe" id="form_name">
				</div>
				
				<div class="form-group" id="control_message">
					<label for="form_message">Message</label>
					<textarea class="form-control" rows="10" name="message" id="form_message"></textarea>
				</div>
				<?php 
					if ($recaptcha_enabled) {
						echo recaptcha_get_html($public_key, NULL, true);
					}
				?><br />
				<button class="btn btn-default btn-disabled" name="submit" id="form_submit" disabled>Submit</button>
			</form>
		</div>		
		
		<div class="col-sm-4" style="text-align:right;">
			<h3></h3><!-- lazy padding -->
			
			<p style="font-size:19px;">
				If you are interested in sponsorship or donating to UBC Open Robotics, you may contact us with this form.
				To donate immediately, click the button below.
			</p>
			<a href="<?php echo $GLOBALS['donate_link']; ?>"><button class="btn btn-lg btn-or">Donate Now</button></a>
			
		</div>
	</div>
			
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>