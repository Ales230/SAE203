-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 28 mai 2023 à 15:54
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `location_materiel`
--

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `ID_materiel` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`ID_materiel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`ID_materiel`, `nom`, `reference`, `type`, `description`) VALUES
(374529, 'Trépied', 'TRE2462', 'video', 'trépied'),
(384649, 'Camera HD', 'CAM2819', 'video', 'Camera'),
(396403, 'projecteur', 'PRO2810', 'video', 'Projecteur vidéo pour diffuser des présentations ou des vidéos.'),
(464531, 'micro', 'HU2G27', 'audio', 'micro'),
(563610, 'Micro', 'RAZT718', 'audio', 'mic'),
(593568, 'Microphone', 'MIC3820', 'audio', 'un micro'),
(640303, 'Casqueeeeeeeeeeee', 'CAJ7281', 'Type 2', 'casque'),
(816742, 'camera', 'R262G2', 'Autre type de matériel', 'camera'),
(831731, 'rge', 'ezqgfzq', 'audio', 'gzeg');

-- --------------------------------------------------------

--
-- Structure de la table `reserve`
--

DROP TABLE IF EXISTS `reserve`;
CREATE TABLE IF NOT EXISTS `reserve` (
  `ID_utilisateur` int NOT NULL,
  `ID_materiel` int NOT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ID_reservation` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID_reservation`),
  KEY `reserve_Materiel0_FK` (`ID_materiel`),
  KEY `ID_utilisateur` (`ID_utilisateur`,`ID_materiel`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reserve`
--

INSERT INTO `reserve` (`ID_utilisateur`, `ID_materiel`, `dateDebut`, `dateFin`, `statut`, `ID_reservation`) VALUES
(655977, 374529, '1111-11-11', '1111-11-11', 'acceptee', 15),
(393546, 831731, '1212-12-12', '1212-12-13', 'acceptée', 16),
(393546, 374529, '1212-12-12', '1212-12-12', 'rejetée', 17),
(393546, 593568, '1111-11-11', '1111-11-11', 'acceptée', 18),
(655977, 396403, '2023-11-11', '2023-11-12', 'acceptee', 19),
(393546, 384649, '2023-11-11', '2023-11-12', 'acceptée', 20),
(393546, 593568, '1111-11-11', '1111-11-12', 'en attente', 21),
(393546, 593568, '1111-11-11', '1111-11-11', 'en attente', 22),
(393546, 593568, '1111-11-11', '1111-11-11', 'en attente', 23),
(393546, 593568, '1111-11-11', '1111-11-11', 'rejetée', 24),
(393546, 593568, '1111-11-11', '1111-11-12', 'en attente', 25);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `ID_role` int NOT NULL,
  `Nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`ID_role`, `Nom_role`) VALUES
(1, 'utilisateur'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID_utilisateur` int NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `datenaiss` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ID_role` int NOT NULL,
  PRIMARY KEY (`ID_utilisateur`),
  KEY `utilisateur_role_FK` (`ID_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_utilisateur`, `prenom`, `nom`, `email`, `datenaiss`, `password`, `ID_role`) VALUES
(393546, 'b', 'th', 'gerardaoste@gmail.com', '1671-12-15', '$2y$12$wxmk.HiHy61At5N4r74qBeSXTuHveTLVNX1lDUOJMSEMezLMGdaD.', 1),
(490833, 'zefze', 'zfzef', 'zefzf@zefz', '2222-02-12', '$2y$12$xPaVRJhS6bu1f1mbULtzneteHmpshj5/YfFWPbBBr5pHkTVJ2b3ke', 1),
(646739, 'A', 'A', 'dvzghrec@euzzze.com', '0001-01-01', '$2y$12$GEL2BUpN2Cnu29os2BP1YOVhWBONWIn9NyZa5QOvdLlruAnEjyxC2', 1),
(655977, 'test', 'test', 'admin@admin.com', '1000-10-10', '$2y$12$hfL5XEK36TGnt4mxh8xeA.prCcyY34ZSs3dAquNgqm/h4jnAajVn2', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `reserve_Materiel0_FK` FOREIGN KEY (`ID_materiel`) REFERENCES `materiel` (`ID_materiel`),
  ADD CONSTRAINT `reserve_utilisateur_FK` FOREIGN KEY (`ID_utilisateur`) REFERENCES `utilisateur` (`ID_utilisateur`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_role_FK` FOREIGN KEY (`ID_role`) REFERENCES `role` (`ID_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
