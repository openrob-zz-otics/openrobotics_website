<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "resources";
print_header($page_name, false);
print_navbar();
?>
<div class="container">
    <section class="services">
        <div class="row">
            <div class="col-md-4">
                <!-- <div class="service-item first-service" id="blog" onclick="location.href='/resources/blog/'"> -->
                <div class="service-item first-service" id="blog">
                    <div class="service-icon"></div>
                    <h2>Blog</h2>
                    <p>Blog section contains all blog posts of Open Robotics. We look forward to sharing current and exciting news and information about our team members, projects, and competitions. We hope that our blog will be a place where people will come to read interesting, relevant, and thought-provoking content.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <!-- <div class="service-item second-service" id="training" onclick="location.href='/resources/training/'"> -->
                <div class="service-item second-service" id="training">
                    <div class="service-icon"></div>
                    <h2>Training</h2>
                    <p>Training section contains information related to the training process for newbie to become one of us. This training process is the application of Engineering knowledge & gives people an awareness of rules & procedures to guide their behavior. It helps in bringing about positive change in the knowledge, skills & attitudes of members of the team.</p>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <!-- <div class="service-item third-service" id="calendar" onclick="location.href='/resources/calendar/'"> -->
                <div class="service-item third-service" id="calendar">
                    <div class="service-icon"></div>
                    <h2>Calendar</h2>
                    <p>Calendar section contains our team weekly meeting time as well as special team events. Team members can add their own schedules, and use it as their own calendar</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <br />
    <?php
    print_footnote();
    ?>
</div>
<!--container-->
<?php
//print the footer	
print_footer();
?>