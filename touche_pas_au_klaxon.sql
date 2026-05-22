-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 22 mai 2026 à 15:59
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `touche_pas_au_klaxon`
--

-- --------------------------------------------------------

--
-- Structure de la table `agencies`
--

DROP TABLE IF EXISTS `agencies`;
CREATE TABLE IF NOT EXISTS `agencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `agencies`
--

INSERT INTO `agencies` (`id`, `name`) VALUES
(9, 'Bordeaux'),
(10, 'Lille'),
(2, 'Lyon'),
(3, 'Marseille'),
(8, 'Monpellier'),
(6, 'Nantes'),
(5, 'Nice'),
(1, 'Paris'),
(12, 'Reims'),
(11, 'Rennes'),
(7, 'Strasbourg'),
(4, 'Toulouse');

-- --------------------------------------------------------

--
-- Structure de la table `trips`
--

DROP TABLE IF EXISTS `trips`;
CREATE TABLE IF NOT EXISTS `trips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departure_agency_id` int NOT NULL,
  `arrival_agency_id` int NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `seats_total` int NOT NULL,
  `seats_available` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departure_agency_id` (`departure_agency_id`),
  KEY `arrival_agency_id` (`arrival_agency_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `trips`
--

INSERT INTO `trips` (`id`, `departure_agency_id`, `arrival_agency_id`, `departure_time`, `arrival_time`, `seats_total`, `seats_available`, `user_id`) VALUES
(1, 4, 1, '2026-05-04 17:56:00', '2026-05-04 17:56:00', 3, 0, 3),
(2, 9, 10, '2026-05-18 19:58:00', '2026-05-18 23:58:00', 3, 3, 4),
(3, 9, 10, '2026-05-20 18:59:00', '2026-05-21 18:59:00', 3, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `password`, `phone`, `role`) VALUES
(2, 'Martin', 'Alice', 'admin@klaxon.local', '$2a$12$90kp2thfD5v1LFYJwQxINeGR02lqIwIUPPZr64VAijjSyQmGRrj.e', '0605060708', 'admin'),
(3, 'Dupont', 'Jean', 'user@klaxon.local', '$2y$10$7zbpEufM2o6cdV5FmiVIo.UQ9tcbaLAyj1z6WmEh0DzVL4QJvKoDi', '0601020304', 'user'),
(4, 'Martin', 'Marc', 'marc@klaxon.local', '$2y$10$U9QodEGji/DPIE2JIi46WesbbuQK7qR6deaSKHF2AnMHIMfu5zRtq', '0611223344', 'user');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`departure_agency_id`) REFERENCES `agencies` (`id`),
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`arrival_agency_id`) REFERENCES `agencies` (`id`),
  ADD CONSTRAINT `trips_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
