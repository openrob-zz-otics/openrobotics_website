<?php
if (isset($_COOKIE['seen_popup'])) {
    define("seen_popup", true);
} else {
    define("seen_popup", false);
}

setcookie("seen_popup", "1", time() + 3600 * 24 * 7);

//include our library and start drawing the page
require_once("php_include/functions.php");
$page_name = "home";
print_header($page_name, false);
print_navbar();
?>

<?php
//include carousel
include("php_include/carousel.php");

//grab text from php
$text_data = start_PageDisplayText($page_name);
?>



<div class="container">

    <!-- Three columns of text below the carousel -->
    <div class="row span_content">
        <div class="col-sm-4">
            <center><img class="img-circle" src="/assets/images/icon1.png" style="width: 140px; height: 140px;"></center>
            <!--
			<h2>@home</h2>
			<p>We aim to complete our electromechanical platform by summer 2015, and compete at RoboCup<a href="http://www.robocupathome.org/">@home</a> 2016 in Germany.</p>
			-->
            <h2><?php echo get_PageDisplayText($text_data, "l_heading"); ?></h2>
            <p>
                <?php echo get_PageDisplayText($text_data, "l_par"); ?>
            </p>
            <p><a class="btn btn-default" href="/training/" role="buttons"><?php echo get_PageDisplayText($text_data, "l_button"); ?> &raquo;</a></p>
            <!--<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>-->
        </div><!-- /.col-lg-4 -->
        <div class="col-sm-4">
            <center><img class="img-circle" src="/assets/images/icon2.png" style="width: 140px; height: 140px;"></center>
            <h2><?php echo get_PageDisplayText($text_data, "m_heading"); ?></h2>
            <p><?php echo get_PageDisplayText($text_data, "m_par"); ?></p>
            <p><a class="btn btn-default" href="/projects" role="button"><?php echo get_PageDisplayText($text_data, "m_button"); ?> &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-sm-4">
            <center><img class="img-circle" src="/assets/images/icon3.png" style="width: 140px; height: 140px;"></center>
            <h2><?php echo get_PageDisplayText($text_data, "r_heading"); ?></h2>
            <p><?php echo get_PageDisplayText($text_data, "r_par"); ?></p>
            <p><a class="btn btn-default" href="/recruitment" role="button"><?php echo get_PageDisplayText($text_data, "r_button"); ?> &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->
    <hr class="featurette-divider">

    <div class="row featurette span_content">
        <div class="col-sm-7">
            <h2 class="featurette-heading"></span><?php echo get_PageDisplayText($text_data, "first_heading"); ?></h2>
            <p class="lead"><?php echo get_PageDisplayText($text_data, "first_par"); ?></p>
        </div>
        <div class="col-sm-5">
            <img class="featurette-image img-responsive" src="/assets/images/Arm.PNG">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette span_content">
        <div class="col-sm-5">
            <img class="img-responsive" src="/assets/images/fig3.jpg">
        </div>
        <div class="col-sm-7">
            <h2 class="featurette-heading"><?php echo get_PageDisplayText($text_data, "second_heading"); ?></h2>
            <p class="lead"><?php echo get_PageDisplayText($text_data, "second_par"); ?></p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-12">
            <p style="font-size:17px;text-align:center">
                UBC Open Robotics is currently seeking someone to administrate and further develop this site. Click <a href="/webdev">here</a> for more information.
            </p>
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