<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "contact";
	print_header($page_name);
	print_navbar();
?>
<div class="container">
	<div class="row">		
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<h3>Here is some contact information:</h3>
			
			<p style="padding-left:25px;">
				Some email, address, phone number? <br />
				Goes here...
			</p>
		</div>
		<div class="col-lg-2"></div>
	</div>
	
	<?php
		if (isset($_POST['submit'])) {
			$email = @$_POST['email'];
			$name = @$_POST['name'];
			$message = @$_POST['message'];
			
			myMailFrom("intelligence@openrobotics.ca", "Message From $name", $message, $email);
			myMail($email, "Your recent message to Open Robotics", "Hello $name,\nWe recently received a message from you. We will attempt to reply to as soon as we can. Thank you for your patience.\n\nYour message was as follows:\n$message");
			
			if ($db = get_db()) {
				$query = "INSERT INTO `contact_form_messages` (`email`, `name`, `message`) VALUES ('$email', '$name', '$message');";
				$db->query($query);
				$db->close();
			}
			
			$message_sent = true;
		}
	
	if (@$message_sent) {
		echo '<div class="row"><div class="col-lg-2"></div><div class="col-md-8"><h3>Message sent</h3></div><div class="col-lg-2"></div></div>';
	}
	
	?>
	
	
	<div class="row" id="form_control" <?php if(@$message_sent)echo'style="display:none;"';?>>
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<h3>Contact Form</h3>
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
				<button class="btn btn-default btn-disabled" name="submit" id="form_submit" disabled>Submit</button>
			</form>
		</div>		
		<div class="col-lg-2"></div>
	</div>
			
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>