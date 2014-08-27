<?php 
	define("CLASS_ACTIVE", 'class="active"');
?>


<!-- Fixed navbar -->
<div id="nav_container" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="line hidden-xs" id="left_line" style="position: absolute; transform: rotate(0deg); width: 400px; top: 120px; left: 10px;"></div>
	
	<div class="line hidden-xs" id="right_line" style="position: absolute; transform: rotate(0deg); width: 400px; top: 120px; left: 550px;"></div>

	<div class="container navbar-inner navbar-full" id="cred_navbar">
		<?php
		if (isset($GLOBALS['logged_in']) && $GLOBALS['logged_in']) {
			echo '<div class="hidden-xs" id="right_nav">'
					.'<ul class="nav navbar-nav">';
			
			echo '<li><a href="/manage/profile">Your Profile</a></li>';
			if (canAddProjects() || canManageAllProjects())
				echo '<li><a href="/manage/projects">Manage Projects</a></li>';
			if (canAddBlogPost() || canManageAllBlogPosts())
				echo '<li><a href="/manage/blog">Manage Blog</a></li>';
			if (canManageUsers())
				echo '<li><a href="/manage/users">Manage Users</a></li>';
			if (canSendEmail())
				echo '<li><a href="/email/send_email">Email</a></li>';	
		
		
			echo '</ul>'
				.'</div>'
				.'<div class="visible-xs">'
				.'<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="manage_dropdown_control">Manage<span class="caret"></span></a>'
				.'<ul class="dropdown-menu" role="menu" id="manage_dropdown_menu">';
			echo '<li><a href="/manage/profile">Your Profile</a></li>';
			if (canAddProjects() || canManageAllProjects())
				echo '<li><a href="/manage/projects">Manage Projects</a></li>';
			if (canAddBlogPost() || canManageAllBlogPosts())
				echo '<li><a href="/manage/blog">Manage Blog</a></li>';
			if (canManageUsers())
				echo '<li><a href="/manage/users">Manage Users</a></li>';
			if (canSendEmail())
				echo '<li><a href="/email/send_email">Email</a></li>';	

		
				
			echo '</ul>'
				.'</a>'
				.'</div>';
		}
		?>
		<ul class="nav navbar-nav navbar-right right-override">
			<?php 
			if (isset($GLOBALS['logged_in']) && $GLOBALS['logged_in']) {
				echo '<li class="nav_float_fix heading-text">Welcome, '.$GLOBALS['user_first_name'].'</li>'
					. '<li class="nav_float_fix"><a class="nav_float_fix" href="/logout">Logout</a></li>';
			} else {
				echo '<li class="nav_float_fix"><a class="nav_float_fix" href="/login">Login</a></li>'
					. '<li class="nav_float_fix"><a class="nav_float_fix" href="/register">Sign-up</a></li>';
			}
			?>
		</ul>
	</div>
	<div class="container navbar-inner navbar-full">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand hidden-lg hidden-md hidden-sm" href="/"><img src="/assets/images/logo.gif" class="img" id="logo_small">Open Robotics</a>
		</div>
		
		<div class="nav-center hidden-xs">
			<a href="/"><img src="/assets/images/logo.gif" class="img" id="logo" width="100"></a>
		</div>
		
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li <?php if(PAGE_TITLE == "recruitment") echo CLASS_ACTIVE;?>><a style="padding-left:0px;" href="/recruitment/">Recruitment</a></li>
				<li <?php if(PAGE_TITLE == "projects") echo CLASS_ACTIVE;?>><a href="/projects/">Projects</a></li>
				<li <?php if(PAGE_TITLE == "blog") echo CLASS_ACTIVE;?>><a href="/blog/">Blog</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li <?php if(PAGE_TITLE == "tech") echo CLASS_ACTIVE;?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tech<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a class='heading-text' href="/training/">Training</a></li>
						<li><a class='heading-text' href="//wiki.<?php echo $_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']=='80' ? '' : ':'.$_SERVER['SERVER_PORT']); ?>">wiki</a></li>
					</ul>			
				</li>
				<li <?php if(PAGE_TITLE == "contact") echo CLASS_ACTIVE;?> class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Contact <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a class='heading-text' href="/contact/">Contact Form</a></li>
						<li><a class='heading-text' href="/contact/key_users">Key People</a></li>
						<!--<li class="divider"></li>-->
						<!--<li class="dropdown-header" class='heading-text'>Member Pages</li>-->
						<?php
							/*
							if ($db = get_db()) {
								$query = "SELECT * FROM `user_info` WHERE `id` in (SELECT `id` FROM `user_permissions` WHERE `in_contact_list`='1');";
								if ($result = $db->query($query)) {
									while ($row = $result->fetch_assoc()) {
										echo "<li><a class='heading-text' href='/contact/user?id=".$row['id']."'>";
										echo $row['first_name']." ".$row['last_name'];
										echo "</a></li>";
									}
								}	
								$db->close();
							}*/
						?>
					</ul>
				
				<li <?php if(PAGE_TITLE == "about") echo CLASS_ACTIVE;?>><a href="/about/">About</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	</div>
</div>

<!-- in order to push things down -->
<div id="main_container">