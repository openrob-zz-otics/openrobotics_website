<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "recruitment";
print_header($page_name, false);
print_navbar();
?>

<div class="container">
    <div class="mtt-content">
        <h2>So we've got your interest, what's next?<span class="text-muted"></h2>
        <p>Right now we are looking for technically experienced individuals who can help write the training program, improve the website,
            and complete the first iteration of our full-size robotics platform. If that's not you don't worry, just follow us on social media, and try and do a couple small hands on projects.
            We'll post suggestions soon!</span></p>
    </div>
    <br />
    <section class="services">
        <div class="row">
            <div class="mtt-content">
                <div class="col-md-4">
                    <div class="service-item first-service">
                        <div class="service-icon"></div>
                        <h2>Beginner</h2>
                        <p>You're probably a first or second year student with a passion for technology and a desire to develop your hands on skills. You're ready to put some time into it, but you don't know much about robotics... yet. What we're looking for: Enthusiasm, some basic hands on skills, demonstrated commitment. Don't forget you'll only get out what you put in.</p>
                        <a class="btn btn-default btn-custom" href="/recruitment/recruit_form?level=Beginner" role="button">Register &raquo;</a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="service-item second-service">
                        <div class="service-icon"></div>
                        <h2>Intermediate</h2>
                        <p>You're probably a second or third year student who has done some mechanical design, electrical design, or coding already. You're getting more comfortable with your skills but you want to take them to the next level.
                            This is your chance. We will pair you with an expert mentor, provide the resources and guidance you need, and give you a place to show off your project. You'll be expected to put in more time into CAD/coding/fabrication than your mentor, but hey, it's more fun than studying and it's what gets you the good jobs.</p>
                        <a class="btn btn-default btn-custom" href="/recruitment/recruit_form?level=Intermediate" role="button">Register &raquo;</a>
                    </div>
                </div><!-- /.col-lg-4 -->
                <div class="col-sm-4">
                    <div class="service-item third-service">
                        <div class="service-icon"></div>
                        <h2>Advanced</h2>
                        <p>You're probably a fourth year to graduate student who has significant experience in mechanical design, control, software, or robotics. We know how busy you are and we appreciate whatever you can put into the team. You are the mentors, and the most important contributors to our training program. </p>
                        <a class="btn btn-default btn-custom" href="/recruitment/recruit_form?level=Advanced" role="button">Register &raquo;</a>
                    </div>
                </div><!-- /.col-lg-4 -->
            </div>
        </div><!-- /.row -->
    </section>

    <br /><br />

    <?php
    print_footnote();
    ?>

</div>
<!--container-->

<?php
//print the footer	
print_footer();
?>