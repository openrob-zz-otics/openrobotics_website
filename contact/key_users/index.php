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
		
				$query .= " ORDER BY (SELECT COUNT(`id`) FROM `user_badges` WHERE `user_badges`.`user_id`=`users`.`id`) DESC;";
				if ($result = $db->query($query)) {
					while ($row = $result->fetch_assoc()) {
						echo '<hr><div class="row"><div class="col-sm-4" ><center><a href="/contact/user?id='.$row['id'].'"><img src=';
						if (file_exists('../../upload_content/user_images/'.$row['id'].'.png')) {
							echo '"/upload_content/user_images/'.$row['id'].'.png?'.time().'"';
						} else {
							echo '"/assets/images/default_profile.png?'.time().'" width="150"';
						}
						echo ' alt="'.$row['first_name'].' '.$row['last_name'].'" class="img-responsive img-thumbnail"></a></center>
						</div><div class="col-sm-8"><p><a href="/contact/user?id='.$row['id'].'" style="font-size:large;">'.$row['first_name'].' '.$row['last_name'].'</a><br />'.$row['open_robotics_position'].'<br />'.$row['education'].'</p><hr><p>'
						. ((strlen($row['bio']) > 200) ? substr($row['bio'], 0, 200)."<a href='/contact/user?id=".$row['id']."'>... read more.</a>" : $row['bio']).'</p>';
						$query = "SELECT `id`, `name` FROM `badges` WHERE `is_disabled`='0' AND `id` IN (SELECT `badge_id` FROM `user_badges` WHERE `user_id`='".$row['id']."');";
						if ($result2 = $db->query($query)) {
							$i = 0;
							while ($row2 = $result2->fetch_assoc()) {
								if ($i == 0) {
									echo '<div class="row">';
								}
								echo '<div class="col-xs-1">';
								echo '<a href="/badge?id='.$row2['id'].'"><img data-toggle="tooltip" data-placement="top" title="'.$row2['name'].'" class="img-responsive badge_image" style="max-width:50px;" src="/upload_content/badge_images/small/'.$row2['id'].'.png"></a>';
								echo '</div>';
								if ($i++ == 11) {
									echo '</div>';
									$i = 0;
								}

							}
						}
						if ($i > 0) {
							echo '</div>';
						}
						echo '</div></div>';
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
