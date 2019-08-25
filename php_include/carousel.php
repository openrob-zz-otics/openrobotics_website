<div id="myCarousel" class="carousel slide carousel_resize" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php
		//(after checking it exists), add all images
		if (file_exists("assets/images/carousel/")) {
			$array = scandir("assets/images/carousel/");
			$i=0;
			foreach ($array as $val) {
				$var = explode('.', $val);
				$ext = strtolower(array_pop($var));
				if (in_array($ext, $acceptable_image_extensions)) {		
					echo '<li data-target="#myCarousel" data-slide-to="0" class="'.(!$i++?'active':'').'"></li>';
				}
			}
		}
		?>
	</ol>
	
	<div id="carousel-overlay">
		<p style="font-family:'klinic-slab-book';">Creating Robots, Improving Humans.</p>
	</div>
	
	<div class="carousel-inner">

		<?php
		//(after checking it exists), add all images
		if (file_exists("assets/images/carousel/")) {
			$array = scandir("assets/images/carousel/");
			$i=0;
			foreach ($array as $val) {
				$var = explode('.', $val);
				$ext = strtolower(array_pop($var));
				if (in_array($ext, $acceptable_image_extensions)) {		
					echo 
					'<div class="item carousel_resize '.(!$i++?'active':'').'">
						<img src="/assets/images/carousel/'.$val.'" class="carousel_resize">
						<div class="container">
							<div class="carousel-caption">
								<button type="button" class="btn btn-default btn-lg transparent-button">
									<a href="/projects/">View Projects</a>
								</button>	
							</div>
						</div>
					</div>';
				}
			}
		}
		?>
	</div>
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>