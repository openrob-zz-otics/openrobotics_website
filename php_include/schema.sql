CREATE TABLE IF NOT EXISTS `users` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NOT NULL,
	`password` VARCHAR(60) NOT NULL COMMENT '(md5)',
	`registration_time` DATETIME NOT NULL,
	`registration_ip` TEXT NOT NULL,	
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `sessions` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`session_id` TEXT NOT NULL,
	`session_time` DATETIME NOT NULL,
	`session_ip` TEXT NOT NULL,
	`session_expire` DATETIME NOT NULL,
	PRIMARY KEY(`id`),
	CONSTRAINT `sessions.fk_user`
		FOREIGN KEY (`user_id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `user_permissions` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`manage_users` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`add_projects` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`manage_all_projects` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`add_blog_post` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`manage_all_blog_posts` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`in_contact_list` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`send_email` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `user_permissions.fk_user`
		FOREIGN KEY (`id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `user_info` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`first_name` TEXT NOT NULL,
	`middle_name` TEXT NOT NULL,
	`last_name` TEXT NOT NULL,
	`ubc_student_number` INT(10) UNSIGNED NOT NULL,
	`contact_email` TEXT NOT NULL,
	`linkedin` TEXT NULL,
	`personal_site` TEXT NULL,
	`open_robotics_position` TEXT NOT NULL,
	`education` TEXT NULL,
	`employment` TEXT NULL,
	`bio` TEXT NULL,
	PRIMARY KEY(`id`),	
	CONSTRAINT `user_info.fk_user`
		FOREIGN KEY (`id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `projects` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`created_by` BIGINT(20) UNSIGNED NOT NULL,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`is_featured` TINYINT(1) UNSIGNED NOT NULL,
	`start_time` DATE NOT NULL,
	`finish_time` DATE,
	`name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`hide_main_picture` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`is_upcoming_project` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`display_type` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `projects.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `project_contributors` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`project_id` BIGINT(20) UNSIGNED NOT NULL,
	PRIMARY KEY(`id`),
	CONSTRAINT `project_contributors.fk_user`
		FOREIGN KEY (`user_id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE,
	CONSTRAINT `project_contributors.fk_project`
		FOREIGN KEY (`project_id`)
		REFERENCES `projects`(`id`)
		ON DELETE CASCADE	
);

CREATE TABLE IF NOT EXISTS `blog_posts` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`created_by` BIGINT(20) UNSIGNED NOT NULL,
	`publish_time` DATETIME NOT NULL,
	`title` TEXT NOT NULL,
	`sub_title` TEXT,
	`short_desc` TEXT NOT NULL,
	`content` TEXT NOT NULL,	
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `blog_posts.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `training_categories` (
	`training_category_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`training_category_name` TEXT NOT NULL,
	`training_category_description` TEXT NOT NULL,
	PRIMARY KEY(`training_category_id`)
);

CREATE TABLE IF NOT EXISTS `training_posts` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`created_by` BIGINT(20) UNSIGNED NOT NULL,
	`publish_time` DATETIME NOT NULL,
	`title` TEXT NOT NULL,
	`sub_title` TEXT,
	`category`BIGINT(20) UNSIGNED NOT NULL,
	`content` TEXT NOT NULL,	
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `training_posts.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE,
	CONSTRAINT `training_posts.fk_training_category`
		FOREIGN KEY (`category`)
		REFERENCES `training_categories`(`training_category_id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `mailing_list_recipients` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` TEXT NOT NULL,
	`registration_time` DATETIME NOT NULL,
	`registration_ip` TEXT NOT NULL,
	`is_enabled` TINYINT(1) NOT NULL DEFAULT '0',
	`verification_key` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `contact_form_messages` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` TEXT NOT NULL,
	`name` TEXT NOT NULL,
	`message` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `roster` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`email` TEXT NOT NULL,
	`phone` TEXT NOT NULL,
	`year` TINYINT(1) UNSIGNED NOT NULL,
	`major` TEXT NOT NULL,
	`student_number` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `training_completion` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`training_id` BIGINT(20) UNSIGNED NOT NULL,
	PRIMARY KEY(`id`),
	CONSTRAINT `training_completion.fk_user`
		FOREIGN KEY (`user_id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE,
	CONSTRAINT `training_completion.fk_training_posts`
		FOREIGN KEY (`training_id`)
		REFERENCES `training_posts`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `badge_categories` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`category_name` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `badge_difficulties` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`difficulty_name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);
