-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 21 Novembre 2014 à 20:44
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `covoiturage`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE IF NOT EXISTS `adherent` (
`Id_Adherent` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Sexe` varchar(1) NOT NULL,
  `Telephone` int(10) NOT NULL,
  `Date_Naissance` date NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE IF NOT EXISTS `administrateur` (
  `Id_Adherent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique`
--

CREATE TABLE IF NOT EXISTS `caracteristique` (
`Id_Caracteristique` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

CREATE TABLE IF NOT EXISTS `conducteur` (
  `Num_Permis` int(11) NOT NULL,
  `Id_Adherent_Conducteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

CREATE TABLE IF NOT EXISTS `equipements` (
`Id_Equipements` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

CREATE TABLE IF NOT EXISTS `etapes` (
  `Id_Etapes` int(11) NOT NULL,
  `Id_Trajet` int(11) NOT NULL,
  `Lieu` varchar(30) NOT NULL,
  `Ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `Id_Adherent_From` int(11) NOT NULL,
  `Id_Adherent_To` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Sujet` varchar(50) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `Id_Adherent_From` int(11) NOT NULL,
  `Id_Adherent_To` int(11) NOT NULL,
  `Date` date NOT NULL,
  `note` int(11) NOT NULL,
  `Commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

CREATE TABLE IF NOT EXISTS `participe` (
  `Id_Adherent` int(11) NOT NULL,
  `Id_Trajet` int(11) NOT NULL,
  `Nb_Invites` int(11) NOT NULL,
  `Frais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE IF NOT EXISTS `trajet` (
`Id_Trajet` int(11) NOT NULL,
  `Id_Adherent` int(11) NOT NULL,
  `Num_Permis` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Nb_Passagers_Max` int(11) NOT NULL,
  `Lieu_Depart` varchar(30) NOT NULL,
  `Lieu_arrivee` varchar(30) NOT NULL,
  `Commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `trajet_caracteristique`
--

CREATE TABLE IF NOT EXISTS `trajet_caracteristique` (
  `Id_Trajet` int(11) NOT NULL,
  `Id_Caracteristique` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

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
  `Immatriculation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule_equipements`
--

CREATE TABLE IF NOT EXISTS `vehicule_equipements` (
  `Id_Vehicule` int(11) NOT NULL,
  `Id_Equipements` int(11) NOT NULL,
  `Commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
 ADD PRIMARY KEY (`Id_Adherent`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
 ADD PRIMARY KEY (`Id_Adherent`);

--
-- Index pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
 ADD PRIMARY KEY (`Id_Caracteristique`);

--
-- Index pour la table `conducteur`
--
ALTER TABLE `conducteur`
 ADD PRIMARY KEY (`Num_Permis`,`Id_Adherent_Conducteur`);

--
-- Index pour la table `equipements`
--
ALTER TABLE `equipements`
 ADD PRIMARY KEY (`Id_Equipements`);

--
-- Index pour la table `etapes`
--
ALTER TABLE `etapes`
 ADD PRIMARY KEY (`Id_Etapes`), ADD KEY `FK_etapes_trajet` (`Id_Trajet`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`Id_Adherent_From`,`Id_Adherent_To`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
 ADD PRIMARY KEY (`Id_Adherent_From`,`Id_Adherent_To`);

--
-- Index pour la table `participe`
--
ALTER TABLE `participe`
 ADD PRIMARY KEY (`Id_Adherent`,`Id_Trajet`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
 ADD PRIMARY KEY (`Id_Trajet`);

--
-- Index pour la table `trajet_caracteristique`
--
ALTER TABLE `trajet_caracteristique`
 ADD PRIMARY KEY (`Id_Trajet`,`Id_Caracteristique`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
 ADD PRIMARY KEY (`Id_Vehicule`), ADD KEY `index` (`Id_Adherent`), ADD KEY `Id_Adherent` (`Id_Adherent`), ADD KEY `Num_Permis` (`Num_Permis`);

--
-- Index pour la table `vehicule_equipements`
--
ALTER TABLE `vehicule_equipements`
 ADD PRIMARY KEY (`Id_Vehicule`,`Id_Equipements`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
MODIFY `Id_Adherent` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
MODIFY `Id_Caracteristique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `equipements`
--
ALTER TABLE `equipements`
MODIFY `Id_Equipements` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
MODIFY `Id_Trajet` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
ADD CONSTRAINT `FK_Adherent_Adminitrateur` FOREIGN KEY (`Id_Adherent`) REFERENCES `adherent` (`Id_Adherent`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etapes`
--
ALTER TABLE `etapes`
ADD CONSTRAINT `FK_etapes_trajet` FOREIGN KEY (`Id_Trajet`) REFERENCES `trajet` (`Id_Trajet`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
