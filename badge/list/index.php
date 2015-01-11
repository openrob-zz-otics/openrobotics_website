<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "badges";
	print_header($page_name, false);
	print_navbar();

	//badge search parameters
	$name = @$_GET['search_name'];
	$difficulty = @$_GET['search_difficulty'];
	$category = @$_GET['search_category'];
?>

<div class="container">

	<!--search form-->
	<div class="row">
		<div class="col-sm-12">
			<form class="form-inline" action="." method="get" style="margin-top:20px;float:right;">
				<div class="form-group">
					<label class="sr-only" for="search_name">Search Name</label>
					<input type="text" class="form-control" id="search_name" name="search_name" placeholder="Search Name" 
					<?php if (strlen($name)) echo "value='$name'"; ?>/>
				</div>
				<select class="form-control" id="search_difficulty" name="search_difficulty">
					<label class="sr-only" for="search_difficulty">Search Difficulty</label>
				  	<option value='-1'>Difficulty (All)</option>
				  	<?php
				  		if ($db = get_db()) {
				  			$query = "SELECT * FROM `badge_difficulties` WHERE `id`!='0';";
				  		}
				  		if ($result = $db->query($query)) {
				  			while ($row = $result->fetch_assoc()) {
					  			echo "<option value='".$row['id']."'";
					  			if (strlen($difficulty) && $difficulty == $row['id'])
					  				echo " selected";
					  			echo ">".$row['difficulty_name']."</option>";
							}
				  		}
				  	?>
				</select>
				<select class="form-control" id="search_category" name="search_category">
					<label class="sr-only" for="search_category">Search Category</label>
				  	<option value='-1'>Category (All)</option>
				  	<?php
				  		if ($db = get_db()) {
				  			$query = "SELECT * FROM `badge_categories` WHERE `id`!='1';";
				  		}
				  		if ($result = $db->query($query)) {
				  			while ($row = $result->fetch_assoc()) {
					  			echo "<option value='".$row['id']."'";
					  			if (strlen($category) && $category == $row['id'])
					  				echo " selected";
					  			echo ">".$row['category_name']."</option>";
							}
				  		}
				  	?>
				</select>
				<button type="submit" class="btn btn-default">Search</button>
			</form>
			<h1>Badges</h1>
		</div>
	</div><!--row-->

	<!--badge list container-->
	<div id="list_container">
	<?php
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
	</div><!--list container-->
<?php 
	print_footnote();
?>
</div><!--container-->

<?php 
	//print the footer	
	print_footer();
?>