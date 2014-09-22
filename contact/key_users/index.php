<?php
	//include our library and start drawing the page
	require_once("../../php_include/functions.php");
	$page_name = "key_users";
	print_header($page_name, false);
	print_navbar();
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h2>Key People</h2>
		</div>
	</div>
		<?php
			if ($db = get_db()) {
				$query = "SELECT * FROM `users` JOIN `user_info` ON `users`.`id`=`user_info`.`id` WHERE `users`.`is_disabled`='0' AND `users`.`id` IN (SELECT `id` FROM `user_permissions` WHERE `in_contact_list`='1')";
				//Use this line to override the order in key_users page (sorry...)
				$query .= "ORDER BY CASE `users`.`id` WHEN '2' THEN 0 WHEN '7' THEN 1 WHEN '3' THEN 2 WHEN '8' THEN 3 WHEN '11' THEN 4 WHEN '4' THEN 5 WHEN '6' THEN 6 ELSE 7 END ASC;";
				if ($result = $db->query($query)) {
					while ($row = $result->fetch_assoc()) {
						echo '<hr><div class="row"><div class="col-sm-4" ><center><a href="/contact/user?id='.$row['id'].'"><img src=';
						if (file_exists('../../upload_content/user_images/'.$row['id'].'.png')) {
							echo '"/upload_content/user_images/'.$row['id'].'.png"';
						} else {
							echo '"/assets/images/default_profile.png" width="150"';
						}
						echo ' alt="'.$row['first_name'].' '.$row['last_name'].'" class="img-responsive img-thumbnail"></a></center>
						</div><div class="col-sm-8"><p><a href="/contact/user?id='.$row['id'].'" style="font-size:large;">'.$row['first_name'].' '.$row['last_name'].'</a><br />'.$row['open_robotics_position'].'<br />'.$row['education'].'</p><hr><p>'.$row['bio'].'</p></div></div>';
					}
				}
				$db->close();
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