################################
#
# FIX THE GODDAMN FK CONSTRAINTS
#
#################################


CREATE TABLE IF NOT EXISTS `badges` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`instructions` TEXT NOT NULL,
	`difficulty` BIGINT(20) UNSIGNED NOT NULL,
	`category` BIGINT(20) UNSIGNED NOT NULL,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	CONSTRAINT `badges.fk_category`
		FOREIGN KEY (`category`)
		REFERENCES `badge_categories`(`id`)
		ON DELETE CASCADE,
	CONSTRAINT `badges.fk_difficulty`
		FOREIGN KEY (`difficulty`)
		REFERENCES `badge_difficulties`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `user_badges` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`badge_id` BIGINT(20) UNSIGNED NOT NULL,
	PRIMARY KEY(`id`),
	CONSTRAINT `user_badges.fk_user_id`
		FOREIGN KEY (`user_id`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE,
	CONSTRAINT `user_badges.fk_badge_id`
		FOREIGN KEY (`badge_id`)
		REFERENCES `badges`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `text_locations` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`location_name` TEXT NOT NULL,
	`location_display_name` TEXT NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE IF NOT EXISTS `display_text` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`text_location` BIGINT UNSIGNED NOT NULL,
	`text_name` TEXT NOT NULL,
	`text_display_name` TEXT NOT NULL,
	`text_content` TEXT,
	PRIMARY KEY(`id`)
);

#default text to display
INSERT INTO `text_locations` VALUES('1', 'global', 'Global');
INSERT INTO `text_locations` VALUES('2', 'home', 'Home Page');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('1', 'donate_text', 'Donate Text', 'UBC Open Robotics is a new team, and we\'re working on growing our team and expanding our reach. We would graciously accept donations to help us reach our goal of competing in RoboCup 2016. For more details on sponshorship, please use our contact form. Thank you!');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'l_heading', 'Left Heading', 'Training');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'm_heading', 'Middle Heading', 'Future Projects');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'r_heading', 'Right Heading', 'Get Involved');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'l_par', 'Left Paragraph', 'Open Robotics offers training for different disciplines involved in robotics. The training is freely available on this website.');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'm_par', 'Middle Paragraph', 'Our members have already worked on various projects. All of the projects are documented here on the website.');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'r_par', 'Right Paragraph', 'All UBC students are welcome to check us out and work on projects.');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'l_button', 'Left Button', 'View');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'm_button', 'Middle Button', 'View Projects');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'r_button', 'Right Button', 'View Details');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'first_heading', 'First Heading', 'Work on <span class="text-muted">unique and interesting projects.</span>');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'first_par', 'First Paragraph', 'Provide your skills to a current team. Aid in CAD, manufacturing, electrical design and programming.');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'second_heading', 'Second Heading', 'Let your idea <span class="text-muted">come to life.</span>');
INSERT INTO `display_text` (`text_location`, `text_name`, `text_display_name`, `text_content`) VALUES ('2', 'second_par', 'Second Paragraph', 'Have an idea? We can help you find the resources and pair you with more people like yourself.');

#Add a default user
INSERT INTO `users` VALUES ('1', 'intelligence@openrobotics.ca', '6c527bf7ce0349c332f828ec79fa1eac', '3000-01-01 00:00:00', '0', '0');
INSERT INTO `user_info` (`id`, `first_name`, `middle_name`, `last_name`, `ubc_student_number`, `contact_email`, `open_robotics_position`) VALUES ('1', 'Open', "", 'Robotics', 12345678, 'intelligence@openrobotics.ca', "admin");
INSERT INTO `user_permissions` VALUES ('1', '1', '1', '1', '1', '1', '1', '1');
