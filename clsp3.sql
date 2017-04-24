-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2017 at 06:47 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `student_registration_id` int(11) DEFAULT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_deleted` int(11) DEFAULT NULL,
  `date_start` int(11) NOT NULL,
  `date_end` int(11) NOT NULL,
  `timezone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `is_student` tinyint(1) NOT NULL,
  `is_professor` tinyint(1) NOT NULL,
  `is_designer` tinyint(1) NOT NULL,
  `forgot_password_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgot_password_expiry` int(11) DEFAULT NULL,
  `is_administrator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `student_registration_id`, `username`, `name`, `password`, `email`, `is_active`, `date_created`, `date_deleted`, `date_start`, `date_end`, `timezone`, `is_student`, `is_professor`, `is_designer`, `forgot_password_key`, `forgot_password_expiry`, `is_administrator`) VALUES
(1, NULL, 'testAdmin', 'Admin', '$2y$13$0CufFffPPVESfKWBuo89l.ExJms8Ok7pmf34eMKGw/odcVnenVI6a', 'testAdmin@test.com', 1, 1488417865, NULL, 0, 1519953865, 'America/New_York', 0, 0, 0, NULL, NULL, 1),
(2, NULL, 'testProfessor1C', 'Chinese Professor 1', '$2y$13$zWrrKfihiMfiaSOLoJnffe2A09sKD833AqO/AJn/zyh9H6lxkr2Yi', 'testProfessor1C@test.com', 1, 1488417866, NULL, 0, 1519953866, 'America/New_York', 0, 1, 0, NULL, NULL, 0),
(3, NULL, 'testProfessor2C', 'Chinese Professor 2', '$2y$13$j49K0hdMLq42r8arg1AsAeC6R1JL2.4T4dI7LgJo/Uz5VJVNGgmGu', 'testProfessor2C@test.com', 1, 1488417866, NULL, 0, 1519953866, 'America/New_York', 0, 1, 0, NULL, NULL, 0),
(4, NULL, 'testProfessor3J', 'Japanese Professor 1', '$2y$13$cCwrH6sK2QYr4WvEV5RxoObiG513amfWzvyEhnwo7Jhjs/Q41Sf0O', 'testProfessor3J@test.com', 1, 1488417867, NULL, 0, 1519953867, 'America/New_York', 0, 1, 0, NULL, NULL, 0),
(5, NULL, 'testDesignerChinese', 'Chinese Designer', '$2y$13$7lAaX5vmk2lTXs2EPUitHOW9qMw.LXZwCCnEWJQLG5IWfYBgxlv0y', 'testDesignerChinese@test.com', 1, 1488417867, NULL, 0, 1519953867, 'America/New_York', 0, 0, 1, NULL, NULL, 0),
(6, NULL, 'testDesignerJapanese', 'Japanese Designer', '$2y$13$fDSsmLKU5tkbJaeNGr0mgu/fCkU7/PVMuiCQ17pU.Z5qAYiGagAh6', 'testDesignerJapanese@test.com', 1, 1488417868, NULL, 0, 1519953868, 'America/New_York', 0, 0, 1, NULL, NULL, 0),
(7, 1, 'testStudent1', 'Student 1', '$2y$13$Zqa9NjAUwbfqtVKV0wjaK.E1IRvJ6uw55YlzFx6NTBkqMxwhGUuxi', 'testStudent1@test.com', 1, 1488417868, NULL, 0, 1519953868, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(8, 1, 'testStudent2', 'Student 2', '$2y$13$z2bYFlMnzMhHjKjxE2anTusMng2GXHYBK0JDrL6jB7BZkY8r/mQ6C', 'testStudent2@test.com', 1, 1488417868, NULL, 0, 1519953868, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(9, 1, 'testStudent3', 'Student 3', '$2y$13$fSSg8fMxd8f3e.KT3u3OxehxZzmijzKuU6Fj6abCt01dfQFoPFDsK', 'testStudent3@test.com', 1, 1488417869, NULL, 0, 1519953869, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(10, 2, 'testStudent4', 'Student 4', '$2y$13$PifSsxDAYTReP0.grgtwDe.GkMpIvNoIS48QDJ8VE2P3Fe1ymjVIu', 'testStudent4@test.com', 1, 1488417869, NULL, 0, 1519953869, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(11, 2, 'testStudent5', 'Student 5', '$2y$13$Smc06DEhW6WwfqJ6ztbWH.OWfEclKNHWAIyV.dz8TYpi9WlwEbWQK', 'testStudent5@test.com', 1, 1488417870, NULL, 0, 1519953870, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(12, 3, 'testStudent6', 'Student 6', '$2y$13$YIAc2A3xLWZ0ddihk8Sja.M.xm2sx3GbS1Bp/Xzokm8AM/BWIoeu2', 'testStudent6@test.com', 1, 1488417870, NULL, 0, 1519953870, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(13, 3, 'testStudent7', 'Student 7', '$2y$13$bWxOpKZM08RKTRjtdBSPBOO2uj0BDw3VzHH0O022wwk1FwMv1S6EC', 'testStudent7@test.com', 1, 1488417871, NULL, 0, 1519953871, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(14, 4, 'testStudent8', 'Student 8', '$2y$13$Nr3y2M.x9hvImtqP.yopoeAObGoBFOA9qzcaH2JRJF7yd7jNvd0Cq', 'testStudent8@test.com', 1, 1488417871, NULL, 0, 1519953871, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(15, 5, 'testStudent9', 'Student 9', '$2y$13$hwzZOrjipur661YfjiU/X.arFV2csiZxHkXreGUjs4hq//JcVnHIm', 'testStudent9@test.com', 1, 1488417871, NULL, 0, 1519953871, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(16, 6, 'testStudent10', 'Student 10', '$2y$13$a4TmxNffHTKi8JQOYtUphOrMr1J0SLt2vRNjOFfZd7L7QBAmfAr/y', 'testStudent10@test.com', 1, 1488417872, NULL, 0, 1519953872, 'America/New_York', 1, 0, 0, NULL, NULL, 0),
(17, 1, 'asdf', 'asdf', '$2y$13$yXwV0fFzXBHjnc2cHyN/Ou6UpcrDgO6ghmaHSF7tf.rtbuHiM7K6.', 'asdf', 1, 1490213206, NULL, 1490213206, 1497057872, 'UTC', 1, 0, 0, NULL, NULL, 0),
(18, 7, 'testStudent11', 'Student 11', '$2y$13$XrSDPc//pAgJxR.kN82keuuhkaf/R5XxfOerFtj/faZnJ7aiZ4Ffm', 'test11@mail.com', 1, 1492404162, NULL, 1492404162, 1497057872, 'UTC', 1, 0, 0, NULL, NULL, 0),
(19, NULL, 'sgoldberg', 'Stuart Goldberg', '$2y$13$1KV8ueKZnXLdYi3J9JvptOH2A1JkgWqJbOyOWAQXA/y1HI7tYjerm', 'stuart.goldberg@modlangs.gatech.edu', 1, 1492911242, NULL, 1492911242, 1524447242, 'UTC', 0, 0, 1, NULL, NULL, 0),
(20, NULL, 'testProfessorRussian', 'Test Professor', '$2y$13$ULNJ7G2mnhCb2xeILofwwOFSTbMMvJ3rdH0Yc0suYQfkTYoAqCrLG', 'ypan75@gatech.edu', 1, 1492971319, NULL, 1492971319, 1507680000, 'UTC', 0, 1, 0, NULL, NULL, 0),
(21, 8, 'testStudentRussian', 'Test Student', '$2y$13$GpRgdqyz/LzXBxHXitUY5eGSL5m5QXNAs3M31GQTghuHf5RTGujwa', 'test@test.com', 1, 1492974538, NULL, 1492974538, 1495584000, 'UTC', 1, 0, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `course_id`, `registration_id`, `name`, `description`) VALUES
(1, 1, 1, 'CHIN 3002 A', ''),
(2, 1, 1, 'CHIN 3002 B', ''),
(3, 1, 2, 'CHIN 3002 C', ''),
(4, 2, 3, 'JAPN 3001 A', ''),
(5, 2, 3, 'JAPN 3001 B', ''),
(6, 3, 4, 'JAPN 4361 A', ''),
(7, 4, 5, 'JAPN 4215 A', ''),
(8, 5, 6, 'Russian Class Test', 'Test for the Russian class');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `language_id`, `name`, `description`) VALUES
(1, 5, 1, 'CHIN 3002', 'Advanced Chinese Language, part 2'),
(2, 6, 3, 'JAPN 3001', 'Advanced Japanese Language'),
(3, 6, 3, 'JAPN 4361', 'Japanese Literature'),
(4, 6, 3, 'JAPN 4215', 'Modern Japanese Culture'),
(5, 19, 2, 'Русская культура в двадцати одной песне', 'Placeholder');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `language_code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_code`, `name`) VALUES
(1, 'ZH', 'Chinese'),
(2, 'RU', 'Russian'),
(3, 'JA', 'Japanese'),
(4, 'AR', 'Arabic'),
(5, 'KO', 'Korean');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `file_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `user_id`, `name`, `filename`, `file_type`) VALUES
(1, 6, 'sdvx bunkasai', '47abd84e204fd1d5c15b27252e83a311.pdf', 'pdf'),
(2, 6, 'ibuki', '644956120669be46685d2661a88d7ee3.png', 'png'),
(3, 1, 'not a designer user', 'test.png', 'png'),
(4, 6, 'meumeu', '2ad08ecb1ab85946fcbe589fbf4a0fc5.mp3', 'mp3'),
(5, 6, 'ckp', 'a09ccdc7b891ff21945fb2d2e4a0badc.mp3', 'mp3'),
(6, 6, 'chikuwaparfait', '012f7de9069b0d26d6bbe86887b0eb63.jpg', 'jpg'),
(7, 6, 'chikuwa', '4800929fbe78e52eea895b05ef3c9935.jpg', 'jpg'),
(8, 6, '君がいる場所へ', '7aa35cf0c643fa69da4159c85a72f911.mp3', 'mp3'),
(9, 6, 'voltexes ii', 'ba5afe9446e9471a9cf22d93addbca63.ogg', 'ogg'),
(10, 6, 'voltexes iii', '153d3141e7a157b88b44e70541ff4843.ogg', 'ogg'),
(11, 6, 'closer', 'dab17e617dd55d55fdc2404d05a6afef.mp3', 'mp3');

-- --------------------------------------------------------

--
-- Table structure for table `module_cn`
--

CREATE TABLE `module_cn` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_cn`
--

INSERT INTO `module_cn` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu', NULL, 1, 1, 0),
(2, 2, NULL, NULL, 0, 1, 0),
(3, 3, NULL, NULL, 0, 1, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', 'Cultural Notes', 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0),
(10, 18, '', NULL, 0, 1, 0),
(11, 19, '', NULL, 0, 1, 0),
(12, 20, '', NULL, 0, 1, 0),
(13, 21, '', NULL, 0, 1, 0),
(14, 22, '', NULL, 0, 1, 0),
(15, 23, '', 'Текст, примечания, контекст', 0, 1, 0),
(16, 24, '', 'Текст, примечания, контекст', 0, 1, 0),
(17, 25, '', 'Текст, примечания, контекст', 0, 1, 0),
(18, 26, '', 'Текст, примечания, контекст', 0, 1, 0),
(19, 27, '', 'Текст, примечания, контекст', 0, 1, 0),
(20, 28, '', 'Текст, примечания, контекст', 0, 1, 0),
(21, 29, '', 'Текст, примечания, контекст', 0, 0, 0),
(22, 30, '', 'Текст, примечания, контекст', 0, 1, 0),
(23, 31, '', 'Текст, примечания, контекст', 0, 1, 0),
(24, 32, '', 'Текст, примечания, контекст', 0, 1, 0),
(25, 33, '', 'Текст, примечания, контекст', 0, 1, 0),
(26, 34, '', 'Текст, примечания, контекст', 0, 1, 0),
(27, 35, '', 'Текст, примечания, контекст', 0, 1, 0),
(28, 36, '', 'Текст, примечания, контекст', 0, 1, 0),
(29, 37, '', NULL, 0, 0, 0),
(30, 38, '', 'Текст, примечания, контекст', 0, 1, 0),
(31, 39, '', 'Текст, примечания, контекст', 0, 1, 0),
(32, 40, '', 'Текст, примечания, контекст', 0, 1, 0),
(33, 41, '', 'Текст, примечания, контекст', 0, 0, 0),
(34, 42, '', 'Текст, примечания, контекст', 0, 1, 0),
(35, 43, '', 'Текст, примечания, контекст', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_cn_keyword`
--

