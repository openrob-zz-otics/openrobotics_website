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
            Our Summer Recruitment cycle is in full swing right now! If you're interested in joining, apply for a technical position <a href="/recruitment/postings/?type=technical">here</a>. 
            If you're interested in an admin position apply <a href="/recruitment/postings/?type=admin">here</a>! Note that our applications are open to students across all faculties and of varying skill levels. 
            We look forward to your applications!
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