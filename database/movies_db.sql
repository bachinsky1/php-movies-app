-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Час створення: Січ 23 2024 р., 16:49
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

-- DROP TABLE `actors`, `movies`, `movie_actors`, `users`;
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
(331, 'Віра', 'Марченко'),
(332, 'Clint', 'Eastwood'),
(333, 'Lee', 'Van Cliff'),
(334, 'Elliy', 'Wallah'),
(335, 'фісфісіфс', 'фісфісфісфіс'),
(336, 'фсфісфісфіс', 'фісфіфісфісфіс'),
(337, 'іпвапівапвап', NULL),
(338, 'апропро', NULL),
(339, 'вапрвапр', 'вапр вапрапр'),
(340, 'апроапро', 'апрапро'),
(341, 'ascascascasc', NULL),
(342, 'ивапивапи', NULL),
(343, 'митьиьмитьмить', NULL),
(344, 'чсмисмисми', NULL),
(345, 'Lee', 'Van-Cliff');

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
(187, 'яблуко', 1974, 'VHS'),
(188, 'Акація', 1978, 'VHS'),
(189, 'Ялинка', 1978, 'VHS'),
(190, 'Яблук', 1985, 'DVD'),
(191, 'Яблукоо', 1978, 'VHS'),
(192, 'Ілоавпп', 1985, 'Blu-ray'),
(193, 'Їжак', 1985, 'VHS'),
(194, 'їжачок', 1986, 'VHS'),
(195, 'абрикос', 1999, 'DVD'),
(196, 'Абрико', 1996, 'VHS'),
(197, 'The Good, the Bad and the Ugly', 1965, 'VHS');

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
(187, 331),
(188, 331),
(189, 331),
(190, 331),
(191, 331),
(193, 331),
(197, 332),
(197, 334),
(192, 341),
(194, 342),
(195, 343),
(196, 344),
(197, 345);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT для таблиці `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

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
