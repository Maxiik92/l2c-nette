-- Adminer 4.8.1 MySQL 5.5.5-10.6.5-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `role` (`id`, `name`) VALUES
(1,	'guest'),
(2,	'user'),
(3,	'moderator'),
(4,	'admin');


INSERT INTO `user_x_role` (`id`, `user_id`, `role_id`) VALUES
(1,	1,	1),
(2,	2,	4);
-- 2023-08-16 10:38:25