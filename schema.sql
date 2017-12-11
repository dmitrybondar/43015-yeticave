CREATE DATABASE `yeticave`;

USE `yeticave`;

CREATE TABLE `categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) DEFAULT NULL,
  `class` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `registration_date` DATETIME DEFAULT NULL,
  `email` VARCHAR(64) DEFAULT NULL,
  `name` VARCHAR(64) DEFAULT NULL,
  `password` VARCHAR(72) DEFAULT NULL,
  `avatar` VARCHAR(64) DEFAULT NULL,
  `contacts` VARCHAR(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lots` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(64) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `start_date` DATETIME DEFAULT NULL,
  `end_date` DATETIME DEFAULT NULL,
  `img` VARCHAR(64) DEFAULT NULL,
  `price` INT(11) DEFAULT NULL,
  `bet_step` INT(11) DEFAULT NULL,
  `user_id` INT(11) DEFAULT NULL,
  `winner_id` INT(11) DEFAULT NULL,
  `category_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
	KEY `winner_id` (`winner_id`),
	KEY `category_id` (`category_id`),
	CONSTRAINT `lots_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
	CONSTRAINT `lots_fk_2` FOREIGN KEY (`winner_id`) REFERENCES `users`(`id`),
	CONSTRAINT `lots_fk_3` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `value` INT(11) DEFAULT NULL,
  `user_id` INT(11) DEFAULT NULL,
  `lot_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lot_id` (`lot_id`),
  CONSTRAINT `bets_fk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `bets_fk_2` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX `email` ON users(email);
CREATE UNIQUE INDEX `category` ON categories(title);