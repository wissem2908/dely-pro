-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 jan. 2026 à 16:04
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `delypro`
--

-- --------------------------------------------------------

--
-- Structure de la table `delypro_inscriptions`
--

CREATE TABLE `delypro_inscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `wilaya` varchar(100) DEFAULT NULL,
  `projet` text DEFAULT NULL,
  `typologie` varchar(150) DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `type_date_naissance` enum('P','N') NOT NULL DEFAULT 'N',
  `nin` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `situation_matrimoniale` enum('Célibataire','Marié(e)','Divorcé(e)','Veuf(ve)') NOT NULL,
  `confirmation_exactitude` tinyint(1) NOT NULL DEFAULT 1,
  `confirmation_cgu` tinyint(1) NOT NULL DEFAULT 1,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `delypro_inscriptions`
--

INSERT INTO `delypro_inscriptions` (`id`, `wilaya`, `projet`, `typologie`, `nom`, `prenom`, `date_naissance`, `type_date_naissance`, `nin`, `adresse`, `telephone`, `email`, `situation_matrimoniale`, `confirmation_exactitude`, `confirmation_cgu`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'Alger', 'test', 'test', 'omri', 'wissem', '2026-01-09', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 0, 0, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 09:00:06'),
(2, 'Alger', 'tet', 'test', 'omri', 'wissem', '2026-01-01', 'N', '747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 0, 0, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 09:03:26');

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`id`, `name`) VALUES
(1, 'Adrar'),
(2, 'Chlef'),
(3, 'Laghouat'),
(4, 'Oum El Bouaghi'),
(5, 'Batna'),
(6, 'Béjaïa'),
(7, 'Biskra'),
(8, 'Béchar'),
(9, 'Blida'),
(10, 'Bouira'),
(11, 'Tamanrasset'),
(12, 'Tébessa'),
(13, 'Tlemcen'),
(14, 'Tiaret'),
(15, 'Tizi Ouzou'),
(16, 'Algiers'),
(17, 'Djelfa'),
(18, 'Jijel'),
(19, 'Sétif'),
(20, 'Saïda'),
(21, 'Skikda'),
(22, 'Sidi Bel Abbès'),
(23, 'Annaba'),
(24, 'Guelma'),
(25, 'Constantine'),
(26, 'Médéa'),
(27, 'Mostaganem'),
(28, 'M\'Sila'),
(29, 'Mascara'),
(30, 'Ouargla'),
(31, 'Oran'),
(32, 'El Bayadh'),
(33, 'Illizi'),
(34, 'Bordj Bou Arreridj'),
(35, 'Boumerdès'),
(36, 'El Tarf'),
(37, 'Tindouf'),
(38, 'Tissemsilt'),
(39, 'El Oued'),
(40, 'Khenchela'),
(41, 'Souk Ahras'),
(42, 'Tipaza'),
(43, 'Mila'),
(44, 'Aïn Defla'),
(45, 'Naâma'),
(46, 'Aïn Témouchent'),
(47, 'Ghardaïa'),
(48, 'Relizane'),
(49, 'El M’Ghair'),
(50, 'El Menia'),
(51, 'Ouled Djellal'),
(52, 'Bordj Badji Mokhtar'),
(53, 'Béni Abbès'),
(54, 'In Salah'),
(55, 'In Guezzam'),
(56, 'Touggourt'),
(57, 'Djanet'),
(58, 'El Bayadh');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `delypro_inscriptions`
--
ALTER TABLE `delypro_inscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `delypro_inscriptions`
--
ALTER TABLE `delypro_inscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
