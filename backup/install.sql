-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 11. úno 2017, 18:38
-- Verze serveru: 5.6.15-log
-- Verze PHP: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `kiis`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_activity_id_uindex` (`id`),
  KEY `user_activity_user_id_fk` (`user_id`),
  KEY `activity_thread_id_fk` (`thread_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8407 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `image` varchar(50) DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id_uindex` (`id`),
  KEY `event_user_id_fk` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `event_role`
--

CREATE TABLE IF NOT EXISTS `event_role` (
  `event_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  KEY `event_role_event_id_fk` (`event_id`),
  KEY `event_role_role_id_fk` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `homepage`
--

CREATE TABLE IF NOT EXISTS `homepage` (
  `version` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`version`),
  UNIQUE KEY `homepage_version_uindex` (`version`),
  KEY `homepage_user_id_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `like_id_uindex` (`id`),
  KEY `like_user_id_fk` (`user_id`),
  KEY `like_post_id_fk` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `description` text,
  `security_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `security_role_id_uindex` (`id`),
  UNIQUE KEY `security_role_slug_uindex` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `permission`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order` varchar(20) DEFAULT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `deleted` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `reply_to_id` int(11) DEFAULT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id_uindex` (`id`),
  UNIQUE KEY `post_path_uindex` (`path`),
  KEY `post_thread_id_fk` (`thread_id`),
  KEY `post_user_id_fk` (`user_id`),
  KEY `post_post_id_fk` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `slug` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id_uindex` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=288 ;



-- --------------------------------------------------------

--
-- Struktura tabulky `thread`
--

CREATE TABLE IF NOT EXISTS `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_post` timestamp,
  `event_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `pinned` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `discussion_id_uindex` (`id`),
  KEY `thread_user_id_fk` (`user_id`),
  KEY `thread_event_id_fk` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `thread_hidden_user`
--

CREATE TABLE IF NOT EXISTS `thread_hidden_user` (
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  KEY `thread_hidden_user_user_id_fk` (`user_id`),
  KEY `thread_hidden_user_thread_id_fk` (`thread_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `registration_token` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_activity` timestamp,
  `hash` varchar(100) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `logout` tinyint(1) DEFAULT '0',
  `hash_old` varchar(50) DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `calendar_token` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_uindex` (`id`),
  UNIQUE KEY `user_email_uindex` (`email`),
  UNIQUE KEY `user_reset_token_uindex` (`reset_token`),
  KEY `user_user_id_fk` (`approved_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `user_event`
--

CREATE TABLE IF NOT EXISTS `user_event` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_from` datetime DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `date_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_event_id_uindex` (`id`),
  KEY `user_event_user_id_fk` (`user_id`),
  KEY `user_event_event_id_fk` (`event_id`),
  KEY `user_event_role_id_fk` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=922 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `user_permission`
--

CREATE TABLE IF NOT EXISTS `user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_slug` varchar(50) NOT NULL,
  KEY `user_permission_permission_slug_fk` (`permission_slug`),
  KEY `user_permission_user_id_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `permission` (`id`, `slug`, `description`, `security_level`) VALUES
(1, 'member', 'Přístup ke KIISu, pokud je vypnuto, uživatel uvidí pouze hlavní stránku a zprávu, že má kontaktovat admina.', 1),
(2, 'add-thread', 'Přidávání nových vláken', 2),
(3, 'add-event', 'Přidávání nových událostí', 2),
(4, 'manage-threads', 'Úprava viditelnosti pro ostatní, úprava tématu, mazání příspěvků.', 5),
(5, 'manage-events', 'Správa akcí vytvořených jinými uživateli.', 5),
(6, 'modify-homepage', 'Uprava hlavní stránky', 5),
(7, 'modify-user', 'Editace ostantích uživatelů a jejich práv', 10);


--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id`, `title`, `slug`) VALUES
(1, 'Kuchař', 'kuchar'),
(2, 'Oddílový vedoucí', 'oddilovy-vedouci'),
(3, 'Hlavas', 'hlavas'),
(4, 'Instruktorský oddíl', 'instruktorsky-oddil'),
(5, 'Instruktor', 'instruktor'),
(6, 'Volný instruktor', 'volny-instruktor');



--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_thread_id_fk` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activity_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `event_role`
--
ALTER TABLE `event_role`
  ADD CONSTRAINT `event_role_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_role_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `homepage`
--
ALTER TABLE `homepage`
  ADD CONSTRAINT `homepage_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_post_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_thread_id_fk` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `thread_hidden_user`
--
ALTER TABLE `thread_hidden_user`
  ADD CONSTRAINT `thread_hidden_user_thread_id_fk` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_hidden_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_user_id_fk` FOREIGN KEY (`approved_by_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Omezení pro tabulku `user_event`
--
ALTER TABLE `user_event`
  ADD CONSTRAINT `user_event_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_event_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_permission_slug_fk` FOREIGN KEY (`permission_slug`) REFERENCES `permission` (`slug`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_permission_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



