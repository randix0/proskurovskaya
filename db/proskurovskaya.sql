-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 20 2013 г., 23:57
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
-- Структура таблицы `p_colors`
--

CREATE TABLE IF NOT EXISTS `p_colors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `iname` varchar(255) NOT NULL,
  `idesc` text NOT NULL,
  `photo_s` varchar(255) NOT NULL,
  `photo_m` varchar(255) NOT NULL,
  `photo_b` varchar(255) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `p_colors`
--

INSERT INTO `p_colors` (`id`, `uri`, `iname`, `idesc`, `photo_s`, `photo_m`, `photo_b`, `is_deleted`) VALUES
(1, 'dark', 'dark', '', 'upload/colors/s_a460772f1ea95d476dde14959d228c09c244e737.jpg', 'upload/colors/m_a460772f1ea95d476dde14959d228c09c244e737.jpg', 'upload/colors/b_a460772f1ea95d476dde14959d228c09c244e737.jpg', 0),
(2, 'dark', 'Dark', '', 'upload/colors/s_229fe7d3e80eff3500efa3889af15d66e38b1432.png', 'upload/colors/m_229fe7d3e80eff3500efa3889af15d66e38b1432.png', 'upload/colors/b_229fe7d3e80eff3500efa3889af15d66e38b1432.png', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `p_details`
--

INSERT INTO `p_details` (`id`, `uri`, `iname`, `idesc`, `photo_s`, `photo_m`, `photo_b`, `is_deleted`) VALUES
(1, 'wooden handle', 'Wooden handle', '', 'upload/details/s_1eccff64b2acaa7c516a3b440052b6f077850f0d.png', 'upload/details/m_1eccff64b2acaa7c516a3b440052b6f077850f0d.png', 'upload/details/b_1eccff64b2acaa7c516a3b440052b6f077850f0d.png', 0);

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
  `materials` text NOT NULL,
  `dimensions` text NOT NULL,
  `photo_s` varchar(512) NOT NULL,
  `photo_m` varchar(512) NOT NULL,
  `photo_b` varchar(512) NOT NULL,
  `price` varchar(10) NOT NULL,
  `views_count` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `add_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `p_products`
--

