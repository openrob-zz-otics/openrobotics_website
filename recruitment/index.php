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
        <p>Although we plan to have a truly open team which can accept any motivated individual, our training program
            is not complete and the team is still small. Right now we are mostly looking for technically experienced individuals who can help write the training program, improve the website,
            and complete the first iteration of our full-size robotics platform. If that's not you don't worry, just follow us on social media, and try and do a couple small hands on projects.
            We'll post suggestions soon!</span></p>
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