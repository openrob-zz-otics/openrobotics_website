<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "display";
	print_header($page_name, true);
	print_navbar();
	if (!isLoggedIn()) {
		header("Location: /");
	}
?>

<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h2>Manage Content</h2>
			<?php
				if (!canManageUsers()) {
					echo '<h3>You do not have permissions to be here</h3>';
				} else {
					if ($db = get_db()) {

						echo '<p>Please choose a page to edit the content for.</p>';
						echo '<select class="form-control" id="location_select">';
						$query = "SELECT * FROM `text_locations`;";
						$result = $db->query($query);
						while ($row = $result->fetch_assoc()) {
							echo '<option value="'.$row['id'].'">'.$row['location_display_name'].'</option>';
						}				
						echo '<option value="-1">Edit Home Page Carousel</option>';
						echo '</select><br />';	
						echo '<button class="btn btn-default" id="location_button">Select</button><br /><hr>
						<div id="form_area"></div>';

					} else {
						echo '<h3>DB Error</h3>';
					}

				}
			?>
		</div>
		<div class="col-md-2"></div>
	</div>

	<?php
		print_footnote();
	?>

</div><!-- /.container -->


<?php 
	//print the footer	
	print_footer();
?>