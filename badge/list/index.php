<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "badges";
	print_header($page_name, false);
	print_navbar();


	$name = @$_GET['search_name'];
	$difficulty = @$_GET['search_difficulty'];
	$category = @$_GET['search_category'];
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-inline" action="." method="get" style="margin-top:20px;float:right;">
				<div class="form-group">
					<label class="sr-only" for="search_name">Search Name</label>
					<input type="text" class="form-control" id="search_name" name="search_name" placeholder="Search Name" 
					<?php if (strlen($name)) echo "value='$name'"; ?>/>
				</div>
				<div class="form-group">
					<label class="sr-only" for="search_difficulty">Search Difficulty</label>
					<input type="text" class="form-control" id="search_difficulty" name="search_difficulty" placeholder="Search Difficulty" 
					<?php if (strlen($difficulty)) echo "value='$difficulty'"; ?>/>
				</div>
				<div class="form-group">
					<label class="sr-only" for="search_category">Search Category</label>
					<input type="text" class="form-control" id="search_category" name="search_category" placeholder="Search Category" 
					<?php if (strlen($category)) echo "value='$category'"; ?>/>
				</div>
				<button type="submit" class="btn btn-default">Search</button>
			</form>
			<h1>Badges</h1>
		</div>
	</div>
	<div id="list_container">
	<?php		
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
			
			echo "<hr>";

			if ($result = $db->query($query)) {
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					//if ($i++ > 0)
					//	echo '<hr>';
					//echo '<div class="row"><div class="col-sm-12">';
					//echo '<div style="float:right;">';
					//echo '<a href="..?id='.$row['id'].'"><img class="img-responsive" style="max-width:150px;" src="/upload_content/badge_images/small/'.$row['id'].'.png" /></a>';
					//echo '</div>';
					//echo '<a href="..?id='.$row['id'].'"><h3>'.ucwords(strtolower($row['name'])).'</h3></a>';
					//echo '<p>Difficulty: '.ucfirst(strtolower($row['difficulty'])).'</p>';
					//echo '<p>Category: '.ucfirst(strtolower($row['category_name'])).'</p>';
					//echo '<p>'.$row['instructions'].'</p>';
					//echo '</div><div class="col-sm-2">';
					//echo '</div></div>';
					
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
	</div>	
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>