<?php
//include our library and start drawing the page
require_once("../php_include/functions.php");
require_once('../php_include/recaptchalib.php');
$page_name = "contact";
print_header($page_name, false);
print_navbar();
?>
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<div class="container">

    <?php
        $email = @$_POST['email'];
        $name = @$_POST['name'];
        $message = @$_POST['message'];

        if (isset($_POST['submit'])) {
            mail("webdevelopment@openrobotics.ca", "Email from: ".$email." (".$name.")", $message);
        }

    ?>


    <div class="row" id="form_control" <?php if (@$message_sent) echo 'style="display:none;"'; ?>>
        <div class="mtt-content">
            <h3>Contact Form</h3>
            <?php
            if (isset($errors)) {
                echo "<p class=\"bg-danger\">" . $errors . "</p>";
            }
            ?>
            <form role="form" action="." method="POST">
                <div class="form-group" id="control_email">
                    <label for="form_email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="example@theworld.com" id="form_email">
                </div>

                <div class="form-group" id="control_name">
                    <label for="form_name">Your Name</label>
                    <input type="text" class="form-control" name="name" placeholder="John Doe" id="form_name">
                </div>

                <div class="form-group" id="control_message">
                    <label for="form_message">Message</label>
                    <textarea class="form-control" rows="10" name="message" id="form_message"></textarea>
                </div>
                <br />
                <div class="g-recaptcha" data-sitekey="6LcLgt0UAAAAADb3C05_LsPRlGBzkh9g1oTmerZw"></div>
                <p id="captcha-error" style="display:none;">Please prove you are not a robot before submitting</p>
                <button class="btn btn-default btn-disabled" name="submit" id="form_submit" disabled>Submit</button>
            </form>
        </div>

        <div class="mtt-content" style="text-align:left;">
            <h3></h3><!-- lazy padding -->

            <p style="font-size:19px;">
                If you are interested in sponsorship or donating to UBC Open Robotics, you may contact us with this form.
                To donate immediately, click the button below.
            </p>
            <a href="<?php echo $GLOBALS['donate_link']; ?>"><button class="btn btn-primary btn-lg">Donate Now</button></a>

        </div>
    </div>

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