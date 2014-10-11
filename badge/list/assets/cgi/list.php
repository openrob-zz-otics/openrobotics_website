<?php
	require_once("../../../../php_include/functions.php");
	$name = @$_POST['name'];
	$difficulty = @$_POST['difficulty'];
	$category = @$_POST['category'];
	if ($db = get_db()) {
		$name = $db->real_escape_string($name);
		$difficulty = $db->real_escape_string($difficulty);
		$category = $db->real_escape_string($category);

		$query = "SELECT `badges`.`id`, `badges`.`name`, `badges`.`difficulty`, `badges`.`instructions`, `badge_categories`.`category_name` FROM `badges` INNER JOIN `badge_categories` ON `badges`.`category`=`badge_categories`.`id` WHERE `badges`.`is_disabled`='0' AND `badges`.`visible`='1'";
		if (strlen($name) > 0) 
			$query .= " AND `badges`.`name` LIKE '%$name%'";
		if (strlen($difficulty) > 0) 
			$query .= " AND `badges`.`difficulty` LIKE '%$difficulty%'";
		if (strlen($category) > 0) 
			$query .= " AND `badge_categories`.`category_name` LIKE '%$category%'";
		$query .=";";
		if ($result = $db->query($query)) {
			$i = 0;
			while ($row = $result->fetch_assoc()) {
				// if ($i++ > 0)
				// 	echo '<hr>';
				// echo '<div class="row"><div class="col-sm-10">';
				// echo '<a href="..?id='.$row['id'].'"><h3>'.ucwords(strtolower($row['name'])).'</h3></a>';
				// echo '<p>Difficulty: '.ucfirst(strtolower($row['difficulty'])).'</p>';
				// echo '<p>Category: '.ucfirst(strtolower($row['category_name'])).'</p>';
				// echo '<p>'.$row['instructions'].'</p>';
				// echo '</div><div class="col-sm-2">';
				// echo '<a href="..?id='.$row['id'].'"><img class="img-responsive" src="/upload_content/badge_images/small/'.$row['id'].'.png" /></a>';
				// echo '</div></div>';
				if ($i == 0) {
					echo '<div class="row">';
				}
				echo "<div class='col-sm-2'>";
				echo '<a href="..?id='.$row['id'].'"><img class="img-responsive" src="/upload_content/badge_images/small/'.$row['id'].'.png" /></a>';
				echo "</div>";
				if ($i == 5) {
					echo '</div>';
					$i = 0;
				} else {
					$i++;
				}
			}
			if ($i == 0) {
				echo '<div class="row"><div class="col-sm-12"><p>No Results Found</p></div></div>';
			}
		}
	}
?>