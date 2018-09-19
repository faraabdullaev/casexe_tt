-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 19 2018 г., 19:23
-- Версия сервера: 10.1.28-MariaDB
-- Версия PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `casexe_tt`
--
DROP DATABASE IF EXISTS `casexe_tt`;
CREATE DATABASE IF NOT EXISTS `casexe_tt` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `casexe_tt`;

-- --------------------------------------------------------

--
-- Структура таблицы `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `conversion_rate` float DEFAULT NULL,
  `money_balance` int(11) DEFAULT NULL,
  `money_from` int(11) DEFAULT NULL,
  `money_to` int(11) DEFAULT NULL,
  `bonus_from` int(11) DEFAULT NULL,
  `bonus_to` int(11) DEFAULT NULL,
  `money_share` int(11) DEFAULT NULL,
  `gift_share` int(11) DEFAULT NULL,
  `bonus_share` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `game`
--

INSERT INTO `game` (`id`, `name`, `start`, `end`, `conversion_rate`, `money_balance`, `money_from`, `money_to`, `bonus_from`, `bonus_to`, `money_share`, `gift_share`, `bonus_share`, `is_active`) VALUES
  (1, 'First Game', '2018-09-19 11:45:35', '2018-09-20 13:45:00', 1.5, 4960, 10, 15, 5, 50, 25, 15, 60, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `gift`
--

CREATE TABLE IF NOT EXISTS `gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gift`
--

INSERT INTO `gift` (`id`, `game_id`, `name`, `count`) VALUES
  (1, 1, 'PS 4', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `loyalty_card`
--

CREATE TABLE IF NOT EXISTS `loyalty_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `balance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `loyalty_card`
--

INSERT INTO `loyalty_card` (`id`, `user_id`, `balance`) VALUES
  (1, 1, 59);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prize_receiver`
--

CREATE TABLE IF NOT EXISTS `prize_receiver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prize_type` smallint(6) NOT NULL,
  `prize_value` int(11) DEFAULT NULL,
  `prize_status` smallint(6) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prize_receiver`
--

INSERT INTO `prize_receiver` (`id`, `user_id`, `prize_type`, `prize_value`, `prize_status`, `game_id`, `created_date`, `updated_date`) VALUES
  (1, 1, 0, 10, 9, 1, '2018-09-18 12:33:57', '2018-09-19 10:12:02'),
  (2, 1, 0, 32, 4, 1, '2018-09-19 10:47:17', '2018-09-19 10:49:13'),
  (3, 1, 2, 15, 4, 1, '2018-09-19 10:52:00', '2018-09-19 11:14:21'),
  (4, 1, 2, 15, 4, 1, '2018-09-19 11:15:41', '2018-09-19 11:45:16'),
  (5, 1, 2, 10, 1, 1, '2018-09-19 11:45:35', '2018-09-19 11:45:42');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `bank_account` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `bank_account`, `address`) VALUES
  (1, 'admin', '6iu-zW4qJk5naLvl9I0UpFid0TtqYVGK', '$2y$13$MOez1lMDfeMFl1q9vV.At.bPSn7slMpLYB8bAEBofTUNE5r64T.Iu', NULL, 'admin@casexe.tt', 10, 1537206330, 1537206330, NULL, NULL);
COMMIT;