INSERT INTO `p_products` (`id`, `category_id`, `collection_id`, `uri`, `iname`, `idesc`, `materials`, `dimensions`, `photo_s`, `photo_m`, `photo_b`, `price`, `views_count`, `is_deleted`, `add_date`) VALUES
(1, 1, 1, 'bag-w1', 'W1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur fringilla metus, sed accumsan lorem sagittis vel. Suspendisse et lorem in magna cursus eleifend vitae sit amet tellus. Curabitur nisi nibh, consequat eu purus sit amet, egestas faucibus nisi. In pellentesque dolor quis sodales rhoncus. Sed porttitor erat vitae tortor porttitor, sed dignissim ligula fermentum. Nam tellus lorem, posuere nec auctor in, aliquam ut est. In elit lorem, viverra suscipit pulvinar vitae, aliquam sed velit. In vitae enim id velit ultrices semper. Duis ut fringilla lacus. Proin eu posuere odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec tristique sem dictum, rutrum justo at, convallis justo. Donec ultrices enim sit amet adipiscing semper.</p>\n\n<p>Fusce ac mauris adipiscing, hendrerit turpis quis, bibendum ante. Sed suscipit dolor eu congue interdum. Nunc facilisis urna vitae enim hendrerit, tempor aliquam est condimentum. Vivamus risus nulla, laoreet vitae lacinia eget, laoreet et sapien. Aliquam accumsan tellus eros, at mattis sem convallis sed. Etiam neque nisl, pretium in mauris at, fringilla cursus velit. Aliquam vestibulum purus at ante tempor, id consequat mi bibendum. Vivamus fermentum mattis magna vel vestibulum. Suspendisse gravida nibh enim, eu hendrerit ligula ultrices eu. Integer vestibulum lorem quis vehicula ultrices. Pellentesque mattis tellus at convallis ultricies. Pellentesque adipiscing quis velit et lobortis. Proin ornare arcu id libero convallis venenatis. Phasellus tellus nisi, faucibus ut congue id, semper in turpis.</p>\n\n<p>Nam ac lorem ullamcorper, vehicula metus id, consectetur massa. Sed auctor augue varius semper adipiscing. Nunc viverra tortor eget felis lacinia mattis. Fusce bibendum neque nunc, nec viverra tortor ultricies a. Aenean viverra id erat eget dapibus. Praesent sed nunc id purus convallis bibendum nec ac purus. Etiam sed pretium tellus, sit amet aliquam quam. Phasellus id accumsan velit, id egestas nulla. Fusce sodales, massa at interdum iaculis, ipsum tortor porttitor dolor, eu ullamcorper elit quam ut erat. Nulla rutrum leo eu pellentesque tincidunt. Integer tincidunt pulvinar nisl, sed mattis diam porttitor vitae. Maecenas quis eros ultricies, dignissim quam eget, mattis dui. Suspendisse velit erat, hendrerit non scelerisque nec, lacinia feugiat ligula. Mauris tincidunt justo auctor, rutrum nisi et, tempor libero. Donec mattis tortor sit amet neque convallis gravida.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur fringilla metus, sed accumsan lorem sagittis vel.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur fringilla metus, sed accumsan lorem sagittis vel.</p>', 'upload/products/s_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/m_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/b_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', '100', 0, 0, 0),
(2, 1, 1, 'mac', 'mac', 'jvk k', '', '', 'upload/products/s_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', 'upload/products/m_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', 'upload/products/b_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', '100', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `p_products_colors`
--

CREATE TABLE IF NOT EXISTS `p_products_colors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `p_products_colors`
--

INSERT INTO `p_products_colors` (`id`, `product_id`, `color_id`) VALUES
(3, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `p_products_details`
--

CREATE TABLE IF NOT EXISTS `p_products_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `p_products_details`
--

INSERT INTO `p_products_details` (`id`, `product_id`, `detail_id`) VALUES
(1, 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `p_products_photos`
--

INSERT INTO `p_products_photos` (`id`, `product_id`, `iname`, `idesc`, `photo_s`, `photo_m`, `photo_b`, `add_date`) VALUES
(1, 1, '', '', 'upload/products/s_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 'upload/products/m_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 'upload/products/b_7b7a912e6480fd7541c782cd030da1d47f07f543.jpg', 1371255686),
(2, 1, '', '', 'upload/products/s_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 'upload/products/m_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 'upload/products/b_a995548e53badaa37cf443551e9dab689f7c5b51.jpg', 1371255686),
(3, 1, '', '', 'upload/products/s_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 'upload/products/m_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 'upload/products/b_1252935ddc312ccfc98d27d0ab993be00f5c31eb.jpg', 1371255686),
(4, 1, '', '', 'upload/products/s_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 'upload/products/m_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 'upload/products/b_14a16fd8a6563f476baa15aee2f70d7df1f6afb1.jpg', 1371255686),
(6, 1, '', '', 'upload/products/s_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/m_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 'upload/products/b_2d934916eb05009db82f4cf6271bdafd4123b984.jpg', 1371256435),
(7, 2, '', '', 'upload/products/s_1c5ad233ac45704442dc0151517f107c9cbc19fb.jpg', 'upload/products/m_1c5ad233ac45704442dc0151517f107c9cbc19fb.jpg', 'upload/products/b_1c5ad233ac45704442dc0151517f107c9cbc19fb.jpg', 1371498552),
(8, 2, '', '', 'upload/products/s_9367232f38d20d56ca14d898d1560250839de627.png', 'upload/products/m_9367232f38d20d56ca14d898d1560250839de627.png', 'upload/products/b_9367232f38d20d56ca14d898d1560250839de627.png', 1371498552),
(9, 2, '', '', 'upload/products/s_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', 'upload/products/m_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', 'upload/products/b_ffe84930e515bfad7611e19ae488a0cf98fda79b.png', 1371498552),
(10, 2, '', '', 'upload/products/s_7a72180e65dec3d77eb6cbcc9f8252e95477a8c3.jpg', 'upload/products/m_7a72180e65dec3d77eb6cbcc9f8252e95477a8c3.jpg', 'upload/products/b_7a72180e65dec3d77eb6cbcc9f8252e95477a8c3.jpg', 1371498552);

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
