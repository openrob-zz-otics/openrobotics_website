<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "about";
	print_header($page_name);
	print_navbar();
?>
<div class="container">

	<h2>About</h2>
	
	<p>abooooooout turn.</p>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>