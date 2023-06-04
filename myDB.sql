-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 05 2023 г., 01:49
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myDB`
--

-- --------------------------------------------------------

--
-- Структура таблицы `candies`
--

CREATE TABLE `candies` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `candies`
--

INSERT INTO `candies` (`id`, `name`) VALUES
(1, 'Яблочная'),
(2, 'Мармеладная'),
(4, 'Ягодная'),
(5, 'Грушевая'),
(6, 'Малиновая'),
(7, 'Клубничная'),
(8, 'Персиковая'),
(9, 'Лимонная'),
(10, 'Арбузная'),
(11, 'Мятная');

-- --------------------------------------------------------

--
-- Структура таблицы `ProductReceipt`
--

CREATE TABLE `ProductReceipt` (
  `id` int NOT NULL,
  `candy_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `amount` int NOT NULL,
  `date_received` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ProductReceipt`
--

INSERT INTO `ProductReceipt` (`id`, `candy_id`, `supplier_id`, `amount`, `date_received`) VALUES
(1, 1, 4, 101, '21.05.2023'),
(2, 1, 2, 55, '21.05.2023'),
(3, 4, 2, 50, '23.05.2023'),
(4, 11, 3, 50, '13.05.2023');

-- --------------------------------------------------------

--
-- Структура таблицы `ProductRelease`
--

CREATE TABLE `ProductRelease` (
  `id` int NOT NULL,
  `candy_id` int NOT NULL,
  `store_id` int NOT NULL,
  `amount` int NOT NULL,
  `date_sold` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ProductRelease`
--

INSERT INTO `ProductRelease` (`id`, `candy_id`, `store_id`, `amount`, `date_sold`) VALUES
(1, 1, 3, 155, '02.06.2023'),
(2, 10, 1, 15, '02.06.2023'),
(3, 1, 2, 77, '21.05.2023'),
(4, 1, 2, 155, '25.05.2023');

-- --------------------------------------------------------

--
-- Структура таблицы `stores`
--

CREATE TABLE `stores` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `stores`
--

INSERT INTO `stores` (`id`, `name`, `adress`, `phone`) VALUES
(1, 'Магнит', 'Уральская 111', '+79181726111'),
(2, 'Пятёрочка', 'Сормовская 6', '+79181726911'),
(3, 'Табрис', 'Старокубанская 15', '+79181202124');

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`) VALUES
(2, 'РусскиеСладости', '+555'),
(3, 'Сладкоежка', '+79181554413'),
(4, 'Магнит', 'Блатной');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `candies`
--
ALTER TABLE `candies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ProductReceipt`
--
ALTER TABLE `ProductReceipt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_candie2` (`candy_id`),
  ADD KEY `fk_supplies` (`supplier_id`);

--
-- Индексы таблицы `ProductRelease`
--
ALTER TABLE `ProductRelease`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_candie` (`candy_id`),
  ADD KEY `fk_stores` (`store_id`);

--
-- Индексы таблицы `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `candies`
--
ALTER TABLE `candies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `ProductReceipt`
--
ALTER TABLE `ProductReceipt`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `ProductRelease`
--
ALTER TABLE `ProductRelease`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ProductReceipt`
--
ALTER TABLE `ProductReceipt`
  ADD CONSTRAINT `fk_candie2` FOREIGN KEY (`candy_id`) REFERENCES `candies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_supplies` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productreceipt_ibfk_1` FOREIGN KEY (`candy_id`) REFERENCES `candies` (`id`),
  ADD CONSTRAINT `productreceipt_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Ограничения внешнего ключа таблицы `ProductRelease`
--
ALTER TABLE `ProductRelease`
  ADD CONSTRAINT `fk_candie` FOREIGN KEY (`candy_id`) REFERENCES `candies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stores` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productrelease_ibfk_1` FOREIGN KEY (`candy_id`) REFERENCES `candies` (`id`),
  ADD CONSTRAINT `productrelease_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
