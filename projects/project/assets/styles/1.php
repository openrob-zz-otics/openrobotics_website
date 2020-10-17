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

<div class="row mtt-content">
    <div class="col-md-12 project-header">
        <!-- print project name-->
        <?php
        //(after checking it exists), show all images in the project related to this project
        if (file_exists("../../upload_content/project_images/" . $project_id . "/")) {
            $array = scandir("../../upload_content/project_images/" . $project_id . "/");
            echo "<img class='img-responsive img-thumbnail' src='/upload_content/project_images/" . $project_id . "/header.png'>";
        }
        ?>
    </div>
</div>
<div class="row mtt-content">
    <div class="col-md-12 project-content">
        <?php
        echo "<h1>" . $project_data['name'] . "</h1>";

        //display project start end date						
        echo "<p>Started: " . $project_data['start_time'] . "<br />";
        if (isset($project_data['finish_time'])) {
            echo "Finished: " . $project_data['finish_time'] . "</p>";
        } else {
            echo "Ongoing project</p><hr>";
        }

        echo "<span class='disp-content'>" . $project_data['description'] . "</span><br><br>";
        ?>
    </div>
</div>