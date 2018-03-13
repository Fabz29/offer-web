-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 27 jan. 2018 à 16:58
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `securalliance`
--

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) DEFAULT NULL,
  `offer_logo_id` int(11) DEFAULT NULL,
  `offer_background_id` int(11) DEFAULT NULL,
  `thematic_thumbnail_id` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6A2CA10CDD5AFB87` (`slide_id`),
  UNIQUE KEY `UNIQ_6A2CA10C5887D243` (`offer_logo_id`),
  UNIQUE KEY `UNIQ_6A2CA10C95693AE1` (`offer_background_id`),
  UNIQUE KEY `UNIQ_6A2CA10C1BBD1C73` (`thematic_thumbnail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `slide_id`, `offer_logo_id`, `offer_background_id`, `thematic_thumbnail_id`, `path`, `alt`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, NULL, NULL, '5a63a1a6bc309.png', '5a2aa13b9bc3e.png', 1, '2018-01-20 20:08:07', '2018-01-20 20:08:07'),
(2, NULL, NULL, 1, NULL, '5a63a1a724299.jpeg', 'securalliance-fond4.jpg', 1, '2018-01-20 20:08:07', '2018-01-20 20:08:07'),
(3, NULL, NULL, NULL, 3, '5a63a1f19ee88.jpeg', 'controle-acces-entreprise2.jpg', 1, '2018-01-20 20:09:21', '2018-01-20 20:09:21'),
(4, NULL, NULL, NULL, 2, '5a63a1fe838bf.jpeg', 'accueil-entreprise.jpg', 1, '2018-01-20 20:09:34', '2018-01-20 20:09:34'),
(5, NULL, NULL, NULL, 1, '5a63a20c19c13.jpeg', 'surveillance-humaine-1.jpg', 1, '2018-01-20 20:09:48', '2018-01-20 20:09:48'),
(6, NULL, NULL, NULL, 4, '5a63a21c50d0c.jpeg', 'securalliance-fond4.jpg', 1, '2018-01-20 20:10:04', '2018-01-20 20:10:04'),
(9, NULL, 5, NULL, NULL, '5a6c991a082f9.png', 'bandeau-charal.png', 1, '2018-01-27 15:22:02', '2018-01-27 15:22:02'),
(10, NULL, NULL, 5, NULL, '5a6c991a08fc1.jpeg', 'securalliance-fond4.jpg', 1, '2018-01-27 15:22:02', '2018-01-27 15:22:02');

-- --------------------------------------------------------

--
-- Structure de la table `offer`
--

DROP TABLE IF EXISTS `offer`;
CREATE TABLE IF NOT EXISTS `offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_29D6873E989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_29D6873EA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `offer`
--

INSERT INTO `offer` (`id`, `user_id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mercedes', 'mercedes', '2018-01-05 15:36:02', '2018-01-05 15:36:02'),
(5, 4, 'test 2', 'test-2', '2018-01-27 15:22:01', '2018-01-27 15:22:01');

-- --------------------------------------------------------

--
-- Structure de la table `slide`
--

DROP TABLE IF EXISTS `slide`;
CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thematic_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_72EFEE62989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_72EFEE62EA9FDD75` (`media_id`),
  KEY `IDX_72EFEE622395FCED` (`thematic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thematic`
--

DROP TABLE IF EXISTS `thematic`;
CREATE TABLE IF NOT EXISTS `thematic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_shared` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7C1CDF72989D9B62` (`slug`),
  KEY `IDX_7C1CDF7253C674EE` (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `thematic`
--

INSERT INTO `thematic` (`id`, `offer_id`, `name`, `title`, `is_shared`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'Agent', 0, 'test', '2018-01-05 15:37:35', '2018-01-05 15:37:35'),
(2, 1, 'Environnement', 'Environnement', 1, 'environnement', '2018-01-05 15:40:01', '2018-01-05 15:40:01'),
(3, 1, 'Numérique', 'Numérique', 0, 'numerique', '2018-01-05 15:42:54', '2018-01-05 15:42:54'),
(4, 1, 'test', 'test', 0, 'test-1', '2018-01-20 20:10:04', '2018-01-20 20:10:04'),
(6, 5, 'Environnement', 'Environnement', 1, 'environnement-1', '2018-01-05 15:40:01', '2018-01-05 15:40:01');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `lastName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `accessStartAt` datetime NOT NULL,
  `accessEndAt` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`),
  UNIQUE KEY `UNIQ_8D93D64953C674EE` (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `lastName`, `firstName`, `companyName`, `birthday`, `accessStartAt`, `accessEndAt`, `created_at`, `updated_at`, `offer_id`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 1, NULL, '$2y$13$HKZdnlGxEiiC0Cw2ippgVueZeop8JHGI8mkUnEudAiG1bUc8K.MLu', '2018-01-27 13:49:08', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', NULL, NULL, NULL, NULL, '2018-02-02 09:48:53', '2018-02-02 09:48:53', '2018-01-02 09:48:54', '2018-01-27 13:49:08', NULL),
(2, 'test@mail.com', 'test@mail.com', 'test@mail.com', 'test@mail.com', 1, NULL, 'password', NULL, NULL, NULL, 'a:0:{}', 'Dupond', 'Jean', NULL, NULL, '2018-01-05 00:00:00', '2018-02-05 00:00:00', '2018-01-05 15:31:22', '2018-01-05 15:31:22', 1),
(4, 'test2@mail.com', 'test2@mail.com', 'test2@mail.com', 'test2@mail.com', 0, NULL, '$2y$13$UItkpl8I4cggVUDZPJZtdeN5BuwbWPeg6mZjfl22dsGw0cEnvnR0W', NULL, NULL, NULL, 'a:0:{}', 'Dupon', 'Marc', NULL, NULL, '2018-01-27 00:00:00', '2018-02-27 00:00:00', '2018-01-27 14:35:04', '2018-01-27 15:22:02', 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C1BBD1C73` FOREIGN KEY (`thematic_thumbnail_id`) REFERENCES `thematic` (`id`),
  ADD CONSTRAINT `FK_6A2CA10C5887D243` FOREIGN KEY (`offer_logo_id`) REFERENCES `offer` (`id`),
  ADD CONSTRAINT `FK_6A2CA10C95693AE1` FOREIGN KEY (`offer_background_id`) REFERENCES `offer` (`id`),
  ADD CONSTRAINT `FK_6A2CA10CDD5AFB87` FOREIGN KEY (`slide_id`) REFERENCES `slide` (`id`);

--
-- Contraintes pour la table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `FK_29D6873EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `slide`
--
ALTER TABLE `slide`
  ADD CONSTRAINT `FK_72EFEE622395FCED` FOREIGN KEY (`thematic_id`) REFERENCES `thematic` (`id`),
  ADD CONSTRAINT `FK_72EFEE62EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`);

--
-- Contraintes pour la table `thematic`
--
ALTER TABLE `thematic`
  ADD CONSTRAINT `FK_7C1CDF7253C674EE` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64953C674EE` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
