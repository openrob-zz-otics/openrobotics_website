<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "web development";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container" id="div_container">
	<div class="row">
		<div class="col-sm-12">	
			<h3>Seeking Web Administrator and Developer!</h3>
			<p>
				Our current administrator and developer won't be around starting in May. 
				As such we are currently in need of someone to take over the following duties (not a complete list):
			</p>
			<ul>
				<li>performing routine maintenance on the server, ensuring uptime and reliability</li>
				<li>maintain the database, keeping regular backups and being prepared to restore it</li>
				<li>feature updates, as requested by members</li>
				<li>bug fixes</li>
				<li>provide general tech support for team</li>
			</ul>
			<p>
				The new administrator is ideally a UBC engineering/science student with an interest in the team. 
				They need not have all the skills from the get go, but need to be prepared to learn as necessary in order to perform the duties mentioned.
				The skills that one must have or learn are (but are not limited to):
			</p>
			<ul>
				<li>knowledge of and ability to apply HTML, PHP, JavaScript, CSS, SQL</li>
				<li>knows their way around a linux server</li>
				<li>can configure a fresh installation of ubuntu to be able to serve a website</li>
				<li>familiarity with Amazon Web Services</li>
				<li>know how to backup and restore the server (and database), for example: be able to migrate it from one server to another</li>
			</ul>
			<p>
				Interested individuals should contact the <a href="/contact/user/?id=4">current administrator.</a>
			</p>
	</div>
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>
