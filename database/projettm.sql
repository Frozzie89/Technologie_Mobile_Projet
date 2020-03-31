-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Mar 31, 2020 at 12:53 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projettm`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id_administrateurs` int(11) NOT NULL AUTO_INCREMENT,
  `id_membres` int(11) NOT NULL,
  PRIMARY KEY (`id_administrateurs`),
  KEY `id_membres` (`id_membres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaires` int(11) NOT NULL AUTO_INCREMENT,
  `texte_commentaires` text NOT NULL,
  `id_posts` int(11) NOT NULL,
  `id_membres` int(11) NOT NULL,
  PRIMARY KEY (`id_commentaires`),
  KEY `id_posts` (`id_posts`),
  KEY `id_membres` (`id_membres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id_likes` int(11) NOT NULL AUTO_INCREMENT,
  `like_likes` int(11) NOT NULL,
  `id_posts` int(11) NOT NULL,
  `id_membres` int(11) NOT NULL,
  PRIMARY KEY (`id_likes`),
  KEY `id_posts` (`id_posts`),
  KEY `id_membres` (`id_membres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id_membres` int(11) NOT NULL AUTO_INCREMENT,
  `login_membres` varchar(50) NOT NULL,
  `motDePasse_membres` varchar(50) NOT NULL,
  `pseudo_membres` varchar(50) NOT NULL,
  PRIMARY KEY (`id_membres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id_photos` int(11) NOT NULL AUTO_INCREMENT,
  `nom_photos` varchar(50) NOT NULL,
  `id_posts` int(11) NOT NULL,
  PRIMARY KEY (`id_photos`),
  KEY `id_posts` (`id_posts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id_posts` int(11) NOT NULL AUTO_INCREMENT,
  `titre_posts` varchar(100) NOT NULL,
  `texte_posts` text NOT NULL,
  `autheur_posts` varchar(50) NOT NULL,
  `nbVue_posts` int(11) NOT NULL,
  `nbLike_posts` int(11) NOT NULL,
  `id_tags` int(11) NOT NULL,
  PRIMARY KEY (`id_posts`),
  KEY `id_tags` (`id_tags`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id_tags` int(11) NOT NULL AUTO_INCREMENT,
  `nom_tags` varchar(50) NOT NULL,
  `affichage_tags` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tags`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id_tags`, `nom_tags`, `affichage_tags`) VALUES
(1, 'actualite', 'Actualité'),
(2, 'culture', 'Culture'),
(3, 'sport', 'Sport'),
(4, 'divertissement', 'Divertissement');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD CONSTRAINT `administrateurs_ibfk_1` FOREIGN KEY (`id_membres`) REFERENCES `membres` (`id_membres`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_membres`) REFERENCES `membres` (`id_membres`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id_posts`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_membres`) REFERENCES `membres` (`id_membres`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id_posts`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id_posts`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_tags`) REFERENCES `tags` (`id_tags`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
