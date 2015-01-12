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
			<center><img class="img-circle" src="/assets/images/icon1.png" style="width: 140px; height: 140px;"></center>
			<!--
			<h2>@home</h2>
			<p>We aim to complete our electromechanical platform by summer 2015, and compete at RoboCup<a href="http://www.robocupathome.org/">@home</a> 2016 in Germany.</p>
			-->	
			<h2>Training</h2>
			<p>
				Open Robotics offers training for different disciplines involved in robotics. The training is freely available on this website.
			</p>
			<p><a class="btn btn-default" href="/training/" role="buttons">View &raquo;</a></p>
			<!--<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<center><img class="img-circle" src="/assets/images/icon2.png" style="width: 140px; height: 140px;"></center>
			<h2>Featured Projects</h2>
			<p>Our members have already worked on various projects. All of the projects are documented here on the website.</p>
			<p><a class="btn btn-default" href="/projects" role="button">View projects &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<center><img class="img-circle" src="/assets/images/icon3.png" style="width: 140px; height: 140px;"></center>
			<h2>Get Involved</h2>
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
			<img class="featurette-image img-responsive" src="/assets/images/Arm.PNG">
		</div>
	</div>

  	<hr class="featurette-divider">

	<div class="row featurette">
		<div class="col-sm-5">
			<img class="img-responsive" src="/assets/images/fig3.jpg">
		</div>
		<div class="col-sm-7">
			<h2 class="featurette-heading">Let your idea <span class="text-muted">come to life.</span></h2>
			<p class="lead">Have an idea? We can help you find the resources and pair you with more people like yourself.</p>
		</div>
	</div>

	<hr>
	
	
	<div class="row">
		<div class="col-sm-12" style="text-align:center;">
			<p style="font-size:19px;">
				UBC Open Robotics is a new team, and we're working on growing our team and expanding our reach. 
				We would graciously accept donations to help us reach our goal of competing in RoboCup 2016. 
				For more details on sponshorship, please use our <a href="contact">contact form.</a>
				Thank you!
			</p>
			<a href="<?php echo $GLOBALS['donate_link']; ?>"><button class="btn btn-lg btn-or">Donate Now</button></a>
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