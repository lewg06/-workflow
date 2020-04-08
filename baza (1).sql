-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 08 2020 г., 19:26
-- Версия сервера: 10.1.34-MariaDB
-- Версия PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `baza`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dostup`
--

CREATE TABLE `dostup` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Виды прав доступа';

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE `file` (
  `nom` int(10) NOT NULL,
  `kod_oborud` int(10) NOT NULL,
  `put` varchar(500) NOT NULL,
  `user` int(10) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица содержит путь к картинкам';

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent` int(10) NOT NULL DEFAULT '1',
  `sort` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Основное меню';

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`nom`, `name`, `parent`, `sort`) VALUES
(1, 'Главное меню', 0, 0),
(2, 'События', 1, 0),
(3, 'Оборудование', 1, 0),
(5, 'Задание на работу', 1, 0),
(6, 'График работы', 1, 0),
(7, 'Манометры', 3, 0),
(8, 'Датчики давления', 3, 0),
(9, 'УМС', 7, 0),
(10, 'Добыча газа', 7, 0),
(11, 'Добыча нефти', 7, 0),
(12, 'ПКИОС', 7, 0),
(14, 'Добыча нефти', 8, 0),
(15, 'Добыча газа', 8, 0),
(16, 'УМС', 8, 0),
(17, 'Test', 1, 0),
(18, 'test2', 1, 0),
(19, 'test3', 1, 0),
(20, 'test4', 1, 0),
(21, 'test2', 17, 0),
(22, 'test2', 18, 0),
(23, 'test2', 22, 0),
(24, 'test2', 3, 0),
(25, 'test2', 2, 0),
(26, 'Услуги', 6, 0),
(27, 'test2', 25, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `oborud`
--

CREATE TABLE `oborud` (
  `nom` int(10) NOT NULL,
  `kod_tip` int(10) NOT NULL,
  `id_menu` int(10) NOT NULL,
  `proverka` varchar(500) NOT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(10) NOT NULL,
  `prim` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица связки меню, типа прибора и параметров';

--
-- Дамп данных таблицы `oborud`
--

INSERT INTO `oborud` (`nom`, `kod_tip`, `id_menu`, `proverka`, `del`, `data`, `user`, `prim`) VALUES
(1, 6, 1, 'a2c945a7870ececfbf6a2a753972f87c', NULL, '2019-04-28 17:43:33', 1, NULL),
(2, 6, 1, '227f7a09aed3bd4c39f4c7df48735c89', NULL, '2019-04-28 17:59:23', 1, NULL),
(3, 6, 17, '564f365cbf8169f03496705cfb712c38', NULL, '2019-04-28 18:02:05', 1, NULL),
(4, 6, 17, '32e92250eeaf0eb7ac13c6e824d1f343', NULL, '2019-04-28 18:03:38', 1, NULL),
(5, 6, 17, 'b9b0d31e695138981148a13b9338381c', NULL, '2019-04-28 18:04:50', 1, NULL),
(6, 6, 17, '9a71c02cc6f593aae58abf720660d3b2', NULL, '2019-04-28 18:14:11', 1, NULL),
(7, 6, 17, '57056838fbbcad56531fe3c8d270dff2', NULL, '2019-05-01 05:08:15', 1, NULL),
(62, 6, 26, '7aec8e581134b1c2479854f82d329cf2', NULL, '2019-05-02 04:53:21', 1, NULL),
(63, 6, 26, 'fac73746292277e8ba3d9f5a81d9d746', NULL, '2019-05-02 04:53:35', 1, NULL),
(64, 6, 26, 'b42ad10ed9557a08899af3ace8cafee3', NULL, '2019-05-02 04:55:53', 1, NULL),
(65, 6, 26, 'b401dc57e7c6470e87ac4579e792aad9', NULL, '2019-05-02 04:59:20', 1, NULL),
(66, 6, 26, '5fb6b2af051a303c0717084abfb90a25', NULL, '2019-05-02 04:59:40', 1, NULL),
(67, 6, 26, 'b62137d0626ad4ee59d1d8c4fc77d2a3', NULL, '2019-05-02 05:00:30', 1, NULL),
(68, 6, 26, '604a8a8a48ac3047b145cfc2de3a7586', NULL, '2019-05-02 05:03:02', 1, NULL),
(69, 6, 26, '0b5938896abf8b342957a5c3a54a54db', NULL, '2019-05-02 05:51:42', 1, NULL),
(70, 6, 26, '456d9c2d741ed4caf08e138d987fc37a', NULL, '2019-05-02 05:52:56', 1, NULL),
(71, 6, 1, '6caf461422469c7e103487389c3e92d6', NULL, '2019-05-08 20:08:29', 1, NULL),
(72, 6, 1, '4a1e0ec9cfe5fee8a5877c1eceac84a6', NULL, '2019-05-08 20:08:51', 1, NULL),
(73, 6, 1, '86a046c9b56fc569c3891aaf8e61fcc4', NULL, '2019-05-08 20:08:59', 1, NULL),
(74, 2, 1, '1499a306f475ce80dfddb3ce09a8b838', NULL, '2019-05-08 20:13:51', 1, NULL),
(75, 2, 1, 'fcbfb2905fd0b331e05b5a2b0ff211c4', NULL, '2019-05-08 20:19:41', 1, NULL),
(76, 2, 1, 'fb0c29d552b8be7ed4fd7600d1485da5', NULL, '2019-05-08 20:22:44', 1, NULL),
(77, 2, 1, '4601b7e6f0e14c01c8362625e8fcc5bb', NULL, '2019-05-08 20:23:05', 1, NULL),
(78, 8, 1, 'd8e86e703f7f296f584a2a905aba6a86', NULL, '2019-05-25 19:04:05', 1, NULL),
(79, 8, 1, '8e187f97c0415644f661217885935652', NULL, '2019-05-26 04:14:02', 1, NULL),
(80, 8, 1, '2178977c61ea2c9be7d8e837e5c41573', NULL, '2019-05-26 04:14:08', 1, NULL),
(81, 8, 1, '58f0b423fe59e8cbe1601a3b7615067e', NULL, '2019-05-26 04:14:26', 1, NULL),
(82, 8, 1, 'd1e96525e69b5329dfa5d25d014f299d', NULL, '2019-05-26 04:15:49', 1, NULL),
(83, 8, 1, '7c74f1dc05d5f64c59d32c27d456bc3e', NULL, '2019-05-26 04:15:52', 1, NULL),
(84, 7, 6, 'bb8de8af3ca1c0294449fdedb42b39f6', NULL, '2019-05-27 21:06:12', 1, NULL),
(85, 6, 16, 'f4655839c5202549c0b5f40e73669eee', NULL, '2019-06-07 18:47:50', 1, NULL),
(86, 6, 16, 'b072f4cd48a4765eee044b1a94fd3b3a', NULL, '2019-06-07 18:48:26', 1, NULL),
(87, 8, 1, '369aeca06d140f17d054fe06426ffdf8', NULL, '2019-06-25 07:19:42', 1, NULL),
(88, 1, 10, 'b64321aa36094327aabcf8f6549c788c', NULL, '2019-06-25 12:38:34', 1, NULL),
(89, 1, 7, '66cb219c9b33d6c3117ec5bb6b7e3526', NULL, '2019-07-26 09:41:03', 1, NULL),
(90, 1, 7, '7f05b37b2d4ff046886ba617762e98c9', NULL, '2019-07-26 09:41:11', 1, NULL),
(91, 6, 8, '981af33545c5c78a0917f4ade5371fc3', NULL, '2019-07-26 09:47:53', 1, NULL),
(92, 6, 3, '773afc07f62527198b714fd545e6204b', NULL, '2019-07-26 09:50:47', 1, NULL),
(93, 8, 1, '42922982ea60bc9ef10aa7bf0b932569', NULL, '2019-08-11 06:00:32', 1, NULL),
(94, 8, 1, '07efb927235c5c2a605f6db1fa2a6cb9', NULL, '2019-08-11 06:01:00', 1, NULL),
(95, 8, 1, '46e0ac0f0f0f23b4532a13821e6169bd', NULL, '2019-08-11 06:12:21', 1, NULL),
(96, 8, 1, '462dc8129abb730b402d31c07f6dea7f', NULL, '2019-08-11 06:13:15', 1, NULL),
(97, 13, 1, '18683bdad8c0d2309e6ebe8bd27106f7', NULL, '2019-08-13 04:56:38', 1, NULL),
(98, 13, 1, '81cd6716b640e9fd9f9b587e608bc576', NULL, '2019-08-13 04:57:04', 1, NULL),
(99, 13, 1, '859dc19ca960d82b9eb6823d3eca0712', NULL, '2019-08-13 04:57:13', 1, NULL),
(100, 1, 1, '9b10fe5112bf39c527d355a69f5956ef', NULL, '2019-08-13 05:09:04', 1, NULL),
(101, 14, 1, '47317b9e8b2bf97ffb4befe6e2202c43', NULL, '2019-08-13 05:09:27', 1, NULL),
(102, 6, 8, '56dc69b9f03b2eac8eac0dc31368657a', NULL, '2019-08-20 13:02:11', 1, NULL),
(103, 13, 1, '44cee6be35f0b9e0aebcfe84923c2738', NULL, '2019-08-20 16:33:36', 1, NULL),
(104, 16, 27, '21b397b26595db9761e7c9741ae2ee2e', NULL, '2019-08-22 04:42:50', 1, NULL),
(105, 2, 10, '87ff9edc83f4b7fe6bffb317ba3a051e', NULL, '2020-04-06 13:55:03', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `oborud_param`
--

CREATE TABLE `oborud_param` (
  `nom` int(10) NOT NULL,
  `kod_oborud` int(10) NOT NULL,
  `kod_param` int(10) NOT NULL,
  `value_int` int(10) NOT NULL,
  `value_text` varchar(500) DEFAULT NULL,
  `value_date` date DEFAULT NULL,
  `value_fail` varchar(500) DEFAULT NULL,
  `value_folder` varchar(500) DEFAULT NULL,
  `value_bool` tinyint(1) DEFAULT NULL,
  `zagolovok` int(10) DEFAULT NULL,
  `proverka` varchar(500) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(10) NOT NULL,
  `prim` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с данными для оборудования';

--
-- Дамп данных таблицы `oborud_param`
--

INSERT INTO `oborud_param` (`nom`, `kod_oborud`, `kod_param`, `value_int`, `value_text`, `value_date`, `value_fail`, `value_folder`, `value_bool`, `zagolovok`, `proverka`, `sort`, `del`, `data`, `user`, `prim`) VALUES
(1, 0, 0, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-28 17:59:23', 0, NULL),
(2, 6, 2, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-28 18:14:11', 0, NULL),
(142, 69, 2, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(143, 69, 3, 0, NULL, '0019-05-25', NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(144, 69, 8, 0, NULL, '2019-04-15', NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(145, 69, 9, 0, 'r', NULL, NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(146, 69, 10, 0, NULL, NULL, NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(147, 69, 14, -1, NULL, NULL, NULL, NULL, NULL, NULL, '0b5938896abf8b342957a5c3a54a54db', NULL, NULL, '2019-05-02 05:51:42', 0, NULL),
(148, 70, 2, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(149, 70, 3, 0, NULL, '0019-05-25', NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(150, 70, 8, 0, NULL, '2019-04-15', NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(151, 70, 9, 0, 'r', NULL, NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(152, 70, 10, 5, NULL, NULL, NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(153, 70, 14, -1, NULL, NULL, NULL, NULL, NULL, NULL, '456d9c2d741ed4caf08e138d987fc37a', NULL, NULL, '2019-05-02 05:52:56', 0, NULL),
(154, 71, 9, 0, 'r', NULL, NULL, NULL, NULL, NULL, '6caf461422469c7e103487389c3e92d6', NULL, NULL, '2019-05-08 20:08:29', 0, NULL),
(155, 72, 9, 0, 'r', NULL, NULL, NULL, NULL, NULL, '4a1e0ec9cfe5fee8a5877c1eceac84a6', NULL, NULL, '2019-05-08 20:08:51', 0, NULL),
(156, 73, 3, 0, NULL, '9999-05-25', NULL, NULL, NULL, NULL, '86a046c9b56fc569c3891aaf8e61fcc4', NULL, NULL, '2019-05-08 20:08:59', 0, NULL),
(157, 74, 7, 0, '', NULL, NULL, NULL, NULL, NULL, '1499a306f475ce80dfddb3ce09a8b838', NULL, NULL, '2019-05-08 20:13:51', 0, NULL),
(158, 75, 7, 0, '', NULL, NULL, NULL, NULL, NULL, 'fcbfb2905fd0b331e05b5a2b0ff211c4', NULL, NULL, '2019-05-08 20:19:41', 0, NULL),
(159, 76, 7, 0, '', NULL, NULL, NULL, NULL, NULL, 'fb0c29d552b8be7ed4fd7600d1485da5', NULL, NULL, '2019-05-08 20:22:44', 0, NULL),
(160, 77, 7, 0, '', NULL, NULL, NULL, NULL, NULL, '4601b7e6f0e14c01c8362625e8fcc5bb', NULL, NULL, '2019-05-08 20:23:05', 0, NULL),
(161, 78, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, 'd8e86e703f7f296f584a2a905aba6a86', NULL, NULL, '2019-05-25 19:04:05', 0, NULL),
(162, 78, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, 'd8e86e703f7f296f584a2a905aba6a86', NULL, NULL, '2019-05-25 19:04:06', 0, NULL),
(163, 79, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '8e187f97c0415644f661217885935652', NULL, NULL, '2019-05-26 04:14:02', 0, NULL),
(164, 79, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '8e187f97c0415644f661217885935652', NULL, NULL, '2019-05-26 04:14:02', 0, NULL),
(165, 80, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '2178977c61ea2c9be7d8e837e5c41573', NULL, NULL, '2019-05-26 04:14:08', 0, NULL),
(166, 80, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '2178977c61ea2c9be7d8e837e5c41573', NULL, NULL, '2019-05-26 04:14:08', 0, NULL),
(167, 81, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '58f0b423fe59e8cbe1601a3b7615067e', NULL, NULL, '2019-05-26 04:14:26', 0, NULL),
(168, 81, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '58f0b423fe59e8cbe1601a3b7615067e', NULL, NULL, '2019-05-26 04:14:26', 0, NULL),
(169, 82, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, 'd1e96525e69b5329dfa5d25d014f299d', NULL, NULL, '2019-05-26 04:15:49', 0, NULL),
(170, 82, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, 'd1e96525e69b5329dfa5d25d014f299d', NULL, NULL, '2019-05-26 04:15:49', 0, NULL),
(171, 83, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '7c74f1dc05d5f64c59d32c27d456bc3e', NULL, NULL, '2019-05-26 04:15:52', 0, NULL),
(172, 83, 3, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '7c74f1dc05d5f64c59d32c27d456bc3e', NULL, NULL, '2019-05-26 04:15:52', 0, NULL),
(173, 84, 9, 0, 'gj', NULL, NULL, NULL, NULL, NULL, 'bb8de8af3ca1c0294449fdedb42b39f6', NULL, NULL, '2019-05-27 21:06:12', 0, NULL),
(174, 84, 15, 500, NULL, NULL, NULL, NULL, NULL, NULL, 'bb8de8af3ca1c0294449fdedb42b39f6', NULL, NULL, '2019-05-27 21:06:12', 0, NULL),
(175, 86, 2, 0, 'Элемер', NULL, NULL, NULL, NULL, NULL, 'b072f4cd48a4765eee044b1a94fd3b3a', NULL, NULL, '2019-06-07 18:48:26', 0, NULL),
(176, 86, 3, 0, NULL, '2018-06-23', NULL, NULL, NULL, NULL, 'b072f4cd48a4765eee044b1a94fd3b3a', NULL, NULL, '2019-06-07 18:48:26', 0, NULL),
(177, 86, 8, 0, NULL, NULL, NULL, NULL, NULL, NULL, 'b072f4cd48a4765eee044b1a94fd3b3a', NULL, NULL, '2019-06-07 18:48:26', 0, NULL),
(178, 86, 9, 0, '', NULL, NULL, NULL, NULL, NULL, 'b072f4cd48a4765eee044b1a94fd3b3a', NULL, NULL, '2019-06-07 18:48:26', 0, NULL),
(179, 87, 2, 0, 'Клёш', NULL, NULL, NULL, NULL, NULL, '369aeca06d140f17d054fe06426ffdf8', NULL, NULL, '2019-06-25 07:19:42', 0, NULL),
(180, 87, 3, 0, NULL, '2019-04-01', NULL, NULL, NULL, NULL, '369aeca06d140f17d054fe06426ffdf8', NULL, NULL, '2019-06-25 07:19:42', 0, NULL),
(181, 87, 15, 5000, NULL, NULL, NULL, NULL, NULL, NULL, '369aeca06d140f17d054fe06426ffdf8', NULL, NULL, '2019-06-25 07:19:42', 0, NULL),
(182, 87, 16, 0, '54', NULL, NULL, NULL, NULL, NULL, '369aeca06d140f17d054fe06426ffdf8', NULL, NULL, '2019-06-25 07:19:42', 0, NULL),
(183, 88, 8, 0, NULL, '2018-10-01', NULL, NULL, NULL, NULL, 'b64321aa36094327aabcf8f6549c788c', NULL, NULL, '2019-06-25 12:38:35', 0, NULL),
(184, 88, 18, 0, 'Скв 1037', NULL, NULL, NULL, NULL, NULL, 'b64321aa36094327aabcf8f6549c788c', NULL, NULL, '2019-06-25 12:38:35', 0, NULL),
(185, 89, 8, 0, NULL, '2018-04-15', NULL, NULL, NULL, NULL, '66cb219c9b33d6c3117ec5bb6b7e3526', NULL, NULL, '2019-07-26 09:41:03', 0, NULL),
(186, 89, 18, 0, 'труба', NULL, NULL, NULL, NULL, NULL, '66cb219c9b33d6c3117ec5bb6b7e3526', NULL, NULL, '2019-07-26 09:41:03', 0, NULL),
(187, 90, 8, 0, NULL, '2019-04-15', NULL, NULL, NULL, NULL, '7f05b37b2d4ff046886ba617762e98c9', NULL, NULL, '2019-07-26 09:41:11', 0, NULL),
(188, 90, 18, 0, 'труба 1', NULL, NULL, NULL, NULL, NULL, '7f05b37b2d4ff046886ba617762e98c9', NULL, NULL, '2019-07-26 09:41:11', 0, NULL),
(189, 91, 2, 0, 'Элемер', NULL, NULL, NULL, NULL, NULL, '981af33545c5c78a0917f4ade5371fc3', NULL, NULL, '2019-07-26 09:47:53', 0, NULL),
(190, 91, 8, 0, NULL, '2020-06-23', NULL, NULL, NULL, NULL, '981af33545c5c78a0917f4ade5371fc3', NULL, NULL, '2019-07-26 09:47:54', 0, NULL),
(191, 91, 9, 0, 'FT201', NULL, NULL, NULL, NULL, NULL, '981af33545c5c78a0917f4ade5371fc3', NULL, NULL, '2019-07-26 09:47:54', 0, NULL),
(192, 91, 14, 5, NULL, NULL, NULL, NULL, NULL, NULL, '981af33545c5c78a0917f4ade5371fc3', NULL, NULL, '2019-07-26 09:47:54', 0, NULL),
(193, 92, 2, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, '773afc07f62527198b714fd545e6204b', NULL, NULL, '2019-07-26 09:50:47', 0, NULL),
(194, 92, 3, 0, NULL, '9999-05-25', NULL, NULL, NULL, NULL, '773afc07f62527198b714fd545e6204b', NULL, NULL, '2019-07-26 09:50:47', 0, NULL),
(195, 92, 9, 0, '', NULL, NULL, NULL, NULL, NULL, '773afc07f62527198b714fd545e6204b', NULL, NULL, '2019-07-26 09:50:47', 0, NULL),
(196, 93, 2, 0, 'Классические', NULL, NULL, NULL, NULL, NULL, '42922982ea60bc9ef10aa7bf0b932569', NULL, NULL, '2019-08-11 06:00:32', 0, NULL),
(197, 93, 3, 0, NULL, '1956-09-18', NULL, NULL, NULL, NULL, '42922982ea60bc9ef10aa7bf0b932569', NULL, NULL, '2019-08-11 06:00:32', 0, NULL),
(198, 93, 15, 3000, NULL, NULL, NULL, NULL, NULL, NULL, '42922982ea60bc9ef10aa7bf0b932569', NULL, NULL, '2019-08-11 06:00:32', 0, NULL),
(199, 93, 16, 0, '52', NULL, NULL, NULL, NULL, NULL, '42922982ea60bc9ef10aa7bf0b932569', NULL, NULL, '2019-08-11 06:00:32', 0, NULL),
(200, 94, 2, 0, 'Классические', NULL, NULL, NULL, NULL, NULL, '07efb927235c5c2a605f6db1fa2a6cb9', NULL, NULL, '2019-08-11 06:01:00', 0, NULL),
(201, 94, 3, 0, NULL, '1956-09-18', NULL, NULL, NULL, NULL, '07efb927235c5c2a605f6db1fa2a6cb9', NULL, NULL, '2019-08-11 06:01:00', 0, NULL),
(202, 94, 15, 3000, NULL, NULL, NULL, NULL, NULL, NULL, '07efb927235c5c2a605f6db1fa2a6cb9', NULL, NULL, '2019-08-11 06:01:00', 0, NULL),
(203, 94, 16, 0, '52', NULL, NULL, NULL, NULL, NULL, '07efb927235c5c2a605f6db1fa2a6cb9', NULL, NULL, '2019-08-11 06:01:00', 0, NULL),
(204, 95, 2, 0, 'Классические', NULL, NULL, NULL, NULL, NULL, '46e0ac0f0f0f23b4532a13821e6169bd', NULL, NULL, '2019-08-11 06:12:21', 0, NULL),
(205, 95, 3, 0, NULL, '1956-09-18', NULL, NULL, NULL, NULL, '46e0ac0f0f0f23b4532a13821e6169bd', NULL, NULL, '2019-08-11 06:12:21', 0, NULL),
(206, 95, 15, 3000, NULL, NULL, NULL, NULL, NULL, NULL, '46e0ac0f0f0f23b4532a13821e6169bd', NULL, NULL, '2019-08-11 06:12:21', 0, NULL),
(207, 95, 16, 0, '52', NULL, NULL, NULL, NULL, NULL, '46e0ac0f0f0f23b4532a13821e6169bd', NULL, NULL, '2019-08-11 06:12:21', 0, NULL),
(208, 96, 2, 0, 'Классические', NULL, NULL, NULL, NULL, NULL, '462dc8129abb730b402d31c07f6dea7f', NULL, NULL, '2019-08-11 06:13:15', 0, NULL),
(209, 96, 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, '462dc8129abb730b402d31c07f6dea7f', NULL, NULL, '2019-08-11 06:13:15', 0, NULL),
(210, 96, 15, 3001, NULL, NULL, NULL, NULL, NULL, NULL, '462dc8129abb730b402d31c07f6dea7f', NULL, NULL, '2019-08-11 06:13:15', 0, NULL),
(211, 96, 16, 0, '54', NULL, NULL, NULL, NULL, NULL, '462dc8129abb730b402d31c07f6dea7f', NULL, NULL, '2019-08-11 06:13:15', 0, NULL),
(212, 97, 2, 0, 'Победа', NULL, NULL, NULL, NULL, NULL, '18683bdad8c0d2309e6ebe8bd27106f7', NULL, NULL, '2019-08-13 04:56:39', 0, NULL),
(213, 97, 3, 0, NULL, '2019-04-12', NULL, NULL, NULL, NULL, '18683bdad8c0d2309e6ebe8bd27106f7', NULL, NULL, '2019-08-13 04:56:39', 0, NULL),
(214, 97, 15, 600, NULL, NULL, NULL, NULL, NULL, NULL, '18683bdad8c0d2309e6ebe8bd27106f7', NULL, NULL, '2019-08-13 04:56:39', 0, NULL),
(215, 98, 2, 0, 'Победа', NULL, NULL, NULL, NULL, NULL, '81cd6716b640e9fd9f9b587e608bc576', NULL, NULL, '2019-08-13 04:57:04', 0, NULL),
(216, 98, 3, 0, NULL, '2019-04-12', NULL, NULL, NULL, NULL, '81cd6716b640e9fd9f9b587e608bc576', NULL, NULL, '2019-08-13 04:57:04', 0, NULL),
(217, 98, 15, 500, NULL, NULL, NULL, NULL, NULL, NULL, '81cd6716b640e9fd9f9b587e608bc576', NULL, NULL, '2019-08-13 04:57:04', 0, NULL),
(218, 99, 2, 0, 'Победа', NULL, NULL, NULL, NULL, NULL, '859dc19ca960d82b9eb6823d3eca0712', NULL, NULL, '2019-08-13 04:57:13', 0, NULL),
(219, 99, 3, 0, NULL, '2019-04-12', NULL, NULL, NULL, NULL, '859dc19ca960d82b9eb6823d3eca0712', NULL, NULL, '2019-08-13 04:57:13', 0, NULL),
(220, 99, 15, 500, NULL, NULL, NULL, NULL, NULL, NULL, '859dc19ca960d82b9eb6823d3eca0712', NULL, NULL, '2019-08-13 04:57:13', 0, NULL),
(221, 100, 18, 0, 'труба', NULL, NULL, NULL, NULL, NULL, '9b10fe5112bf39c527d355a69f5956ef', NULL, NULL, '2019-08-13 05:09:04', 0, NULL),
(222, 101, 2, 0, 'Элемер', NULL, NULL, NULL, NULL, NULL, '47317b9e8b2bf97ffb4befe6e2202c43', NULL, NULL, '2019-08-13 05:09:27', 0, NULL),
(223, 101, 15, 500, NULL, NULL, NULL, NULL, NULL, NULL, '47317b9e8b2bf97ffb4befe6e2202c43', NULL, NULL, '2019-08-13 05:09:27', 0, NULL),
(224, 102, 2, 0, 'Метран', NULL, NULL, NULL, NULL, NULL, '56dc69b9f03b2eac8eac0dc31368657a', NULL, NULL, '2019-08-20 13:02:11', 0, NULL),
(225, 102, 9, 0, 'FT201', NULL, NULL, NULL, NULL, NULL, '56dc69b9f03b2eac8eac0dc31368657a', NULL, NULL, '2019-08-20 13:02:11', 0, NULL),
(226, 92, 8, 0, NULL, '2019-04-30', NULL, NULL, NULL, NULL, '', NULL, NULL, '2019-08-20 13:06:32', 0, NULL),
(227, 103, 2, 0, '', NULL, NULL, NULL, NULL, NULL, '44cee6be35f0b9e0aebcfe84923c2738', NULL, NULL, '2019-08-20 16:33:37', 0, NULL),
(228, 104, 2, 0, 'Классические', NULL, NULL, NULL, NULL, NULL, '21b397b26595db9761e7c9741ae2ee2e', NULL, NULL, '2019-08-22 04:42:50', 0, NULL),
(229, 104, 15, 500, NULL, NULL, NULL, NULL, NULL, NULL, '21b397b26595db9761e7c9741ae2ee2e', NULL, NULL, '2019-08-22 04:42:50', 0, NULL),
(230, 105, 1, 0, NULL, '2019-05-25', NULL, NULL, NULL, NULL, '87ff9edc83f4b7fe6bffb317ba3a051e', NULL, NULL, '2020-04-06 13:55:03', 0, NULL),
(231, 105, 7, 0, '', NULL, NULL, NULL, NULL, NULL, '87ff9edc83f4b7fe6bffb317ba3a051e', NULL, NULL, '2020-04-06 13:55:03', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `param`
--

CREATE TABLE `param` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` int(10) NOT NULL,
  `value_char` varchar(50) DEFAULT NULL,
  `value_data` timestamp NULL DEFAULT NULL,
  `value_folder` varchar(500) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `user` int(10) NOT NULL,
  `prim` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Параметры';

--
-- Дамп данных таблицы `param`
--

INSERT INTO `param` (`nom`, `name`, `type`, `value_char`, `value_data`, `value_folder`, `sort`, `del`, `user`, `prim`) VALUES
(1, 'ddd', 2, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(2, 'Наименование', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(3, 'Дата изготовления', 2, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(7, 'Файл', 3, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(8, 'Дата поверки', 2, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(9, 'Позиция', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(10, 'Инвентарный номер', 4, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(11, 'Снят в поверку', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(12, 'Снят в калибровку', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(13, 'Отправлен в ГПУ', 5, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(14, 'Диаметр фланца', 4, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(15, 'Цена', 4, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(16, 'Размер', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(17, 'Диаметр', 4, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(18, 'Место установки', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(19, 'Марка', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pic`
--

CREATE TABLE `pic` (
  `nom` int(10) NOT NULL,
  `kod_oborud` int(10) NOT NULL,
  `put` varchar(500) NOT NULL,
  `user` int(10) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица содержит путь к картинкам';

-- --------------------------------------------------------

--
-- Структура таблицы `soob`
--

CREATE TABLE `soob` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id` int(10) NOT NULL,
  `tip_soob` int(10) NOT NULL,
  `vid_soob` int(10) NOT NULL,
  `data_soob` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `del` timestamp NULL DEFAULT NULL,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Сообшения для пользователя';

-- --------------------------------------------------------

--
-- Структура таблицы `soob_param`
--

CREATE TABLE `soob_param` (
  `nom` int(10) NOT NULL,
  `kod_soob` int(10) NOT NULL,
  `kod_oborud` int(10) DEFAULT NULL,
  `kod_tip` int(10) DEFAULT NULL,
  `kod_param` int(10) DEFAULT NULL,
  `kod_file` int(10) DEFAULT NULL,
  `kod_pic` int(10) DEFAULT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица связи оборудования и сообщений';

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `nom` int(11) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`nom`, `color`) VALUES
(1, 'красный'),
(2, 'оранжевый'),
(3, 'жёлтый'),
(4, 'зелёный'),
(5, 'голубой'),
(6, 'синий'),
(7, 'фиолетовый');

-- --------------------------------------------------------

--
-- Структура таблицы `tip`
--

CREATE TABLE `tip` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `user` int(10) NOT NULL,
  `prim` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы оборудования  и не только';

--
-- Дамп данных таблицы `tip`
--

INSERT INTO `tip` (`nom`, `name`, `del`, `user`, `prim`) VALUES
(1, 'Манометры', NULL, 0, NULL),
(2, 'Противогазы', NULL, 0, NULL),
(3, 'Датчики давления', NULL, 0, NULL),
(4, 'Уровнемеры', NULL, 0, NULL),
(5, 'ЭКМ', NULL, 0, NULL),
(6, 'Расходомеры', NULL, 0, NULL),
(7, 'Сумочки', NULL, 0, NULL),
(8, 'Брюки', NULL, 0, NULL),
(9, 'Трубы', NULL, 0, NULL),
(10, 'Огнетушители', NULL, 0, NULL),
(11, 'Наушники', NULL, 0, NULL),
(12, 'ручки', NULL, 0, NULL),
(13, 'Футболки', NULL, 0, NULL),
(14, 'Фильтр', NULL, 0, NULL),
(15, 'KIA', NULL, 0, NULL),
(16, 'юбки', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tip_field`
--

CREATE TABLE `tip_field` (
  `nom` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `shablon` varchar(500) DEFAULT NULL,
  `proverka` varchar(500) DEFAULT NULL,
  `field_oborud` varchar(200) NOT NULL,
  `field_type` varchar(100) DEFAULT NULL,
  `kov` varchar(10) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы полей с шаблонами';

--
-- Дамп данных таблицы `tip_field`
--

INSERT INTO `tip_field` (`nom`, `name`, `shablon`, `proverka`, `field_oborud`, `field_type`, `kov`, `sort`) VALUES
(1, 'Текстовое поле', NULL, 't', 'value_text', 'text', '\"', NULL),
(2, 'Тип поля ДАТА', '[0-9]{2}.[0-9]{2}.[0-9]{4}', 'd', 'value_date', 'text', '\"', NULL),
(3, 'Поле типа Файл', '', 'f', 'value_text', 'text', '\"', NULL),
(4, 'Числовое поле', '', 'n', 'value_int', 'text', NULL, NULL),
(5, 'Тип поля ЛОГИЧЕСКИЙ (ДА/НЕТ)', NULL, 'l', 'value_bool', 'checkbox', '\"', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tip_param`
--

CREATE TABLE `tip_param` (
  `nom` int(10) NOT NULL,
  `tip` int(10) NOT NULL,
  `param` int(11) NOT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица связи типов с доступными параметрами';

--
-- Дамп данных таблицы `tip_param`
--

INSERT INTO `tip_param` (`nom`, `tip`, `param`, `del`, `sort`, `user`) VALUES
(36, 2, 1, NULL, 0, 0),
(37, 2, 7, NULL, 0, 0),
(38, 6, 3, NULL, 0, 0),
(39, 6, 8, NULL, 0, 0),
(40, 6, 10, NULL, 0, 0),
(41, 6, 2, NULL, 0, 0),
(42, 6, 9, NULL, 0, 0),
(43, 6, 14, NULL, 0, 0),
(44, 6, 13, NULL, 0, 0),
(45, 7, 9, NULL, 0, 0),
(46, 7, 15, NULL, 0, 0),
(48, 8, 3, NULL, 0, 0),
(49, 8, 2, NULL, 0, 0),
(50, 8, 15, NULL, 0, 0),
(51, 8, 16, NULL, 0, 0),
(52, 1, 8, NULL, 0, 0),
(53, 1, 18, NULL, 0, 0),
(60, 4, 3, NULL, 0, 0),
(61, 11, 2, NULL, 0, 0),
(63, 12, 2, NULL, 0, 0),
(64, 12, 16, NULL, 0, 0),
(65, 12, 15, NULL, 0, 0),
(67, 12, 19, NULL, 0, 0),
(69, 11, 3, NULL, 0, 0),
(71, 13, 15, NULL, 0, 0),
(72, 14, 3, NULL, 0, 0),
(73, 14, 8, NULL, 0, 0),
(74, 14, 17, NULL, 0, 0),
(75, 14, 14, NULL, 0, 0),
(76, 14, 19, NULL, 0, 0),
(77, 14, 18, NULL, 0, 0),
(78, 14, 2, NULL, 0, 0),
(79, 14, 15, NULL, 0, 0),
(80, 13, 2, NULL, 0, 0),
(81, 13, 3, NULL, 0, 0),
(82, 1, 2, NULL, 0, 0),
(83, 1, 3, NULL, 0, 0),
(84, 13, 8, NULL, 0, 0),
(85, 13, 9, NULL, 0, 0),
(86, 15, 10, NULL, 0, 0),
(87, 15, 2, NULL, 0, 0),
(88, 15, 15, NULL, 0, 0),
(89, 16, 3, NULL, 0, 0),
(91, 16, 15, NULL, 0, 0),
(92, 16, 2, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tip_soob`
--

CREATE TABLE `tip_soob` (
  `nom` int(10) NOT NULL,
  `tip_soob` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(500) DEFAULT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `user` int(10) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы сообщений для всех полей или для текущей записи';

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `nom` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица с пользователями';

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`nom`, `name`, `password`) VALUES
(1, 'admin', '1234567890');

-- --------------------------------------------------------

--
-- Структура таблицы `user_dostup`
--

CREATE TABLE `user_dostup` (
  `nom` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `kod_dostupa` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Доступные права для пользователя';

-- --------------------------------------------------------

--
-- Структура таблицы `vid_soob`
--

CREATE TABLE `vid_soob` (
  `nom` int(10) NOT NULL,
  `vid_soob` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `del` timestamp NULL DEFAULT NULL,
  `user` int(10) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вид сообщения для всех полей или для одного параметра';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `dostup`
--
ALTER TABLE `dostup`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`nom`),
  ADD KEY `kod_oborud` (`kod_oborud`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `parent` (`parent`),
  ADD KEY `name` (`name`) USING BTREE;

--
-- Индексы таблицы `oborud`
--
ALTER TABLE `oborud`
  ADD PRIMARY KEY (`nom`),
  ADD KEY `kod_tip` (`kod_tip`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `proverka` (`proverka`(255));

--
-- Индексы таблицы `oborud_param`
--
ALTER TABLE `oborud_param`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `kod_oborud` (`kod_oborud`),
  ADD KEY `kod_param` (`kod_param`),
  ADD KEY `value_text` (`value_text`(255)),
  ADD KEY `value_date` (`value_date`),
  ADD KEY `value_fail` (`value_fail`(255)),
  ADD KEY `value_folder` (`value_folder`(255)),
  ADD KEY `user` (`user`),
  ADD KEY `zagolovok` (`zagolovok`),
  ADD KEY `sort` (`sort`);

--
-- Индексы таблицы `param`
--
ALTER TABLE `param`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `sort` (`sort`);

--
-- Индексы таблицы `pic`
--
ALTER TABLE `pic`
  ADD PRIMARY KEY (`nom`),
  ADD KEY `kod_oborud` (`kod_oborud`);

--
-- Индексы таблицы `soob`
--
ALTER TABLE `soob`
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Индексы таблицы `soob_param`
--
ALTER TABLE `soob_param`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `kod_soob` (`kod_soob`),
  ADD KEY `kod_oborud` (`kod_oborud`),
  ADD KEY `kod_tip` (`kod_tip`),
  ADD KEY `del` (`del`),
  ADD KEY `data` (`data`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`nom`);

--
-- Индексы таблицы `tip`
--
ALTER TABLE `tip`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `tip_field`
--
ALTER TABLE `tip_field`
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Индексы таблицы `tip_param`
--
ALTER TABLE `tip_param`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `sort` (`sort`);

--
-- Индексы таблицы `tip_soob`
--
ALTER TABLE `tip_soob`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `tip_soob` (`tip_soob`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `password` (`password`);

--
-- Индексы таблицы `user_dostup`
--
ALTER TABLE `user_dostup`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `id` (`id`),
  ADD KEY `kod_dostupa` (`kod_dostupa`);

--
-- Индексы таблицы `vid_soob`
--
ALTER TABLE `vid_soob`
  ADD UNIQUE KEY `nom` (`nom`),
  ADD UNIQUE KEY `vid_soob` (`vid_soob`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `dostup`
--
ALTER TABLE `dostup`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `oborud`
--
ALTER TABLE `oborud`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT для таблицы `oborud_param`
--
ALTER TABLE `oborud_param`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT для таблицы `param`
--
ALTER TABLE `param`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `pic`
--
ALTER TABLE `pic`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `soob`
--
ALTER TABLE `soob`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `soob_param`
--
ALTER TABLE `soob_param`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `nom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `tip`
--
ALTER TABLE `tip`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `tip_field`
--
ALTER TABLE `tip_field`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tip_param`
--
ALTER TABLE `tip_param`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT для таблицы `tip_soob`
--
ALTER TABLE `tip_soob`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user_dostup`
--
ALTER TABLE `user_dostup`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vid_soob`
--
ALTER TABLE `vid_soob`
  MODIFY `nom` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
