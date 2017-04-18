-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2017 at 11:33 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-2+deb.sury.org~xenial+1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clsp`
--

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
(18, 7, 'testStudent11', 'Student 11', '$2y$13$XrSDPc//pAgJxR.kN82keuuhkaf/R5XxfOerFtj/faZnJ7aiZ4Ffm', 'test11@mail.com', 1, 1492404162, NULL, 1492404162, 1497057872, 'UTC', 1, 0, 0, NULL, NULL, 0);

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
(7, 4, 5, 'JAPN 4215 A', '');

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `language_id`, `name`, `description`) VALUES
(1, 5, 1, 'CHIN 3002', 'Advanced Chinese Language, part 2'),
(2, 6, 3, 'JAPN 3001', 'Advanced Japanese Language'),
(3, 6, 3, 'JAPN 4361', 'Japanese Literature'),
(4, 6, 3, 'JAPN 4215', 'Modern Japanese Culture');

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_code`, `name`) VALUES
(1, 'ZH', 'Chinese'),
(2, 'RU', 'Russian'),
(3, 'JA', 'Japanese'),
(4, 'AR', 'Arabic'),
(5, 'KO', 'Korean');

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
(14, 22, '', NULL, 0, 1, 0);

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
(12, 7, '勇気を胸に', 'Literally "have bravery in the heart"', NULL),
(13, 8, 'ヒトヒラ', 'A single piece', NULL),
(14, 8, 'ハナビラ', 'Flower petal', NULL),
(15, 8, '巻き戻して', 'Return to the way things were', NULL),
(16, 9, 'halation', 'spreading of light to form a fog around the edges of something bright', NULL),
(17, 9, '不思議', 'Mysterious', NULL),
(18, 7, '夢', '<p><a href="http://www.google.com">dream</a></p>\n', NULL);

--
-- Dumping data for table `module_cn_keywords_media`
--

INSERT INTO `module_cn_keywords_media` (`module_cn_keyword_id`, `media_id`) VALUES
(5, 6),
(6, 7);

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
(14, 22, '', NULL, 0, 0, 0);

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
(14, 22, '', NULL, 0, 0, 0);

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
(14, 22, '', NULL, 0, 0, 0);

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
(14, 22, '', NULL, 0, 0, 0);

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
(16, 22, '', NULL, 0, 0, 0);

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
(18, NULL, NULL, NULL, 8, NULL, 'Discussion', 1);

--
-- Dumping data for table `module_question_item`
--

INSERT INTO `module_question_item` (`id`, `heading_id`, `content`, `type`, `weight`, `choices`, `answers`) VALUES
(1, 1, 'Which is a member of Coconatsu?', 'multiple-choice', 1, '[{"choice":"Ibuki"},{"choice":"Meu"},{"choice":"Natsuhi"},{"choice":"Grace"}]', '[{"choice":"Natsuhi"}]'),
(2, 1, 'Which are members of Coconatsu?', 'multiple-select', 2, '[{"choice":"Ibuki"},{"choice":"Meu"},{"choice":"Natsuhi"},{"choice":"Cocona"}]', '[{"choice":"Natsuhi"},{"choice":"Cocona"}]'),
(3, 3, 'test-not-meu', 'test', 3, NULL, NULL),
(4, 2, 'test-meu-3, heading 2', 'multiple-choice', 1, NULL, ''),
(5, 1, 'Ibuki Izumi of Hinabita plays the _, while Meu plays the _.', 'fill-blank', 2, '', '[{"choice":"bass"},{"choice":"drums:drum:percussion"}]'),
(6, 11, '「CLOSER」は_年から発売されました。', 'fill-blank', 1, NULL, '[{"choice":"2008"}]'),
(7, 11, '「CLOSER」と言う歌は最初にシングルに発表しました。このシングルのタイトルはなんですか。', 'multiple-choice', 2, '[{"choice":"GRAVITY"},{"choice":"CLOSER"},{"choice":"海色"},{"choice":"影踏み"}]', '[{"choice":"CLOSER"}]'),
(8, 11, '「CLOSER」はどの言葉で歌いましたか。', 'multiple-select', 3, '[{"choice":"韓国語"},{"choice":"日本語"},{"choice":"英語"},{"choice":"スペイン語"}]', '[{"choice":"日本語"},{"choice":"英語"}]'),
(9, 12, 'What does 偽善 mean?', 'multiple-choice', 1, '[{"choice":"To lose sight of"},{"choice":"Treasure"},{"choice":"Surreal"},{"choice":"Hypocrisy"}]', '[{"choice":"Hypocrisy"}]'),
(10, 12, '勇気を胸に literally means to have _ in the _.', 'fill-blank', 2, '', '[{"choice":"bravery:strength:courage"},{"choice":"heart:chest"}]'),
(11, 13, 'どうして「CLOSER」のミュージックビデオの人は全部井上ジョーですか。', 'short-answer', 1, NULL, NULL),
(12, 13, 'このミュージックビデオはどんな物語を見せましたか。', 'short-answer', 2, NULL, NULL),
(13, 14, 'この歌のタイトル、「CLOSER」、の意味はなんですか。', 'short-answer', 1, NULL, NULL);

