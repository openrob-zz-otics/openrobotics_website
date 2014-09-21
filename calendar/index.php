<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "calendar";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container" id="div_container">
	<div class="row">
		<div class="col-sm-12" style="padding-top:50px;">
			<iframe src="https://www.google.com/calendar/embed?src=openrobotics.ca_747tfgll02diqafke3arbjsai4%40group.calendar.google.com&ctz=America/Vancouver" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe></div>
	</div>
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>