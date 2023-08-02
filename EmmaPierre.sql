-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 02 août 2023 à 11:40
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `final_emma_pierre`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'collier'),
(2, 'boucles d\'oreilles'),
(3, 'bracelet');

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

DROP TABLE IF EXISTS `collection`;
CREATE TABLE IF NOT EXISTS `collection` (
  `collection_id` int NOT NULL AUTO_INCREMENT,
  `collection_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`collection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `collection`
--

INSERT INTO `collection` (`collection_id`, `collection_name`) VALUES
(1, 'impertinante'),
(2, 'precieuse'),
(3, 'unique');

-- --------------------------------------------------------

--
-- Structure de la table `color`
--

DROP TABLE IF EXISTS `color`;
CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id_customer` int NOT NULL AUTO_INCREMENT,
  `telephone` varchar(20) DEFAULT NULL,
  `numero_rue` varchar(50) DEFAULT NULL,
  `nom_rue` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id_customer`, `telephone`, `numero_rue`, `nom_rue`, `ville`, `code_postal`, `pays`) VALUES
(1, '01234567989', '12', 'Jules Ferry', 'Dijon', '21000', 'France'),
(2, '0123456789', '15', 'Victor Hugo', 'Villeurbanne', '69100', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `gem_type`
--

DROP TABLE IF EXISTS `gem_type`;
CREATE TABLE IF NOT EXISTS `gem_type` (
  `gem_id` int NOT NULL AUTO_INCREMENT,
  `gem_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `gem_type`
--

INSERT INTO `gem_type` (`gem_id`, `gem_name`) VALUES
(1, 'Améthyste '),
(2, 'Aigue-marine'),
(3, 'Citrine '),
(4, 'Cornaline ');

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `model_id` int NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `order_total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `id_customer` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_date`, `order_status`, `order_total`) VALUES
(14, 4, '2023-07-21', 'Pending', '240'),
(15, 5, '2023-07-21', 'Pending', '660'),
(16, 4, '2023-07-21', 'Pending', '160'),
(17, 5, '2023-07-21', 'Pending', '380'),
(18, 5, '2023-07-21', 'Pending', '120'),
(19, NULL, '2023-07-21', 'Pending', '180'),
(20, 5, '2023-07-21', 'Pending', '120');

-- --------------------------------------------------------

--
-- Structure de la table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `order_detail`
--

INSERT INTO `order_detail` (`detail_id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(5, 14, 1, 2, '120.00'),
(6, 15, 2, 3, '180.00'),
(7, 15, 1, 1, '120.00'),
(8, 16, 3, 2, '80.00'),
(9, 17, 2, 1, '180.00'),
(10, 17, 1, 1, '120.00'),
(11, 17, 3, 1, '80.00'),
(12, 18, 1, 1, '120.00'),
(13, 19, 2, 1, '180.00'),
(14, 20, 1, 1, '120.00');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `collection_id` int DEFAULT NULL,
  `color_id` int DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `gem_id` int DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `collection_id` (`collection_id`),
  KEY `color_id` (`color_id`),
  KEY `model_id` (`model_id`),
  KEY `gem_id` (`gem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `description`, `image`, `category_id`, `collection_id`, `color_id`, `model_id`, `gem_id`) VALUES
(1, 'collier de Cornaline ', '120.00', 'Une pierre de couleur rouge-orangé à brun, associée à l\'énergie et à la vitalité. Elle est souvent utilisée pour favoriser la motivation et la créativité.', 'catPrecieuse.png', 1, 2, NULL, NULL, 4),
(2, 'bracelet Améthyste ', '180.00', 'Une pierre violette souvent utilisée en bijouterie. Elle est associée à la sagesse et à la spiritualité.', 'bracelet.webp', 3, 1, NULL, NULL, 1),
(3, 'Boucles d\'oreilles Aigue Marine', '80.00', 'Une pierre de couleur bleu clair à bleu-vert, qui rappelle la mer. Elle est associée à la clarté mentale et à la communication.', 'earings_zoom_2.jpeg', 2, 3, NULL, NULL, 2),
(4, 'Collier Citrine', '110.00', 'Une pierre jaune à orangée qui symbolise la joie et l\'abondance. Elle est souvent utilisée comme pierre de protection.', 'neck_necklace.jpeg', 1, 1, NULL, NULL, 3),
(6, 'test', '22.00', 'test', 'BJOUX1.png', 1, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_customer` int DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '1',
  `nom_prenom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `id_customer` (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `id_customer`, `statut`, `nom_prenom`) VALUES
(3, 'admin', 'admin@admin.fr', '$2y$10$kDHdBiC0c43y/kEch7l3O.XpaQQV5Yfm1uO34ZlpQ3wupJDJ6da5O', NULL, 0, NULL),
(4, 'gaet56', 'gaet@gmail.com', '$2y$10$ZaL1CxHI3EobQ2AduXoRF.7sCw5mQR6EyECxuuh8s6H77/tBcHI8G', 1, 1, 'Gaetan Cardier'),
(5, 'john69', 'johndoe@gmail.com', '$2y$10$FHUQm9SK.e2CzYeNlTlf2ukNoup43VOitn9bfRTtLcHbgPRlf..i2', 2, 1, 'John Doe');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`collection_id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`),
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`model_id`) REFERENCES `model` (`model_id`),
  ADD CONSTRAINT `product_ibfk_5` FOREIGN KEY (`gem_id`) REFERENCES `gem_type` (`gem_id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
