SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `covoiturage`
--
CREATE DATABASE IF NOT EXISTS `covoiturage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `covoiturage`;

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `Id_Adherent` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Sexe` varchar(1) NOT NULL,
  `Telephone` varchar(10) NOT NULL,
  `Date_Naissance` date NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_Adherent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Vider la table avant d'insérer `adherent`
--

TRUNCATE TABLE `adherent`;
--
-- Contenu de la table `adherent`
--

INSERT INTO covoiturage_`adherent` (`Id_Adherent`, `Nom`, `Prenom`, `Sexe`, `Telephone`, `Date_Naissance`, `Mail`, `Password`) VALUES
(1, 'Boulongne', 'Thomas', '1', '0160103788', '2014-12-03', 'thomasboulongne@hotmail.com', '1234'),
(2, 'Chapka', 'Thomas', '1', '0102030405', '2014-12-16', 'thomas@mail.fr', '1234'),
(3, 'Chakrina', 'Mouhouni', '1', '0102030405', '2013-06-21', 'mou@mail.com', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `Id_Adherent` int(11) NOT NULL,
  PRIMARY KEY (`Id_Adherent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `administrateur`
--

TRUNCATE TABLE `administrateur`;
-- --------------------------------------------------------

--
-- Structure de la table `caracteristique`
--

DROP TABLE IF EXISTS `caracteristique`;
CREATE TABLE IF NOT EXISTS `caracteristique` (
  `Id_Caracteristique` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Caracteristique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `caracteristique`
--

TRUNCATE TABLE `caracteristique`;
-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

DROP TABLE IF EXISTS `conducteur`;
CREATE TABLE IF NOT EXISTS `conducteur` (
  `Num_Permis` int(11) NOT NULL,
  `Id_Adherent_Conducteur` int(11) NOT NULL,
  PRIMARY KEY (`Num_Permis`,`Id_Adherent_Conducteur`),
  UNIQUE KEY `Id_Adherent_Conducteur` (`Id_Adherent_Conducteur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `conducteur`
--

TRUNCATE TABLE `conducteur`;
--
-- Contenu de la table `conducteur`
--

INSERT INTO covoiturage_`conducteur` (`Num_Permis`, `Id_Adherent_Conducteur`) VALUES
(12345, 1);

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
  `Id_Equipements` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Equipements`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vider la table avant d'insérer `equipements`
--

TRUNCATE TABLE `equipements`;
-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

DROP TABLE IF EXISTS `etapes`;
CREATE TABLE IF NOT EXISTS `etapes` (
  `Id_Etapes` int(11) NOT NULL,
  `Id_Trajet` int(11) NOT NULL,
  `Lieu` varchar(30) NOT NULL,
  `Ordre` int(11) NOT NULL,
  PRIMARY KEY (`Id_Etapes`),
  KEY `FK_etapes_trajet` (`Id_Trajet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `etapes`
--

TRUNCATE TABLE `etapes`;
-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `Id_Adherent_From` int(11) NOT NULL,
  `Id_Adherent_To` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Sujet` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  PRIMARY KEY (`Id_Adherent_From`,`Id_Adherent_To`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `message`
--

TRUNCATE TABLE `message`;
-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `Id_Adherent_From` int(11) NOT NULL,
  `Id_Adherent_To` int(11) NOT NULL,
  `Date` date NOT NULL,
  `note` int(11) NOT NULL,
  `Commentaire` text NOT NULL,
  PRIMARY KEY (`Id_Adherent_From`,`Id_Adherent_To`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `note`
--

TRUNCATE TABLE `note`;
-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `Id_Adherent` int(11) NOT NULL,
  `Id_Trajet` int(11) NOT NULL,
  `Nb_Invites` int(11) NOT NULL,
  `Frais` int(11) NOT NULL,
  PRIMARY KEY (`Id_Adherent`,`Id_Trajet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `participe`
--

TRUNCATE TABLE `participe`;
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
  PRIMARY KEY (`id_trajet`),
  KEY `Id_Adherent` (`id_adherent`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Vider la table avant d'insérer `trajet`
--

TRUNCATE TABLE `trajet`;
--
-- Contenu de la table `trajet`
--

INSERT INTO covoiturage_`trajet` (`id_trajet`, `id_adherent`, `num_permis`, `date_traj`, `nb_passagers_max`, `lieu_depart`, `lieu_arrivee`, `commentaire`) VALUES
(1, 1, 25156, '2014-12-16 00:00:00', 3, 'Dijon', 'Paris', ''),
(2, 1, 7, '2014-12-16 00:00:00', 3, 'Dijon', 'Paris', ''),
(3, 1, 0, '2015-01-02 00:00:00', 3, 'Bora Bora', 'Dijon', NULL),
(8, 1, 0, '2015-01-02 00:00:00', 3, 'Bora Bora', 'Dijon', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `trajet_caracteristique`
--

DROP TABLE IF EXISTS `trajet_caracteristique`;
CREATE TABLE IF NOT EXISTS `trajet_caracteristique` (
  `Id_Trajet` int(11) NOT NULL,
  `Id_Caracteristique` int(11) NOT NULL,
  PRIMARY KEY (`Id_Trajet`,`Id_Caracteristique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `trajet_caracteristique`
--

TRUNCATE TABLE `trajet_caracteristique`;
-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `Id_Vehicule` int(11) NOT NULL,
  `Id_Adherent` int(11) NOT NULL,
  `Num_Permis` int(11) NOT NULL,
  `Marque` varchar(50) NOT NULL,
  `Modele` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Couleur` varchar(50) NOT NULL,
  `Photo` varchar(50) NOT NULL,
  `Carburant` varchar(50) NOT NULL,
  `Immatriculation` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Vehicule`),
  KEY `index` (`Id_Adherent`),
  KEY `Id_Adherent` (`Id_Adherent`),
  KEY `Num_Permis` (`Num_Permis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `vehicule`
--

TRUNCATE TABLE `vehicule`;
-- --------------------------------------------------------

--
-- Structure de la table `vehicule_equipements`
--

DROP TABLE IF EXISTS `vehicule_equipements`;
CREATE TABLE IF NOT EXISTS `vehicule_equipements` (
  `Id_Vehicule` int(11) NOT NULL,
  `Id_Equipements` int(11) NOT NULL,
  `Commentaire` text NOT NULL,
  PRIMARY KEY (`Id_Vehicule`,`Id_Equipements`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `vehicule_equipements`
--

TRUNCATE TABLE `vehicule_equipements`;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `FK_Adherent_Adminitrateur` FOREIGN KEY (`Id_Adherent`) REFERENCES `adherent` (`Id_Adherent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD CONSTRAINT `conducteur_ibfk_1` FOREIGN KEY (`Id_Adherent_Conducteur`) REFERENCES `adherent` (`Id_Adherent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etapes`
--
ALTER TABLE `etapes`
  ADD CONSTRAINT `FK_etapes_trajet` FOREIGN KEY (`Id_Trajet`) REFERENCES `trajet` (`Id_Trajet`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `cle_conducteur` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`Id_Adherent_Conducteur`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`Id_Adherent`) REFERENCES `conducteur` (`Id_Adherent_Conducteur`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
