<?php
	if (isset($_COOKIE['seen_popup'])) {
		define("seen_popup", true);
	} else {
		define("seen_popup", false);
	}

	setcookie("seen_popup", "1", time()+3600*24*7);
	
	//include our library and start drawing the page
	require_once("php_include/functions.php");
	$page_name = "home";
	print_header($page_name, false);
	print_navbar();
?>

<?php
	//include carousel
	include("php_include/carousel.php");
?>



<div class="container">

	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="col-sm-4">
			<!--<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">-->
			<h2>@home</h2>
			<p>Our philosophy...</p>
			<!--<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<!--<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">-->
			<h2>featured projects</h2>
			<p>Our members have already worked on various projects. All of the projects are documented here on the website.</p>
			<p><a class="btn btn-default" href="/projects" role="button">View projects &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<!--<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">-->
			<h2>get involved</h2>
			<p>All UBC students are welcome to check us out and work on projects.</p>
			<p><a class="btn btn-default" href="/recruitment" role="button">View details &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
	</div><!-- /.row -->


	<!-- START THE FEATURETTES -->
	<hr class="featurette-divider">
	
	<div class="row featurette">
		<div class="col-sm-7">
			<h2 class="featurette-heading">Work on <span class="text-muted">unique and interesting projects.</span></h2>
			<p class="lead">Provide your skills to a current team. Aid in CAD, manufacturing, electrical design and programming.</p>
		</div>
		<div class="col-sm-5">
			<!--<img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">-->
		</div>
	</div>

  <hr class="featurette-divider">

	<div class="row featurette">
		<div class="col-sm-5">
			<!--<img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">-->
		</div>
		<div class="col-sm-7">
			<h2 class="featurette-heading">Let your idea <span class="text-muted">come to life.</span></h2>
			<p class="lead">Have an idea? We can help you find the resources and pair you with more people like yourself.</p>
		</div>
	</div>

	<!-- /END THE FEATURETTES -->


	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>