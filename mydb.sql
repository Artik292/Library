-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 09 2017 г., 19:22
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mydb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `year_published` date DEFAULT NULL,
  `total_quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `year_published`, `total_quantity`) VALUES
(1, 'test', 'test', '2015-11-10', 0),
(2, 'name', 'author', NULL, 0),
(3, 'name', 'author', '2017-07-03', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `borrow`
--

CREATE TABLE `borrow` (
  `id` int(11) NOT NULL,
  `date_loan` datetime DEFAULT NULL,
  `date_return` datetime DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `returned` tinyint(4) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `librarians`
--

CREATE TABLE `librarians` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `name`, `surname`, `grade`, `password`) VALUES
(1, 'в', 'в', 'в', 'd'),
(2, 'ю', 'ю', 'ю', '.'),
(3, 'ж', 'ж', 'ж', ';'),
(4, 'l', 'll', 'l', 'l'),
(5, 'a', 'a', 'a', 'a'),
(6, 'd', 'd', 'd', 'd'),
(7, 'ko', 'ko', 'kok', 'ko'),
(8, 'd', '', '', 'd'),
(9, 'p', 'p', 'p', 'p'),
(10, 'admin', '', '', 'admin'),
(11, 'admin', '', '', 'l'),
(12, 'admin', '', '', 'j'),
(13, 'admin', '', '', 'd'),
(14, 'admin', '', '', 'd'),
(15, 'admin', '', '', 'Lolol'),
(16, 'admin', '', '', 'admin'),
(17, 'name', '', '', 'password'),
(18, 'admin', '', '', 'admin'),
(19, 'admin', '', '', 'a'),
(20, 'admin', '', '', 'kl'),
(21, 'awdaw', '', '', 'awdaw'),
(22, 'lol', '', '', 'lol'),
(23, 'admin', '', '', 'admin'),
(24, 'a', 'b', 'c', 'e');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_borrow_students_idx` (`student_id`),
  ADD KEY `fk_borrow_books1_idx` (`book_id`);

--
-- Индексы таблицы `librarians`
--
ALTER TABLE `librarians`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `borrow`
--
ALTER TABLE `borrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `librarians`
--
ALTER TABLE `librarians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `fk_borrow_books1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_borrow_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
