-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.22-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных readme
CREATE DATABASE IF NOT EXISTS `readme1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `readme1`;

-- Дамп структуры для таблица readme.content
CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `class_name` (`class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.content: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`id`, `title`, `class_name`) VALUES
	(1, 'Текст', 'text'),
	(2, 'Цитата', 'quote'),
	(3, 'Фото', 'photo'),
	(4, 'Видео', 'video'),
	(5, 'Ссылка', 'link');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;

-- Дамп структуры для таблица readme.hashtag
CREATE TABLE IF NOT EXISTS `hashtag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.hashtag: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `hashtag` DISABLE KEYS */;
/*!40000 ALTER TABLE `hashtag` ENABLE KEYS */;

-- Дамп структуры для таблица readme.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `registered` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.roles: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Дамп структуры для таблица readme.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registration_date` datetime NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `avatar` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.users: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `registration_date`, `name`, `email`, `login`, `password`, `avatar`) VALUES
	(1, '2014-12-05 12:05:14', 'Лариса', 'larisa@mail.ru', 'Larisa', '123456', 'userpic-larisa-small.jpg'),
	(2, '2017-05-09 13:06:14', 'Владик', 'vladik@mail.ru', 'Vladik', '654321', 'userpic.jpg'),
	(3, '2017-05-09 13:06:14', 'Виктор', 'viktor@mail.ru', 'Viktor', '654321', 'userpic-mark.jpg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;









-- Дамп структуры для таблица readme.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_view` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `quote_author` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user` (`user_id`),
  KEY `FK_content` (`content_id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `text` (`text`),
  CONSTRAINT `FK_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.post: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id`, `date`, `title`, `text`, `picture`, `video`, `link`, `count_view`, `likes`, `quote_author`, `user_id`, `content_id`) VALUES
	(1, '2015-12-05 12:05:14', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', '', '', '', 5, 1, '', 1, 2),
	(2, '2015-12-05 12:05:14', 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', '', '', '', 8, 0, '', 2, 1),
	(3, '2015-12-05 12:05:14', 'Наконец, обработал фотки!', '', 'rock-medium.jpg', '', '', 6, 0, '', 3, 3),
	(4, '2015-12-05 12:05:14', 'Моя мечта', '', 'coast-medium.jpg', '', '', 14, 0, '', 1, 3),
	(5, '2015-12-05 12:05:14', 'Лучшие курсы', '', '', '', 'www.htmlacademy.ru', 12, 0, '', 2, 5);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;


-- Дамп структуры для таблица readme.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_date` datetime NOT NULL,
  `comment_text` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_user` (`user_id`),
  KEY `FK_comment_post` (`post_id`),
  CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.comment: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`id`, `comment_date`, `comment_text`, `user_id`, `post_id`) VALUES
	(1, '2020-07-12 19:49:10', 'Прикольное фото', 1, 3),
	(2, '2020-07-12 19:49:10', 'Дождались!', 3, 2);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;


-- Дамп структуры для таблица readme.like
CREATE TABLE IF NOT EXISTS `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_like_user` (`user`),
  KEY `FK_like_post` (`post`),
  CONSTRAINT `FK_like_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_like_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.like: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;

-- Дамп структуры для таблица readme.message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_time` datetime NOT NULL,
  `message_text` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user1` (`user1_id`),
  KEY `FK_user2` (`user2_id`),
  CONSTRAINT `FK_user1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_user2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.message: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;


-- Дамп структуры для таблица readme.post_hashtag
CREATE TABLE IF NOT EXISTS `post_hashtag` (
  `post_id` int(11) NOT NULL,
  `hashtag_id` int(11) NOT NULL,
  KEY `FK_hashtag_id` (`hashtag_id`),
  KEY `FK_post_id` (`post_id`),
  CONSTRAINT `FK_hashtag_id` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`id`),
  CONSTRAINT `FK_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.post_hashtag: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `post_hashtag` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_hashtag` ENABLE KEYS */;


-- Дамп структуры для таблица readme.subscription
CREATE TABLE IF NOT EXISTS `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscribed_user` int(11) NOT NULL,
  `subscribed_user1` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_subscribed_user` (`subscribed_user`),
  KEY `FK_subscribed_user1` (`subscribed_user1`),
  CONSTRAINT `FK_subscribed_user` FOREIGN KEY (`subscribed_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_subscribed_user1` FOREIGN KEY (`subscribed_user1`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы readme.subscription: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
INSERT INTO `subscription` (`id`, `subscribed_user`, `subscribed_user1`) VALUES
	(1, 2, 1);
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;



/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
