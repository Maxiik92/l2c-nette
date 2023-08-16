/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.6.5-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `comment` (
	`id` int (11),
	`post_id` int (11),
	`name` varchar (765),
	`email` varchar (765),
	`content` text ,
	`created_at` datetime 
); 
