<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "recruitment";
print_header($page_name, false);
print_navbar();
?>

<div class="container">
    <div class="mtt-content">
        <h2>So we've got your interest, what's next?</h2>
        <p>
            Our Fall Recruitment Cycle is now closed, but stay tuned! Our next recruitment cycle will open on January 1st, 2021. 
            In the mean time follow us on <a href="https://www.facebook.com/UBCOpenRobotics/" target="_blank">Facebook</a>, 
            <a href="https://www.instagram.com/ubcopenrobotics/" target="_blank">Instagram</a>, or <a href="https://twitter.com/ubcopenrobotics" target="_blank">Twitter</a> 
            or email us at <a href="mailto:intelligence@openrobotics.ca">intelligence@openrobotics.ca</a> if you have any questions. 
        </p>
    </div>
    <?php
    print_footnote();
    ?>

</div>
<!--container-->

<?php
//print the footer	
print_footer();
?>