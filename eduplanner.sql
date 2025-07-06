-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 06, 2025 at 03:58 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduplanner`
--

-- --------------------------------------------------------

--
-- Table structure for table `emplois_du_temps`
--

DROP TABLE IF EXISTS `emplois_du_temps`;
CREATE TABLE IF NOT EXISTS `emplois_du_temps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `semaine` date NOT NULL,
  `fichier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_publication` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emplois_du_temps`
--

INSERT INTO `emplois_du_temps` (`id`, `classe`, `semaine`, `fichier`, `date_publication`) VALUES
(11, 'PREPA 1', '2025-07-21', 'emploi_2025-07-05_6869ab7fda665.xls', '2025-07-05 22:47:27'),
(12, 'PREPA 2', '2025-07-07', 'emploi_2025-07-05_6869ac3e4ae7e.xls', '2025-07-05 22:50:38'),
(13, 'ING 1', '2025-07-20', 'emploi_2025-07-06_6869bd0e128e5.xls', '2025-07-06 00:02:22'),
(14, 'ING 3', '2025-07-24', 'emploi_2025-07-06_6869bd18c9e82.xls', '2025-07-06 00:02:32'),
(15, 'ING 2', '2025-07-13', 'emploi_2025-07-06_6869bd2d5a5d5.xls', '2025-07-06 00:02:53'),
(16, 'ING 2', '2025-07-14', 'emploi_2025-07-06_6869e38b8e94e.xls', '2025-07-06 02:46:35'),
(17, 'ING 2', '2025-07-14', 'emploi_2025-07-06_6869e473c1f70.xls', '2025-07-06 02:50:27'),
(18, 'ING 2', '2025-07-14', 'emploi_2025-07-06_686a984ae6347.xls', '2025-07-06 15:37:46'),
(19, 'ING 1', '2025-07-08', 'emploi_2025-07-06_686a9a208eb77.xls', '2025-07-06 15:45:36'),
(20, 'ING 1', '2025-07-08', 'emploi_2025-07-06_686a9a5ed1ab1.xls', '2025-07-06 15:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lue` tinyint(1) DEFAULT '0',
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `lue`, `date_envoi`) VALUES
(14, 4, 'Un nouvel emploi du temps pour la classe ING 2 a été publié (Semaine: 2025-07-13).', 1, '2025-07-06 00:02:53'),
(15, 4, 'Un nouvel emploi du temps pour la classe ING 2 a été publié (Semaine: 2025-07-14).', 1, '2025-07-06 02:46:35'),
(16, 4, 'Un nouvel emploi du temps pour la classe ING 2 a été publié (Semaine: 2025-07-14).', 1, '2025-07-06 02:50:27'),
(17, 4, 'Un nouvel emploi du temps pour la classe ING 2 a été publié (Semaine: 2025-07-14).', 1, '2025-07-06 15:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `classe` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `derniere_connexion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`, `classe`, `derniere_connexion`) VALUES
(1, 'memel', 'axelmea09@gmail.com', '$2y$10$0XVrvYb0ebKr.mBInGW8Oud2iKoW.0kqoeKxqqh8pqf3Xh8NKgx36', 'ING 1', NULL),
(2, 'kevin', 'kevint@gmail.com', '$2y$10$htcyNWUnWY9qOCMRuTz5jOpzpUB.HGQcuMXUstgxrWF/Yh6m2n9EO', '', NULL),
(3, 'TESTEUR1', 'testeur1@gmail.com', '$2y$10$5ybDUHCt1JHyNggoxpaLauik7KvGu5jnm4bp2O8zxOyAH8Zl0rgey', 'PREPA 2', '2025-07-06 02:06:31'),
(4, 'testeur2', 'testeur2@gmail.com', '$2y$10$nkJTSqmai/TvrmqkouYhHOVkA3SDOoXSl/5ZmcOOil9VFNMg1V0Ru', 'ING 2', '2025-07-06 15:40:46'),
(5, 'testeur 3', 'testeur3@gmail.com', '$2y$10$AjYAY1E6srfhgpyunaoqOe71aRNWqVvJtG6zzTG8qqL4ESci7dCXS', 'PREPA 1', NULL),
(6, 'testeur4', 'testeur4@gmail.com', '$2y$10$Hz5.tsedKzOp5pEpaZTvse8.pcvQRK4gNyj2u5hvrG9YEi/CjnDsK', 'ING 3', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
