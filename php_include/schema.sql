CREATE TABLE IF NOT EXISTS `users` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(50) NOT NULL,
	`password` VARCHAR(60) NOT NULL COMMENT '(md5)',
	`registration_time` DATETIME NOT NULL,
	`registration_ip` TEXT NOT NULL,
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
	`manage_users` TINYINT(1) UNSIGNED NOT NULL,
	`add_projects` TINYINT(1) UNSIGNED NOT NULL,
	`manage_all_projects` TINYINT(1) UNSIGNED NOT NULL,
	`add_blog_post` TINYINT(1) UNSIGNED NOT NULL,
	`manage_all_blog_posts` TINYINT(1) UNSIGNED NOT NULL,
	`in_contact_list` TINYINT(1) UNSIGNED NOT NULL,
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
	`start_time` DATETIME NOT NULL,
	`finish_time` DATETIME,
	`name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY(`id`),
	CONSTRAINT `projects.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
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
	PRIMARY KEY(`id`),
	CONSTRAINT `blog_posts.fk_user`
		FOREIGN KEY (`created_by`)
		REFERENCES `users`(`id`)
		ON DELETE CASCADE
);