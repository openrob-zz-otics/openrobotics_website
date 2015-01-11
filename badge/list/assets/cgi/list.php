<?php
	require_once("../../../../php_include/functions.php");
	$name = @$_POST['name'];
	$difficulty = @$_POST['difficulty'];
	$category = @$_POST['category'];
	if ($db = get_db()) {
		$name = $db->real_escape_string($name);
		$difficulty = $db->real_escape_string($difficulty);
		$category = $db->real_escape_string($category);

		$query = "SELECT *FROM `badges` WHERE `is_disabled`='0' AND `visible`='1'";
		if (strlen($name) > 0) 
			$query .= " AND `name` LIKE '%$name%'";
		if ($difficulty > 0) 
			$query .= " AND `difficulty`='$difficulty'";
		if ($category > 0) 
			$query .= " AND `category`='$category'";
		$query .=";";

		echo "<hr>";

		//6 badge per line list
		if ($result = $db->query($query)) {
			$i = 0;
			while ($row = $result->fetch_assoc()) {
				
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
		}
	}

?>