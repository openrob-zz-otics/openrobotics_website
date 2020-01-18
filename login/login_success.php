<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
$page_name = "login";
print_header($page_name, false);
print_navbar();
?>

<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <h2>Login Success</h2>
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