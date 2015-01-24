<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name, false);
	print_navbar();
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12" style="margin-top:25px;margin-bottom:25px;text-align:center;">
				<div class="btn-group" role="group" aria-label="...">
					<a href="?upcoming=0"><button type="button" class="btn btn-default btn-lg">Current and Complete Projects</button></a>
					<a href="?upcoming=1"><button type="button" class="btn btn-default btn-lg">Upcoming Projects</button></a>
				</div>
			</div>
		</div>
	</div>

	<?php
		$p = intval(@$_GET['upcoming']);
		if($db = get_db()) {
			$query = "SELECT * FROM `projects` WHERE `is_upcoming_project`='$p' AND `is_featured`='1' AND `visible`='1' AND `is_disabled`='0';";
			if ($result = $db->query($query)) {			
		
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
			<p style="font-family:'klinic-slab-book';"><?php if($p) echo 'Featured Upcoming Projects'; else echo 'Featured Projects';?></p>
		</div>
		
		<div class="carousel-inner">
				
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
	<h3><?php if($p) echo 'All Upcoming Projects'; else echo 'All Projects';?></h3>
	<div class="row">
		<div class="col-sm-6">
			<?php 
				if (!$p)
					echo "<h4>Projects in Progress</h4>";
			?>
	<?php
		if($db) {
			$query = "SELECT * FROM `projects` WHERE `is_upcoming_project`='$p' AND `visible`='1' AND `is_disabled`='0';";

			if ($result = $db->query($query)) {
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					if (isset($row['finish_time']))
						continue;
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";
			}
		}
	?>
		</div>
		<?php 
			if (!$p)
			echo '<div class="col-sm-6"><h4>Finished Projects</h4>';
	
		if($db && !$p) {
			$query = "SELECT * FROM `projects` WHERE `visible`='1' AND `is_disabled`='0';";

			if ($result = $db->query($query)) {
				echo "<ul>";
				while ($row = $result->fetch_assoc()) {
					if (!isset($row['finish_time']))
						continue;
					echo '<li><a href="project?id='.$row['id'].'">';
					echo $row['name'];
					echo "</a></li>";
				}
				echo "</ul>";
			}
			$db->close();
		}
	?>
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