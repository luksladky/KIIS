-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Ned 12. úno 2017, 12:33
-- Verze serveru: 5.5.41-0+wheezy1
-- Verze PHP: 5.4.36-0+deb7u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `ddmhradek_cz`
--

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
  `last_activity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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

--
-- Vypisuji data pro tabulku `user`
--
INSERT INTO `user` (`id`, `name`, `nickname`, `email`, `phone`, `photo`, `reset_token`, `registration_token`, `created_at`, `last_activity`, `hash`, `city`, `logout`, `hash_old`, `approved_by_id`, `calendar_token`) VALUES
(25, 'Lukáš Sladký', 'Lukin', 'lusladky@gmail.com', '724410215', 'profile/25_profile.jpg', NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 11:29:49', '$2y$10$22xWYEXQE0mK040luC5JoOcRDyzUVjHrT4ssUIyY.cZD0L8b0w5pS', 'Praha', 0, NULL, 25, 'b6ten593nj3tknw2tojrollfpbo5itphyhx7lday6wvnohhfv7');

INSERT INTO `user` (`id`, `name`, `nickname`, `email`, `phone`, `photo`, `reset_token`, `registration_token`, `created_at`, `last_activity`, `hash`, `city`, `logout`, `hash_old`, `approved_by_id`, `calendar_token`) VALUES
(1, 'Michal Schorm', 'Veverčák', 'mschorm@centrum.cz', '702 573 656', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-11 10:28:27', NULL, 'Brno', 1, '4b4826029f98c52d1ad8c160c3c3a318', 25, NULL),
(2, 'František Vejmělka', 'Spider', 'v.spider@seznam.cz', '721 346 997', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 09:14:40', NULL, 'Třebíč', 0, '6085d86d916b20ee4d5e6b656d271558', 25, NULL),
(3, 'Pavel Ratkovský', 'Drsňák', 'pavel.ratkovsky@gmail.com', '725 699 644', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-10 19:39:44', NULL, 'Třebíč', 0, 'bcba2cd4a8e04d38f51e25d7c83067c8', 25, NULL),
(4, 'Kamil Svoboda', 'Bohouš', 'svoboda@ddmtrebic.cz', '725405845', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-11 09:19:13', NULL, 'Stařeč', 0, '3407115e6ecdf92dbf6add4e2ec6b8d3', 25, NULL),
(5, 'Kuba Norbert', 'Kubajz', 'kubajs911@seznam.cz', '728329590', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 09:11:41', NULL, 'Dačice', 0, '570fe428b19ad8b9be8be4bfdb327db1', 25, NULL),
(6, 'David Rypel', 'raket', 'rypeld@gmail.com', '732651451', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-10 09:47:13', NULL, 'Brno', 0, '392222cfa204f94f5b98119588c27c94', 25, NULL),
(7, 'matěj lorenc', 'prcek', 'mates.lorenco@seznam.cz', '731844136', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-10-20 02:01:24', NULL, 'Třebíč', 0, 'bf0ea7e9a0065cffc1da96d246545cc7', 25, NULL),
(8, 'Jakub Křivý', 'KuKř', 'jamesikxxx@gmail.com', '605455472', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-09 12:32:14', NULL, 'Třebíč nebo Brno', 0, 'd78091c4f4ecb5b5f5a988c7a1b33b73', 25, NULL),
(9, 'Zdeněk Svoboda', 'Zdeněk', 'cidonius@volny.cz', '602765156', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-04 21:48:49', NULL, 'Moravské Budějovice', 0, 'a55450aced75cb6cc1b33d09092bf858', 25, NULL),
(10, 'Tomáš Kašparides', 'Dědek', 'trebican@gmail.com', '721770683', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-20 21:40:53', NULL, 'Černá Hora', 0, 'abcae0bc5c393e9a223aca8f46e45468', 25, NULL),
(11, 'Jana Pevná', 'Janča', 'janapevna@seznam.cz', '721111090', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-05 15:26:54', NULL, 'Jaroměřice nad Rokytnou', 0, '5db570f8bc09d03553fe6ac46e3617da', 25, NULL),
(12, 'Anna Kravarova', 'Ani', 'akravarova@seznam.cz', '777 163 586', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-07 16:40:51', NULL, 'Čáslavice', 0, 'd523dcf473ec1d49398503217efbf321', 25, NULL),
(13, 'Káťa Maryšková', 'Káťa', 'k.maryskova@seznam.cz', '773 686 881', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-07-04 20:20:22', NULL, '', 0, 'a52fd7c15fd1596f1f20edec6a740d6a', 25, NULL),
(14, 'Adéla Jonáková', 'Áďa', 'adelajonakova01@seznam.cz', '724471364', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-06 18:42:33', NULL, 'Vyskytná nad Jihlavou', 0, '63687e9aa7f0fe87f61fc3bcaa78b50b', 25, NULL),
(15, 'Michal Hejsek', 'meda', 'mhejsek@gmail.com', '608925894', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 00:00:18', NULL, 'Kostice', 0, '505a628f1ac26babf674054bbfe447f8', 25, NULL),
(16, 'Jan Jelínek', 'Honza', 'mrgazzoz@gmail.com', '728 661 964', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-04 19:32:38', NULL, 'Třebíč', 0, 'a6787d3bb181c523b14532ec0f272839', 25, NULL),
(17, 'Lenka Šabachová', 'LenkaS', 'lenka.sabachova@gmail.com', '774943400', NULL, NULL, NULL, '2017-02-12 09:57:58', '2015-03-22 11:13:46', NULL, 'Třebíč', 0, '88548bc23a68bb84a2a1847870c3eeee', 25, NULL),
(18, 'Radomír Vejmělka', 'Vampi', 'Vampirius@email.cz', '739553823', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-06 15:40:43', NULL, 'Třebíč', 0, '7f73a315bf2d32c5f52bbb28952d7c7a', 25, NULL),
(19, 'Tereza Kašková', 'Terka', 'terkakaskova@seznam.cz', '608263505', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 09:29:00', NULL, '', 0, '8c793f098e1b0f9de688cfe66a83ec26', 25, NULL),
(20, 'Klára Kovaříková', 'Klárka', 'klara.kowa514@seznam.cz', '737155575', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-01-03 12:58:25', NULL, 'Třebíč', 0, '80e4d02c80281c1e2b1bc7ebed824b60', 25, NULL),
(23, 'Libor Kravar', 'libor', 'liborkravar@seznam.cz', '777959416', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-07 13:56:20', NULL, 'Výčapy', 0, '5a1fdfa2202c1a3fe55aeec33f26aef5', 25, NULL),
(24, 'Luděk Soukup', 'Luděk', 'ludek.soukup@seznam.cz', '737477318', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-09-17 18:43:10', NULL, 'Brno', 0, '6edb65bc52d9b5b20ab449c7e2e4fc18', 25, NULL),
(26, 'Markéta Krejčová', 'Markéta', 'krejcovamiki@seznam.cz', '', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-11 19:23:30', NULL, '', 0, '146a633fc781764e68c1af5962dd4c15', 25, NULL),
(27, 'Zdenka Kolářová', 'Zdenka', 'houbesova@seznam.cz', '724753488', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-12 19:18:25', NULL, 'Nárameč', 0, '0378119fe6478c5fc68c06af9a348330', 25, NULL),
(28, 'Filip Rosenkranc', 'Filip', 'frosenkranc@gmail.com', '728 106 822', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-10 07:40:26', NULL, 'Praha', 0, 'df5bf6794a96f28aef8b14f4641a151a', 25, NULL),
(29, 'Kristýna Maryšková', 'Kristýna', 'kmaryskova@seznam.cz', '773686880', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-09 20:31:56', NULL, 'Jihlava', 0, '932704b68739dbbb34e798a5f851fa00', 25, NULL),
(30, 'Eliška Kašparidesová', 'Keli', 'efanfrdlova@gmail.com', '730973449', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 08:38:37', NULL, 'Černá hora', 0, 'b03280c9f7b22b7d7bc6ac55394c503f', 25, NULL),
(31, 'Roman Javorek', 'Rosťa', 'r.javorek.rj@gmail.com', '720705694', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-10-25 14:25:46', NULL, 'Čáslavice', 0, '67af41f31b4182be54bc3f83aa41bc66', 25, NULL),
(33, 'Václav Kulovaný', 'Derik', 'dzudo@seznam.cz', '720663995', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-11 19:11:08', NULL, 'Třebíč nebo Brno', 0, 'aaf847b32e18c80c6993c24984399cb8', 25, NULL),
(34, 'Karolína Koláčná', 'Kája', 'kajakolacna@centrum.cz', '724 851 265', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-05 17:08:04', NULL, 'Větrný Jeníkov', 0, '30d97ebc2f43b040376abbdabe3dffa4', 25, NULL),
(35, 'Romana Svobodová', 'Romča', 'romca.skritek@seznam.cz', '739572821', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-08 17:33:22', NULL, 'Stařeč', 0, 'b4491b4f8b56aa9decc43b6400663f49', 25, NULL),
(36, 'Kamil Peštál', 'Kamil', 'kamilpestal1992@gmail.com', '608872335', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-10-26 17:48:13', NULL, 'Třebíč', 1, '7840a980c99624ebee60d17648db43df', 25, NULL),
(39, 'Monika Robotková', 'Monča', 'robotkova.m@seznam.cz', '605320412', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-08-30 15:30:05', NULL, 'Velké Meziříčí', 0, 'cef44cab10301e3c0e8937793c62419c', 25, NULL),
(41, 'David Svoboda', 'Dejf', 'svoboda989@gmail.com', '739572820', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-06 22:04:37', NULL, 'Stařeč ', 0, '51784eb648a34f318471bf7cf885258a', 25, NULL),
(43, 'Jan Růžička', 'honza r', 'jan.ruzicka360@gmail.com', '605430434', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-09 16:00:56', NULL, 'Náměšť nad Oslavou', 0, 'ef23c9199de7762cb38244eeab6b313d', 25, NULL),
(44, 'Tomáš Látal', 'hemmond', 'tomlatal@post.cz', '774308672 733656942', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-07 14:12:34', NULL, 'Brno', 0, 'a406455ba38dd469bcd16bba8dcfc40e', 25, NULL),
(45, 'Lenka Kotyzová', 'Brouček', 'sestinozka@gmail.com', '725381481', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-07 10:13:44', NULL, 'Třebíč', 0, 'fa2dd7899fd6b8af4fb55c64014c5864', 25, NULL),
(46, 'Pavla Kratochvílová', 'Pavča', 'kratochvilovapavla@email.cz', '605480790', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-01-31 18:34:32', NULL, 'Třebíč', 0, 'a0d465a69be727347da4e3941199b700', 25, NULL),
(48, 'Lenka Kafková', 'Mufča', 'mufik@seznam.cz', '737771253', NULL, NULL, NULL, '2017-02-12 09:57:58', '2015-09-13 10:41:38', NULL, 'Třebíč', 0, 'bfdb20e2cc50aae4663448f1d1cb5bbd', 25, NULL),
(50, 'Gabriela Fialová', 'Gábi', 'gab.fialova@seznam.cz', '605717800', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-10-13 17:26:43', NULL, '', 0, '0d67c3102221235cc25dbaa9093d2571', 25, NULL),
(51, 'Alena  Svobodová', 'Ája', 'alena.svobodova.trebic@seznam.cz', '605384110', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-09-09 08:38:43', NULL, 'Třebíč', 0, 'c67f09b78b3c9db7f2d4f059455a7952', 25, NULL),
(52, 'Václav  Jelínek', 'Vašek', 'jelinek.vaclav39@gmail.com', '606876125', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-02 23:22:53', NULL, 'Třebíč', 0, '3f6e45f18900e2c7341f82f3fe01275c', 25, NULL),
(53, 'Jakub Balabán', 'Bonbon', '29bonbon@gmail.com', '723404664', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-11 13:05:12', NULL, 'Třebíč', 0, '6d8952d77e7e211136d33855e4ee455f', 25, NULL),
(54, 'Matěj Vláčil', 'Matěj', 'matej.vlacil@gmail.com', '602627348', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-12 11:16:43', '$2y$10$gUvLygYB/wkFUMIpdM3Q5uXcX6IjjRs/CtmBFp8Zl8uO6Y0ad27Ji', 'Stařeč', 0, NULL, 25, NULL),
(55, 'Jana Svobodová', 'Žába', 'janastarec@seznam.cz', '739572819', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-07 09:12:07', NULL, 'Stařeč', 0, 'cc90870a97f9c854d16500e0036d8e65', 25, NULL),
(56, 'Jakub Máca', 'Kruba', 'kuba.maca@email.cz', '733 159 124', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-11 10:49:35', NULL, 'Třebič ', 0, '53b7ffad4a03474ff0879f679ce98fda', 25, NULL),
(57, 'Jakub Hájek', 'Laenor', 'kubianiv@email.cz', '730 596 121', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-20 13:36:06', NULL, 'Třebíč', 0, 'fadf6a7c2afb53c4ce90587c20c9cbfe', 25, NULL),
(58, 'Nela Šulová', 'Nela', 'sulovanela@seznam.cz', '', NULL, NULL, NULL, '2017-02-12 09:57:58', '1970-01-01 00:00:01', NULL, '', 0, '305f0b53e4dda20e2e46ba7d449bc745', 25, NULL),
(59, 'Martina Burianová', 'Marťa', 'burianova.m.r@seznam.cz', '702 285 062', NULL, NULL, NULL, '2017-02-12 09:57:58', '2016-10-09 15:27:43', NULL, 'Bítovánky ', 0, '4f32989211b6bb494d30fca97ca57c8f', 25, NULL),
(60, 'Ondřej Kaška', 'Ondra', 'ondrejkaska@seznam.cz', '', NULL, NULL, NULL, '2017-02-12 09:57:58', '1970-01-01 00:00:01', NULL, '', 0, '335626ac61a945ee3ab8777da821353e', 25, NULL),
(61, 'Dominika Zemánková', 'Sůša', 'domcazemankova@seznam.cz', '774534662', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-01-09 20:53:45', NULL, 'Moravské Budějovice', 0, '3d48a1f2dcb20c3fc8aec4a8d18fc874', 25, NULL),
(62, 'Martin Balabán', 'Žužu', 'mart22240@gmail.com', '731404665', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-09 14:46:19', NULL, 'Třebíč', 0, 'e2ddb5af5e5b40361fe1d1a18468b10b', 25, NULL),
(63, 'Lucie Šlampová', 'Lůca', 'lucinka.slampova@seznam.cz', '', NULL, NULL, NULL, '2017-02-12 09:57:58', '1970-01-01 00:00:01', NULL, '', 0, 'a4fcba8864be23f6e6f1e9c9e29f467b', 25, NULL),
(64, 'Martin Kratochvíl', 'Cvrček', 'cvrcek.martin@email.cz', '732976126', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-01 10:58:46', NULL, 'Třebíč', 0, '8149e914136a86dc2d8c3c0780b1f8a6', 25, NULL),
(65, 'Michaela Petříčková', 'Míša', 'michaela.petrickova@email.cz', '721 446 112', NULL, NULL, NULL, '2017-02-12 09:57:58', '2017-02-08 17:45:27', NULL, 'Brno', 0, 'c07ecbdce1de2ef7b3ddf6965eef3ea5', 25, NULL);

