<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "logout";
print_header($page_name, false);

//logout
session_destroy();
$GLOBALS['logged_in'] = false;
$GLOBALS['user_email'] = "";

print_navbar();

?>

<div class="container">

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <h2>Logout Success</h2>
        </div>
    </div>

    <br/><br/><br/><br/><br/><br/>

    <?php
    print_footnote();
    ?>

</div><!-- /.container -->


<?php
//print the footer	
print_footer();
?>