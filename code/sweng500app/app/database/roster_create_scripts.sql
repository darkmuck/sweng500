
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(15) NOT NULL,
  `title` varchar(250) NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `descrip` varchar(250) DEFAULT NULL,
  `duration_min` int(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `author_id` int(8) NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


INSERT INTO `courses` (`id`, `course_name`, `title`, `enabled`, `descrip`, `duration_min`, `created`, `author_id`, `modified`) VALUES
(1, 'CS-200', 'Effective Writing. SRS for Beginners', 1, 'This course provides an introduction to successful development of a Software Requirment''s Specification document.', NULL, NULL, 1, NULL),
(2, 'CS-210', 'Effective Writing. SRS for Beginners Part2', 1, NULL, NULL, NULL, 1, NULL);
INSERT INTO courses (course_number, course_name, lesson_completion, quiz_passing_score, instructor, course_status) VALUES ("SWE200", "Nitty Gritty of SRS",100, 80, "Viscuso", "U");
INSERT INTO courses (course_number, course_name, lesson_completion, quiz_passing_score, instructor, course_status) VALUES ("SWE215", "SRS: Technical Writing", 100, 80, "Viscuso", "U");

ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);


CREATE TABLE IF NOT EXISTS `rosters` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `course_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `completion_status` varchar(11) DEFAULT 'Incomplete',
  `date_added` datetime DEFAULT NULL,
  `date_removed` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `archived`  int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ;

ALTER TABLE `rosters`
  ADD CONSTRAINT `rosters_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
ALTER TABLE `rosters`
  ADD CONSTRAINT `rosters_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);


INSERT INTO `rosters` ( `course_id`, `user_id`, `completion_status`, `date_added`, `date_completed`) VALUES
(1, 1, 'Complete', '2013-02-18', '2013-02-21');
INSERT INTO `rosters` ( `course_id`, `user_id`, `completion_status`, `date_added`, `date_completed`) VALUES
(2, 1, 'Incomplete', '2013-02-18', NULL);
INSERT INTO `rosters` ( `course_id`, `user_id`, `completion_status`, `date_added`, `date_completed`) VALUES
(2, 2, 'Incomplete', '2013-02-18', NULL);
INSERT INTO `rosters` ( `course_id`, `user_id`, `completion_status`, `date_added`, `date_completed`) VALUES
(1, 2, 'Not Started', '2013-02-18', NULL);



INSERT INTO users (username, password, enabled, type_id, last_name, middle_name, first_name, created, modified)
    VALUES ('tester2', PASSWORD('tester'), 1, 1, 'Tester', 'Tester', 'Tester', NOW(), NOW());
INSERT INTO types_users (type_id, user_id) VALUES (3, 2);
INSERT INTO types_permissions (type_id, permission_id) VALUES (3, 1);


