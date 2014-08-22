<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "tech";
	print_header($page_name);
	print_navbar();
?>
<div class="container">

	<h2>Tech</h2>
	
	<p>What is supposed to go here?.</p>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>