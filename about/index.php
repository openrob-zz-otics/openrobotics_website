<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "about";
print_header($page_name, false);
print_navbar();
?>
<div class="container" id="div_container">
    <div class="row">
        <div class="col-sm-12">
            <h2>About</h2>

            <blockquote>
                <p>
                    Our team was started in 2012 as
                    Thunderbots @home, to compete
                    in the July 2014 <a href="http://www.robocupathome.org/">RoboCup@home</a>
                    competition
                </p>
            </blockquote>
            <blockquote class="blockquote-reverse">
                <p>
                    The team’s shot at the competition was
                    ambitious; Most teams are at least 6
                    years old, and have professors and
                    PhDs on board.
                    <br />
                    Thunderbots @home
                    made great progress, achieving basic
                    autonomous operation
                </p>
            </blockquote>
            <blockquote>
                <p>
                    The <a href="http://www.robocupathome.org/">@home competition</a> is still in our
                    sights for the future. Our aim is to have
                    our platform completed mechanically
                    and electronically by 2015, developing
                    software and doing mechanical revision
                    to compete in 2016.
                </p>
            </blockquote>
            <p>Promotional Media</p>
            <ul>
                <li class="list"><a href="assets/pdf/bannerwork6.pdf">Banner</a></li>
                <li class="list"><a href="assets/pdf/posters3.pdf">Poster</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p>Take a look at our brochure</p>

            <div data-configid="0/9041205" style="width: 1170px; height: 550px;" class="issuuembed" id="issu_doc"></div>
            <script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>

        </div>
    </div>
    <?php
    print_footnote();
    ?>

</div><!-- /.container -->
<?php
//print the footer	
print_footer();
?>
