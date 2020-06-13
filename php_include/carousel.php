<div id="myCarousel" class="carousel slide carousel_resize" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        //(after checking it exists), add all images
        if (file_exists("assets/images/carousel/")) {
            $array = scandir("assets/images/carousel/");
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

    <div id="carousel-overlay">
        <p id="carousel-overlay-title" style="text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;"><span style="color: red;">UBC </span><span style="color: white;">OPEN ROBOTICS</span></p>
        <br/>
        <p id="carousel-overlay-slogan" style="text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; color: white;">Creating robots, improving humans</p>
    </div>

    <div class="carousel-inner">

        <?php
        //(after checking it exists), add all images
        if (file_exists("assets/images/carousel/")) {
            $array = scandir("assets/images/carousel/");
            $i = 0;
            foreach ($array as $val) {
                $var = explode('.', $val);
                $ext = strtolower(array_pop($var));
                if (in_array($ext, $acceptable_image_extensions)) {
                    echo
                        '<div class="item carousel_resize ' . (!$i++ ? 'active' : '') . '">
						<img src="/assets/images/carousel/' . $val . '" class="carousel_resize">
					</div>';
                }
            }
        }
        ?>
    </div>
</div>