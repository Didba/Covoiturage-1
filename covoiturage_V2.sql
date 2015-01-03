-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 02 Janvier 2015 à 14:55
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET FOREIGN_KEY_CHECKS=0;
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

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
`id_adherent` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `date_naissance` date NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `adherent`
--

INSERT INTO `adherent` (`id_adherent`, `nom`, `prenom`, `sexe`, `telephone`, `date_naissance`, `mail`, `password`) VALUES
(1, 'Boulongne', 'Thomas', '1', '0160103788', '2014-12-03', 'thomasboulongne@hotmail.com', '1234'),
(2, 'Chapka', 'Thomas', '1', '0102030405', '2014-12-16', 'thomas@mail.fr', '1234'),
(3, 'Chakrina', 'Mouhouni', '1', '0102030405', '2013-06-21', 'mou@mail.com', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_adherent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `caracteristique`
--

DROP TABLE IF EXISTS `caracteristique`;
CREATE TABLE IF NOT EXISTS `caracteristique` (
`id_caracteristique` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

DROP TABLE IF EXISTS `conducteur`;
CREATE TABLE IF NOT EXISTS `conducteur` (
  `num_permis` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `conducteur`
--

INSERT INTO `conducteur` (`num_permis`, `id_adherent`) VALUES
(12345, 1);

-- --------------------------------------------------------

--
-- Structure de la table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
CREATE TABLE IF NOT EXISTS `equipements` (
`id_equipements` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etapes`
--

DROP TABLE IF EXISTS `etapes`;
CREATE TABLE IF NOT EXISTS `etapes` (
  `id_etapes` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL,
  `lieu` varchar(30) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_adherent_from` int(11) NOT NULL,
  `id_adherent_to` int(11) NOT NULL,
  `date` date NOT NULL,
  `sujet` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `commentaire` text NOT NULL
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
  `frais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

DROP TABLE IF EXISTS `trajet`;
CREATE TABLE IF NOT EXISTS `trajet` (
`id_trajet` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL,
  `num_permis` int(11) NOT NULL,
  `date_traj` datetime NOT NULL,
  `nb_passagers_max` int(11) NOT NULL,
  `lieu_depart` varchar(30) NOT NULL,
  `lieu_arrivee` varchar(30) NOT NULL,
  `commentaire` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `id_adherent`, `num_permis`, `date_traj`, `nb_passagers_max`, `lieu_depart`, `lieu_arrivee`, `commentaire`) VALUES
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
  `id_trajet` int(11) NOT NULL,
  `id_caracteristique` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL,
  `num_permis` int(11) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `carburant` varchar(50) NOT NULL,
  `immatriculation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule_equipements`
--

DROP TABLE IF EXISTS `vehicule_equipements`;
CREATE TABLE IF NOT EXISTS `vehicule_equipements` (
  `id_vehicule` int(11) NOT NULL,
  `id_equipements` int(11) NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adherent`
--
ALTER TABLE `adherent`
 ADD PRIMARY KEY (`id_adherent`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
 ADD PRIMARY KEY (`id_adherent`);

--
-- Index pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
 ADD PRIMARY KEY (`id_caracteristique`);

--
-- Index pour la table `conducteur`
--
ALTER TABLE `conducteur`
 ADD PRIMARY KEY (`num_permis`,`id_adherent`), ADD UNIQUE KEY `Id_Adherent_Conducteur` (`id_adherent`);

--
-- Index pour la table `equipements`
--
ALTER TABLE `equipements`
 ADD PRIMARY KEY (`id_equipements`);

--
-- Index pour la table `etapes`
--
ALTER TABLE `etapes`
 ADD PRIMARY KEY (`id_etapes`), ADD KEY `FK_etapes_trajet` (`id_trajet`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`id_adherent_from`,`id_adherent_to`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
 ADD PRIMARY KEY (`id_adherent_from`,`id_adherent_to`);

--
-- Index pour la table `participe`
--
ALTER TABLE `participe`
 ADD PRIMARY KEY (`id_adherent`,`id_trajet`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
 ADD PRIMARY KEY (`id_trajet`), ADD KEY `id_adherent` (`id_adherent`);

--
-- Index pour la table `trajet_caracteristique`
--
ALTER TABLE `trajet_caracteristique`
 ADD PRIMARY KEY (`id_trajet`,`id_caracteristique`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
 ADD PRIMARY KEY (`id_vehicule`), ADD KEY `index` (`id_adherent`), ADD KEY `id_adherent` (`id_adherent`), ADD KEY `Num_Permis` (`num_permis`);

--
-- Index pour la table `vehicule_equipements`
--
ALTER TABLE `vehicule_equipements`
 ADD PRIMARY KEY (`id_vehicule`,`id_equipements`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `adherent`
--
ALTER TABLE `adherent`
MODIFY `id_adherent` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `caracteristique`
--
ALTER TABLE `caracteristique`
MODIFY `id_caracteristique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `equipements`
--
ALTER TABLE `equipements`
MODIFY `id_equipements` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
MODIFY `id_trajet` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
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
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
ADD CONSTRAINT `cle_conducteur` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`id_adherent`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`id_adherent`) REFERENCES `conducteur` (`id_adherent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
