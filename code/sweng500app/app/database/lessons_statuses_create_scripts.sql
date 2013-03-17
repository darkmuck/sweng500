CREATE TABLE IF NOT EXISTS `lesson_statuses` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL,
  `lesson_id` int(8) NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `user_id` (`user_id`)
) ;

ALTER TABLE `lesson_statuses`
  ADD CONSTRAINT `lesson_statuses_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`);
ALTER TABLE `lesson_statuses`
  ADD CONSTRAINT `lesson_statuses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);




