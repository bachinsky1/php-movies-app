-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Час створення: Січ 22 2024 р., 19:53
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

-- --------------------------------------------------------

--
-- Структура таблиці `actors`
--

CREATE TABLE `actors` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`) VALUES
(744, 'ascasc', 'ascascasc'),
(745, 'dfsgdsfdsfg', 'dfgdsfgsdf'),
(746, 'dfgdsfg', NULL),
(747, 'ascascasc', NULL),
(748, 'івафвафіва', 'івафівафіва'),
(749, 'аівапвапівпа', NULL),
(750, 'фівфівафіва', NULL),
(751, 'ваіпвапівап', NULL),
(752, 'dfghdfghdfgh', NULL),
(753, 'імфімфімівм', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `movies`
--

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_year` int NOT NULL,
  `format` enum('VHS','DVD','Blu-ray') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_year`, `format`) VALUES
(350, 'Star Wars', 1978, 'VHS'),
(351, 'star track', 1965, 'VHS'),
(352, 'Їжачок', 1978, 'VHS'),
(353, 'Інопланетянин', 1963, 'VHS'),
(354, 'їжак', 1936, 'VHS'),
(355, 'Super Duck', 1963, 'VHS'),
(356, 'інтурист', 1999, 'VHS');

-- --------------------------------------------------------

--
-- Структура таблиці `movie_actors`
--

CREATE TABLE `movie_actors` (
  `movie_id` int NOT NULL,
  `actor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `movie_actors`
--

INSERT INTO `movie_actors` (`movie_id`, `actor_id`) VALUES
(350, 744),
(350, 745),
(350, 746),
(351, 747),
(352, 748),
(352, 749),
(353, 750),
(354, 751),
(355, 752),
(356, 753);

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(66) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `active`, `created_at`) VALUES
(1, 'admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2024-01-19 18:13:01');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD PRIMARY KEY (`movie_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=754;

--
-- AUTO_INCREMENT для таблиці `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

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
