<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "projects";
print_header($page_name, false);
print_navbar();
?>

<?php
//include carousel
include("../php_include/carousel_projects.php");

//grab text from php
$text_data = start_PageDisplayText($page_name);
?>

<?php
//print the footer	
print_footer();
?>