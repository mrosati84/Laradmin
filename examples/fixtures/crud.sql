-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2014 at 03:56 PM
-- Server version: 5.6.16
-- PHP Version: 5.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_index` (`post_id`),
  KEY `comments_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `body`, `post_id`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Etiam porta sem malesuada magna mollis euismod. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Curabitur blandit tempus porttitor. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vestibulum id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.', 3, '2014-10-28 13:35:21', '2014-10-28 13:53:49', NULL),
(2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.', 1, '2014-10-28 13:35:26', '2014-10-28 13:45:33', NULL),
(3, 'Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.', NULL, '2014-10-28 13:35:31', '2014-10-28 13:35:31', NULL),
(4, 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.', 1, '2014-10-28 13:35:37', '2014-10-28 13:45:33', NULL),
(5, 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nullam id dolor id nibh ultricies vehicula ut id elit. Maecenas faucibus mollis interdum. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.', 2, '2014-10-28 13:35:42', '2014-10-28 13:53:42', NULL),
(6, 'Sed posuere consectetur est at lobortis. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Etiam porta sem malesuada magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Vestibulum id ligula porta felis euismod semper.', 4, '2014-10-28 13:35:59', '2014-10-28 13:53:55', NULL),
(7, 'Nullam id dolor id nibh ultricies vehicula ut id elit. Nullam id dolor id nibh ultricies vehicula ut id elit. Donec ullamcorper nulla non metus auctor fringilla. Aenean lacinia bibendum nulla sed consectetur. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Nullam id dolor id nibh ultricies vehicula ut id elit.', NULL, '2014-10-28 13:36:08', '2014-10-28 13:36:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_08_29_134134_create_posts', 1),
('2014_08_30_085522_add_timestamps_to_posts', 1),
('2014_08_30_140835_create_comments', 1),
('2014_08_30_191908_create_tags', 1),
('2014_08_30_192057_create_post_tag', 1),
('2014_08_30_202541_create_users', 1),
('2014_08_30_202836_create_phones', 1),
('2014_08_31_112108_add_user_id_to_posts', 1),
('2014_08_31_112839_add_user_id_to_comments', 1),
('2014_10_17_233359_add_body_to_posts', 1),
('2014_10_24_110615_add_password_to_users', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE IF NOT EXISTS `phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `phones_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `number`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '+1555236589', 1, '2014-10-28 12:51:20', '2014-10-28 12:53:45'),
(2, '+1555874147', 2, '2014-10-28 12:51:27', '2014-10-28 12:53:50'),
(3, '+1555878596', 3, '2014-10-28 12:51:34', '2014-10-28 12:53:56'),
(4, '+1444874521', 4, '2014-10-28 12:51:41', '2014-10-28 12:54:09'),
(5, '+1555478541', 5, '2014-10-28 12:51:48', '2014-10-28 12:54:22'),
(6, '+3965474514', 6, '2014-10-28 12:54:32', '2014-10-28 12:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `created_at`, `updated_at`, `user_id`, `body`) VALUES
(1, 'Bibendum Venenatis Ridiculus Sem', '2014-10-28 12:54:58', '2014-10-28 12:57:45', 1, 'Nulla vitae elit libero, a pharetra augue. Maecenas sed diam eget risus varius blandit sit amet non magna. Etiam porta sem malesuada magna mollis euismod. Maecenas sed diam eget risus varius blandit sit amet non magna.'),
(2, 'Justo Consectetur', '2014-10-28 13:34:09', '2014-10-28 13:34:26', 2, 'Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec id elit non mi porta gravida at eget metus. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.'),
(3, 'Commodo Nullam Etiam', '2014-10-28 13:34:29', '2014-10-28 13:34:45', 3, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.'),
(4, 'Elit Tortor Amet Justo', '2014-10-28 13:34:51', '2014-10-28 13:35:08', 4, 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Curabitur blandit tempus porttitor. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla vitae elit libero, a pharetra augue.');

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE IF NOT EXISTS `post_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned DEFAULT NULL,
  `tag_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `post_tag_post_id_index` (`post_id`),
  KEY `post_tag_tag_id_index` (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 3, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 3, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 3, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 4, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 4, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 4, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 2, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 4, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'development', '2014-10-28 12:49:40', '2014-10-28 12:49:40'),
(2, 'cooking', '2014-10-28 12:49:45', '2014-10-28 12:49:45'),
(3, 'photography', '2014-10-28 12:49:50', '2014-10-28 12:49:50'),
(4, 'music', '2014-10-28 12:49:54', '2014-10-28 12:49:54'),
(5, 'nature', '2014-10-28 12:49:58', '2014-10-28 12:49:58'),
(6, 'sport', '2014-10-28 12:50:08', '2014-10-28 12:50:08'),
(7, 'reading', '2014-10-28 12:50:54', '2014-10-28 12:50:54'),
(8, 'sailing', '2014-10-28 12:50:59', '2014-10-28 12:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `created_at`, `updated_at`, `password`) VALUES
(1, 'johndoe@gmail.com', '2014-10-28 12:52:14', '2014-10-28 12:53:45', '$2y$10$i0orHXXvi5Y5NyhEA2RUoeKuRNIOQLQH5YOEJVs7Bxff0B3rJIdaa'),
(2, 'bob@gmail.com', '2014-10-28 12:52:47', '2014-10-28 12:53:50', '$2y$10$N5ktqU8KyuGp66AEluBVIeBlGM0SB5iCHDbAyVNx27klbVCN2tMOm'),
(3, 'alice@gmail.com', '2014-10-28 12:52:54', '2014-10-28 12:53:56', '$2y$10$nNpzmrKXQsnwEMidyQBOguzhpt3fIaaQTxHSfARgbXkdjDdx6P0Zy'),
(4, 'frank@gmail.com', '2014-10-28 12:53:02', '2014-10-28 12:54:09', '$2y$10$7t1k9JXyD99DWlQTq.MiM.RbzpMXZajX/VhpmeuH/S8c/LDexi.9G'),
(5, 'user@iol.com', '2014-10-28 12:53:20', '2014-10-28 12:54:22', '$2y$10$96I.PUrRZcDXJ7fvbTIELOrxZi4i1fIyK0lmjw5c74exIFYx3X73.'),
(6, 'mark@hotmail.com', '2014-10-28 12:53:30', '2014-10-28 12:54:46', '$2y$10$.TO3.GscfDyeq.UcfDGTReQCtyao.fw2eZzfJY4e0Q3k2ysVCfbl2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
