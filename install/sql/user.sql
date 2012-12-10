-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 10 Décembre 2012 à 15:38
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `graphit`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` char(255) CHARACTER SET ascii NOT NULL,
  `first_time_seen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_time_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_black_listed` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


--
-- Déclencheurs `user`
--
DROP TRIGGER IF EXISTS `user_trigger_before_insert`;
DELIMITER //
CREATE TRIGGER `user_trigger_before_insert` BEFORE INSERT ON `user`
 FOR EACH ROW BEGIN
SET NEW.first_time_seen = UNIX_TIMESTAMP();
SET NEW.email = SHA(NEW.email);
END
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
