<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "recruitment";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	<h2>So we've got your interest, what's next?<span class="text-muted"></h2><p>Although we plan to have a truly open team which can accept any motivated individual, our training program 
		is not complete and the team is still small. Right now we are mostly looking for technically experienced individuals who can help write the training program, improve the website, 
		and complete the first iteration of our full-size robotics platform. If that's not you don't worry, just follow us on social media, and try and do a couple small hands on projects. 
		We'll post suggestions soon!</span></p>
	<div class="row">
		<div class="col-sm-4">
			<img class="img-responsive center-block" src="assets/images/wrench1.png" alt="Beginner Wrench" style="width: 50px; height: auto; margin: auto; margin-top: 60px; vertical-align: middle;">
			<br />
			<h2>Beginner</h2>
			<p>You're probably a first or second year student with a passion for technology and a desire to develop your hands on skills. You're ready to put some time into it, but you don't know much about robotics... yet. What we're looking for: Enthusiasm, some basic hands on skills, demonstrated commitment. Don't forget you'll only get out what you put in.</p>
			<p><a class="btn btn-default" href="/recruitment/recruit_form?level=Beginner" role="button">Register &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<img class="img-responsive" src="assets/images/wrench2.png" alt="Intermediate Wrench" style="width: 140px; height: auto; margin: auto; margin-top: 50px;vertical-align: middle;">
			<br />
			<h2>Intermediate</h2>
			<p>You're probably a second or third year student who has done some mechanical design, electrical design, or coding already. You're getting more comfortable with your skills but you want to take them to the next level.
				This is your chance. We will pair you with an expert mentor, provide the resources and guidance you need, and give you a place to show off your project. You'll be expected to put in more time into CAD/coding/fabrication than your mentor, but hey, it's more fun than studying and it's what gets you the good jobs.</p>
			<p><a class="btn btn-default" href="/recruitment/recruit_form?level=Intermediate" role="button">Register &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
		<div class="col-sm-4">
			<img class="img-responsive" src="assets/images/wrench3.png" alt="Advanced Wrench" style="width: 170px; height: auto; margin: auto; margin-top: 10px;vertical-align: middle;">
			<br />
			<h2>Advanced</h2>
			<p>You're probably a fourth year to graduate student who has significant experience in mechanical design, control, software, or robotics. We know how busy you are and we appreciate whatever you can put into the team. You are the mentors, and the most important contributors to our training program. </p>
			<p><a class="btn btn-default" href="/recruitment/recruit_form?level=Advanced" role="button">Register &raquo;</a></p>
		</div><!-- /.col-lg-4 -->
	</div><!-- /.row -->
	
<?php 
	print_footnote();
?>

</div><!--container-->

<?php 
	//print the footer	
	print_footer();
?>