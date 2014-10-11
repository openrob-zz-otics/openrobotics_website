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
	`linkedin` TEXT NOT NULL,
	`personal_site` TEXT NOT NULL,
	`open_robotics_position` TEXT NOT NULL,
	`education` TEXT NOT NULL,
	`employment` TEXT NOT NULL,
	`bio` TEXT NOT NULL,
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
	`content` TEXT NOT NULL,	
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `blog_posts.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `training_posts` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`created_by` BIGINT(20) UNSIGNED NOT NULL,
	`publish_time` DATETIME NOT NULL,
	`title` TEXT NOT NULL,
	`sub_title` TEXT,
	`content` TEXT NOT NULL,	
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	CONSTRAINT `training_posts.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
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

CREATE TABLE IF NOT EXISTS `badges` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`instructions` TEXT NOT NULL,
	`difficulty` TEXT NOT NULL,
	`category` BIGINT(20) UNSIGNED NOT NULL,
	`visible` TINYINT(1) UNSIGNED NOT NULL,
	`is_disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	CONSTRAINT `badges.fk_category`
		FOREIGN KEY (`category`)
		REFERENCES `badge_categories`(`id`)
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
	
INSERT INTO `users` VALUES ('1', 'intelligence@openrobotics.ca', '6c527bf7ce0349c332f828ec79fa1eac', '0', '0', '0');
INSERT INTO `user_info` (`id`, `first_name`, `last_name`) VALUES ('1', 'Open', 'Robotics');
INSERT INTO `user_permissions` VALUES ('1', '1', '1', '1', '1', '1', '1', '1');
