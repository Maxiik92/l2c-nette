/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.6.5-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `user` (
	`id` int (11),
	`name` varchar (765),
	`surname` varchar (765),
	`email` varchar (765),
	`password` varchar (300),
	`last_login_date` datetime ,
	`register_date` datetime 
); 
