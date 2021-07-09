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
            $teams = array('Admin', 'ArtBot', 'PianoBot', 'Robocup Arm', 'Robocup Drivetrain', 'Robocup Gripper', 'Robocup Software');
            for ($i = 0; $i < count($teams); $i++) {
                echo '<div class="team-section">';
                
                // Admin team is represented according to seniority
                if ($teams[$i] === 'Admin') {
                    $query = "SELECT * FROM `users` JOIN `user_info` ON `users`.`id`=`user_info`.`id` JOIN `team_members` ON `users`.`id`=`team_members`.`id` WHERE `users`.`is_disabled`='0' AND `users`.`id` IN (SELECT DISTINCT `id` FROM `user_permissions` WHERE `in_contact_list`='1') AND `team_members`.`team_name`='" . $teams[$i] . "' ORDER BY FIELD(`users`.`id`,'1', '24', '20','6','98','100','62','65','66','64');";
                }
                else {
                    // Query each team, from team lead to team members
                    $query = "SELECT * FROM `users` JOIN `user_info` ON `users`.`id`=`user_info`.`id` JOIN `team_members` ON `users`.`id`=`team_members`.`id` WHERE `users`.`is_disabled`='0' AND `users`.`id` IN (SELECT DISTINCT `id` FROM `user_permissions` WHERE `in_contact_list`='1') AND `team_members`.`team_name`='" . $teams[$i] . "' ORDER BY `team_lead` DESC, `last_name` ASC;";
                }

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
                        $leadSectionDivision = ($leadCount >= 3) ? 12 : 12 - ($leadCount * 3);

                        echo '<div class="lead" id="' . $teams[$i] . '"> <!-- Start title section --> <div class="row mtt-content"> <div class="title col-md-' . $leadSectionDivision . '"> ';

                        // Query the team description
                        $query2 = "SELECT * FROM `teams` WHERE `team_name`='" . $teams[$i] . "';";
                        if ($result2 = $db->query($query2)) {
                            $row2 = $result2->fetch_assoc();
                            echo '<h2>' . strtoupper($row2['team_name']) . '</h2> <p>' . $row2['team_desc'] . '</p> </div>';
                        }

                        if ($leadCount >= 3) {
                            echo '</div><div class="row mtt-content">';
                        }

                        $leadPerRow = 0;
                        $memberPerRow = 0;
                        // Rerun the query to place the pointer at the beginning
                        if ($result = $db->query($query)) {
                            while ($row = $result->fetch_assoc()) {
                                if ($leadCount > 0) {
                                    $leadCount--;
                                    $memberPerRow++;
                                    echo '<div class="col-md-3"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

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
                                    } else {
                                        echo '<p>' . $teams[$i] . ' Lead</p> </a> </div> </div> ';
                                    }

                                    if ($leadPerRow == 3) {
                                        echo '</div><div class="row mtt-content">';
                                        $leadPerRow = 0;
                                    }
                                    if ($leadCount == 0) {
                                        echo '</div> </div> <div class="member"> <div class="title"> <h2>TEAM MEMBER</h2> </div> ';
                                        $leadPerRow = 0;
                                        $memberPerRow = 0;
                                    }
                                } else {
                                    if ($memberPerRow == 0) {
                                        echo '<div class="row mtt-content">';
                                    }
                                    echo '<div class="col-md-3"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

                                    // Get the profile picture
                                    if (file_exists('../../upload_content/user_images/' . $row['id'] . '.png')) {
                                        echo '"/upload_content/user_images/' . $row['id'] . '.png?' . time() . '"';
                                    } else {
                                        echo '"/assets/images/default_profile.png?' . time() . '" width="150"';
                                    }

                                    echo ' alt="service 1"> </div> <h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3> ';
                                    
                                    # Admin members have their own unique titles 
                                    if ($teams[$i] === 'Admin') {
                                        if ($row['id'] == 20) {
                                            echo '<p>Web Development Lead</p> </a> </div> </div>';
                                        }
                                        else if ($row['id'] == 100) {
                                            echo '<p>Finance Lead/Treasurer</p> </a> </div> </div>';
                                        }
                                        else if ($row['id'] == 62 || $row['id'] == 65 || $row['id'] == 66) {
                                            echo '<p>Finance Member</p> </a> </div> </div>';
                                        }
                                        else if ($row['id'] == 98) {
                                            echo '<p>Graphic Designer</p> </a> </div> </div>';
                                        }
                                        else if ($row['id'] == 6) {
                                            echo '<p>Web Developer</p> </a> </div> </div>';
                                        }
                                        else if ($row['id'] == 64) {
                                            echo '<p>Safety Officer</p> </a> </div> </div>';
                                        }
										else if ($row['id'] == 24) {
											echo '<p>Mentor</p> </a> </div> </div>';
										} 
										else if ($row['id'] == 1) {
											echo '<p>Integration Lead</p> </a> </div> </div>';
										}
                                    }
                                    else if ($teams[$i] === 'First Year Mentorship') {
                                        echo '<p>Mentee</p> </a> </div> </div> ';
                                    } else {
                                        echo '<p>' . $teams[$i] . ' Member</p> </a> </div> </div> ';
                                    }

                                    $memberPerRow++;
                                    if ($memberPerRow == 4 || $row['id'] == 98 || $row['id'] == 24 || $row['id'] == 1) {
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
                            echo '<div class="h-divider"> <div class="shadow"> </div> </div>';
                        }
                    }
                }
                echo '</div>';
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