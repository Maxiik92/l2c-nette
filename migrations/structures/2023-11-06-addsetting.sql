CREATE TABLE `setting` (
  `name` varchar(255) NOT NULL,
  `value` longtext NOT NULL
) ENGINE='InnoDB';

ALTER TABLE `setting`
ADD PRIMARY KEY `name` (`name`);