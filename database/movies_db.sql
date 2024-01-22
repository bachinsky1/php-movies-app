-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Час створення: Січ 22 2024 р., 21:01
-- Версія сервера: 8.1.0
-- Версія PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `movies_db`
--
CREATE DATABASE IF NOT EXISTS `movies_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `movies_db`;

-- --------------------------------------------------------

--
-- Структура таблиці `actors`
--

DROP TABLE IF EXISTS `actors`;
CREATE TABLE IF NOT EXISTS `actors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Очистити таблицю перед вставкою `actors`
--

TRUNCATE TABLE `actors`;
--
-- Дамп даних таблиці `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`) VALUES
(231, 'Mel', 'Brooks'),
(232, 'Clevon', 'Little'),
(233, 'Harvey', 'Korman'),
(234, 'Gene', 'Wilder'),
(235, 'Slim', 'Pickens'),
(236, 'Madeline', 'Kahn'),
(237, 'Humphrey', 'Bogart'),
(238, 'Ingrid', 'Bergman'),
(239, 'Claude', 'Rains'),
(240, 'Peter', 'Lorre'),
(241, 'Audrey', 'Hepburn'),
(242, 'Cary', 'Grant'),
(243, 'Walter', 'Matthau'),
(244, 'James', 'Coburn'),
(245, 'George', 'Kennedy'),
(246, 'Paul', 'Newman'),
(247, 'Strother', 'Martin'),
(248, 'Robert', 'Redford'),
(249, 'Katherine', 'Ross'),
(250, 'Robert', 'Shaw'),
(251, 'Charles', 'Durning'),
(252, 'Jim', 'Henson'),
(253, 'Frank', 'Oz'),
(254, 'Dave', 'Geolz'),
(255, 'Austin', 'Pendleton'),
(256, 'John', 'Travolta'),
(257, 'Danny', 'DeVito'),
(258, 'Renne', 'Russo'),
(259, 'Gene', 'Hackman'),
(260, 'Dennis', 'Farina'),
(261, 'Joe', 'Pesci'),
(262, 'Marrisa', 'Tomei'),
(263, 'Fred', 'Gwynne'),
(264, 'Lane', 'Smith'),
(265, 'Ralph', 'Macchio'),
(266, 'Russell', 'Crowe'),
(267, 'Joaquin', 'Phoenix'),
(268, 'Connie', 'Nielson'),
(269, 'Harrison', 'Ford'),
(270, 'Mark', 'Hamill'),
(271, 'Carrie', 'Fisher'),
(272, 'Alec', 'Guinness'),
(273, 'James', 'Earl Jones'),
(274, 'Karen', 'Allen'),
(275, 'Nathan', 'Fillion'),
(276, 'Alan', 'Tudyk'),
(277, 'Adam', 'Baldwin'),
(278, 'Ron', 'Glass'),
(279, 'Jewel', 'Staite'),
(280, 'Gina', 'Torres'),
(281, 'Morena', 'Baccarin'),
(282, 'Sean', 'Maher'),
(283, 'Summer', 'Glau'),
(284, 'Chiwetel', 'Ejiofor'),
(285, 'Barbara', 'Hershey'),
(286, 'Dennis', 'Hopper'),
(287, 'Matthew', 'Broderick'),
(288, 'Ally', 'Sheedy'),
(289, 'Dabney', 'Coleman'),
(290, 'John', 'Wood'),
(291, 'Barry', 'Corbin'),
(292, 'Bill', 'Pullman'),
(293, 'John', 'Candy'),
(294, 'Rick', 'Moranis'),
(295, 'Daphne', 'Zuniga'),
(296, 'Joan', 'Rivers'),
(297, 'Kenneth', 'Mars'),
(298, 'Terri', 'Garr'),
(299, 'Peter', 'Boyle'),
(300, 'Val', 'Kilmer'),
(301, 'Gabe', 'Jarret'),
(302, 'Michelle', 'Meyrink'),
(303, 'William', 'Atherton'),
(304, 'Tom', 'Cruise'),
(305, 'Kelly', 'McGillis'),
(306, 'Anthony', 'Edwards'),
(307, 'Tom', 'Skerritt'),
(308, 'Donald', 'Sutherland'),
(309, 'Elliot', 'Gould'),
(310, 'Sally', 'Kellerman'),
(311, 'Robert', 'Duvall'),
(312, 'Carl', 'Reiner'),
(313, 'Eva', 'Marie Saint'),
(314, 'Alan', 'Arkin'),
(315, 'Brian', 'Keith'),
(316, 'Roy', 'Scheider'),
(317, 'Richard', 'Dreyfuss'),
(318, 'Lorraine', 'Gary'),
(319, 'Keir', 'Dullea'),
(320, 'Gary', 'Lockwood'),
(321, 'William', 'Sylvester'),
(322, 'Douglas', 'Rain'),
(323, 'James', 'Stewart'),
(324, 'Josephine', 'Hull'),
(325, 'Peggy', 'Dow'),
(326, 'Charles', 'Drake'),
(327, 'Seth', 'Rogen'),
(328, 'Katherine', 'Heigl'),
(329, 'Paul', 'Rudd'),
(330, 'Leslie', 'Mann');

