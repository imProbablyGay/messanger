-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Июл 25 2022 г., 18:44
-- Версия сервера: 5.7.38
-- Версия PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `messanger`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chats_id`
--

CREATE TABLE `chats_id` (
  `id` int(11) NOT NULL,
  `user1` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `user2` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chats_id`
--

INSERT INTO `chats_id` (`id`, `user1`, `user2`) VALUES
(1, 'test1', ''),
(2, 'test1', 'test2'),
(3, 'test3', 'test1'),
(4, 'test4', 'test1'),
(5, 'test1', 'test4'),
(6, 'test1@gmail.com', 'test2@gmail.com'),
(7, 'test1@gmail.com', 'test1'),
(8, 'AAAAAA', 'test1'),
(9, 'sdf', 'test1'),
(10, '2', 'test1'),
(11, 'sdf', '2'),
(12, 'sdf', '228_xxx_228'),
(13, 'sdf', '22');

-- --------------------------------------------------------

--
-- Структура таблицы `chat_1`
--

CREATE TABLE `chat_1` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_1`
--

INSERT INTO `chat_1` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656528860, 'df', 'test1', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_2`
--

CREATE TABLE `chat_2` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_2`
--

INSERT INTO `chat_2` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656526753, 'dsf', 'test1', 'test2', 1),
(2, 1656526982, 'sdf', 'test2', 'test1', 1),
(3, 1656527149, 'sdf', 'test2', 'test1', 1),
(4, 1656527194, 'fgh', 'test1', 'test2', 1),
(5, 1656527411, 'bv', 'test1', 'test2', 1),
(6, 1656527570, 'voice:../voice/chat_2/4777161648f08249e4c6de6a117702f4.wav', 'test1', 'test2', 1),
(7, 1656527592, 'image:../images/chat_2/4e8299e9056ad4ca5a5412b6dd4b205c.jpeg', 'test1', 'test2', 1),
(8, 1656527625, 'kuradi raisk!!!', 'test2', 'test1', 1),
(9, 1656527631, 'gfh', 'test1', 'test2', 1),
(10, 1656528333, 'g', 'test1', 'test2', 1),
(11, 1656528333, 'g', 'test1', 'test2', 1),
(12, 1656528334, 'g', 'test1', 'test2', 1),
(13, 1656528334, 'g', 'test1', 'test2', 1),
(14, 1656528334, 'g', 'test1', 'test2', 1),
(15, 1656528335, 'g', 'test1', 'test2', 1),
(16, 1656528335, 'g', 'test1', 'test2', 1),
(17, 1656528335, 'g', 'test1', 'test2', 1),
(18, 1656528336, 'g', 'test1', 'test2', 1),
(19, 1656528336, 'g', 'test1', 'test2', 1),
(20, 1656528336, 'g', 'test1', 'test2', 1),
(21, 1656528337, 'g', 'test1', 'test2', 1),
(22, 1656528337, 'g', 'test1', 'test2', 1),
(23, 1656528337, 'g', 'test1', 'test2', 1),
(24, 1656528338, 'g', 'test1', 'test2', 1),
(25, 1656528338, 'g', 'test1', 'test2', 1),
(26, 1656528338, 'g', 'test1', 'test2', 1),
(27, 1656528339, 'g', 'test1', 'test2', 1),
(28, 1656528339, 'g', 'test1', 'test2', 1),
(29, 1656528339, 'g', 'test1', 'test2', 1),
(30, 1656528341, 'g', 'test1', 'test2', 1),
(31, 1656528600, 'gfh', 'test2', 'test1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_3`
--

CREATE TABLE `chat_3` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_3`
--

INSERT INTO `chat_3` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656528865, 'sdf', 'test3', 'test1', 1),
(2, 1656529055, 'g', 'test3', 'test1', 1),
(3, 1656529060, 'g', 'test3', 'test1', 1),
(4, 1656529103, 'm', 'test1', 'test3', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_4`
--

CREATE TABLE `chat_4` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_4`
--

INSERT INTO `chat_4` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656529196, 'sd', 'test4', 'test1', 1),
(2, 1656529245, 'image:../images/chat_4/1aa3365f8faf811272c884382fd1f6f7.jpeg', 'test1', 'test4', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_6`
--

