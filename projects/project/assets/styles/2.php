<!-- Style 2 Project page 
	1st full width row: page description text
	2nd full width row: grid of page images

	The should be included from projects/project/index.php, since it relies in specific variables created there
	$project_data
	$first_name_array
	$last_name array
	$contributor_ids
	$project_id
	-->

<div class="row">
	<div class="col-md-12">
		<!-- print project name-->
		<h1><?php echo $project_data['name'];?></h1>
	</div>
</div>	
<div class="row">
	<div class="col-md-12">
	<?php	
		//Print a list of contributors, using the data we got before, including project creator				
		echo "<h4>Contributors:</h4><ul class='list'>";
		for ($i = 0; $i < count($first_name_array); $i++) {
			echo "<li><a href='/contact/user?id=".$contributor_ids[$i]."'>";
			echo $first_name_array[$i].' '.$last_name_array[$i]."</a></li>";
		}
		echo "</ul>";
						
		//print project start and end times						
		echo "<p>Started: ".$project_data['start_time']."<br />";
		if (isset($project_data['finish_time'])) {
			echo "Finished: ".$project_data['finish_time']."</p>";
		} else {
			echo "Ongoing project</p><hr>";
		}						

		//print discussion
		echo "<span class='disp-content'>".$project_data['description']."</span>";

		//start new row
		echo '</div><div class="row">';

		//(after checking it exists), show all images in the project related to this projects
		if (file_exists("../../upload_content/project_images/".$project_id."/")) {
			$array = scandir("../../upload_content/project_images/".$project_id."/");
			foreach ($array as $val) {
				//don't display main picture if set so				
				if ($val[0] == '0' && $project_data['hide_main_picture'])
					continue;
				$var = explode('.', $val);
				$ext = strtolower(array_pop($var));
				if (in_array($ext, $acceptable_image_extensions)) {
					//put inside own column (don't need to make new rows)
					echo '<div class="col-md-3">';
					echo "<img class='img-responsive img-thumbnail' src='/upload_content/project_images/".$project_id."/$val'>";
					echo "</div>";
				}
			}
		}
	?>
	</div>
</div>

					
					