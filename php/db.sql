-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 20 Janvier 2014 à 10:49
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `eip`
--
CREATE DATABASE IF NOT EXISTS `eip` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `eip`;

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

CREATE TABLE IF NOT EXISTS `archives` (
  `ID` int(1) unsigned NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Creation_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Note` int(1) NOT NULL,
  `Vote_nbr` int(1) NOT NULL,
  `Coach_ID` int(1) unsigned NOT NULL,
  `Valid` int(1) NOT NULL COMMENT '-1=no; 1=yes;',
  `Member_nbr` int(1) NOT NULL,
  `Creator_ID` int(1) unsigned NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `ID` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `passwrd` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_nbr` varchar(25) NOT NULL DEFAULT '-1',
  `type` int(1) NOT NULL DEFAULT '-1' COMMENT '0=Student; 1=Teacher; 2=Admin;',
  `project_ID` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`,`email`,`phone_nbr`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `members`
--

INSERT INTO `members` (`ID`, `login`, `first_name`, `last_name`, `passwrd`, `email`, `phone_nbr`, `type`, `project_ID`) VALUES
(3, 'sscssc', 'carlos', 'jonathan', '92eb5ffee6ae2fec3ad71c777531578f', 'carlos_j@etna_alternance.net', '1', 2, 0),
(14, 'e1', 'e1', 'e1', 'cd3dc8b6cffb41e4163dcbd857ca87da', 'e1@etna-alternance.net', '-1', 1, 20),
(15, 'p1', 'p1', 'p1', 'ec6ef230f1828039ee794566b9c58adc', 'p1', '-1', 2, 0),
(16, 'e2', 'e2', 'e2', '68a9e49bbc88c02083a062a78ab3bf30', 'e2', '-1', 1, 21),
(17, 'p2', 'p2', 'p2', '1d665b9b1467944c128a5575119d1cfd', 'p2', '-1', 2, 0),
(18, 'e3', 'e3', 'e3', '7ed21b04c0dcde1c638e5c8480ad0026', 'e3', '-1', 1, 22),
(19, 'a3', 'a3', 'a3', '9d607a663f3e9b0a90c3c8d4426640dc', 'a3', 'a3', 1, 23),
(20, 'test', 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', '-1', 1, 24),
(21, 'test1', 'sds', 's', '92eb5ffee6ae2fec3ad71c777531578f', 's', '-1', 1, 0),
(22, 'e5', 'e5', 'e5', '72baa9d520b127dd4ab03ff904cc1959', 'e5', '-1', 1, 0),
(23, 'test42', 'b', 'b', '92eb5ffee6ae2fec3ad71c777531578f', 'b', '-1', 1, 0),
(24, 't', 't', 't', 'e358efa489f58062f10dd7316b65649e', 't', '-1', 1, 25),
(25, 'n', 'n', 'n', '7b8b965ad4bca0e41ab51de7b31363a1', 'n', '-1', 1, 26),
(26, 'W', 'W', 'W', '61e9c06ea9a85a5088a499df6458d276', 'W', 'W', 1, 27),
(27, 'q', 'q', 'q', '7694f4a66316e53c8cdd9d9954bd611d', 'q', 'q', 1, 28),
(28, 'h', 'h', 'h', '2510c39011c5be704182423e3a695e91', 'h', 'h', 1, 29),
(29, 'g', 'g', 'g', 'b2f5ff47436671b6e533d8dc3614845d', 'g', 'g', 1, 30),
(30, 'k', 'k', 'k', '8ce4b16b22b58894aa86c421e8759df3', 'k', 'k', 1, 31),
(31, 'i', 'i', 'i', '865c0c0b4ab0e063e5caa3387c1a8741', 'i', 'i', 1, 32),
(32, 'l', 'l', 'l', '2db95e8e1a9267b7a1188556b2013b33', 'l', '-1', 1, 33);

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `ID` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Ceation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Note` int(1) NOT NULL DEFAULT '-1',
  `Vote_nbr` int(1) NOT NULL DEFAULT '-1',
  `Coach_ID` int(1) NOT NULL DEFAULT '-1',
  `Valid` int(1) NOT NULL DEFAULT '-1' COMMENT '-1=rejected; 0=incurrent; 1=accepted',
  `Membre_nbr` int(1) NOT NULL DEFAULT '-1',
  `Creator_ID` int(1) NOT NULL DEFAULT '-1',
  `cdcf` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`,`Name`,`Creator_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `projects`
--

INSERT INTO `projects` (`ID`, `Name`, `Description`, `Ceation_date`, `Note`, `Vote_nbr`, `Coach_ID`, `Valid`, `Membre_nbr`, `Creator_ID`, `cdcf`) VALUES
(19, '[test] Hesperidia shop!', 'Test add project', '2014-01-18 15:08:09', -1, 4, -1, 2, -1, 3, ''),
(20, '[Test] add project etudient 1', '................\r\nDecriptife .....\r\n................\r\n', '2014-01-18 19:47:51', -1, 2, -1, 2, -1, 14, ''),
(21, '[test] add project etudient 2', 'ghggsdsdsdsdsdsdssdd', '2014-01-18 20:06:18', -1, 2, -1, 2, -1, 16, ''),
(22, '[test] add p e3', 'ertfyguhijkl', '2014-01-18 22:03:28', -1, 2, -1, 2, -1, 18, ''),
(23, '[test] add project etudient a3', 'ghjk', '2014-01-18 22:22:36', -1, -1, -1, -1, -1, 19, ''),
(24, 'Last test', 'sddqd', '2014-01-19 00:11:51', -1, 1, -1, 1, -1, 20, ''),
(25, 'test projet !42', 'ertyuj', '2014-01-19 14:24:45', -1, -1, -1, -1, -1, 24, ''),
(26, 'aaaaaaaaaaaaaaaaa', 'aaaaaaa', '2014-01-19 14:30:41', -1, -1, -1, -1, -1, 25, ''),
(27, 'test add projet file', 'jqkskjqhjsk', '2014-01-19 17:05:53', -1, -1, -1, -1, -1, 26, './cdcf/'),
(28, 'gfhjkl', 'fghjkl', '2014-01-19 17:07:45', -1, -1, -1, -1, -1, 27, './cdcf/'),
(29, 'dfghjklkjhgf', 'fghjkl\r\n', '2014-01-19 17:09:30', -1, -1, -1, -1, -1, 28, './cdcf/EIP.sql'),
(30, 's', 'swcwcwxc', '2014-01-19 17:16:15', -1, -1, -1, -1, -1, 29, 'cdcf/EIP.sql'),
(31, 'fghjk', 'hgjkl', '2014-01-19 17:26:51', -1, -1, -1, -1, -1, 30, 'cdcf/EIP.sql'),
(32, 'ui', 'hjkl', '2014-01-19 17:27:58', -1, 1, -1, 1, -1, 31, 'php/cdcf/EIP.sql'),
(33, 'sdfghjkl', 'dfbgnh,jk:;lm', '2014-01-20 10:40:05', -1, -1, -1, -1, -1, 32, 'wamp/www/php/cdcf/');

-- --------------------------------------------------------

--
-- Structure de la table `steps`
--

CREATE TABLE IF NOT EXISTS `steps` (
  `ID` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(1) unsigned NOT NULL,
  `name` varchar(75) NOT NULL,
  `description` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `render_date` varchar(16) NOT NULL,
  `project_ID` int(1) unsigned NOT NULL,
  `valid` int(1) NOT NULL DEFAULT '0' COMMENT '-1=rejected; 0=incurrent; 1=accepted',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`,`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `steps`
--

INSERT INTO `steps` (`ID`, `number`, `name`, `description`, `creation_date`, `render_date`, `project_ID`, `valid`) VALUES
(1, 1, 'zaerty', 'azerty', '2014-01-17 15:38:56', '20/01/2014', 1, 1),
(2, 3, 'zertyu', 'zetyu', '2014-01-17 15:38:56', '23/01/2014', 1, -1),
(3, 2, 'ertyui', 'ertyui', '2014-01-17 15:42:01', '23/2/2014', 1, 0),
(4, 2, 'rtyuio', 'rtyuio', '2014-01-17 15:42:01', '26/01/2014', 2, 0),
(5, 2, 'test', 'en vla une!', '0000-00-00 00:00:00', '15/24/1450', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prof` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `vote`
--

INSERT INTO `vote` (`id`, `id_prof`, `id_project`, `vote`) VALUES
(15, 3, 22, 1),
(16, 15, 21, 1),
(17, 17, 22, 1),
(18, 3, 24, 1),
(19, 3, 32, 1);
