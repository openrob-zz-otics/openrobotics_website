<?php
//include our library and start drawing the page
require_once("../../php_include/functions.php");
$page_name = "key_users";
print_header($page_name, false);
print_navbar();
?>
<div class="container">
    <!-- Service section start -->
    <div class="section primary-section" id="service">
        <?php
        if ($db = get_db()) {
            // List of teams
            $teams = array('Admin', 'ArtBot', 'First Year Mentorship', 'PianoBot', 'Robocup Arm', 'Robocup Drivetrain', 'Robocup Gripper', 'Robocup Software');
            for ($i = 0; $i < count($teams); $i++) {
                // Query each team, from team lead to team members
                $query = "SELECT * FROM `users` JOIN `user_info` ON `users`.`id`=`user_info`.`id` JOIN `team_members` ON `users`.`id`=`team_members`.`id` WHERE `users`.`is_disabled`='0' AND `users`.`id` IN (SELECT DISTINCT `id` FROM `user_permissions` WHERE `in_contact_list`='1') AND `team_members`.`team_name`='" . $teams[$i] . "' ORDER BY `team_lead` DESC, `last_name` ASC;";

                if ($result = $db->query($query)) {
                    if ($result->num_rows > 0) {
                        // Find the number of leads in the team
                        $leadCount = 0;
                        while ($row = $result->fetch_assoc()) {
                            if ($row['team_lead'] == '0') {
                                break;
                            }
                            $leadCount++;
                        }

                        // This is how we will divide the lead section 
                        $leadSectionDivision = 12 / ($leadCount + 1);

                        echo '<div class="lead"> <!-- Start title section --> <div class="row"> <div class="title col-md-' . $leadSectionDivision . '"> ';

                        // Query the team description
                        $query2 = "SELECT * FROM `teams` WHERE `team_name`='" . $teams[$i] . "';";
                        if ($result2 = $db->query($query2)) {
                            $row2 = $result2->fetch_assoc();
                            echo '<h2>' . strtoupper($row2['team_name']) . '</h2> <p>' . $row2['team_desc'] . '</p> </div>';
                        }

                        $memberPerRow = 0;
                        // Rerun the query to place the pointer at the beginning
                        if ($result = $db->query($query)) {
                            while ($row = $result->fetch_assoc()) {
                                if ($leadCount > 0) {
                                    $leadCount--;
                                    echo '<div class="col-md-' . $leadSectionDivision . '"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

                                    // Get the profile picture
                                    if (file_exists('../../upload_content/user_images/' . $row['id'] . '.png')) {
                                        echo '"/upload_content/user_images/' . $row['id'] . '.png?' . time() . '"';
                                    } else {
                                        echo '"/assets/images/default_profile.png?' . time() . '" width="150"';
                                    }

                                    echo ' alt="service 1"> </div> <h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3>';

                                    // Captain has their own title
                                    if ($teams[$i] === 'Admin') {
                                        echo '<p>Co-captain</p> </a> </div> </div> ';
                                    } else if ($teams[$i] === 'First Year Mentorship') {
                                        if ($row['id'] == 1) {
                                            echo '<p>Mechanical Mentor</p> </a> </div> </div> ';
                                        } else if ($row['id'] == 89) {
                                            echo '<p>Software Mentor</p> </a> </div> </div> ';
                                        } else {
                                            echo '</a> </div> </div> ';
                                        }
                                    } else {
                                        echo '<p>' . $teams[$i] . ' Lead</p> </a> </div> </div> ';
                                    }

                                    if ($leadCount == 0) {
                                        echo '</div> </div> <div class="member"> <div class="title"> <h2>TEAM MEMBER</h2> </div> ';
                                        $memberPerRow = 0;
                                    }
                                } else {
                                    if ($memberPerRow == 0) {
                                        echo '<div class="row">';
                                    }
                                    echo '<div class="col-md-4"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

                                    // Get the profile picture
                                    if (file_exists('../../upload_content/user_images/' . $row['id'] . '.png')) {
                                        echo '"/upload_content/user_images/' . $row['id'] . '.png?' . time() . '"';
                                    } else {
                                        echo '"/assets/images/default_profile.png?' . time() . '" width="150"';
                                    }

                                    echo ' alt="service 1"> </div> <h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3> ';

                                    if ($teams[$i] === 'First Year Mentorship') {
                                        echo '<p>Mentee</p> </a> </div> </div> ';
                                    } else {
                                        echo '<p>' . $teams[$i] . ' Member</p> </a> </div> </div> ';
                                    }

                                    $memberPerRow++;
                                    if ($memberPerRow == 3) {
                                        echo '</div>';
                                        $memberPerRow = 0;
                                    }
                                }
                            }
                            if ($memberPerRow != 0) {
                                echo '</div>';
                                $memberPerRow = 0;
                            }
                            echo '</div>';
                        }
                    }
                }
            }
            echo '</div>';
        }
        ?>
    </div>
    <!-- Service section end -->

    <?php
    print_footnote();
    ?>

</div>
<!--container-->
<?php
//print the footer	
print_footer();
?>