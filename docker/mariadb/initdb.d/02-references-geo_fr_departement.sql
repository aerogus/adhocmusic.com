-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 25 août 2019 à 18:57
-- Version du serveur :  10.1.38-MariaDB-0+deb9u1
-- Version de PHP :  7.3.8-1+0~20190807.43+debian9~1.gbp7731bf

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `adhocmusic`
--

-- --------------------------------------------------------

--
-- Structure de la table `geo_fr_departement`
--

CREATE TABLE `geo_fr_departement` (
  `id_departement` char(3) NOT NULL,
  `id_world_region` char(2) NOT NULL,
  `id_region_insee` char(2) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `geo_fr_departement`
--

INSERT INTO `geo_fr_departement` (`id_departement`, `id_world_region`, `id_region_insee`, `name`) VALUES
('01', 'B9', '', 'Ain'),
('02', 'B6', '', 'Aisne'),
('03', '98', '', 'Allier'),
('04', 'B8', '', 'Alpes de Haute Provence'),
('05', 'B8', '', 'Hautes Alpes'),
('06', 'B8', '', 'Alpes Maritimes'),
('07', 'B9', '', 'Ardèche'),
('08', 'A4', '', 'Ardennes'),
('09', 'B3', '', 'Ariège'),
('10', 'A4', '', 'Aube'),
('11', 'A9', '', 'Aude'),
('12', 'B3', '', 'Aveyron'),
('13', 'B8', '', 'Bouches du Rhône'),
('14', '99', '', 'Calvados'),
('15', '98', '', 'Cantal'),
('16', 'B7', '', 'Charente'),
('17', 'B7', '', 'Charente Maritime'),
('18', 'A3', '', 'Cher'),
('19', 'B1', '', 'Corrèze'),
('2A', 'A5', '', 'Corse du Sud'),
('2B', 'A5', '', 'Haute Corse'),
('21', 'A1', '', 'Côte d\'or'),
('22', 'A2', '', 'Côtes d\'Armor'),
('23', 'B1', '', 'Creuse'),
('24', '97', '', 'Dordogne'),
('25', 'A6', '', 'Doubs'),
('26', 'B9', '', 'Drôme'),
('27', 'A7', '', 'Eure'),
('28', 'A3', '', 'Eure et Loir'),
('29', 'A2', '', 'Finistère'),
('30', 'A9', '', 'Gard'),
('31', 'B3', '', 'Haute Garonne'),
('32', 'B3', '', 'Gers'),
('33', '97', '', 'Gironde'),
('34', 'A9', '', 'Hérault'),
('35', 'A2', '', 'Ille et Vilaine'),
('36', 'A3', '', 'Indre'),
('37', 'A3', '', 'Indre et Loire'),
('38', 'B9', '', 'Isère'),
('39', 'A6', '', 'Jura'),
('40', '97', '', 'Landes'),
('41', 'A3', '', 'Loir et Cher'),
('42', 'B9', '', 'Loire'),
('43', '98', '', 'Haute Loire'),
('44', 'B5', '', 'Loire Atlantique'),
('45', 'A3', '', 'Loiret'),
('46', 'B3', '', 'Lot'),
('47', '97', '', 'Lot et Garonne'),
('48', 'A9', '', 'Lozère'),
('49', 'B5', '', 'Maine et Loire'),
('50', '99', '', 'Manche'),
('51', 'A4', '', 'Marne'),
('52', 'A4', '', 'Haute Marne'),
('53', 'B5', '', 'Mayenne'),
('54', 'B2', '', 'Meurthe et Moselle'),
('55', 'B2', '', 'Meuse'),
('56', 'A2', '', 'Morbihan'),
('57', 'B2', '', 'Moselle'),
('58', 'A1', '', 'Nièvre'),
('59', 'B4', '', 'Nord'),
('60', 'B6', '', 'Oise'),
('61', '99', '', 'Orne'),
('62', 'B4', '', 'Pas de Calais'),
('63', '98', '', 'Puy de dôme'),
('64', '97', '', 'Pyrénées-Atlantiques'),
('65', 'B3', '', 'Hautes Pyrénées'),
('66', 'A9', '', 'Pyrénées Orientales'),
('67', 'C1', '', 'Bas Rhin'),
('68', 'C1', '', 'Haut Rhin'),
('69', 'B9', '', 'Rhône'),
('70', 'A6', '', 'Haute Saône'),
('71', 'A1', '', 'Saône et Loire'),
('72', 'B5', '', 'Sarthe'),
('73', 'B9', '', 'Savoie'),
('74', 'B9', '', 'Haute Savoie'),
('75', 'A8', '', 'Paris'),
('76', 'A7', '', 'Seine Maritime'),
('77', 'A8', '', 'Seine et Marne'),
('78', 'A8', '', 'Yvelines'),
('79', 'B7', '', 'Deux-Sèvres'),
('80', 'B6', '', 'Somme'),
('81', 'B3', '', 'Tarn'),
('82', 'B3', '', 'Tarn et Garonne'),
('83', 'B8', '', 'Var'),
('84', 'B8', '', 'Vaucluse'),
('85', 'B5', '', 'Vendée'),
('86', 'B7', '', 'Vienne'),
('87', 'B1', '', 'Haute-Vienne'),
('88', 'B2', '', 'Vosges'),
('89', 'A1', '', 'Yonne'),
('90', 'A6', '', 'Territoire de Belfort'),
('91', 'A8', '', 'Essonne'),
('92', 'A8', '', 'Hauts de Seine'),
('93', 'A8', '', 'Seine Saint Denis'),
('94', 'A8', '', 'Val de Marne'),
('95', 'A8', '', 'Val d\'Oise');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `geo_fr_departement`
--
ALTER TABLE `geo_fr_departement`
  ADD PRIMARY KEY (`id_departement`),
  ADD KEY `id_region_old` (`id_region_insee`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
