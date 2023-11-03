ALTER TABLE `comment`
    ADD `author_id` int(11) NOT NULL DEFAULT '2',
    ADD FOREIGN KEY (`author_id`) REFERENCES `user`(`id`);