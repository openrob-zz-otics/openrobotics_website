<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "about";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container" id="div_container">

	<h2>About</h2>
	
	<p>Take a look at our brochure</p>
	
	<div data-configid="0/9041205" style="width: 1170px; height: 550px;" class="issuuembed" id="issu_doc"></div><script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>