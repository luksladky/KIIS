-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Ned 12. úno 2017, 12:34
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
-- Struktura tabulky `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `slug` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_id_uindex` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=428 ;

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id`, `title`, `slug`) VALUES
(288, 'na celou dobu', 'na-celou-dobu'),
(289, 'jen na část', 'jen-na-cast'),
(290, 'pomoc s programem', 'pomoc-s-programem'),
(291, 'pomoc s pomůckami', 'pomoc-s-pomuckami'),
(292, 'na část', 'na-cast'),
(293, 'hlavní org', 'hlavni-org'),
(294, 'štáb', 'stab'),
(295, 'org', 'org'),
(296, 'lektor', 'lektor'),
(297, 'účast', 'ucast'),
(298, 'hlavní', 'hlavni'),
(299, 'pomocný', 'pomocny'),
(300, 'na místě', 'na-miste'),
(301, 'účastník', 'ucastnik'),
(302, 'podobojí', 'podoboji'),
(303, 'dílčí pomoc', 'dilci-pomoc'),
(304, 'jen pá', 'jen-pa'),
(305, 'jen so', 'jen-so'),
(306, 'celou dobu', 'celou-dobu'),
(307, 'pá-ne', 'pa-ne'),
(308, 'pá-so', 'pa-so'),
(309, 'so-ne', 'so-ne'),
(310, 'so', 'so'),
(311, 'ne', 'ne'),
(312, 'pá', 'pa'),
(313, 'jen_porady', 'jen-porady'),
(314, 'Třebíč', 'trebic'),
(315, 'tábořiště', 'taboriste'),
(316, 'programák', 'programak'),
(317, 'oddílák', 'oddilak'),
(318, 'volný', 'volny'),
(319, 'hlavní_kuchař(ka)', 'hlavni-kuchar-ka'),
(320, 'kuchař(ka)', 'kuchar-ka'),
(321, 'hospodář', 'hospodar'),
(322, 'zdravotník', 'zdravotnik'),
(323, 'IO', 'io'),
(324, 'Hráč', 'hrac'),
(325, 'od 15:30', 'od-15-30'),
(326, ' od 16:30', 'od-16-30'),
(327, 'až na místě', 'az-na-miste'),
(328, 'na sraz orgů', 'na-sraz-orgu'),
(329, 'od pá', 'od-pa'),
(330, 'od so dop', 'od-so-dop'),
(331, 'od so odp', 'od-so-odp'),
(332, 'jen valná hromada', 'jen-valna-hromada'),
(333, ' přijedu', 'prijedu'),
(334, 'víkend', 'vikend'),
(335, ' sobota', 'sobota'),
(336, ' jen akce', 'jen-akce'),
(337, ' jen dobrodružná hra', 'jen-dobrodruzna-hra'),
(338, 'jen příprava', 'jen-priprava'),
(339, 'příprava+víkend', 'priprava-vikend'),
(340, 'jen možná', 'jen-mozna'),
(341, 'spíše ne', 'spise-ne'),
(342, 'jen na akci', 'jen-na-akci'),
(343, 'určitě', 'urcite'),
(344, 'spíše jo', 'spise-jo'),
(345, 'snad', 'snad'),
(346, ' fakt ne', 'fakt-ne'),
(347, ' organizátor (šéf dílčího týmu)', 'organizator-sef-dilciho-tymu'),
(348, 'programová pomoc', 'programova-pomoc'),
(349, 'technická pomoc', 'technicka-pomoc'),
(350, 'jen část', 'jen-cast'),
(351, 'organizátorská pomoc', 'organizatorska-pomoc'),
(352, 'organizátor', 'organizator'),
(353, 'lektor-účastník', 'lektor-ucastnik'),
(354, 'účastník-lektor', 'ucastnik-lektor'),
(355, 'příprava před+akce ', 'priprava-pred-akce'),
(356, 'příprava na místě+akce', 'priprava-na-miste-akce'),
(357, 'jen ne', 'jen-ne'),
(358, 'jinak', 'jinak'),
(359, 'Borec', 'borec'),
(360, 'Superborec', 'superborec'),
(361, 'Extraborec', 'extraborec'),
(362, 'Dr.Sňák', 'dr-snak'),
(363, 'celý víkend', 'cely-vikend'),
(364, 'jen PÁ-SO', 'jen-pa-so'),
(365, 'jen SO-NE', 'jen-so-ne'),
(366, 'jen SOBOTA', 'jen-sobota'),
(367, 'so dop', 'so-dop'),
(368, ' so odp', 'so-odp'),
(369, 'ne dop', 'ne-dop'),
(370, 'jen valná hromada+padesátka', 'jen-valna-hromada-padesatka'),
(371, ' jen padesátka', 'jen-padesatka'),
(372, 'příprava', 'priprava'),
(373, ' šéf týmu', 'sef-tymu'),
(374, 'jen je-li nutno', 'jen-je-li-nutno'),
(375, ' jen neděle', 'jen-nedele'),
(376, 'Celá akce', 'cela-akce'),
(377, ' organizační pomoc', 'organizacni-pomoc'),
(378, 'Jedu!', 'jedu'),
(379, ' Nejedu', 'nejedu'),
(380, ' Ještě nevim', 'jeste-nevim'),
(381, 'pomoc na celé akci', 'pomoc-na-cele-akci'),
(382, 'nějaká hra', 'nejaka-hra'),
(383, 'pomůcky ap.', 'pomucky-ap'),
(384, 'možná', 'mozna'),
(385, 'hlavas-fantasy', 'hlavas-fantasy'),
(386, 'hlavas-LARP', 'hlavas-larp'),
(387, 'org-LARP', 'org-larp'),
(388, 'POZVANÁ návštěva', 'pozvana-navsteva'),
(389, 'volný instruktor-progr. příprava', 'volny-instruktor-progr-priprav'),
(390, 'hlavní kuchař', 'hlavni-kuchar'),
(391, 'pomohu s organizací', 'pomohu-s-organizaci'),
(392, 'budu se jen bavit', 'budu-se-jen-bavit'),
(393, 'pomohu celý den', 'pomohu-cely-den'),
(394, 'pomohu na část', 'pomohu-na-cast'),
(395, ' ostatní', 'ostatni'),
(396, 'jen nějaký den', 'jen-nejaky-den'),
(397, 'pojedu', 'pojedu'),
(398, 'budu a pomohu s přípravou', 'budu-a-pomohu-s-pripravou'),
(399, 'budu', 'budu'),
(400, 'spíše budu', 'spise-budu'),
(401, 'možná budu', 'mozna-budu'),
(402, 'spíše nebudu', 'spise-nebudu'),
(403, 'z Třebíče', 'z-trebice'),
(404, 'na táboře', 'na-tabore'),
(405, ' jen sobota-z Třebíče', 'jen-sobota-z-trebice'),
(406, ' jen sobota-na táboře', 'jen-sobota-na-tabore'),
(407, 'Šéf', 'sef'),
(408, 'od sobotního rána', 'od-sobotniho-rana'),
(409, ' od sobotních 13h', 'od-sobotnich-13h'),
(410, 'org na část', 'org-na-cast'),
(411, 'impregnátor', 'impregnator'),
(412, 'celou dobu-akce', 'celou-dobu-akce'),
(413, 'celou dobu-příprava', 'celou-dobu-priprava'),
(414, 'jen část-akce', 'jen-cast-akce'),
(415, 'jen část-příprava', 'jen-cast-priprava'),
(416, 'intruktor', 'intruktor'),
(417, 'vedoucí', 'vedouci'),
(418, 'hospodářská funkce', 'hospodarska-funkce'),
(419, 'akce', 'akce'),
(420, 'půjdu', 'pujdu'),
(421, 'spíšepůjdu', 'spisepujdu'),
(422, 'spíše nepůjdu', 'spise-nepujdu'),
(423, 'Průvodce', 'pruvodce'),
(424, 'Velmistr', 'velmistr'),
(425, 'Pomoc s přípravou', 'pomoc-s-pripravou'),
(426, 'Instruktor na místě', 'instruktor-na-miste'),
(427, 'volný instruktor-progr. příprava', 'volny-instruktor-progr-priprav');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
