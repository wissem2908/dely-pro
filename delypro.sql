-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 04 fév. 2026 à 14:13
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
-- Structure de la table `choix_site`
--

CREATE TABLE `choix_site` (
  `id_site` int(11) NOT NULL,
  `wilaya` varchar(20) NOT NULL,
  `projet` varchar(200) NOT NULL,
  `typologie` varchar(200) NOT NULL,
  `id_inscription` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `choix_site`
--

INSERT INTO `choix_site` (`id_site`, `wilaya`, `projet`, `typologie`, `id_inscription`) VALUES
(1, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'Place de stationnement', 34),
(2, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'F5', 35),
(3, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'F5', 36),
(4, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'F5', 37),
(5, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'F5', 38),
(6, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'Place de stationnement', 39),
(7, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'F5', 40),
(8, '16', 'Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)', 'Place de stationnement', 41);

-- --------------------------------------------------------

--
-- Structure de la table `delypro_documents`
--

CREATE TABLE `delypro_documents` (
  `id` int(11) NOT NULL,
  `inscription_id` int(11) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `document_type` enum('piece_identite','extrait_naissance') NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_extension` varchar(10) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delypro_documents`
--

INSERT INTO `delypro_documents` (`id`, `inscription_id`, `reference`, `document_type`, `filename`, `file_path`, `file_extension`, `file_size`, `created_at`) VALUES
(31, 34, 'DLY-20260201-34', 'piece_identite', 'PIECE_IDENTITE_34_1770126545.pdf', '../../../../assets/uploads/files_uploads/DLY-20260201-34/', 'pdf', 305326, '2026-02-03 13:49:05'),
(32, 34, 'DLY-20260201-34', 'extrait_naissance', 'EXTRAIT_NAISSANCE_34_1770126545.png', '../../../../assets/uploads/files_uploads/DLY-20260201-34/', 'png', 2579828, '2026-02-03 13:49:05'),
(39, 39, 'DLY-20260202-39', 'piece_identite', 'PIECE_IDENTITE_39_1770201156.png', '../../../../assets/uploads/files_uploads/DLY-20260202-39/', 'png', 2758587, '2026-02-04 10:32:36'),
(40, 39, 'DLY-20260202-39', 'extrait_naissance', 'EXTRAIT_NAISSANCE_39_1770201156.jpg', '../../../../assets/uploads/files_uploads/DLY-20260202-39/', 'jpg', 62413, '2026-02-04 10:32:36'),
(41, 37, 'DLY-20260202-37', 'piece_identite', 'PIECE_IDENTITE_37_1770201307.png', '../../../../assets/uploads/files_uploads/DLY-20260202-37/', 'png', 2758587, '2026-02-04 10:35:07'),
(42, 37, 'DLY-20260202-37', 'extrait_naissance', 'EXTRAIT_NAISSANCE_37_1770201307.jpg', '../../../../assets/uploads/files_uploads/DLY-20260202-37/', 'jpg', 62413, '2026-02-04 10:35:07');

-- --------------------------------------------------------

--
-- Structure de la table `delypro_inscriptions`
--

CREATE TABLE `delypro_inscriptions` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
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
  `pdf_file` varchar(200) NOT NULL,
  `reference` varchar(200) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('en_attente','en_cours','valide','refuse') DEFAULT 'en_attente',
  `motif_refus` text DEFAULT NULL,
  `statut_updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('user','admin') NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `delypro_inscriptions`
--

INSERT INTO `delypro_inscriptions` (`id`, `username`, `password`, `nom`, `prenom`, `date_naissance`, `type_date_naissance`, `nin`, `adresse`, `telephone`, `email`, `situation_matrimoniale`, `confirmation_exactitude`, `confirmation_cgu`, `pdf_file`, `reference`, `ip_address`, `user_agent`, `created_at`, `statut`, `motif_refus`, `statut_updated_at`, `role`, `is_archived`) VALUES
(34, 'USR-20260201-D6CA', '541699d3', 'omri', 'wissem', '2026-02-27', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, '', 'DLY-20260201-34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 10:42:10', 'valide', NULL, '2026-02-03 14:02:46', 'user', 0),
(35, 'USR-20260201-AC3D', '2b8dc3dc', 'omri', 'wissem', '2026-02-19', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, '', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 12:33:56', 'en_attente', NULL, '2026-02-03 10:31:13', 'user', 0),
(36, 'USR-20260201-2BB4', 'ae26a609', 'omri', 'wissem', '2026-02-06', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260201-36.pdf', 'DLY-20260201-36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-01 12:49:35', 'en_attente', NULL, '2026-02-04 10:38:58', 'user', 1),
(37, 'USR-20260202-011D', '8628ac4c', 'omri', 'wissem', '2026-02-06', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260202-37.pdf', 'DLY-20260202-37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:47:43', 'en_attente', NULL, '2026-02-04 10:44:52', 'user', 0),
(38, 'USR-20260202-4658', '5c927669', 'omri', 'wissem', '2026-02-18', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260202-38.pdf', 'DLY-20260202-38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:48:39', 'en_attente', NULL, '2026-02-04 10:39:18', 'user', 0),
(39, 'USR-20260202-0D3A', 'ac2b41ce', 'omri', 'wissem', '2026-02-05', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260202-39.pdf', 'DLY-20260202-39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:49:25', 'en_attente', NULL, '2026-02-04 10:37:25', 'user', 0),
(40, 'USR-20260202-3916', '4598c2ee', 'omri', 'wissem', '2026-01-31', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260202-40.pdf', 'DLY-20260202-40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:50:10', 'en_cours', NULL, '2026-02-04 10:35:46', 'user', 0),
(41, 'USR-20260202-CDD6', '55ed908b', 'omri', 'wissem', '2026-02-13', 'N', '7474747474', 'alger ouled fayet', '4775782587', 'test@ghmd.df', 'Célibataire', 1, 1, 'DLY-20260202-41.pdf', 'DLY-20260202-41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 14:50:52', 'en_cours', NULL, '2026-02-03 15:32:32', 'user', 0),
(43, 'admin', 'admin', '', '', '0000-00-00', 'N', '', '', '', NULL, '', 1, 1, '', '', NULL, NULL, '2026-02-03 13:43:33', 'en_attente', NULL, '2026-02-04 09:56:39', 'admin', 0);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) NOT NULL,
  `inscription_id` int(10) NOT NULL,
  `status` enum('en_attente','en_cours','valide','refuse') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `inscription_id`, `status`, `message`, `is_read`, `created_at`) VALUES
(11, 41, 'en_cours', 'Votre inscription est en cours de traitement.', 0, '2026-02-03 15:32:32');

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
(16, 'Alger'),
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
-- Index pour la table `choix_site`
--
ALTER TABLE `choix_site`
  ADD PRIMARY KEY (`id_site`),
  ADD KEY `id_inscription` (`id_inscription`);

--
-- Index pour la table `delypro_documents`
--
ALTER TABLE `delypro_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inscription` (`inscription_id`),
  ADD KEY `idx_reference` (`reference`),
  ADD KEY `idx_doc_type` (`document_type`);

--
-- Index pour la table `delypro_inscriptions`
--
ALTER TABLE `delypro_inscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscription_id` (`inscription_id`);

--
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `choix_site`
--
ALTER TABLE `choix_site`
  MODIFY `id_site` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `delypro_documents`
--
ALTER TABLE `delypro_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `delypro_inscriptions`
--
ALTER TABLE `delypro_inscriptions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `choix_site`
--
ALTER TABLE `choix_site`
  ADD CONSTRAINT `choix_site_ibfk_1` FOREIGN KEY (`id_inscription`) REFERENCES `delypro_inscriptions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `delypro_documents`
--
ALTER TABLE `delypro_documents`
  ADD CONSTRAINT `fk_documents_inscription` FOREIGN KEY (`inscription_id`) REFERENCES `delypro_inscriptions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`inscription_id`) REFERENCES `delypro_inscriptions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
