-- Adminer 4.8.1 MySQL 10.4.28-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `animateur`;
CREATE TABLE `animateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `equipe`;
CREATE TABLE `equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tournois` int(11) NOT NULL,
  `id_poule` int(11) DEFAULT NULL,
  `id_joueur1` int(11) DEFAULT NULL,
  `id_joueur2` int(11) DEFAULT NULL,
  `id_joueur3` int(11) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tournois` (`id_tournois`),
  KEY `id_poule` (`id_poule`),
  KEY `nom_joueur1` (`id_joueur1`),
  KEY `nom_joueur2` (`id_joueur2`),
  KEY `nom_joueur3` (`id_joueur3`),
  CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`id_tournois`) REFERENCES `tournois` (`id`),
  CONSTRAINT `equipe_ibfk_2` FOREIGN KEY (`id_poule`) REFERENCES `poule` (`id`),
  CONSTRAINT `equipe_ibfk_3` FOREIGN KEY (`id_joueur1`) REFERENCES `joueur` (`id`),
  CONSTRAINT `equipe_ibfk_4` FOREIGN KEY (`id_joueur2`) REFERENCES `joueur` (`id`),
  CONSTRAINT `equipe_ibfk_5` FOREIGN KEY (`id_joueur3`) REFERENCES `joueur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `joueur`;
CREATE TABLE `joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_animateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_equipe` (`id_animateur`),
  CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`id_animateur`) REFERENCES `animateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `poule`;
CREATE TABLE `poule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tournois` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tournois` (`id_tournois`),
  CONSTRAINT `poule_ibfk_1` FOREIGN KEY (`id_tournois`) REFERENCES `tournois` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tournois`;
CREATE TABLE `tournois` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_animateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `nb_joueur_equipe` int(11) NOT NULL,
  `poule` enum('oui','non') NOT NULL DEFAULT 'non',
  `nb_poule` int(11) NOT NULL,
  `nb_equipe_poule` int(8) NOT NULL,
  `consolante` enum('oui','non') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_animateur`),
  CONSTRAINT `tournois_ibfk_1` FOREIGN KEY (`id_animateur`) REFERENCES `animateur` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2024-06-20 12:28:54
