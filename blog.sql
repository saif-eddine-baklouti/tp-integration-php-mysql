-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 10 sep. 2023 à 02:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `auteur` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `texte`, `auteur`) VALUES
(1, 'new 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Cum sociis natoque penatibus et magnis dis parturient montes nascetur. Quis vel eros donec ac odio tempor orci dapibus. Mattis pellentesque id nibh tortor id aliquet lectus proin nibh. Facilisis leo vel fringilla est ullamcorper. Aliquam sem fringilla ut morbi. Tincidunt eget nullam non nisi est sit. Ut ornare lectus sit amet est placerat in egestas. Ultrices neque ornare aenean euismod elementum nisi. Netus et malesuada fames ac. Tincidunt lobortis feugiat vivamus at augue eget. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor. Sit amet risus nullam eget felis eget nunc lobortis mattis. Elit at imperdiet dui accumsan sit. Ultricies mi quis hendrerit dolor. Massa tincidunt dui ut ornare. Libero enim sed faucibus turpis in eu mi.', 'user1'),
(2, 'another one', 'Tempus egestas sed sed risus. Malesuada fames ac turpis egestas maecenas pharetra convallis posuere morbi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames. Sit amet venenatis urna cursus eget nunc scelerisque viverra mauris. Convallis aenean et tortor at risus. Eget mi proin sed libero enim sed faucibus turpis in. Turpis in eu mi bibendum neque egestas congue quisque. Amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar sapien. Hendrerit dolor magna eget est lorem. Malesuada nunc vel risus commodo. Vitae turpis massa sed elementum tempus. Placerat duis ultricies lacus sed turpis tincidunt.', 'user1'),
(3, 'yeah', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'user2'),
(4, 'hello', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'user2'),
(5, 'yes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In eu mi bibendum neque egestas congue quisque. Ac tortor dignissim convallis aenean et tortor at. Ridiculus mus mauris vitae ultricies leo integer malesuada nunc. Duis ut diam quam nulla porttitor massa. Fames ac turpis egestas integer eget aliquet nibh praesent tristique. Justo eget magna fermentum iaculis eu. Id leo in vitae turpis. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus. Arcu cursus euismod quis viverra nibh cras pulvinar mattis. Congue quisque egestas diam in arcu. Velit ut tortor pretium viverra suspendisse potenti. Sed risus ultricies tristique nulla aliquet. Quam elementum pulvinar etiam non. Elit pellentesque habitant morbi tristique senectus et netus et malesuada. Vitae sapien pellentesque habitant morbi tristique senectus et. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Id nibh tortor id aliquet lectus proin nibh nisl. Pellentesque habitant morbi tristique senectus et.', 'user4'),
(6, 'no no', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed turpis tincidunt id aliquet risus feugiat in ante. Id cursus metus aliquam eleifend. Metus vulputate eu scelerisque felis imperdiet proin fermentum. Senectus et netus et malesuada. Cras ornare arcu dui vivamus arcu felis bibendum ut tristique. Id diam maecenas ultricies mi eget mauris pharetra et. Tincidunt tortor aliquam nulla facilisi cras fermentum odio eu. At elementum eu facilisis sed odio morbi quis commodo. Quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor.', 'user4'),
(7, 'sup', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed turpis tincidunt id aliquet risus feugiat in ante. Id cursus metus aliquam eleifend. Metus vulputate eu scelerisque felis imperdiet proin fermentum. Senectus et netus et malesuada. Cras ornare arcu dui vivamus arcu felis bibendum ut tristique. Id diam maecenas ultricies mi eget mauris pharetra et. Tincidunt tortor aliquam nulla facilisi cras fermentum odio eu. At elementum eu facilisis sed odio morbi quis commodo. Quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor.', 'user3'),
(9, 'last one ', 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'user4');

-- --------------------------------------------------------

--
-- Structure de la table `usagers`
--

CREATE TABLE `usagers` (
  `username` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `usagers`
--

INSERT INTO `usagers` (`username`, `password`) VALUES
('user1', '$2y$10$bH.zrgw9yhzevS2kY3e0n.RZ.DXB7HEXwG.Vz4bUcfjqKgKyR7w5W'),
('user2', '$2y$10$v9ZTi3O9xUhj6LEyqAwdhufqotJ30dJUt8v3G5ep/ADSrdLjr/StC'),
('user3', '$2y$10$LgvO9aon1cTUF6RBxJnUROKzYsXcncVHcnHbfGP633LoU50JvHQNi'),
('user4', '$2y$10$y3xhI3YfMbJUZW6KaGoXt.o4VuSUww45WLxLvDe08jpkPOOwEACJG');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auteur` (`auteur`);

--
-- Index pour la table `usagers`
--
ALTER TABLE `usagers`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `usagers` (`username`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
