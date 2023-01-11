-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-11-2022 a las 19:47:58
-- Versión del servidor: 8.0.31-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `savepetsBD`
--

DROP DATABASE IF EXISTS `savepetsBD`;
CREATE DATABASE IF NOT EXISTS `savepetsBD` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `savepetsBD`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province` varchar(30) NOT NULL,
  `postal_code` int NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `country` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

DROP TABLE IF EXISTS `animal`;
CREATE TABLE IF NOT EXISTS `animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `image` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `specie` enum('cat','dog','bunny','hamster','snake','turtles','other') NOT NULL,
  `chip` enum('yes','no','unknown') DEFAULT NULL,
  `sex` enum('intact_female','intact_male','neutered_female','castrated_male','unknow') NOT NULL,
  `race` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `information` varchar(300) DEFAULT NULL,
  `state` enum('healthy','sick','adopted','dead','foster','vet','unknown','other') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal_adoption`
--

DROP TABLE IF EXISTS `animal_adoption`;
CREATE TABLE IF NOT EXISTS `animal_adoption` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `animal_id` (`animal_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal_shelter`
--

DROP TABLE IF EXISTS `animal_shelter`;
CREATE TABLE IF NOT EXISTS `animal_shelter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shelter` (`user_id`),
  KEY `animal` (`animal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_date` datetime NOT NULL,
  `message` varchar(300) NOT NULL,
  `publication_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `publication_id` (`publication_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `message` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` int NOT NULL,
  `addres_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shelter` (`user_id`),
  KEY `address` (`addres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feature`
--

DROP TABLE IF EXISTS `feature`;
CREATE TABLE IF NOT EXISTS `feature` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_feature` varchar(100) NOT NULL
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_feature` (`key_feature`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `feature` (`id`, `key_feature`) VALUES (1, 'work'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (2, 'studies'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (3, 'marital status'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (4, 'children'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (5, 'housing type'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (7, 'numpets'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (8, 'gender');

--
-- Estructura de tabla para la tabla `feature_user`
--

DROP TABLE IF EXISTS `feature_user`;
CREATE TABLE IF NOT EXISTS `feature_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `feature_id` int NOT NULL,
  `value` varchar(100) NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `feature_id` (`feature_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foster_list`
--

DROP TABLE IF EXISTS `foster_list`;
CREATE TABLE IF NOT EXISTS `foster_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foster_list_user`
--

DROP TABLE IF EXISTS `foster_list_user`;
CREATE TABLE IF NOT EXISTS `foster_list_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `foster_list_id` int NOT NULL,
  `user_id` int NOT NULL,
  `specie` enum('cat','dog','bunny','hamster','snake','turtles','other','indifferent') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `foster_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foster_list_id` (`foster_list_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_date` datetime NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `content` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `transmitter_user_id` int NOT NULL,
  `receiver_user_id` int NOT NULL,
  `readed` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transmitter` (`transmitter_user_id`),
  KEY `receiver` (`receiver_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication`
--

DROP TABLE IF EXISTS `publication`;
CREATE TABLE IF NOT EXISTS `publication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_date` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication_adoption`
--

DROP TABLE IF EXISTS `publication_adoption`;
CREATE TABLE IF NOT EXISTS `publication_adoption` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `animal_id` int NOT NULL,
  `urgent` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`) USING BTREE,
  KEY `animal_id` (`animal_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication_help`
--

DROP TABLE IF EXISTS `publication_help`;
CREATE TABLE IF NOT EXISTS `publication_help` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `categorie` enum('textile','medical devices','food','cleaning products','hygiene products','pet accessories','other') NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication_stray`
--

DROP TABLE IF EXISTS `publication_stray`;
CREATE TABLE IF NOT EXISTS `publication_stray` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `image` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `urgent` enum('yes','no') NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `publication_id` (`publication_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication_stray_address`
--

DROP TABLE IF EXISTS `publication_stray_address`;
CREATE TABLE IF NOT EXISTS `publication_stray_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_stray_id` int NOT NULL,
  `addres_id` int NOT NULL,
  `user_id` int NOT NULL,
  `publication_date` datetime NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_stray_id` (`publication_stray_id`),
  KEY `user_id` (`user_id`),
  KEY `addres_id` (`addres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `DNI_CIF` varchar(9) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('standar','admin','shelter') NOT NULL,
  `addres_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `DNI_CIF` (`DNI_CIF`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `username` (`username`),
  KEY `addres_id` (`addres_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal_adoption`
--
ALTER TABLE `animal_adoption`
  ADD CONSTRAINT `animal_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_adoption_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `animal_shelter`
--
ALTER TABLE `animal_shelter`
  ADD CONSTRAINT `animal_shelter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_shelter_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `feature_user`
--
ALTER TABLE `feature_user`
  ADD CONSTRAINT `feature_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feature_user_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foster_list`
--
ALTER TABLE `foster_list`
  ADD CONSTRAINT `foster_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foster_list_user`
--
ALTER TABLE `foster_list_user`
  ADD CONSTRAINT `foster_list_user_ibfk_1` FOREIGN KEY (`foster_list_id`) REFERENCES `foster_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foster_list_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`transmitter_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiver_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Filtros para la tabla `publication_adoption`
--
ALTER TABLE `publication_adoption`
  ADD CONSTRAINT `publication_adoption_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_adoption_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_adoption_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_help`
--
ALTER TABLE `publication_help`
  ADD CONSTRAINT `publication_help_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_help_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_stray`
--
ALTER TABLE `publication_stray`
  ADD CONSTRAINT `publication_stray_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_stray_address`
--
ALTER TABLE `publication_stray_address`
  ADD CONSTRAINT `publication_stray_address_ibfk_1` FOREIGN KEY (`publication_stray_id`) REFERENCES `publication_stray` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_address_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_address_ibfk_3` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
