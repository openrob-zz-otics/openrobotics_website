<?php 
/*
 * This file contains globally useful functions
 *
 * Author: Jonathan Chapple
 *
 */
date_default_timezone_set('America/Vancouver');
 
require_once("login_functions.php");
/*
class ValidateSessionResult {
	public $valid_user = RETURN_NULL;
	public $valid_session = RETURN_NULL;
	public $session_expired = RETURN_NULL;
	
	public $validate_success = true;
	
	public $db_error = false;
}

*/

/* -- Constants -- */
$donate_link = "https://donate.support.ubc.ca/page/20924/donate/1?transaction.dirgift=Open+Robotics+Student+Team%20G1102";

/* -- Globals -- */
$user_email = "";
$user_first_name = "";
$logged_in = false;
$user_id = 0;
/* -- User Permissions -- */
$manage_users = false;
$add_projects = false;
$manage_all_projects = false;
$add_blog_post = false;
$manage_all_blog_posts = false;
$send_email = false;

function check_login() {
	if (isset($_SESSION['email']) && isset($_SESSION['session_id'])) {
		$result = validate_session($_SESSION['email'], $_SESSION['session_id']);
		if ($result->validate_success) {
			$GLOBALS['logged_in'] = true;
			$GLOBALS['user_email'] = $_SESSION['email'];
			if ($db = get_db()) {
				$query = "SELECT `first_name`, `id` FROM `user_info` WHERE `id` in (SELECT `id` FROM `users` WHERE `email`='".$GLOBALS['user_email']."');";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {
						$GLOBALS['user_id'] = $row['id'];
						$GLOBALS['user_first_name'] = $row['first_name'];
					}
				}
				$query = "SELECT * FROM `user_permissions` WHERE `id`='".$GLOBALS['user_id']."';";
				if ($result = $db->query($query)) {
					if ($row = $result->fetch_assoc()) {
						$GLOBALS['manage_users'] = $row['manage_users'];
						$GLOBALS['add_projects'] = $row['add_projects'];
						$GLOBALS['manage_all_projects'] = $row['manage_all_projects'];
						$GLOBALS['add_blog_post'] = $row['add_blog_post'];
						$GLOBALS['manage_all_blog_posts'] = $row['manage_all_blog_posts'];
						$GLOBALS['send_email'] = $row['send_email'];					
					}
				}
				$db->close();
			}
			
		}
	}
}

function isLoggedIn() {
	return $GLOBALS['logged_in'];
}

function canManageUsers() {
	return $GLOBALS['manage_users'];
}

function canAddProjects() {
	return $GLOBALS['add_projects'];
}

function canManageAllProjects() {
	return $GLOBALS['manage_all_projects'];
}

function canAddBlogPost() {
	return $GLOBALS['add_blog_post'];
}

function canManageAllBlogPosts() {
	return $GLOBALS['manage_all_blog_posts'];
}

function canSendEmail() {
	return $GLOBALS['send_email'];
}

/* --- Page Building functions --- */

/*
 * Print the html header for a page
 * takes one argument, which is the title of the page,
 * which goes between <title></title>
 */
function print_header($page_title, $is_locked_page) {
	define("PAGE_TITLE", $page_title);
	@session_start();
	check_login();
	if ($is_locked_page && !isLoggedIn()) {
		header("Location: /");
	}
	include("header.php");
}

/*
 * prints the footer for the page, which includes
 * all of the js and css
 */
function print_footer() {
	include("footer.php");
}

/*
 * prints the navbar
 */
function print_navbar() {
	include("navigation.php");
}

/*
 * prints the footnote
 */
function print_footnote() {
	include("footnote.php");
}

/* Send a message with good headers */
function myMail($to, $subject, $message) {
	$headers = "From: doNotReply@openrobotics.ca\r\n";
	$headers .= "Reply-To: doNotReply@openrobotics\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
	
	return mail($to, $subject, $message, $headers);
}

function myMailFrom($to, $subject, $message, $from) {
	$headers = "From: $from\r\n";
	$headers .= "Reply-To: $from\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
	
	return mail($to, $subject, $message, $headers);
}

// from
// http://stackoverflow.com/questions/5341168/best-way-to-make-links-clickable-in-block-of-text
function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
}

$acceptable_image_extensions = array("png", "jpg", "jpen", "gif");

function start_PageDisplayText($page_name) {
	$r_data = array();
	if ($db = get_db()) {
		$query = "SELECT * FROM `display_text` WHERE `text_location` IN (SELECT `id` FROM `text_locations` WHERE `location_name`='$page_name' OR `location_name`='global');";
		if ($result = $db->query($query)) {
			while ($row = $result->fetch_assoc()) {
				array_push($r_data, $row);
			}
		}
		$db->close();
		return $r_data;
	}
	return NULL;	
}
function get_PageDisplayText($r_data, $name) {
	if (!is_null($r_data)) {
		foreach ($r_data as $data) {
			if ($data['text_name'] == $name) {
				return $data['text_content'];
			}
		}
	}
	return "Error Connecting to the database.";
}

?>
