<!-- Style 1 Project page 
	1/3 page description text
	2/3 page images on top of each other

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
	<div class="col-md-4">
	<?php					
		//Print a list of contributors, using the data we got before, including project creator
		echo "<h4>Contributors:</h4><ul class='list'>";

		for ($i = 0; $i < count($first_name_array); $i++) {
			echo "<li><a href='/contact/user?id=".$contributor_ids[$i]."'>";
			echo $first_name_array[$i].' '.$last_name_array[$i]."</a></li>";
		}
		echo "</ul>";
						
		//display project start end date						
		echo "<p>Started: ".$project_data['start_time']."<br />";
		if (isset($project_data['finish_time'])) {
			echo "Finished: ".$project_data['finish_time']."</p>";
		} else {
			echo "Ongoing project</p><hr>";
		}						

		//display description
		echo "<span class='disp-content'>".$project_data['description']."</span>";

		//start second column
		echo '</div><div class="col-md-8">';


		//(after checking it exists), show all images in the project related to this project
		if (file_exists("../../upload_content/project_images/".$project_id."/")) {
			$array = scandir("../../upload_content/project_images/".$project_id."/");
			foreach ($array as $val) {
				//don't display main picture if set so				
				if ($val[0] == '0' && $project_data['hide_main_picture'])
					continue;
				$var = explode('.', $val);
				$ext = strtolower(array_pop($var));
				if (in_array($ext, $acceptable_image_extensions)) {
		
					echo "<img class='img-responsive img-thumbnail' src='/upload_content/project_images/".$project_id."/$val'>";

				}
			}
		}
	?>
	</div>
</div>

					
					