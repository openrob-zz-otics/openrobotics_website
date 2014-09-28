<?php
	//include our library and start drawing the page
	require_once("../php_include/functions.php");
	$page_name = "badge";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<?php
				$id = intval(@$_GET['id']);
				if($id > 0 && $db = get_db()) {
					$query = "SELECT * FROM `badges` INNER JOIN `badge_categories` ON `badges`.`category`=`badge_categories`.`id` WHERE `badges`.`id`='$id' AND `badges`.`is_disabled`='0';";
					if ($result = $db->query($query)) {
						if ($row = $result->fetch_assoc()) {
							//print_r($row);
							echo "<h1>".ucwords(strtolower($row['name']))."</h1>";
							echo "<h3>Category: ".ucwords(strtolower($row['category_name']))."</h3>";
							echo "<h3>Difficulty: ".ucfirst(strtolower($row['difficulty']))."</h3>";
							echo "<h3>Description</h3>";
							echo "<p>".$row['description']."</p>";
							echo "<h3>How to get it</h3>";
							echo "<p>How to get".$row['instructions']."</p>";
						}
					} else {
						echo "error: ".$dbs->error;
					}
				}  
			?>
		</div>
		<div class="col-sm-4">
			<?php
				echo "<img class='img-responsive' src='/upload_content/badge_images/large/".$id.".png' />";
			?>
		</div>
		<div class="col-sm-4">
			<h3>Users with this badge:</h3>
			<ul>
			<?php
			if ($id > 0 && $db) {
				$query = "SELECT * FROM `user_info` WHERE `id` IN (SELECT `user_id` FROM `user_badges` WHERE `badge_id`='$id');";
				if ($result = $db->query($query)) {
					while ($row = $result->fetch_assoc()) {
						echo "<li><a href='/contact/user?id=".$row['id']."'>".$row['first_name'].' '.$row['last_name']."</a></li>";
					}
				}
				$db->close();
			}
			?>
			</ul>
		</div>
	</div>			
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>