-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2025 at 11:20 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinetech`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tmdb_id` int NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `tmdb_id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(3, 1, 1423, 'movie', 'Iste sint saepe delectus voluptas minima recusandae iure autem enim ipsum veritatis beatae veritatis est aut accusantium.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(5, 1, 7089, 'tv', 'Eos quisquam in qui id ad ea quo nam dolore minima.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(7, 1, 7712, 'tv', 'Omnis aut et quia nihil ea dolores consequatur est fugiat veritatis aspernatur.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(8, 1, 4403, 'movie', 'Quia est voluptatem sed omnis enim accusamus quis.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(10, 1, 8424, 'tv', 'Sed fugit velit pariatur voluptas ratione asperiores cupiditate sed occaecati optio modi incidunt cumque eaque tenetur.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(11, 1, 9875, 'movie', 'Molestiae architecto fugit odit molestiae laboriosam doloremque sit neque modi labore error quam rerum veritatis.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(14, 1, 1548, 'tv', 'Autem porro et pariatur eligendi blanditiis est ex eius deserunt deleniti.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(15, 1, 7180, 'tv', 'Quos sequi facilis facere est autem cumque sequi sed qui facilis rem delectus aliquam ratione.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(16, 1, 1363, 'movie', 'Rerum occaecati est saepe rerum doloremque ratione voluptatem nihil non non ea nemo laborum quos.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(17, 1, 7462, 'movie', 'Illum totam est rerum optio sunt in dolore illum non iusto facere repellendus modi consequatur.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(18, 1, 367, 'tv', 'Sint rerum exercitationem aut architecto nostrum sit amet quia sed optio doloremque.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(19, 1, 4999, 'tv', 'Nemo officia quas optio molestiae sed laborum atque in iure aperiam.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(20, 1, 8301, 'tv', 'Praesentium animi omnis recusandae blanditiis quasi voluptatem provident vel nostrum.', '2025-04-28 15:51:18', '2025-04-28 15:51:18'),
(21, 1, 950387, 'movie', 'dsqdqs', '2025-04-28 15:51:24', '2025-04-28 15:51:24'),
(22, 1, 1233069, 'movie', 'sqdsqdsqdsq', '2025-05-03 07:34:59', '2025-05-03 07:34:59'),
(23, 1, 1233069, 'movie', 'dqsdsqdsq', '2025-05-03 07:39:16', '2025-05-03 07:39:16'),
(31, 1, 13945, 'tv', 'ddsqdsq', '2025-05-03 08:32:05', '2025-05-03 08:32:05'),
(35, 1, 986717, 'movie', 'sfdfgd\nd', '2025-05-03 08:40:53', '2025-05-03 08:40:53'),
(36, 1, 986717, 'movie', 'dqsdsq', '2025-05-03 08:40:55', '2025-05-03 08:40:55'),
(37, 1, 986717, 'movie', 'gsfsdfdsfd', '2025-05-03 08:40:57', '2025-05-03 08:40:57'),
(38, 1, 986717, 'movie', 'dqsdsqdd', '2025-05-03 08:41:00', '2025-05-03 08:41:00'),
(39, 1, 13945, 'tv', 'qdsqdsqdqs', '2025-05-03 08:41:42', '2025-05-03 08:41:42'),
(40, 1, 13945, 'tv', 'dqsdsqsddqs', '2025-05-03 08:41:44', '2025-05-03 08:41:44'),
(41, 1, 13945, 'tv', 'dsqsdqdqsdqs', '2025-05-03 08:41:46', '2025-05-03 08:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_05_085120_create_comments_table', 1),
(6, '2025_04_27_102635_add_is_admin_to_users_table', 1),
(7, '2025_04_28_145742_drop_favorites_table', 1),
(8, '2024_05_01_000000_remove_parent_id_from_comments', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Arthur', 'arthur.descourvieres@gmail.com', '2025-04-28 15:51:18', '$2y$12$NpXBudxpPqvDBTTfPl7nkONW/e8W.4X0NYYoH6s1VEBKF9GQnBzfW', 1, '8i1pDmIbN4', '2025-04-28 15:51:18', '2025-04-28 15:51:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
