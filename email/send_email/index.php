<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	require_once("../../php_include/client_functions.php");
	require_once("../../php_include/db.php");
	require_once('../../php_include/recaptchalib.php');
	
	$page_name = "send_email";
	print_header($page_name);
	print_navbar();
?>

<div class="container">
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		

			<h2>Send Message</h2>
			<?php
				
				if(isset($_POST["submit"])) {
					$subject = $_POST["subject"];
					$message = $_POST["message"];
					$from = "admin@openrobotics.com";

					// simplest validate
					if(isset($subject) && isset($subject)) {
						$mysqli = get_db();
						
						$query  = "SELECT ALL `email` FROM `mailing_list_recipients` WHERE `id` >= 1;";
						if ($result = $mysqli->query($query)) {
							while($email = $result->fetch_assoc()){
								myMailFrom($email["email"], $subject, $message, $from);
							}
							$success = "Emails were sent Successfully.";
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

			<?php 
				if(canSendEmail()) {
					if(!isset($success)) {
						echo "<form action=\".\" method=\"post\">";
							echo "<div class=\"form-group\" id=\"control_subject\">";
								echo "<label for=\"form_subject\">Subject</label>";
								echo "<input type=\"text\" name=\"subject\" class=\"form-control\" placeholder=\"Subject\" id=\"form_subject\" value=\"\">";
								echo "<span class=\"help-block with-errors\"></span>";
							echo "</div>";
							
							
							echo "<div class=\"form-group\" id=\"control_message\">";
								echo "<label for=\"form_message\">Message</label>";
								echo "<textarea class=\"form-control\" name = \"message\" rows=\"10\" id=\"form_message\"></textarea>";
								echo "<span class=\"help-block with-errors\"></span>";
							echo "</div>";	

							echo "<div class=\"form-group\">";
								echo "<button type=\"submit\" class=\"btn btn-default\" id=\"form_submit\" name=\"submit\" >Register</button>";
							echo "</div>";
						echo "</form>";	
					}
				} else {
					echo "You do not have permission to use mailing list.";
				}
			?>
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