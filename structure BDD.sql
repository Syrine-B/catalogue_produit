-- MySQL dump 10.14  Distrib 5.5.68-MariaDB, for Linux ()
--
--
-- Table `UTILISATEUR`
--

CREATE TABLE `UTILISATEUR` (
  `primkey` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) NOT NULL,
  `prenom` varchar(500) NOT NULL,
  `groupe` varchar(500) NOT NULL,
  `userID` varchar(500) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  PRIMARY KEY (`primkey`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
--  Table `catalogueProduit`
--

CREATE TABLE `catalogueProduit` (
  `ID_Prod` int(255) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire',
  `categorie` varchar(100) NOT NULL COMMENT 'catégorie de produit',
  `nomFournisseur` varchar(100) NOT NULL COMMENT 'nom du fournisseur du produit',
  `nomDitom` varchar(100) NOT NULL,
  `details` varchar(100) DEFAULT NULL,
  `constructeur` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `necessite` varchar(100) DEFAULT NULL COMMENT 'si un autre produit est necessaire au bon fonctionnement de celui ci',
  `utilite` varchar(100) DEFAULT NULL COMMENT 'dans quel cadre le produit est utile',
  `dimension` varchar(100) NOT NULL,
  `poids` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL COMMENT 'emplacement de la photo du produit',
  PRIMARY KEY (`ID_Prod`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table `documents`
--

CREATE TABLE `documents` (
  `idDoc` int(255) NOT NULL AUTO_INCREMENT,
  `nomDoc` varchar(500) NOT NULL,
  `cheminDoc` varchar(500) NOT NULL,
  PRIMARY KEY (`idDoc`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

