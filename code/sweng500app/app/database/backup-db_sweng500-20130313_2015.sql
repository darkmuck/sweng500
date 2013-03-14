-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2013 at 01:14 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sweng500`
--
DROP DATABASE `sweng500`;
CREATE DATABASE `sweng500` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sweng500`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `question_id` int(8) NOT NULL,
  `value` varchar(50) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_fk` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `value`, `correct`, `created`, `modified`) VALUES
(14, 8, '55', 1, '2013-03-12 01:59:01', '2013-03-14 00:06:27'),
(15, 8, '66', 0, '2013-03-14 00:06:08', '2013-03-14 00:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(15) NOT NULL,
  `course_number` varchar(6) NOT NULL,
  `course_status` varchar(1) NOT NULL,
  `title` varchar(250) NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `descrip` varchar(250) DEFAULT NULL,
  `duration_min` int(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(8) NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_number`, `course_status`, `title`, `enabled`, `descrip`, `duration_min`, `created`, `user_id`, `modified`) VALUES
(1, 'CS-200', '', '', 'Effective Writing. SRS for Beginners', 1, 'This course provides an introduction to successful development of a Software Requirment''s Specification document.', NULL, NULL, 1, NULL),
(2, 'CS-210', '', '', 'Effective Writing. SRS for Beginners Part2', 1, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_contents`
--

DROP TABLE IF EXISTS `lesson_contents`;
CREATE TABLE IF NOT EXISTS `lesson_contents` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(8) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` int(8) NOT NULL,
  `file` longblob NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `course_id` int(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `main_content` text NOT NULL,
  `lesson_order` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `name`, `created`, `modified`, `main_content`, `lesson_order`) VALUES
(1, 1, 'testlesson1', '2013-03-10 18:26:24', '2013-03-10 18:26:24', '<p>asdfasdfasfads</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `created`, `modified`) VALUES
(1, '*', '2013-02-08 15:07:34', '2013-02-08 15:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(8) NOT NULL,
  `type` int(1) NOT NULL,
  `points` int(3) NOT NULL,
  `question` varchar(150) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`quiz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `type`, `points`, `question`, `created`, `modified`) VALUES
(1, 1, 1, 5, 'this is test question 1', NULL, NULL),
(2, 1, 1, 10, 'this is test question 2', NULL, NULL),
(3, 1, 1, 7, 'test question 3\r\n', '2013-03-10 19:46:35', '2013-03-10 19:46:35'),
(4, 1, 1, 7, 'test question 3\r\n', '2013-03-10 19:47:04', '2013-03-10 19:47:04'),
(8, 1, 4, 555, 'blahhhhhh', '2013-03-10 23:46:08', '2013-03-10 23:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

DROP TABLE IF EXISTS `quiz_submissions`;
CREATE TABLE IF NOT EXISTS `quiz_submissions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `question_id` int(8) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `points` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_sub_user_fk` (`user_id`),
  KEY `quiz_sub_quiz_fk` (`quiz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `quiz_id`, `user_id`, `question_id`, `answer`, `points`, `created`, `modified`) VALUES
(2, 1, 1, 1, 'a', NULL, '2013-03-14 01:06:35', '2013-03-14 01:06:35'),
(3, 1, 1, 2, 'b', NULL, '2013-03-14 01:06:35', '2013-03-14 01:06:35'),
(4, 1, 1, 3, 'c', NULL, '2013-03-14 01:06:35', '2013-03-14 01:06:35'),
(5, 1, 1, 4, 'd', NULL, '2013-03-14 01:06:35', '2013-03-14 01:06:35'),
(6, 1, 1, 8, '0', NULL, '2013-03-14 01:06:35', '2013-03-14 01:06:35'),
(7, 1, 1, 1, 'aaasadasd', NULL, '2013-03-14 01:10:15', '2013-03-14 01:10:15'),
(8, 1, 1, 2, 'aaaadddds', NULL, '2013-03-14 01:10:15', '2013-03-14 01:10:15'),
(9, 1, 1, 3, 'aaaagggghh', NULL, '2013-03-14 01:10:15', '2013-03-14 01:10:15'),
(10, 1, 1, 4, 'aaaannnnnn', NULL, '2013-03-14 01:10:15', '2013-03-14 01:10:15'),
(11, 1, 1, 8, '14', NULL, '2013-03-14 01:10:15', '2013-03-14 01:10:15'),
(12, 1, 1, 1, '55', NULL, '2013-03-14 01:12:59', '2013-03-14 01:12:59'),
(13, 1, 1, 2, 'hh', NULL, '2013-03-14 01:12:59', '2013-03-14 01:12:59'),
(14, 1, 1, 3, 'gg', NULL, '2013-03-14 01:12:59', '2013-03-14 01:12:59'),
(15, 1, 1, 4, 'nn', NULL, '2013-03-14 01:12:59', '2013-03-14 01:12:59'),
(16, 1, 1, 8, '15', NULL, '2013-03-14 01:12:59', '2013-03-14 01:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `lesson_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_lesson_fk` (`lesson_id`),
  KEY `quiz_course_fk` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `lesson_id`, `course_id`, `created`, `modified`) VALUES
(1, 1, 1, '2013-03-10 18:40:39', '2013-03-10 18:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `rosters`
--

DROP TABLE IF EXISTS `rosters`;
CREATE TABLE IF NOT EXISTS `rosters` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `course_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `completion_status` varchar(11) DEFAULT 'Incomplete',
  `date_added` datetime DEFAULT NULL,
  `date_removed` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `archived` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `rosters`
--

INSERT INTO `rosters` (`id`, `course_id`, `user_id`, `completion_status`, `date_added`, `date_removed`, `date_completed`, `archived`) VALUES
(10, 1, 1, 'Complete', '2013-02-18 00:00:00', NULL, '2013-02-21 00:00:00', 0),
(11, 2, 1, 'Incomplete', '2013-02-18 00:00:00', NULL, NULL, 0),
(12, 2, 1, 'Incomplete', '2013-02-18 00:00:00', NULL, NULL, 0),
(13, 1, 1, 'Not Started', '2013-02-18 00:00:00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type_name`, `created`, `modified`) VALUES
(1, 'Administrator', '2013-02-08 15:03:17', '2013-02-08 15:03:17'),
(2, 'Instructor', '2013-02-08 15:03:17', '2013-02-08 15:03:17'),
(3, 'Student', '2013-02-08 15:03:17', '2013-02-08 15:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `types_permissions`
--

DROP TABLE IF EXISTS `types_permissions`;
CREATE TABLE IF NOT EXISTS `types_permissions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_id` int(8) NOT NULL,
  `permission_id` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `types_permissions`
--

INSERT INTO `types_permissions` (`id`, `type_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `types_users`
--

DROP TABLE IF EXISTS `types_users`;
CREATE TABLE IF NOT EXISTS `types_users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `types_users`
--

INSERT INTO `types_users` (`id`, `type_id`, `user_id`) VALUES
(1, 1, 1),
(2, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `type_id` int(8) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `enabled`, `type_id`, `last_name`, `middle_name`, `first_name`, `created`, `modified`) VALUES
(1, 'tester', 'b96689421b87d4c93f377eba19b8eb97807e2656', 1, 1, 'Tester', 'Tester', 'Tester', '2013-02-08 15:03:41', '2013-02-08 15:03:41'),
(4, 'butt', '27bd33516f54f5b8daffd4729fb728ac1dfe9e1d', 1, 3, 'butt', 'butt', 'butt', '2013-02-17 02:21:57', '2013-02-25 02:13:36');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_fk` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_sub_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_sub_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quiz_course_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rosters`
--
ALTER TABLE `rosters`
  ADD CONSTRAINT `rosters_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `rosters_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `types_permissions`
--
ALTER TABLE `types_permissions`
  ADD CONSTRAINT `types_permissions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `types_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `types_users`
--
ALTER TABLE `types_users`
  ADD CONSTRAINT `types_users_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `types_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
