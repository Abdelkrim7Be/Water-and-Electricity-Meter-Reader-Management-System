-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 05 mai 2024 à 02:34
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `releve`
--

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `releve_plan_id` int(11) NOT NULL,
  `acteur` varchar(255) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `updated_fields` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acteur_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `releve_plan_id`, `acteur`, `action_type`, `updated_fields`, `created_at`, `updated_at`, `acteur_type`) VALUES
(1, 96, 'morad hifadi', 'update', 'num_tournee_fin ', '2023-06-16 17:15:37', '2023-06-16 17:15:37', 'AdminSup'),
(2, 97, 'morad hifadi', 'create', 'toutes les colonnes', '2023-06-18 12:12:27', '2023-06-18 12:12:27', 'AdminSup'),
(3, 95, 'morad hifadi', 'update', 'releveur ordre_lecture nombre_total temps_execution_jours ', '2023-06-18 12:15:02', '2023-06-18 12:15:02', 'AdminSup'),
(4, 95, 'morad hifadi', 'update', 'ordre_lecture nombre_total ', '2023-06-18 12:15:57', '2023-06-18 12:15:57', 'AdminSup'),
(5, 97, 'morad hifadi', 'update', 'ordre_lecture nombre_total ', '2023-06-18 12:17:49', '2023-06-18 12:17:49', 'AdminSup'),
(6, 97, 'morad hifadi', 'update', 'num_tournee_debut ', '2023-06-18 12:19:31', '2023-06-18 12:19:31', 'AdminSup'),
(7, 83, 'morad hifadi', 'delete', 'tous les colonnes', '2023-06-18 12:20:23', '2023-06-18 12:20:23', 'AdminSup'),
(8, 97, 'morad hifadi', 'update', 'temps_execution_jours ', '2023-06-18 12:30:34', '2023-06-18 12:30:34', 'AdminSup'),
(9, 97, 'abdelkrim bellagnech', 'update', 'temps_execution_jours ', '2023-06-18 12:31:37', '2023-06-18 12:31:37', 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_04_20_223136_create_releveurs_table', 1),
(7, '2023_04_20_225538_add_birthday_column_to_releveurs_table', 1),
(8, '2023_04_25_143656_add_icon_column_to_releveurs_table', 1),
(9, '2023_04_25_143805_create_periodes_table', 1),
(10, '2023_04_25_143821_create_historiques_table', 1),
(11, '2023_04_25_143944_create_releve_plans_table', 1),
(12, '2023_04_26_101645_drop_description_field_from_releveurs_table', 2),
(13, '2023_05_01_133318_reorder_columns_in_releveurs', 3),
(14, '2023_05_07_185857_change_default_value_of_version_field', 4),
(15, '2023_05_07_213824_change_acteur_field_type_in_releve_plans_table', 5),
(16, '2023_05_07_215137_change_type_of_fields_in_theperiodes_table', 6),
(17, '2023_05_07_215532_change_type_of_fields_in_the_periodes_table', 7),
(18, '2023_05_07_215606_change_type_of_fields_in_the_periodes_table_again', 8),
(19, '2023_05_07_225753_change_releveur_type_in_the_plan_releve_table', 9),
(20, '2023_05_07_234350_change_releveur_birthday_type_', 10),
(21, '2023_05_08_005210_change_releve_plan_table_type_ordre_lecture', 11),
(22, '2023_05_10_130244_supprimer_historiques_table_et_creer_nouvelle_meme_nom_differents_columns', 12),
(23, '2023_05_10_134240_set_default_values_for_updated_fields_colonne_for_historique_table', 13),
(24, '2023_05_11_001414_add_acteur_type_column_dans_historique_tabel', 14),
(28, '2023_05_14_184239_create_roles_table', 15),
(29, '2023_05_15_115821_add_is_admin_field_to_roles_table', 16),
(30, '2023_05_15_115852_add_role_id_field_to_users_table', 16);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `periodes`
--

CREATE TABLE `periodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `periodes`
--

INSERT INTO `periodes` (`id`, `mois`, `annee`, `created_at`, `updated_at`) VALUES
(1, 8, 2019, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `releveurs`
--

CREATE TABLE `releveurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serialNumber` varchar(255) NOT NULL,
  `iconImage` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `releveurs`
--

INSERT INTO `releveurs` (`id`, `serialNumber`, `iconImage`, `fullName`, `birthday`, `email`, `created_at`, `updated_at`) VALUES
(49, 'R184', '1683680819.jpg', 'Andrew Tate', '1979-05-23', 'andrewtate@gmail.com', '2023-05-10 01:07:42', '2023-05-10 01:07:42'),
(50, 'R526', '1686352818.jpg', 'Hicham Bellagnech', '2004-02-19', 'hichambellagnech@gmail.com', '2023-05-10 01:13:53', '2023-06-09 23:50:29'),
(57, 'R125', '1686353050.jpg', 'soufiane hijam', '1975-05-01', 'soufianhijama12@gmail.com', '2023-05-15 23:23:13', '2023-06-09 23:24:11'),
(59, 'R436', '1684941131.jpg', 'Maya rbtt', '1998-05-15', 'mayamaya@gmail.com', '2023-05-24 15:12:13', '2023-06-10 01:58:44'),
(60, 'R409', '1686407175.jpg', 'Achraf Hmidi', '2003-09-04', 'achrafhmidi@gmail.com', '2023-06-09 23:26:41', '2023-06-10 14:26:16'),
(61, 'R668', '1686872009.jpg', 'Jawad Skali', '2002-06-14', 'jawadskls@gmail.com', '2023-06-10 14:25:59', '2023-06-16 17:06:05'),
(62, 'R155', '1686938893.jpg', 'hiba bnaima', '1995-02-14', 'hibabnaima@gmail.com', '2023-06-16 17:08:45', '2023-06-16 17:08:45');

-- --------------------------------------------------------

--
-- Structure de la table `releve_plans`
--

CREATE TABLE `releve_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `releveur` varchar(5) NOT NULL,
  `periode` int(11) NOT NULL,
  `acteur` text NOT NULL,
  `version` int(11) NOT NULL DEFAULT 0,
  `date_releve` date NOT NULL,
  `num_tournee_debut` varchar(255) NOT NULL,
  `num_tournee_fin` varchar(255) NOT NULL,
  `ordre_lecture` varchar(255) NOT NULL,
  `nombre_total` int(11) NOT NULL,
  `temps_execution_jours` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `releve_plans`
--

INSERT INTO `releve_plans` (`id`, `releveur`, `periode`, `acteur`, `version`, `date_releve`, `num_tournee_debut`, `num_tournee_fin`, `ordre_lecture`, `nombre_total`, `temps_execution_jours`, `created_at`, `updated_at`) VALUES
(82, 'R125', 1, 'abdelkrim bellagnech', 0, '2023-06-05', '120 000 000', '120 120 010', '52 42', 224, 2, '2023-06-04 12:59:46', '2023-06-04 12:59:46'),
(84, 'R436', 1, 'morad hifadi', 1, '2023-06-12', '110 000 000', '110 050 030', '54 85 6', 336, 3, '2023-06-09 23:15:30', '2023-06-10 14:23:23'),
(85, 'R125', 1, 'morad hifadi', 3, '2023-06-13', '110 060 000', '110 410 021', '6 25 3', 336, 3, '2023-06-09 23:17:56', '2023-06-10 14:34:56'),
(87, 'R409', 1, 'morad hifadi', 7, '2023-06-11', '230 000 000', '230 190 026', '8 12 5 31', 448, 4, '2023-06-10 13:54:31', '2023-06-10 14:15:25'),
(94, 'R668', 1, 'morad hifadi', 2, '2023-06-15', '153 100 000', '153 293 030', '8 485 69', 336, 3, '2023-06-16 16:29:26', '2023-06-16 16:52:18'),
(95, 'R526', 1, 'morad hifadi', 9, '2023-06-17', '152 000 000', '152 299 030', '8 45 23 30', 448, 4, '2023-06-16 16:31:20', '2023-06-18 12:15:57'),
(96, 'R184', 1, 'morad hifadi', 8, '2023-06-15', '266 000 000', '266 352 006', '8 405 230', 336, 3, '2023-06-16 16:34:05', '2023-06-16 17:15:37'),
(97, 'R436', 1, 'morad hifadi', 4, '2023-06-20', '129 100 000', '129 230 030', '845 215 021', 336, 4, '2023-06-18 12:12:26', '2023-06-18 12:31:37');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roleName` varchar(255) NOT NULL,
  `permission` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `roleName`, `permission`, `description`, `isAdmin`, `created_at`, `updated_at`) VALUES
(21, 'AdminSup', '[{\"ressourceName\":\"Relèves\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"releves\"},{\"ressourceName\":\"Releveurs\",\"read\":true,\"write\":false,\"update\":true,\"delete\":true,\"name\":\"releveurs\"},{\"ressourceName\":\"Admin_Users\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"adminusers\"},{\"ressourceName\":\"Roles\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"roles\"},{\"ressourceName\":\"Assign_Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"assignRole\"},{\"ressourceName\":\"Historique\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"historique\"}]', 'Administrateur supérieur qui peut tout faire', 1, '2023-05-14 21:10:22', '2023-11-22 13:11:09'),
(22, 'Admin', '[{\"ressourceName\":\"Relèves\",\"read\":true,\"write\":true,\"update\":true,\"delete\":false,\"name\":\"releves\"},{\"ressourceName\":\"Releveurs\",\"read\":true,\"write\":true,\"update\":true,\"delete\":false,\"name\":\"releveurs\"},{\"ressourceName\":\"Admin_Users\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"adminusers\"},{\"ressourceName\":\"Roles\",\"read\":true,\"write\":true,\"update\":false,\"delete\":false,\"name\":\"roles\"},{\"ressourceName\":\"Assign_Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\"},{\"ressourceName\":\"Historique\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"historique\"}]', 'Administrateur qui ne peut pas supprimer des plans de relève', 1, '2023-05-14 21:10:40', '2023-06-15 22:34:37'),
(25, 'User', '[{\"ressourceName\":\"Relèves\",\"read\":true,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"releves\"},{\"ressourceName\":\"Releveurs\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"releveurs\"},{\"ressourceName\":\"Admin_Users\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"adminusers\"},{\"ressourceName\":\"Roles\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"roles\"},{\"ressourceName\":\"Assign_Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\"},{\"ressourceName\":\"Historique\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"historique\"}]', 'Utilisateur normal qui peeut seulement voir le planning et les releveurs sans rien faire', 0, '2023-06-01 02:02:30', '2023-11-22 13:16:22');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `userType` varchar(255) NOT NULL DEFAULT 'user',
  `isActivated` tinyint(1) NOT NULL DEFAULT 0,
  `passwordResetCode` varchar(255) DEFAULT NULL,
  `activationCode` varchar(255) DEFAULT NULL,
  `socialType` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `fullName`, `email`, `password`, `role_id`, `userType`, `isActivated`, `passwordResetCode`, `activationCode`, `socialType`, `created_at`, `updated_at`) VALUES
(25, 'morad hifadi', 'moradhi125@gmail.com', '$2y$10$TlmGTNsdaij2rmiG2ClyC.VTH8llIshG/ocBAhVHfTJ8sXEnhsJ.W', 21, 'AdminSup', 0, NULL, NULL, NULL, '2023-05-15 23:46:04', '2023-06-18 12:24:43'),
(26, 'abdelkrim bellagnech', 'abdelkrimbellagnech10@gmail.com', '$2y$10$0d4OKYfRNEEaIH5mO2AkWuGQ6qJxRTndQ2Pd6.3hRqlhByjGU21C2', 22, 'Admin', 0, NULL, NULL, NULL, '2023-05-15 23:47:08', '2023-06-10 14:34:17'),
(30, 'hanan hifadi', 'hanan.hifadi.2002@gmail.com', '$2y$10$E/An0eAWG83mD4cVienPH.r/YKasXRSled0z/obVEI0u2aMv1NXqC', 25, 'User', 0, NULL, NULL, NULL, '2023-06-01 02:02:59', '2023-06-10 00:43:20'),
(31, 'Otmane Lmaya', 'lmaya@manara.ma', '$2y$10$EAcfxsJ8IhMnMlQ7MHJezOnFGiFthmA0hh01MMl1w/CFEDpEuSSE.', 21, 'AdminSup', 0, NULL, NULL, NULL, '2023-06-09 23:56:32', '2023-06-09 23:56:32'),
(33, 'Hibaa Laacharr', 'hibalaachar45@gmail.com', '$2y$10$FXt6uGnUMzj8ORkQ/TrRBehfqJDVXQQ.kxxnR6vOT0F868.nI0HWq', 22, 'Admin', 0, NULL, NULL, NULL, '2023-06-10 00:43:09', '2023-11-22 13:15:29');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `periodes`
--
ALTER TABLE `periodes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `releveurs`
--
ALTER TABLE `releveurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `releve_plans`
--
ALTER TABLE `releve_plans`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `periodes`
--
ALTER TABLE `periodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `releveurs`
--
ALTER TABLE `releveurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `releve_plans`
--
ALTER TABLE `releve_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
