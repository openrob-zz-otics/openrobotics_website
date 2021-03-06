<?php
//include our library and start drawing the page
require_once("../../php_include/functions.php");
$page_name = "blog";
print_header($page_name, false);
print_navbar();
?>
<div class="container">
    <div class="row span-content mtt-content">
        <div class="col-sm-8 pt-5">
            <?php

            //the limit controls how many posts are displayed on one page
            $limit = 5;
            //the offset is where to start displaying posts
            $offset = intval(@$_GET['offset']);
            if ($db = get_db()) {
                //get a number of total blog posts
                $query = "SELECT * FROM `blog_posts` WHERE `visible`='1' AND `is_disabled`='0';";
                $result = $db->query($query);
                $count = $result->num_rows;

                //get the correct number of blog posts with correct offset
                $query = "SELECT * FROM `blog_posts` WHERE `visible`='1' AND `is_disabled`='0' ORDER BY `publish_time` DESC LIMIT $offset,$limit;";
                $index = 0;
                if ($result = $db->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        //find out who wrote this blog post. (!!!!JOIN THIS WITH PREVIOUS QUERY)
                        $query = "SELECT `first_name`, `last_name` FROM `user_info` WHERE `id`='" . $row['created_by'] . "';";
                        $asoc = $db->query($query)->fetch_assoc();
                        $name = $asoc['first_name'] . ' ' . $asoc['last_name'];

                        //print blog post info and snippet
                        echo '<div class="row">';
                        echo '	<div class="col-sm-12">';
                        if ($index > 0)
                            echo '<hr>';
                        echo '		<a href="post?id=' . $row['id'] . '"><h3>' . htmlspecialchars($row['title']) . '</h3></a>';
                        echo '		<div style="padding-left:2%">';
                        echo '			<h4>' . htmlspecialchars($row['sub_title']) . '</h4>';
                        echo '			<h5>Published At ' . $row['publish_time'] . ', By <a href="/contact/user?id=' . $row['created_by'] . '">' . $name . '</a></h5>';
                        echo '			<hr>';
                        echo '			<span id="disp-content">' . htmlspecialchars($row['short_desc']) . '</span>';
                        echo '      	<br/><br/><a href="post?id=' . $row['id'] . '"><strong>Read this post...</strong></a>';
                        echo '		</div>';
                        echo '	</div>';
                        echo '</div>';
                        $index++;
                    }
                }

                //display buttons for older/newer posts when relevant
                if ($count > $offset + $limit || $offset) {
                    echo '<hr><div class="row">';
                    echo '	<div class="col-sm-8">';
                    if ($count > $offset + $limit) {
                        echo '	<span style="float:right;"><a href="?offset=' . ($offset + 5) . '"><button type="button" class="btn btn-default btn-sm">Older Posts&raquo;</button></a></span>';
                    }
                    if ($offset) {
                        echo '<a href="?offset=' . ($offset - 5) . '"><button type="button" class="btn btn-default btn-sm">&laquo; Newer Posts</button></a>';
                    }
                    echo '	</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>DB Error.</p>";
            }
            ?>
        </div>
        <!-- List all posts by month-->
        <div class="col-sm-4 pt-5">
            <?php
            if ($db) {
                //!!!!!!USE THE FIRST QUERY WE MADE TO GET NUMBER OF BLOG POSTS!!!
                $query = "SELECT * FROM `blog_posts` WHERE `visible`='1' AND `is_disabled`='0' ORDER BY `publish_time` DESC;";
                if ($result = $db->query($query)) {
                    $month = "";
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $date = new DateTime($row['publish_time']);
                        $new_month = $date->format('F');
                        if ($new_month != $month) {
                            $month = $new_month;
                            $year = $date->format('Y');
                            if ($i++ == 0) {
                                echo "<h4 class='expand' data-id='month_$month' data_down='1' id='title_$month'>
										$month $year
										<span id='icon_$month' style='float:right;' class='glyphicon glyphicon-chevron-down'></span>
										</h4>";
                                echo "<div id='month_$month'><ul>";
                            } else {
                                echo "</ul></div>";
                                echo "<h4 class='expand' data-id='month_$month' data_down='0' id='title_$month'>
										$month $year
										<span id='icon_$month' style='float:right;' class='glyphicon glyphicon-chevron-down'></span>
										</h4>";
                                echo "<div id='month_$month' style='display:none;'><ul>";
                            }
                        }
                        echo '<a href="post?id=' . $row['id'] . '"><li>' . $row['title'] . " - " . $row['publish_time'] . "</li></a>";
                    }
                    echo "</ul></div>";
                }
                $db->close();
            }
            ?>
        </div>
    </div>
    <br /><br />
    <?php
    print_footnote();
    ?>

</div><!-- /.container -->
<?php
//print the footer	
print_footer();
?>