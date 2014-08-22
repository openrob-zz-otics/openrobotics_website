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
		
	<div class="row" id="form_control">
		<div class="col-lg-2"></div>
		<div class="col-lg-8">
			<h3>Contact Form</h3>
			<!--<form role="form">-->
				<div class="form-group" id="control_email">
					<label for="form_email">Email</label>
					<input type="text" class="form-control" placeholder="example@theworld.com" id="form_email">
				</div>
				
				<div class="form-group" id="control_name">
					<label for="form_name">Your Name</label>
					<input type="text" class="form-control" placeholder="John Doe" id="form_name">
				</div>
				
				<div class="form-group" id="control_message">
					<label for="form_message">Message</label>
					<textarea class="form-control" rows="10" id="form_message"></textarea>
				</div>
				<button class="btn btn-default btn-disabled" id="form_submit" disabled>Submit</button>
			<!--</form>-->
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