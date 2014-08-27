<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "training";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">

	<h2>Training</h2>
	
	<p>Check back later for training content!</p>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>