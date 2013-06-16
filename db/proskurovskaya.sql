-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 16 2013 г., 20:29
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `proskurovskaya`
--

-- --------------------------------------------------------

--
-- Структура таблицы `p_categories`
--

CREATE TABLE IF NOT EXISTS `p_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `iname` varchar(255) NOT NULL,
  `idesc` text NOT NULL,
  `position` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `p_categories`
--

INSERT INTO `p_categories` (`id`, `uri`, `iname`, `idesc`, `position`, `is_deleted`) VALUES
(1, 'bags', 'Bags', '', 0, 0),
(2, 'wallets', 'Wallets', '', 0, 0),
(3, 'accessories', 'Accessories', '', 0, 0),
(4, 'shoes', 'Shoes', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `p_collections`
--

CREATE TABLE IF NOT EXISTS `p_collections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `iname` varchar(512) NOT NULL,
  `idesc` text NOT NULL,
  `position` tinyint(4) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `p_collections`
--

INSERT INTO `p_collections` (`id`, `uri`, `iname`, `idesc`, `position`, `is_deleted`) VALUES
(1, 'basic', 'Basic', '', 0, 0),
(2, 'season-collections', 'Season Collections', '', 0, 0),
(3, 'limited-editions', 'Limited Editions', '', 0, 0),
(4, 'private-order', 'Private Order', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `p_details`
--

CREATE TABLE IF NOT EXISTS `p_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `iname` varchar(255) NOT NULL,
  `idesc` text NOT NULL,
  `photo_s` varchar(255) NOT NULL,
  `photo_m` varchar(255) NOT NULL,
  `photo_b` varchar(255) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `p_products`
--

CREATE TABLE IF NOT EXISTS `p_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `iname` varchar(512) NOT NULL,
  `idesc` text NOT NULL,
  `photo_s` varchar(512) NOT NULL,
  `photo_m` varchar(512) NOT NULL,
  `photo_b` varchar(512) NOT NULL,
  `price` varchar(10) NOT NULL,
  `views_count` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `add_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `p_products`
--

INSERT INTO `p_products` (`id`, `category_id`, `collection_id`, `uri`, `iname`, `idesc`, `photo_s`, `photo_m`, `photo_b`, `price`, `views_count`, `is_deleted`, `add_date`) VALUES
(1, 1, 1, 'bag-w1', 'W1', '', 'upload/products/s_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/m_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/b_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', '100', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `p_products_details`
--

CREATE TABLE IF NOT EXISTS `p_products_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `p_products_photos`
--

CREATE TABLE IF NOT EXISTS `p_products_photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `iname` varchar(255) NOT NULL,
  `idesc` text NOT NULL,
  `photo_s` varchar(512) NOT NULL,
  `photo_m` varchar(512) NOT NULL,
  `photo_b` varchar(512) NOT NULL,
  `add_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `p_products_photos`
--

INSERT INTO `p_products_photos` (`id`, `product_id`, `iname`, `idesc`, `photo_s`, `photo_m`, `photo_b`, `add_date`) VALUES
(1, 1, '', '', 'upload/products/s_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 'upload/products/m_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 'upload/products/b_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 1371255686),
(2, 1, '', '', 'upload/products/s_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 'upload/products/m_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 'upload/products/b_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 1371255686),
(3, 1, '', '', 'upload/products/s_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 'upload/products/m_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 'upload/products/b_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 1371255686),
(4, 1, '', '', 'upload/products/s_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 'upload/products/m_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 'upload/products/b_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 1371255686),
(6, 1, '', '', 'upload/products/s_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/m_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/b_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 1371256435);

-- --------------------------------------------------------

--
-- Структура таблицы `p_users`
--

CREATE TABLE IF NOT EXISTS `p_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `url_friendly_name` varchar(255) NOT NULL,
  `avatar_b` varchar(255) NOT NULL,
  `avatar_m` varchar(255) NOT NULL,
  `avatar_s` varchar(255) NOT NULL,
  `timezone` tinyint(4) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  `auto_login_key` varchar(255) NOT NULL,
  `facebook_id` bigint(20) NOT NULL,
  `facebook_oa_access_token` text NOT NULL,
  `facebook_oa_valid_till` int(11) NOT NULL,
  `vkontakte_id` bigint(20) NOT NULL,
  `vkontakte_oa_access_token` text NOT NULL,
  `vkontakte_oa_valid_till` int(11) NOT NULL,
  `google_id` varchar(50) NOT NULL,
  `google_oa_access_token` text NOT NULL,
  `google_oa_valid_till` int(11) NOT NULL,
  `linkedin_id` varchar(50) NOT NULL,
  `linkedin_oa_access_token` text NOT NULL,
  `linkedin_oa_valid_till` int(11) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `twitter_oa_access_token` varchar(255) NOT NULL,
  `twitter_oa_valid_till` int(11) NOT NULL,
  `is_judge` tinyint(4) NOT NULL,
  `online_till` int(11) NOT NULL,
  `add_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `p_users`
--

INSERT INTO `p_users` (`id`, `login`, `password`, `email`, `first_name`, `last_name`, `url_friendly_name`, `avatar_b`, `avatar_m`, `avatar_s`, `timezone`, `gender`, `access_level`, `auto_login_key`, `facebook_id`, `facebook_oa_access_token`, `facebook_oa_valid_till`, `vkontakte_id`, `vkontakte_oa_access_token`, `vkontakte_oa_valid_till`, `google_id`, `google_oa_access_token`, `google_oa_valid_till`, `linkedin_id`, `linkedin_oa_access_token`, `linkedin_oa_valid_till`, `twitter_id`, `twitter_oa_access_token`, `twitter_oa_valid_till`, `is_judge`, `online_till`, `add_date`) VALUES
(1, '', '', 'i@randix.info', 'Yuriy', 'Denishchenko', '', '', '', '', 2, 1, 100, '', 100000667500718, '', 0, 0, '', 0, '', '', 0, '0', '', 0, 0, '', 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
