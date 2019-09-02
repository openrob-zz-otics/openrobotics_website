<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "projects";
	print_header($page_name, false);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>Projects</h2>
		</div>
	</div>
	<?php
	if ($db = get_db()) {
		$query = "SELECT * FROM `projects` WHERE `is_featured`='1' AND `visible`='1';";
		if ($result = $db->query($query)) {
			while ($row = $result->fetch_assoc()) {
				echo '<hr><div class="row"><div class="col-sm-4"><center><a href="/projects/project/?id='.$row['id'].'"><img src=';
				if (file_exists('../upload_content/project_images/'.$row['id'].'/0.png')) {
					echo '"/upload_content/project_images/'.$row['id'].'/0.png"';
				} else {
					echo '"/assets/images/default_profile.png" width="150"';
				}
				echo ' alt="'.$row['name'].'" class="img-responsive img-thumbnail"></a></center>
				</div><div class="col-sm-8"><p><a href="/projects/project?id='.$row['id'].'" style="font-size:large;">'.$row['name'].'</a><br/></p><hr><p>'.((strlen($row['description']) > 200) ? substr($row['description'], 0, 200)."<a href='/projects/project?id=".$row['id']."'>... Read more</a>" : $row['description']).'</p></div></div>';
				
			}
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