-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 11 Janvier 2015 à 12:56
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `covoiturage`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `id_adherent` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `date_naissance` date NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id_adherent`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `adherent`
--

INSERT INTO `adherent` (`id_adherent`, `nom`, `prenom`, `sexe`, `telephone`, `date_naissance`, `mail`, `password`, `photo`) VALUES
(1, 'Boulongne', 'Thomas', '1', '0160103788', '2014-12-03', 'thomasboulongne@hotmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'adherent/default.png'),
(3, 'Chakrina', 'Mouhouni', '1', '0102030406', '2013-06-21', 'mou@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adherent/default.png'),
(8, 'De Montargis', 'Quentin', '1', '0160103788', '1992-06-02', 'tom@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adherent/quentin_demontargis_8.jpg'),
(15, 'Pays-Bas', 'François', '0', '0504030201', '1992-06-06', 'fh@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adherent/francois_pays-bas_15.PNG');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_adherent` int(11) NOT NULL,
  PRIMARY KEY (`id_adherent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique`
--

DROP TABLE IF EXISTS `caracteristique`;
CREATE TABLE IF NOT EXISTS `caracteristique` (
  `id_caracteristique` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_caracteristique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `carburant`
--

DROP TABLE IF EXISTS `carburant`;
CREATE TABLE IF NOT EXISTS `carburant` (
  `id_carburant` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`id_carburant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `carburant`
--

INSERT INTO `carburant` (`id_carburant`, `libelle`) VALUES
(1, 'Essence'),
(2, 'Diesel'),
(3, 'GPL'),
(4, 'Électrique'),
(5, 'Hybride');

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

DROP TABLE IF EXISTS `conducteur`;
CREATE TABLE IF NOT EXISTS `conducteur` (
  `num_permis` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL,
  PRIMARY KEY (`num_permis`,`id_adherent`),
  UNIQUE KEY `Id_Adherent_Conducteur` (`id_adherent`),
  UNIQUE KEY `num_permis` (`num_permis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conducteur`
--

INSERT INTO `conducteur` (`num_permis`, `id_adherent`) VALUES
(12345, 1),
(856, 15);

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `id_equipements` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_equipements`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

DROP TABLE IF EXISTS `etapes`;
CREATE TABLE IF NOT EXISTS `etapes` (
  `id_etapes` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `lieu` varchar(30) NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id_etapes`),
  KEY `FK_etapes_trajet` (`id_trajet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_msg` int(11) NOT NULL AUTO_INCREMENT,
  `id_adherent_from` int(11) NOT NULL,
  `id_adherent_to` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `sujet` varchar(50) NOT NULL,
  `message` varchar(2000) NOT NULL,
  PRIMARY KEY (`id_msg`),
  KEY `id_adherent_from` (`id_adherent_from`),
  KEY `id_adherent_to` (`id_adherent_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id_msg`, `id_adherent_from`, `id_adherent_to`, `date`, `sujet`, `message`) VALUES
(2, 1, 3, '2015-01-07 00:00:00', 'Sujet2', 'Msg'),
(4, 1, 3, '2015-01-08 00:00:00', 'Sujet du message', 'jet'),
(5, 3, 1, '2015-01-08 00:00:00', 'suj', 'et'),
(6, 1, 1, '2015-01-08 12:43:00', 'Sujet', 'J''ai envie de voyager'),
(7, 1, 1, '2015-01-08 17:12:00', 'Auxerre_Dijon_2015-01-02 00:00:00', 'Comment est votre blanquette?'),
(8, 1, 1, '2015-01-08 17:13:00', 'Auxerre_Dijon_2015-01-02 00:00:00', 'La blanquette est bonne'),
(9, 8, 1, '2015-01-10 17:38:00', 'Dijon_Palaiseau_2015-01-09 12:00:00', 'Est-ce que vous êtes gentils ?'),
(10, 1, 8, '2015-01-10 17:40:00', 'Dijon_Palaiseau_2015-01-09 12:00:00', 'Ça dépend, salope'),
(11, 8, 1, '2015-01-10 17:46:00', 'Dijon > Palaiseau, le 2015-01-09 12:00:00', 'Merci fdp'),
(12, 1, 8, '2015-01-10 17:49:00', 'Dijon > Palaiseau, le 2015-01-09 12:00:00', 'Sois poli ducon'),
(13, 1, 8, '2015-01-10 17:55:00', 'Dijon > Palaiseau, le 2015-01-09 12:00:00', 'Eh salut'),
(14, 8, 1, '2015-01-10 17:59:00', 'Dijon > Palaiseau, le 09-01-15 à 12:01', 'Ça a l''air bien le covoiturage');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_adherent_from` int(11) NOT NULL,
  `id_adherent_to` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id_adherent_from`,`id_adherent_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `id_adherent` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `nb_invites` int(11) NOT NULL,
  `frais` int(11) NOT NULL,
  PRIMARY KEY (`id_adherent`,`id_trajet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `participe`
--

INSERT INTO `participe` (`id_adherent`, `id_trajet`, `nb_invites`, `frais`) VALUES
(15, 19, 1, 36);

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
  `id_trajet` int(11) NOT NULL AUTO_INCREMENT,
  `id_adherent` int(11) NOT NULL,
  `num_permis` int(11) NOT NULL,
  `date_traj` datetime NOT NULL,
  `nb_passagers_max` int(11) NOT NULL,
  `lieu_depart` varchar(30) NOT NULL,
  `lieu_arrivee` varchar(30) NOT NULL,
  `commentaire` varchar(1000) DEFAULT NULL,
  `id_vehicule` int(11) NOT NULL,
  PRIMARY KEY (`id_trajet`),
  KEY `id_adherent` (`id_adherent`),
  KEY `id_vehicule` (`id_vehicule`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `id_adherent`, `num_permis`, `date_traj`, `nb_passagers_max`, `lieu_depart`, `lieu_arrivee`, `commentaire`, `id_vehicule`) VALUES
(2, 1, 7, '2014-12-16 00:00:00', 3, 'Dijon', 'Paris', '', 1),
(3, 1, 0, '2015-01-02 00:00:00', 3, 'Auxerre', 'Dijon', NULL, 2),
(8, 1, 0, '2015-01-02 00:00:00', 3, 'Strasbourg', 'Dijon', NULL, 1),
(19, 1, 0, '2015-01-09 12:00:00', 3, 'Dijon', 'Palaiseau', 'Jeeezus', 2);

-- --------------------------------------------------------

--
-- Structure de la table `trajet_caracteristique`
--

DROP TABLE IF EXISTS `trajet_caracteristique`;
CREATE TABLE IF NOT EXISTS `trajet_caracteristique` (
  `id_trajet` int(11) NOT NULL,
  `id_caracteristique` int(11) NOT NULL,
  PRIMARY KEY (`id_trajet`,`id_caracteristique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id_type`, `libelle`) VALUES
(1, 'Moyenne berline'),
(2, 'Citadine'),
(3, 'Grande berline'),
(4, 'Break'),
(5, 'Monospace'),
(6, '4x4, SUV'),
(7, 'Coupé'),
(8, 'Cabriolet'),
(9, 'Utilitaire'),
(10, 'Moto');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id_vehicule` int(11) NOT NULL AUTO_INCREMENT,
  `id_adherent` int(11) NOT NULL,
  `num_permis` int(11) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `type` int(50) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `carburant` int(10) NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  PRIMARY KEY (`id_vehicule`),
  KEY `index` (`id_adherent`),
  KEY `id_adherent` (`id_adherent`),
  KEY `Num_Permis` (`num_permis`),
  KEY `carburant` (`carburant`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `id_adherent`, `num_permis`, `marque`, `modele`, `type`, `couleur`, `photo`, `carburant`, `immatriculation`) VALUES
(1, 1, 12345, 'Renault', 'Megane', 1, '#000000', '', 1, '66-55-22'),
(2, 1, 12345, 'Renault', 'Twingo', 2, '#fe98ca', '', 4, '8892245'),
(3, 15, 856, 'Mercedes', 'Classe A', 2, '#666666', '', 1, '123456789'),
(4, 15, 856, 'Suzuki', 'GSX R', 10, '#010066', '', 1, '987654');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule_equipements`
--

DROP TABLE IF EXISTS `vehicule_equipements`;
CREATE TABLE IF NOT EXISTS `vehicule_equipements` (
  `id_vehicule` int(11) NOT NULL,
  `id_equipements` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id_vehicule`,`id_equipements`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `FK_ADHERENT_ADMIN` FOREIGN KEY (`id_adherent`) REFERENCES `adherent` (`id_adherent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD CONSTRAINT `FK_ADHERENT_CONDUCTEUR` FOREIGN KEY (`id_adherent`) REFERENCES `adherent` (`id_adherent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etapes`
--
ALTER TABLE `etapes`
  ADD CONSTRAINT `FK_TRAJET_ETAPES` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id_trajet`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_adherent_from`) REFERENCES `adherent` (`id_adherent`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_adherent_to`) REFERENCES `adherent` (`id_adherent`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `trajet_ibfk_2` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id_vehicule`),
  ADD CONSTRAINT `cle_conducteur` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`id_adherent`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`id_adherent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `vehicule_ibfk_1` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`id_adherent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicule_ibfk_2` FOREIGN KEY (`num_permis`) REFERENCES `conducteur` (`num_permis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicule_ibfk_3` FOREIGN KEY (`carburant`) REFERENCES `carburant` (`id_carburant`),
  ADD CONSTRAINT `vehicule_ibfk_4` FOREIGN KEY (`type`) REFERENCES `type` (`id_type`);
SET FOREIGN_KEY_CHECKS=1;
