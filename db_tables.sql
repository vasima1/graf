-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 04 2020 г., 10:38
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `arrow`
--

CREATE TABLE `arrow` (
  `id` int(11) NOT NULL,
  `a` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `w` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `arrow`
--

INSERT INTO `arrow` (`id`, `a`, `b`, `w`) VALUES
(1, 1, 2, 7),
(2, 1, 3, 9),
(3, 1, 6, 14),
(4, 2, 3, 10),
(5, 2, 4, 15),
(6, 3, 4, 11),
(7, 3, 6, 2),
(8, 4, 5, 6),
(10, 5, 6, 9),
(12, 6, 5, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `vertex`
--

CREATE TABLE `vertex` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `chk` int(11) NOT NULL DEFAULT '0',
  `metka` int(11) NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vertex`
--

INSERT INTO `vertex` (`id`, `name`, `chk`, `metka`) VALUES
(1, 1, 0, 1000),
(2, 2, 0, 1000),
(3, 3, 0, 1000),
(4, 4, 0, 1000),
(5, 5, 0, 1000),
(6, 6, 0, 1000);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `arrow`
--
ALTER TABLE `arrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `b` (`b`);

--
-- Индексы таблицы `vertex`
--
ALTER TABLE `vertex`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `name_2` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `arrow`
--
ALTER TABLE `arrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `vertex`
--
ALTER TABLE `vertex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `arrow`
--
ALTER TABLE `arrow`
  ADD CONSTRAINT `arrow_ibfk_1` FOREIGN KEY (`b`) REFERENCES `vertex` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
