<?php
define("CLASS_ACTIVE", 'class="active"');
?>


<!-- Fixed navbar -->
<div id="nav_container" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="line hidden-xs" id="left_line" style="display:none;position: absolute; transform: rotate(0deg); width: 400px; top: 120px; left: 10px; z-index:1;"></div>

    <div class="hidden-xs">
        <a href="/" title="Home">
            <img src="/assets/images/logo.png" class="img" id="logo" width="130" text="home" style="position: absolute;top: 50px; left:410px;">
        </a>
    </div>

    <div class="line hidden-xs" id="right_line" style="display:none;position: absolute; transform: rotate(0deg); width: 400px; top: 120px; left: 550px; z-index:1;"></div>

    <div class="container navbar-inner navbar-full" id="cred_navbar">
        <?php
        if (isset($GLOBALS['logged_in']) && $GLOBALS['logged_in']) {
            echo '<div class="hidden-sm hidden-xs" id="right_nav">'
                . '<ul class="nav navbar-nav">';
            echo '<li><a href="/manage/profile">Your Profile</a></li>';
            if (canAddProjects() || canManageAllProjects())
                echo '<li><a href="/manage/projects">Manage Projects</a></li>';
            if (canAddBlogPost() || canManageAllBlogPosts())
                echo '<li>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Postings<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/manage/blog">Manage Blog</a></li>
						<li><a href="/manage/training">Manage Training</a></li>
						<li><a href="/manage/badges">Manage Badges</a></li>
					</ul>
					</a>					
					</li>';
            if (canManageUsers())
                echo '<li>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin Tools<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/manage/users">Manage Users</a></li>
						<li><a href="/manage/display">Manage Content</a></li>
					</ul>
					</a>					
					</li>';
            if (canSendEmail())
                echo '<li><a href="/email/send_email">Email</a></li>';
            echo '</ul>'
                . '</div>'
                . '<div class="visible-sm visible-xs">'
                . '<a href="#" class="dropdown-toggle heading-text" data-toggle="dropdown" id="manage_dropdown_control">Manage<span class="caret"></span></a>'
                . '<ul class="dropdown-menu" role="menu" id="manage_dropdown_menu">';
            echo '<li><a href="/manage/profile">Your Profile</a></li>';
            if (canAddProjects() || canManageAllProjects())
                echo '<li><a href="/manage/projects">Manage Projects</a></li>';
            if (canAddBlogPost() || canManageAllBlogPosts())
                echo '<li><a href="/manage/blog">Manage Blog</a></li>
					<li><a href="/manage/training">Manage Training</a></li>
					<li><a href="/manage/badges">Manage Badges</a></li>';
            if (canManageUsers())
                echo '<li><a href="/manage/users">Manage Users</a></li>';
            if (canSendEmail())
                echo '<li><a href="/email/send_email">Email</a></li>';



            echo '</ul>'
                . '</a>'
                . '</div>';
        }
        ?>
        <ul class="nav navbar-nav navbar-right right-override">
            <?php
            if (isset($GLOBALS['logged_in']) && $GLOBALS['logged_in']) {
                echo '<li class="nav_float_fix heading-text">Welcome, ' . $GLOBALS['user_first_name'] . '</li>'
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
            <a class="navbar-brand hidden-lg hidden-md hidden-sm" href="/"><img src="/assets/images/logo.png" class="img" id="logo_small">Open Robotics</a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-nav-custom">
                <?php if (PAGE_TITLE == "projects")
                    echo '<li class="dropdown active"><a href="/projects/">Projects</span></a>';
                else
                    echo '<li class="dropdown"><a href="/projects/">Projects</span></a>';
                ?>
                <ul class="dropdown-menu" role="menu">
                    <?php
                    if ($db = get_db()) {
                        $query = "SELECT * FROM `projects`;";
                        if ($result = $db->query($query)) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<li><a class="heading-text" href="/projects/project?id=' . $row['id'] . '">' . $row['name'] . '</a></li>';
                            }
                        }
                    }
                    ?>
                </ul>
                <?php echo '</li>' ?>;
                <li <?php if (PAGE_TITLE == "key_users") echo CLASS_ACTIVE; ?>><a href="/contact/key_users">Meet the Team</a></li>
                <li <?php if (PAGE_TITLE == "recruitment") echo CLASS_ACTIVE; ?>><a href="/recruitment/">Recruitment</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (PAGE_TITLE == "blog" || PAGE_TITLE == "training" || PAGE_TITLE == "calendar")
                    echo '<li class="dropdown active"><a href="#">Resources</span></a>';
                else
                    echo '<li class="dropdown"><a href="#">Resources</span></a>';
                ?>
                <ul class="dropdown-menu" role="menu">
                    <li><a class='heading-text' href="/blog/">Blog</a></li>
                    <li><a class='heading-text' href="/training/">Training</a></li>
                    <li><a class='heading-text' href="/calendar/">Calendar</a></li>
                </ul>
                <?php echo '</li>' ?>;
                <li <?php if (PAGE_TITLE == "contact") echo CLASS_ACTIVE; ?>><a href="/contact/">Contact Us</a></li>
                <li <?php if (PAGE_TITLE == "donate") echo CLASS_ACTIVE; ?> style="padding-top: 12px;"><a href="<?php echo $GLOBALS['donate_link']; ?>"><button class="btn btn-primary btn-lg">Donate</button></a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<!-- in order to push things down -->
<div id="main_container">