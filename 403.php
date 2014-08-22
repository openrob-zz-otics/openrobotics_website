<?php
	//include our library and start drawing the page
	require_once("php_include/functions.php");
	$page_name = "home";
	print_header($page_name);
	print_navbar();
?>

<div class="container">

	<h1>403 Forbidden</h1>

	<h3>Bugger Off...</h3>

	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>