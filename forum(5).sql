-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 23 oct. 2023 à 17:10
-- Version du serveur : 10.1.29-MariaDB
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum`
--

-- --------------------------------------------------------

--
-- Structure de la table `CATEGORY`
--

CREATE TABLE `CATEGORY` (
  `idcategory` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(2000) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `CATEGORY`
--

INSERT INTO `CATEGORY` (`idcategory`, `name`, `description`) VALUES
(3, 'en vrai ah', 'voila non ?'),
(6, 'Huh ?', 'Huh ?'),
(9, 'blabla', 'que du blabla'),
(10, 'bon Ã§a marche plutot bien', 'c\'esr vraimen sympatique tout Ã§a en sah de sah de sah tah les ouf'),
(11, 'Sugar', 'Pour les fans de sucre');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `idcomment` int(11) NOT NULL,
  `text` varchar(3000) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `idticket` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `COMMENT`
--

INSERT INTO `COMMENT` (`idcomment`, `text`, `date`, `idticket`, `username`) VALUES
(5, 'ah oui c\'est vraiment bon !', '2023-10-23 16:32:26', 7, 'LeG'),
(7, 'Mais vraiment c\'est super', '2023-10-23 16:34:52', 7, 'LeG');

-- --------------------------------------------------------

--
-- Structure de la table `MENTION`
--

CREATE TABLE `MENTION` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `idticket` int(11) NOT NULL,
  `idcomment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `TICKET`
--

CREATE TABLE `TICKET` (
  `idticket` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `message` varchar(3000) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `TICKET`
--

INSERT INTO `TICKET` (`idticket`, `title`, `message`, `date`, `username`) VALUES
(5, 'alors la', 'Oui ou non ?\r\nSurement.', '2023-10-23 12:09:52', 'LeG'),
(6, 'Huh ?', 'Huh huh huh huh ?', '2023-10-23 12:10:29', 'leV'),
(7, 'Sucre', 'Le sucre c\'est bon', '2023-10-23 12:11:11', 'Sucre'),
(8, 'Destination le bonne endroit', 'La page de post ?', '2023-10-23 12:14:07', 'LeG'),
(11, 'a', 'a', '2023-10-23 15:39:44', NULL),
(12, 'Test de suppression de compte', 'Va-t\'il afficher \'compte supprimÃ©\' ?', '2023-10-23 16:42:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `TICKETCATEGORY`
--

CREATE TABLE `TICKETCATEGORY` (
  `idcategory` int(11) NOT NULL,
  `idticket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `TICKETCATEGORY`
--

INSERT INTO `TICKETCATEGORY` (`idcategory`, `idticket`) VALUES
(3, 5),
(3, 12),
(6, 6),
(10, 5),
(11, 7);

-- --------------------------------------------------------

--
-- Structure de la table `USER`
--

CREATE TABLE `USER` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `mail` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `frontname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `firstconnection` datetime DEFAULT NULL,
  `lastconnection` datetime DEFAULT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `deactivated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `USER`
--

INSERT INTO `USER` (`username`, `mail`, `password`, `frontname`, `firstconnection`, `lastconnection`, `administrator`, `deactivated`) VALUES
('LeG', 'adresse@exemple.com', 'Test000*', 'Guigstyle', '2023-10-17 11:58:34', '2023-10-23 16:42:56', 1, 0),
('Sucre', 'sucre@sucre.sucre', 'Lesucre*3', 'hmm le sucre', '2023-10-19 11:00:27', '2023-10-23 12:12:00', 0, 0),
('leV', 'huh@huh.huh', 'Huh0000*', 'huh', '2023-10-19 09:56:46', '2023-10-23 12:10:07', 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  ADD PRIMARY KEY (`idcategory`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD PRIMARY KEY (`idcomment`),
  ADD KEY `COMMENT_ibfk_1` (`idticket`),
  ADD KEY `COMMENT_ibfk_2` (`username`);

--
-- Index pour la table `MENTION`
--
ALTER TABLE `MENTION`
  ADD PRIMARY KEY (`username`,`idticket`,`idcomment`),
  ADD KEY `MENTION_ibfk_4` (`idticket`),
  ADD KEY `MENTION_ibfk_5` (`idcomment`);

--
-- Index pour la table `TICKET`
--
ALTER TABLE `TICKET`
  ADD PRIMARY KEY (`idticket`),
  ADD KEY `TICKET_ibfk_1` (`username`);

--
-- Index pour la table `TICKETCATEGORY`
--
ALTER TABLE `TICKETCATEGORY`
  ADD PRIMARY KEY (`idcategory`,`idticket`),
  ADD KEY `TICKETCATEGORY_ibfk_2` (`idticket`);

--
-- Index pour la table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `TICKET`
--
ALTER TABLE `TICKET`
  MODIFY `idticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  ADD CONSTRAINT `COMMENT_ibfk_1` FOREIGN KEY (`idticket`) REFERENCES `TICKET` (`idticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `COMMENT_ibfk_2` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `MENTION`
--
ALTER TABLE `MENTION`
  ADD CONSTRAINT `MENTION_ibfk_1` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MENTION_ibfk_4` FOREIGN KEY (`idticket`) REFERENCES `TICKET` (`idticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MENTION_ibfk_5` FOREIGN KEY (`idcomment`) REFERENCES `COMMENT` (`idcomment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TICKET`
--
ALTER TABLE `TICKET`
  ADD CONSTRAINT `TICKET_ibfk_1` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `TICKETCATEGORY`
--
ALTER TABLE `TICKETCATEGORY`
  ADD CONSTRAINT `TICKETCATEGORY_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `CATEGORY` (`idcategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TICKETCATEGORY_ibfk_2` FOREIGN KEY (`idticket`) REFERENCES `TICKET` (`idticket`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
