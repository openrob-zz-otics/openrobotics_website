<div id="myCarousel" class="carousel slide carousel_resize" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        //(after checking it exists), add all images
        if (file_exists("../assets/images/carousel_projects/")) {
            $array = scandir("../assets/images/carousel_projects/");
            $i = 0;
            foreach ($array as $val) {
                $var = explode('.', $val);
                $ext = strtolower(array_pop($var));
                if (in_array($ext, $acceptable_image_extensions)) {
                    echo '<li data-target="#myCarousel" data-slide-to="0" class="' . (!$i++ ? 'active' : '') . '"></li>';
                }
            }
        }
        ?>
    </ol>

    <?php
    echo '<div class="carousel-inner">';
    //(after checking it exists), add all images
    if (file_exists("../assets/images/carousel_projects/")) {
        $array = scandir("../assets/images/carousel_projects/");
        $i = 0;
        if ($db = get_db()) {
            foreach ($array as $val) {
                $query = "SELECT * FROM `projects` WHERE `id`='" . $val . "';";
                if ($result = $db->query($query)) {
                    $row = $result->fetch_assoc();
                    $var = explode('.', $val);
                    $ext = strtolower(array_pop($var));
                    if (in_array($ext, $acceptable_image_extensions)) {
                        echo
                            '<div class="item carousel_resize ' . (!$i++ ? 'active' : '') . '">
                        <img src="../assets/images/carousel_projects/' . $val . '" class="carousel_resize">';
                        echo '<div class="carousel-caption carousel-title"> <h3>' . $row['name'] . '</h3> </div>';
                        echo '</div>';
                    }
                }
            }
        }
    }
    echo '</div>';

    ?>
    <!-- 
    <div id="carousel-overlay">
        <p style="font-family:'klinic-slab-book';">Creating Robots, Improving Humans.</p>
    </div> -->

    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>