<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "badges";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Badges</h1>
		</div>
	</div>

	
	<?php
		if ($db = get_db()) {
			$query = "SELECT * FROM `badges` WHERE `is_disabled`='0' AND `visible`='1';";
			if ($result = $db->query($query)) {
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					if ($i++ > 0)
						echo '<hr>';
					echo '<div class="row"><div class="col-sm-10">';
					echo '<a href="..?id='.$row['id'].'"><h3>'.ucwords(strtolower($row['name'])).'</h3></a>';
					echo '<p>Difficulty: '.ucfirst(strtolower($row['difficulty'])).'</p>';
					echo '<p>'.$row['instructions'].'</p>';
					echo '</div><div class="col-sm-2">';
					echo '<a href="..?id='.$row['id'].'"><img class="img-responsive" src="/upload_content/badge_images/small/'.$row['id'].'.png" /></a>';
					echo '</div></div>';
				}
			}
		}
	?>
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>