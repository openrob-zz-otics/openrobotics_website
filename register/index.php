<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "register";
	print_header($page_name);
	print_navbar();
?>

<div class="container">

	<h2>Register</h2>
	
	<p>Apologies, we are not currently accepting registration for user accounts. Instead, please register for out mailing list.</p>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>