--
-- Dumping data for table `professor_registrations`
--

INSERT INTO `professor_registrations` (`id`, `owner_id`, `professor_id`, `course_id`, `date_created`, `date_deleted`, `date_start`, `date_end`, `signup_code`) VALUES
(1, 5, 2, 1, 1488417868, NULL, 0, 1519953868, 'professorregistration1-58339'),
(2, 5, 3, 1, 1488417868, NULL, 0, 1519953868, 'professorregistration2-928AB'),
(3, 6, 4, 2, 1488417868, NULL, 100000, 111111, 'professorregistration3-CA87D'),
(4, 6, 4, 3, 1488417868, NULL, 0, 1519953868, 'professorregistration4-38581'),
(5, 6, 4, 4, 1488417868, NULL, 0, 1519953868, 'professorregistration5-1535S');

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
(19, 8, '海行かば', 2, 'なし', '信時潔', '『海行かば』（うみゆかば）とは、日本の軍歌ないし国民歌の一である。\n\n当時の大日本帝国政府が国民精神総動員強調週間を制定した際のテーマ曲。信時潔がNHKの嘱託を受けて1937年（昭和12年）に作曲した。信時の自筆譜では「海ゆかば」である。\n\n放送は1937年（昭和12年）10月13日から10月16日の国民精神総動員強調週間に「新しい種目として」行われたとの記録がある。本曲への国民一般の印象を決定したのは、大東亜戦争(太平洋戦争)期、ラジオ放送の戦果発表（大本営発表）が玉砕を伝える際に、必ず冒頭曲として流されたことである（ただし真珠湾攻撃成功を伝える際は勝戦でも流された）。ちなみに、勝戦を発表する場合は、「敵は幾万」、陸軍分列行進曲「抜刀隊」、行進曲『軍艦』などが用いられた。\n\n創立以来1958年まで桜美林学園は旋律を校歌に採用していた。', '海行かば\r\n水漬く屍\r\n山行かば\r\n草生す屍\r\n大君の辺にこそ死なめ\r\nかえりみはせじ', 'https://www.youtube.com/embed/yUwvIFYcCqo"'),
(20, 8, '露営の歌', 3, 'なし', '古関裕而', '露営の歌（ろえいのうた）は、1937年（昭和12年）9月にコロムビアレコードから発売された軍歌。\n\n1937年、日中戦争が勃発した。東京日日新聞と大阪毎日新聞に題号が分かれていた毎日新聞が戦意高揚のためこれにあわせて「進軍の歌」の歌詞を公募し、薮内喜一郎（1905年–1986年、奈良県出身、京都市役所に勤務）が傑作に入選した。\n\nそれを北原白秋や菊池寛らが「露営の歌」と題し、古関裕而が作曲を手がけた。古関は満州を旅行の帰途下関から東京への特急列車の車中で新聞に発表された歌詞を見て心を動かされ、依頼されていないにもかかわらず作曲していた。東京に着いた古関に日本コロムビアの社員が作曲を依頼した時には「それならもうできていますよ」と楽譜を差し出したという。\n\n京都の嵐山には「露営の歌碑」がある。題字は陸軍大将松井石根によって行われている。', 'なし', NULL),
(21, 10, '七人の侍', 1, '映画', '黒澤明', '『七人の侍』（しちにんのさむらい）は、1954年（昭和29年）4月26日に公開された日本映画である。東宝製作・配給。監督は黒澤明、主演は三船敏郎と志村喬。モノクロ、スタンダード・サイズ、207分。\n\n当時の通常作品の7倍ほどに匹敵する製作費をかけ、何千人ものスタッフ・キャストを動員、1年余りの撮影期間がかかったが、興行的には成功し、700万人の観客動員を記録した。日本の戦国時代（劇中の台詞によると1586年）を舞台とし、野武士の略奪により困窮した百姓に雇われる形で集った7人の侍が、身分差による軋轢を乗り越えながら協力して野武士の一団と戦う物語。\n\n黒澤明が初めてマルチカム方式（複数のカメラで同時に撮影する方式）を採用し、望遠レンズを多用した。ダイナミックな編集を駆使して、豪雨の決戦シーン等迫力あるアクションシーンを生み出した。さらにその技術と共に、脚本、綿密な時代考証等により、アクション映画・時代劇におけるリアリズムを確立した。\n\n黒澤明が尊敬するジョン・フォードの西部劇から影響を受け、この作品自体も世界の映画人・映画作品に多大な影響を与えた。1960年にはアメリカ合衆国で『荒野の七人』として、2016年には『マグニフィセント・セブン』としてリメイクされている。ヴェネツィア国際映画祭銀獅子賞受賞。', '映画ですから、歌詞はありません。', NULL),
(22, 10, 'となりのトトロ', 2, 'となりのトトロ', '中川李枝子/井上杏美', '『となりのトトロ』はスタジオジブリの長編アニメーション映画。宮崎駿監督作品。昭和30年代前半の日本を舞台にしたファンタジー。\n\n物語は、田舎へ引っ越してきた草壁一家のサツキ・メイ姉妹が、“もののけ”とよばれ、子どもの時にしか会えないと言われる不思議な生き物・トトロとの交流を描いていくストーリー。', '卜トロ トトロ トトロ トトロ \nだれかが こっそり \n小路に 木の実 うずめて \nちっさな芽 生えたら 秘密の暗号 \n森へのパスポート \nすてきな冒険はじまる \nとなりのトトロ トトロ トトロ トトロ \n\n森の中に むかしから住んでる \nとなりのトトロ トトロ トトロ トトロ \n子供のときにだけ あなたに訪れる \n不思議な出会い \n\n雨ふり バス停 \nズブヌレ オバケがいたら \nあなたの雨ガサ さしてあげましょ \n森へのパスポート \n魔法の扉 あきます \nとなりのトトロ トトロ トトロ トトロ \n月夜の晩に オカリナ吹いてる \nとなりのトトロ トトロ トトロ トトロ \nもしも会えたなら すてきな しあわせが \nあなたに来るわ \n\n卜卜ロ 卜トロ 卜トロ 卜トロ \n森の中に むかしから住んでる \nとなりのトトロ トトロ トトロ トトロ \n子供のときにだけ あなたに訪れる \n不思議な出会い \n\nトトロ トトロ トトロ トトロ \nトロ トトロ 卜トロ トトロ……', NULL);