CREATE TABLE `module_cn_keyword` (
  `id` int(11) NOT NULL,
  `cn_id` int(11) DEFAULT NULL,
  `phrase` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `link` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_cn_keyword`
--

INSERT INTO `module_cn_keyword` (`id`, `cn_id`, `phrase`, `description`, `link`) VALUES
(1, 1, 'M・O・K・S!!', 'moe okoshi', NULL),
(2, 1, 'めう', NULL, NULL),
(3, 1, 'ぺったん', 'pettan', NULL),
(5, 2, 'ちくパ', 'chikuwa parfait', 'https://remywiki.com/Chikuwa_parfait_da_yo_CKP'),
(6, 2, 'ちくわ', 'fish cake roll', NULL),
(7, 2, 'ちくわ', 'test', NULL),
(8, 7, '身近', 'Near oneself; Things closest to self (most precious, in this case) (みぢか)', NULL),
(9, 7, '偽善', 'Hypocrisy (ぎぜん)', NULL),
(10, 7, 'あきらめずに進め', 'To go forth without giving up', NULL),
(11, 7, '見失', 'To lose sight of', NULL),
(12, 7, '勇気を胸に', 'Literally \"have bravery in the heart\"', NULL),
(13, 8, 'ヒトヒラ', 'A single piece', NULL),
(14, 8, 'ハナビラ', 'Flower petal', NULL),
(15, 8, '巻き戻して', 'Return to the way things were', NULL),
(16, 9, 'halation', 'spreading of light to form a fog around the edges of something bright', NULL),
(17, 9, '不思議', 'Mysterious', NULL),
(18, 7, '夢', '<p><a href=\"http://www.google.com\">dream</a></p>\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_cn_keywords_media`
--

CREATE TABLE `module_cn_keywords_media` (
  `module_cn_keyword_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_cn_keywords_media`
--

INSERT INTO `module_cn_keywords_media` (`module_cn_keyword_id`, `media_id`) VALUES
(5, 6),
(6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `module_dw`
--

CREATE TABLE `module_dw` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_dw`
--

INSERT INTO `module_dw` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-dw', NULL, 1, 1, 0),
(2, 2, 'chikuwaparfait-dw', NULL, 1, 1, 0),
(3, 3, 'not 4361', NULL, 1, 1, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', 'Discussion', 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 0, 0),
(10, 18, '', NULL, 0, 0, 0),
(11, 19, '', NULL, 0, 0, 0),
(12, 20, '', NULL, 0, 0, 0),
(13, 21, '', NULL, 0, 0, 0),
(14, 22, '', NULL, 0, 0, 0),
(15, 23, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(16, 24, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(17, 25, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(18, 26, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(19, 27, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(20, 28, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(21, 29, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(22, 30, '', 'Темы для обсуждения и сочинений', 0, 1, 1),
(23, 31, '', NULL, 0, 0, 0),
(24, 32, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(25, 33, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(26, 34, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(27, 35, '', 'Темы для обсуждения и сочинений', 0, 1, 1),
(28, 36, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(29, 37, '', 'Темы для обсуждения и сочинений', 0, 1, 1),
(30, 38, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(31, 39, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(32, 40, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(33, 41, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(34, 42, '', 'Темы для обсуждения и сочинений', 0, 1, 0),
(35, 43, '', 'Темы для обсуждения и сочинений', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_ge`
--

CREATE TABLE `module_ge` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_ge`
--

INSERT INTO `module_ge` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-ge', NULL, 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', 'Grammar', 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0),
(10, 18, '', NULL, 0, 1, 1),
(11, 19, '', NULL, 0, 0, 0),
(12, 20, '', NULL, 0, 0, 0),
(13, 21, '', NULL, 0, 0, 0),
(14, 22, '', NULL, 0, 0, 0),
(15, 23, '', NULL, 0, 0, 0),
(16, 24, '', NULL, 0, 0, 0),
(17, 25, '', NULL, 0, 0, 0),
(18, 26, '', 'Грамматические задания', 0, 1, 0),
(19, 27, '', NULL, 0, 0, 0),
(20, 28, '', 'Грамматические задания', 0, 1, 0),
(21, 29, '', NULL, 0, 0, 0),
(22, 30, '', NULL, 0, 0, 0),
(23, 31, '', NULL, 0, 0, 0),
(24, 32, '', NULL, 0, 0, 0),
(25, 33, '', NULL, 0, 0, 0),
(26, 34, '', NULL, 0, 0, 0),
(27, 35, '', NULL, 0, 0, 0),
(28, 36, '', NULL, 0, 0, 0),
(29, 37, '', NULL, 0, 0, 0),
(30, 38, '', NULL, 0, 0, 0),
(31, 39, '', NULL, 0, 0, 0),
(32, 40, '', NULL, 0, 0, 0),
(33, 41, '', NULL, 0, 0, 0),
(34, 42, '', NULL, 0, 0, 0),
(35, 43, '', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_ls`
--

CREATE TABLE `module_ls` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_ls`
--

INSERT INTO `module_ls` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-ls', 'Listening Suggestions-meu!', 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', 'Listening Suggestions', 0, 1, 0),
(8, 11, '', NULL, 0, 0, 0),
(9, 12, '', NULL, 0, 0, 0),
(10, 18, '', NULL, 0, 0, 0),
(11, 19, '', NULL, 0, 0, 0),
(12, 20, '', NULL, 0, 0, 0),
(13, 21, '', NULL, 0, 0, 0),
(14, 22, '', NULL, 0, 0, 0),
(15, 23, '', 'Что слушать дальше!', 0, 1, 0),
(16, 24, '', NULL, 0, 0, 0),
(17, 25, '', 'Что слушать дальше!', 0, 1, 0),
(18, 26, '', 'Что слушать дальше!', 0, 1, 0),
(19, 27, '', 'Что слушать дальше!', 0, 1, 0),
(20, 28, '', 'Что слушать дальше!', 0, 0, 0),
(21, 29, '', NULL, 0, 0, 0),
(22, 30, '', 'Что слушать дальше!', 0, 1, 0),
(23, 31, '', NULL, 0, 0, 0),
(24, 32, '', 'Что слушать дальше!', 0, 1, 0),
(25, 33, '', 'Что слушать дальше!', 0, 1, 0),
(26, 34, '', 'Что слушать дальше!', 0, 1, 0),
(27, 35, '', NULL, 0, 0, 0),
(28, 36, '', 'Что слушать дальше!', 0, 1, 0),
(29, 37, '', 'Что слушать дальше!', 0, 1, 0),
(30, 38, '', 'Что слушать дальше!', 0, 1, 0),
(31, 39, '', 'Что слушать дальше!', 0, 1, 0),
(32, 40, '', 'Что слушать дальше!', 0, 1, 0),
(33, 41, '', 'Что слушать дальше!', 0, 1, 0),
(34, 42, '', NULL, 0, 0, 0),
(35, 43, '', 'Что слушать дальше!', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `module_lt`
--

CREATE TABLE `module_lt` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_lt`
--

INSERT INTO `module_lt` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-lt', NULL, 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', 'Listening Tasks', 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0),
(10, 18, '', NULL, 0, 0, 0),
(11, 19, '', NULL, 0, 0, 0),
(12, 20, '', NULL, 0, 0, 0),
(13, 21, '', NULL, 0, 0, 0),
(14, 22, '', NULL, 0, 0, 0),
(15, 23, '', 'Аудирование', 0, 1, 1),
(16, 24, '', 'Аудирование', 0, 1, 1),
(17, 25, '', 'Аудирование', 0, 1, 1),
(18, 26, '', 'Аудирование', 0, 1, 1),
(19, 27, '', 'Аудирование', 0, 1, 1),
(20, 28, '', 'Аудирование', 0, 1, 1),
(21, 29, '', 'Аудирование', 0, 1, 1),
(22, 30, '', 'Аудирование', 0, 1, 1),
(23, 31, '', 'Аудирование', 0, 1, 1),
(24, 32, '', 'Аудирование', 0, 1, 1),
(25, 33, '', 'Аудирование', 0, 1, 1),
(26, 34, '', 'Аудирование', 0, 1, 1),
(27, 35, '', 'Аудирование', 0, 1, 1),
(28, 36, '', 'Аудирование', 0, 1, 1),
(29, 37, '', 'Аудирование', 0, 1, 1),
(30, 38, '', 'Аудирование', 0, 1, 1),
(31, 39, '', 'Аудирование', 0, 1, 1),
(32, 40, '', 'Аудирование', 0, 1, 1),
(33, 41, '', 'Аудирование', 0, 1, 1),
(34, 42, '', 'Аудирование', 0, 1, 1),
(35, 43, '', 'Аудирование', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_qu`
--

CREATE TABLE `module_qu` (
  `id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_password` tinyint(1) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `song_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_qu`
--

INSERT INTO `module_qu` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-qu', NULL, 1, 1, 0),
(2, 3, 'not 4361 - qu', NULL, 1, 1, 0),
(6, 2, 'chikupa-qu', NULL, 1, 0, 0),
(8, 6, 'valleystone', NULL, 1, 1, 1),
(9, 10, '', 'Questions for Understanding', 0, 1, 0),
(10, 11, '', NULL, 0, 0, 0),
(11, 12, '', NULL, 0, 1, 0),
(12, 18, '', NULL, 0, 0, 0),
(13, 19, '', NULL, 0, 0, 0),
(14, 20, '', NULL, 0, 0, 0),
(15, 21, '', NULL, 0, 0, 0),
(16, 22, '', NULL, 0, 0, 0),
(17, 23, '', 'Вопросы к тексту', 0, 1, 1),
(18, 24, '', NULL, 0, 0, 0),
(19, 25, '', 'Вопросы к тексту', 0, 1, 1),
(20, 26, '', NULL, 0, 0, 0),
(21, 27, '', 'Вопросы к тексту', 0, 1, 1),
(22, 28, '', 'Вопросы к тексту', 0, 1, 1),
(23, 29, '', 'Вопросы к тексту', 0, 1, 1),
(24, 30, '', 'Вопросы к тексту', 0, 1, 1),
(25, 31, '', 'Вопросы к тексту', 0, 1, 1),
(26, 32, '', 'Вопросы к тексту', 0, 1, 1),
(27, 33, '', 'Вопросы к тексту', 0, 1, 1),
(28, 34, '', 'Вопросы к тексту', 0, 1, 1),
(29, 35, '', 'Вопросы к тексту', 0, 1, 1),
(30, 36, '', NULL, 0, 0, 0),
(31, 37, '', 'Вопросы к тексту', 0, 1, 1),
(32, 38, '', 'Вопросы к тексту', 0, 1, 1),
(33, 39, '', 'Вопросы к тексту', 0, 1, 1),
(34, 40, '', 'Вопросы к тексту', 0, 1, 1),
(35, 41, '', 'Вопросы к тексту', 0, 0, 0),
(36, 42, '', 'Вопросы к тексту', 0, 1, 1),
(37, 43, '', 'Вопросы к тексту', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_question_heading`
--

CREATE TABLE `module_question_heading` (
  `id` int(11) NOT NULL,
  `qu_id` int(11) DEFAULT NULL,
  `lt_id` int(11) DEFAULT NULL,
  `ge_id` int(11) DEFAULT NULL,
  `dw_id` int(11) DEFAULT NULL,
  `ls_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_question_heading`
--

INSERT INTO `module_question_heading` (`id`, `qu_id`, `lt_id`, `ge_id`, `dw_id`, `ls_id`, `name`, `weight`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 'Intro', 1),
(2, 1, NULL, NULL, NULL, NULL, 'Characters', 2),
(3, 2, NULL, NULL, NULL, NULL, 'Not 4361', 1),
(4, NULL, NULL, NULL, 1, NULL, 'Stuff', 1),
(5, 1, NULL, NULL, NULL, NULL, 'Songs', 3),
(6, NULL, 1, NULL, NULL, NULL, 'asdfasdfs', 1),
(7, NULL, NULL, NULL, NULL, 1, 'asdfasdfs', 1),
(8, NULL, NULL, NULL, NULL, 1, 'LSLSLSLS', 1),
(9, 1, NULL, NULL, NULL, NULL, 'Radio', 4),
(10, 1, NULL, NULL, NULL, NULL, 'Conclusion', 5),
(11, 9, NULL, NULL, NULL, NULL, 'Overview', 1),
(12, 9, NULL, NULL, NULL, NULL, 'Song Details', 2),
(13, 9, NULL, NULL, NULL, NULL, 'Video Details', 3),
(14, 9, NULL, NULL, NULL, NULL, 'Additional Questions', 4),
(15, NULL, NULL, 7, NULL, NULL, 'Grammar', 1),
(16, NULL, NULL, 7, NULL, NULL, 'Extra Practice', 2),
(17, NULL, NULL, NULL, 7, NULL, 'Discussion', 1),
(18, NULL, NULL, NULL, 8, NULL, 'Discussion', 1),
(19, 9, NULL, NULL, NULL, NULL, 'Test', 7),
(20, 9, NULL, NULL, NULL, NULL, 'Test 2', 9),
(24, NULL, 15, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(25, NULL, 15, NULL, NULL, NULL, 'Аудирование. Упр. 1.', 2),
(26, NULL, 15, NULL, NULL, NULL, 'Диктант?', 3),
(27, NULL, 15, NULL, NULL, NULL, 'Аудирование. Упр. 2', 4),
(28, NULL, 15, NULL, NULL, NULL, 'Аудирование. Упр. 3', 5),
(29, NULL, 15, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 6),
(30, 17, NULL, NULL, NULL, NULL, 'Other Questions for Understanding', 1),
(31, NULL, NULL, NULL, 15, NULL, 'Темы для обсуждения', 1),
(32, NULL, NULL, NULL, 15, NULL, ' Темы для сочинений', 2),
(33, NULL, 16, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(34, NULL, 16, NULL, NULL, NULL, 'Прослушайте теперь песню', 2),
(35, NULL, 16, NULL, NULL, NULL, 'Вы дошли до пароля. Пароль —', 3),
(36, NULL, NULL, NULL, 16, NULL, 'Темы для обсуждения', 1),
(37, NULL, 17, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(38, NULL, 17, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(39, NULL, 17, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 3),
(40, 19, NULL, NULL, NULL, NULL, 'Вопросы к тексту 1', 1),
(41, 19, NULL, NULL, NULL, NULL, 'Вопросы к тексту 2', 2),
(42, NULL, NULL, NULL, 17, NULL, 'Темы для обсуждения и сочинений', 1),
(43, NULL, 18, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(44, NULL, 18, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(45, NULL, 18, NULL, NULL, NULL, 'Диктант!', 3),
(46, NULL, 18, NULL, NULL, NULL, 'А теперь...', 4),
(47, NULL, 18, NULL, NULL, NULL, 'Вы дошли до пароля...', 5),
(48, NULL, NULL, 18, NULL, NULL, 'Упр. 1 (тот же самый)', 1),
(49, NULL, NULL, 18, NULL, NULL, 'Упр. 2 (не тот)', 2),
(50, NULL, NULL, NULL, 18, NULL, 'Темы для обсуждения', 1),
(51, NULL, 19, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(52, NULL, 19, NULL, NULL, NULL, 'Аудирование. Упр. 1.', 2),
(53, NULL, 19, NULL, NULL, NULL, 'Аудирование. Упр. 2.', 3),
(54, NULL, 19, NULL, NULL, NULL, 'Вы дошли до пароля...', 4),
(55, 21, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(56, NULL, NULL, NULL, 19, NULL, 'Тема для сочинения', 1),
(57, NULL, NULL, NULL, 19, NULL, 'Тема для обсуждения', 2),
(58, NULL, 20, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(59, NULL, 20, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(60, NULL, 20, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(61, NULL, 20, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(62, 22, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(63, 22, NULL, NULL, NULL, NULL, 'Гимн России', 2),
(64, NULL, NULL, 20, NULL, NULL, 'Упражнение', 1),
(65, NULL, NULL, 20, NULL, NULL, 'Бонус: головоломка для смелых', 2),
(66, NULL, NULL, NULL, 20, NULL, 'Темы для обсуждения', 1),
(67, NULL, NULL, NULL, 20, NULL, 'Ваше творчество!', 2),
(68, NULL, 21, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(69, NULL, 21, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(70, NULL, 21, NULL, NULL, NULL, 'Аудирование, упр. 2', 3),
(71, NULL, 21, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля.', 4),
(72, 23, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(73, NULL, NULL, NULL, 21, NULL, 'Доклад', 1),
(74, NULL, 22, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(75, NULL, 22, NULL, NULL, NULL, 'Аудирование', 2),
(76, NULL, 22, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 3),
(77, 24, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(78, NULL, NULL, NULL, 22, NULL, 'Темы для обсуждения', 1),
(79, NULL, NULL, NULL, 22, NULL, 'Тема для сочинения', 2),
(80, NULL, 23, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(81, NULL, 23, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(82, NULL, 23, NULL, NULL, NULL, 'Вы дошли до пароля...', 3),
(83, 25, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(84, NULL, 24, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(85, NULL, 24, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(86, NULL, 24, NULL, NULL, NULL, 'Аудирование, упр. 2', 3),
(87, NULL, 24, NULL, NULL, NULL, 'Вы дошли до пароля...', 4),
(88, 26, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(89, NULL, NULL, NULL, 24, NULL, 'Темы для обсуждения и сочинений', 1),
(90, NULL, 25, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(91, NULL, 25, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(92, NULL, 25, NULL, NULL, NULL, 'Аудирование, упр. 2', 3),
(93, NULL, 25, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(94, 27, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(95, NULL, NULL, NULL, 25, NULL, 'Для обсуждения или сочинения', 1),
(96, NULL, 26, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(97, NULL, 26, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(98, NULL, 26, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(99, NULL, 26, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(100, 28, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(101, NULL, NULL, NULL, 26, NULL, 'Темы для обсуждения', 1),
(102, NULL, NULL, NULL, 26, NULL, 'Темы для сочинения', 2),
(103, NULL, 27, NULL, NULL, NULL, 'Диктант', 1),
(104, NULL, 27, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(105, NULL, 27, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 3),
(106, 29, NULL, NULL, NULL, NULL, 'Вопросы к тексту 1', 1),
(107, 29, NULL, NULL, NULL, NULL, 'Вопросы к тексту 2', 2),
(108, NULL, NULL, NULL, 27, NULL, 'Темы для обсуждения', 1),
(109, NULL, 28, NULL, NULL, NULL, 'Диктант', 1),
(110, NULL, 28, NULL, NULL, NULL, 'Пароль —', 2),
(111, NULL, NULL, NULL, 28, NULL, 'Темы для сочинений', 1),
(112, NULL, NULL, NULL, 28, NULL, 'Темы для обсуждения', 2),
(113, NULL, 29, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(114, NULL, 29, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(115, NULL, 29, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(116, NULL, 29, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(117, 31, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(118, NULL, NULL, NULL, 29, NULL, 'Темы для обсуждения', 1),
(119, NULL, 30, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(120, NULL, 30, NULL, NULL, NULL, 'Аудирование, упр. 1', 2),
(121, NULL, 30, NULL, NULL, NULL, 'Аудирование, упр. 2', 3),
(122, NULL, 30, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(123, 32, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(124, NULL, NULL, NULL, 30, NULL, 'Темы для обсуждения и сочинений', 1),
(125, NULL, 31, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(126, NULL, 31, NULL, NULL, NULL, 'Упражнение 1', 2),
(127, NULL, 31, NULL, NULL, NULL, 'Упражнение 2', 3),
(128, NULL, 31, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(129, 33, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(130, 33, NULL, NULL, NULL, NULL, 'А теперь посмотрите клип...', 2),
(131, NULL, NULL, NULL, 31, NULL, 'Темы для обсуждения и сочинений', 1),
(132, NULL, 32, NULL, NULL, NULL, 'Подговтовка к прослушиванию', 1),
(133, NULL, 32, NULL, NULL, NULL, 'Аудирование', 2),
(134, NULL, 32, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 3),
(135, 34, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(136, NULL, NULL, NULL, 32, NULL, 'Темы для обсуждения и сочинений', 1),
(137, NULL, 33, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(138, NULL, 33, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(139, NULL, 33, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(140, NULL, 33, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(141, 35, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(142, NULL, NULL, NULL, 33, NULL, 'Темы для сочинений', 2),
(143, NULL, NULL, NULL, 33, NULL, 'Темы для обсуждения', 1),
(144, NULL, 34, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(145, NULL, 34, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(146, NULL, 34, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(147, NULL, 34, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(148, 36, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(149, NULL, NULL, NULL, 34, NULL, 'Темы для обсуждения', 1),
(150, NULL, 35, NULL, NULL, NULL, 'Подготовка к прослушиванию', 1),
(151, NULL, 35, NULL, NULL, NULL, 'Аудирование. Упр. 1', 2),
(152, NULL, 35, NULL, NULL, NULL, 'Аудирование. Упр. 2', 3),
(153, NULL, 35, NULL, NULL, NULL, 'Поздравляем! Вы дошли до пароля...', 4),
(154, 37, NULL, NULL, NULL, NULL, 'Вопросы к тексту', 1),
(155, NULL, NULL, NULL, 35, NULL, 'Темы для обсуждения и сочинений', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_question_item`
--

CREATE TABLE `module_question_item` (
  `id` int(11) NOT NULL,
  `heading_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `choices` longtext COLLATE utf8_unicode_ci,
  `answers` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module_question_item`
--

INSERT INTO `module_question_item` (`id`, `heading_id`, `content`, `type`, `weight`, `choices`, `answers`) VALUES
(1, 1, 'Which is a member of Coconatsu?', 'multiple-choice', 1, '[{\"choice\":\"Ibuki\"},{\"choice\":\"Meu\"},{\"choice\":\"Natsuhi\"},{\"choice\":\"Grace\"}]', '[{\"choice\":\"Natsuhi\"}]'),
(2, 1, 'Which are members of Coconatsu?', 'multiple-select', 2, '[{\"choice\":\"Ibuki\"},{\"choice\":\"Meu\"},{\"choice\":\"Natsuhi\"},{\"choice\":\"Cocona\"}]', '[{\"choice\":\"Natsuhi\"},{\"choice\":\"Cocona\"}]'),
(3, 3, 'test-not-meu', 'test', 3, NULL, NULL),
(4, 2, 'test-meu-3, heading 2', 'multiple-choice', 1, NULL, ''),
(5, 1, 'Ibuki Izumi of Hinabita plays the _, while Meu plays the _.', 'fill-blank', 2, '', '[{\"choice\":\"bass\"},{\"choice\":\"drums:drum:percussion\"}]'),
(6, 11, '「CLOSER」は_年から発売されました。', 'fill-blank', 1, NULL, '[{\"choice\":\"2008\"}]'),
(7, 11, '「CLOSER」と言う歌は最初にシングルに発表しました。このシングルのタイトルはなんですか。', 'multiple-choice', 2, '[{\"choice\":\"GRAVITY\"},{\"choice\":\"CLOSER\"},{\"choice\":\"海色\"},{\"choice\":\"影踏み\"}]', '[{\"choice\":\"CLOSER\"}]'),
(8, 11, '「CLOSER」はどの言葉で歌いましたか。', 'multiple-select', 3, '[{\"choice\":\"韓国語\"},{\"choice\":\"日本語\"},{\"choice\":\"英語\"},{\"choice\":\"スペイン語\"}]', '[{\"choice\":\"日本語\"},{\"choice\":\"英語\"}]'),
(9, 12, 'What does 偽善 mean?', 'multiple-choice', 1, '[{\"choice\":\"To lose sight of\"},{\"choice\":\"Treasure\"},{\"choice\":\"Surreal\"},{\"choice\":\"Hypocrisy\"}]', '[{\"choice\":\"Hypocrisy\"}]'),
(10, 12, '勇気を胸に literally means to have _ in the _.', 'fill-blank', 2, '', '[{\"choice\":\"bravery:strength:courage\"},{\"choice\":\"heart:chest\"}]'),
(11, 13, 'どうして「CLOSER」のミュージックビデオの人は全部井上ジョーですか。', 'short-answer', 1, NULL, NULL),
(12, 13, 'このミュージックビデオはどんな物語を見せましたか。', 'short-answer', 2, NULL, NULL),
(13, 14, 'この歌のタイトル、「CLOSER」、の意味はなんですか。', 'short-answer', 1, NULL, NULL),
(15, 24, 'Что такое сказка? Чем сказка отличается от рассказа?', 'short-answer', 1, NULL, NULL),
(16, 24, 'Какие обычно бывают герои сказок?', 'multiple-select', 2, '[{\"choice\":\"си́льные\"},{\"choice\":\"хи́трые\"},{\"choice\":\"бе́дные\"},{\"choice\":\"бога́тые\"},{\"choice\":\"сла́бые\"},{\"choice\":\"сме́лые\"},{\"choice\":\"насты́рные (stubbornly persistent)\"},{\"choice\":\"глу́пые\"},{\"choice\":\"везу́чие (lucky; ср. мне повезло́, тебе всегда везёт)\"},{\"choice\":\"лени́вые\"},{\"choice\":\"жа́дные\"},{\"choice\":\"до́брые\"},{\"choice\":\"ве́жливые (polite)\"}]', '[]'),
(17, 24, 'Как лидер должен реагировать на кризис?  Вы — король или королева. Дракон атакует вашу страну. Что вы сделаете?', 'short-answer', 3, NULL, NULL),
(18, 25, 'Прослушайте песню и ответьте на вопросы.', 'long-answer', 1, NULL, NULL),
(19, 25, 'Какая критическая ситуация в королевстве?', 'short-answer', 2, NULL, NULL),
(20, 25, 'Кто герой этой сказки?', 'short-answer', 3, NULL, NULL),
(21, 25, 'Почему возникает конфликт между ним и королем?', 'short-answer', 4, NULL, NULL),
(22, 26, 'Cтуденты более высокого уровня (особенно те, кто учился в русскоговорящих странах), запишите не менее 3-х куплетов (4 строки в каждом). Постарайтесь разобрать почти каждое слово и записать с правильной орфографией и пунктуацией.', 'long-answer', 1, NULL, NULL),
(23, 27, 'Заполните пробелы (студенты, которые не сделали \"Диктант\").', 'long-answer', 1, NULL, NULL),
(24, 27, 'В _, _ _ _ и складно,', 'fill-blank', 2, NULL, '[{\"choice\":\"ужасный\"},{\"choice\":\"Зверя:зверя\"},{\"choice\":\"надо\"},{\"choice\":\"говорит\"}]'),
(25, 27, '_ _ буйвол, _ _ _, _ _ тур.', 'fill-blank', 3, NULL, '[{\"choice\":\"наконец\"},{\"choice\":\"Тот:тот\"},{\"choice\":\"принцессу\"},{\"choice\":\"поведет\"},{\"choice\":\"под\"},{\"choice\":\"Бывший:бывший\"},{\"choice\":\"лучший\"}]'),
(26, 27, '_ _ _ _ и астмой,', 'fill-blank', 4, NULL, '[{\"choice\":\"но\"},{\"choice\":\"опальный\"},{\"choice\":\"На:на\"},{\"choice\":\"полу\"}]'),
(27, 27, '_ _ _ зверюга _', 'fill-blank', 5, NULL, '[{\"choice\":\"и\"},{\"choice\":\"шкуры\"},{\"choice\":\"Если:если\"},{\"choice\":\"завтра\"}]'),
(28, 27, '_ _ — _ — одолеть _!', 'fill-blank', 6, NULL, '[{\"choice\":\"победишь\"},{\"choice\":\"тебя\"},{\"choice\":\"раз\"},{\"choice\":\"два\"}]'),
(29, 28, 'Расскажите своими словами все, что вы знаете о...', 'long-answer', 1, NULL, NULL),
(30, 28, 'королевстве,', 'short-answer', 2, NULL, NULL),
(31, 28, 'короле,', 'short-answer', 3, NULL, NULL),
(32, 28, '	 стрелке,', 'short-answer', 4, NULL, NULL),
(33, 28, 'вепре.', 'short-answer', 5, NULL, NULL),
(34, 28, 'Что происходит в конце песни?', 'short-answer', 6, NULL, NULL),
(35, 30, '	Как жили в королевстве раньше?', 'short-answer', 1, NULL, NULL),
(36, 30, 'Что случилось потом?', 'short-answer', 2, NULL, NULL),
(37, 30, 'Вы можете описать \"чудище\", которое появилось?', 'short-answer', 3, NULL, NULL),
(38, 30, '	Что за король там живет? Он сильный правитель?', 'short-answer', 4, NULL, NULL),
(39, 30, 'Что король хочет, и что он предлагает взамен?', 'short-answer', 5, NULL, NULL),
(40, 30, '	В четвертой строфе появляется герой песни. Как он живет? С кем общается?', 'short-answer', 6, NULL, NULL),
(41, 30, 'Король доволен образом жизни стрелка? Нет, он явно считает, что должен \"читать ему мораль\". Почему?', 'short-answer', 7, NULL, NULL),
(42, 30, '	Почему стрелок нужен королю?', 'short-answer', 8, NULL, NULL),
(43, 30, 'Что стрелок хочет в награду за то, что он победит зверя и спасет королевство?', 'short-answer', 9, NULL, NULL),
(44, 30, 'Что значит \"я и так победю\"?', 'short-answer', 10, NULL, NULL),
(45, 30, 'За что стрелок может попасть в тюрьму?', 'short-answer', 11, NULL, NULL),
(46, 30, 'Что происходит в королевстве во время разговора короля со стрелком?', 'short-answer', 12, NULL, NULL),
(47, 30, 'Песня имеет счастливый или несчастливый конец?   Почему вы так считаете?', 'short-answer', 13, NULL, NULL),
(48, 31, '	Что стрелку нужно в жизни? Что не нужно?', 'short-answer', 1, NULL, NULL),
(49, 31, 'Как вы думаете, что за человек \"поет\" эту песню? Это еще один герой, которого в своей песне создает Высоцкий. Мы можем сказать что-нибудь о нем, исходя из его голоса, манеры речи?', 'short-answer', 2, NULL, NULL),
(50, 31, 'Высоцкий назвал песню «Лукоморья больше нет» (cм. \"Что слушать дальше!\") анти-сказкой. Есть ли у нас право называть и песню \"Про дикого вепря\" антисказкой? Почему?', 'short-answer', 3, NULL, NULL),
(52, 31, 'Имеет ли эта история особый смысл для советского человека конца 60-х годов? Если да, то какой?', 'short-answer', 5, NULL, NULL),
(53, 31, '	Является ли стрелок положительным героем?', 'short-answer', 6, NULL, NULL),
(54, 31, 'Где и когда происходит действие песни? \n\nОбратите особое внимание на следующие строчки: \n    \"В королевстве, где все тихо и складно...\" \n    \"В бесшабашной жил тоске и гусарстве...\" \n    \"Мне бы — выкатить портвейна бадью!\"', 'short-answer', 4, NULL, NULL),
(58, 32, 'Перепишите историю прозой, заменив конец на другой или добавив продолжение. \n\nИЛИ \n\nНапишите новый конец или продолжение в стихах.', 'short-answer', 1, NULL, NULL),
(59, 32, 'В советское время говорили, что можно жить, если \"не читать (газету) и не включать (телевизор)\". Что лучше — участвовать в далеко не совершенном политическом процессе и активно бороться с социальной реальностью, или же уйти от общественной жизни? Какими могут быть этические доводы с той и другой стороны?', 'short-answer', 2, NULL, NULL),
(60, 33, 'Какие песни вы поете от избытка чувств?', 'long-answer', 1, NULL, NULL),
(61, 33, 'Кто такие цыгане (Gypsies)? Что вы знаете о них?', 'long-answer', 2, NULL, NULL),
(62, 33, 'Какие ассоциации цыгане вызывают у вас?', 'long-answer', 3, NULL, NULL),
(63, 34, 'Опишите песню (слова и музыку) человеку, который никогда не слышал цыганских песен.', 'short-answer', 1, NULL, NULL),
(65, 35, '\"Эх!\"', 'long-answer', 1, NULL, NULL),
(66, 36, 'Каким образом качества, обычно ассоцирующиеся с цыганами (те же \"непосредственность\", \"страстность\", \"задушевность\") проявляются в тексте песни, в мелодии, в аккоманементе, в голосе певца?', 'short-answer', 1, NULL, NULL),
(67, 36, 'Сравните песню Лещенко и стихи Григорьева. Чем они похожи? Чем они отличаются? (Обратите внимание и на тексты и на гамму эмоций, которые передаются в стихах и в песне.)', 'short-answer', 2, NULL, NULL),
(68, 37, 'У вас скверное-прескверное настроение. Что может помочь? К кому или куда вы пойдете?', 'long-answer', 1, NULL, NULL),
(69, 37, '	\nНеобходимые слова и выражения: \n\nповремени́ть — подождать немного, медлить, тянуть время \nУтро вечера мудренее... — пословица. Важные решения надо делать, подождав до утра. \nне так = wrong; не так, как надо; cр. не то; не тот; не туда [the wrong way] \nнатоща́к — на голодный желудок \nпохме́лье — hang-over \nкаба́к — таверна \nшут — jester \nтьма — мрак, darkness \nчистое поле — ровное, где видно далеко [Даль]; в народной поэзии часто упоминается «чисто поле» \nвасильки́ (ед. василёк) — ярко синие цветы \nБа́ба-Яга́ — лесная ведьма русских сказок \nтопо́р — axe \nпода́вно — тем более \ncвято́й — holy, sacred', 'long-answer', 2, NULL, NULL),
(70, 38, 'Попытайтесь назвать все места, где, как поется в песне, все не так, как надо.', 'short-answer', 1, NULL, NULL),
(71, 38, 'Как вы думаете, что Высоцкий хотел сказать выбором именно этих мест?', 'short-answer', 2, NULL, NULL),
(72, 39, 'А пароль — венгерка.', 'long-answer', 1, NULL, NULL),
(73, 40, 'Что не то...', 'long-answer', 1, NULL, NULL),
(74, 40, 'во сне?', 'short-answer', 2, NULL, NULL),
(75, 40, 'утром?', 'short-answer', 3, NULL, NULL),
(76, 40, 'в кабаке?', 'short-answer', 4, NULL, NULL),
(77, 40, 'в церкви?', 'short-answer', 5, NULL, NULL),
(78, 40, 'на природе?', 'short-answer', 6, NULL, NULL),
(79, 40, 'в жизни?', 'short-answer', 7, NULL, NULL),
(80, 41, 'Почему эта песня называется «Моя цыганская»?', 'short-answer', 1, NULL, NULL),
(81, 41, 'Какое настроение у певца?', 'short-answer', 2, NULL, NULL),
(82, 41, 'Какой у него голос?\n', 'short-answer', 3, NULL, NULL),
(83, 41, 'Почему ему плохо?', 'short-answer', 4, NULL, NULL),
(84, 41, 'Почему это «цыганская» песня?', 'short-answer', 5, NULL, NULL),
(85, 42, 'Прослушайте примеры советской цыганской песни. \n\nВы можете привести свои примеры того, как живое культурное явление становится клише?', 'short-answer', 1, NULL, NULL),
(86, 42, 'Было ли такое время в вашей жизни, когда казалось, что все не так? Почему вы так себя чувствовали? Вы нашли способ \"отвести душу\"? Как все закончилось?', 'short-answer', 2, NULL, NULL),
(87, 42, 'Что не так в нашем обществе? В мире? Что именно так, как надо? Возможно ли изменить порядок вещей? Если нет, почему? Если да, то как?', 'short-answer', 3, NULL, NULL),
(88, 43, 'Вы пригласили девушку (парня) на свидание. \n\n    (Ходите ли вы на свидания? В 30-х годах еще ходили.) \n\nОна (он) согласилась (согласился)! Ура! \n\nКуда вы пойдете? \n\nКак вы подготовитесь? \n\nЧто вы наденете?', 'long-answer', 1, NULL, NULL),
(89, 43, 'Каких исполнителей раннего джаза вы знаете? Они пели песни или только играли на каком-нибудь инструменте?', 'long-answer', 2, NULL, NULL),
(90, 43, 'Необходимые выражения: \n\nЗол (зла, злы) — сердитый (angry). Он зол (в какой-то конкретный момент). Он зол на кого-то, на что-то. [В этих конструкциях употребляются только краткие формы прилагательного.] Родственные слова — злость, (разо)злиться. \nТот же (самый) — the same \nср. не тот — \'the wrong\' \nра́зные — different (in plural or with collective nouns); ср. друго́й — a different, other, another \n    Это был другой человек. \n    Люди разные. \n    Эти ботинки малы. Дайте другие (другую пару). \n    Он вышел из дома в разных ботинках.', 'long-answer', 3, NULL, NULL),
(91, 44, 'Прослушайте внимательно песню. Потом ответьте на вопросы.', 'long-answer', 1, NULL, NULL),
(92, 44, 'Какие отношения между героем и героиней в начале песни?', 'short-answer', 2, NULL, NULL),
(93, 44, 'Как герой готовится к свиданию?', 'short-answer', 3, NULL, NULL),
(94, 44, 'Какая неувязка возникает?', 'short-answer', 4, NULL, NULL),
(95, 44, 'С какими результатами?', 'short-answer', 5, NULL, NULL),
(96, 44, 'В чем шутка?', 'short-answer', 6, NULL, NULL),
(97, 45, 'На отдельном листе запишите слова песни. Стремитесь к максимальной точности.', 'long-answer', 1, NULL, NULL),
(98, 46, 'Как бы вы назвали эту песню? (Настоящее название найдете в \"Примечаниях\".)', 'short-answer', 1, NULL, NULL),
(99, 47, 'Пароль — \"Эрмитаж\". \n\n(Нет, не музей в Зимнем дворце в Петербурге, а Сад Эрмитаж, в Каретном ряду в Москве, где в конце 20-х годов играл джаз-оркестр под управлением Цфасмана, а в 40-х он был музыкальным директором театра \"Эрмитаж\".)', 'long-answer', 1, NULL, NULL),
(100, 48, 'По-русски можно выразить значение the same оборотами \n\nТот же \nТот же самый \nОдин и тот же \n\nОборот \"тот самый\" отличается от предыдущих тем, что речь идет в нем о чем-нибудь единичном и определенном: тот самый человек, с которым я говорил утром; то самое платье, которое я искал (the very dress). \n\n\"Тот же (самый)\" склоняется по всем правилам русской грамматики: Мы пришли к тому же выводу; мы занимаемся теми же самыми вопросами. Таблицу можно найти здесь. \n\nВ зависимости от контекста the same может быть выражено такими фразами, как \"тот же\", \"то же\" (Мы занимаемся одним и тем же); \"туда же\" (the same direction); \"такой же\", и т.д.', 'long-answer', 1, NULL, NULL),
(101, 48, 'Заполните пробелы оборотом, означающим \"the same\".', 'long-answer', 2, NULL, NULL),
(102, 48, 'Я боюсь_ _, чего и ты (боишься).', 'fill-blank', 3, NULL, '[{\"choice\":\"того\"},{\"choice\":\"же\"}]'),
(103, 48, 'Они бывают в _ _квартирах, видят _ _людей.', 'fill-blank', 4, NULL, '[{\"choice\":\"тех\"},{\"choice\":\"же\"},{\"choice\":\"тех\"},{\"choice\":\"же\"}]'),
(104, 48, 'Мы купили _ _ _ _ кепку.', 'fill-blank', 5, NULL, '[{\"choice\":\"одну\"},{\"choice\":\"и\"},{\"choice\":\"ту\"},{\"choice\":\"же\"}]'),
(105, 48, 'Я_ _американец, как и вы! [может сказать американец первого поколения]', 'fill-blank', 6, NULL, '[{\"choice\":\"такой\"},{\"choice\":\"же\"}]'),
(106, 49, 'Заполните пропуски подходящими формами фразы \"не тот\" (the wrong), используя предлоги, если нужно.', 'long-answer', 1, NULL, NULL),
(107, 49, 'Отвертка — _ _. Дай крестовую.', 'fill-blank', 2, NULL, '[{\"choice\":\"не\"},{\"choice\":\"та\"}]'),
(108, 49, 'Вернитесь! Вы_ _пошли. [the wrong way]', 'fill-blank', 3, NULL, '[{\"choice\":\"не\"},{\"choice\":\"туда\"}]'),
(109, 49, 'Да, кажется,_ _ _сторону.', 'fill-blank', 4, NULL, '[{\"choice\":\"не\"},{\"choice\":\"в\"},{\"choice\":\"ту\"}]'),
(110, 49, '_ _ жалуешься! У меня самого три экзамена на этой неделе!', 'fill-blank', 5, NULL, '[{\"choice\":\"не:Не\"},{\"choice\":\"тому\"}]'),
(111, 49, 'Напишите 2 своих предложения с \"тот же\"/\"не тот\".', 'short-answer', 6, NULL, NULL),
(112, 50, 'В разделе \"Что слушать дальше?\" вы найдете примеры советской массовой песни этого периода. Послушайте марш из фильма \"Веселые ребята\" (1934) и \"Песню о родине\", которая прозвучала в фильме \"Цирк\" (1936). \n\nПохожа ли песня Цфасмана на эти песни? Чем она отличается?', 'short-answer', 1, NULL, NULL),
(113, 50, 'Вспомним, что происходило в России в 34-38-м годах. (В помощь следующая ссылка.) \n\nКак вы думаете, время повлияло на эти песни? Если да, то как?', 'short-answer', 2, NULL, NULL),
(114, 50, 'Трудный вопрос: имеет ли герой песни \"Неудачное свидание\" социальный облик?', 'short-answer', 3, NULL, NULL),
(115, 51, 'Необходимые слова и выражения: \n\nгру́стно — не весело; грусть — антоним слова «радость» \nопада́ть — what word is this related to (hint: the subject of the sentence is листья) \nхpуста́льный — crystal \nцвела́ → цвести́ — bloom \nплени́ть — capture \nне в си́лах → cи́ла — strength \nскры́ться — hide \nпогуби́ть — be/cause the death of \nпоко́й — мир, спокойствие \nо́чи — глаза', 'long-answer', 1, NULL, NULL),
(116, 52, 'Какая проблема у героя песни?', 'short-answer', 1, NULL, NULL),
(117, 52, 'Что заставляет его петь?', 'short-answer', 2, NULL, NULL),
(118, 52, 'Когда он был счастлив?', 'short-answer', 3, NULL, NULL),
(119, 53, 'В середине песни звучит новая мелодия. Выпишите все слова этой части песни.', 'short-answer', 1, NULL, NULL),
(120, 54, 'Пароль — \"танго\".', 'long-answer', 1, NULL, NULL),
(121, 55, 'Какая здесь музыка? Как называется этот стиль?', 'short-answer', 1, NULL, NULL),
(122, 55, 'Что делается с музыкой в середине песни?', 'short-answer', 2, NULL, NULL),
(123, 55, 'Это вставка из другой популярной песни. В каком она стиле?', 'short-answer', 3, NULL, NULL),
(124, 55, 'Как вы думаете, какое у этой новой песни название?', 'short-answer', 4, NULL, NULL),
(125, 55, 'Чьи могут быть такие очи?', 'short-answer', 5, NULL, NULL),
(127, 56, 'Напишите историю несчастливой или счастливой любви.', 'short-answer', 1, NULL, NULL),
(128, 57, 'Вы любите песни \"дедушек и бабушек\"? \"Отцов и матерей\"? Почему или почему нет?', 'short-answer', 1, NULL, NULL),
(129, 58, 'Какие темы и образы подходят для государственного гимна?', 'long-answer', 1, NULL, NULL),
(130, 58, 'Чего не должно быть в гимне?', 'long-answer', 2, NULL, NULL),
(131, 58, 'Как должны петь государственный гимн?', 'long-answer', 3, NULL, NULL),
(132, 58, 'Какие чувства человек должен испытывать, когда он поет гимн своей страны?', 'long-answer', 4, NULL, NULL),
(133, 58, 'Какие чувства вы испытываете, когда вы поете гимн США?', 'long-answer', 5, NULL, NULL),
(134, 58, '	\nНеобходимые слова: \n\nсою́з — union, alliance \nнеруши́мый — который нельзя разрушить, не падет \nсплáчивать/сплоти́ть — сомкнуть, скрепить в тесный (плотный) ряд (плечо к плечу, бревно к бревну); объединить в одно неразрывное целое \nнаве́ки — навсегда \nсла́виться — быть известным чем-нибудь \nоте́чество — родина \nторжество́ — полная победа (victory), триумф \n        торже́ственный — важный, величавый (majestic) и серьёзный \nпо́двиг — feat, heroic deed', 'long-answer', 6, NULL, NULL),
(136, 59, 'Прослушайте песню и заполните пробелы:', 'long-answer', 1, NULL, NULL),
(140, 59, '_ _ дело _ _ народы,\n_ _ _ _ _ _ вдохновил!', 'fill-blank', 5, NULL, '[{\"choice\":\"На:на\"},{\"choice\":\"правое\"},{\"choice\":\"он\"},{\"choice\":\"поднял\"},{\"choice\":\"На:на\"},{\"choice\":\"труд\"},{\"choice\":\"и\"},{\"choice\":\"на\"},{\"choice\":\"подвиги\"},{\"choice\":\"нас\"}]'),
(141, 59, '_ _ — сила народная\n_ _ торжеству _ _!', 'fill-blank', 4, NULL, '[{\"choice\":\"Партия:партия\"},{\"choice\":\"Ленина\"},{\"choice\":\"Нас:нас\"},{\"choice\":\"к\"},{\"choice\":\"коммунизма\"},{\"choice\":\"ведёт:ведет\"}]'),
(142, 59, 'Славься, _ _ _,\n_ _ _ оплот!', 'fill-blank', 3, NULL, '[{\"choice\":\"отечество:Отечество\"},{\"choice\":\"наше\"},{\"choice\":\"свободное\"},{\"choice\":\"Дружбы:дружбы\"},{\"choice\":\"народов\"},{\"choice\":\"надежный:надёжный\"}]'),
(143, 59, 'Союз _ _ _\n_ _ _ Русь.', 'fill-blank', 2, NULL, '[{\"choice\":\"нерушимый\"},{\"choice\":\"республик\"},{\"choice\":\"свободных\"},{\"choice\":\"Сплотила:сплотила\"},{\"choice\":\"навеки\"},{\"choice\":\"Великая:великая\"}]'),
(144, 60, 'В каком стиле исполняется песня?', 'short-answer', 1, NULL, NULL),
(145, 60, 'Стиль соответствует содержанию?', 'short-answer', 2, NULL, NULL),
(146, 60, 'Послушайте РенТВ версию песни. \nВ какой обстановке исполняется песня?', 'short-answer', 3, NULL, NULL),
(147, 60, 'Какие эмоции песня вызывает у слушающих? Как вы думаете, почему?', 'short-answer', 4, NULL, NULL),
(148, 60, 'Как вы думаете, это до или после распада Советского Союза? До или после утверждения нового российского гимна с этой мелодией?', 'short-answer', 5, NULL, NULL),
(149, 61, 'А пароль — \"подвиг\".', 'long-answer', 1, NULL, NULL),
(150, 62, 'Перечитайте первую строфу.', 'long-answer', 1, NULL, NULL),
(151, 62, 'Есть ли иерархия между республиками и народами в Советском Союзе? Если да, то кто главный?', 'short-answer', 2, NULL, NULL),
(152, 62, 'Как долго будет существовать Советский Союз?', 'short-answer', 3, NULL, NULL),
(153, 62, 'Кто создал Советский Союз? Кто дал ему право на существование?', 'short-answer', 4, NULL, NULL),
(154, 62, 'Как бы вы охарактеризовали стиль первого куплета песни? (Речь идет о словах.) \n\nСтиль слов совпадает со стилем музыки (в традиционном исполнении)?', 'short-answer', 5, NULL, NULL),
(155, 62, 'Теперь читайте дальше.', 'long-answer', 6, NULL, NULL),
(156, 62, 'К чему стремится Советский Союз?', 'short-answer', 7, NULL, NULL),
(157, 62, 'Кто указал путь к этим высотам?', 'short-answer', 8, NULL, NULL),
(158, 62, 'В целом, что за страна Советский Союз? Какие качества его отличают?', 'short-answer', 9, NULL, NULL),
(159, 62, 'Вернемся мысленно к исполнению песни гр. \"5\'nizza\".', 'long-answer', 10, NULL, NULL),
(160, 62, 'Какие голоса сосуществуют и борются между собой, когда группа \"5\'nizza\" исполняет гимн? Сколько слоев можно различить? Чьи голоса присутствуют явно (мы слышим их)? Чьи присутствуют имплицитно (как эхо прошлого или как повлиявшие на форму песни)?', 'short-answer', 11, NULL, NULL),
(161, 62, 'Как вы думаете — какие цели преследуют/преследовали эти разные \"со-авторы\" и \"со-исполнители\" гимна?', 'short-answer', 12, NULL, NULL),
(162, 63, 'Теперь послушайте Гимн России в исполнении гр. \"Любэ\":', 'long-answer', 1, NULL, NULL),
(163, 63, 'В каком стиле исполняет новый гимн гр. \"Любэ\"?', 'short-answer', 2, NULL, NULL),
(164, 63, 'Стиль соответсвует содержанию?', 'short-answer', 3, NULL, NULL),
(165, 63, 'В какой обстановке исполняется песня?', 'short-answer', 4, NULL, NULL),
(166, 63, 'Какие эмоции песня вызывает у слушающих? Они радостно подпевают? Как вы считаете, почему?', 'short-answer', 5, NULL, NULL),
(167, 64, 'Перепишите первые две строки гимна, перемещая слова, чтобы добиться как можно более нейтрального порядка слов.', 'short-answer', 1, NULL, NULL),
(168, 65, 'Распутайте следующие строки из стихотворения Пушкина \"К Чаадаеву\" (1818?). Востановите наиболее нейтральный порядок слов. \n\nПод гнетом власти роковой \nНетерпеливою душой \nОтчизны внемлем призыванье.', 'short-answer', 1, NULL, NULL),
(169, 66, 'Какое значение имеет то, что новый гимн России поется на музыку советского гимна? (Текст нового гимна можно прочитать здесь). Какое значение имеет то, что его автор — один из соавторов гимна СССР?', 'short-answer', 1, NULL, NULL),
(170, 66, 'Как вам кажется, какое значение имеет то, что \"5\'nizza\", группа из Харькова (города на востоке Украины), исполняет гимн СССР? \n\nНа каком языке, между прочим, поют здесь?', 'short-answer', 2, NULL, NULL),
(171, 66, 'Это стёб или нечто другое? \n\nСтёб — особый тип иронии. Стёбом по-русски называется ироническое высмеивание путём крайнего самоотождествления с высмеиваемым мировоззрением. (Более подробно о стёбе см. песню \"Гагарин, я вас любила\" в уроке \"Гагарин\".)', 'short-answer', 3, NULL, NULL),
(172, 66, 'В разделе \"Текст/примечания/контекст\" посмотрите дополнительные материалы о новом российском гимне. \n\nКаково ваше мнение и почему: правильным или неправильным было решение написать новый гимн на мелодию старого (советского) гимна? Хорошо или плохо, что автором слов нового гимна стал Сергей Михалков?', 'short-answer', 4, NULL, NULL),
(173, 67, 'Напишите (с музыкой или без) новый гимн России. \n\nили \n\nНапишите проект нового гимна. Какой должна быть музыка? Какими будут образы? Какие темы гимн будет затрагивать? Какой будет общая тональность? Можно назвать отдельные фразы, которые войдут в текст. Почему вы решили так его написать, а не иначе?', 'short-answer', 1, NULL, NULL),
(174, 68, 'С какими песнями идут в бой? С какими отдыхают на фронте? С какими ждут дома?', 'long-answer', 1, NULL, NULL),
(175, 68, 'Как долго длилась Вторая мировая война для Советского Союза? Как долго длилась военная служба советских солдат во время войны?', 'long-answer', 2, NULL, NULL),
(176, 68, 'Необходимая лексика: \n\nбой — battle \nфронт \nпулемёт — machine gun \nстрочи́ть — стрелять (из автоматического оружия) \nсбере́чь — бережно сохранить \nо́блик — внешний вид, образ, лицо \nзаве́тный — особенно ценимый, свято хранимый; самый дорогой для кого-л. \nне́жный — tender', 'long-answer', 3, NULL, NULL),
(177, 69, 'Помню, _ _ памятный _\n_ _ _ _ _,\n_ _,\n_ _\n_ _ сберечь.', 'fill-blank', 1, NULL, '[{\"choice\":\"как\"},{\"choice\":\"в\"},{\"choice\":\"вечер\"},{\"choice\":\"Падал:падал\"},{\"choice\":\"платочек\"},{\"choice\":\"твой\"},{\"choice\":\"с\"},{\"choice\":\"плеч\"},{\"choice\":\"Как:как\"},{\"choice\":\"провожала\"},{\"choice\":\"И:и\"},{\"choice\":\"обещала\"},{\"choice\":\"Синий:синий\"},{\"choice\":\"платочек\"}]'),
(178, 69, 'Письма твои _,\n_ _ _ родной.\n_ _ _\n_ _\nСнова _ _ _.', 'fill-blank', 2, NULL, '[{\"choice\":\"получая\"},{\"choice\":\"Cлышу:слышу\"},{\"choice\":\"я\"},{\"choice\":\"голос\"},{\"choice\":\"И:и\"},{\"choice\":\"между\"},{\"choice\":\"строчек\"},{\"choice\":\"Синий:синий\"},{\"choice\":\"платочек\"},{\"choice\":\"встает\"},{\"choice\":\"предо\"},{\"choice\":\"мной\"}]'),
(179, 69, 'За них, _,\n_, _ таких.\nСтрочит пулеметчик\n_ _ _,\n_ _ _ _ _!', 'fill-blank', 3, NULL, '[{\"choice\":\"родных\"},{\"choice\":\"Желанных:желанных\"},{\"choice\":\"любимых\"},{\"choice\":\"За:за\"},{\"choice\":\"синий\"},{\"choice\":\"платочек\"},{\"choice\":\"Что:что\"},{\"choice\":\"был\"},{\"choice\":\"на\"},{\"choice\":\"плечах\"},{\"choice\":\"дорогих\"}]'),
(180, 70, 'Кто кому поет? Песня поется от лица женщины или мужчины?', 'short-answer', 1, NULL, NULL),
(181, 70, 'Где солдат сейчас?', 'short-answer', 2, NULL, NULL),
(182, 70, 'Что поддерживает его в бою?', 'short-answer', 3, NULL, NULL),
(183, 70, 'За что он воюет?', 'short-answer', 4, NULL, NULL),
(184, 71, 'А пароль — страда.', 'long-answer', 1, NULL, NULL),
(185, 72, 'Почему вечер в первой строфе был памятный?', 'short-answer', 1, NULL, NULL),
(186, 72, 'Откуда синий платочек? Почему дано обещание его сберечь?', 'short-answer', 2, NULL, NULL),
(187, 72, 'В какой комнате \"любимая\" держит платок теперь?', 'short-answer', 3, NULL, NULL),
(188, 72, 'Что помогает герою чувствовать ее близость?', 'short-answer', 4, NULL, NULL),
(189, 72, 'Что поддерживает его в бою?', 'short-answer', 5, NULL, NULL),
(190, 72, 'В каком смысле бойцы сохраняют заветные платочки?', 'short-answer', 6, NULL, NULL),
(191, 72, 'За что они воюют? Что дает смысл их испытаниям и жертвам?', 'short-answer', 7, NULL, NULL),
(192, 72, 'В полной версии песни: \n\nЧем все кончится?', 'short-answer', 8, NULL, NULL),
(193, 73, 'Расскажите группе (3-4 минуты) о ходе событий и историческом значении одного из следующих фактов Великой Отечественной войны. В подготовке к докладу можно использовать не только печатные источники (в интернете), но и видео (на youtube\'e или rutube\'е): \n\nРепрессии в РККА (Красной Армии) 1937-38 гг. \nПакт Молотова-Риббентропа \nОперация \"Барбаросса\" \nБабий Яр \nПанфиловцы \nБлокада Ленинграда \nЭвакуация \nБитва за Сталинград \nФорсирование Днепра \nПадение Берлина', 'short-answer', 1, NULL, NULL),
(194, 74, '	\nНеобходимая лексика: \n\nшпик — свиное сало (как блюдо) \nпривыкáть/привы́кнуть — become accustomed \n  отвыкáть/отвы́кнуть — become unused to \nмужи́к — русский крестьянин (peasant) \nштык — bayonet \nмунди́р — военная форма \nбое́ц — солдат', 'long-answer', 1, NULL, NULL),
(195, 75, 'Как трансформируется фамилия барона? Какие рифмы к ней подбираются?', 'short-answer', 1, NULL, NULL),
(196, 76, 'а пароль — \"капут\".', 'long-answer', 1, NULL, NULL),
(197, 77, 'Кто такой барон фон дер Пшик?', 'short-answer', 1, NULL, NULL),
(198, 77, 'О чем он мечтает?', 'short-answer', 2, NULL, NULL),
(199, 77, 'Как жил раньше (и жить привык) барон?', 'short-answer', 3, NULL, NULL),
(200, 77, 'Что (и почему) он орет по радио?', 'short-answer', 4, NULL, NULL),
(201, 77, 'Кто подает ему шпик? Где?', 'short-answer', 5, NULL, NULL),
(202, 77, 'Почему важно что: \n\n    мужик? \n    клюква равесистая? \n    Сталинград?', 'short-answer', 6, NULL, NULL),
(203, 77, 'Барон действительно, как на параде в Сталинграде (Ленинграде)?', 'short-answer', 7, NULL, NULL),
(204, 77, 'О чем он забыл, размечтавшись о русском шпике?', 'short-answer', 8, NULL, NULL),
(205, 77, 'Каких баронов (какого барона) привык бить русский штык? Когда он их/его бил?', 'short-answer', 9, NULL, NULL),
(206, 77, 'Почему барон — барон? Вы можете назвать одного или двух \"релевантных\" для песни баронов?', 'short-answer', 10, NULL, NULL),
(207, 77, 'Что стало с бароном?', 'short-answer', 11, NULL, NULL),
(208, 77, 'Что от него осталось? Чем стал его прежний \"ор\" (крик)? (Барон ведь орал.)', 'short-answer', 12, NULL, NULL),
(209, 78, 'Сравните песни Шульженко и Утесова (а также другие песни военного времени) с песнями Высоцкого в разделе \"Что слушать дальше!\". Чем они отличаются? Какие эмоции и образы преобладают в песнях военного времени? Какие в песнях Высоцкого? Почему?', 'short-answer', 1, NULL, NULL),
(210, 78, 'Во время и после вьетнамской войны многие песни и фильмы выражали резко негативное отношение к войне. Во всяком случае они выражали боль потерь более открыто, чем эти песни ВОВ. То же самое можно сказать о солдатских песнях времени афганской войны. (Их можно послушать в следующем уроке, в разделе \"Что слушать дальше!\".) Вредят ли такие песни военной дисциплине? Какие песни нужны во время войны? Обоснуйте свое мнение.', 'short-answer', 2, NULL, NULL),
(211, 79, 'Посмотрите выступление Ксении Симоновой на передаче \"Україна має талант\".\n\nОпишите словами и перескажите сюжет ее выступления. Стремитесь к максимальной точности и подробности в своем пересказе. \n\nМужской голос, объявляющий о начале войны (\"Внимание, говорит Москва. Граждане и гражданки Советского Союза, сегодня, 22-го июня...\") принадлежит знаменитому диктору Всесоюзного радио Юрию Левитану. (Правда, это запись 50-х годов, так как радиосообщения тех лет не записывались.)', 'short-answer', 1, NULL, NULL),
(212, 80, 'Что такое солдат? (Заметьте, по-русски солдат и офицер понятия разные.)', 'long-answer', 1, NULL, NULL),
(213, 80, 'Какое у него существование?', 'long-answer', 2, NULL, NULL),
(214, 81, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(215, 81, '1) Я — солдат.\nЯ не _ _ _, и у меня _ _ мешки.\n_ _ _ _, \n_ _ _ _.\nЯ — солдат, _ _ _ _ башки, \n_ _ _ _.', 'fill-blank', 2, NULL, '[{\"choice\":\"спал\"},{\"choice\":\"пять\"},{\"choice\":\"лет\"},{\"choice\":\"под\"},{\"choice\":\"глазами\"},{\"choice\":\"Я:я\"},{\"choice\":\"сам\"},{\"choice\":\"не\"},{\"choice\":\"видел\"},{\"choice\":\"но:Но\"},{\"choice\":\"мне\"},{\"choice\":\"так\"},{\"choice\":\"сказали\"},{\"choice\":\"и\"},{\"choice\":\"у\"},{\"choice\":\"меня\"},{\"choice\":\"нет\"},{\"choice\":\"мне\"},{\"choice\":\"отбили\"},{\"choice\":\"её:ее\"},{\"choice\":\"сапогами\"}]'),
(216, 81, '2) Белая вата, _ _ _ _ _.', 'fill-blank', 3, NULL, '[{\"choice\":\"красная\"},{\"choice\":\"вата\"},{\"choice\":\"не\"},{\"choice\":\"лечит\"},{\"choice\":\"солдата\"}]'),
(217, 81, '3) Я — солдат, недоношенный _ войны,\nЯ — солдат, _ , _ _ _,\nЯ — солдат, _ _ _ _,\n_ &mdash; _, _ _ _ _.', 'fill-blank', 4, NULL, '[{\"choice\":\"ребёнок:ребенок\"},{\"choice\":\"мама\"},{\"choice\":\"залечи\"},{\"choice\":\"мои\"},{\"choice\":\"раны\"},{\"choice\":\"солдат\"},{\"choice\":\"забытой\"},{\"choice\":\"богом\"},{\"choice\":\"страны\"},{\"choice\":\"Я:я\"},{\"choice\":\"герой\"},{\"choice\":\"скажите\"},{\"choice\":\"мне\"},{\"choice\":\"какого\"},{\"choice\":\"романа\"}]'),
(218, 82, 'а пароль — \"вата\".', 'long-answer', 1, NULL, NULL),
(219, 83, 'Почему солдат не видел мешки под собственными глазами?', 'short-answer', 1, NULL, NULL),
(220, 83, 'Что случилось с комбатом?', 'short-answer', 2, NULL, NULL),
(221, 83, 'Почему солдат не просто ребенок войны, а \"недоношенный\" ее ребенок?', 'short-answer', 3, NULL, NULL),
(222, 83, 'Почему поющие утверждают, что страна, за которую воюет солдат, \"забытая богом\"?', 'short-answer', 4, NULL, NULL),
(223, 83, 'В каком смысле солдат — \"герой\"?', 'short-answer', 5, NULL, NULL),
(224, 83, 'Какие стороны солдатской жизни освещаются в этой песне?', 'short-answer', 6, NULL, NULL),
(225, 83, 'Какие прилагательные подходят для описания этой жизни?', 'short-answer', 7, NULL, NULL),
(226, 83, 'К кому обращается солдат своей песней?', 'short-answer', 8, NULL, NULL),
(227, 83, 'Что ему нужно? Как война его изменила?', 'short-answer', 9, NULL, NULL),
(228, 83, 'А вот концертная запись песни \"Солдат\":', 'long-answer', 10, NULL, NULL),
(229, 83, 'Как вы cчитаете, почему эта песня стала такой популярной?', 'short-answer', 11, NULL, NULL),
(230, 84, 'Вы солдат на войне. \n\n      За кого/что вы воюете? \n\n      Ради кого/чего нужно выжить? \n\n      За кого/что выпить (сейчас и потом)?', 'long-answer', 1, NULL, NULL),
(231, 84, 'Необходимая лексика: \n\nвыжива́ть/вы́жить — остаться в живых \nра́на — wound \n    ра́неный \nпехо́та — infantry \n    cр. пéший (и конный), пе́шка (в шахматах), пешехо́д \nнаступа́ть — ведя военные действия, двигаться вперёд, атаковать \n    наступле́ние. Армия перешла в наступление. \nпрокля́тие — curse \n    Будь про́клят(а)! \nдеса́нт — Airborne \nспецна́з — Войска специального назначения (Special Forces) \nо́рден (мн. ордена́) — decoration \nбо́мба \n    бомбёжка \nстон — жалобный звук, издаваемый человеком от боли или при сильном горе', 'long-answer', 2, NULL, NULL),
(232, 85, 'C чьей точки зрения поется песня?', 'short-answer', 1, NULL, NULL),
(233, 85, '1-я попытка ответить: \n\nКак исполнители относятся к войне? К России?', 'short-answer', 2, NULL, NULL),
(234, 86, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(235, 86, '_ _ _, _ _ _ _\n_ _ _, _ _ _ _ _\n_ _ _, _ проклята война\nПомянем тех, _ _ _ _ _.', 'fill-blank', 2, NULL, '[{\"choice\":\"Давай:давай\"},{\"choice\":\"за\"},{\"choice\":\"жизнь\"},{\"choice\":\"давай\"},{\"choice\":\"брат\"},{\"choice\":\"до\"},{\"choice\":\"конца\"},{\"choice\":\"Давай:давай\"},{\"choice\":\"за\"},{\"choice\":\"тех\"},{\"choice\":\"кто\"},{\"choice\":\"с\"},{\"choice\":\"нами\"},{\"choice\":\"был\"},{\"choice\":\"тогда\"},{\"choice\":\"Давай:давай\"},{\"choice\":\"за\"},{\"choice\":\"жизнь\"},{\"choice\":\"будь\"},{\"choice\":\"кто\"},{\"choice\":\"с\"},{\"choice\":\"нами\"},{\"choice\":\"был\"},{\"choice\":\"тогда\"}]'),
(236, 86, 'Только _ выжил _ _ _\n_ потерпи, _ , _ _ _\n_ _ _ _ _ _ _\n_ _ _ _ _ отплясывать\n_ _ _ _ детишек подбрасывать', 'fill-blank', 3, NULL, '[{\"choice\":\"бы\"},{\"choice\":\"товарищ\"},{\"choice\":\"мой\"},{\"choice\":\"раненый\"},{\"choice\":\"Ты:ты\"},{\"choice\":\"браток\"},{\"choice\":\"не\"},{\"choice\":\"умирай\"},{\"choice\":\"пока\"},{\"choice\":\"Будешь:будешь\"},{\"choice\":\"ты\"},{\"choice\":\"жить\"},{\"choice\":\"ещё\"},{\"choice\":\"долго\"},{\"choice\":\"и\"},{\"choice\":\"счастливо\"},{\"choice\":\"Будем:будем\"},{\"choice\":\"на\"},{\"choice\":\"свадьбе\"},{\"choice\":\"твоей\"},{\"choice\":\"мы\"},{\"choice\":\"Будешь:будешь\"},{\"choice\":\"ты\"},{\"choice\":\"в\"},{\"choice\":\"небо\"}]'),
(237, 87, 'а пароль — \"за Кавказ!\".', 'long-answer', 1, NULL, NULL),
(238, 88, 'Где и когда происходит действие в начале песни?', 'short-answer', 1, NULL, NULL),
(239, 88, 'Как меняется ракурс во второй половине первого куплета? С какого расстояния мы наблюдаем события?', 'short-answer', 2, NULL, NULL),
(240, 88, 'Что происходит во втором куплете (\"Небо над нами свинцовыми тучами...\")? Если бы вы снимали это в кино, как бы этот кадр выглядел?', 'short-answer', 3, NULL, NULL),
(241, 88, 'Что значит \"Давай за...\"? Как меняется значение этой фразы от первого припева ко второму и потом в cредней части песни (\"Давай за них, давай за нас...\")?', 'short-answer', 4, NULL, NULL),
(242, 88, 'Что добавляет последний куплет? Как он обогащает и завершает (делает законченной) песню?', 'short-answer', 5, NULL, NULL),
(243, 88, 'В той части песни, которая начинается \"Давай за них, давай за нас\", с кем и чем сближает себя группа \"Любэ\"? Какая политическая или жизненная программа здесь возникает?', 'short-answer', 6, NULL, NULL),
(244, 88, 'Где \"враги\" в этой песне? Как бы она изменилась, если бы они появлялись открыто? \n\nКак вы понимаете слово \"враг\" в песне гр. \"5\'nizza\"?', 'short-answer', 7, NULL, NULL),
(245, 88, 'Какие стороны военной жизни освещаются в ЭТОЙ песне?', 'short-answer', 8, NULL, NULL),
(246, 88, 'Какие прилагательные подходят для описания этой жизни?', 'short-answer', 9, NULL, NULL),
(247, 88, 'Как вы думаете, почему ЭТА песня была популярной?', 'short-answer', 10, NULL, NULL),
(251, 89, 'Сравните образы солдат, которые возникают в этих двух песнях.', 'short-answer', 1, NULL, NULL),
(252, 89, 'Чем они отличаются друг от друга? \n\nМузыкально? \nПо идейному складу? \nПо отношению к власти? \nПо отношению к войне?', 'short-answer', 2, NULL, NULL),
(253, 89, 'Вы знаете людей, которые воевали? Или, может, сами воевали? Какие песни лучше всего отражают ваш опыт или опыт ваших друзей, знакомых, родных на войне? Почему?', 'short-answer', 3, NULL, NULL),
(254, 89, 'У русских есть классический тост: \"Чтоб не было войны!\" \n\nВозможен ли мир без войны?', 'short-answer', 4, NULL, NULL),
(255, 90, 'Что вам нужно в жизни? \n\nТо же самое нужно всем? Или каждому нужно что-нибудь другое, свое? \n\nЧто вам не нужно?', 'long-answer', 1, NULL, NULL),
(256, 90, 'Необходимые слова: \n\nверте́ться — turn (around), spin \nя́ркий — bright \nум — intelligence \nтру́сость — cowardice \nсча́стье — luck (and happiness) \nвласть — power \nпереды́шка — отдых \nще́дрость — generosity \nисхо́д — конец \nраска́яние — penitence, remorse \nверова́ть — penitence, remorse \n   ве́ра — faith \nрай — Heaven \nве́дая — зная', 'long-answer', 2, NULL, NULL),
(257, 91, 'Заполните пробелы в первой строфе песни.', 'long-answer', 1, NULL, NULL),
(258, 91, 'Пока _ _ вертится,\n_ _ ярок _,\n_, _ _ _ _,\n_ _ _ _:\n_ _ _,\n_ _ _,\n_ _ _...\n_ _ _ _ меня.', 'fill-blank', 2, NULL, '[{\"choice\":\"земля:Земля\"},{\"choice\":\"ещё:еще\"},{\"choice\":\"пока:Пока\"},{\"choice\":\"еще\"},{\"choice\":\"свет\"},{\"choice\":\"Господи\"},{\"choice\":\"дай\"},{\"choice\":\"же\"},{\"choice\":\"Ты:ты\"},{\"choice\":\"каждому\"},{\"choice\":\"чего:Чего\"},{\"choice\":\"у\"},{\"choice\":\"него\"},{\"choice\":\"нет\"},{\"choice\":\"умному:Умному\"},{\"choice\":\"дай\"},{\"choice\":\"голову\"},{\"choice\":\"трусливому:Трусливому\"},{\"choice\":\"дай\"},{\"choice\":\"коня\"},{\"choice\":\"дай:Дай\"},{\"choice\":\"счастливому\"},{\"choice\":\"денег\"},{\"choice\":\"И:и\"},{\"choice\":\"не\"},{\"choice\":\"забудь\"},{\"choice\":\"про\"}]'),
(259, 92, 'За что молится лирический субъект этой песни? Какой принцип объединяет все его просьбы?', 'short-answer', 1, NULL, NULL),
(260, 92, 'Кому он молится?', 'short-answer', 2, NULL, NULL),
(261, 92, 'Он верующий?', 'short-answer', 3, NULL, NULL),
(262, 92, 'Что ему самому нужно?', 'short-answer', 4, NULL, NULL),
(263, 93, 'А пароль... \n\nконя!', 'long-answer', 1, NULL, NULL),
(264, 94, 'Почему надо дать мудрому голову?', 'short-answer', 1, NULL, NULL),
(265, 94, 'Почему трусливому нужен конь? Что это говорит о мире и жизни?', 'short-answer', 2, NULL, NULL),
(266, 94, 'Почему счастливому нужны деньги?', 'short-answer', 3, NULL, NULL),
(267, 94, 'Почему передышка нужна щедрому?', 'short-answer', 4, NULL, NULL),
(268, 94, 'Почему герой песни предлагает дать \"рвущемуся к власти навластвоваться всласть\"? Что это говорит о мировоззрении поющего?', 'short-answer', 5, NULL, NULL),
(269, 94, 'Как характеризует свою веру лирическое \"я\" песни?', 'short-answer', 6, NULL, NULL),
(270, 94, 'Что значит \"Как веруем и мы сами, не ведая, что творим\"?', 'short-answer', 7, NULL, NULL),
(271, 94, 'Удивительна здесь фраза \"зеленоглазый мой\". Как вы ее понимаете? Почему для поющего Бог зеленоглазый?', 'short-answer', 8, NULL, NULL),
(272, 94, 'Несколько раз повторяется фраза \"Пока земля еще вертится\". Вся песня так начинается: \"Пока земля еще вертится, пока еще ярок свет\". Что эта фраза добавляет в песню? Какое настроение она создает?', 'short-answer', 9, NULL, NULL),
(273, 94, 'Почему лирическое \"я\" не говорит, что ему нужно?', 'short-answer', 10, NULL, NULL),
(274, 94, 'Как вы думаете, что же нужно лирическому \"я\" песни? Есть намеки в песне? Какие?', 'short-answer', 11, NULL, NULL),
(275, 94, 'Меняется ли ответ на предыдущий вопрос, когда Окуджава меняет название песни? Если да, то как?', 'short-answer', 12, NULL, NULL),
(276, 95, 'Вы молитесь? Когда? О чем? О чем нельзя молиться? Почему?', 'short-answer', 1, NULL, NULL),
(277, 95, 'Какую роль играет религия в общественной жизни России и/или США сегодня? Какую роль должна она играть?', 'short-answer', 2, NULL, NULL),
(278, 95, 'Вы согласны с выводами Окуджавы о том, что кому нужно? \n\nПродолжите песню: \n\nЧто нужно грустному? \nсытому? \nпопулярному? \n??-ому? \n\nПочему?', 'short-answer', 3, NULL, NULL),
(279, 96, 'Где находится Колыма? Что значит Колыма в русской культуре?', 'long-answer', 1, NULL, NULL),
(280, 96, 'Читали ли вы когда-нибудь о советских лагерях?', 'short-answer', 2, NULL, NULL),
(281, 96, 'Кто сидел в лагерях?', 'short-answer', 3, NULL, NULL),
(282, 96, 'Какая там была жизнь?', 'short-answer', 4, NULL, NULL),
(283, 96, 'Что нужно было заключенному для жизни? Что обладало ценностью в лагере?', 'short-answer', 5, NULL, NULL),
(284, 96, 'Необходимые слова для этого урока: \n\nоку́рочек → оку́рок — cigarette butt \nла́герь — camp \nзаключённый (зек) — prisoner, convict \nполитзаключённый — человек, заключённый по политической \"статье\" (из них самой знаменитой была Статья №58) \nуголо́вник — criminal \n    уголо́вный кóдекс — criminal code \nу́рка — профессиональный вор \nнад-зира́т-ель — \"-зреть-/-зирать-\" значит \"смотреть\". Раньше говорили над-смо́тр-щик — это работник лагеря, который смотрит за заключёнными \nсрок — sentence. Отбывать/отбыть срок. Сидеть/отсидеть срок. \nзо́на — место, где заключённые работают. На Колыме рубили лес, добывали золото, строили. \nкáрцер — тюрьма в лагере. Там был особо жестокий режим: крайне мало ели, было очень холодно и нечем было укрыться. В очень маленьком помещении не было ни мебели, ни окна. \nразма́х — еще одно ключевое понятие в русской культуре. Ближайщий английский эквивалент — abandon (as in the phrase \"to do something with abandon\"). \nблатно́й мир — криминальный мир \nблатна́я пе́сня — песни воровского мира. Это в России 90-х годов был очень популярный жанр.', 'short-answer', 6, NULL, NULL),
(285, 97, '10) рукавичкой _ _ _ _...', 'fill-blank', 10, NULL, '[{\"choice\":\"вы\"},{\"choice\":\"мне\"},{\"choice\":\"по\"},{\"choice\":\"губам\"}]'),
(286, 97, '1) _ _ _ _ _ _\nи рванулся из строя к нему.', 'fill-blank', 1, NULL, '[{\"choice\":\"Я:я\"},{\"choice\":\"заметил\"},{\"choice\":\"окурочек\"},{\"choice\":\"с\"},{\"choice\":\"красной\"},{\"choice\":\"помадой\"}]'),
(287, 97, '2) _ _ _ мой бушлат.', 'fill-blank', 2, NULL, '[{\"choice\":\"Злобный:злобный\"},{\"choice\":\"пес:пёс\"},{\"choice\":\"разодрал\"}]'),
(288, 97, '3) Баб _ _ _ _ _', 'fill-blank', 3, NULL, '[{\"choice\":\"не\"},{\"choice\":\"видел\"},{\"choice\":\"я\"},{\"choice\":\"года\"},{\"choice\":\"четыре\"}]'),
(289, 97, '4) Всю дорогу _ _ _, _\n_ _ _ _ _.', 'fill-blank', 4, NULL, '[{\"choice\":\"до\"},{\"choice\":\"зоны\"},{\"choice\":\"шагали\"},{\"choice\":\"вздыхали\"},{\"choice\":\"Не:не\"},{\"choice\":\"сводили\"},{\"choice\":\"с\"},{\"choice\":\"окурочка\"},{\"choice\":\"глаз\"}]'),
(290, 97, '5) Ты во Внуково спьяну _ _ _,\n_ _ _ _ _ _.', 'fill-blank', 5, NULL, '[{\"choice\":\"билета\"},{\"choice\":\"не\"},{\"choice\":\"купишь\"},{\"choice\":\"чтоб:Чтоб\"},{\"choice\":\"хотя\"},{\"choice\":\"б\"},{\"choice\":\"пролететь\"},{\"choice\":\"надо\"},{\"choice\":\"мной\"}]'),
(291, 97, '6) _ _ _ _, _ _ _ \"_\"\nс золотым на конце ободком.', 'fill-blank', 6, NULL, '[{\"choice\":\"Сам:сам\"},{\"choice\":\"пьянел\"},{\"choice\":\"от\"},{\"choice\":\"того\"},{\"choice\":\"как\"},{\"choice\":\"курила\"},{\"choice\":\"ты\"},{\"choice\":\"\\\"Тройку\\\":тройку:Тройку\"}]'),
(292, 97, '7) _ _ _ _ _ _,\nхоть дороже _ _ _.', 'fill-blank', 7, NULL, '[{\"choice\":\"Проиграл:проиграл\"},{\"choice\":\"тот\"},{\"choice\":\"окурочек\"},{\"choice\":\"в\"},{\"choice\":\"карты\"},{\"choice\":\"я\"},{\"choice\":\"был\"},{\"choice\":\"тыщи:тысячи\"},{\"choice\":\"рублей\"}]'),
(293, 97, '8) _ _ _ _ урок,\nза размах _ _.', 'fill-blank', 8, NULL, '[{\"choice\":\"Господа:господа\"},{\"choice\":\"из\"},{\"choice\":\"влиятельных\"},{\"choice\":\"лагерных\"},{\"choice\":\"уважали\"},{\"choice\":\"меня\"}]'),
(294, 97, '9) Шел я в карцер босыми ногами,\n_ _, _ _ _ _', 'fill-blank', 9, NULL, '[{\"choice\":\"Как:как\"},{\"choice\":\"Христос\"},{\"choice\":\"и\"},{\"choice\":\"спокоен\"},{\"choice\":\"и\"},{\"choice\":\"тих\"}]'),
(295, 98, 'Где находится лирический герой песни?', 'short-answer', 1, NULL, NULL),
(296, 98, 'Зачем он выбегает из строя?', 'short-answer', 2, NULL, NULL),
(297, 98, 'Почему этот окурочек такой особенный?', 'short-answer', 3, NULL, NULL),
(298, 98, 'Что потом случается с окурочком?', 'short-answer', 4, NULL, NULL),
(299, 98, 'Как это изменяет жизнь героя?', 'short-answer', 5, NULL, NULL),
(300, 98, 'Какая разница между \"окурочком\" и \"окурком\"?', 'short-answer', 6, NULL, NULL),
(301, 99, 'А пароль — шмон.', 'long-answer', 1, NULL, NULL),
(302, 100, 'Где и когда начинается действие песни?', 'short-answer', 1, NULL, NULL),
(303, 100, 'Какое событие изменяет жизнь героя?', 'short-answer', 2, NULL, NULL),
(304, 100, 'Почему это происшествие ялвляется событием?', 'short-answer', 3, NULL, NULL),
(305, 100, 'Как относятся к находке товарищи героя?', 'short-answer', 4, NULL, NULL),
(306, 100, 'На какие мысли эта находка наводит героя? Кто мог уронить окурочек?', 'short-answer', 5, NULL, NULL),
(307, 100, 'Как герой к этому человеку относится?', 'short-answer', 6, NULL, NULL),
(308, 100, 'Какой неосторожный поступок дальше изменяет судьбу героя?', 'short-answer', 7, NULL, NULL),
(309, 100, 'Перескажите своими словами: \n\"Даже здесь не видать мне счастливого фарту / из-за грусти по даме червей.\"', 'short-answer', 8, NULL, NULL),
(310, 100, 'Кто/что такое \"дама червей\"?', 'short-answer', 9, NULL, NULL),
(311, 100, 'Какую стоимость имеет для героя окурочек?', 'short-answer', 10, NULL, NULL),
(312, 100, 'До чего доходит он в своей жизни? Какие лишения принимает он \"за этот окурочек\"?', 'short-answer', 11, NULL, NULL),
(313, 100, 'Почему и у кого это вызывает уважение?', 'short-answer', 12, NULL, NULL),
(314, 100, 'Почему герой попадает в карцер?', 'short-answer', 13, NULL, NULL),
(315, 100, 'Какой образ замыкает песню в кольцо?', 'short-answer', 14, NULL, NULL),
(316, 100, 'Какая здесь возникает ирония?', 'short-answer', 15, NULL, NULL),
(317, 100, 'Кто герой песни?', 'short-answer', 16, NULL, NULL),
(318, 101, 'Прочитайте следующий отрывок из повести Солженицына, \"Один день Ивана Денисовича\": \n\n      Художник обновил Шухову \"Щ-854\" на телогрейке, и Шухов, уже не запахивая бушлата, потому что до шмона оставалось недалеко, с веревочкой в руке догнал бригаду. И сразу разглядел: однобригадник его Цезарь курил, и курил не трубку, а сигарету — значит, подстрельнуть можно. Но Шухов не стал прямо просить, а остановился совсем рядом с Цезарем и вполоборота глядел мимо него. \n      Он глядел мимо и как будто равнодушно, но видел, как после каждой затяжки (Цезарь затягивался редко, в задумчивости) ободок красного пепла передвигался по сигарете, убавляя ее и подбираясь к мундштуку. \n      Тут же и Фетюков, шакал, подсосался, стал прямо против Цезаря и в рот ему засматривает, и глаза горят. \n      У Шухова ни табачинки не осталось, и не предвидел он сегодня прежде \nвечера раздобыть — он весь напрягся в ожидании, и желанней ему сейчас был этот хвостик сигареты, чем, кажется, воля сама, — но он бы себя не уронил и так, как Фетюков, в рот бы не смотрел. \n      В Цезаре всех наций намешано: не то он грек, не то еврей, не то цыган — не поймешь. Молодой еще. Картины снимал для кино. Но и первой не доснял, как его посадили. У него усы черные, слитые, густые. Потому не сбрили здесь, что на деле так снят, на карточке. \n      — Цезарь Маркович! — не выдержав, прослюнявил Фетюков. -- Да-айте \nразок потянуть! \n      И лицо его передергивалось от жадности и желания. \n      ...Цезарь приоткрыл веки, полуспущенные над черными глазами, и посмотрел на Фетюкова. Из-за того он и стал курить чаще трубку, чтоб не перебивали его, когда он курит, не просили дотянуть. Не табака ему было жалко, а прерванной мысли. Он курил, чтобы возбудить в себе сильную мысль и дать ей найти что-то. Но едва он поджигал сигарету, как сразу в нескольких глазах видел: \"Оставь докурить!\" \n      ...Цезарь повернулся к Шухову и сказал: \n      — Возьми, Иван Денисыч! \n      И большим пальцем вывернул горящий недокурок из янтарного короткого мундштука. \n      Шухов встрепенулся (он и ждал так, что Цезарь сам ему предложит), одной рукой поспешно благодарно брал недокурок, а второю страховал снизу, чтоб не обронить. Он не обижался, что Цезарь брезговал дать ему докурить в мундштуке (у кого рот чистый, а у кого и гунявый), и пальцы его закалелые не обжигались, держась за самый огонь. Главное, он Фетюкова-шакала пересек и вот теперь тянул дым, пока губы стали гореть от огня. М-м-м-м! Дым разошелся по голодному телу, и в ногах отдалось и в голове. \n      И только эта благость по телу разлилась, как услышал Иван Денисович гул: \n      — Рубахи нижние отбирают!... \n\nЧем отличается значение и ценность окурочка у Солженицына и Алешковского?', 'short-answer', 1, NULL, NULL),
(319, 101, 'Выбор голоса, а с ним и точки зрения, стороны, с которой мы, вместе с автором, смотрим на лагерную жизнь, многое определяет. Повесть \"Один день Ивана Денисовича\" с ее простым героем, Шуховым, несправедливо осужденным по статье 58, можно понять как решительный протест против несправедливости советского строя. \n\nКак вы считаете, герой песни Алешковского выражает протест против существующего строя жизни (в лагере, в Советском Союзе вообще)? \n\nЕсли да, объясните свою позицию. Если нет, то, зная то, что вы знаете о советской песне и советской жизни, скажите, можно ли найти такой протест в этой песне на каком-нибудь другом уровне?', 'short-answer', 2, NULL, NULL),
(320, 101, 'Размах — качество действий героя в этой песне. Это — поступки без оглядки на последствия, поступки, показывающие \"широту\" души. \n\nРазмах — очень важное понятие в русской культуре и оценивается положительно (по крайней мере, когда такие поступки названы именно этим словом). \n\nКак к размаху относятся в вашей родной культуре?', 'short-answer', 3, NULL, NULL);
INSERT INTO `module_question_item` (`id`, `heading_id`, `content`, `type`, `weight`, `choices`, `answers`) VALUES
(321, 102, 'В какой форме существует блатная песня в Америке? Какие ближайщие аналоги вы можете найти? Чем они отличаются от русско-советской лагерной и блатной песни?', 'short-answer', 1, NULL, NULL),
(322, 102, 'Как вы относитесь к употреблению мата в песнях?', 'short-answer', 2, NULL, NULL),
(323, 103, 'Попытайтесь записать слова этой песни целиком. \n\nДаем в помощь первое слово: \"Опустела...\"', 'long-answer', 1, NULL, NULL),
(324, 104, 'Какая ситуация описывается в песне?', 'short-answer', 1, NULL, NULL),
(325, 104, 'Какие эмоции преобладают?', 'short-answer', 2, NULL, NULL),
(326, 104, 'Какие образы в песне эти эмоции передают?', 'short-answer', 3, NULL, NULL),
(327, 105, 'а пароль — \"взлет\".', 'long-answer', 1, NULL, NULL),
(328, 106, 'Не обращая внимания на название урока, присмотритесь к песне. Кто \"ты\" песни?', 'short-answer', 1, NULL, NULL),
(329, 106, 'Почему опустела без него земля?', 'short-answer', 2, NULL, NULL),
(330, 106, 'О каких \"нескольких часах\" может идти речь?', 'short-answer', 3, NULL, NULL),
(331, 106, '\"Несколько часов\" в первой строфе, как, в принципе, и все в этой песне, работает на богатую амбивалентность смысла. \n\nУточните границы возможного контекста песни. Насколько гибко определяется ситуация в ней? Кто поет? Кому? Когда и при каких обстоятельствах?', 'short-answer', 4, NULL, NULL),
(332, 106, 'Авторам пришлось \"отстоять\" упоминание Экзюпери. \"У нас свои летчики!\" — возмущался один критик. \n\nПочему упомянут именно Экзюпери?', 'short-answer', 5, NULL, NULL),
(333, 106, 'Чем отличается вторая строфа от первой? (Посмотрите на грамматику.) Как это изменение перспективы обогащает песню?', 'short-answer', 6, NULL, NULL),
(334, 106, 'Возможно ли, что \"ты\" песни женщина? Как вы считаете и почему?', 'short-answer', 7, NULL, NULL),
(335, 107, 'Какие возможные и реальные голоса сливаются, когда Кристалинская поет песню \"Нежность\"? Сколько слоев можно различить? Чьи голоса присутствуют явно (мы слышим их)? Чьи присутствуют имплицитно?', 'short-answer', 1, NULL, NULL),
(336, 107, 'По меньшей мере, мы слышим \"голоса\": \n\nАлександры Пахмутовой, автора музыки, \nСергея Гребенникова и Николая Добронравова, авторов слов, \nМайи Кристалинской, исполнительницы песни, сделавшей ее советским шлягером (хитом) \n\nТакже возможные голоса, имплицитно звучащие в словах песни: \nжена космонавта \nвся страна, включая слушателей, \nони в тревожном ожидании его возвращения или \nоплакивают его гибель', 'long-answer', 2, NULL, NULL),
(337, 107, 'Ситуация становится еще сложнее, если учесть, что для большинства советских людей эта песня также запомнилась, как часть фильма \"Три тополя на Плющихе\", в очень нестандартном исполнении Татьяны Дорониной (сливающемся с оркестровым фоном, напоминающим популярную запись Кристалинской): ', 'long-answer', 3, NULL, NULL),
(338, 107, 'На этой странице можно найти не только кинозапись Кристалинской, но и мнения людей о ее песне. \n\nКак относятся к песне \"Нежность\" сегодня?', 'short-answer', 4, NULL, NULL),
(339, 108, 'Кем гордится молодежь сегодня? Есть кем? Кто ваш герой и почему?', 'short-answer', 1, NULL, NULL),
(340, 109, '...только для самых смелых! \n\nОстальным записать как можно больше отдельных расслышанных фраз.', 'long-answer', 1, NULL, NULL),
(341, 110, '\"высший пилотаж\"', 'long-answer', 1, NULL, NULL),
(342, 111, 'По выбору. \n\n1) Кто ваш герой? Напишите эссе о нем или о ней. Почему вы уважаете этого человека? Он или она может стать образцом поведения/жизненного пути для всего вашего поколения? \n\n2) Существует ли стёб в американской культуре? Обсудите наиболее близкие примеры и их культурный контекст. \n\n3) Напишите песню-стёб на американские темы (по-русски).', 'short-answer', 1, NULL, NULL),
(343, 112, 'Как вы думаете, почему соперничество в исследовании космоса имело настолько важное значение для жителей США и СССР в поздних 50-х и 60-х годах?', 'short-answer', 1, NULL, NULL),
(344, 112, 'Кто стал победителем космической гонки — США или СССР/Россия? Кто кого опередил или опережает в каких аспектах исследования космоса? (Ответ не прост.)', 'short-answer', 2, NULL, NULL),
(345, 113, '	\nНеобходимые слова и выражения: \n\nкукýшка — птица Сuculus canorus (она говорит \"ку‑ку!\") \nладо́нь — palm \nкула́к — fist \nпо́рох — gunpowder \nсложи́ть гóлову — потерять жизнь (в борьбе, на войне) \nбой — battle \nв бою́ \nво́ля — полная свобода \nплеть — кнут, the lash', 'long-answer', 1, NULL, NULL),
(346, 114, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(347, 114, '1) _ _ _ _ _\n_ кукушка \nПропой\n_ _ _ _ _ на выселках\n_ _\n_ _ _\n_', 'fill-blank', 2, NULL, '[{\"choice\":\"Песен\"},{\"choice\":\"еще\"},{\"choice\":\"не\"},{\"choice\":\"написанных\"},{\"choice\":\"сколько\"},{\"choice\":\"Скажи\"},{\"choice\":\"В\"},{\"choice\":\"городе\"},{\"choice\":\"мне\"},{\"choice\":\"жить\"},{\"choice\":\"или\"},{\"choice\":\"камнем\"},{\"choice\":\"лежать\"},{\"choice\":\"или\"},{\"choice\":\"гореть\"},{\"choice\":\"звездой\"},{\"choice\":\"звездой\"}]'),
(348, 114, '2) _ _ _ _ _\n_ ладонь _ в кулак\n_ _ _ порох _ _\n_ _', 'fill-blank', 3, NULL, '[{\"choice\":\"Солнце:солнце\"},{\"choice\":\"мое\"},{\"choice\":\"взгляни\"},{\"choice\":\"на\"},{\"choice\":\"меня\"},{\"choice\":\"моя:Моя\"},{\"choice\":\"превратилась\"},{\"choice\":\"И:и\"},{\"choice\":\"если\"},{\"choice\":\"есть\"},{\"choice\":\"дай\"},{\"choice\":\"огня\"},{\"choice\":\"Вот:вот\"},{\"choice\":\"так\"}]'),
(349, 114, '3) _ _ _ _ воля _\n_ _ _ _ _ _ _ _\n_\n_ _ _ да _ _ _\n_ _ _ терпеливые под плеть\nПод плеть', 'fill-blank', 4, NULL, '[{\"choice\":\"Где:где\"},{\"choice\":\"же\"},{\"choice\":\"ты\"},{\"choice\":\"теперь\"},{\"choice\":\"вольная\"},{\"choice\":\"С:с\"},{\"choice\":\"кем\"},{\"choice\":\"же\"},{\"choice\":\"ты\"},{\"choice\":\"теперь\"},{\"choice\":\"ласковый\"},{\"choice\":\"рассвет\"},{\"choice\":\"встречаешь\"},{\"choice\":\"ответь:Ответь\"},{\"choice\":\"Хорошо:хорошо\"},{\"choice\":\"с\"},{\"choice\":\"тобой\"},{\"choice\":\"плохо\"},{\"choice\":\"без\"},{\"choice\":\"тебя\"},{\"choice\":\"Голову:голову\"},{\"choice\":\"и\"},{\"choice\":\"плечи\"}]'),
(350, 115, 'Какая сила или умение приписывается кукушке?', 'short-answer', 1, NULL, NULL),
(351, 115, 'Какие жизненные пути открыты герою песни?', 'short-answer', 2, NULL, NULL),
(352, 115, 'Чем стала его рука?', 'short-answer', 3, NULL, NULL),
(353, 115, 'Как вы понимаете слова: \"если есть порох, дай огня\"?', 'short-answer', 4, NULL, NULL),
(354, 115, 'Куда пойдут по следу одинокому?', 'short-answer', 5, NULL, NULL),
(355, 116, 'а пароль — Робертович.', 'long-answer', 1, NULL, NULL),
(356, 117, 'Прослушайте первоначальную версию Виктора Цоя и гр. \"Кино\" \n\n \n\nЧем версии отличаются? Что Земфира оставила? Что добавила? Потерян, конечно, неповторимый голос Цоя. Как Земфира на него намекает или воссоздает его? Как вы думаете, как Земфира относится к Цою?', 'short-answer', 1, NULL, NULL),
(357, 117, 'Опишите героя песни \"Кукушка\". \n\nКакими качествами он обладает?', 'short-answer', 2, NULL, NULL),
(358, 117, 'Если он такой одинокий, к кому обращаются в песне?', 'short-answer', 3, NULL, NULL),
(359, 117, 'Почему такой герой обречен на одиночество?', 'short-answer', 4, NULL, NULL),
(360, 118, 'Какие эмоции преобладают в этой песне? Она актуальна для вас и для вашего поколения? \n\nДжеймс Дин и Виктор Цой — живы?', 'short-answer', 1, NULL, NULL),
(361, 118, 'Некоторые (многие?) в России (и других республиках) посчитали бы выбор записи Земфиры как основы этого урока кощунственным! Как вы относитесь к ремиксам, ремейкам и кавер-версиям иконических песен и фильмов?\n', 'short-answer', 2, NULL, NULL),
(362, 118, 'Рок-музыка имела огромное влияние на молодежь в СССР в эпоху гласности. \n\nГрупп было много и очень разнообразных. Помимо \"Кино\" (и \"Аквариума\", которому мы посвятим урок немного позже), можно назвать следующие группы и исполнителей: \n\nДДТ \nНаутилус Помпилиус \nБраво \nЗоопарк \nГражданская оборона \nБит-квартет \"Секрет\" \nНастя \nЗвуки Му \nЯнка Дягилева \nМашина времени \nСектор Газа \nКалинов мост \nАлександр Башлачев \n\nСамостоятельно изучите в интернете творчество одной из этих групп или одного из исполнителей. (Старайтесь найти их старые песни времен гласности.) \n\nВыберите потом одну песню, чтобы представить ее группе на занятиях. О чем она? Почему она вам понравилась (или не понравилась)? В чем ее выразительность (вообще и/или для эпохи)? Она имеет какую-нибудь свою \"историю\"? Какой у нее культурный контекст? Какие конфликты внутри советского общества она выявляет? Каково отношение авторов/исполнителей к их материалу? Для кого эта песня актуальна, для каких групп людей она особо значима? \n\nЭто — подбор возможных вопросов. Используя их или другие, постарайтесь как можно более полно представить песню в десятиминутном докладе.', 'short-answer', 3, NULL, NULL),
(363, 119, 'Вы любите свою страну? \n\nВсе в ней или только отдельные ее стороны?', 'long-answer', 1, NULL, NULL),
(364, 119, 'Необходимая лексика: \n\nприста́нище — место покоя и отдыха, приют, refuge, haven \nгрех — sin \nколю́чая про́волка \n    коло́ть нсв. (колю́, ко́лешь) — prick, pierce \n    про́волка — wire \nпозо́р — позорное положение, disgrace; стыд, shame \nкоко́шник — богатый головной убор \nузо́р — pattern \nла́поть (мн. ла́пти) — традиционная обувь русского крестянина-мужика \nгрози́ть кому, чему (грожу́, грози́шь) — threaten \nпрости́ть — forgive (по отношению к делам cерьезным) \nпроща́ние — расставание (parting), обычно надолго или навсегда. (Говорили \"Прости, прощай!\") \n    Проща́й(те)! — Farewell! \nВсевы́шний — Бог', 'long-answer', 2, NULL, NULL),
(365, 120, 'Заполните пробелы словами из 2-4 строф песни.', 'long-answer', 1, NULL, NULL),
(366, 120, '_, _ поклажею, навьючена,\n\nПройдя _ _ _ святых _ _ _,\n\n_ _ _,\n\n_ _, _ _ _?', 'fill-blank', 2, NULL, '[{\"choice\":\"Грехами\"},{\"choice\":\"как\"},{\"choice\":\"свой\"},{\"choice\":\"путь\"},{\"choice\":\"от\"},{\"choice\":\"дней\"},{\"choice\":\"до\"},{\"choice\":\"лагерей\"},{\"choice\":\"Изодранная\"},{\"choice\":\"проволкой\"},{\"choice\":\"колючей\"},{\"choice\":\"Душа\"},{\"choice\":\"России\"},{\"choice\":\"бедной\"},{\"choice\":\"Родины:родины\"},{\"choice\":\"моей\"}]'),
(367, 120, '_ _ _, _ проклятьем,\n\n_ _ минувшей, _ _,\n\n_ кокошнике, _ узором,\n\n_ _ _ _ лаптем.', 'fill-blank', 3, NULL, '[{\"choice\":\"Покрытая\"},{\"choice\":\"и\"},{\"choice\":\"страхом\"},{\"choice\":\"и\"},{\"choice\":\"И\"},{\"choice\":\"славою\"},{\"choice\":\"и\"},{\"choice\":\"позором\"},{\"choice\":\"В\"},{\"choice\":\"расписанном\"},{\"choice\":\"Грозила\"},{\"choice\":\"всему\"},{\"choice\":\"миру\"},{\"choice\":\"рваным\"}]'),
(368, 120, '_ _ _ _ _, _ _,\n\n_, _ _, _ _.\n\n_ _, _ _ _ _ _ _,\n\nВсевышний _, _, _.', 'fill-blank', 4, NULL, '[{\"choice\":\"Мы:мы\"},{\"choice\":\"в\"},{\"choice\":\"душу\"},{\"choice\":\"ей\"},{\"choice\":\"плевали\"},{\"choice\":\"как\"},{\"choice\":\"умели\"},{\"choice\":\"Пытались:пытались\"},{\"choice\":\"как\"},{\"choice\":\"могли\"},{\"choice\":\"ее:её\"},{\"choice\":\"спасти\"},{\"choice\":\"И:и\"},{\"choice\":\"то\"},{\"choice\":\"что\"},{\"choice\":\"мы\"},{\"choice\":\"простить\"},{\"choice\":\"ей\"},{\"choice\":\"не\"},{\"choice\":\"посмели\"},{\"choice\":\"ей\"},{\"choice\":\"наверное\"},{\"choice\":\"простит\"}]'),
(369, 121, 'Это СЛОЖНАЯ песня. Не надо огорчаться, если мало в ней понятно при первом знакомстве! Но все-таки сделаем попытку ответить на один вопрос, не заглядывая пока в слова...', 'long-answer', 1, NULL, NULL),
(370, 121, 'Какие чувства вызывает у автора родина?', 'short-answer', 2, NULL, NULL),
(371, 122, 'А пароль... \n\nкуда?!', 'long-answer', 1, NULL, NULL),
(372, 123, 'Какие еще могут быть миры? Какая судьба России в этом мире?', 'short-answer', 1, NULL, NULL),
(373, 123, 'Назовите события в русской истории, которые мешали России найти покой. Назовите как можно больше таких событий.', 'short-answer', 2, NULL, NULL),
(374, 123, 'С кем или с чем сравнивает автор Россию в первых двух куплетах?', 'short-answer', 3, NULL, NULL),
(375, 123, 'В чем двойственность России? Какие противоречия и контрасты автор видит в ней?', 'short-answer', 4, NULL, NULL),
(376, 123, 'В чем двойственность отношения людей к России?', 'short-answer', 5, NULL, NULL),
(377, 123, 'Почему не посмели простить России какие-то из ее грехов?', 'short-answer', 6, NULL, NULL),
(378, 123, 'Какими способами раньше пытались спасти Россию?', 'short-answer', 7, NULL, NULL),
(379, 123, 'В последнем куплете: кто \"поднимется на небо черным облаком\"?', 'short-answer', 8, NULL, NULL),
(380, 123, 'Кто кого проклял? Кто от кого отрекся?', 'short-answer', 9, NULL, NULL),
(381, 123, 'Какие параллели можно найти в песне с историей Христа?', 'short-answer', 10, NULL, NULL),
(382, 123, 'Какой будет судьба России, судя по песне? Какую роль Россия сыграет в истории? \n\nВозможно вам будет легче найти ответ, если вы сравните песню с текстом письма Пушкина к Петру Чаадаеву. (См. его в разделе \"Текст-примечания-контекст\".)', 'short-answer', 11, NULL, NULL),
(383, 124, 'Тема №1 \n\nВы любите свою страну \"странной\" любовью или любовью простой? Почему?\n\nБывало ли вам стыдно за свою страну? Когда и за что?\n\nВы видите исторический смысл (meaning) в судьбе своей страны, своего народа? Если да, то в чем этот исторический смысл состоит?', 'short-answer', 1, NULL, NULL),
(384, 124, 'Тема №2 \n\nПрослушайте песню гр. \"ДДТ\" \"Родина\" (Текст-Примечания-Контекст). Сравните ее с песней Кати Яровой. Обратите внимания и на текст, и на музыку. \n\nЧем похожи и чем отличаются эти песни и отношение их авторов (Кати Яровой и Юрия Шевчука) к родине?', 'short-answer', 2, NULL, NULL),
(385, 124, 'Тема №3 \n\nПрочитайте и прослушайте дополнительные материалы на странице \"Текст/примечания/контекст\". \n\nЧто Катя Яровая заимствует в своей песне из традиции \"странной любви\" к родине?\n\nВ чем особая выразительность ее песни?', 'short-answer', 3, NULL, NULL),
(386, 125, 'Песня написана в 1993 году. \nЧто вы знаете о положении коммунистов в начале 90‑х годов?', 'long-answer', 1, NULL, NULL),
(387, 125, '«Московская октябрьская» — \nСтруктура названия песни, как «Моя цыганская». \n\nЧто значит «октябрь» в русско-советской культуре?', 'long-answer', 2, NULL, NULL),
(388, 125, 'Что вы знаете об изменениях в российском обществе в это время? В области морали/нравов? \n\n(Если нужно, пересмотрите информацию о перестройке во введении к уроку \"Гласность и отчуждение\" и о ельцинской России во введении к песне \"Давай за...\".)', 'long-answer', 3, NULL, NULL),
(389, 125, '	\nНеобходимая лексика: \n\nплеши́вый — balding \nсплоти́ться — band together, close ranks \nуте́чь (imp. утекать) — leak out, drain away \nчугу́н — cast iron \nкора́бль — ship \nохра́на — guard \nполово́й — waiter (19-й век) \nбухо́й — пьяный (сленг) \nотря́д — группа солдат \nразве́дка — reconnaissance \nперемёрла → перемереть, ср. умереть \nмох — moss \nштык — bayonet \nснова́ть — быстро двигаться, мелкать туда-сюда \nбессты́дство → стыд — shame \nпаникади́ло — большой многосвечный канделябр (в церкви) \nсклева́ть (imp. клевать) cклюю, cклюёшь — peck', 'long-answer', 4, NULL, NULL),
(390, 126, '_, _, плешивые _;\n\n_ полка и _ саркофага —\n\nСплотимся _ _ _ _,\n\n_ _ _ утекшая _.', 'fill-blank', 1, NULL, '[{\"choice\":\"Вперед:вперед:Вперёд:вперёд\"},{\"choice\":\"вперед:вперёд\"},{\"choice\":\"стада\"},{\"choice\":\"Дети:дети\"},{\"choice\":\"внуки\"},{\"choice\":\"гордо\"},{\"choice\":\"вкруг\"},{\"choice\":\"родного\"},{\"choice\":\"флага\"},{\"choice\":\"И:и\"},{\"choice\":\"пусть\"},{\"choice\":\"кипит\"},{\"choice\":\"вода\"}]'),
(391, 126, 'Застыл чугун над буйной _,\n\n_ в бурьян _ _ _...\n\n_, _ _ _ _ — _, _, охрана;\n\n_ _ _ _ _ влезет половой.', 'fill-blank', 2, NULL, '[{\"choice\":\"головой\"},{\"choice\":\"Упал:упал\"},{\"choice\":\"корабль\"},{\"choice\":\"без\"},{\"choice\":\"капитана\"},{\"choice\":\"Ну:ну\"},{\"choice\":\"что\"},{\"choice\":\"ж\"},{\"choice\":\"ты\"},{\"choice\":\"спишь\"},{\"choice\":\"проснись\"},{\"choice\":\"проснись\"},{\"choice\":\"А:а\"},{\"choice\":\"то\"},{\"choice\":\"мне\"},{\"choice\":\"в\"},{\"choice\":\"душу\"}]'),
(392, 126, '_ _ _ _ бухой отряд\n\nИ, как на грех, разведка перемерла;\n\nПокрылись мхом штыки, болты и сверла —\n\n_ _ _ _ _ _.', 'fill-blank', 3, NULL, '[{\"choice\":\"Сошел:сошел:сошёл:Сошёл\"},{\"choice\":\"на\"},{\"choice\":\"нет\"},{\"choice\":\"всегда\"},{\"choice\":\"А:а\"},{\"choice\":\"в\"},{\"choice\":\"небе\"},{\"choice\":\"бабы\"},{\"choice\":\"голые\"},{\"choice\":\"летят\"}]'),
(393, 126, '_ _ _ блестит _ _;\n\nОни снуют с бесстыдством _...\n\n_, _, _ паникадило,\n\n_ _ _ склюют _ _.', 'fill-blank', 4, NULL, '[{\"choice\":\"На:на\"},{\"choice\":\"их\"},{\"choice\":\"грудях\"},{\"choice\":\"французский\"},{\"choice\":\"крем\"},{\"choice\":\"крокодила\"},{\"choice\":\"Гори:гори\"},{\"choice\":\"гори\"},{\"choice\":\"мое:моё\"},{\"choice\":\"А:а\"},{\"choice\":\"то\"},{\"choice\":\"они\"},{\"choice\":\"меня\"},{\"choice\":\"совсем\"}]'),
(394, 127, 'Когда и где разворачивается действие песни?', 'short-answer', 1, NULL, NULL),
(395, 127, 'Какие в ней главные образы?', 'short-answer', 2, NULL, NULL),
(396, 127, 'Они реалистичны?', 'short-answer', 3, NULL, NULL),
(397, 127, 'Они указывают на реальные проблемы? \n\nЕсли да, на какие?', 'short-answer', 4, NULL, NULL),
(398, 127, 'Как вы думаете, о чем эта песня?', 'short-answer', 5, NULL, NULL),
(399, 128, 'а пароль — \"Ильич\".', 'long-answer', 1, NULL, NULL),
(400, 129, 'Что это за плешивые стада? Почему они \"плешивые\"?', 'short-answer', 1, NULL, NULL),
(401, 129, 'Они внуки какого саркофага? Кто там лежит?', 'short-answer', 2, NULL, NULL),
(402, 129, 'Как выглядит их «родной» флаг? Какого он цвета? Что на нем изображено?', 'short-answer', 3, NULL, NULL),
(403, 129, 'Что означает то, что над буйными головами застыл чугун? Что корабль упал? Что мох покрыл штыки и болты?', 'short-answer', 4, NULL, NULL),
(404, 129, 'Почему болты и сверла так важны на этой войне?', 'short-answer', 5, NULL, NULL),
(405, 129, 'В каком состоянии находится армия в песне?', 'short-answer', 6, NULL, NULL),
(406, 129, 'Почему это плохо?', 'short-answer', 7, NULL, NULL),
(407, 129, 'От чего они должны защищаться? \n       Обратите внимание на выражение «а то» — «or else» и на будущее время в песне. Боятся того, что может случиться.', 'short-answer', 8, NULL, NULL),
(408, 129, 'Почему эти явления так страшны?', 'short-answer', 9, NULL, NULL),
(409, 129, 'В чем заключается ирония призыва к «паникадилу» в последней строфе?', 'short-answer', 10, NULL, NULL),
(410, 129, 'От чьего имени поет БГ в этой песне?', 'short-answer', 11, NULL, NULL),
(411, 129, 'Какими изображены здесь коммунисты?', 'short-answer', 12, NULL, NULL),
(412, 129, 'Как вы думаете, как к ним относится БГ?', 'short-answer', 13, NULL, NULL),
(413, 130, 'Ваше понимание песни изменилось? Обогатилось?', 'long-answer', 2, NULL, NULL),
(414, 130, 'Но имейте в виду, что песня написана не позже 1992 года, а события, отраженные в клипе произошли в октябре 1993-го. \n\nВ представленном ниже интервью БГ говорит немного о своей песне и о том, как она прозвучала после этих событий: ', 'long-answer', 3, NULL, NULL),
(415, 131, 'В клипе, который вы посмотрели, БГ вызывающе говорит, что большая часть крови и жертв в российской истории была вызвана тем, что в политику идут люди озлобленные, сексуально неудовлетворенные. \n\n\"Где вот нормальных бы людей взять, чтобы он... чтобы он управлял нами, но он был нормальный, чтобы он не был такой... весь вот... такой — видно, что у него злость на все человечество, что ему не досталось, или ей не досталось...\" \n\nКак вы считаете, возможно быть \"нормальным человеком\" в политике? Почему?', 'short-answer', 1, NULL, NULL),
(416, 131, 'Песня \"Московская октябрьская\" написана во время жесткой и болезненной социальной трансформации в России. Скромные сбережения советских семей обесценились в одночасье, инфляция была чудовищной, советские заводы стояли. Эйфория долгожданной свободы прошла, и на смену ей пришла забота о будущем в условиях беззакония и полной непредсказуемости завтрашнего дня. \n\nМожет вы испытали, слышали от родственников или читали о подобных потрясениях? С чем можно это время сравнить? \n\nКак вы считаете, насколько такие перемены вызваны действиями отдельных политических деятелей? \n\nЧто происходит с людьми в такое время?', 'short-answer', 2, NULL, NULL),
(417, 131, 'Как вы считаете, какую роль должен социализм (коммунизм?) играть в политическом дискурсе нашего времени в США и/или России? \n\nКакую роль он играет сейчас в США?', 'short-answer', 3, NULL, NULL),
(418, 132, 'Какой лидер нужен вашей стране? \n\nКакой лидер нужен России? \n\nПочему?', 'long-answer', 1, NULL, NULL),
(419, 132, 'Необходимые слова и выражения: \n\nолига́рх — представитель крупного капитала \nкорми́ть — feed \n    ко́рмленный \nче́стный — honest \n    честь — honor \nвор — thief \nмент — (сленг) милиционер \nграждани́н (мн. гра́ждане) — сitizen \nобогна́ть — pass, surpass \ncла́вный — glorious, renowned \n    сла́ва — glory \nтира́н — единоличный, жестокий правитель \nпра́вить — (кем-чем) руководить, управлять. Править государством, страной. Кто будет нами править? \n    прави́тель \nвласть — power \nпо́ртить — spoil \nчучме́к — пренебрежительное (обидное) название представителей народных меньшинств Средней Азии и Кавказа', 'long-answer', 2, NULL, NULL),
(420, 133, 'Если \"выберут\" исполнителя, кем он будет сначала? \n\nКем потом?', 'short-answer', 1, NULL, NULL),
(421, 133, 'Назовите 3 элемента его программы.', 'short-answer', 2, NULL, NULL),
(422, 133, 'В действительности будет ли он править страной? (Ответ в последнем куплете.)', 'short-answer', 3, NULL, NULL),
(423, 134, 'Поздравляем! Вы дошли до пароля...', 'long-answer', 1, NULL, NULL),
(424, 135, 'Чем, по сути, является название песни?', 'short-answer', 1, NULL, NULL),
(425, 135, 'Почему нужно выбрать \"Шаова\" главным?', 'short-answer', 2, NULL, NULL),
(426, 135, 'Чего он потребует у олигархов?', 'short-answer', 3, NULL, NULL),
(427, 135, 'Как лидер, какими качествами он будет отличаться? За что его полюбят?', 'short-answer', 4, NULL, NULL),
(428, 135, 'Как он наведет порядок?', 'short-answer', 5, NULL, NULL),
(429, 135, 'Кого ему будет жалко?', 'short-answer', 6, NULL, NULL),
(430, 135, 'Назовите еще 4 элемента его первоначальной программы.', 'short-answer', 7, NULL, NULL),
(431, 135, 'Каким будет общественный строй в первые годы его правления?', 'short-answer', 8, NULL, NULL),
(432, 135, 'Какой будет страна впоследствии?', 'short-answer', 9, NULL, NULL),
(433, 135, 'Почему произойдет такая перемена?', 'short-answer', 10, NULL, NULL),
(434, 135, 'Каких смутьянов он посадит? Как вы думаете, кто они на самом деле?', 'short-answer', 11, NULL, NULL),
(435, 135, 'На кого он будет похожим во второй половине его правления? Какими штрихами Шаов это подчеркивает?', 'short-answer', 12, NULL, NULL),
(436, 135, 'Почему он все-таки не станет главным?', 'short-answer', 13, NULL, NULL),
(437, 136, 'Как вы думаете, какие главные проблемы у вас в стране сейчас? Если бы вас избрали \"главным\", как бы вы их решили?', 'short-answer', 1, NULL, NULL),
(438, 136, 'У Шаова в другой песне звучат строки: \"Уже настала тирания, или пока еще нет?! А если нет, тогда я выпью еще!\" \n\nВозможна \"тирания\" в демократиях — США и Европе? Если да, то в каких формах? И как можно ее предотвратить?', 'short-answer', 2, NULL, NULL),
(439, 136, 'Как вы думаете, такая же острая сатира как \"Куклы\" может появиться на американском телевидении (на каналах ABC, NBC, CBS, Fox, особенно в \"прайм-тайм\")? \n\nЕсли нет, то означает ли это, что и у нас в США есть политическая цензура? \n\nЕсли да, то какие это передачи и что они критикуют?', 'short-answer', 3, NULL, NULL),
(440, 137, 'Ездили ли вы в России поездом? \n\nСамые дешевые гарантированные спальные места — в плацкартном вагоне (\"плацкартные места\"; \"ехать плацкартой\"). Вагон открыт (не делится на закрывающиеся купе). А самые дешевые (и по возможности избегаемые) места в плацкартном вагоне — верхние боковые (справа от коридора сверху). \n\nЗдесь можно посмотреть схему плацкартного вагона (чётные места верхние). А здесь посмотрите фотографию.', 'long-answer', 1, NULL, NULL),
(441, 137, 'Что такое \"челнок\"? \n\nЧёлн — первоначально выдолбленная лодочка однодеревка, нечто вроде каноэ, вообще маленькая лодочка. Она также называется челноком. \n\nНо челнок, и это важнее для нас, часть ткацкого станка. Она так называется, потому что похожа на такую лодочку. Челноком прокладывают поперечную нитку из стороны в сторону, туда-сюда между нитями основы. Получается ткань. \"Летучий челнок,\" который изобрел англичанин Джон Кей в 1733 г., так и летает из стороны в сторону. \n\nВ ранних 1990-х годах челноком стали называть человека, занимающегося мелкой торговлей. Как челнок, он вечно мотался туда-сюда, за границу и обратно, покупая и продавая товары, которых не хватало дома, в России. Но если в ранних 90-х челноки работали на самих себя и хорошо зарабатывали, продавая дефицитный товар, в 2000-х годах, они чаще работали на других и возили товар чужой за мизерную зарплату. Также они стали больше возить товар не из-за границы, а из Москвы в малообеспеченные города российской \"глубинки\".', 'long-answer', 2, NULL, NULL),
(442, 137, 'Необходимые слова и выражения: \n\n(черный) вороно́к — машина НКВД (предшественника КГБ) \nве́рхняя бокова́я (полка) — спальнее место в плацкартном вагоне справа от прохода наверху \nнаяву́ — in reality \nта́мбур — маленькое помещение в конце вагона, из которого можно пройти в следующий вагон. \nбашка́ (cленг) — голова \nсни́ться кому — видеться, являться во сне', 'long-answer', 3, NULL, NULL),
(443, 138, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(444, 138, '_ _, _, _?\n..._ _ как наяву:\n_ _ _\n_ — _ _ _, _ _.\nОчнулся _, _ _.\n_ _ _ _.\n_ _ _ _ _\n_ _ _.', 'fill-blank', 2, NULL, '[{\"choice\":\"Где:где\"},{\"choice\":\"ты\"},{\"choice\":\"душа\"},{\"choice\":\"осталась\"},{\"choice\":\"А:а\"},{\"choice\":\"было\"},{\"choice\":\"принесли\"},{\"choice\":\"на\"},{\"choice\":\"станцию\"},{\"choice\":\"человека:Человека\"},{\"choice\":\"и\"},{\"choice\":\"в\"},{\"choice\":\"поезд\"},{\"choice\":\"в\"},{\"choice\":\"Москву\"},{\"choice\":\"ночью\"},{\"choice\":\"в\"},{\"choice\":\"дороге\"},{\"choice\":\"Поезд:поезд\"},{\"choice\":\"уже\"},{\"choice\":\"под\"},{\"choice\":\"Москвой\"},{\"choice\":\"И:и\"},{\"choice\":\"едут\"},{\"choice\":\"вперед\"},{\"choice\":\"его\"},{\"choice\":\"ноги\"},{\"choice\":\"на\"},{\"choice\":\"верхней\"},{\"choice\":\"боковой\"}]'),
(445, 138, '_ _, челнок? Недоумок,\n_ _ жил до ушей.\n_ _ _ клетчатых _,\n_ _ _ _,\n_ _ в Нижнем Тагиле\n_ _ _.\n_ _ _, _ _ _,\n_ _ _...', 'fill-blank', 3, NULL, '[{\"choice\":\"Кто:кто\"},{\"choice\":\"он\"},{\"choice\":\"с:С\"},{\"choice\":\"улыбочкой\"},{\"choice\":\"И:и\"},{\"choice\":\"вот\"},{\"choice\":\"десять\"},{\"choice\":\"сумок\"},{\"choice\":\"привязанных:Привязанных\"},{\"choice\":\"насмерть\"},{\"choice\":\"к\"},{\"choice\":\"душе\"},{\"choice\":\"им:Им\"},{\"choice\":\"брошены\"},{\"choice\":\"неведомо:Неведомо\"},{\"choice\":\"на\"},{\"choice\":\"кого\"},{\"choice\":\"А:а\"},{\"choice\":\"он\"},{\"choice\":\"лежит\"},{\"choice\":\"как\"},{\"choice\":\"в\"},{\"choice\":\"могиле\"},{\"choice\":\"на:На\"},{\"choice\":\"верхней\"},{\"choice\":\"боковой\"}]'),
(446, 139, 'Действие в песне простое. Человек едет поездом. Но детали, образы, метафоры мощно передают настроение. Можно сказать, что слушая эту песню, мы должны сочувствовать герою. \n\nКак этот герой себя чувствует?', 'short-answer', 1, NULL, NULL),
(447, 140, 'а пароль — \"плацкарта\".', 'long-answer', 1, NULL, NULL),
(448, 141, 'Где тело находится? (Ответьте как можно подробнее.)', 'short-answer', 1, NULL, NULL),
(450, 141, 'Где душа? Почему или в каком смысле душа отделилась от тела?', 'short-answer', 2, NULL, NULL),
(451, 141, 'Как оказался герой песни в поезде?', 'short-answer', 3, NULL, NULL),
(452, 141, 'В какое время суток он ощутил себя там? Как вы думаете, почему только тогда?', 'short-answer', 4, NULL, NULL),
(453, 141, 'В чём заключается злая шутка над ним? Почему сказано, что он \"едет, куда не зная\"?', 'short-answer', 5, NULL, NULL),
(454, 141, 'В четвертой строфе тонко проведена метафора войны / военного обоза. Какие у нее составляющие?', 'short-answer', 6, NULL, NULL),
(455, 141, 'Почему верхняя боковая полка — \"прокрустово ложе\" для героя?', 'short-answer', 7, NULL, NULL),
(456, 141, 'Что, как якорь, держит его душу? К чему она привязывается? Почему?', 'short-answer', 8, NULL, NULL),
(457, 141, 'Почему герой вспоминает маму в седьмой строфе? \n\nО каком отце здесь может идти речь?', 'short-answer', 9, NULL, NULL),
(458, 141, 'Почему важно, что под потолком \"ни сердца\" его \"узнать, ни лица\"?', 'short-answer', 10, NULL, NULL),
(459, 141, 'Что для героя первый признак нового утра?', 'short-answer', 11, NULL, NULL),
(460, 141, 'Почему упомянуто небо Аустерлица? С кем и в какой ситуации сравнивают героя?', 'short-answer', 12, NULL, NULL),
(461, 141, 'Как вы cчитаете, почему виноват Пушкин? Почему всех спасает Толстой?', 'short-answer', 13, NULL, NULL),
(462, 141, 'Что снится герою?', 'short-answer', 14, NULL, NULL),
(463, 141, 'Чем является для него верхняя боковая?', 'short-answer', 15, NULL, NULL),
(464, 141, 'Кто герой? Что мы можем о нeм сказать?', 'short-answer', 16, NULL, NULL),
(465, 141, 'Это бардовская песня. Как вы думаете, почему в ней звучит губная гармонь?', 'short-answer', 17, NULL, NULL),
(466, 142, 'Выберите тему со страницы \"Темы для обсуждения\", чтобы написать сочинение.', 'short-answer', 1, NULL, NULL),
(467, 142, 'Или: посмотрите темы для итогового сочинения (в последнем разделе курса). \n\nНачните ваше итоговое сочинение или напишите его и сдайте преподавателю для получения предварительных комментариев.', 'short-answer', 2, NULL, NULL),
(468, 143, 'Читали ли вы такие произведения русской литературы, как \"Медный всадник\" Пушкина, \"Шинель\" Гоголя и \"Бедные люди\" Достоевского? \n\nЕсли да, то чем похожи Евгений, Акакий Акакиевич, Макар Девушкин и герой песни?', 'short-answer', 1, NULL, NULL),
(469, 143, 'Каких еще \"маленьких людей\" можно назвать в русской литературе? В европейской / англо-американской? Чем они вызывают или не вызывают вашу симпатию?', 'short-answer', 2, NULL, NULL),
(470, 143, 'И в Америке в последние годы были значительные события и перемены, которые затрагивали многих, а некоторых очень сильно. Вы знакомы с каким-нибудь американским \"маленьким человеком\"? Вы можете рассказать его историю?', 'short-answer', 3, NULL, NULL),
(471, 144, 'В 50-х-60-х годах популярным способом самовыражения и негласного протеста против общественного строя стало увлечение всем американским — музыкой, стилем одежды, прическами, танцами, английскими словечками и именами; естественно все это было запретным. Людей, увлекавшихся этим, неодобрительно называли стилягами. Степень их знакомства с этими явлениями «американской» жизни могла сильно зависеть от их социального статуса (дети правящей элиты vs. дети рабочих) и места жительства (чем ближе к Москве и Ленинграду, тем больше было и настоящих вещей, и подлинныхзнаний). Быть стилягой, ходить с идеолигески неправильной прической (кок), слушать джаз (позже рок) — все это могло привести к остракизму: исключению из университета или комсомола — со всеми вытекающими отсюда последствиями.', 'long-answer', 1, NULL, NULL),
(472, 144, 'Слушать западную музыку запрещалось. Тот, кто не имел возможности ездить за границу, мог пытаться ловить западные радиостанции коротковолновым радиоприемником или покупать контрабандные пластинки. Их нарезали на старых рентгеновcких cнимках. Поэтому, это яление получило название музыки \"на ребрах\" или \"на костях\". Здесь можно посмотреть и прослушать эти самодельные, контрабандные пластинки 50-х годов, прочитать об их истории. Автор блога между прочим подчеркивает графическую сторону оформления этих пластинок (например, юмор, с которым записывали песню \"Heartbreak Hotel\" — \"На рентгене с хирургической точностью показана как раз область сердца. Разбитого.\").', 'long-answer', 2, NULL, NULL),
(473, 144, 'Необходимые слова и выражения: \n\nК разговору отца с сыном из к/ф \"Стиляги\" \n\nпереболе́ть — заболев, выздороветь \nпроща́ние — farewell \nза́пись! — приказ начать записывание \nдубль — повторная съёмка эпизода в фильме \nвтя́гивать/втяну́ть — suck/pull in \nакаде́мик — профессор, член Академии Наук СССР (самое высокое звание учёных) \nдои́ть — milk (v.). Доить корову. \n\nК песне \n\nпроща́й! — farewell! \nпокида́ть — бросать, уходить (от места, человека) \nстиля́га м. и ж. (разг.) — В СССР в 50-е гг.: о молодом человеке, подражающем западной моде [Грамота] \nкок — излюбленная прическа стиляг, взбитая прядь волос надо лбом. \nвзаме́н — вместо чего-нибудь, в обмен \n\nИз жаргона стиляг \n\nчува́к — молодой человек из круга стиляг \nчуви́ха — девушка из круга стиляг \nшузы́ — обувь \nха́та — квартира \nхиля́ть — ходить \nлаба́ть и ла́́бать — играть (на музыкальном инструменте) \nла́бух — музыкант \nжлоб — представитель \"серой массы\", обыватель \nСо́впарши́в → СовПошив — советская одежда (паршивый — плохой, дрянной, скверный) \n\nЕще о речи этой субкультуры можно узнать здесь.', 'long-answer', 3, NULL, NULL),
(474, 145, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(475, 145, 'Ему _ _ _ _', 'fill-blank', 2, NULL, '[{\"choice\":\"не\"},{\"choice\":\"нужна\"},{\"choice\":\"американская\"},{\"choice\":\"жена\"}]'),
(476, 145, '_ будешь _, _ _\n_ _ _ _ _ _ _,\n_ мы-то _ _ _, _,\n_ _ _ _, _ _, _ _', 'fill-blank', 3, NULL, '[{\"choice\":\"Ты:ты\"},{\"choice\":\"советский\"},{\"choice\":\"простой\"},{\"choice\":\"дипломат\"},{\"choice\":\"Как:как\"},{\"choice\":\"будто\"},{\"choice\":\"о\"},{\"choice\":\"прошлом\"},{\"choice\":\"ты\"},{\"choice\":\"всё:все\"},{\"choice\":\"позабыл\"},{\"choice\":\"Но:но\"},{\"choice\":\"по-прежнему\"},{\"choice\":\"ждём:ждем\"},{\"choice\":\"тебя\"},{\"choice\":\"брат\"},{\"choice\":\"В:в\"},{\"choice\":\"душе\"},{\"choice\":\"ты\"},{\"choice\":\"стиляга\"},{\"choice\":\"такой\"},{\"choice\":\"же\"},{\"choice\":\"как\"},{\"choice\":\"был\"}]'),
(477, 145, '_ _ _ взамен _\n_ _ чувихи, _ _ _,\n_ _ _ _ _ _ _,\n_ _ _ _ _ _.', 'fill-blank', 4, NULL, '[{\"choice\":\"Ты:ты\"},{\"choice\":\"многое\"},{\"choice\":\"сможешь\"},{\"choice\":\"получить\"},{\"choice\":\"От:от\"},{\"choice\":\"щедрой\"},{\"choice\":\"что\"},{\"choice\":\"жизнью\"},{\"choice\":\"зовется\"},{\"choice\":\"Но:но\"},{\"choice\":\"только\"},{\"choice\":\"свободным\"},{\"choice\":\"тебе\"},{\"choice\":\"уж\"},{\"choice\":\"не\"},{\"choice\":\"быть\"},{\"choice\":\"И:и\"},{\"choice\":\"стильная\"},{\"choice\":\"молодость\"},{\"choice\":\"вряд\"},{\"choice\":\"ли\"},{\"choice\":\"вернется:вернётся\"}]'),
(478, 146, 'Кем был адресат песни и кем станет?', 'short-answer', 1, NULL, NULL),
(479, 146, 'Что ему придется сделать, чтобы принять эту новую роль в жизни?', 'short-answer', 2, NULL, NULL),
(480, 146, 'Почему он решается на этот шаг?', 'short-answer', 3, NULL, NULL),
(481, 147, 'а пароль — \"шузы\".', 'long-answer', 1, NULL, NULL),
(482, 148, 'Какая ситуация в песне? Кто поет кому и по какому поводу?', 'short-answer', 1, NULL, NULL),
(483, 148, 'Поют: \"Мне жаль, что уходишь ты именно так...\" \n\nКак уходит герой?', 'short-answer', 2, NULL, NULL),
(484, 148, 'Как придется ему одеваться теперь?', 'short-answer', 3, NULL, NULL),
(485, 148, 'Вслед за кем он уходит? Почему здесь звучит уменьшительное?', 'short-answer', 4, NULL, NULL),
(486, 148, 'Что здесь значит \"большая дорога\"?', 'short-answer', 5, NULL, NULL),
(487, 148, 'Что поющая хочет сказать словами \"мы другие, другие немного\"?', 'short-answer', 6, NULL, NULL),
(488, 148, 'Она понимает и прощает ему его уход? Почему вы так считаете?', 'short-answer', 7, NULL, NULL),
(489, 148, 'Что не нужно герою? Что значит здесь \"американская жена\"?', 'short-answer', 8, NULL, NULL),
(490, 148, 'Какая будет судьба героя?', 'short-answer', 9, NULL, NULL),
(491, 148, 'Как вы считаете: он сделал правильный выбор?', 'short-answer', 10, NULL, NULL),
(492, 149, 'Что для вас важнее — карьера или тусовка? Возможно иметь и то, и другое? Исключают ли друг друга некоторые тусовки и карьеры? Или всегда можно их соединить? \n\nПредставьте, что вы можете получить высокооплачиваемую или очень престижную работу, но нагрузка будет очень большая. Вы будете видеться с друзьями только изредка. Как вы поступите и почему?', 'short-answer', 1, NULL, NULL),
(493, 149, 'Нонконформизм может стать основой поведения молодежи и в странах с менее жесткими кодами поведения. Играет ли он роль в вашей жизни и в жизни ваших друзей? Если да, то какую? Если нет, то можете ли вы назвать конкретные примеры субкультур в других странах (не в СССР), которые практикуют нонконформизм, подобный нонконформизму стиляг? \n\nОстается ли нонконформизм нонконформизмом, если, благодаря ему, образуется группа людей, одинаковым способом отвергающих норму?', 'short-answer', 2, NULL, NULL),
(494, 149, 'На выбор. \n\n1) Посмотрите фильм \"Стиляги\". С кем из героев фильма вы себя идентифицируете или не идентифицируете и до какой степени? Будь вы в их положении, вы бы вели себя также, или по-другому? Почему? \n\n2) Прослушайте песню гр. \"Колибри\" \"Ему не нужна американская жена\". Ее музыка послужила основой для песни из фильма, но слова совсем другие. О чем она? (Запись найдете здесь; текст песни — здесь.)', 'short-answer', 3, NULL, NULL),
(495, 149, '	Роза Люксембург (социалистка) сказала — \"свобода — это всегда свобода других\" (бук. инакомыслящих, тех, которые думают иначе). \n\nCогласны ли вы с ней? \n\n\nФедор Достоеский (критикуя социалистов) от лица \"Человека из подполья\" написал: \n\n\"...человек, всегда и везде, кто бы он ни был, любил действовать так, как хотел, а вовсе не так, как повелевали ему разум и выгода; хотеть же можно и против собственной выгоды, а иногда и положительно должно (это уж моя идея). Свое собственное, вольное и свободное хотенье, свой собственный, хотя бы самый дикий каприз, своя фантазия, раздраженная иногда хоть бы даже до сумасшествия,— вот это-то все и есть та самая, пропущенная, самая выгодная выгода, которая ни под какую классификацию не подходит и от которой все системы и теории постоянно разлетаются к черту. И с чего это взяли все эти мудрецы, что человеку надо какого-то нормального, какого-то добродетельного хотения? С чего это непременно вообразили они, что человеку надо непременно благоразумно выгодного хотенья? Человеку надо — одного только самостоятельного хотенья, чего бы эта самостоятельность ни стоила и к чему бы ни привела. Ну и хотенье ведь черт знает...\" \n\nCогласны ли вы с ним?', 'short-answer', 4, NULL, NULL),
(496, 150, '	\nНеобходимые слова: \n\nостава́ться/оста́ться — remain \nтрюм — hold \nкача́ть — rock \n      укача́ть кого — make ill from rocking motion. Меня укачало. \nмча́ться — rush \nнево́ля → cр. воля (свобода) \nпуть — path \nпоги́бнуть — perish (поги́бну, поги́бнешь, поги́б, поги́бла) \nчужо́й — не свой, не родно́й \nко́рни — roots → ко́рень', 'long-answer', 1, NULL, NULL),
(497, 151, 'Заполните пробелы.', 'long-answer', 1, NULL, NULL),
(498, 151, '_ _ _ _ _ в трюме _,\n_ _ _ твердишь, _ _ _,\n_ _ _ _, _ _ _,\n_ не качает, _ _ _ _ _.', 'fill-blank', 2, NULL, '[{\"choice\":\"А:а \"},{\"choice\":\"мы\"},{\"choice\":\"опять\"},{\"choice\":\"стоим\"},{\"choice\":\"и\"},{\"choice\":\"вода\"},{\"choice\":\"И:и\"},{\"choice\":\"ты\"},{\"choice\":\"опять\"},{\"choice\":\"что\"},{\"choice\":\"надо\"},{\"choice\":\"бежать\"},{\"choice\":\"И:и\"},{\"choice\":\"ты\"},{\"choice\":\"опять\"},{\"choice\":\"твердишь\"},{\"choice\":\"что\"},{\"choice\":\"надо\"},{\"choice\":\"туда\"},{\"choice\":\"Где:где\"},{\"choice\":\"сухо\"},{\"choice\":\"и\"},{\"choice\":\"есть\"},{\"choice\":\"чем\"},{\"choice\":\"дышать\"}]'),
(499, 151, 'Но я, я _.\n_, _ _ _ _.\n_ _ _ немного _,\n_ _, _ _.', 'fill-blank', 3, NULL, '[{\"choice\":\"остаюсь\"},{\"choice\":\"Там:там\"},{\"choice\":\"где\"},{\"choice\":\"мне\"},{\"choice\":\"хочется\"},{\"choice\":\"быть\"},{\"choice\":\"И:и\"},{\"choice\":\"пусть\"},{\"choice\":\"я\"},{\"choice\":\"боюсь\"},{\"choice\":\"Но:но\"},{\"choice\":\"я\"},{\"choice\":\"я\"},{\"choice\":\"остаюсь\"}]'),
(500, 151, '_ _, _ _ _ зла,\n_ _ _ _ _ _,\nТы говоришь, _ _ неволя _,\n_ свято _ _ _ _ _.', 'fill-blank', 4, NULL, '[{\"choice\":\"Ты:ты\"},{\"choice\":\"говоришь\"},{\"choice\":\"что\"},{\"choice\":\"здесь\"},{\"choice\":\"достаточно\"},{\"choice\":\"И:и\"},{\"choice\":\"ты\"},{\"choice\":\"спешишь\"},{\"choice\":\"скорей\"},{\"choice\":\"отсюда\"},{\"choice\":\"уйти\"},{\"choice\":\"что\"},{\"choice\":\"мне\"},{\"choice\":\"мила\"},{\"choice\":\"И:и\"},{\"choice\":\"веришь\"},{\"choice\":\"в\"},{\"choice\":\"правду\"},{\"choice\":\"другого\"},{\"choice\":\"пути\"}]'),
(501, 151, '_ _ _, я здесь не так _,\n_ _, _ _ _ _ _.\n_ _ звенеть _ _,\n_ _ _, _ _ _.', 'fill-blank', 5, NULL, '[{\"choice\":\"Я:я\"},{\"choice\":\"здесь\"},{\"choice\":\"привык\"},{\"choice\":\"одинок\"},{\"choice\":\"Хоть:хоть\"},{\"choice\":\"иногда\"},{\"choice\":\"но\"},{\"choice\":\"здесь\"},{\"choice\":\"я\"},{\"choice\":\"вижу\"},{\"choice\":\"своих\"},{\"choice\":\"Когда:когда\"},{\"choice\":\"начнет:начнёт\"},{\"choice\":\"последний\"},{\"choice\":\"звонок\"},{\"choice\":\"Я:я\"},{\"choice\":\"буду\"},{\"choice\":\"здесь\"},{\"choice\":\"если\"},{\"choice\":\"буду\"},{\"choice\":\"живым\"}]'),
(502, 152, 'Почему поющий должен покинуть Россию?', 'short-answer', 1, NULL, NULL),
(503, 152, 'Почему он не собирается ее покинуть?', 'short-answer', 2, NULL, NULL),
(504, 153, 'а пароль — \"бугор\".', 'long-answer', 1, NULL, NULL),
(505, 154, 'На какой метафоре строится первый куплет? Где, следуя этой метафоре, находятся герои?', 'short-answer', 1, NULL, NULL),
(506, 154, 'Какие качества отличают то место, из которого надо бежать? (Внимательно изучайте каждый куплет.)', 'short-answer', 2, NULL, NULL),
(507, 154, 'Какие качества отличают то место, куда надо бежать?', 'short-answer', 3, NULL, NULL),
(508, 154, 'Какими могут быть чужие? \n\nКак вы думаете, поющий согласен со своим другом в оценке этих чужих? Почему вы так считаете?', 'short-answer', 4, NULL, NULL),
(509, 155, 'Вы оказались в очень сложной жизненной ситуации. Вы склонны остаться на месте и бороться со сложившейся ситуацией по мере сил или попробовать счастья в новом, казалось бы, более благоприятном месте (в новом городе, на новой работе, с новыми друзьями, в новой специальности, и т.д.)? Что бы вы выбрали и почему? Вы можете привести пример такой ситуации и вашего подхода к ней?', 'short-answer', 1, NULL, NULL),
(510, 155, 'Вы хотите жить близко от того места, где вы выросли, или нет? Почему? Вы могли бы уехать в другую страну на постоянное жительство? Если да, то куда и при каких обстоятельствах? Если нет, то почему?', 'short-answer', 2, NULL, NULL),
(511, 155, 'Если вы сами эмигрировали, расскажите о своем личном опыте. Что мотивировало вас или вашу семью? Что для вас было неожиданно трудным? Что было неожиданно ценным? Что вы потеряли? Что приобрели? Вы могли бы (хотели бы) вернуться жить на родину? При каких условиях и почему?', 'short-answer', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `professor_registrations`
--

CREATE TABLE `professor_registrations` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date_created` int(11) NOT NULL,
  `date_deleted` int(11) DEFAULT NULL,
  `date_start` int(11) NOT NULL,
  `date_end` int(11) NOT NULL,
  `signup_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `professor_registrations`
--

INSERT INTO `professor_registrations` (`id`, `owner_id`, `professor_id`, `course_id`, `date_created`, `date_deleted`, `date_start`, `date_end`, `signup_code`) VALUES
(1, 5, 2, 1, 1488417868, NULL, 0, 1519953868, 'professorregistration1-58339'),
(2, 5, 3, 1, 1488417868, NULL, 0, 1519953868, 'professorregistration2-928AB'),
(3, 6, 4, 2, 1488417868, NULL, 100000, 111111, 'professorregistration3-CA87D'),
(4, 6, 4, 3, 1488417868, NULL, 0, 1519953868, 'professorregistration4-38581'),
(5, 6, 4, 4, 1488417868, NULL, 0, 1519953868, 'professorregistration5-1535S'),
(6, 19, 20, 5, 1492971023, NULL, 1491436800, 1507680000, 'd3a6d7aa94ea5c0cc996e19d203f5aa9');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `album` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `artist` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lyrics` longtext COLLATE utf8_unicode_ci NOT NULL,
  `embed` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `unit_id`, `title`, `weight`, `album`, `artist`, `description`, `lyrics`, `embed`) VALUES
(1, 3, 'めうめうぺったんたん!!', 1, 'Bitter Sweet Girls', '日向美ビタースイーツ♪', 'meu meu', 'ワールドワイドな荒波ザッバー  商店街はひなびてらぁな 約束手形何万枚だ  ぺったんぺったんぺったんたーん 押して押されて押しも押されぬ  押し問答  こーなりゃ一肌脱いでやらぁにゃ  商店街から萌えおこしーな 可愛いキャララー　ハンコでホワワー  ぺったんぺったんぺったんたーん 押せばお先に推して知るべし　(せーの!!)  押さえどころ  甘くてゆるくてあざとい仕草に  萌えろよ萌えろよ　ハンコをぺったん 赤くてプニくてしっとり濡れてる  やわらかやわらか　朱肉だよ  萌えるハンコは正義のしるし!! ひれつな悪をうちくだくっ!!  めめめめめめめめうめう  めめめめうめう ぺったんぺったんぺったんぺったん  大好き めめめめうめう　めめめめうめう  ハンコで世界中しあわせ!! めめめめうめう　めめめめうめう ぺったんぺったんぺったんぺったん  大好き 合言葉は　萌えおこし　萌えおこし (M・O・K・S!! M・O・K・S!!) ぺたっとぺたっとぺたりこー!!  わふー!!　(わー!!)  ははははは!!　(オイ!!) んんんんん!!　(オイ!!) こここここ!!　(オイ!!)  ハンコ大好きー!!', NULL),
(2, 3, 'ちくわパフェだよ☆CKP', 2, 'Bitter Sweet Girls', '日向美ビタースイーツ♪', 'chikuwa parfait', 'ちくパちくパ  ちくわのパフェなんだよ！ ちくパちくパ  おいしいめう  おしゃれめう！ ちくパちくパ  CKPCKP  ちくパちくパ  ちくパ最高ーッ！  わぁー！  生クリーム  バニラのアイスに  イチゴとバナナと メインはもちろん（もちろん）  ちくわめう！（ちくわ！） とろけたチョコをかければ完成  ちくパで大丈夫だよ  絶対  大丈夫だよっ！  ｢んきゅーッ！？悪のスイーツ大魔王が現れためう！｣ ｢落ち着いて！このちくわステッキで魔法ちくわ少女に変身するんだよっ！｣ ｢そそそそんな設定聞いてないめう！｣ ｢大丈夫だよ！絶対、大丈夫だよっ！｣  ちくパちくパ  まりまり  ちくパちくパ  もりもり ちくパちくパ  めうめう  ちくパちくパ  めりめり ちくちわ  ちくちくわ  ちくちくちわ  ちくちくちくわ  ちくちくちくちわ  ｢めうーっ！ちくわが折れたぁ！｣ ｢大丈夫！必殺・ちくわの穴から生クリーム光線だよっ！｣ （ドグシャァ　バリバリドッカー　チチクワァ） ｢こうして町に平和が訪れためう｣ ｢ちくわのおかげだねっ！｣  ちくパの味は似ているね  パパパウーパールーパー（違うめう！） みんな笑顔  やぶれかぶれ  無敵のハーモニー ちくパの歯ごたえ  お手前  パパパグーパーチョキパー（勝負めう！） ちくわの穴のぞけば  ほら  キラキラ光る  未来が見える  おーっ！ ちくパちくパ  CKPCKP  ちくパちくパ  ちくパ最高ーッ！                     ｢せーの！｣                        ｢｢ちくパ！｣｣', NULL),
(3, 4, 'NOT 4361 UNIT 3', 3, 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', NULL),
(6, 3, '君がいる場所へ', 3, 'Form Ride', 'VALLEYSTONE', 'The last song on VALLEYSTONE\'s first album, Form Ride. Also featured in SOUND VOLTEX III GRAVITY WARS.', '君だけのため　光る世界\r\nここにあるよ――\r\n\r\n幼い手で握りしめてた\r\n失くさないよう　ぎゅっと\r\n真っ白な　願いを\r\n君と追いかけて\r\n\r\nまた迷い込む　寂しげな夜だから\r\nあの日の面影を　見つけて\r\n思い出すよ\r\n\r\n君がいるから　どこでだって\r\n何度、転んでも　笑える\r\n偶然だとか　必然だとか\r\n要らないほど　強く\r\nきっと輝く　思い出なら\r\n君の側にだけ　あるから\r\n繋いだ手は　信じてるよ\r\n\r\nその温かさが　嬉しくて\r\nずっと守れるように\r\n強くなりたかった\r\nほら　君のように\r\n\r\nもっと沢山の歌詞は ※ Mojim.com\r\n一緒に歩き　重ねたこの季節は\r\nどれだけの思いも　願いも\r\n分かっているの\r\n\r\nもう大丈夫　君がいれば\r\n心、それだけで　強くなる\r\n過去と未来　どこでもない\r\n今ここにあるから\r\n届いてるかな　君の元へ\r\n明日　また逢える　奇跡を\r\n忘れないで\r\nいつまでも――\r\n\r\nあの日　君と会った　その引力が\r\nそっと　物語を　溶かしていくの\r\nちっぽけな　私も　小さな芽を\r\n優しく抱いて　誰かにいつか\r\n届けたいよ\r\n\r\n君がいるから　どこでだって\r\n何度、転んでも　笑える\r\n偶然だとか　必然だとか\r\n要らないほど　強く\r\nきっと輝く　思い出なら\r\n君の側にだけ　あるから\r\n大切な世界　離さないよ', NULL),
(10, 9, 'CLOSER', 1, 'CLOSER', '井上ジョー', '「CLOSER」井上ジョーの曲です。「CLOSER」は最初に2008年12月17日にKi/oon Recordsから発売された。シングルの名前は 「CLOSER」です。そして、「CLOSER」はテレビ東京系アニメ『ナルト』の第4期オープニングテーマでした。\n\nデビュー作である、前作「HELLO!」から5ヶ月ぶりのリリース。初回仕様限定盤には、「描き下ろしワイドキャップステッカー」と、「特製卓上『NARUTO -ナルト- 疾風伝』アニバーサリーカレンダー」が封入[1]。公式ページでのキャッチコピーは、『超大型タイアップ決定！『NARUTO-ナルト-疾風伝』10月2日からオープニングテーマ！』\n\nロサンゼルスで生まれ育った日系アメリカ人であり、両親は日本からアメリカ・ロサンゼルスに移住した日系人である。日本語は日本の漫画とテレビ番組から覚えたと語っている。ボーカルは勿論、ギター、ドラム、ベース、ピアノ、ウクレレ、シンセサイザーも演奏することができ、楽曲制作を全て自身で手掛けている。作詞、作曲、演奏、レコーディング、ミキシング、編曲を自身で担当しており、他のアーティストへの楽曲提供も行っている。', '身近にある物 \r\n常に気を付けていないと \r\n余りに近すぎて \r\n見失ってしまいそう \r\n\r\nあなたが最近体験した \r\n幸せは一体何ですか? \r\n恵まれすぎていて \r\n思い出せないかも! \r\n\r\n今ここにいる事 \r\n息をしている事 \r\nただそれだけの事が \r\n奇跡だと気付く \r\n\r\n身近にある物 \r\n常に気を付けていないと \r\n余りに近すぎて \r\n見失ってしまいそう \r\n\r\nYou know the closer you get to something \r\nThe tougher it is to see it \r\nAnd I\'ll never take it for granted \r\n\r\nLet\'s go \r\n\r\n人助けを偽善と \r\n呼ぶ奴等もいるけれど \r\n信じるのも疑うのも \r\n人それぞれだから \r\n\r\nたとえ仮にそれが \r\n偽善であったとしても \r\n誰かを救えたなら \r\nそりゃむしろ何よりもリアル \r\n\r\n追い続けてきた夢 \r\nあきらめずに進めよなんて \r\nキレイ事を言えるほど \r\n何も出来ちゃいないけど \r\n\r\n一握りの勇気を胸に \r\n明日を生き抜くために \r\nAnd I\'ll never take it for granted \r\n\r\nLet\'s go', 'https://www.youtube.com/embed/4Cp0WgkgDbQ'),
(11, 9, 'ヒトヒラのハナビラ', 2, 'ハイドランジアが咲いている', 'STEREOPONY', '「ヒトヒラのハナビラ」は、日本のロックバンド・ステレオポニーのメジャーデビューシングルである。\n\nロック・フェスティバル『閃光ライオット』の予選出場をきっかけにスカウトされた同バンドのデビュー作。スカウトのきっかけとなった予選出場（2008年6月21日）から4ヶ月半でのデビューとなった。\n\n初回生産版にはステレオポニーオリジナル『BLEACH』特製ステッカーが封入された。\n\nオリコン週間シングルチャートでは最高順位25位を記録、デビュー作にしてTOP30入りを果たした。', 'ヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だったそんな事 思いたくはない \r\n\r\nテーブルの向こう 暗い顔してる \r\n切り出す コトバに 怯えてんだ \r\nいったいいつから僕ら こんなキモチに \r\n気づかないふり続けてたんだ? \r\n出逢った日のような あの透き通る風の中で \r\nやり直せるのなら もう一度 抱きしめたい \r\n\r\nヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だった そんな事 思いたくはない \r\n\r\n好きだった はずだった いつだって声が聞きたくなるほど \r\nそれなのに 手が届く先の君が 見えなくなりそうだ \r\n\r\n平気だってすぐ我慢してたのは \r\nきっと僕たちの悪いトコで \r\nいっつも一緒にいたいって 想ってたのに \r\nすれ違いは現実を変えた? \r\n出逢った日のような あの柔らかな笑顔だって \r\nすぐに取り戻せる 気がしてた 抱きしめたい \r\n\r\nヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だった そんな事 思いたくはない \r\n\r\n黙ったままの君の手のひら \r\nたどり着いたナミダがハジけた \r\nこんな僕たちの 時間を巻き戻して・・・ \r\n\r\nヒトヒラの ハナビラが 舞い落ちた 僕のとなりで今 \r\n間違った 恋だった なんて忘れられるはずはないんだ \r\n\r\n好きだった 好きだった いまだってすがりつきたくなるほど \r\nそれなのに 手が届く先の君が 見えなくなりそうだ', 'https://www.youtube.com/embed/vYV-XJdzupY'),
(12, 9, 'Snow Halation', 3, 'Snow Halation', 'μ’s', '「Snow halation」（スノー・ハレーション）は、μ\'sの楽曲。同グループ2枚目のシングルとして2010年12月22日にLantisから発売された。CDには楽曲とボイスドラマが、DVDにはアニメーションミュージッククリップが収録されている。通称は「スノハレ」。\n\n初回生産分は初回生産限定スペシャルジャケット仕様[注 3]になっている。法人特典として、アニメイト・ゲーマーズ・コミックとらのあなで購入すると、数量限定のレプリカチケット[注 4]が商品1つにつき、1枚付属した。\n2011年1月3日付のオリコン週間ランキングでは1023枚を売り上げ74位にランクインした。その後1週で圏外に去ったが、アニメ第2期9話放送後にあたる2014年6月23日付のオリコン週間ランキングで216枚を売り上げ、3年半ぶりにランクインを果たした。\n\n2017年2月18日にNHK・BSプレミアムにて放送された生放送番組『カウントダウンLIVE アニソン ベスト100!』において、Snow halationが第1位に選ばれ[注 5]、中川翔子・i☆Ris・岩崎良美・高橋洋子によるスペシャルコラボバージョンで歌われた。\n\nキャッチコピーは「あなたと過ごしたい…冬の日の思い出が、はじまる」。', '不思議だね　いまの気持ち \r\n空から降ってきたみたい \r\n特別な季節の色が　ときめきを見せるよ \r\n\r\n初めて出会った時から \r\n予\\感に騒ぐ心のMelody \r\nとめられないとまらない　な・ぜ \r\n\r\n届けて \r\n切なさには名前をつけようか“Snow halation” \r\n想いが重なるまで待てずに \r\n悔しいけど好きって純情 \r\n微熱の中　ためらってもダメだね \r\n飛び込む勇気に賛成 まもなくStart!! \r\n\r\n音もなく　気配もなく \r\n静かに運命は変わる \r\nこれからの未来に胸の　鼓動が早くなる \r\n\r\n例えば困った時には \r\nすぐ駆けつけて抱きしめたくて \r\nどこにいてもどこでも　Fly high \r\n\r\n急いで \r\nいつの間にか大きくなりすぎた“True emotion” \r\n夢だけみてる様じゃつらいよ \r\n恋人は君って言いたい \r\n優しい目が　とまどってるイヤだよ \r\nこのまま一気に愛情 あずけてPlease!! \r\n\r\n届けて \r\n切なさには名前をつけようか“Snow halation” \r\n想いが重なるまで待てずに \r\n悔しいけど好きって純情 \r\n微熱の中　ためらってもダメだね \r\n飛び込む勇気に賛成 まもなくStart!!', NULL),
(18, 8, '故郷', 1, 'なし', '岡野貞一', '故郷（ふるさと）は、高野辰之作詞・岡野貞一作曲による文部省唱歌。\n\n1914年（大正3年）の尋常小学唱歌の第六学年用で発表された。\n長らく作詞作曲者不明だったが、昭和40年代に高野、岡野と同定され、1992年（平成4年）からは音楽の教科書に両者の名前が明記されている。\n高野の出身地である長野県中野市と、岡野の出身地鳥取県鳥取市に歌碑がある。\n\n子供の頃の野山の風景を遠い地から懐かしむという内容で、生まれ故郷から離れて学問や勤労に励む人の心情を歌っている。歌詞に述べられている「かの山」は高野の故郷にある「熊坂山」や「大平山」、また「かの川」は「斑川」であるとする説がある。\n\n野兎を追ったあの山や、小鮒を釣ったあの川よ。今なお夢に思い、心巡る忘れられない故郷よ。\n\n父や母はどうしておいでだろうか（「います」は「居る」の丁寧形ではなく、古語の尊敬語「在す」）、友人たちは変わりなく平穏に暮らしているだろうか。風雨（艱難辛苦の比喩とも）のたびに、思い出す故郷よ。\n自分の夢を叶えて目標を成就させたら、いつの日にか故郷へ帰ろう。山青く水清らかな故郷へ。', '兎追いし　彼の山\r\n小鮒釣りし　彼の川\r\n夢は今も　巡りて\r\n忘れ難き　故郷\r\n\r\n如何にいます　父母\r\n恙無しや　友がき\r\n雨に風に　つけても\r\n思い出づる　故郷\r\n\r\n志を　果たして\r\nいつの日にか　帰らん\r\n山は靑き　故郷\r\n水は淸き　故郷', 'https://www.youtube.com/embed/jnrr_b6xWmI'),
(19, 8, '海行かば', 2, 'なし', '信時潔', '『海行かば』（うみゆかば）とは、日本の軍歌ないし国民歌の一である。\n\n当時の大日本帝国政府が国民精神総動員強調週間を制定した際のテーマ曲。信時潔がNHKの嘱託を受けて1937年（昭和12年）に作曲した。信時の自筆譜では「海ゆかば」である。\n\n放送は1937年（昭和12年）10月13日から10月16日の国民精神総動員強調週間に「新しい種目として」行われたとの記録がある。本曲への国民一般の印象を決定したのは、大東亜戦争(太平洋戦争)期、ラジオ放送の戦果発表（大本営発表）が玉砕を伝える際に、必ず冒頭曲として流されたことである（ただし真珠湾攻撃成功を伝える際は勝戦でも流された）。ちなみに、勝戦を発表する場合は、「敵は幾万」、陸軍分列行進曲「抜刀隊」、行進曲『軍艦』などが用いられた。\n\n創立以来1958年まで桜美林学園は旋律を校歌に採用していた。', '海行かば\r\n水漬く屍\r\n山行かば\r\n草生す屍\r\n大君の辺にこそ死なめ\r\nかえりみはせじ', 'https://www.youtube.com/embed/yUwvIFYcCqo\"'),
(20, 8, '露営の歌', 3, 'なし', '古関裕而', '露営の歌（ろえいのうた）は、1937年（昭和12年）9月にコロムビアレコードから発売された軍歌。\n\n1937年、日中戦争が勃発した。東京日日新聞と大阪毎日新聞に題号が分かれていた毎日新聞が戦意高揚のためこれにあわせて「進軍の歌」の歌詞を公募し、薮内喜一郎（1905年–1986年、奈良県出身、京都市役所に勤務）が傑作に入選した。\n\nそれを北原白秋や菊池寛らが「露営の歌」と題し、古関裕而が作曲を手がけた。古関は満州を旅行の帰途下関から東京への特急列車の車中で新聞に発表された歌詞を見て心を動かされ、依頼されていないにもかかわらず作曲していた。東京に着いた古関に日本コロムビアの社員が作曲を依頼した時には「それならもうできていますよ」と楽譜を差し出したという。\n\n京都の嵐山には「露営の歌碑」がある。題字は陸軍大将松井石根によって行われている。', 'なし', NULL),
(21, 10, '七人の侍', 1, '映画', '黒澤明', '『七人の侍』（しちにんのさむらい）は、1954年（昭和29年）4月26日に公開された日本映画である。東宝製作・配給。監督は黒澤明、主演は三船敏郎と志村喬。モノクロ、スタンダード・サイズ、207分。\n\n当時の通常作品の7倍ほどに匹敵する製作費をかけ、何千人ものスタッフ・キャストを動員、1年余りの撮影期間がかかったが、興行的には成功し、700万人の観客動員を記録した。日本の戦国時代（劇中の台詞によると1586年）を舞台とし、野武士の略奪により困窮した百姓に雇われる形で集った7人の侍が、身分差による軋轢を乗り越えながら協力して野武士の一団と戦う物語。\n\n黒澤明が初めてマルチカム方式（複数のカメラで同時に撮影する方式）を採用し、望遠レンズを多用した。ダイナミックな編集を駆使して、豪雨の決戦シーン等迫力あるアクションシーンを生み出した。さらにその技術と共に、脚本、綿密な時代考証等により、アクション映画・時代劇におけるリアリズムを確立した。\n\n黒澤明が尊敬するジョン・フォードの西部劇から影響を受け、この作品自体も世界の映画人・映画作品に多大な影響を与えた。1960年にはアメリカ合衆国で『荒野の七人』として、2016年には『マグニフィセント・セブン』としてリメイクされている。ヴェネツィア国際映画祭銀獅子賞受賞。', '映画ですから、歌詞はありません。', NULL),
(22, 10, 'となりのトトロ', 2, 'となりのトトロ', '中川李枝子/井上杏美', '『となりのトトロ』はスタジオジブリの長編アニメーション映画。宮崎駿監督作品。昭和30年代前半の日本を舞台にしたファンタジー。\n\n物語は、田舎へ引っ越してきた草壁一家のサツキ・メイ姉妹が、“もののけ”とよばれ、子どもの時にしか会えないと言われる不思議な生き物・トトロとの交流を描いていくストーリー。', '卜トロ トトロ トトロ トトロ \nだれかが こっそり \n小路に 木の実 うずめて \nちっさな芽 生えたら 秘密の暗号 \n森へのパスポート \nすてきな冒険はじまる \nとなりのトトロ トトロ トトロ トトロ \n\n森の中に むかしから住んでる \nとなりのトトロ トトロ トトロ トトロ \n子供のときにだけ あなたに訪れる \n不思議な出会い \n\n雨ふり バス停 \nズブヌレ オバケがいたら \nあなたの雨ガサ さしてあげましょ \n森へのパスポート \n魔法の扉 あきます \nとなりのトトロ トトロ トトロ トトロ \n月夜の晩に オカリナ吹いてる \nとなりのトトロ トトロ トトロ トトロ \nもしも会えたなら すてきな しあわせが \nあなたに来るわ \n\n卜卜ロ 卜トロ 卜トロ 卜トロ \n森の中に むかしから住んでる \nとなりのトトロ トトロ トトロ トトロ \n子供のときにだけ あなたに訪れる \n不思議な出会い \n\nトトロ トトロ トトロ トトロ \nトロ トトロ 卜トロ トトロ……', NULL),
(23, 13, 'Про дикого вепря (1966)', 1, '', 'Владимир Высоцкий', '<A HREF=\"http://clsp.gatech.edu/Song_Project/upload/Vysotksii Zatiazhnoi pryzhok.jpg\"<CENTER><IMG SRC=\"http://clsp.gatech.edu/Song_Project/upload/Vysotksii Zatiazhnoi pryzhok.jpg\" width=\"300\" height=\"300\"></CENTER></A>\n\n\nВладимир Высоцкий (1938-1980) — одна из крупнейших фигур в советской послевоенной культуре. Актер знаменитого Театра на Таганке (где до недавнего времени работал всемирно известный режиссер Юрий Любимов) и звезда кино, автор популярнейших \"бардовских\" песен. Его незабываемый <a href=\"хриплый\" title=\"hoarse\"><font color=\"#A19D72\">хриплый</a></font> голос одинаково прекрасно передает и юмор, и эмоциональный <a href=\"надрыв\" title=\"чрезмерное, мучительное напряжение\"><font color=\"#A19D72\">надрыв</a></font>. Его песни воспринимались в глухих 70-х годах, как глоток <a href=\"\"ворованного воздуха\"\" title=\"stolen air\"><font color=\"#A19D72\">\"ворованного воздуха\"</a></font>. <a target=\"_blank\" href=\"http://ru.wikipedia.org/wiki/Владимир_Высоцкий#.D0.9F.D0.BE.D1.85.D0.BE.D1.80.D0.BE.D0.BD.D1.8B\"> Огромное <a href=\"шествие\" title=\"procession\"><font color=\"#A19D72\">шествие</a></font> народа <a href=\"вопреки\" title=\"in spite of, against\"><font color=\"#A19D72\">вопреки</a></font> желанию властей</a> в день похорон Высоцкого стало <a href=\"предзнаменованием\" title=\"portent\"><font color=\"#A19D72\">предзнаменованием</a></font> будущих перемен эпохи перестройки. До сих пор почитатели его творчества собираются на Ваганьковском кладбище в дни его рождения и смерти (25-е января и июля).\n\nПрослушайте песню из серии смешных, горьких и острых \"песен-сказок\".', 'В королевстве, где все тихо и складно,\nГде ни войн, ни катаклизмов, ни бурь,\nПоявился дикий вепрь огромадный —\nТо ли буйвол, то ли бык, то ли тур.\n\nСам король страдал желудком и астмой,\nТолько кашлем сильный страх наводил, —\nА тем временем зверюга ужасный\nКоих ел, а коих в лес волочил.\n\nИ король тотчас издал три декрета:\n\"Зверя надо — говорит — одолеть наконец!\nКто отчается на это, на это,\nТот принцессу поведет под венец\".\n\nА в отчаявшемся том государстве —\nКак войдешь, так прямо наискосок —\nВ бесшабашной жил тоске и гусарстве\nБывший лучший, но опальный стрелок.\n\nНа полу лежали люди и шкуры,\nПели песни, пили мёды — и тут\nПротрубили во дворе трубадуры,\nХвать стрелка — и во дворец волокут.\n\nИ король ему прокашлял: \"Не буду\nЯ читать тебе морали, юнец, —\nВот если завтра победишь чуду-юду,\nТо принцессу поведешь под венец\".\n\nА стрелок: \"Да это что за награда?!\nМне бы — выкатить портвейна бадью!\"\nМол, принцессу мне и даром не надо, —\nЧуду-юду я и так победю!\n\nА король: \"Возьмешь принцессу — и точка!\nА не то тебя раз-два — и в тюрьму!\nВедь это всё же королевская дочка!..\"\nА стрелок: \"Ну хоть убей — не возьму!\"\n\nИ пока король с им так препирался,\nСъел уже почти всех женщин и кур\nИ возле самого дворца ошивался\nЭтот самый то ли бык, то ли тур.\n\nДелать нечего — портвейн он отспорил, —\nЧуду-юду уложил — и убег...\nВот так принцессу с королем опозорил\nБывший лучший, но опальный стрелок.‍\n\n1966\n\nДополнительное чтение:\n\nСказка \"Иван крестьянский сын и чудо-юдо\"\n\nВино или женщина? Об этом пели и до Высоцкого.\n\nКакая была судьба многих талантливых людей во время брежневского застоя? Отрывок из \"бессмертной поэмы\" Венички Ерофеева \"Москва-Петушки\".', NULL),
(24, 14, 'Две гитары', 1, '', 'Петр Лещенко', 'Это одна из самых знаменитых (русских) цыганских песен. Слова написаны русским поэтом XIX века Аполлоном Григорьевым, ценителем цыганской музыки и культуры. Музыка написана (скорее, <a href=\"обработана\" title=\"обрабо́тка — arrangement\"><font color=\"#A19D72\">обработана</a></font>) его другом, руководителем цыганского хора Иваном Васильевым. (Заметьте, что имена цыган часто неотличимы от русских имен.) Впоследствии песня стала почти народной (русской и цыганской), и слова переделывались и сокращались (а также добавлялись). Слова Лещенко совпадают с григорьевскими только в самом начале песни.', 'Две гитары за стеной\nЖалобно заныли,\nС детства памятный мотив:\n\"Ах, милый, это ты ли?\"\n\nЭх, раз, еще раз, еще да много раз!\nЭх, раз, еще раз, еще да много раз!\n\n[неразборчиво (нрзб)]\n\nОтчего да почему \nИ по какому случаю\nЯ одну тебя люблю\nА пятнадцать мучаю?\n\nЭх, раз, еще раз, еще да много раз!\nЭх, раз, еще раз, еще да много раз!\n\n[нрзб]\n\nЭх садитесь, барин,\nНу что вы, да не торгуйтесь\nНабавьте четвертак\nНу вот так...\n\n[нрзб]\n\nЭх, раз, да еще раз, еще много много раз!\n\n\nДополнительное чтение:\n\nТеперь выберите и прочитайте одно из двух стихотворений Аполлона Григорьева. Это первоначальные тексты \"цыганской венгерки\". Оба стихотворения включались в цикл, посвященный несчастной любви поэта и написанный под впечатлением общения с цыганскими музыкантами. Первое стихотворение, короткое, красивое, замечательное экономностью своих образов, называется \"Поговори хоть ты со мной\". Второе — длинная, экстатическая, отчаянная \"Цыганская венгерка\" (\"Две гитары, зазвенев...\").\n\nЗдесь читайте большой отрывок из мемуарного рассказа Афанасия Фета о том, как Григорьев повел его к цыганам.\n\nА здесь можно читать подробно о Васильеве и об истории \"Цыганочки\".', NULL),
(25, 14, 'Моя цыганская', 2, '', 'Владимир Высоцкий', 'А это одна из версий Владимира Высоцкого. \n\n(О нем можно прочитать в уроке \"Анти-сказка\" во введении к песне \"Про дикого вепря\".)', 'В сон мне — желтые огни,\nИ хриплю во сне я:\n\"Повремени, повремени —\nУтро мудренее!\"\nНо и утром всё не так,\nНет того веселья:\nИли куришь натощак,\nИли пьешь с похмелья.\n\nЭх, раз, да еще раз,\nИли пьешь с похмелья...\n\nВ кабаках — зеленый штоф,\nБелые салфетки, —\nРай для нищих и шутов,\nМне ж — как птице в клетке.\nВ церкви — смрад и полумрак,\nДьяки курят ладан...\nНет, и в церкви всё не так,\nВсё не так, как надо.\n\nДа, э-э-эх, раз, да еще раз,\nВсё не так, как надо...\n\nЯ — на гору впопыхах,\nЧтоб чего не вышло, —\nА на горе стоит ольха,\nА под горою — вишня.\nХоть бы склон увить плющом —\nМне б и то отрада,\nХоть бы что-нибудь еще...\nВсё не так, как надо!\n\nЭх, раз, да еще раз,\nВсё не так, как надо.\n\nЯ — по полю вдоль реки.\nСвета — тьма, нет Бога!\nА в чистом поле — васильки,\nДальняя дорога.\nВдоль дороги — лес густой\nС бабами-ягами,\nА в конце дороги той —\nПлаха с топорами.\n\nЭх, раз, да еще раз,\nПлаха с топорами.\n\nГде-то кони пляшут в такт,\nНехотя и плавно.\nВдоль дороги все не так,\nА в конце — подавно.\nИ ни церковь, и ни кабак  —\nНичего не свято!\nНет, нет, ребята, всё не так,\nВсё не так, ребята...\n\nЭх, раз...\n\n\nисточник\n\nДополнительное чтение:\n\nАлександр Пушкин — \"Цыганы\" (1824)\nФедор Достоевский — отрывок из \"Братьев Карамазовых\" (1879-1880)\nАлександр Блок — \"В ресторане\" (1910)\n', NULL),
(26, 15, '???', 1, '', 'Александр Цфасман', 'Это — песня-шутка, которую не перестают исполнять  и записывать. Первая версия, которую мы и послушаем, записана джаз-оркестром Александра Цфасмана в 1937 году. \n\nНазвание пока не скажем.\n\n\n\n\n', 'Музыка А. Цфасмана \n 	\n 	Слова В. Трофимова \n 	\n 	Тебя просил я быть на свиданье, \n 	Мечтал о встрече, как всегда, \n 	Ты улыбнулась, слегка смутившись, \n 	Сказала: \"Да, да, да, да!\" \n 	\n 	С утра побрился и галстук новый \n 	С горошком синим я надел. \n 	Купил три астры, в четыре ровно \n 	Я прилетел. \n 	\n 	— Я ходил! \n 	— И я ходила! \n 	— Я так ждал! \n 	— И я ждала! \n 	— Я был зол! \n 	— И я сердилась! \n 	— Я ушел! \n 	— И я ушла! \n 	\n 	Мы были оба. \n 	— Я у аптеки! \n 	— А я в кино искала вас! \n 	— Так значит, завтра, на том же месте \n 	В тот же час! \n 	\n 	\nДополнительное чтение: \n 	\n1) первый советский антиджазовый фельетон, \"О музыке толстых\" Максима Горького (\"Правда\", 1928 г.) \n2) \"За хорошую музыку\" (\"Известия\", 11 декабря 1936 г.). Это один из \"залпов\" в перепалке между \"Известиями\" и \"Правдой\" о значении и достоинстве джаза. \"Правда\" (теперь защищающая джаз) была вынуждена отступить. \n3) Заголовки газеты \"Известия\" от 21 ноября 1936 г. \n4) Рассказ руководителя влиятельного советского джаза, А. Варламова, о том, как советские музыканты учились джазу (из книги А. Баташева \"Советский джаз\", 1973 г.).\n\n', NULL),
(27, 15, 'Ах, эти черные глаза', 2, '', 'Петр Лещенко', 'Об истории танго в России можно читать <a target=\"_blank\" href=\"http://mirtango.ru/articles/75\">здесь</a>.\n\n<object width=452 height=385><param name=\"allowScriptAccess\" value=\"always\" /><param name=\"movie\" value=\"http://img.mail.ru/r/video2/player_v2.swf?movieSrc=mail/kiryushenko_nade/869/797\" /><embed src=http://img.mail.ru/r/video2/player_v2.swf?movieSrc=mail/kiryushenko_nade/869/797 type=\"application/x-shockwave-flash\" width=452 height=385 allowScriptAccess=\"always\"></embed></object>', 'Ах, эти черные глаза\n\nСлова и музыка О. Строка\n\nБыл день осенний, и листья гpустно опадали.\nВ последних астpах печаль хpустальная жила.\nГpусти тогда с тобою мы не знали.\nВедь мы любили, и для нас весна цвела.\n\nАх, эти чеpные глаза меня пленили.\nИх позабыть нигде нельзя,\nОни гоpят пеpедо мной.\nАх, эти чеpные глаза меня любили.\nКуда же скpылись вы тепеpь,\nКто близок вам дpугой?\nАх, эти чеpные глаза меня погубят.\nИх позабыть нигде нельзя,\nОни гоpят пеpедо мной.\nАх, эти чеpные глаза, кто вас полюбит,\nТот потеpяет навсегда\nИ сеpдце и покой.\n\n      Очи черныя! Очи страстныя!\n      Очи милыя и прекрасныя!\n      <i>Как люблю я вас! Как боюсь я вас!</i>\n      <i>Знать увидел вас не в добрый час!</i>\n\nАх, эти чеpные глаза, кто вас полюбит,\nТот потеpяет навсегда\nИ сеpдце и покой.', NULL),
(28, 16, 'Гимн СССР', 1, 'Мешанина, или неГолубой огонек (2004)', '5\'nizza', '<br>\n<br>\nПеред тем, как послушать исполнение Гимна СССР группой \"5\'nizza\", послушайте гимн в традиционном испонении:\n	\n<iframe width=\"480\" height=\"360\" src=\"https://www.youtube-nocookie.com/embed/cNNMlwzJ6qU?showinfo=0\" frameborder=\"0\" allowfullscreen></iframe>\n', 'В этой песне серия политических и газетных штампов/лозунгов ложится на торжественную музыку.\n\n\nГимн Советского Союза (версия 1977-го года)\n\nСоюз нерушимый республик свободных\nСплотила навеки Великая Русь.\nДа здравствует созданный волей народов\nЕдиный, могучий Советский Союз!\n\n<i>Припев</i>\n\nСлавься, Отечество наше свободное,\nДружбы народов надежный оплот!\nПартия Ленина — сила народная\nНас к торжеству коммунизма ведет!\n\n  	[Ля-ля-ля-ля-ля-ля-ля-ля\n  	Ля-ля-ля-ля-ля-ля-ля-ля-ля\n  	ля-ля-ля-ля-ля-ля-ля-ля\n  	Уоу-уоу-йей\n  	Уоу-уоу-йей\n  	Уоу-уоу-йей\n  	Ля, ля-ля-ля-ля-ля-ля-ля-ля\n  	Ля-ля-ля-ля-ля-ля-ля-ля-ля\n  	ля-ля-ля-ля-ля-ля-ля-ля] \n\nСквозь грозы сияло нам солнце свободы,\nИ Ленин великий нам путь озарил:\nНа правое дело он поднял народы,\nНа труд и на подвиги нас вдохновил!\n\n<i>Припев</i>\n\n[В победе бессмертных идей коммунизма\nМы видим грядущее нашей страны,\nИ Красному знамени славной Отчизны\nМы будем всегда беззаветно верны!]\n\n\nДополнительное чтение:\n\n1) Заявление Президента России В.В. Путина по проблеме государственной символики (04.12.2000 г.)\n\n2) Василий Аксенов, \"Великий, могучий...\". О биографии автора и судьбе его родителей можно читать здесь.\n\n3) Государственный гимн Российской Федерации. 2000. Слова: Сергей Михалков. Музыка: Александр Александров.', NULL),
(29, 17, 'Синий платочек', 1, 'из к/ф ', 'Клавдия Шульженко', ' ', 'Помню, как в памятный вечер\nПадал платочек твой с плеч, \nКак провожала,\nИ обещала\nСиний платочек сберечь.\n\nИ пусть со мной\nНет сегодня любимой, родной, \nЗнаю, с любовью\nТы к изголовью\nПрячешь платок дорогой.\n\nПисьма твои получая,\nСлышу я голос родной.\nИ между строчек\nСиний платочек\nСнова встает предо мной.\n\nИ часто в бой\nПровожает меня облик твой, \nЧувствую, рядом\nС любящим взглядом\nТы постоянно со мной.\n\nСколько заветных платочков\nМы сохраняем с собой! \nНежные речи,\nДевичьи плечи\nПомним в страде боевой.\n\nЗа них, родных,\nЖеланных, любимых таких. \nСтрочит пулеметчик\nЗа синий платочек,\nЧто был на плечах дорогих!\n\nСтрочит пулеметчик\nЗа синий платочек,\nЧто был на плечах дорогих!\n\nТак заканчивается самая известная версия песни. В фильме \"Концерт — фронту\" (1942) песня имеет еще два куплета:\n\nКончится время лихое,\nС радостной вестью приду.\nСнова дорогу\nК милой порогу\nЯ без ошибки найду.\n\nИ вновь весной\nПод знакомой ветвистой сосной\nМилые встречи,\nНежные речи\nНам возвратятся с тобой.\n\nМилые встречи,\nНежные речи\nНам возвратятся с тобой.\n\n\nДополнительные материалы:\n\n1) Письмо на фронт\n2) Об истории песни \"Синий платочек\" (из книги \"Песенная летопись Великой Отечественной войны\")\n3) Джаз на фронте (отрывок из книги А. Н. Баташева \"Советский джаз\")\n4) Цфасман на фронте (фотография)\n5) Солдаты на привале с патефоном (фотография)', NULL),
(30, 17, 'Барон фон дер Пшик', 2, '', 'Леонид Утесов', '', 'Барон фон дер Пшик\nПокушать русский шпик\nДавно собирался \nИ мечтал.\n\nЛюбил он очень шик,\nСтесняться не привык,\nЗаранее \nО подвигах мечтал.\n\nОрал по радио,\nЧто в Сталинграде он,\nКак на параде он\nИ ест он шпик.\n\nЧто ест он и пьёт,\nА шпик подаёт\nПод клюквою\nРазвесистой мужик.\n\nБарон фон дер Пшик\nЗабыл про русский штык,\nА штык бить\nБаронов не отвык.\n\nИ бравый фон дер Пшик\nПопал на русский штык,\nНе русский,\nА немецкий вышел шпик!\n\nМундир без хлястика,\nРазбита свастика,\nА ну-ка влазьте-ка\nНа русский штык!\n\nБарон фон дер Пшик,\nНу где твой прежний шик?\nОстался от барона\nТолько пшик — капут!\n', NULL),
(31, 18, 'Солдат', 1, '5\'nizza (2003) / Unплаггed (2003)', '5\'nizza', '', 'ooh-yeah ooh-yeah ooh-yeah \nЯ — солдат\n    я не спал пять лет, и у меня под глазами мешки,\nЯ cам не видел, \n    но мне так сказали,\nЯ — солдат, и у меня нет башки, мне отбили её сапогами.\nЁ ё ё — комбат орёт, разорванный рот у комбата,\nПотому что граната. \nБелая вата, красная вата не лечит солдата.\n\nПрипев:\n\nЯ — солдат, недоношенный ребёнок войны,\nЯ — солдат, мама, залечи мои раны,\nЯ — солдат, солдат забытой богом страны,\nЯ — герой, скажите мне какого романа.\n[О-о-о-о-о-о-о-о ooh-yeah ooh-yeah  О-о-о-о-о-о-о-о]\n\nЯ — солдат, мне обидно, когда остается один патрон:\nТолько я или он.\nПоследний вагон, самогон, нас таких миллион... в о-о-о-он!\nЯ — солдат, и я знаю свое дело — мое дело стрелять,\nЧтобы пуля попала в тело врага. \nЭта рага для тебя мама-война, теперь ты довольна?\n\nПрипев\n\nI\'m a solJAH, I\'m a solJAH, \nSolJAH - JAH...\n\nПрипев\n', NULL),
(32, 18, 'Давай за...', 2, 'Давай за... (2002)', 'Любэ', '<h3>Что такое ранняя путинская эра (1999-2003)?</h3>\nПоймем по контрасту с ельцинской. В области\n\n      <b>экономики</b>\n — при Ельцине, после экономического <a href=\"роста\" title=\"рост — growth\"><font color=\"#A19D72\">роста</a></font> середины 90-х, дефолт 98-го года вызвал новый кризис, <a href=\"волну\" title=\"волна́ — wave\"><font color=\"#A19D72\">волну</a></font> безработицы, катастрофическую инфляцию. Многие снова потеряли все <a href=\"сбережения\" title=\"savings\"><font color=\"#A19D72\">сбережения</a></font>, а также уверенность в завтрашнем дне.\n<font face=arial> — при Путине, благодаря осторожной финансовой политике и высоким ценам на нефть, <a href=\"снизилась\" title=\"сни́зиться — be reduced\"><font color=\"#A19D72\">снизилась</a></font> инфляция, рубль укрепился, инвестиции росли, росли зарплаты, безработица <a href=\"сократилась\" title=\"сократи́ться — be reduced\"><font color=\"#A19D72\">сократилась</a></font>. <a href=\"Крупный \" title=\"большой\"><font color=\"#A19D72\">Крупный </a></font> государственный  резерв стал основой стабильности и роста. Однако, вдали от Москвы и других крупных городов экономическая ситуация мало изменилась.</font>\n\n      <b><a href=\"преступности\" title=\"престу́пность — crime\"><font color=\"#A19D72\">преступности</a></font>/безопастности граждан</b>\n — при Ельцине бандитизм и преступность надолго парализовали общество. Даже небогатые люди устанавливали <a href=\"стальные\" title=\"стально́й → сталь — steel\"><font color=\"#A19D72\">стальные</a></font> двери в своих квартирах.\n — при Путине преступность начала уходить в подполье. Бандиты не <a href=\"афишировали \" title=\"афиши́ровать — рекламировать\"><font color=\"#A19D72\">афишировали </a></font>свою деятельность. <a href=\"Коррумпированность\" title=\"corruptness\"><font color=\"#A19D72\">Коррумпированность</a></font> властей не уменьшилась, и продолжался ряд громких <a href=\"заказных\" title=\"заказно́й — here, contract\"><font color=\"#A19D72\">заказных</a></font> убийств, часто политических.  Но <a href=\"рядовые\" title=\"рядово́й — common \"><font color=\"#A19D72\">рядовые</a></font> граждане уже не боялись <a href=\"кражей \" title=\"кра́жа — theft\"><font color=\"#A19D72\">кражей </a></font>и разбоя.\n\n      <b>международных отношений</b>\n — при Ельцине мнение России часто игнорировалось крупными мировыми державами. <a href=\"Ощутилась\" title=\"ощутить — почувствовать \"><font color=\"#A19D72\">Ощутилась </a></font> <a href=\"потеря\" title=\"loss\"><font color=\"#A19D72\">потеря</a></font> власти и влияния на мировой арене после <a href=\"распада\" title=\"распа́д — disintegration\"><font color=\"#A19D72\">распада</a></font> Советского Союза.\n — при Путине Россия опять добилась позиции <a href=\"относительного\" title=\"относи́тельный — relative\"><font color=\"#A19D72\">относительного</a></font> авторитета и власти, показала свою военную, политическую <a href=\"мощь\" title=\"сила; власть\"><font color=\"#A19D72\">мощь</a></font>, важность своих богатых природных ресурсов.\n\n      <b>военных действий</b>\n — при Ельцине Россия была вынуждена оставить Чечню в состоянии полунезависимости после <a href=\"позорного\" title=\"позо́рный — shameful\"><font color=\"#A19D72\">позорного</a></font> <a href=\"поражения\" title=\"поражение — defeat\"><font color=\"#A19D72\">поражения</a></font> в войне 1995-96 годов. \n — при Путине, во внешне успешной второй чеченской войне, Россия нанесла огромные потери Чечне, разрушила город Грозный, установила пророссийское правительство. Грубая путинская фраза о террористах стала знаменитой: «мы и в <a href=\"сортире\" title=\"сорти́р — latrine\"><font color=\"#A19D72\">сортире</a></font> их <a href=\"замочим\" title=\"замочи́ть (сленг) ≈ blow them away\"><font color=\"#A19D72\">замочим</a></font>».\n\n      <b>культуры</b>\n — при Ельцине в культуре продолжала царствовать так называемая «чернуха», натуралистически негативный взгляд на страну и жизнь.	\n — при Путине требовалось (иногда явно, иногда только <a href=\"подразумевалось\" title=\"подразумева́ться — to be understood\"><font color=\"#A19D72\">подразумевалось</a></font>) производить «позитив» в новостях, телевидении, кино, музыке.\n	\n      <b>цензуры</b>\n — при Ельцине была свободная пресса. Ельцина критиковали и даже <a href=\"издевались\" title=\"издева́ться над кем/чем — mock, make fun of\"><font color=\"#A19D72\">издевались</a></font> над ним и другими политиками на телевидении. Часто и страстно критиковали страну и ее историю.\n — при Путине возобновилась цензура на телевидении и в крупных газетах (часто <a href=\"путем\" title=\"lit. by way of\"><font color=\"#A19D72\">путем</a></font> <a href=\"отстранения от должности\" title=\"отстране́ние от должности — dismissal\"><font color=\"#A19D72\">отстранения от должности</a></font> <a href=\"провинившихся\" title=\"провини́ться — commit an offense\"><font color=\"#A19D72\">провинившихся</a></font> редакторов или комментаторов). При Путине, как и при Ельцине, журналисты часто становились жертвами заказных <a target=\"_blank\" href=\"http://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%B6%D1%83%D1%80%D0%BD%D0%B0%D0%BB%D0%B8%D1%81%D1%82%D0%BE%D0%B2,_%D1%83%D0%B1%D0%B8%D1%82%D1%8B%D1%85_%D0%B2_%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B8\">убийств</a>.\n\n      <b>политики</b>\nВ 2002-м году еще не был четко виден тот возврат к по существу однопартийной системе государтсвенности, который стал явным на выборах 2003-04.\n\n<i>Возникновение новой волны патриотизма в ранних 2000-х годах было связано со всеми этими фактами. Новый патриотизм <a href=\"поощрялся\" title=\"поощря́ть — encourage\"><font color=\"#A19D72\">поощрялся</a></font> Путиным, его правительством, его партией (\"Единая Россия\") и их молодежной организацией (\"Наши\").</i>\n', 'муз. И. Матвиенко — сл. А. Шаганов\n\nСерыми тучами небо затянуто\nНервы гитарной струною натянуты\nДождь барабанит с утра и до вечера\nВремя застывшее кажется вечностью\nМы наступаем по всем направлениям\nТанки пехота огонь артиллерии\nНас убивают, но мы выживаем\nИ снова в атаку себя мы бросаем\n\n<font face=arial>Давай за жизнь, давай брат до конца\nДавай за тех, кто с нами был тогда\nДавай за жизнь, будь проклята война\nПомянем тех, кто с нами был тогда</font>\n\nНебо над нами свинцовыми тучами\nСтелется низко туманами рваными\nХочется верить, что всё уже кончилось\nТолько бы выжил товарищ мой раненый\nТы потерпи, браток, не умирай пока\nБудешь ты жить ещё долго и счастливо\nБудем на свадьбе твоей мы отплясывать\nБудешь ты в небо детишек подбрасывать\n\nДавай за жизнь, держись, брат, до конца\nДавай за тех, кто дома ждёт тебя\nДавай за жизнь, будь проклята война\nДавай за тех, кто дома ждёт тебя\n\nДавай за них, давай за нас\nИ за Сибирь, и за Кавказ\nЗа свет далёких городов\nИ за друзей, и за любовь\nДавай за вас, давай за нас\nИ за десант, и за спецназ\nЗа боевые ордена\nДавай поднимем, старина\n\nВ старом альбоме нашёл фотографии\nДеда, он был командир красной армии\n«Сыну на память, Берлин 45-го»\nВека ушедшего воспоминания\nЗапах травы на рассвете не скошенной\nСтоны земли от бомбёжек распаханной\nПара солдатских ботинок истоптанных\nВойнами новыми, войнами старыми\n\nДавай за жизнь...\nДавай за тех...\nДавай за жизнь...\nДавай помянем тех, кто с нами был...\n\n(Сверено по альбому 2004-го — \"Военные песни\")', NULL),
(33, 19, 'Молитва Франсуа Вийона', 1, '', 'Булат Окуджава', 'Первоначально эта песня называлась просто \"Молитва\". Она стала называться \"Франсуа Вийон\" и позже \"Молитвой Франсуа Вийона\" по <a href=\" цензурным \" title=\"цензура — censorship\"><font color=\"#A19D72\"> цензурным </a></font> <a href=\" соображениям \" title=\"considerations\"><font color=\"#A19D72\"> соображениям </a></font>. (Впервые текст опубликован в журнале \"Юность\", №12, 1964.) \n\nКак вы думаете, почему было легче публиковать текст под новым названием?\n\n', 'Пока земля еще вертится,\n        пока еще ярок свет,\nГосподи, дай же Ты каждому,\n        чего у него нет:\nмудрому дай голову,\n        трусливому дай коня,\nдай счастливому денег...\n        И не забудь про меня.\n\nПока земля еще вертится, —\n        Господи, твоя власть! —\nдай рвущемуся к власти\n        навластвоваться всласть,\nдай передышку щедрому,\n        хоть до исхода дня.\nКаину дай раскаяние...\n        И не забудь про меня.\n\nЯ знаю: Ты все умеешь,\n        я верую в мудрость Твою,\nкак верит солдат убитый,\n        что он проживает в раю,\nкак верит каждое ухо\n        тихим речам Твоим,\nкак веруем и мы сами,\n        не ведая, что творим!\n\nГосподи мой Боже,\n        зеленоглазый мой!\nПока земля еще вертится,\n        и это ей странно самой,\nпока ей еще хватает\n        времени и огня,\nдай же Ты всем понемногу...\n        И не забудь про меня.\n\nБулат Окуджава.\nПроза и поэзия. Франкфурт: Посев, 1968.\n\n\nДополнительное \'чтение\':\n\n<b>Молитвы и молитва</b>\n\n1. Молитва \"Отче наш\" (славянский текст слева)\n2. Лермонтов, \"Молитва\" (1839)\n3. Тютчев, \"Наш век\" (1851)\n4. Некрасов, \"Влас\" (1855)\n5. Ахматова, \"Молитва\" (Дай мне горькие годы недуги, 1915)\n\n<b>Из истории советского атеизма</b>\n\n6. Обложка первого номера \"Безбожника\" (1923-1941)\n7. Фотографии взрыва Храма Христа Спасителя (1931)\n8. Из книги \"Общество и религия\" (1967)\n\n<b>Кто такой Франсуа Вийон?</b>\n\n9. Из стихов Франсуа Вийона\n10. Осип Мандельштам, эссе \"Франсуа Виллон\", отрывки (1910)\n', NULL),
(34, 20, 'Окурочек (1965)', 1, '', 'Юз Алешковский', 'Юз Алешковский — писатель, ныне живущий в США. Он вынужден был эмигрировать из Совестского Союза после того, как его песни, которые не могли быть напечатаны при советской власти, появились в самиздатском альманахе \"Метрополь\". (Самиздат — рукописные и машинописные издания запрещенной литературы.) В отличие от многих авторов и особенно исполнителей блатных песен, Алешковский действительно сидел (за \"ничтожное, поверьте, уголовное преступление\", как он пишет в замечательной <a target=\'_blank\' href=\'http://www.yuz.ru/live.htm\'>автобиографии</a>).\n\nНо, конечно, не поэтому мы слушаем его песню. А потому, что она также замечательна.', '            Окурочек\n\nСлова и музыка Юза Алешковского\n    \n\n\n                        <i>Вл. Соколову</i>\n\nИз колымского белого ада\nшли мы в зону в морозном дыму.\nЯ заметил окурочек с красной помадой\nи рванулся из строя к нему. \n\n«Стой, стреляю!» — воскликнул конвойный,\nзлобный пес разодрал мой бушлат.\nДорогие начальнички, будьте спокойны,\nя уже возвращаюсь назад. \n\nБаб не видел я года четыре,\nтолько мне наконец повезло —\nах, окурочек, может быть, с «Ту-104»\nдиким ветром тебя занесло. \n\nИ жену удавивший Капалин,\nи активный один педераст\nвсю дорогу до зоны шагали вздыхали,\nне сводили с окурочка глаз.\nС кем ты, сука, любовь свою крутишь,\nс кем дымишь сигареткой одной?\nТы во Внукове спьяну билета не купишь,\nчтоб хотя б пролететь надо мной. \n\nВ честь твою зажигал я попойки\nи французским поил коньяком,\nсам пьянел от того, как курила ты «Тройку»\nс золотым на конце ободком.\nПроиграл тот окурочек в карты я,\nхоть дороже был тыщи рублей.\nДаже здесь не видать мне счастливого фарта\nиз-за грусти по даме червей.\n\nПроиграл я и шмотки, и сменку,\nсахарок за два года вперед,\nвот сижу я на нарах, обнявши коленки,\nмне ведь не в чем идти на развод.\n\nПропадал я за этот окурочек,\nникого не кляня, не виня,\nгоспода из влиятельных лагерных урок\nза размах уважали меня.\n\nШел я в карцер босыми ногами,\nкак Христос, и спокоен, и тих,\nдесять суток кровавыми красил губами\nя концы самокруток своих. \n\n«Негодяй, ты на воле растратил\nмного тыщ на блистательных дам!» —\n«Это да, — говорю, — гражданин надзиратель,\nтолько зря, — говорю, — гражданин надзиратель.\nрукавичкой вы мне по губам...»\n\n1965\n\n\n[С авторского сайта www.yuz.ru]', NULL),
(35, 21, 'Нежность', 1, '', 'Майя Кристалинская', 'Запись 1966-го года. \n\nМузыка Александры Пахмутовой. \nСлова Сергея Гребенникова и Николая Добронравова.', 'Опустела без тебя Земля…\nКак мне несколько часов прожить?\nТак же падает в садах листва,\nИ куда-то всё спешат такси…\nТолько пусто на Земле одной\nБез тебя, а ты…\nТы летишь, и тебе\nДарят звёзды\nСвою нежность…\n\nТак же пусто было на Земле,\nИ когда летал Экзюпери,\nТак же падала листва в садах,\nИ придумать не могла Земля.\nКак прожить ей без него, пока\nОн летал, летал,\nИ все звёзды ему\nОтдавали\nСвою нежность…\n\nОпустела без тебя Земля…\nЕсли можешь, прилетай скорей…\n\n\nДополнительные материалы:\n\n1) Об истории песни\n2) Страница из повести \"Маленький принц\" (Антуан де Сент-Экзюпери. Сочинения. Москва, 1964.)\n', NULL),
(36, 21, 'Гагарин, я вас любила', 2, 'Все пройдет, милая (2002)', 'Ундервуд', 'Советский Союз любит героев. Культ Гагарина, пропагандируемый советской <a href=\"властью\" title=\"= государством \"><font color=\"#A19D72\">властью</a></font>, достигает <a target=\"_blank\" href=\"http://ru.wikipedia.org/wiki/Памятник_Гагарину_на_Ленинском_проспекте\">впечатляющих пропорций</a>. День его исторического полета становится национальным праздником — Днем космонавтики. Образы Гагарина украшают множество плакатов, почтовых марок. \n\nГагарин — подлинный предмет национальной гордости и любви. Искренне позитивное отношение людей к Гагарину отражено, например, в ностальгической песне группы \"Любэ\", <a target=\"_blank\" href=http://www.youtube.com/watch?v=U_AMXxsbdPo>\"Ребята с нашего двора\"</a>.\n\nОднако всеохатывающий официальный почет, как и весь набор официальных лозунгов, вызывает ироническое отношение. \n\nВ 70-х и 80-х годах возникает особый тип иронии, \"стёб\". Это — ирония путем крайнего <a href=\"самоотождествления\" title=\"self-identification\"><font color=\"#A19D72\">cамоотождествления</a></font> с официальным дискурсом, уже никем не <a href=\"принимаемым\" title=\"taken\"><font color=\"#A19D72\">принимаемым</a></font> всерьез. Элементы такой иронии видны в работах соц-арта (ср. картины Виталия Комара и Александра Меламида из серий <a target=\"_blank\" href=\"http://www.komarandmelamid.org/chronology/1972/index.htm\">\"Соц-арт\"</a> и <a target=\"_blank\" href=\"http://www.komarandmelamid.org/chronology/1981_1983/index.htm\">\"Ностальгический соцреализм\"</a>), в песнях группы \"Аквариум\".\n\nВ чистом виде стёб дает чувство принадлежности к <a href=\"ограниченной\" title=\"limited, ср. граница — border\"><font color=\"#A19D72\">ограниченной</a></font> группе \"понимающих\", возможность скрытого <a href=\"глумления\" title=\"глумление — издевательство; mockery\"><font color=\"#A19D72\">глумления</a></font> над официальной культурой и широкими массами, выход за рамки <a href=\"сковывающей\" title=\"constricting\"><font color=\"#A19D72\">сковывающей</a></font> матрицы разрешенного-неразрешенного, <a href=\"идеологической выдержанности\" title=\"выдержанный — в точности следующий каким-нибудь принципам \"><font color=\"#A19D72\">идеологической выдержанности</a></font>-протеста (так как стёб всегда игровая стихия и не вписывается в контекст политического протеста). О стебе подробнее стебется и не стебется Виктор Матизен в статье, \"Стёб как феномен культуры\" (\"Искусство кино\", 1993).\n	\nВ частности, с именем Гагарина связана история российской рэйв-культуры. В декабре 1991-го года, на развалинах СССР устраивается <a target=\"_blank\" href=\"http://l1000.livejournal.com/342407.html\">грандиозное \"Гагарин-party\"</a> в эстетике стёба в космическом павильоне ВДНХ среди летательных аппаратов и с огромным изображением самого Гагарина. \n\n<a href=\"В духе\" title=\"In the spirit\"><font color=\"#A19D72\">В духе</a></font> стёба, но уже в другой эпохе, выполнена следующая песня нашего курса. Это уже ироничный \"пост-стёб\".\n', 'Он обернулся простой такой\nИ белозубый, незнакомый,\nПригладил волосы рукой,\nПока еще не сведен оскомой\nДобрый-добрый рот его,\nНежной-нежной щетиной рыжей\nКасался, пусть бы был никто,\nПрощай, прощай, родной, бесстыжий.\n\nПрипев:\n\nЖизнь била, била, да.\nЖизнь крыла спалила\n\nГагарин, я Вас любила ой лай-лай-лай-лай\nГагарин я вас любила ой лай-лай-лай-лай\nГагарин я вас любила ой лай-лай-лай-лай\nГагарин я вас любила ой \n\nНе знал он после как долго я \nПлыла осколком его медалей\nИ в спину била его струя \nИ жал он молча свои педали.\n\nБольно-больно потом упал,\nРасшибился. Из-под обломков \nИзвлек себя и начертал \nПо фюзеляжу златой иголкой.\n\nПрипев\n\nКак будто правда что млечный путь \nГосподь спустил ему на лампасы\nЕго погоны горят как ртуть \nОн так прекрасен что нас колбасит\nБелым светом наполнен он\nДобрый славный себе смеется\nДуша его как полигон\nЕму светло и ей поется\n\nПрипев\n', NULL),
(37, 22, 'Кукушка', 1, 'До свиданья... (2002)', 'Zемфира', 'Здесь Земфира Рамазанова, одна из самых нашумевших артисток 2000-х, поет песню Виктора Цоя, кумира 80-х. Цой, солист группы \"Кино\", трагически погиб в автокатастрофе в 1990-м году, заснув <a href=\"за рулем\" title=\"at the wheel\"><font color=\"#A19D72\">за рулем</a></font>. Многие тогда подозревали махинации КГБ. По всему Советскому Союзу появились стены с надписями: Витя, мы тебя не забудем! Витя, вернись! Цой жив! Самая знаменитая такая стена на Арбате в Москве.', 'Песен еще не написанных сколько\nСкажи кукушка\nПропой\nВ городе мне жить или на выселках\nКамнем лежать\nИли гореть звездой\nЗвездой\n\nСолнце мое взгляни на меня\nМоя ладонь превратилась в кулак\nИ если есть порох дай огня\nВот так\n\nКто пойдет по следу одинокому\nСильные да смелые головы сложили в поле\nВ бою\nМало кто остался в светлой памяти\nВ трезвом уме да с твердой рукой в строю\nВ строю\n\nСолнце мое взгляни на меня\nМоя ладонь превратилась в кулак\nИ если есть порох дай огня\nВот так\n\nГде же ты теперь воля вольная\nС кем же ты сейчас ласковый рассвет встречаешь\nОтветь\nХорошо с тобой да плохо без тебя\nГолову и плечи терпеливые под плеть\nПод плеть\n\nСолнце мое взгляни на меня\nМоя ладонь превратилась в кулак\nИ если есть порох дай огня\nВот так\n\n[Виктор Цой. Стихи. Документы. Воспоминания. Авторы-сост. Марианна Цой и Александр Житинский. СПб.: Новый геликон, 1991. Сс. 339-340. Поправлено по записи Земфиры Рамазаной.]', NULL),
(38, 23, 'На смерть России', 1, '', 'Катя Яровая', '', 'В каких мирах пристанище отыщет\nИ обретет неведомый от века\nПокой, как сирота или калека,\nВлачившая судьбу, как Божий нищий,\n\nГрехами, как поклажею, навьючена,\nПройдя свой путь от святых дней до лагерей,\nИзодранная проволкой колючей,\nДуша России, бедной Родины моей?\n\nПокрытая и страхом, и проклятьем,\nИ славою минувшей, и позором,\nВ кокошнике, расписанном узором,\nГрозила всему миру рваным лаптем.\n\nМы в душу ей плевали, как умели,\nПытались, как могли, ее спасти.\nИ то, что мы простить ей не посмели,\nВсевышний ей, наверное, простит.\n\nРастерзанная, захлебнувшись кровью,\nКогда испустит дух моя Россия,\nУж не спасешь ни посланным мессией,\nНи Красотой, ни Верой, ни Любовью.\n\nПоднимется на небо черным облаком,\nПроклявших и отрекшихся детей простит,\nШестую часть земли накроет пологом\nИ на прощанье мир перекрестит...\n\n\nДополнительное чтение/слушание:\n1. Михаил Лермонтов, \"Родина\" (Люблю отчизну я, но странною любовью, 1841)\n2. Федор Тютчев, \"Эти бедные селенья\" (1855)\n3. Александр Блок, \"Россия\" (Опять, как в годы золотые, 1908)\n4. Владимир Высоцкий, \"Купола\" (1975). Вот текст песни.\n5. группа ДДТ, \"Родина\" (1988?). А вот текст и этой песни. И недавнее ее исполнение во время протестов на Болотной площади.\n6. письмо Пушкина Петру Чаадаеву. 1836 (к вопросу об историческом предназначении России)\n', NULL),
(39, 24, 'Московская октябрьская', 1, 'Кострома mon amour (1994)', 'Аквариум (Борис Гребенщиков)', '', 'Где ты, душа, осталась,\nсела в какой воронок,\nпокуда тело моталось\nпо миру, как челнок?\nПокуда его носило\nна скорости звуковой\nв вагонах зелено-синих\nна верхней боковой?\n \nГде ты, душа, осталась?\n...А было как наяву:\nпринесли на станцию\nчеловека — и в поезд, в Москву.\nОчнулся ночью, в дороге.\nПоезд уже под Москвой.\nИ едут вперед его ноги\nна верхней боковой.\n \nВот незадача почище\nгоголевской: через два\nчаса будут Мытищи,\nа дальше, понятно, Москва.\nТак что это, шутка злая?\nОткуда и кто такой —\nон едет, куда не зная,\nна верхней боковой. \n\nКачаясь, он вышел в тамбур\nперекурить. В глазах\nмутно, колеса, что тамбур-\nмажор, нагоняют страх.\nОн шел, как слепая лошадь,\nобратно на храп громовой\nв свое прокрустово ложе\nна верхней боковой. \n\nКто он, челнок? Недоумок,\nс улыбочкой жил до ушей.\nИ вот десять клетчатых сумок,\nпривязанных насмерть к душе,\nим брошены в Нижнем Тагиле\nневедомо на кого.\nА он лежит, как в могиле,\nна верхней боковой... \n\nОн думал про душу и поезд.\nДуша, как в последний приют,\nвцепившись в Каменный пояс,\nтянулась — как парашют —\nза ним. Поезда — это стропы.\nНо он тогда — кто такой?\nМусор земной утробы\nна верхней боковой. \n\nО, время вспомнить о маме.\nВремя позвать отца.\nПод потолком что в яме —\nни сердца узнать, ни лица.\nНо в темноте — как будто\nшарик свечи восковой —\nоблак поплыл. Как Будда\nнад верхней боковой. \n\nС башкой утонуть бы в подушке...\nНо вокруг облаков — строй.\nКто виноват? Пушкин?\nА кто всех спасает? Толстой?\nПод небом Аустерлица\nс большой, как земля, головой\nлежит он и сам себе снится\nна верхней боковой. \n\nИ еще ему снится:\nпроснулся внизу сосед,\nв спортивном трико проводница\nидет закрывать туалет.\nМожет быть, в мире кроме\nних — у него никого...\nИ место его в этом доме.\nНа верхней боковой. ', NULL),
(40, 25, 'Выбери меня', 1, 'Выбери меня (2004)', 'Тимур Шаов', 'Тимур Шаов — самый популярный и известный из молодого поколения бардов. Он отличается блестящим <a href=\"остроумием\" title=\"остроу́мие — wit\"><font color=\"#A19D72\">остроумием</a></font> и огромной продуктивностью. В его творчестве заметно влияние разнообразных музыкальных форм, которые вместе с ним виртуозно воспроизводит ряд музыкантов, включая таких постоянных спутников, как Михаил Махович (мандолина) и Сергей Костюхин (гитара, умер в 2012 г.).\n\nОфициальный сайт Шаова можно найти <a target=\"blank\" href=\"http://www.shaov.ru/\">здесь</a>.\n\nВ этом уроке, речь будет идти о политической жизни ельцинского и путинского времени. Советуем перечитать информацию об этом времени в введении к песне \"Давай за...\" (урок \"Война II: 2000-е\").', 'Всё в стране ужасно, всё в стране погано.\nВ высших эшелонах — шум и болтовня:\nБисмарка там нету, нет Шатобриана — \nЗначит, надо, чтобы главным выбрали меня.\n\nCразу наших олигархов разведу я круто,\nСоберу их вместе и скажу: «Даёшь!»\nИ скажу: «Сдавайте, граждане, валюту!\nУ меня народ не кормлен, начался падёж!»\n\nСам кристально честен и сакрально чистый,\nЛично б сеял жито, лез в шахтёрский штрек —\nИ меня б любили даже коммунисты.\nСамый человечный был бы человек!\n\nВорам и мздоимцам — бить по пяткам палкой!\nУтоплю бандитов, как слепых котят,\nА ментов не трону, потому что жалко.\nЧто, менты — не люди? Тоже есть хотят! \n\nЯ призрел бы сирых, утешал страдальцев,\nКак Ильич, встречал бы чаем ходоков.\nА гимном я бы сделал песенку про зайцев —\nЧуть её подправит старший Михалков.\n\nЯ скажу министрам: «Что за волокита?\nДо сих пор у граждан нету ни шиша!\nВсем читать Прудона и Адама Смита!\nВ общем, чтобы к Пасхе обогнали США!»\n\nАх, каким я славным президентом стану!\nЯрким как Людовик, мудрым как де Голль!\nВсюду будут скверы, парки и фонтаны.\nСлушать будем «Битлз», кушать алкоголь!\n\nНас бы уважали и арабы, и евреи,\nБуш бы за советом в Кремль приезжал:\nДескать, можно мы немного побомбим Корею?\nА я бы средний палец Бушу показал!\n\nА потом, конечно, стану я тираном —\nСтарая, простая, верная стезя, —\nРазгоню парламент, посажу смутьянов.\nНо, здесь уже традиций нарушать нельзя!\n\nИ потом, ведь любят на Руси тиранов.\nТак оно привычней, что ни говори.\nЯ возьму державу, скипетр из Гохрана —\nИ меня Шандыбин выкрикнет в цари.\n\nОц-тоц, хорошо! Буду самым главным!\nБудет голос зычен, а рука тверда.\nБоже, меня храни! Сильный, державный!\nХотели как лучше, а выйдет как всегда!\n\nВласть, конечно, сильно портит человека.\nНе пойду во власть я — мне она вредна.\nИ к тому же вряд ли выберут чучмека,\nТак что спи спокойно, родная страна!\n\n\n<h4>Дополнительные материалы по теме:</h4>\n<i>Сатира и цензура в путинсую эпоху</i>\n\n1. \"Куклы\" (телевизионный проект Виктора Шендеровича). Данный эпизод один из последних перед разгромом телеканала НТВ.\n2. Денис Фрунзе. \"The Independent: \"Не надо рисовать Путина...\" Российская власть боится сатиры\".\n3. Сергей Ковалев (первый Уполномоченный РФ по правам человека). Открытое письмо В.В. Путину и др. после выборов в Государственную Думу 2003 г. \n\n<i>Сатира в русской истории</i>\n\n4. \"Куклы\" времени Ельцина. \"Шамиль Басаев, говори громче\" (о первой чеченской войне)\n5. Сатирический киножурнал \"Фитиль\" \"Трудная задача\" (1971)\n6. Анонимное стихотворение \"Разговор в царстве мертвых, носившийся в народе 1801 года\"\n\n<i>Выборы 2011-12 года</i>\n\nСтратегия \"Нах-нах\"\nБолотная площадь\n\"Гражданин поэт\" (стихи Дмитрия Быкова читает Михаил Ефремов), 05.12.11', NULL);
INSERT INTO `song` (`id`, `unit_id`, `title`, `weight`, `album`, `artist`, `description`, `lyrics`, `embed`) VALUES
(41, 26, 'На верхней боковой', 1, 'На верхней боковой. Книга песен (2004)', 'Григорий Данской', '', 'Где ты, душа, осталась,\nсела в какой воронок,\nпокуда тело моталось\nпо миру, как челнок?\nПокуда его носило\nна скорости звуковой\nв вагонах зелено-синих\nна верхней боковой?\n \nГде ты, душа, осталась?\n...А было как наяву:\nпринесли на станцию\nчеловека — и в поезд, в Москву.\nОчнулся ночью, в дороге.\nПоезд уже под Москвой.\nИ едут вперед его ноги\nна верхней боковой.\n \nВот незадача почище\nгоголевской: через два\nчаса будут Мытищи,\nа дальше, понятно, Москва.\nТак что это, шутка злая?\nОткуда и кто такой —\nон едет, куда не зная,\nна верхней боковой. \n\nКачаясь, он вышел в тамбур\nперекурить. В глазах\nмутно, колеса, что тамбур-\nмажор, нагоняют страх.\nОн шел, как слепая лошадь,\nобратно на храп громовой\nв свое прокрустово ложе\nна верхней боковой. \n\nКто он, челнок? Недоумок,\nс улыбочкой жил до ушей.\nИ вот десять клетчатых сумок,\nпривязанных насмерть к душе,\nим брошены в Нижнем Тагиле\nневедомо на кого.\nА он лежит, как в могиле,\nна верхней боковой... \n\nОн думал про душу и поезд.\nДуша, как в последний приют,\nвцепившись в Каменный пояс,\nтянулась — как парашют —\nза ним. Поезда — это стропы.\nНо он тогда — кто такой?\nМусор земной утробы\nна верхней боковой. \n\nО, время вспомнить о маме.\nВремя позвать отца.\nПод потолком что в яме —\nни сердца узнать, ни лица.\nНо в темноте — как будто\nшарик свечи восковой —\nоблак поплыл. Как Будда\nнад верхней боковой. \n\nС башкой утонуть бы в подушке...\nНо вокруг облаков — строй.\nКто виноват? Пушкин?\nА кто всех спасает? Толстой?\nПод небом Аустерлица\nс большой, как земля, головой\nлежит он и сам себе снится\nна верхней боковой. \n\nИ еще ему снится:\nпроснулся внизу сосед,\nв спортивном трико проводница\nидет закрывать туалет.\nМожет быть, в мире кроме\nних — у него никого...\nИ место его в этом доме.\nНа верхней боковой. ', NULL),
(42, 27, 'Американская жена', 1, 'Кадры из фильма Валерия Тодоровского ', 'ВИА Гра', 'Что важнее для вас, карьера или <a href=\"тусовка\" title=\"группа людей, которые общаются, развлекаются вместе; также их встречи, общение\"><font color=\"#A19D72\">тусовка</a></font>? Возможно иметь и то, и другое? <a href=\"Исключают\" title=\"exclude\"><font color=\"#A19D72\">Исключают</a></font> ли друг друга некоторые тусовки и карьеры? Или всегда можно их соединить?\n\nВ Советском Союзе, эти вопросы стояли особенно остро. Продвижение по карьерной лестнице было возможно только для членов коммунистической партии, и выбор, вступить ли в партию, вставал перед сотнями тысяч людей. Люди, принадлежащие к контркультуре 50-х, 70-х, 80-х годов, жертвовали социальным статусом и <a href=\" материальными благами\" title=\"material comforts\"><font color=\"#A19D72\">материальными благами</a></font>, могли попасть под <a href=\"суд\" title=\"trial\"><font color=\"#A19D72\">суд</a></font>. (Часто людей искусства судили за тунея́дство — жизнь за счёт чужого труда, то есть, за то, что они не имели \"настоящей\", официально признанной работы.) \n\n', 'Припев:\nЕму не нужна американская жена!\nЕму не нужна американская жена!\nЕму не нужна американская жена!\n\nМой милый дружок, уезжаешь — прощай!\nТебя я любила всегда беззаветно.\nТы мне показал новый мир, новый рай,\nА сам покидаешь его незаметно.\n\nТы будешь советский, простой дипломат,\nКак будто о прошлом ты все позабыл,\nНо мы-то по-прежнему ждем тебя, брат,\nВ душе ты стиляга, такой же, как был.\n\n<i>Припев</i>\n\nПусть в угол летят дорогие шузы,\nПусть кок не сверкает уже бриолином,\nНо я не пролью ни единой слезы,\nПрощай, мой любимый, любимый мужчина!\n\nТвой выбор понятен; смелее, чувак,\nЗа папочкой вслед, на большую дорогу.\nМне жаль, что уходишь ты именно так!\nПрости, мы другие, другие немного...\n\n<i>Припев</i>\n\nТы многое сможешь взамен получить\nОт щедрой чувихи, что жизнью зовется,\nНо только свободным тебе уж не быть\nИ стильная молодость вряд ли вернется.\n\n<i>Припев</i>\n\n\n<u>Дополнительные материалы:</u>\n\n1) Из книги Алексея Козлова \"Джазист\" (\"Козел на саксе\")\n2) Из книги Василия Аксенова \"В поисках грустного бэби\"\n3) Советуем посмотреть: фильм Валерия Тодоровского \"Стиляги\"', NULL),
(43, 27, 'Я остаюсь', 2, 'Кадры из фильма Валерия Тодоровского ', 'ВИА Гра', 'Что важнее для вас, карьера или <a href=\"тусовка\" title=\"группа людей, которые общаются, развлекаются вместе; также их встречи, общение\"><font color=\"#A19D72\">тусовка</a></font>? Возможно иметь и то, и другое? <a href=\"Исключают\" title=\"exclude\"><font color=\"#A19D72\">Исключают</a></font> ли друг друга некоторые тусовки и карьеры? Или всегда можно их соединить?\n\nВ Советском Союзе, эти вопросы стояли особенно остро. Продвижение по карьерной лестнице было возможно только для членов коммунистической партии, и выбор, вступить ли в партию, вставал перед сотнями тысяч людей. Люди, принадлежащие к контркультуре 50-х, 70-х, 80-х годов, жертвовали социальным статусом и <a href=\" материальными благами\" title=\"material comforts\"><font color=\"#A19D72\">материальными благами</a></font>, могли попасть под <a href=\"суд\" title=\"trial\"><font color=\"#A19D72\">суд</a></font>. (Часто людей искусства судили за тунея́дство — жизнь за счёт чужого труда, то есть, за то, что они не имели \"настоящей\", официально признанной работы.) \n\n', 'Припев:\nЕму не нужна американская жена!\nЕму не нужна американская жена!\nЕму не нужна американская жена!\n\nМой милый дружок, уезжаешь — прощай!\nТебя я любила всегда беззаветно.\nТы мне показал новый мир, новый рай,\nА сам покидаешь его незаметно.\n\nТы будешь советский, простой дипломат,\nКак будто о прошлом ты все позабыл,\nНо мы-то по-прежнему ждем тебя, брат,\nВ душе ты стиляга, такой же, как был.\n\n<i>Припев</i>\n\nПусть в угол летят дорогие шузы,\nПусть кок не сверкает уже бриолином,\nНо я не пролью ни единой слезы,\nПрощай, мой любимый, любимый мужчина!\n\nТвой выбор понятен; смелее, чувак,\nЗа папочкой вслед, на большую дорогу.\nМне жаль, что уходишь ты именно так!\nПрости, мы другие, другие немного...\n\n<i>Припев</i>\n\nТы многое сможешь взамен получить\nОт щедрой чувихи, что жизнью зовется,\nНо только свободным тебе уж не быть\nИ стильная молодость вряд ли вернется.\n\n<i>Припев</i>\n\n\n<u>Дополнительные материалы:</u>\n\n1) Из книги Алексея Козлова \"Джазист\" (\"Козел на саксе\")\n2) Из книги Василия Аксенова \"В поисках грустного бэби\"\n3) Советуем посмотреть: фильм Валерия Тодоровского \"Стиляги\"', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `songs_media`
--

CREATE TABLE `songs_media` (
  `song_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `songs_media`
--

INSERT INTO `songs_media` (`song_id`, `media_id`) VALUES
(1, 4),
(2, 5),
(10, 11);

-- --------------------------------------------------------

--
-- Table structure for table `student_registrations`
--

CREATE TABLE `student_registrations` (
  `id` int(11) NOT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `prof_registration_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` int(11) NOT NULL,
  `date_deleted` int(11) DEFAULT NULL,
  `date_start` int(11) NOT NULL,
  `date_end` int(11) NOT NULL,
  `signup_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_registrations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_registrations`
--

INSERT INTO `student_registrations` (`id`, `designer_id`, `class_id`, `prof_registration_id`, `name`, `date_created`, `date_deleted`, `date_start`, `date_end`, `signup_code`, `max_registrations`) VALUES
(1, 5, 1, 1, 'CHIN 3002 A', 1488417872, NULL, 0, 1497057872, 'studentregistration1-XK783', 2),
(2, 5, 2, 1, 'CHIN 3002 B', 1488417872, NULL, 0, 1497057872, 'studentregistration2-9UIO3', 40),
(3, 5, 3, 2, 'CHIN 3002 C', 1488417872, NULL, 0, 1497057872, 'studentregistration3-AKFIU', 30),
(4, 6, 4, 3, 'JAPN 3001 A', 1488417872, NULL, 100000, 111111, 'studentregistration4-A143U', 4),
(5, 6, 5, 3, 'JAPN 3001 B', 1488417872, NULL, 100000, 111111, 'studentregistration5-93FSD', 3),
(6, 6, 6, 4, 'JAPN 4361 A', 1488417872, NULL, 0, 1497057872, 'studentregistration5-93FSD', 1),
(7, 6, 7, 5, 'JAPN 4215 A', 1488417872, NULL, 0, 1497057872, 'studentregistration6-4215C', 15),
(8, 19, 8, 6, '', 1492972647, NULL, 1491523200, 1495584000, 'a7c7d840a84cf567e04225cdfc2a3e8d', 20);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `course_id`, `name`, `description`, `weight`) VALUES
(2, 3, 'Unit 3 - 4361', 'Modern Japan', 3),
(3, 3, 'Unit 2 - 4361', 'Historic Japan', 2),
(4, 1, 'Unit 1 - CHINESE 3002', 'THIS DOES NOT BELONG TO 4361', 10),
(6, 3, 'Unit 1 - 4361', 'Introduction to Syllabus', 1),
(8, 4, 'Unit 2 - 民謡\n', '民謡を使って、21世紀までの文化と歴史を少し勉強しましょう。\n\nシューリンガンのグーリンダイ、五劫の擦り切れ、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの。食う寝る処に住む処。長久命の長助。長久命の長助、寿限無、寿限無、水行末 雲来末 風来末、海砂利水魚の、海砂利水魚の、食う寝る処に住む処。グーリンダイのポンポコピーのポンポコナーの、シューリンガンのグーリンダイ、水行末 雲来末 風来末。\n\n寿限無、寿限無。シューリンガンのグーリンダイ。パイポパイポ パイポのシューリンガン。長久命の長助、食う寝る処に住む処、食う寝る処に住む処、海砂利水魚の、グーリンダイのポンポコピーのポンポコナーの、やぶら小路の藪柑子、やぶら小路の藪柑子。\n\nパイポパイポ パイポのシューリンガン、水行末 雲来末 風来末、食う寝る処に住む処、長久命の長助。グーリンダイのポンポコピーのポンポコナーの、海砂利水魚の。やぶら小路の藪柑子、五劫の擦り切れ、寿限無、寿限無、水行末 雲来末 風来末、寿限無、寿限無、海砂利水魚の、シューリンガンのグーリンダイ。\n\nシューリンガンのグーリンダイ。食う寝る処に住む処。食う寝る処に住む処、水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの、パイポパイポ パイポのシューリンガン。シューリンガンのグーリンダイ。\n\n五劫の擦り切れ。寿限無、寿限無、長久命の長助、長久命の長助。グーリンダイのポンポコピーのポンポコナーの。水行末 雲来末 風来末、シューリンガンのグーリンダイ、食う寝る処に住む処、グーリンダイのポンポコピーのポンポコナーの、水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン。海砂利水魚の。パイポパイポ パイポのシューリンガン。寿限無、寿限無。やぶら小路の藪柑子。\n\nパイポパイポ パイポのシューリンガン、長久命の長助。やぶら小路の藪柑子、五劫の擦り切れ。やぶら小路の藪柑子。パイポパイポ パイポのシューリンガン、食う寝る処に住む処。グーリンダイのポンポコピーのポンポコナーの、食う寝る処に住む処、海砂利水魚の。シューリンガンのグーリンダイ。\n\n五劫の擦り切れ、やぶら小路の藪柑子。グーリンダイのポンポコピーのポンポコナーの。長久命の長助。やぶら小路の藪柑子。海砂利水魚の。海砂利水魚の、パイポパイポ パイポのシューリンガン。五劫の擦り切れ、寿限無、寿限無。パイポパイポ パイポのシューリンガン。食う寝る処に住む処。水行末 雲来末 風来末、シューリンガンのグーリンダイ。グーリンダイのポンポコピーのポンポコナーの、シューリンガンのグーリンダイ。水行末 雲来末 風来末。長久命の長助、寿限無、寿限無。\n\n海砂利水魚の、パイポパイポ パイポのシューリンガン。グーリンダイのポンポコピーのポンポコナーの。五劫の擦り切れ、水行末 雲来末 風来末。やぶら小路の藪柑子。長久命の長助。寿限無、寿限無。パイポパイポ パイポのシューリンガン。海砂利水魚の、シューリンガンのグーリンダイ。水行末 雲来末 風来末。', 2),
(9, 4, 'Unit 3 - 現代の歌\n', '21世紀に作った人気な曲を見ましょう。これらの曲は世話にインパクトした。 \n\n毛御個りゆにほえぬ野遊氏区あゃいきえんこめっのな他日らねぬろゅ氏擢他遊毛日ひむうたも夜魔舳絵等鵜他さらくけこ課留目以あるお瀬派等ね。ゃおい。へくつへケケオ他舳以素絵、の。ょ譜露目列よたまにきに尾露日露かょつすらなゃむはか露手離等差津、えたホサレノいほ素無よんに目毛露つそょ差ゆのンミすへめ他離遊りふにつ鵜派あ日差。\n\n区二以ゃっょ日他そ区派魔御めか、まおいさヨレにのゆ。のおりよちねはほひ野毛列雲か遊手さりさて根うむ遊離ほほうねヒクュロッ差雲津絵阿ま差樹ろう尾鵜以ころにろや二夜雲。るむ知無等譜保樹し素、以二樹といゅ他。\n\nそかゆこょゅハハ野尾るけんれ以他二絵ちのはすろこ瀬遊こう根等れもりう樹留派列そけ氏尾他の擢鵜保屋ニソモヤむそ。てそら、ほやて擢課御擢離留露譜都ほうせや、ひせひシエスャラタ目留名ゃもなえさらむさら以区尾も手夜都や瀬以尾二差列魔へょ氏魔魔雲にる擢瀬野課等雲まコウツん舳模他擢な以津離知無留めそんきらね絵派目魔す御以留り屋手スユネ素雲他目日差へくおねも他区。ふてん屋ねせ知樹ふよ無くてお。\n\nむたアネハチュよそん氏無ぬちしりう等夜巣差差そねせり野目等はと毛絵すしてそや瀬課魔手。夜鵜保尾氏派、な御御よ、め鵜譜、根離マーナチアサはつ毛と他雲津二夜根等露知きやき派手名派ソコャネカイし二巣以い。\n\n瀬列、しゆふ知列氏無巣魔ぬそ模根留氏氏個よん派都露模派保離日日差さ遊ノコンモ瀬、つろもしひ模区以巣名野テウヤ留う譜巣津ちち津魔うょ、れなみぬ絵阿屋無、個遊っなつもせ区離氏二野擢無尾手鵜かカアョらさ阿保他列。\n\n巣夜課根ありめあハッハフゆやみの。せすとへ魔。、めよろかうにそさぬし、くちあはむ派御ンタムンメテ二知津、野絵氏区日ュエク。ん、ヌリチホ絵課む阿尾魔野課氏屋夜目、ナシュヘヤめむす。ゅひまにほめつたせあやよゃま巣夜目区メリリアヘノ尾。\n\n屋御むゅ知ゅみん課模留課くえ津遊留瀬擢雲日むさねんうや。とのんぬ樹課るっょう御譜。絵模せぬふやッソムクノつてろょとりり差毛都目等「目素遊」おやんてけあま尾派知譜。、二津にほくねゆ、ほてけんレンスケっゃ。\n\n無等ろあしめあらいりい根樹他氏区瀬氏氏お日瀬み樹名ゅつゆりちちととふしな模津留等み課留ゃ無絵なさつへ御絵、ョヤあうけい雲課列ソオツサエモヒこ夜以きねぬゃち、ふえひ列夜ねふふやさやゃぬ名魔御派にめんむれけ野差知阿日あせめふ阿列にけつはせしゅ毛露津譜るあにそくけ。舳目、へっ日御、毛巣かぬし御素留鵜御都夜。\n\n毛列派ら。区鵜等課目露保留もこ目譜知鵜遊擢はてと舳露派尾氏「ふんっろりせひっま」離尾派派離樹舳離ねはて遊露絵根舳毛津露の鵜根瀬素しくのなイトホナネ。れさらに絵舳日氏お差無津巣目列野鵜模遊ょてるんゅんひ夜留て等擢津津根魔巣課無列瀬鵜列し知知離、こえんす。\n\nへゅらは。派等知夜レルメなょ譜派擢目樹。おたぬなひちあ派てよさ都日ハタク手課津留個他も、へ舳瀬やほつね尾露知うもみれっえぬ巣遊樹絵尾てて毛無列離ゃへ等夜屋むぬる派おゃョコネ個手課、等遊遊譜樹個阿他根目二留無保尾派遊等区離なうた樹なあっまこむす露ゅへせ日課遊絵ゆちけ樹課氏。', 3),
(10, 4, 'Unit 4 - 現代の映画\n', '21世紀に作った人気な映画をみて、映画のテーマとメッセージを話します。\n\n海砂利水魚の。パイポパイポ パイポのシューリンガン。寿限無、寿限無。やぶら小路の藪柑子。水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン。シューリンガンのグーリンダイ、寿限無、寿限無、五劫の擦り切れ。\n\n長久命の長助。パイポパイポ パイポのシューリンガン、食う寝る処に住む処。五劫の擦り切れ。やぶら小路の藪柑子、シューリンガンのグーリンダイ、やぶら小路の藪柑子。水行末 雲来末 風来末、寿限無、寿限無、グーリンダイのポンポコピーのポンポコナーの。食う寝る処に住む処、水行末 雲来末 風来末、パイポパイポ パイポのシューリンガン、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの。', 4),
(11, 5, 'Введение: How to Use These Materials', '<br><font size=4><b>Добро пожаловать на наш курс!</b></font> \n\nThe materials offered on this website are designed to fit a range of advanced students of Russian.  In using them, you will expand your knowledge of Russian while learning about some of the key problems and issues that have vexed and fascinated Russians for the last century or more.    \n\nIf you are a truly advanced student (ACTFL Advanced or ILR 2 and higher)* and have spent significant time in-country, you will find lots of contextual content to enrich your understanding of Russian music and culture and to challenge you linguistically. Your goal should be to achieve near 100% comprehension of each main song and to achieve as close to native understanding of the cultural context of the songs as possible. Writing assignments are given without prescriptions in terms of length or complexity. Be adventurous and challenge yourself!\n\nIf you are an intermediate- to advanced-level student who has fulfilled prerequisites for a fourth-year course primarily through on-campus courses in your home country with no sustained period of Russian-language immersion, you will also benefit greatly from these materials. Your goal should be to find the requested information in the listening exercises, work toward full comprehension of the main unit song(s) with the help of the lyrics and annotations, and get as much out of the contextual materials as your linguistic level allows you. In general, do as much as you can, and in confronting new vocabulary, concentrate on words you feel you will need and use in the future. \n\nRegardless of your level: listen repeatedly and listen deeply, not only to the main song, but also to the suggestions for further listening. We suggest listening for at least 15 minutes to each main song, rewinding when you encounter difficult passages, before you look at the words. When you reach the “suggestions for further listening” (Что слушать дальше!), you may want to listen to a portion of each song first and then pick one or two that interest you and listen to them more carefully.\n\nIn order to play the .ogg format audio and video, you will have to use Firefox, Opera or Google Chrome. (Internet Explorer has promised support, but not in this version.) We’ve chosen this audio format because of the high quality media player it allowed us to use.  \n\nNote that as you use the \"bubble pointer\" to rewind and fast-forward, you can see the number of seconds of the song that have elapsed. This will make it easy to rewind 3 or 5 seconds in order to hear a specific phrase again and generally to access a particular place in the song. In parsing a mysterious passage, think about what might fit. What parts of speech/cases does the grammar imply. What sort of word(s) would you expect given the context?  \n\nMost importantly: have fun, and sing along! Impress your friends with your spot-on Vysotsky imitation! There is no better way to achieve excellent pronunciation than to mimic singers. Strive to repeat their individual manner of pronunciation, their intonation, their idiosyncracies. \n\nYou won’t regret the time you spend with these songs. They are capacious vessels for Russian culture, and if you manage to internalize them, you will have gained a resource that will enrich your understanding of and appreciation for Russia for the rest of your life. \n\nAs the song says: Кто с песней по жизни шагает, тот никогда и нигде не пропадет! Regardless of how we feel about the ideological framework of the Stalin-era anthem from which this phrase was taken, it’s hard to disagree with that sentiment.\n\n\nMore information, for instructors and interested students, on using these materials can be found <a target=\"blank\" href=\"http://www.prism.gatech.edu/~sg185/Instructor\'s_Guide.pdf\">here</a>.\n\n', 1),
(12, 5, 'Как сдавать домашнюю работу...', '<br><font size=4><b>Preferred method for homework submission (Georgia Tech):</font></b><br>\nFor each day of class, create one Microsoft Word document to submit to your professor.  Type your name at the top.<br>\nAfter completing each assigned exercise, click on the “Print or Save” or “Check Answers” button at the bottom of the page.<br>\nFor the first exercise attached to any given song, on the Print/Save formatted page which opens, “select ALL,” copy and paste directly into the Word document.  Save according to your professor’s directions: for instance, “Lastname Anti-skazka 1” (i.e., first day of homework for Anti-skazka unit).<br>\nFor subsequent exercises relating to the same song, select the text <b>beginning with the name of the exercise</b> (not the name of the song).  <i>This will save a lot of paper!</i>  Copy and paste into the Word document immediately below the previous exercise.<br>\nOpen writing assignments (Темы для сочинений) should be completed directly in the Microsoft Word document.<br>  \nSuggestion: resave the Word document after pasting each exercise.  While the tab with your completed exercise will not disappear until you close it, your work is NOT saved on the server.<br>\nWhen your work for the day is complete, hand in according to professor’s instructions: print OR save and email OR upload to course website, etc.<br>\nNote that when submitting your work as described above, you can also review the day’s homework and make any necessary edits directly in the Word document.<br><br>\n<b><font size=4>Other homework submission methods:</font></b><br>\n    1)  Each page can be saved separately using the “Save Page As” function in your browser.  The file name automatically includes the name of the song and exercise.  These can be submitted electronically, and your professor can open them in Microsoft Word (using the “Open With” function) to add comments.<br>\n    2)  Each page can be printed separately.<br>', 2),
(13, 5, '(Анти-)сказка', 'Начнем со сказки... не то, чтобы традиционной. Но, может быть, эта сказка связана с Россией сильнее, чем кажется...\n\n\n\n\n\n\n', 3),
(14, 5, 'Цыганская песня', '<h4>(Очень) кратко о месте цыган (Gypsies) в <i>русской</i> культуре:</h4> \n→ В конце XVIII века русские аристократы собирают хоры из <a href=\"крепостных\" title=\"крепностно́й — n., adj: serf\"><font color=\"#A19D72\">крепостных</a></font> цыган.\n\n→ В XIX веке цыганская музыка (включая и русские романсы в исполнении цыган) становится <a href=\"неотъемлемой\" title=\"inalienable\"><font color=\"#A19D72\">неотъемлемой</a></font> частью русской, особенно ресторанной, культуры.\n\n→ Образ аристократа или <a href=\"купца\" title=\"merchant\"><font color=\"#A19D72\">купца</a></font>, кутящего (кутёж — большая, шумная попойка) под аккомпанемент целого <a href=\"табора\" title=\"та́бор — gypsy encampment\"><font color=\"#A19D72\">табора</a></font> нанятых цыган — <a href=\"штамп\" title=\"cliché\"><font color=\"#A19D72\">штамп</a></font> XIX века. (Может быть, самый знаменитый пример — Дмитрий Карамазов в романе Достоевского.)\n\n→ Возникают стереотипы. Русские видят в цыганских песнях \"непосредственность\", \"страсть\", \"задушевность\". Цыгане ассоцируются у них с обманом и дикостью, а также и с волей (стихийной свободой).\n\n→ Цыгане входят в русскую литературу. Из основополагающих произведений — поэма Пушкина \"Цыганы\", стихотворения Аполлона Григорьева \"Две гитары\", \"О, говори хоть ты со мной\".\n\n→ После революции цыгане считаются народом-меньшинством, подлежащим и защите, и <a href=\"насильственному\" title=\"наси́льственный — through force\"><font color=\"#A19D72\">насильственному</a></font> \"развитию\". Вместе с музыкальной культурой других народов-меньшинств, цыганская культура санкционируется сверху, разыгрывается на праздниках в \"традиционных\" формах. (Поиск в Youtube \"Цыганочки\" легко их выявляет.) В то же время, знаменитый театр \"Ромэн\" в Москве становится местом приобщения к подлинной цыганской культуре.\n\n→ В России сегодня, как и в прошлом, рома — так цыгане называют себя — работают в разнообразных отраслях и профессиях. Российские рома были среди первых в мире, публиковавших книги на своем языке.', 4),
(15, 5, 'Ретро: популярная музыка 30-х годов', 'Джаз и танго... Вы \"ретро\" любите?', 5),
(16, 5, 'Гимн', 'В Америке есть один гимн, принятый официально в 1931 году (\"Звездное знамя\").\n\nВ России дело обстоит немного сложнее. В России сменилось уже девять гимнов... Не от легкой жизни, как говорят.\n\nНовые гимны часто создавались с оглядкой на старые гимны или на их основе (но в новой политической <a href=\"обстановке\" title=\"circumstances, situation\"><font color=\"#A19D72\">обстановке</a></font>). Последний российский гимн написан одним из соавторов сталинского гимна и на ту же музыку!\n\nВот гимны России. В этом уроке мы сосредоточимся на гимне №7.\n\n1) <a target=\"_blank\" href=\"http://youtu.be/y4FMyIjrrAA\">\"Молитва русских\" (Боже царя храни)</a> (ок. 1815, м. Генри Кэри [\"God Save the King\"], сл. Василия Жуковского)\n2) <a target=\"_blank\" href=\"http://youtu.be/mejgZ5SNxZs\">\"Боже царя храни\"</a> (1833, м. Алексея Львова, сл. Василия Жуковского)\n2а) <a target=\"_blank\" href=\"http://youtu.be/f-9TOHwxPHM\">Хор \"Славься\"</a> (м. Михаила Глинки из оперы \"Жизнь за царя\", сл. Егора Розена). Неофициальный гимн дома Романовых.\n3) <a target=\"_blank\" href=\"http://youtu.be/hxPMLkJqv0U\">\"Рабочая марсельеза\"</a> (1917 [гимн при Временном правительстве после февральской революции], м. Клода Жозефа Руже де Лиля [1792], русский текст Петра Лавровича Лаврова [1875])\n4) <a target=\"_blank\" href=\"http://youtu.be/fpvwh292VKI\">\"Интернационал\"</a> (ок. 1918, сл. Эжена Потье [1871], м. Пьера Дегейтера [1888], перевод Аркадия Коца [1902, 1931])\n5) <a target=\"_blank\" href=\"http://youtu.be/oY_N-nK8yWs\">Гимн СССР</a> (1944, м. Александра Александрова, сл. Сергея Михалкова и Эль-Регистана)\n6) <a target=\"_blank\" href=\"https://youtu.be/D5AQlDNwHlc\">Гимн СССР</a> (1955, без слов, м. Александра Александрова)\n7) <a target=\"_blank\" href=\"https://youtu.be/cNNMlwzJ6qU\">Гимн СССР</a> (1977, м. Александра Александрова, сл. Сергея Михалкова и Эль-Регистана)\n8) Гимном РСФСР избрана <a target=\"_blank\" href=\"https://youtu.be/yrol0fUUtyU\">\"Патриотическая песня\"</a> (сент. 1990, без слов, м. Михаила Глинки [автора музыки гимна № 2а])\n8а) Указом Ельцина утверждена \"Патриотическая песня\" Глинки в качестве Гимна Россиийской Федерации (дек. 1993).\n9) <a target=\"_blank\" href=\"http://youtu.be/-dHUAZydTQ4\">Гимн России</a> (2000, м. Александра Александрова, сл. Сергея Михалкова)\n\nТексты гимнов прошлого можно найти <a target=\"_blank\" href=\"https://ru.wikipedia.org/wiki/История_гимна_России\">здесь</a>).', 6),
(17, 5, 'Война I: Великая Отечественная война', 'История России в XX веке полна знаменательных событий, часто кровавых, навсегда и радикально изменивших жизнь миллионов людей.\n\nРусско-японская война (1904)\nРеволюция 1905-го года (начавшаяся кровавым подавлением <a href=\"шествия\" title=\"procession\"><font color=\"#A19D72\">шествия </a></font> народа к царю и закочившаяся введением конституции, вскоре <a href=\"попранной\" title=\"trampled\"><font color=\"#A19D72\">попранной</a></font> царской властью)\nПервая мировая война (1914-1917)\nФевральская революция (1917)\nОктябрьская революция (1917)\nГражданская война (1918-1921)\nКоллективизация и голод\nИндустриализация\nЧистки (ежовщина, Большой террор) 1936-1938 годов\nВеликая Отечественная (Вторая мировая) война (ВОВ, 1941-45)\nХолодная война\n<a href=\"Оттепель\" title=\"the Thaw\"><font color=\"#A19D72\">Оттепель</a></font>\n<a href=\"Застой\" title=\"Stagnation\"><font color=\"#A19D72\">Застой</a></font>\nАфганская война\nПерестройка\nРаспад СССР\n«Дикие», посткоммунистические 90-е годы (экономическая «шок-терапия» и <a href=\"нищета\" title=\"крайняя бедность\"><font color=\"#A19D72\">нищета</a></font> многих людей, <a href=\"разгул\" title=\"rampancy, raging\"><font color=\"#A19D72\">разгул</a></font> преступности, распад системы социальной защиты граждан, конституционный кризис и бои в Москве в октябре 1993-го, первая Чеченская война, дефолт 1998-го года)\n \nСреди этих событий выделяется Великая Отечественная война. Огромные коллективные <a href=\"жертвы\" title=\"жертва — sacrifice\"><font color=\"#A19D72\">жертвы </a></font> советского народа, героическая роль Красной армии и рядовых советских солдат в освобождении Европы — это, пожалуй, единственное, о чем cходились во мнениях все в Советском Союзе. \n\nЕсть фильмы и песни о войне. Есть фильмы и песни войны. Песни этого урока из второй группы. Здесь мы узнаем, что пели и слушали в Советском Союзе в годы войны, во время самых тяжелых <a href=\"испытаний\" title=\"испытание — жизненные трудности, trial\"><font color=\"#A19D72\">испытаний</a></font>.', 7),
(18, 5, 'Война II: 2000-е', 'Делаем <a href=\"скачок\" title=\"leap\"><font color=\"#A19D72\">скачок</a></font> вперед. Пропустим песни о Великой отечественной войне послевоенного времени, песни Афганской войны (во многом похожей на Вьетнамскую). Такие песни можно послушать в разделах «Что слушать дальше!» этого и предыдущего урока.\n\nПослушаем теперь две песни современные, ставшие популярными во время второй чеченской войны (1999-начало 2000-х годов) и <a href=\"освещающие\" title=\"освещать — illuminate, interpret\"><font color=\"#A19D72\">освещающие</a></font> эту войну совершенно по-разному.\n', 8),
(19, 5, 'Молитва', 'Сталин мертв. Никита Хрущев переигрывает тройку бывших <a href=\"сподвижников\" title=\"сподви́жник — confederate, supporter\"><font color=\"#A19D72\">сподвижников</a></font> Сталина — Берию, Маленкова и Молотова, и становится Генеральным секретарем Коммунистической партии, лидером Советского Союза. В \"секретной речи\" на XX съезде КПСС (1956) Хрущев <a href=\"обличает\" title=\"unmasks, denounces\"><font color=\"#A19D72\">обличает</a></font> Сталина в преступлениях \"большого террора\", развенчивает его культ личности. Начинается так называемая \"оттепель\", таяние льда, <a href=\"cковывавшего\" title=\"ско́вывать/скова́ть — immobilize\"><font color=\"#A19D72\">сковывавшего</a></font> советское общество.\n\nПод личным <a href=\"покровительством\" title=\"patronage\"><font color=\"#A19D72\">покровительством</a></font> Хрущева Солженицын публикует свою повесть о лагерной жизни \"Один день Ивана Денисовича\". \n\nСреди новых свобод — свобода НЕ выражать политическую позицию, свобода писать песни, которые не <a href=\"востребованы\" title=\"needed, called for, in demand\"><font color=\"#A19D72\">востребованы</a></font> при построении социализма и борьбе со внутренным и внешним врагом.\n\nПоэзия живет новой жизнью. Многотысячные толпы собираются, чтобы слушать на площадях выступления таких поэтов, как Андрей Вознесенский, Евгений Евтушенко, Белла Ахмадулина. А им как разрешенным поэтам приходится маневрировать между позицией свободы и <a href=\"подчинением\" title=\"submission\"><font color=\"#A19D72\">подчинением</a></font> власти.\n\nПоявляются первые <a href=\"ростки\" title=\"lit. shoots, sprouts\"><font color=\"#A19D72\">ростки</a></font> бардовской (авторской) песни. Среди основателей жанра — Булат Окуджава, который начинает петь свои стихи под гитару. \n\nОднако, к 1963-му году, когда Окуджава пишет \"Молитву\", \"оттепель\" уже на исходе. В начале декабря 1962-го на выставке в Манеже Хрущев гневно <a href=\"обрушивается\" title=\"обру́шиваться на кого-нибудь — attack, lit. come crashing down upon\"><font color=\"#A19D72\">обрушивается</a></font> на молодых художников-абстракционистов. Это кладет начало кампании по <a href=\"искоренению\" title=\"rooting out\"><font color=\"#A19D72\">искоренению</a></font> \"абстракционизма\" и \"формализма\" в искусстве. Еще раньше, в конце 1950-х годов, началась новая волна усиленной борьбы с религией (после смягчения в отношениях между властью и церковью во время ВОВ). \n\nТаков историко-культурный контекст. Но \"Молитва Франсуа Вийона\" — подлинный <a href=\"шедевр\" title=\"masterpiece\"><font color=\"#A19D72\">шедевр</a></font> песенного и поэтического искусства. Она связана со своей эпохой, но не <a href=\"ограничена\" title=\"bounded, limited\"><font color=\"#A19D72\">ограничена</a></font> ей... ', 9),
(20, 5, 'Лагерная песня', '<i>Колыма, Колыма,\nЧудная планета:\nДевять месяцев зима,\nОстальное — лето!</i>\n\n        [из лагерного фольклора]', 10),
(21, 5, 'Гагарин', 'Среди многочисленных героев, которые появились или были созданы силами пропаганды в Советском Союзе, выделяется Юрий Гагарин. \n\nКак первый человек в космосе, совершивший полет на корабле \"Восток\" 12 апреля 1961 г., он заслуженно овладел воображением миллионов людей. К тому же, он <a href=\"олицетворил\" title=\"embodied\"><font color=\"#A19D72\">олицетворил</a></font> новые успехи страны, способной \"<a href=\"догнать и перегнать\" title=\"Догнать и перегнать (to catch up to and surpass) — слова Ленина, ставшие клише, и особо любимые Хрущевым\"><font color=\"#A19D72\">догнать и перегнать</a></font>\" запад, оптимизм хрущевской \"оттепели\". \n\n<object width=\"480\" height=\"385\"><param name=\"movie\" value=\"http://www.youtube.com/v/CGQ1ZAQJzY8?fs=1&hl=en_US\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/CGQ1ZAQJzY8?fs=1&hl=en_US\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"480\" height=\"385\"></embed></object>\n\nМолодой, скромный и простой, он притягивал к себе. Вот редкое продолжительное интервью с ним:\n\n<OBJECT width=\"470\" height=\"353\"><PARAM name=\"movie\" value=\"http://video.rutube.ru/861454d9fbf616d4001d4c1aa3afc31f\"></PARAM><PARAM name=\"wmode\" value=\"window\"></PARAM><PARAM name=\"allowFullScreen\" value=\"true\"></PARAM><EMBED src=\"http://video.rutube.ru/861454d9fbf616d4001d4c1aa3afc31f\" type=\"application/x-shockwave-flash\" wmode=\"window\" width=\"470\" height=\"353\" allowFullScreen=\"true\" ></EMBED></OBJECT>\n\n<a target=\"_blank\" href=\"http://yurigagarin.ru/news/gibel-gagarina-sluxi-i-pravda\">Трагическая и непонятная смерть Гагарина в 1968 г. во время тренировочного полета</a> стала ударом для страны.', 11),
(22, 5, 'Гласность и отчуждение', '<h3>Гласность и застой</h3>\n<a href=\"Застой\" title=\"stagnation\"><font color=\"#A19D72\">Застой</a></font> — время правления Брежнева.  В политической сфере — он отмечен коррупцией, бюрократизацией, и диким <a href=\"взяточничеством\" title=\"взя́тка — bribe\"><font color=\"#A19D72\">взяточничеством</a></font>. В экономике — наблюдается <a href=\"прoвал\" title=\"here, failure\"><font color=\"#A19D72\">прoвал</a></font> системы центрального управления, <a href=\"вoровство\" title=\"вoровство́ — theft (at work)\"><font color=\"#A19D72\">вoровство</a></font>, полное отсутствие дисциплины на работе,— а в результате — низкая <a href=\"производительность\" title=\"productivity\"><font color=\"#A19D72\">производительность</a></font>. В жизни — страдают от той же бюрократизации, отсутствия возможности свободно определить свой жизненный путь, говорить и писать (в общественной сфере) то, что думаешь.  \n\nВсё это приводит к <b>деморализации</b> общества.  \n\nПосле правления \"кремлевских старцев\" (Брежнев умер в 82-м г., Андропов в 84-м, Черненко в 85-м) Генеральным Секретарем Коммунистической Партии становится Михаил Сергеевич Горбачев. В свои пятьдесят четыре года, он первый представитель нового поколения лидеров, учившихся в Москве в пятидесятые годы во время \"оттепели\". Первая <a href=\"волна\" title=\"wave\"><font color=\"#A19D72\">волна</a></font> горбачевских реформ (1985-86 гг.) включает ускорение в экономике, дисциплину на работе, борьбу с коррупцией и (весьма непопулярный) антиалкогольный закон. Следующий этап — гласность, возможность открыто критиковать систему. \n\nГорбачев хотел привлечь общественность к делу перестройки государственной системы. Сначала <a href=\"настроение\" title=\"mood\"><font color=\"#A19D72\">настроение</a></font> было приподнятым. Людям нравился молодой, <a href=\"деятельный\" title=\"active\"><font color=\"#A19D72\">деятельный</a></font> лидер, а пресса пела ему <a href=\"дифирамбы\" title=\"дифира́мб — преувеличенная, восторженная похвала\"><font color=\"#A19D72\">дифирамбы</a></font>. \n\nРеформы политические считались необходимым <a href=\"условием\" title=\"усло́вие — condition\"><font color=\"#A19D72\">условием</a></font> для спасения экономики. Но реформы должны были проходить <a href=\"в рамках\" title=\"ра́мка — frame; ра́мки — framework\"><font color=\"#A19D72\">в рамках</a></font> социализма-коммунизма. Это оказалось невозможным. Критика подрывала авторитет Коммунистической Партии и самого Горбачева. Революция сверху <a href=\"породила\" title=\"ср. роди́ть\"><font color=\"#A19D72\">породила</a></font> революцию снизу.\n\nВообще ряд событий и <a href=\"обстоятельств\" title=\"обстоя́тельство — circumstance\"><font color=\"#A19D72\">обстоятельств</a></font> подрывал авторитет Горбачева.  \n\n<ul><li>Когда случилась <a href=\"авария\" title=\"accident\"><font color=\"#A19D72\">авария</a></font> на Чернобыльской <a href=\"АЭС\" title=\"а́томная электростанция\"><font color=\"#A19D72\">АЭС</a></font>, правительство по старой привычке сначала скрывало <a href=\"масштаб\" title=\"scale\"><font color=\"#A19D72\">масштаб</a></font> и уровень опасности аварии.  \n\n<li>В экономике ситуация продолжала ухудшаться. Цена на <a href=\"нефть\" title=\"oil\"><font color=\"#A19D72\">нефть</a></font> упала и пришлось занять много денег за границей. Еще важнее то, что реформы были <a href=\"половинчатыми\" title=\"→ половина\"><font color=\"#A19D72\">половинчатыми</a></font>. Продолжала функционировать система центрального <a href=\"управления\" title=\"управле́ние — management\"><font color=\"#A19D72\">управления</a></font> экономикой со всеми ее <a href=\"недостатками\" title=\"недоста́ток — deficiency, disadvantage. Aнтоним: досто́инство\"><font color=\"#A19D72\">недостатками</a></font>. Работа новых кооперативов саботировалась аппаратчиками. <a href=\"Наглядным\" title=\"graphic\"><font color=\"#A19D72\">Наглядным</a></font> примером экономических бедствий стало отсутствие <a href=\"мыла\" title=\"soap\"><font color=\"#A19D72\">мыла</a></font> у шахтеров, а к 89-90 году <a href=\"зияющие\" title=\"зия́ть — gape\"><font color=\"#A19D72\">зияющие</a></font> пустотой полки магазинов. \n\n<li>Когда начались национальные волнения в республиках, Горбачев прибегал к силе, чтобы их подавить. В январе 1991-го года граждане увидели танки на улицах Вильнюса (столицы Литвы).</ul>\nВ культуре застой — время расцвета самиздата и советского анекдота. Гласность — время горячего обсуждения истории Советского Союза, публикации запрещенных произведений русской и мировой литературы, расцвета русской рок-музыки и кино. Но в то же время, гласность стала временем так называемой \"чернухи\". Со свободой открытого и полномасштабного обсуждения проблем советского общества пришло большое количество мрачных и пессимистичных произведений кино и литературы.\n\nБольшие надежды, но и большие разочарования и тревога за будущее — вот культурное наследие конца горбачевской эпохи и культурный фон нашей следующей песни.\n\n\n\n', 12),
(23, 5, 'Странная любовь', 'В эпоху гласности очень остро ставился вопрос об отношении каждого человека к родине и к ее истории. Газеты и журналы <a href=\"пестрели\" title=\"were dotted with\"><font color=\"#A19D72\">пестрели</a></font> в это время <a href=\" откровениями \" title=\"откровение — revelation\"><font color=\"#A19D72\">откровениями</a></font> из темной истории репрессий, <a href=\"запрещенными\" title=\"запрещенный — forbidden\"><font color=\"#A19D72\">запрещенными</a></font> долгие годы произведениями литературы, <a href=\"откровенными\" title=\"откровенный — candid\"><font color=\"#A19D72\">откровенными</a></font> дискуссиями между представителями <a href=\"партии\" title=\"КПСС\"><font color=\"#A19D72\">партии</a></font>, интелигенцией и простыми гражданами о прошлом и будущем страны. \n\nЭта песня написана в 90-м, предпоследнем советском, году и всего за два года до ранней смерти от <a href=\"рака\" title=\"рак — cancer\"><font color=\"#A19D72\">рака</a></font> Кати Яровой. В ней певица и поэт отвечает на этот вопрос, <a href=\"отражая\" title=\"отражать — reflect\"><font color=\"#A19D72\">отражая</a></font> ощущения и многих своих <a href=\"современников\" title=\"современник — a contemporary\"><font color=\"#A19D72\">современников</a></font>.\n', 13),
(24, 5, 'Московская октябрьская', 'Аквариум — одна из важнейших российских рок-групп. В 70-е годы она исполняла и записывала песни подпольно. Первые альбомы выходят в начале 80-х. Солист, автор большинства песен и художественный руководитель группы, <a target=\"_blank\" href=\"http://lenta.ru/lib/14172824/\">Борис Гребенщиков</a> («БГ») — живая легенда. Многие его песни близки к <a href=\"зауми\" title=\"заумь — trans-sense poetry\"><font color=\"#A19D72\">зауми</a></font>. Однако, внимательно изучая эту песню и ее культурный <a href=\"фон\" title=\"background\"><font color=\"#A19D72\">фон</a></font>, мы <a href=\"обнаружим\" title=\"обнаружить — discover\"><font color=\"#A19D72\">обнаружим</a></font> вполне острый смысл. \nОфициальный сайт группы Аквариум — <a target=\"blank\" href=\"http://www.aquarium.ru\">http://www.aquarium.ru</a>.\n\n', 14),
(25, 5, 'Сатира и власть', ' ', 15),
(26, 5, 'Маленький человек... возвращается?', 'Гриша Данской — современный русский бард из <a target=\"_blank\" href=\"http://maps.yandex.ru/-/CRd7usR\">Перм́́и</a>. В этой его песне по-новому затрагивается классическая тема русской культуры — проблема маленького человека и его места в обществе и истории. <i>История</i> здесь, правда, в подтексте. Чтобы ее ход почувствовать, надо знать, что такое \"челнок\" (вернее, кто такие \"челноки\"), и еще задаваться вопросом, почему тот, кому место \"на верхней боковой\", стал \"челноком\".\n\nВеб-страницу Данского можно найти <a target=\"_blank\" href=\"http://www.danskoy.ru\"> здесь </a>\n', 16),
(27, 5, 'Выбор жизненного пути', '', 17),
(28, 5, 'Итоговая работа', '<br><font size=4><b>Темы для итоговой работы:</font></b><br><br>\n<font color=black><u>Тема №1:</u><br>\n\"Слушать будем Битлз, кушать алкоголь...\"<br>\nЕсли бы в вашей власти было переделать страну так, как вы хотите, какую бы вы основали страну? Что бы из этого вышло?<br>\nВаш ответ не обязательно должен быть серьезным. Можно и стебаться ;-)<br><br>\n<u>Тема №2:</u><br>\nВ России, США и других странах музыка использовалась и в качестве государственной пропаганды, и как выражение общественного протеста. Почему музыка так хорошо исполняет эти функции? Какими способами музыка может повлиять на человеческие  жизни (как в хорошем, так и в плохом смысле)? Возможно ли изменить мир с помощью песни?<br><br> \n<u>Тема №3:</u><br>\nПодумайте о тех случаях в песнях, которые мы слушали, когда разные видения мира, русской культуры и истории входят в <a href=\"противоречие\" title=\"сontradiction\"><font color=\"#A19D72\">противоречие</a></font>. (Один яркий пример — разные мироощущения в \"Солдате\" группы \"5’nizza\" и \"Давай за...\" группы \"Любэ\", но это могут быть и противоречия внутри самой песни, а также конфликт между <a href=\"мировоззрением\" title=\"worldview\"><font color=\"#A19D72\">мировоззрением</a></font>, выраженным в песне, и имплицитно присутствующим реальным миром вне песни.) Какие вы находили в этих песнях \"<a href=\"болевые точки\" title=\"болева́я то́чка — lit. pressure point, a sore spot, something which touches a nerve\"><font color=\"#A19D72\">болевые точки</a></font>\"? Они похожие на \"болевые точки\" американской культуры или нет? Чем они похожи и чем отличаются? Какие могут быть источники <a href=\"совпадений\" title=\"cовпаде́ние — here, congruence\"><font color=\"#A19D72\">совпадений</a></font> и <a href=\"расхождений\" title=\"расхожде́ние — divergence; cр. расходи́ться\"><font color=\"#A19D72\">расхождений</a></font>?<br><br>\n<u>Тема №4:</u><br>\nНапишите антиутопический рассказ. Если вы читали антиутопии Замятина, Хаксли, Орвелла и др., попытайтесь не повторить их путь.</font>', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`),
  ADD KEY `IDX_C2502824DF990765` (`student_registration_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2ED7EC5591CC992` (`course_id`),
  ADD KEY `IDX_2ED7EC5833D8F43` (`registration_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A9A55A4CA76ED395` (`user_id`),
  ADD KEY `IDX_A9A55A4C82F1BAF4` (`language_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6A2CA10C3C0BE965` (`filename`),
  ADD KEY `IDX_6A2CA10CA76ED395` (`user_id`);

--
-- Indexes for table `module_cn`
--
ALTER TABLE `module_cn`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B5F8B405A0BDB2F3` (`song_id`);

--
-- Indexes for table `module_cn_keyword`
--
ALTER TABLE `module_cn_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_93E7E9815A496692` (`cn_id`);

--
-- Indexes for table `module_cn_keywords_media`
--
ALTER TABLE `module_cn_keywords_media`
  ADD PRIMARY KEY (`module_cn_keyword_id`,`media_id`),
  ADD KEY `IDX_3B11077237648B6A` (`module_cn_keyword_id`),
  ADD KEY `IDX_3B110772EA9FDD75` (`media_id`);

--
-- Indexes for table `module_dw`
--
ALTER TABLE `module_dw`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9ED28A02A0BDB2F3` (`song_id`);

--
-- Indexes for table `module_ge`
--
ALTER TABLE `module_ge`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4646A889A0BDB2F3` (`song_id`);

--
-- Indexes for table `module_ls`
--
ALTER TABLE `module_ls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5166C413A0BDB2F3` (`song_id`);

--
-- Indexes for table `module_lt`
--
ALTER TABLE `module_lt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CF0251B0A0BDB2F3` (`song_id`);

--
-- Indexes for table `module_qu`
--
ALTER TABLE `module_qu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_47690D3AA0BDB2F3` (`song_id`);

--
-- Indexes for table `module_question_heading`
--
ALTER TABLE `module_question_heading`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F83A45C77172EE` (`qu_id`),
  ADD KEY `IDX_1F83A45E7BD46B8` (`lt_id`),
  ADD KEY `IDX_1F83A4578C84753` (`ge_id`),
  ADD KEY `IDX_1F83A45C578A297` (`dw_id`),
  ADD KEY `IDX_1F83A457A6A7E01` (`ls_id`);

--
-- Indexes for table `module_question_item`
--
ALTER TABLE `module_question_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_122E085962FE64EC` (`heading_id`);

--
-- Indexes for table `professor_registrations`
--
ALTER TABLE `professor_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_40122D7F7E3C61F9` (`owner_id`),
  ADD KEY `IDX_40122D7F7D2D84D5` (`professor_id`),
  ADD KEY `IDX_40122D7F591CC992` (`course_id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_33EDEEA1F8BD700D` (`unit_id`);

--
-- Indexes for table `songs_media`
--
ALTER TABLE `songs_media`
  ADD PRIMARY KEY (`song_id`,`media_id`),
  ADD KEY `IDX_EE720FF2A0BDB2F3` (`song_id`),
  ADD KEY `IDX_EE720FF2EA9FDD75` (`media_id`);

--
-- Indexes for table `student_registrations`
--
ALTER TABLE `student_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_642A979EA000B10` (`class_id`),
  ADD KEY `IDX_642A979CFC54FAB` (`designer_id`),
  ADD KEY `IDX_642A9791B55C8B6` (`prof_registration_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DCBB0C53591CC992` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `module_cn`
--
ALTER TABLE `module_cn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_cn_keyword`
--
ALTER TABLE `module_cn_keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `module_dw`
--
ALTER TABLE `module_dw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_ge`
--
ALTER TABLE `module_ge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_ls`
--
ALTER TABLE `module_ls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_lt`
--
ALTER TABLE `module_lt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `module_qu`
--
ALTER TABLE `module_qu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `module_question_heading`
--
ALTER TABLE `module_question_heading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `module_question_item`
--
ALTER TABLE `module_question_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;
--
-- AUTO_INCREMENT for table `professor_registrations`
--
ALTER TABLE `professor_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `student_registrations`
--
ALTER TABLE `student_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `FK_C2502824DF990765` FOREIGN KEY (`student_registration_id`) REFERENCES `student_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `FK_2ED7EC5591CC992` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2ED7EC5833D8F43` FOREIGN KEY (`registration_id`) REFERENCES `professor_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_A9A55A4C82F1BAF4` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A9A55A4CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_cn`
--
ALTER TABLE `module_cn`
  ADD CONSTRAINT `FK_B5F8B405A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_cn_keyword`
--
ALTER TABLE `module_cn_keyword`
  ADD CONSTRAINT `FK_93E7E9815A496692` FOREIGN KEY (`cn_id`) REFERENCES `module_cn` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_cn_keywords_media`
--
ALTER TABLE `module_cn_keywords_media`
  ADD CONSTRAINT `FK_3B11077237648B6A` FOREIGN KEY (`module_cn_keyword_id`) REFERENCES `module_cn_keyword` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3B110772EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_dw`
--
ALTER TABLE `module_dw`
  ADD CONSTRAINT `FK_9ED28A02A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_ge`
--
ALTER TABLE `module_ge`
  ADD CONSTRAINT `FK_4646A889A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_ls`
--
ALTER TABLE `module_ls`
  ADD CONSTRAINT `FK_5166C413A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_lt`
--
ALTER TABLE `module_lt`
  ADD CONSTRAINT `FK_CF0251B0A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_qu`
--
ALTER TABLE `module_qu`
  ADD CONSTRAINT `FK_47690D3AA0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_question_heading`
--
ALTER TABLE `module_question_heading`
  ADD CONSTRAINT `FK_1F83A4578C84753` FOREIGN KEY (`ge_id`) REFERENCES `module_ge` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1F83A457A6A7E01` FOREIGN KEY (`ls_id`) REFERENCES `module_ls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1F83A45C578A297` FOREIGN KEY (`dw_id`) REFERENCES `module_dw` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1F83A45C77172EE` FOREIGN KEY (`qu_id`) REFERENCES `module_qu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1F83A45E7BD46B8` FOREIGN KEY (`lt_id`) REFERENCES `module_lt` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_question_item`
--
ALTER TABLE `module_question_item`
  ADD CONSTRAINT `FK_122E085962FE64EC` FOREIGN KEY (`heading_id`) REFERENCES `module_question_heading` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `professor_registrations`
--
ALTER TABLE `professor_registrations`
  ADD CONSTRAINT `FK_40122D7F591CC992` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_40122D7F7D2D84D5` FOREIGN KEY (`professor_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_40122D7F7E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `FK_33EDEEA1F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `songs_media`
--
ALTER TABLE `songs_media`
  ADD CONSTRAINT `FK_EE720FF2A0BDB2F3` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EE720FF2EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_registrations`
--
ALTER TABLE `student_registrations`
  ADD CONSTRAINT `FK_642A9791B55C8B6` FOREIGN KEY (`prof_registration_id`) REFERENCES `professor_registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_642A979CFC54FAB` FOREIGN KEY (`designer_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_642A979EA000B10` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_DCBB0C53591CC992` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
