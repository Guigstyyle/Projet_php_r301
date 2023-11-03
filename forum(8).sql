-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 03 nov. 2023 à 17:02
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
(9, 'blabla', 'que du blabla et du blabla'),
(10, 'bon Ã§a marche plutot bien askip', 'c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs c\'esr vraimeny sympatique tout Ã§a en sah de sah de sah tah les oufs'),
(11, 'Sugar', 'Pour les fans de sucre'),
(15, 'la redirect mod', 'Sample text 2'),
(16, 'mention', 'On va voir si Ã§a marche');

-- --------------------------------------------------------

--
-- Structure de la table `COMMENT`
--

CREATE TABLE `COMMENT` (
  `idcomment` int(11) NOT NULL,
  `text` varchar(3000) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `idticket` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `important` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `COMMENT`
--

INSERT INTO `COMMENT` (`idcomment`, `text`, `date`, `idticket`, `username`, `important`) VALUES
(8, 'et la c\'est super bon vraiment excellent oui', '2023-10-24 10:36:22', 7, 'LeBigG', 0),
(17, 'HUH?', '2023-10-25 10:45:28', 6, 'leV', 0),
(19, 'je commente', '2023-10-25 14:59:13', 12, 'LeBigG', 0),
(20, 'je commente et je modifie et je reteste', '2023-10-25 15:01:30', 15, 'LeBigG', 0),
(21, 'J\'ai mis un h minuscule pour tester la casse dans la recherche', '2023-10-26 14:49:15', 15, 'LeBigG', 0),
(23, 'je comment ce billet super intÃ©ressant pour voir si je peux le modifier plus tard', '2023-10-26 15:30:08', 16, 'LeBanni', 0),
(30, 'Ã§a mentionne ici', '2023-10-27 15:09:48', 25, 'LeBigG', 0),
(31, 'le css', '2023-10-31 17:06:42', 25, 'LeBigG', 0),
(33, 'et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? et la Ã§a dÃ©passe ? ', '2023-11-02 14:48:02', 25, 'LeBigG', 0),
(34, 'commentaire', '2023-11-03 10:00:31', 5, 'LeBigG', 0),
(35, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2023-11-03 10:05:51', 5, 'LeBigG', 0),
(39, 'Avec un commentaire important', '2023-11-03 16:25:06', 26, 'LeBigG', 1),
(40, 'et un pas important', '2023-11-03 16:26:21', 26, 'LeBigG', 0),
(44, 'et un pas important mais qui est important', '2023-11-03 16:49:22', 26, 'LeBigG', 1),
(45, 'a', '2023-11-03 16:58:01', 26, 'leHasheur', 0);

-- --------------------------------------------------------

--
-- Structure de la table `MENTIONCOMMENT`
--

CREATE TABLE `MENTIONCOMMENT` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `idcomment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `MENTIONCOMMENT`
--

INSERT INTO `MENTIONCOMMENT` (`username`, `idcomment`) VALUES
('LeBigG', 31),
('leV', 31),
('LeBigG', 21),
('leHasheur', 21),
('leV', 21),
('leV', 33),
('LeBanni', 34);

-- --------------------------------------------------------

--
-- Structure de la table `MENTIONTICKET`
--

CREATE TABLE `MENTIONTICKET` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `idticket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `MENTIONTICKET`
--

INSERT INTO `MENTIONTICKET` (`username`, `idticket`) VALUES
('LeBigG', 29),
('LeBigG', 30),
('leHasheur', 25),
('leHasheur', 29),
('leHasheur', 30),
('leV', 25),
('leV', 29),
('leV', 30);

-- --------------------------------------------------------

--
-- Structure de la table `TICKET`
--

CREATE TABLE `TICKET` (
  `idticket` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `message` varchar(3000) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `username` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `important` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `TICKET`
--

INSERT INTO `TICKET` (`idticket`, `title`, `message`, `date`, `username`, `important`) VALUES
(5, 'alors la', 'Oui ou non ?\r\nSurement.', '2023-10-23 12:09:52', 'LeBigG', 0),
(6, 'Huh ?', 'Huh huh huh huh ?', '2023-10-23 12:10:29', 'leV', 0),
(7, 'Sucre', 'Le sucre c\'est bon', '2023-10-23 12:11:11', 'Sucre', 0),
(8, 'Destination le bonne endroit', 'La page de post ?', '2023-10-23 12:14:07', 'LeBigG', 0),
(12, 'Test de suppression de compte', 'Va-t\'il afficher \'compte supprimÃ©\' ?', '2023-10-23 16:42:42', NULL, 0),
(14, 'Post avec un message tres long', 'Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. Ceci est un message trÃ¨s long. ', '2023-10-24 16:11:29', 'LeBigG', 0),
(15, 'Les catÃ©gorie sont sympa', 'petit message pour pas laisser Ã§a vide et tester', '2023-10-25 11:57:24', 'LeBigG', 0),
(16, 'Je vais Ãªtre ban', 'Pour de bon', '2023-10-26 15:29:29', 'LeBanni', 0),
(25, 'alors les mentions?', 'la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e la largeur est limitÃ©e ', '2023-10-27 13:50:39', 'LeBigG', 0),
(26, 'Billet important', 'C\'est trÃ¨s important oui', '2023-11-03 14:31:19', 'LeBigG', 1),
(29, 'Hash', 'pour couper du bois', '2023-11-03 14:54:14', 'leHasheur', 0),
(30, 'Un autre billet importnant', 'pour vÃ©rifier que la liste de billets important fonctionne correctement', '2023-11-03 16:07:37', 'LeBigG', 1);

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
(3, 15),
(3, 16),
(3, 29),
(6, 6),
(6, 15),
(6, 16),
(6, 29),
(9, 15),
(9, 16),
(9, 25),
(9, 26),
(9, 30),
(10, 5),
(10, 15),
(11, 7),
(11, 15),
(15, 15),
(16, 25),
(16, 26),
(16, 29);

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
('LeBanni', 'b@b.b', '$2y$10$luU10UH0GV8ULPOXFlvIKuLIeuBY58jBoxOYTm62i9N75e32xj7yG', 'LeBanDef', '2023-10-26 15:22:51', '2023-11-03 14:52:52', 0, 1),
('LeBigG', 'adresse@exemple.com', '$2y$10$suZGlFIa1ZmK3b/VR4kvFO4XvHdqWVeiLYWtu24LFwniSPxByG2e2', 'Guigstyle', '2023-10-17 11:58:34', '2023-11-03 17:01:04', 1, 0),
('Sucre', 'sucre@sucre.sucre', '$2y$10$oTeYgP0C7TyoDsJOx.VbTuSMkLwACxmTeJ8QnEm2XweAIbjG5BAFa', 'hmm le sucre', '2023-10-19 11:00:27', '2023-10-23 12:12:00', 0, 0),
('leHasheur', 'dev@localhost.localdomain', '$2y$10$xDj7emsm74fcfpljGoBj4uDaXr1FCQHroVi.JoL86/skB8apGv6Ue', 'HashMan', '2023-10-26 19:03:01', '2023-11-03 16:57:30', 0, 0),
('leV', 'huh@localhost.net', '$2y$10$o6Rfa9/naGi.pgzS2aUUI.MOQs2oWd2TSYXr2EdMT2GRAejJgMJHC', 'huh', '2023-10-19 09:56:46', '2023-10-26 20:43:09', 0, 0);

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
-- Index pour la table `MENTIONCOMMENT`
--
ALTER TABLE `MENTIONCOMMENT`
  ADD KEY `username` (`username`),
  ADD KEY `idcomment` (`idcomment`);

--
-- Index pour la table `MENTIONTICKET`
--
ALTER TABLE `MENTIONTICKET`
  ADD PRIMARY KEY (`username`,`idticket`),
  ADD KEY `MENTION_ibfk_4` (`idticket`);

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
  MODIFY `idcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `COMMENT`
--
ALTER TABLE `COMMENT`
  MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `TICKET`
--
ALTER TABLE `TICKET`
  MODIFY `idticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Contraintes pour la table `MENTIONCOMMENT`
--
ALTER TABLE `MENTIONCOMMENT`
  ADD CONSTRAINT `MENTIONCOMMENT_ibfk_1` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MENTIONCOMMENT_ibfk_2` FOREIGN KEY (`idcomment`) REFERENCES `COMMENT` (`idcomment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MENTIONTICKET`
--
ALTER TABLE `MENTIONTICKET`
  ADD CONSTRAINT `MENTIONTICKET_ibfk_1` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MENTIONTICKET_ibfk_2` FOREIGN KEY (`idticket`) REFERENCES `TICKET` (`idticket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TICKET`
--
ALTER TABLE `TICKET`
  ADD CONSTRAINT `TICKET_ibfk_1` FOREIGN KEY (`username`) REFERENCES `USER` (`username`) ON DELETE SET NULL ON UPDATE CASCADE;

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
