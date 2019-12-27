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
            $teams = array('Admin', 'Robocup Gripper', 'Robocup Drivetrain', 'Robocup Arm', 'Robocup Software', 'PianoBot', 'ArtBot');
            for ($i = 0; $i < count($teams); $i++) {
                // Query each team, from team lead to team members
                $query = "SELECT * FROM `users` JOIN `user_info` ON `users`.`id`=`user_info`.`id` JOIN `team_members` ON `users`.`id`=`team_members`.`id` WHERE `users`.`is_disabled`='0' AND `users`.`id` IN (SELECT `id` FROM `user_permissions` WHERE `in_contact_list`='1') AND `users`.`id` IN (SELECT `id` FROM `team_members` WHERE `team_name`='" . $teams[$i] . "') ORDER BY `team_lead` DESC;";

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

                        echo '<div class="lead"> <!-- Start title section --> <div class="row-fluid"> <div class="title span' . $leadSectionDivision . '"> ';

                        // Query the team description
                        $query2 = "SELECT * FROM `teams` WHERE `team_name`='" . $teams[$i] . "';";
                        if ($result2 = $db->query($query2)) {
                            $row2 = $result2->fetch_assoc();
                            echo '<h2>' . strtoupper($row2['team_name']) . '</h2> <p>' . $row2['team_desc'] . '</p> </div>';
                        }

                        // Rerun the query to place the pointer at the beginning
                        if ($result = $db->query($query)) {
                            while ($row = $result->fetch_assoc()) {
                                if ($leadCount > 0) {
                                    $leadCount--;
                                    echo '<div class="span' . $leadSectionDivision . '"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

                                    // Get the profile picture
                                    if (file_exists('../../upload_content/user_images/' . $row['id'] . '.png')) {
                                        echo '"/upload_content/user_images/' . $row['id'] . '.png?' . time() . '"';
                                    } else {
                                        echo '"/assets/images/default_profile.png?' . time() . '" width="150"';
                                    }

                                    echo ' alt="service 1"> </div> <h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3> <p>' . $teams[$i] . ' Lead</p> </a> </div> </div> ';

                                    if ($leadCount == 0) {
                                        echo '</div> </div> <div class="member"> <div class="title"> <h2>TEAM MEMBER</h2> </div> <div class="row-fluid"> ';
                                    }
                                } else {
                                    echo '<div class="span4"> <div class="centered service"> <a href="/contact/user?id=' . $row['id'] . '"> <div class="circle-border zoom-in"> <img class="img-circle" src=';

                                    // Get the profile picture
                                    if (file_exists('../../upload_content/user_images/' . $row['id'] . '.png')) {
                                        echo '"/upload_content/user_images/' . $row['id'] . '.png?' . time() . '"';
                                    } else {
                                        echo '"/assets/images/default_profile.png?' . time() . '" width="150"';
                                    }

                                    echo ' alt="service 1"> </div> <h3>' . $row['first_name'] . ' ' . $row['last_name'] . '</h3> <p>' . $teams[$i] . ' Member</p> </a> </div> </div> ';
                                }
                            }
                        }
                        echo '</div> </div> ';
                    }
                }
            }
        }
        ?>
    </div>

    <!-- <div class="lead">
            <div class="row-fluid">
                <div class="title span4">
                    <h2>SOFTWARE TEAM</h2>
                    <p>This is our biggest sub-team with the most amount of work. The software team writes code to take in information about the robot’s surroundings and makes decisions about where the to go next. If you are interested in working in pathfinding, mapping, computer vision, networking or systems integration, software has projects for you!</p>
                </div>
                <div class="span4">
                    <div class="centered service">
                        <a href="/contact/user?id=1">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="/upload_content/user_images/software/members/1.png" alt="service 1">
                            </div>
                            <h3>Naruto Uzumaki</h3>
                            <p>Hokage</p>
                        </a>
                    </div>
                </div>
                <div class="span4">
                    <div class="centered service">
                        <a href="/contact/user?id=1">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="/upload_content/user_images/software/members/1.png" alt="service 1">
                            </div>
                            <h3>Naruto Uzumaki</h3>
                            <p>Hokage</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="member">
            <div class="title">
                <h2>TEAM MEMBER</h2>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="centered service">
                        <a href="/contact/user?id=1">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="/upload_content/user_images/software/members/1.png" alt="service 1" href="/contact/user?id=1">
                            </div>
                            <h3>Naruto Uzumaki</h3>
                            <p>Hokage</p>
                        </a>
                    </div>
                </div>
                <div class="span4">
                    <div class="centered service">
                        <a href="/contact/user?id=1">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="/upload_content/user_images/software/members/2.png" alt="service 2" href="/contact/user?id=1" />
                            </div>
                            <h3>Sasuke Uchiha</h3>
                            <p>Hokage bestfriend</p>
                        </a>
                    </div>
                </div>
                <div class="span4">
                    <div class="centered service">
                        <a href="/contact/user?id=1">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="/upload_content/user_images/software/members/3.png" alt="service 3" href="/contact/user?id=1">
                            </div>
                            <h3>Sakura Hatano</h3>
                            <p>Hokage bestfriend's wife</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

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