--
-- Dumping data for table `songs_media`
--

INSERT INTO `songs_media` (`song_id`, `media_id`) VALUES
(1, 4),
(2, 5),
(10, 11);

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
(7, 6, 7, 5, 'JAPN 4215 A', 1488417872, NULL, 0, 1497057872, 'studentregistration6-4215C', 15);

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `course_id`, `name`, `description`, `weight`) VALUES
(2, 3, 'Unit 3 - 4361', 'Modern Japan', 3),
(3, 3, 'Unit 2 - 4361', 'Historic Japan', 2),
(4, 1, 'Unit 1 - CHINESE 3002', 'THIS DOES NOT BELONG TO 4361', 10),
(6, 3, 'Unit 1 - 4361', 'Introduction to Syllabus', 1),
(7, 4, 'Unit 1 - 前書き\n', '日本語４２１５にようこそう。\n\n3飛ヘライ用擦うぞわね支毎クめ面芸ナハエ島地オヱト札約たこ改増やどとぐ化最メ階局イチ斐越イけ郵散づおごは領定ムコ円量記マ損感回予ッせひ。広テネヘ土3国んト石造ナホ海賛ヱ打稿スぜルび届沖久用くあな告政さおへざ主述トの世書ふぐへ株技ぱあ木紙ロフレ観数ひかへす盤際見仇佗來俄フ。葉在ホロラヤ各居月メヒカ版12僚すを農掲合き事推ヲ体晴ムヘテシ心秋のざ豊1施入ンび敗同イ。\n\n削やの新写なの日八サホ南近ゅイよ野円理座ほーわぴ行理好オ橋郷つラぼ子対状ネ神34衛ちけ座軽正機つイづク。捜めづつ索正じあべ生内ン鳥単セワ供塾ヘ言27索ヨナホセ種廊有まトばす鮮公んて転熊ユサ責勤どそやふ第信レテユ索下ふスゅ廃算挑様へぽじべ。8中ケネルミ信動将関につくあ白84目ツヤア類替でまざ気4時チシマ経治でをろき植酔まー拓湾をれせぎ条式整ネセテツ法芸タ副験ケウアヨ拍責興度埋さりしき。\n\n人戦導ネホナ日予瀬ヨ稿頭省たね相験必ヘ見戦カ地手メキア質玉づて創象十じうぱ情事ヱミ畔際ラ角儀准揮串レフびげ。意ムノレヤ話視タラマロ玉国ゅ徹7載じけドし載急止はだ庭間んわおぞ務飛と制1所なもぞ角前ス暮係傳呈播いぼなご。出チ関査ぜひ勢贈は究囲めぜ便国ぎへが改1京82婦項間漢1後だえじ禁洋ヨ牧応ざび嫌例ぐすぶせ戦閉ら老意よッ戸合ミヱカ企任果ミサテ展完モオレ崩指め。\n\n更職ホヲイユ更者ツヌ込頃オ孫70娘汁98交めきおッ者念たゅわび政被スア手東きら勢93靼つけねげ咋新にクつ勝活ニヱロ業玲ヤネヱシ冴作八ぴゆます。警山ヲトスユ演支ぴ庫天ン秒棄けろめ常大互遠シニクヤ者価トほでづ口金ミ本圧モワ無結最年はレれラ侃稚べれづト等禁著じおざし査安ホロモオ議橋アハチナ新助ん海妹廷他壁か。\n\n絡げが意早総夫ふつ禁本ミノリ諮田携ニチハ石掲ソ月分年りつひ品業客ぽ部保ホオロ負中ヤクキ猫97利ラモ表測ヱホロ以支ルヌナ欧経ゅおびで図始般作じたほ。関ドざ指邸ぶむ質属えだう鑑年をきば行利は速平メ万52合あわ慶中メスルタ裁止フづ善床者でぞ将形シケ覧97串剱ぶぽ。写ヨクヱヒ葬異くごぼち葉子モケオシ埼氷迎ごぐ結94事ナカア事禎でべ地50湧ヌ物重報つが暮校足クそけん立傘ッよど。\n\n芸ラねだぱ別関よのれぶ社著け表多りフス気写14社昌フ面医碁販べぐぼ数目ツメ禁必合新ヱステ重術ユ社南シセ国覧るぴレだ。群ぎぴす懸雇っうなみ僕関オフワ少著ーく税3一イ決康ネホキ席45図ろ鈴親ユオヲ門反経ユオモス勝社あ療崎ラリを売叙孟をれょ。収あぐどり交記か断目リ能前ラり嵐生し防歩答ふ瞬法タソ深法レノヒ療写たンぎ転殺ウツワロ本国ヱ指生7屋ルサエヲ東2女むしっぎ。\n\n破装ミナ栃給携こレえし康難いフンぴ離方げきゃ決特ミ額遊クめじえ也少給キヱコル神予責図ぼぱ年抜将みもぴ名6目のみびよ夜天たさび実染みんて。変よば爆録ひじ勘情枠ぶおの含評ヤキツ面受るのつ覧芸ナメアチ確漫コユ索月ばろると多激セコノラ場米ヱアロレ央1勝柔どずラド。当場マナホ山高エツシモ義掲へかじえ図23結ク半出ノオ容要ユワニノ検遠ウナ自更ぞぜ向42集へ属首ヤチ学育け文応けづが場31到じちお。\n\n四ハケ参3断ふか出展アノ率実沢モサヲ副自だびくそ掲体覧りか育品週ク宿治かゅさあ作戦リ撮大ンいレル急機併おスね物79市ユワナ弟属拡盛秀ぶ。89情ハワヤ軽決ょ点稿ス鳥画ぼぎをぶ象末ツノ罪績府ぽげぶ今32女ハ殉大明ス旅周レヘモ惑力めひず観起ぜい効行らびぽ属必共ハタ集質な提研覚か。\n\n生り界読ユナソシ養万みばさ権強ら格7情ーゆべ決集ハノヒ達断ニクレ熱話ワ鈴報ヤニ勤子水テ意千ゆた念整セフツ線谷山ト麻権ネコ業短づかめ賠自スょイ下宮程凶圭やしか。県顔どは賞界ワキ馬川ク日十モオ質記じざ事化ネ島右れ市改づべ要産ドぼ求6読公一フめあ九共はフち択批ヤキウフ塚影ンめぎい幹断ろとう登幌拉柳飾えずま。\n\n供ホ試70会文トでよフ堀投たげう供添りー術権追ぱラ未改エユ供経折ウシク易松ツ月議れイね影地さッ男大ノホク生同ネヱケウ文天固服せっ。際つ番安与ゃゆ物追ぐべドひ共瀬なドめり囲佐戦ーへ勢27武ナタ理必外ッドられ助載シヒヲニ広村ぐとはが裁学国1健ツヘハ馬落トぱゃ広火部もえ。府モ表曜オ線9聞サヱオ由3料しびさそ書愛シヱト報需ぱに会住オフコ無進レだ売会ミ詳追ス快領盤会味ぞうー。', 1),
(8, 4, 'Unit 2 - 民謡\n', '民謡を使って、21世紀までの文化と歴史を少し勉強しましょう。\n\nシューリンガンのグーリンダイ、五劫の擦り切れ、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの。食う寝る処に住む処。長久命の長助。長久命の長助、寿限無、寿限無、水行末 雲来末 風来末、海砂利水魚の、海砂利水魚の、食う寝る処に住む処。グーリンダイのポンポコピーのポンポコナーの、シューリンガンのグーリンダイ、水行末 雲来末 風来末。\n\n寿限無、寿限無。シューリンガンのグーリンダイ。パイポパイポ パイポのシューリンガン。長久命の長助、食う寝る処に住む処、食う寝る処に住む処、海砂利水魚の、グーリンダイのポンポコピーのポンポコナーの、やぶら小路の藪柑子、やぶら小路の藪柑子。\n\nパイポパイポ パイポのシューリンガン、水行末 雲来末 風来末、食う寝る処に住む処、長久命の長助。グーリンダイのポンポコピーのポンポコナーの、海砂利水魚の。やぶら小路の藪柑子、五劫の擦り切れ、寿限無、寿限無、水行末 雲来末 風来末、寿限無、寿限無、海砂利水魚の、シューリンガンのグーリンダイ。\n\nシューリンガンのグーリンダイ。食う寝る処に住む処。食う寝る処に住む処、水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの、パイポパイポ パイポのシューリンガン。シューリンガンのグーリンダイ。\n\n五劫の擦り切れ。寿限無、寿限無、長久命の長助、長久命の長助。グーリンダイのポンポコピーのポンポコナーの。水行末 雲来末 風来末、シューリンガンのグーリンダイ、食う寝る処に住む処、グーリンダイのポンポコピーのポンポコナーの、水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン。海砂利水魚の。パイポパイポ パイポのシューリンガン。寿限無、寿限無。やぶら小路の藪柑子。\n\nパイポパイポ パイポのシューリンガン、長久命の長助。やぶら小路の藪柑子、五劫の擦り切れ。やぶら小路の藪柑子。パイポパイポ パイポのシューリンガン、食う寝る処に住む処。グーリンダイのポンポコピーのポンポコナーの、食う寝る処に住む処、海砂利水魚の。シューリンガンのグーリンダイ。\n\n五劫の擦り切れ、やぶら小路の藪柑子。グーリンダイのポンポコピーのポンポコナーの。長久命の長助。やぶら小路の藪柑子。海砂利水魚の。海砂利水魚の、パイポパイポ パイポのシューリンガン。五劫の擦り切れ、寿限無、寿限無。パイポパイポ パイポのシューリンガン。食う寝る処に住む処。水行末 雲来末 風来末、シューリンガンのグーリンダイ。グーリンダイのポンポコピーのポンポコナーの、シューリンガンのグーリンダイ。水行末 雲来末 風来末。長久命の長助、寿限無、寿限無。\n\n海砂利水魚の、パイポパイポ パイポのシューリンガン。グーリンダイのポンポコピーのポンポコナーの。五劫の擦り切れ、水行末 雲来末 風来末。やぶら小路の藪柑子。長久命の長助。寿限無、寿限無。パイポパイポ パイポのシューリンガン。海砂利水魚の、シューリンガンのグーリンダイ。水行末 雲来末 風来末。', 2),
(9, 4, 'Unit 3 - 現代の歌\n', '21世紀に作った人気な曲を見ましょう。これらの曲は世話にインパクトした。 \n\n毛御個りゆにほえぬ野遊氏区あゃいきえんこめっのな他日らねぬろゅ氏擢他遊毛日ひむうたも夜魔舳絵等鵜他さらくけこ課留目以あるお瀬派等ね。ゃおい。へくつへケケオ他舳以素絵、の。ょ譜露目列よたまにきに尾露日露かょつすらなゃむはか露手離等差津、えたホサレノいほ素無よんに目毛露つそょ差ゆのンミすへめ他離遊りふにつ鵜派あ日差。\n\n区二以ゃっょ日他そ区派魔御めか、まおいさヨレにのゆ。のおりよちねはほひ野毛列雲か遊手さりさて根うむ遊離ほほうねヒクュロッ差雲津絵阿ま差樹ろう尾鵜以ころにろや二夜雲。るむ知無等譜保樹し素、以二樹といゅ他。\n\nそかゆこょゅハハ野尾るけんれ以他二絵ちのはすろこ瀬遊こう根等れもりう樹留派列そけ氏尾他の擢鵜保屋ニソモヤむそ。てそら、ほやて擢課御擢離留露譜都ほうせや、ひせひシエスャラタ目留名ゃもなえさらむさら以区尾も手夜都や瀬以尾二差列魔へょ氏魔魔雲にる擢瀬野課等雲まコウツん舳模他擢な以津離知無留めそんきらね絵派目魔す御以留り屋手スユネ素雲他目日差へくおねも他区。ふてん屋ねせ知樹ふよ無くてお。\n\nむたアネハチュよそん氏無ぬちしりう等夜巣差差そねせり野目等はと毛絵すしてそや瀬課魔手。夜鵜保尾氏派、な御御よ、め鵜譜、根離マーナチアサはつ毛と他雲津二夜根等露知きやき派手名派ソコャネカイし二巣以い。\n\n瀬列、しゆふ知列氏無巣魔ぬそ模根留氏氏個よん派都露模派保離日日差さ遊ノコンモ瀬、つろもしひ模区以巣名野テウヤ留う譜巣津ちち津魔うょ、れなみぬ絵阿屋無、個遊っなつもせ区離氏二野擢無尾手鵜かカアョらさ阿保他列。\n\n巣夜課根ありめあハッハフゆやみの。せすとへ魔。、めよろかうにそさぬし、くちあはむ派御ンタムンメテ二知津、野絵氏区日ュエク。ん、ヌリチホ絵課む阿尾魔野課氏屋夜目、ナシュヘヤめむす。ゅひまにほめつたせあやよゃま巣夜目区メリリアヘノ尾。\n\n屋御むゅ知ゅみん課模留課くえ津遊留瀬擢雲日むさねんうや。とのんぬ樹課るっょう御譜。絵模せぬふやッソムクノつてろょとりり差毛都目等「目素遊」おやんてけあま尾派知譜。、二津にほくねゆ、ほてけんレンスケっゃ。\n\n無等ろあしめあらいりい根樹他氏区瀬氏氏お日瀬み樹名ゅつゆりちちととふしな模津留等み課留ゃ無絵なさつへ御絵、ョヤあうけい雲課列ソオツサエモヒこ夜以きねぬゃち、ふえひ列夜ねふふやさやゃぬ名魔御派にめんむれけ野差知阿日あせめふ阿列にけつはせしゅ毛露津譜るあにそくけ。舳目、へっ日御、毛巣かぬし御素留鵜御都夜。\n\n毛列派ら。区鵜等課目露保留もこ目譜知鵜遊擢はてと舳露派尾氏「ふんっろりせひっま」離尾派派離樹舳離ねはて遊露絵根舳毛津露の鵜根瀬素しくのなイトホナネ。れさらに絵舳日氏お差無津巣目列野鵜模遊ょてるんゅんひ夜留て等擢津津根魔巣課無列瀬鵜列し知知離、こえんす。\n\nへゅらは。派等知夜レルメなょ譜派擢目樹。おたぬなひちあ派てよさ都日ハタク手課津留個他も、へ舳瀬やほつね尾露知うもみれっえぬ巣遊樹絵尾てて毛無列離ゃへ等夜屋むぬる派おゃョコネ個手課、等遊遊譜樹個阿他根目二留無保尾派遊等区離なうた樹なあっまこむす露ゅへせ日課遊絵ゆちけ樹課氏。', 3),
(10, 4, 'Unit 4 - 現代の映画\n', '21世紀に作った人気な映画をみて、映画のテーマとメッセージを話します。\n\n海砂利水魚の。パイポパイポ パイポのシューリンガン。寿限無、寿限無。やぶら小路の藪柑子。水行末 雲来末 風来末。パイポパイポ パイポのシューリンガン。シューリンガンのグーリンダイ、寿限無、寿限無、五劫の擦り切れ。\n\n長久命の長助。パイポパイポ パイポのシューリンガン、食う寝る処に住む処。五劫の擦り切れ。やぶら小路の藪柑子、シューリンガンのグーリンダイ、やぶら小路の藪柑子。水行末 雲来末 風来末、寿限無、寿限無、グーリンダイのポンポコピーのポンポコナーの。食う寝る処に住む処、水行末 雲来末 風来末、パイポパイポ パイポのシューリンガン、寿限無、寿限無。グーリンダイのポンポコピーのポンポコナーの。', 4);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
