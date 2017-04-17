-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2017 at 04:44 AM
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
(7, 10, '', NULL, 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0);

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
(17, 9, '不思議', 'Mysterious', NULL);

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
(7, 10, '', NULL, 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 0, 0);

--
-- Dumping data for table `module_ge`
--

INSERT INTO `module_ge` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-ge', NULL, 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', NULL, 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0);

--
-- Dumping data for table `module_ls`
--

INSERT INTO `module_ls` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-ls', 'Listening Suggestions-meu!', 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', NULL, 1, 0, 0),
(8, 11, '', NULL, 0, 0, 0),
(9, 12, '', NULL, 0, 0, 0);

--
-- Dumping data for table `module_lt`
--

INSERT INTO `module_lt` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-lt', NULL, 1, 1, 0),
(4, 2, NULL, NULL, 0, 0, 0),
(5, 3, NULL, NULL, 0, 0, 0),
(6, 6, '', NULL, 0, 0, 0),
(7, 10, '', NULL, 0, 1, 0),
(8, 11, '', NULL, 0, 1, 0),
(9, 12, '', NULL, 0, 1, 0);

--
-- Dumping data for table `module_qu`
--

INSERT INTO `module_qu` (`id`, `song_id`, `password`, `name`, `has_password`, `is_enabled`, `song_enabled`) VALUES
(1, 1, 'meumeumeu-qu', NULL, 1, 1, 0),
(2, 3, 'not 4361 - qu', NULL, 1, 1, 0),
(6, 2, 'chikupa-qu', NULL, 1, 0, 0),
(8, 6, 'valleystone', NULL, 1, 1, 1),
(9, 10, '', NULL, 0, 1, 0),
(10, 11, '', NULL, 0, 0, 0),
(11, 12, '', NULL, 0, 1, 0);

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
(6, 11, 'CLOSER was released in year _.', 'fill-blank', 1, NULL, '[{"choice":"2009"}]'),
(7, 11, 'What was the name of the original single that CLOSER was released on?', 'multiple-choice', 2, '[{"choice":"ME ME ME"},{"choice":"CLOSER"},{"choice":"Colors"},{"choice":"Silhouette"}]', '[{"choice":"CLOSER"}]'),
(8, 11, 'What languages did Joe Inoue eventually cover or sing CLOSER in?', 'multiple-select', 3, '[{"choice":"Korean"},{"choice":"Japanese"},{"choice":"English"},{"choice":"Spanish"}]', '[{"choice":"Japanese"},{"choice":"English"}]'),
(9, 12, 'What does 偽善 mean?', 'multiple-choice', 1, '[{"choice":"To lose sight of"},{"choice":"Treasure"},{"choice":"Surreal"},{"choice":"Hypocrisy"}]', '[{"choice":"Hypocrisy"}]'),
(10, 12, '勇気を胸に literally means to have _ in the _.', 'fill-blank', 2, '', '[{"choice":"bravery:strength:courage"},{"choice":"heart:chest"}]'),
(11, 13, 'Why do you think the music video for the song features only Joe Inoue representing all characters?', 'short-answer', NULL, NULL, NULL),
(12, 13, 'In your own terms (and to the best of your ability), describe what is happening in the music video.', 'short-answer', NULL, NULL, NULL),
(13, 14, 'What do you think the title, CLOSER, was trying to convey?', 'short-answer', NULL, NULL, NULL);

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
(1, 3, 'めうめうぺったんたん!!', 1, 'Bitter Sweet Girls', '日向美ビタースイーツ♪', 'meu meu', 'ワールドワイドな荒波ザッバー  商店街はひなびてらぁな 約束手形何万枚だ  ぺったんぺったんぺったんたーん 押して押されて押しも押されぬ  押し問答  こーなりゃ一肌脱いでやらぁにゃ  商店街から萌えおこしーな 可愛いキャララー　ハンコでホワワー  ぺったんぺったんぺったんたーん 押せばお先に推して知るべし　(せーの!!)  押さえどころ  甘くてゆるくてあざとい仕草に  萌えろよ萌えろよ　ハンコをぺったん 赤くてプニくてしっとり濡れてる  やわらかやわらか　朱肉だよ  萌えるハンコは正義のしるし!! ひれつな悪をうちくだくっ!!  めめめめめめめめうめう  めめめめうめう ぺったんぺったんぺったんぺったん  大好き めめめめうめう　めめめめうめう  ハンコで世界中しあわせ!! めめめめうめう　めめめめうめう ぺったんぺったんぺったんぺったん  大好き 合言葉は　萌えおこし　萌えおこし (M・O・K・S!! M・O・K・S!!) ぺたっとぺたっとぺたりこー!!  わふー!!　(わー!!)  ははははは!!　(オイ!!) んんんんん!!　(オイ!!) こここここ!!　(オイ!!)  ハンコ大好きー!!', 'test stuff'),
(2, 3, 'ちくわパフェだよ☆CKP', 2, 'Bitter Sweet Girls', '日向美ビタースイーツ♪', 'chikuwa parfait', 'ちくパちくパ  ちくわのパフェなんだよ！ ちくパちくパ  おいしいめう  おしゃれめう！ ちくパちくパ  CKPCKP  ちくパちくパ  ちくパ最高ーッ！  わぁー！  生クリーム  バニラのアイスに  イチゴとバナナと メインはもちろん（もちろん）  ちくわめう！（ちくわ！） とろけたチョコをかければ完成  ちくパで大丈夫だよ  絶対  大丈夫だよっ！  ｢んきゅーッ！？悪のスイーツ大魔王が現れためう！｣ ｢落ち着いて！このちくわステッキで魔法ちくわ少女に変身するんだよっ！｣ ｢そそそそんな設定聞いてないめう！｣ ｢大丈夫だよ！絶対、大丈夫だよっ！｣  ちくパちくパ  まりまり  ちくパちくパ  もりもり ちくパちくパ  めうめう  ちくパちくパ  めりめり ちくちわ  ちくちくわ  ちくちくちわ  ちくちくちくわ  ちくちくちくちわ  ｢めうーっ！ちくわが折れたぁ！｣ ｢大丈夫！必殺・ちくわの穴から生クリーム光線だよっ！｣ （ドグシャァ　バリバリドッカー　チチクワァ） ｢こうして町に平和が訪れためう｣ ｢ちくわのおかげだねっ！｣  ちくパの味は似ているね  パパパウーパールーパー（違うめう！） みんな笑顔  やぶれかぶれ  無敵のハーモニー ちくパの歯ごたえ  お手前  パパパグーパーチョキパー（勝負めう！） ちくわの穴のぞけば  ほら  キラキラ光る  未来が見える  おーっ！ ちくパちくパ  CKPCKP  ちくパちくパ  ちくパ最高ーッ！                     ｢せーの！｣                        ｢｢ちくパ！｣｣', NULL),
(3, 4, 'NOT 4361 UNIT 3', 3, 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', 'NOT 4361 UNIT 3', NULL),
(6, 3, '君がいる場所へ', 3, 'Form Ride', 'VALLEYSTONE', 'The last song on VALLEYSTONE\'s first album, Form Ride. Also featured in SOUND VOLTEX III GRAVITY WARS.', '君だけのため　光る世界\r\nここにあるよ――\r\n\r\n幼い手で握りしめてた\r\n失くさないよう　ぎゅっと\r\n真っ白な　願いを\r\n君と追いかけて\r\n\r\nまた迷い込む　寂しげな夜だから\r\nあの日の面影を　見つけて\r\n思い出すよ\r\n\r\n君がいるから　どこでだって\r\n何度、転んでも　笑える\r\n偶然だとか　必然だとか\r\n要らないほど　強く\r\nきっと輝く　思い出なら\r\n君の側にだけ　あるから\r\n繋いだ手は　信じてるよ\r\n\r\nその温かさが　嬉しくて\r\nずっと守れるように\r\n強くなりたかった\r\nほら　君のように\r\n\r\nもっと沢山の歌詞は ※ Mojim.com\r\n一緒に歩き　重ねたこの季節は\r\nどれだけの思いも　願いも\r\n分かっているの\r\n\r\nもう大丈夫　君がいれば\r\n心、それだけで　強くなる\r\n過去と未来　どこでもない\r\n今ここにあるから\r\n届いてるかな　君の元へ\r\n明日　また逢える　奇跡を\r\n忘れないで\r\nいつまでも――\r\n\r\nあの日　君と会った　その引力が\r\nそっと　物語を　溶かしていくの\r\nちっぽけな　私も　小さな芽を\r\n優しく抱いて　誰かにいつか\r\n届けたいよ\r\n\r\n君がいるから　どこでだって\r\n何度、転んでも　笑える\r\n偶然だとか　必然だとか\r\n要らないほど　強く\r\nきっと輝く　思い出なら\r\n君の側にだけ　あるから\r\n大切な世界　離さないよ', NULL),
(10, 9, 'CLOSER', 1, 'CLOSER', 'Joe Inoue', 'The title track of the second single of Joe Inoue (井上ジョー). Although released in 2009, it is one of his most popular works to date. The song was used in the Naruto television series.', '身近にある物 \r\n常に気を付けていないと \r\n余りに近すぎて \r\n見失ってしまいそう \r\n\r\nあなたが最近体験した \r\n幸せは一体何ですか? \r\n恵まれすぎていて \r\n思い出せないかも! \r\n\r\n今ここにいる事 \r\n息をしている事 \r\nただそれだけの事が \r\n奇跡だと気付く \r\n\r\n身近にある物 \r\n常に気を付けていないと \r\n余りに近すぎて \r\n見失ってしまいそう \r\n\r\nYou know the closer you get to something \r\nThe tougher it is to see it \r\nAnd I\'ll never take it for granted \r\n\r\nLet\'s go \r\n\r\n人助けを偽善と \r\n呼ぶ奴等もいるけれど \r\n信じるのも疑うのも \r\n人それぞれだから \r\n\r\nたとえ仮にそれが \r\n偽善であったとしても \r\n誰かを救えたなら \r\nそりゃむしろ何よりもリアル \r\n\r\n追い続けてきた夢 \r\nあきらめずに進めよなんて \r\nキレイ事を言えるほど \r\n何も出来ちゃいないけど \r\n\r\n一握りの勇気を胸に \r\n明日を生き抜くために \r\nAnd I\'ll never take it for granted \r\n\r\nLet\'s go', NULL),
(11, 9, 'ヒトヒラのハナビラ', 2, 'ハイドランジアが咲いている', 'STEREOPONY', 'The first single released in 2008 by the Japanese rock group, STEREOPONY. ', 'ヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だったそんな事 思いたくはない \r\n\r\nテーブルの向こう 暗い顔してる \r\n切り出す コトバに 怯えてんだ \r\nいったいいつから僕ら こんなキモチに \r\n気づかないふり続けてたんだ? \r\n出逢った日のような あの透き通る風の中で \r\nやり直せるのなら もう一度 抱きしめたい \r\n\r\nヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だった そんな事 思いたくはない \r\n\r\n好きだった はずだった いつだって声が聞きたくなるほど \r\nそれなのに 手が届く先の君が 見えなくなりそうだ \r\n\r\n平気だってすぐ我慢してたのは \r\nきっと僕たちの悪いトコで \r\nいっつも一緒にいたいって 想ってたのに \r\nすれ違いは現実を変えた? \r\n出逢った日のような あの柔らかな笑顔だって \r\nすぐに取り戻せる 気がしてた 抱きしめたい \r\n\r\nヒトヒラの ハナビラが 揺れている 僕のとなりで今 \r\n間違った 恋だった そんな事 思いたくはない \r\n\r\n黙ったままの君の手のひら \r\nたどり着いたナミダがハジけた \r\nこんな僕たちの 時間を巻き戻して・・・ \r\n\r\nヒトヒラの ハナビラが 舞い落ちた 僕のとなりで今 \r\n間違った 恋だった なんて忘れられるはずはないんだ \r\n\r\n好きだった 好きだった いまだってすがりつきたくなるほど \r\nそれなのに 手が届く先の君が 見えなくなりそうだ', NULL),
(12, 9, 'Snow Halation', 3, 'Snow Halation', 'μ’s', 'The second single produced by μ’s in 2010. Arguably the most popular song that lead to their overwhelming fame and popularity in Japan.', '不思議だね　いまの気持ち \r\n空から降ってきたみたい \r\n特別な季節の色が　ときめきを見せるよ \r\n\r\n初めて出会った時から \r\n予\\感に騒ぐ心のMelody \r\nとめられないとまらない　な・ぜ \r\n\r\n届けて \r\n切なさには名前をつけようか“Snow halation” \r\n想いが重なるまで待てずに \r\n悔しいけど好きって純情 \r\n微熱の中　ためらってもダメだね \r\n飛び込む勇気に賛成 まもなくStart!! \r\n\r\n音もなく　気配もなく \r\n静かに運命は変わる \r\nこれからの未来に胸の　鼓動が早くなる \r\n\r\n例えば困った時には \r\nすぐ駆けつけて抱きしめたくて \r\nどこにいてもどこでも　Fly high \r\n\r\n急いで \r\nいつの間にか大きくなりすぎた“True emotion” \r\n夢だけみてる様じゃつらいよ \r\n恋人は君って言いたい \r\n優しい目が　とまどってるイヤだよ \r\nこのまま一気に愛情 あずけてPlease!! \r\n\r\n届けて \r\n切なさには名前をつけようか“Snow halation” \r\n想いが重なるまで待てずに \r\n悔しいけど好きって純情 \r\n微熱の中　ためらってもダメだね \r\n飛び込む勇気に賛成 まもなくStart!!', NULL);

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
(7, 4, 'Unit 1 - Introduction', 'Welcome to Japanese 4215: Modern Japanese Culture!', 1),
(8, 4, 'Unit 2 - Brief History', 'A quick overview of culture and history up to the 21st century.', 2),
(9, 4, 'Unit 3 - Popular Songs', 'Several popular songs released in the 21st century will be discussed in this unit, along with their impact on popular culture.', 3),
(10, 4, 'Unit 4 - Popular Movies', 'Several popular movies and their impact on Japanese culture will be discussed in this unit.', 4);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