-- --------------------------------------------------------

--
-- Структура таблиці `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `release_year` int NOT NULL,
  `format` enum('VHS','DVD','Blu-ray') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Очистити таблицю перед вставкою `movies`
--

TRUNCATE TABLE `movies`;
--
-- Дамп даних таблиці `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_year`, `format`) VALUES
(123, 'Blazing Saddles', 1974, 'VHS'),
(124, 'Casablanca', 1942, 'DVD'),
(125, 'Charade', 1953, 'DVD'),
(126, 'Cool Hand Luke', 1967, 'VHS'),
(127, 'Butch Cassidy and the Sundance Kid', 1969, 'VHS'),
(128, 'The Sting', 1973, 'DVD'),
(129, 'The Muppet Movie', 1979, 'DVD'),
(130, 'Get Shorty', 1995, 'DVD'),
(131, 'My Cousin Vinny', 1992, 'DVD'),
(132, 'Gladiator', 2000, 'Blu-ray'),
(133, 'Star Wars', 1977, 'Blu-ray'),
(134, 'Raiders of the Lost Ark', 1981, 'DVD'),
(135, 'Serenity', 2005, 'Blu-ray'),
(136, 'Hooisers', 1986, 'VHS'),
(137, 'WarGames', 1983, 'VHS'),
(138, 'Spaceballs', 1987, 'DVD'),
(139, 'Young Frankenstein', 1974, 'VHS'),
(140, 'Real Genius', 1985, 'VHS'),
(141, 'Top Gun', 1986, 'DVD'),
(142, 'MASH', 1970, 'DVD'),
(143, 'The Russians Are Coming, The Russians Are Coming', 1966, 'VHS'),
(144, 'Jaws', 1975, 'DVD'),
(145, '2001: A Space Odyssey', 1968, 'DVD'),
(146, 'Harvey', 1950, 'DVD'),
(147, 'Knocked Up', 2007, 'Blu-ray');

-- --------------------------------------------------------

--
-- Структура таблиці `movie_actors`
--

DROP TABLE IF EXISTS `movie_actors`;
CREATE TABLE IF NOT EXISTS `movie_actors` (
  `movie_id` int NOT NULL,
  `actor_id` int NOT NULL,
  PRIMARY KEY (`movie_id`,`actor_id`),
  KEY `actor_id` (`actor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Очистити таблицю перед вставкою `movie_actors`
--

TRUNCATE TABLE `movie_actors`;
--
-- Дамп даних таблиці `movie_actors`
--

INSERT INTO `movie_actors` (`movie_id`, `actor_id`) VALUES
(123, 231),
(129, 231),
(138, 231),
(123, 232),
(123, 233),
(123, 234),
(139, 234),
(123, 235),
(123, 236),
(124, 237),
(124, 238),
(124, 239),
(124, 240),
(125, 241),
(125, 242),
(125, 243),
(125, 244),
(129, 244),
(125, 245),
(126, 245),
(126, 246),
(127, 246),
(128, 246),
(126, 247),
(127, 248),
(128, 248),
(127, 249),
(128, 250),
(144, 250),
(128, 251),
(129, 251),
(129, 252),
(129, 253),
(129, 254),
(129, 255),
(131, 255),
(130, 256),
(130, 257),
(130, 258),
(130, 259),
(136, 259),
(139, 259),
(130, 260),
(131, 261),
(131, 262),
(131, 263),
(131, 264),
(131, 265),
(132, 266),
(132, 267),
(132, 268),
(133, 269),
(134, 269),
(133, 270),
(133, 271),
(133, 272),
(133, 273),
(134, 274),
(135, 275),
(135, 276),
(135, 277),
(135, 278),
(135, 279),
(135, 280),
(135, 281),
(135, 282),
(135, 283),
(135, 284),
(136, 285),
(136, 286),
(137, 287),
(137, 288),
(137, 289),
(137, 290),
(137, 291),
(138, 292),
(138, 293),
(138, 294),
(138, 295),
(138, 296),
(139, 297),
(139, 298),
(139, 299),
(140, 300),
(141, 300),
(140, 301),
(140, 302),
(140, 303),
(141, 304),
(141, 305),
(141, 306),
(141, 307),
(142, 307),
(142, 308),
(142, 309),
(142, 310),
(142, 311),
(143, 312),
(143, 313),
(143, 314),
(143, 315),
(144, 316),
(144, 317),
(144, 318),
(145, 319),
(145, 320),
(145, 321),
(145, 322),
(146, 323),
(146, 324),
(146, 325),
(146, 326),
(147, 327),
(147, 328),
(147, 329),
(147, 330);

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL,
  `login` varchar(66) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Очистити таблицю перед вставкою `users`
--

TRUNCATE TABLE `users`;
--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `active`, `created_at`) VALUES
(1, 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2024-01-19 18:13:01');

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD CONSTRAINT `movie_actors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
