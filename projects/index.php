<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name, false);
	print_navbar();
?>
	<?php
		if($db = get_db()) {
			$query = "SELECT * FROM `projects` WHERE `is_featured`='1' AND `visible`='1' AND `is_disabled`='0';";
			if ($result = $db->query($query)) {
				/*echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";*/
			
		
	?>
	<div id="myCarousel" class="carousel slide carousel_resize" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<?php
				for ($i = 0; $i < $result->num_rows; $i++) {
					echo '<li data-target="#myCarousel" data-slide-to="'.$i.'" '.($i==0?'class="active"':'').'></li>';
				}
			?>
		</ol>
		
		<div id="carousel-overlay">
			<p style="font-family:'klinic-slab-book';">Featured Project</p>
		</div>
		
		<div class="carousel-inner">
			<!--<div class="item carousel_resize active">
				<img src="/assets/images/carousel/0.jpg" class="carousel_resize">
				<div class="container">
					<div class="carousel-caption">
						<button type="button" class="btn btn-default btn-lg transparent-button">
							<a href="/projects/">View Projects</a>
						</button>	
					</div>
				</div>
			</div>-->
			
			<?php
			$i = 0;
			while ($row = $result->fetch_assoc()) {
				echo '<div class="item carousel_resize '.($i==0?'active':'').'">
						<img src="/upload_content/project_images/'.$row['id'].'/0.png" class="carousel_resize">
						<div class="container">
						<div class="carousel-caption">
							<p style="font-size:xx-large;" class="hidden-xs">'.$row['name'].'</p>
							<p style="font-size:large;" class="visible-xs">'.$row['name'].'</p>
							<a href="project?id='.$row['id'].'"><button type="button" class="btn btn-default transparent-button">View Project</button></a>
						</div></div></div>';
				$i++;
			}	
			}}
			?>

		</div>
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
	<div class="container">
	<br />
	<h3>All Projects</h3>
	
	<?php
		if($db) {
			$query = "SELECT * FROM `projects` WHERE `visible`='1' AND `is_disabled`='0';";
			if ($result = $db->query($query)) {
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";
			}
			$db->close();
		}
	?>
	
	<?php
		print_footnote();
	?>

</div><!-- /.container -->
<?php 
	//print the footer	
	print_footer();
?>