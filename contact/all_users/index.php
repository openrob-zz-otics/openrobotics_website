<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "all_users";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2>User Index</h2>
		</div>
	</div>
		<ul>
		<?php
			if ($db = get_db()) {
				//list all users
				$query = "SELECT `id`, `first_name`, `last_name` FROM `user_info` WHERE `id` IN (SELECT `id` FROM `users` WHERE `id`!='1' AND `is_disabled`='0')";
				$query .= " ORDER BY `last_name`;";
				//echo $query;
				if ($result = $db->query($query)) {
					while ($row = $result->fetch_assoc()) {
							echo '<li><a href="../user?id='.$row['id'].'">'.$row['last_name'].', '.$row['first_name'].'</a></li>';
						}
				}
				$db->close();
			}
		?>
		</ul>
<?php 
	print_footnote();
?>

</div><!--container-->
<?php 
	//print the footer	
	print_footer();
?>