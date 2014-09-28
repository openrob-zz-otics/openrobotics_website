<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "badges";
	print_header($page_name, true);
	print_navbar();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>Manage Badges</h2>
		<div>
	</div>
<?php
if (!canManageUsers()) {
	echo '<div class="row"><div class="col-md-12"><h3>You do not have permission to be here</h3></div></div>';
} else {
	echo '<div class="row">
		<div class="col-sm-12">
			<a href="badge?id=0"><button class="btn btn-default">New Badge</button></a>
		</div>
		</div>';
		if ($db = get_db()) {
			$query = "SELECT * FROM `badges` WHERE `is_disabled`='0';";
			if ($result = $db->query($query)) {
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					if ($i++ > 0)
						echo '<hr>';
					if ($row['name'] == "") {
						$row['name'] = "[[No name]]";
					}
					echo '<div class="row"><div class="col-sm-10">';
					echo '<a href="badge?id='.$row['id'].'"><h3>'.ucwords(strtolower($row['name'])).'</h3></a>';
					echo '<p>Difficulty: '.ucfirst(strtolower($row['difficulty'])).'</p>';
					echo '<p>'.$row['instructions'].'</p>';
					echo '</div><div class="col-sm-2">';
					echo '<a href="badge?id='.$row['id'].'"><img class="img-responsive" src="/upload_content/badge_images/small/'.$row['id'].'.png" /></a>';
					echo '</div></div>';
				}
			}
		}



	echo '</div>';

}
print_footnote();
?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>