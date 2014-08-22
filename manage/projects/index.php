<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h2>Manage Projects</h2>	
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