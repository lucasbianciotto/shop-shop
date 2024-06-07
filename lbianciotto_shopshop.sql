-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 07 juin 2024 à 16:14
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lbianciotto_shopshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `etat` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `montant`, `date`, `etat`, `idUtilisateur`) VALUES
(1, '28760.00', '2024-01-07 18:20:41', 1, 1),
(2, '698.00', '2024-06-05 15:23:56', 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `composer`
--

CREATE TABLE `composer` (
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `composer`
--

INSERT INTO `composer` (`idCommande`, `idProduit`, `qte`) VALUES
(1, 32, 4),
(2, 34, 2);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `idType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `designation`, `description`, `prix`, `photo`, `idType`) VALUES
(1, 'Shure SM7B', 'Le Shure-SM7B est un microphone dynamique à bobine mobile avec une directivité cardioïde, ce qui le rend idéal pour l\'enregistrement de la parole et de la voix, mais il se défends également bien lors de la prise d\'instruments. Une réponse en fréquences large et linéaire garantit une reproduction naturelle des voix et des instruments.', 388, '7109b5bSIDS._AC_UF1000_1000_QL80_.jpg', 3),
(2, 'Rode Podmic', 'Micro voix dynamique pour enregistrement', 99, '61V2IPfjMEL.jpg', 3),
(4, 'Rode NT-USB', 'Microphone USB a condensateur polyvalent de qualite studio avec filtre anti-pop et trepied pour le streaming, les jeux, les podcasts, la production musicale.\r\n', 129, '11557354_800.jpg', 1),
(29, 'Blue Yeti', 'Micro USB Pour Enregistrer, Streaming, Gaming, Podcast, Micro Gaming Condensateur, Micro PC & Mac Avec Effets Blue VO!CE, Support Ajustable, Plug And Play', 139, '61vI0Zii07L.jpg', 1),
(30, 'Universal Audio SC-1', 'Microphone à condensateur large membrane avec système de modélisation de microphone Hemisphere', 555, '18613668_800.jpg', 3),
(32, 'Neumann M49V Set', 'Microphone à tube large membrane', 7190, '18341395_800.jpg', 3),
(33, 'AKG C414 XLII', 'Micro à condensateur large membrane', 1045, '9508381_800.jpg', 3),
(34, 'Aston Microphones Spirit', 'Microphone à condensateur large diaphragme', 349, '10774965_800.jpg', 3),
(35, 'the t.bone MB 7 Beta', 'Microphone dynamique de diffusion', 79, '15869078_800.jpg', 3),
(36, 'Bird Woodbrass UM1 Noir', 'Micro de studio\r\nUn excellent rapport qualité/prix. Idéal pour le studio, l\'animation de webradio\r\nLe Bird UM1 est un micro de studio d\'excellente qualité avec interface USB intégrée. C\'est une solution idéale et tout-en-un qui évite d\'avoir à acheter un préampli ou une interface audio supplémentaire.', 49, '71dIzQ71LvL.jpg', 1),
(37, 'Test', 'Test', 145, 'image1.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `libelle`) VALUES
(1, 'Adminstrateur'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `libelle`) VALUES
(1, 'USB'),
(3, 'XLR');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `mdp` varchar(256) CHARACTER SET latin1 NOT NULL,
  `nom` varchar(100) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(100) CHARACTER SET latin1 NOT NULL,
  `idRole` int(11) NOT NULL,
  `valider` tinyint(1) NOT NULL DEFAULT 0,
  `idgenere` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mdp`, `nom`, `prenom`, `idRole`, `valider`, `idgenere`) VALUES
(1, 'bianciottolucas@gmail.com', '$2y$10$TWSsj4e9MtHAPLjsglLaYO89B16V1G8b4SKg40fmfmKYMdN0b9AZO', 'BIANCIOTTO', 'Lucas', 1, 1, ''),
(11, 'lucaslauris84360@gmail.com', '$2y$10$3U/Gj9dqIT9DWok.3m5m4.DwdDf2nMXEWBSFp3Wz7IeVfgzqOun56', 'BIANCIOTTO', 'Lucas', 1, 1, '66605e492a51c');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_util` (`idUtilisateur`);

--
-- Index pour la table `composer`
--
ALTER TABLE `composer`
  ADD PRIMARY KEY (`idCommande`,`idProduit`),
  ADD KEY `fk_produit` (`idProduit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idType` (`idType`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_util` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idType`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
