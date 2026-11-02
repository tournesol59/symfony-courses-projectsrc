-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 12 avr. 2026 à 23:01
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
-- Base de données : `studentsdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `city`, `zipcode`) VALUES
(1, 'Fenouillet', 31150),
(2, 'Puteaux', 92800),
(3, 'Pin Balma', 31130),
(4, 'Quint Fonsegrives', 31130),
(5, 'Pin Balma', 31130),
(6, 'Quint-Fonsegrives', 31130),
(7, 'Puteaux', 92800),
(8, 'Pin Balma', 31130),
(9, 'Quint-Fonsegrives', 31130),
(10, 'Pin Balma', 31130),
(11, 'Quint-Fonsegrives', 31130),
(12, 'Pin Balma', 31130);

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hour` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `code_naf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `title`, `hour`, `day`, `code_naf`) VALUES
(1, 'Fonctionnement Reseaux', 1, 8, 'SEC102'),
(2, 'Conception Bases de Donnees', 8, 4, 'NFP107'),
(3, 'Intergiciels en Java', 8, 2, 'NSY102');

-- --------------------------------------------------------

--
-- Structure de la table `course_block`
--

CREATE TABLE `course_block` (
  `id` int(11) NOT NULL,
  `code_rncp` varchar(255) NOT NULL,
  `code_naf` varchar(255) NOT NULL,
  `precede_naf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course_block`
--

INSERT INTO `course_block` (`id`, `code_rncp`, `code_naf`, `precede_naf`) VALUES
(1, 'CYC9101A1', 'NSY102', ''),
(2, 'CYC9101A1', 'NSY103', ''),
(3, 'CYC9101A1', 'NSY104', ''),
(4, 'CYC9101A1', 'NFP119', ''),
(5, 'CYC9101A1', 'NFP121', ''),
(6, 'CYC9101A1', 'NSY115', ''),
(7, 'CYC9101A1', 'GLG105', ''),
(8, 'CYC9101A1', 'SEC102', ''),
(9, 'CYC9101A1', 'NSY014', '');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250728210948', '2025-08-09 21:46:36', 33),
('DoctrineMigrations\\Version20250729194731', '2025-08-09 21:46:41', 9),
('DoctrineMigrations\\Version20250803145606', '2025-08-09 21:46:52', 7),
('DoctrineMigrations\\Version20250809101020', '2025-08-09 21:47:37', 37),
('DoctrineMigrations\\Version20250810151612', '2025-08-10 17:16:47', 19),
('DoctrineMigrations\\Version20250810151840', '2025-08-10 17:18:52', 36);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'general-student'),
(2, 'apprentice-student'),
(3, 'general-student'),
(4, 'general-student'),
(6, 'general-student'),
(7, 'general-student'),
(8, 'general-student'),
(9, 'general-student'),
(10, 'general-student'),
(11, 'general-student'),
(12, 'general-student');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `status_id`, `lastname`, `email`) VALUES
(1, 1, 'Peugny', 'frederic.peugny@gmail.com'),
(2, 2, 'Tisserand', 'mickaeltisserand@gmail.com'),
(3, 8, 'Archen', 'mathieuarchen@stand.edu'),
(4, 12, 'Sebbag', 'williamsebbag@gmail.com'),
(6, 6, 'Gilbert', 'wilfriedgilbert@gmail.com'),
(7, 11, 'Boustangi', 'fatmaboustangi@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `student_address`
--

CREATE TABLE `student_address` (
  `student_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_address`
--

INSERT INTO `student_address` (`student_id`, `address_id`) VALUES
(4, 12),
(6, 5),
(7, 10),
(7, 11);

-- --------------------------------------------------------

--
-- Structure de la table `student_course`
--

CREATE TABLE `student_course` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_course`
--

INSERT INTO `student_course` (`student_id`, `course_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3),
(4, 3),
(6, 1),
(7, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `course_block`
--
ALTER TABLE `course_block`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B723AF336BF700BD` (`status_id`);

--
-- Index pour la table `student_address`
--
ALTER TABLE `student_address`
  ADD PRIMARY KEY (`student_id`,`address_id`),
  ADD KEY `IDX_E078DA79CB944F1A` (`student_id`),
  ADD KEY `IDX_E078DA79F5B7AF75` (`address_id`);

--
-- Index pour la table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `IDX_98A8B739CB944F1A` (`student_id`),
  ADD KEY `IDX_98A8B739591CC992` (`course_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `course_block`
--
ALTER TABLE `course_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_B723AF336BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Contraintes pour la table `student_address`
--
ALTER TABLE `student_address`
  ADD CONSTRAINT `FK_E078DA79CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E078DA79F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `FK_98A8B739591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_98A8B739CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
