<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "login";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h2>Login</h2>	
			<p class="text-error"><?php if(isset($error_msg))echo $error_msg; ?></p>
			<form role="form" action="login_post.php" method="post">
				<div class="form-group" id="control_email">
					<label for="form_email">Email</label>
					<input type="email" class="form-control" placeholder="example@theworld.com" name="email" id="form_email" value="<?php if(isset($email))echo $email;?>">
				</div>			
				<div class="form-group" id="control_name">
					<label for="form_password">Password</label>
					<input type="password" class="form-control" placeholder="password" name="password" id="form_password">
				</div>
				<button type="submit" name="submit" class="btn btn-default" id="form_submit">Login</button>
			</form>
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