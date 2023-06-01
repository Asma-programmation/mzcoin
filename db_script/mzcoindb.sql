-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 01 juin 2023 à 19:55
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
-- Base de données : `mzcoindb`
--

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `all_data_user_account_balance`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `all_data_user_account_balance`;
CREATE TABLE IF NOT EXISTS `all_data_user_account_balance` (
`id_utilisateur` bigint
,`reference_utilisateur` varchar(255)
,`nom_utilisateur` varchar(50)
,`prenom_utilisateur` varchar(50)
,`date_naissance_utilisateur` date
,`adresse_utilisateur` varchar(255)
,`pays_utilisateur` varchar(255)
,`agglomeration_utilisateur` varchar(255)
,`code_postal_utilisateur` varchar(10)
,`email_utilisateur` varchar(255)
,`mobile_utilisateur` varchar(20)
,`nationalite_utilisateur` varchar(255)
,`piece_identite_recto_utilisateur` varchar(255)
,`piece_identite_verso_utilisateur` varchar(255)
,`login_utilisateur` varchar(255)
,`password_utilisateur` varchar(255)
,`date_ajout_utilisateur` datetime
,`date_connexion_utilisateur` datetime
,`type_utilisateur` tinyint(1)
,`etat_utilisateur` tinyint(1)
,`id_compte` bigint
,`reference_compte` varchar(255)
,`iban_compte` varchar(16)
,`code_carte_compte` varchar(3)
,`jeton_compte` longtext
,`date_ajout_compte` datetime
,`type_compte` tinyint(1)
,`etat_compte` tinyint
,`client_compte` bigint
,`id_balance` bigint
,`reference_balance` varchar(255)
,`somme_balance` bigint
,`monnaie_balance` varchar(3)
,`date_ajout_balance` datetime
,`type_balance` tinyint(1)
,`etat_balance` tinyint(1)
,`compte_balance` bigint
);

-- --------------------------------------------------------

--
-- Structure de la table `balance`
--

DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `id_balance` bigint NOT NULL AUTO_INCREMENT COMMENT 'Identifiant interne autoincrémentale d''une balance',
  `reference_balance` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Numéro héxadicimal généré automatiquement pour tout nouvelle balance',
  `somme_balance` bigint DEFAULT '0' COMMENT 'La somme totale actuelle sur la balance, représentée par un nombre décimal',
  `monnaie_balance` varchar(3) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'La devise associée à la balance, représentée par une chaîne de 3 caractères ',
  `date_ajout_balance` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'La date auxquelles la balance a été créée et ajoutée au système',
  `type_balance` tinyint(1) DEFAULT NULL COMMENT '1. Balance d''un compte paiement\n2. Balance d''un compte carte bancaire physique\n3. Balance d''un compte carte bancaire virtuelle',
  `etat_balance` tinyint(1) DEFAULT '1' COMMENT 'L''état actuel de la balance, qui peut être soit "En vigueur" (si la balance est en cours d''utilisation), soit "Gelé" (si la balance est hors service ou en cours de maintenance), soit "Annuler"',
  `compte_balance` bigint NOT NULL COMMENT 'Le compte associé à la balance, représenté par un identifiant de compte unique dans le système',
  PRIMARY KEY (`id_balance`),
  UNIQUE KEY `reference_balance_UNIQUE` (`reference_balance`),
  KEY `fk_balance_carte1_idx` (`compte_balance`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `balance`
--

INSERT INTO `balance` (`id_balance`, `reference_balance`, `somme_balance`, `monnaie_balance`, `date_ajout_balance`, `type_balance`, `etat_balance`, `compte_balance`) VALUES
(1, '1111', 20000, 'DZD', '2023-05-27 09:54:07', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `id_compte` bigint NOT NULL AUTO_INCREMENT COMMENT 'Identifiant interne autoincrémentale du compte',
  `reference_compte` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Numéro héxadicimal généré automatiquement pour tout nouveau compte',
  `iban_compte` varchar(16) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Numéro attribué au compte pour être utilisé lors du paiement en ligne',
  `code_carte_compte` varchar(3) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Code de sécurité attribué uniquement aux cartes bancaires',
  `jeton_compte` longtext COLLATE utf8mb3_unicode_ci COMMENT 'Jeton de sécurité écrit en JSON contenant les données nécessaires à une opération (Voir modélio tOperation) ',
  `date_ajout_compte` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création du compte',
  `type_compte` tinyint(1) DEFAULT NULL COMMENT 'Type du compte qui peut être:\n1. Compte paiement\n2. Compte carte bancaire physique\n3. Compte carte bancaire virtuelle',
  `etat_compte` tinyint DEFAULT '1' COMMENT 'Etat des comptes:\r\n0. Compte gelé\r\n1. Compte en vigueur\r\n2. Compte annulé',
  `client_compte` bigint NOT NULL COMMENT 'Identifiant du client propriétaire du compte',
  PRIMARY KEY (`id_compte`),
  UNIQUE KEY `reference_carte_UNIQUE` (`reference_compte`),
  UNIQUE KEY `numero_carte_UNIQUE` (`iban_compte`),
  KEY `fk_carte_utilisateur_idx` (`client_compte`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `reference_compte`, `iban_compte`, `code_carte_compte`, `jeton_compte`, `date_ajout_compte`, `type_compte`, `etat_compte`, `client_compte`) VALUES
(1, '1111', 'DZ00111122223333', NULL, NULL, '2023-05-27 09:52:00', 1, 1, 6),
(2, '6a91ea3a', 'DZ1390234493', '139', NULL, '2023-05-31 18:31:41', 1, 0, 6),
(3, '7287843c', 'DZ1027024926', '102', NULL, '2023-05-31 20:17:29', 1, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

DROP TABLE IF EXISTS `operation`;
CREATE TABLE IF NOT EXISTS `operation` (
  `id_operation` bigint NOT NULL AUTO_INCREMENT COMMENT 'Identifiant interne autoincrémentale d''une operation',
  `reference_operation` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Numéro héxadicimal généré automatiquement pour tout nouvelle operation',
  `destinataire_operation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Destinataire de l''opération de transfère d''argent',
  `details_operation` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Informations supplémentaires sur l''opération effectuée sur le compte',
  `somme_operation` bigint DEFAULT '0' COMMENT 'Montant de l''opération effectuée sur le compte',
  `monnaie_operation` varchar(3) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT ' Type de monnaie dans laquelle l''opération a été effectuée (par exemple :DZD, EUR, USD.. etc.).',
  `jeton_partenaire_operation` longtext COLLATE utf8mb3_unicode_ci COMMENT 'Jeton de sécurité du partenaire (la deuxième partie de l''opération réalisée) écrit en JSON contenant les coordonnées du partenaire\nPar exemple:\n{\n  "card_number": "4242424242424242",\n  "card_expiry": "12/24",\n  "cvc": "123",\n  "amount": 100.50,\n  "currency": "USD",\n  "merchant_id": "1234567890",\n  "order_id": "ORD1234567890",\n  "customer_id": "CUS1234567890",\n  "timestamp": "2023-04-23T12:34:56Z",\n  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjYXJkX251bWJlciI6IjQyNDI0MjQyNDI0MjQyNDI0MjQiLCJjYXJkX2V4cGlyeSI6IjEyLzI0Iiwic3ViIjoiMTIzNDU2Nzg5MCIsImFtb3VudCI6MTAwLjUwLCJjdXJyZW5jeSI6IlVTRCIsIm1lcmNoYW50X2lkIjoiMTIzNDU2Nzg5MCIsIm9yZGVyX2lkIjoiT1JEMTIzNDU2Nzg5MCIsImN1c3RvbWVyX2lkIjoiQ1VTMTIzNDU2Nzg5MCIsInRpbWVzdGFtcCI6IjIwMjMtMDQtMjNUMTI6MzQ6NTZaIiwidG9rZW4iOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpJVXpJMU5pSjkuZXlKcGMzTWlPaUpyZFdKbGNsTnZiUzV6WldGMFlXZGxJaXdpYldsbGNuUmhkR1Z1ZEM1aGJHUXViRzlqYjIwdllYUnBiMjRnVTNneE1EQXdNVEF3TnpNd01EazBOak0yTnpBd05HWmpZV1l6WkRreFltTmxlQzV6YVhOMFpXNTBhVzRpT2lKa1l6SXhPREE0T0RRMk',
  `date_ajout_operation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date à laquelle l''opération a été ajoutée au compte',
  `date_annulation_operation` datetime DEFAULT NULL COMMENT ' Date à laquelle l''opération a été annulée',
  `type_operation` tinyint(1) DEFAULT NULL COMMENT 'Type de l''opération effectuée, qui peut être l''un des suivants : \r\n1. virement bancaire interne\r\n2. virement bancaire externe \r\n3. virement entre ses propres comptes',
  `etat_operation` tinyint(1) DEFAULT '1',
  `compte_operation` bigint NOT NULL COMMENT 'Compte sur lequel l''opération a été effectuée',
  PRIMARY KEY (`id_operation`),
  UNIQUE KEY `reference_operation_UNIQUE` (`reference_operation`),
  KEY `fk_operation_compte1_idx` (`compte_operation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` bigint NOT NULL AUTO_INCREMENT COMMENT 'Identifiant interne autoincrémentale d''utilisateur',
  `reference_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Numéro héxadicimal généré automatiquement pour tout nouveau utilisateur',
  `nom_utilisateur` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'nom de l''utilisateur ',
  `prenom_utilisateur` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'prenom de l''utilisateur ',
  `date_naissance_utilisateur` date DEFAULT NULL COMMENT 'date de naissance de l''utilisateur',
  `adresse_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'L''adresse physique de l''utilisateur',
  `pays_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Le pays de résidence de l''utilisateur',
  `agglomeration_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT ' L''agglomération (ville, village ou zone urbaine) de résidence de l''utilisateur',
  `code_postal_utilisateur` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Le code postal de l''adresse de résidence de l''utilisateur',
  `email_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'L''adresse e-mail de l''utilisateur',
  `mobile_utilisateur` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Le numero de telephone de l''utilisateur',
  `nationalite_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'La nationalité de l''utilisateur',
  `piece_identite_recto_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Une image ou une copie numérisée recto de la pièce d''identité de l''utilisateur (carte d''identité, passeport, permis de conduire).',
  `piece_identite_verso_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT ' Une image ou une copie numérisée verso de la pièce d''identité de l''utilisateur (carte d''identité, passeport, permis de conduire)',
  `login_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT ' Le nom d''utilisateur utilisé pour se connecter au système',
  `password_utilisateur` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'Mot de passe de l''utilisateur ',
  `date_ajout_utilisateur` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'La date à laquelle le compte utilisateur a été créé',
  `date_connexion_utilisateur` datetime DEFAULT NULL COMMENT ' La date de la dernière connexion de l''utilisateur au système',
  `type_utilisateur` tinyint(1) DEFAULT NULL COMMENT ' Le type d''utilisateur (Cliient, Administrateur,Partenaire)',
  `etat_utilisateur` tinyint(1) DEFAULT '1' COMMENT 'L''état actuel du compte utilisateur (actif , gelé ,annuler)',
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `reference_utilisateur_UNIQUE` (`reference_utilisateur`),
  UNIQUE KEY `email_utilisateur_UNIQUE` (`email_utilisateur`),
  UNIQUE KEY `mobile_utilisateur_UNIQUE` (`mobile_utilisateur`),
  UNIQUE KEY `login_utilisateur_UNIQUE` (`login_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `reference_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `date_naissance_utilisateur`, `adresse_utilisateur`, `pays_utilisateur`, `agglomeration_utilisateur`, `code_postal_utilisateur`, `email_utilisateur`, `mobile_utilisateur`, `nationalite_utilisateur`, `piece_identite_recto_utilisateur`, `piece_identite_verso_utilisateur`, `login_utilisateur`, `password_utilisateur`, `date_ajout_utilisateur`, `date_connexion_utilisateur`, `type_utilisateur`, `etat_utilisateur`) VALUES
(1, '000000', 'ZENTAR', 'Asma', '2000-08-11', '/', '/', '/', '/', '/', '/', '/', '/', '/', 'asma_zentar', '123456', '2023-04-30 13:55:26', NULL, 6, 1),
(2, '111111', 'MESSAOUDI', 'Chiraz', '2000-09-26', '/', '/', '/', '', 'chiraz@gmail.com', '0673748588', '/', '/', '/', 'Messaoudi_Chiraz', '123456', '0000-00-00 00:00:00', NULL, 1, 1),
(3, '1b6720ff', 'Artiste', 'Z', '2002-07-13', 'Annaba', 'ALGERIE', 'ANNABA', '23000', 'artista@gmail.Com', '0644445854', 'Algerienne', NULL, NULL, 'Artista', '123456', '2023-05-13 12:41:47', NULL, NULL, 1),
(4, '2b00ce5e', 'test', 'test', '1999-02-14', 'alger', 'ALGERIE', 'ANNABA', '23000', 'test@gmail.Com', '0644435854', 'Algerienne', NULL, NULL, 'test', '123456', '2023-05-14 20:12:55', NULL, NULL, 1),
(5, '57b33f9d', 'Zentar1', 'Asma1', '1999-02-01', 'Annaba', 'ALGERIE', 'Annaba', '23000', 'asma_zentar1@gmail.com', '06724358555', 'Algerienne', NULL, NULL, 'asma_zentar1', '123456', '2023-05-14 20:26:16', NULL, NULL, 1),
(6, '7f9921d3', 'Messaoudi', 'Chiraz', '2000-01-01', 'Annaba', 'ALGERIE', 'Annaba', '23000', 'netlog@gmail.com', '0655665566', 'Algérienne', NULL, NULL, 'netlog', '123456', '2023-05-14 20:41:04', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la vue `all_data_user_account_balance`
--
DROP TABLE IF EXISTS `all_data_user_account_balance`;

DROP VIEW IF EXISTS `all_data_user_account_balance`;
CREATE VIEW `all_data_user_account_balance`  AS SELECT `u`.`id_utilisateur` AS `id_utilisateur`, `u`.`reference_utilisateur` AS `reference_utilisateur`, `u`.`nom_utilisateur` AS `nom_utilisateur`, `u`.`prenom_utilisateur` AS `prenom_utilisateur`, `u`.`date_naissance_utilisateur` AS `date_naissance_utilisateur`, `u`.`adresse_utilisateur` AS `adresse_utilisateur`, `u`.`pays_utilisateur` AS `pays_utilisateur`, `u`.`agglomeration_utilisateur` AS `agglomeration_utilisateur`, `u`.`code_postal_utilisateur` AS `code_postal_utilisateur`, `u`.`email_utilisateur` AS `email_utilisateur`, `u`.`mobile_utilisateur` AS `mobile_utilisateur`, `u`.`nationalite_utilisateur` AS `nationalite_utilisateur`, `u`.`piece_identite_recto_utilisateur` AS `piece_identite_recto_utilisateur`, `u`.`piece_identite_verso_utilisateur` AS `piece_identite_verso_utilisateur`, `u`.`login_utilisateur` AS `login_utilisateur`, `u`.`password_utilisateur` AS `password_utilisateur`, `u`.`date_ajout_utilisateur` AS `date_ajout_utilisateur`, `u`.`date_connexion_utilisateur` AS `date_connexion_utilisateur`, `u`.`type_utilisateur` AS `type_utilisateur`, `u`.`etat_utilisateur` AS `etat_utilisateur`, `c`.`id_compte` AS `id_compte`, `c`.`reference_compte` AS `reference_compte`, `c`.`iban_compte` AS `iban_compte`, `c`.`code_carte_compte` AS `code_carte_compte`, `c`.`jeton_compte` AS `jeton_compte`, `c`.`date_ajout_compte` AS `date_ajout_compte`, `c`.`type_compte` AS `type_compte`, `c`.`etat_compte` AS `etat_compte`, `c`.`client_compte` AS `client_compte`, `b`.`id_balance` AS `id_balance`, `b`.`reference_balance` AS `reference_balance`, `b`.`somme_balance` AS `somme_balance`, `b`.`monnaie_balance` AS `monnaie_balance`, `b`.`date_ajout_balance` AS `date_ajout_balance`, `b`.`type_balance` AS `type_balance`, `b`.`etat_balance` AS `etat_balance`, `b`.`compte_balance` AS `compte_balance` FROM ((`utilisateur` `u` join `compte` `c`) join `balance` `b`) WHERE ((`u`.`id_utilisateur` = `c`.`client_compte`) AND (`c`.`id_compte` = `b`.`compte_balance`))  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