CREATE TABLE `chat_6` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_6`
--

INSERT INTO `chat_6` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656534753, 'sdf', 'test1@gmail.com', 'test2@gmail.com', 1),
(2, 1656538877, 'sdf', 'test1@gmail.com', 'test2@gmail.com', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_7`
--

CREATE TABLE `chat_7` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_7`
--

INSERT INTO `chat_7` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656538897, 'sdf', 'test1@gmail.com', 'test1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_8`
--

CREATE TABLE `chat_8` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_8`
--

INSERT INTO `chat_8` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656539212, 'image:../images/chat_8/25bda7d4de8e40f9ddee829298c42bf0.jpeg', 'AAAAAA', 'test1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_9`
--

CREATE TABLE `chat_9` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_9`
--

INSERT INTO `chat_9` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656539239, 'sdf', 'sdf', 'test1', 0),
(2, 1656629595, 'sdf', 'sdf', 'test1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_10`
--

CREATE TABLE `chat_10` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_10`
--

INSERT INTO `chat_10` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656539289, 'voice:../voice/chat_10/32da811b05c1702b22de8caf0182d7f8.wav', '2', 'test1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_11`
--

CREATE TABLE `chat_11` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_11`
--

INSERT INTO `chat_11` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656539637, 'voice:../voice/chat_11/5e8c8d2970db5594e9b4d02812818f75.wav', 'sdf', '2', 0),
(2, 1656539643, 'image:../images/chat_11/6ea8b88741a86d40f720608126bee2a8.png', 'sdf', '2', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_12`
--

CREATE TABLE `chat_12` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_12`
--

INSERT INTO `chat_12` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656580863, 'voice:../voice/chat_12/b84d2dec47c2887bd668e1cfa42af75e.wav', 'sdf', '228_xxx_228', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `chat_13`
--

CREATE TABLE `chat_13` (
  `id` int(6) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `sender` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `is_seen` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `chat_13`
--

INSERT INTO `chat_13` (`id`, `time`, `message`, `sender`, `receiver`, `is_seen`) VALUES
(1, 1656581351, 'f', 'sdf', '22', 1),
(2, 1656581402, 'image:../images/chat_13/099b76a84b3360478ce86dd7fe2822de.jpeg', '22', 'sdf', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `chat_id` text COLLATE utf8mb4_bin NOT NULL,
  `online` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `userName`, `chat_id`, `online`) VALUES
(1, 'test1', '2,3,4,7,8,9,10', 1656539611),
(2, 'test2', '2', 1656528817),
(3, 'test3', '3', 1656529109),
(4, 'test4', '4', 1656529236),
(5, 'test1@gmail.com', '6,7', 1658738377),
(6, 'test2@gmail.com', '6', 1656538884),
(7, 'AAAAAA', '8', 1656539227),
(8, 'sdf', '9,11,12,13', 1656630657),
(9, '2', '10,11', 1656540339),
(10, '228_xxx_228', '12', 1656580914),
(11, '22', '13', 1656581413);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats_id`
--
ALTER TABLE `chats_id`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_1`
--
ALTER TABLE `chat_1`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_2`
--
ALTER TABLE `chat_2`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_3`
--
ALTER TABLE `chat_3`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_4`
--
ALTER TABLE `chat_4`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_6`
--
ALTER TABLE `chat_6`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_7`
--
ALTER TABLE `chat_7`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_8`
--
ALTER TABLE `chat_8`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_9`
--
ALTER TABLE `chat_9`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_10`
--
ALTER TABLE `chat_10`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_11`
--
ALTER TABLE `chat_11`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_12`
--
ALTER TABLE `chat_12`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat_13`
--
ALTER TABLE `chat_13`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chats_id`
--
ALTER TABLE `chats_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `chat_1`
--
ALTER TABLE `chat_1`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `chat_2`
--
ALTER TABLE `chat_2`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `chat_3`
--
ALTER TABLE `chat_3`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `chat_4`
--
ALTER TABLE `chat_4`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_6`
--
ALTER TABLE `chat_6`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_7`
--
ALTER TABLE `chat_7`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `chat_8`
--
ALTER TABLE `chat_8`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `chat_9`
--
ALTER TABLE `chat_9`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_10`
--
ALTER TABLE `chat_10`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `chat_11`
--
ALTER TABLE `chat_11`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `chat_12`
--
ALTER TABLE `chat_12`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `chat_13`
--
ALTER TABLE `chat_13`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
