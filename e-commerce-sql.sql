-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 11 oct. 2024 à 23:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `e-commerce-sql`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id_address` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart_product`
--

CREATE TABLE `cart_product` (
  `id_cart_product` int(11) NOT NULL,
  `id_cart` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

CREATE TABLE `command` (
  `id_command` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_address` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','delivered') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `command_product`
--

CREATE TABLE `command_product` (
  `id_command_product` int(11) NOT NULL,
  `id_command` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE `invoice` (
  `id_invoice` int(11) NOT NULL,
  `id_command` int(11) NOT NULL,
  `invoice_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `id_payment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `payment_type` enum('Credit Card','IBAN') NOT NULL,
  `payment_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rate`
--

CREATE TABLE `rate` (
  `id_rate` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id_address`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`id_cart_product`),
  ADD KEY `id_cart` (`id_cart`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`id_command`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_address` (`id_address`);

--
-- Index pour la table `command_product`
--
ALTER TABLE `command_product`
  ADD PRIMARY KEY (`id_command_product`),
  ADD KEY `id_command` (`id_command`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id_invoice`),
  ADD KEY `id_command` (`id_command`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Index pour la table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id_rate`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_product` (`id_product`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id_address` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cart_product`
--
ALTER TABLE `cart_product`
  MODIFY `id_cart_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `command`
--
ALTER TABLE `command`
  MODIFY `id_command` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `command_product`
--
ALTER TABLE `command_product`
  MODIFY `id_command_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rate`
--
ALTER TABLE `rate`
  MODIFY `id_rate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Contraintes pour la table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `command_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `command_ibfk_2` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`) ON DELETE CASCADE;

--
-- Contraintes pour la table `command_product`
--
ALTER TABLE `command_product`
  ADD CONSTRAINT `command_product_ibfk_1` FOREIGN KEY (`id_command`) REFERENCES `command` (`id_command`) ON DELETE CASCADE,
  ADD CONSTRAINT `command_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`id_command`) REFERENCES `command` (`id_command`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `photo_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE SET NULL;

--
-- Contraintes pour la table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
