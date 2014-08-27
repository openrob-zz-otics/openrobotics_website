<?php
	//include our library and start drawing the page
	require_once("php_include/functions.php");
	$page_name = "home";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">

	<h1>404 Not Found</h1>
	
	<h3>I couldn't come up with anything clever to say. Sorry.</h3>


	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>