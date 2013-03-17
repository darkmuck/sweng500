CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `lesson_id` int(8) NOT NULL,
  `lesson_status` varchar(11) DEFAULT 'Incomplete',
  `bookmark_type` varchar(6) DEFAULT  'system',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `user_id` (`user_id`)
) ;

ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`);
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);



INSERT INTO `bookmarks` ( `user_id`, `lesson_id`, `lesson_status`) VALUES (2, 2, 'Complete');


INSERT INTO `bookmarks` ( `user_id`, `lesson_id`, `lesson_status`) VALUES (2, 3, 'Incomplete');
INSERT INTO `bookmarks` ( `user_id`, `lesson_id`, `lesson_status`) VALUES (2, 4, 'Incomplete');