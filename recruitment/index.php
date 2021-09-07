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
            Our Fall Recruitment cycle is in full swing right now! If you're interested in joining, apply for a technical position <a href="/recruitment/postings/?type=technical">here</a>. 
            If you're interested in an admin position apply <a href="/recruitment/postings/?type=admin">here</a>! Note that our applications are open to students across all faculties and of varying skill levels. 
            We look forward to your applications!
        </p>
        <br>
        <p>
            We will be conducting 2 information sessions on Imagine Day (Tuesday September 7th) for those that are interested in joining the team.
        </p>
        <br>
        <h4>Information Sessions</h4>
        <p><a href="https://teams.microsoft.com/l/meetup-join/19%3ameeting_YmUwNmM1MmItMTk5NS00NWVkLWFmYjEtMTdjZTEzM2Y2OWNi%40thread.v2/0?context=%7b%22Tid%22%3a%2284f8c798-d9e9-4d63-8c3b-2a98b3f55136%22%2c%22Oid%22%3a%2250b0368d-55a8-42ab-8cb6-e568726535ee%22%7d">9AM - 10:30AM</a></p>
        <p><a href="https://teams.microsoft.com/l/meetup-join/19%3ameeting_YjliZmU0MWYtNGUyMS00ZTRiLThmMDEtZjk5ZDI0Y2Q4NTQ4%40thread.v2/0?context=%7b%22Tid%22%3a%2284f8c798-d9e9-4d63-8c3b-2a98b3f55136%22%2c%22Oid%22%3a%2250b0368d-55a8-42ab-8cb6-e568726535ee%22%7d">3:30PM - 5:30PM</a></p>
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