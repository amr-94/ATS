-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 11:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruiter2`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `current_stage` enum('applied','phone_screen','interview','hired','rejected') NOT NULL DEFAULT 'applied',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `candidate_id`, `cover_letter`, `current_stage`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 4, 2, 'I am very interested in this position...', 'interview', NULL, '2025-09-16 16:11:06', '2025-09-16 16:57:38'),
(5, 6, 3, 'dasda', 'phone_screen', NULL, '2025-09-17 17:43:17', '2025-09-17 18:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `application_stage_transitions`
--

CREATE TABLE `application_stage_transitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `from_stage` varchar(255) DEFAULT NULL,
  `to_stage` varchar(255) NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_stage_transitions`
--

INSERT INTO `application_stage_transitions` (`id`, `application_id`, `from_stage`, `to_stage`, `changed_by`, `notes`, `created_at`, `updated_at`) VALUES
(5, 3, 'hired', 'interview', NULL, 'Candidate performed well in technical interview', '2025-09-16 16:51:06', '2025-09-16 16:51:06'),
(6, 3, 'interview', 'interview', 1, 'Candidate performed well in technical interview', '2025-09-16 16:51:47', '2025-09-16 16:51:47'),
(7, 3, 'interview', 'hired', 1, 'Candidate performed well in technical interview', '2025-09-16 16:55:41', '2025-09-16 16:55:41'),
(8, 3, 'hired', 'interview', 1, 'Candidate performed well in technical interview', '2025-09-16 16:57:38', '2025-09-16 16:57:38'),
(9, 3, 'interview', 'interview', 1, 'Candidate performed well in technical interview', '2025-09-16 16:57:40', '2025-09-16 16:57:40'),
(10, 5, 'applied', 'phone_screen', 2, 'اتصلت عليه', '2025-09-17 17:44:16', '2025-09-17 17:44:16'),
(11, 5, 'phone_screen', 'applied', 2, 'رجع تانى', '2025-09-17 17:46:34', '2025-09-17 17:46:34'),
(12, 5, 'applied', 'phone_screen', 2, 'هتصل عليه', '2025-09-17 18:15:38', '2025-09-17 18:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `email`, `password`, `phone`, `resume_path`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'amr condidate', 'amr@yahoo.com', '$2y$12$x0YmyU3sZ1er3snGbGn0.OvY2vG2qLc9ETHzWJJDiHU6XqCoyWg/K', '010', 'Candidate/BNabrG7kcMPCRANB9FkeVjSvF241RAnoGIU0Avjh.jpg', NULL, '2025-09-15 17:48:09', '2025-09-16 15:56:43'),
(3, 'Candidate 5eqweqw', 'Candidate5@yahoo.com', '$2y$12$Nvb7wpSps.IBBJ46TN50nesljDBwKkr3gzhWA4wIyMbmL9YoYukAS', '01032360685', 'candidates/resumes/5cmbHqyl19xy9cKMwr1j7tNlWshfeEu3nID4PRE0.pdf', NULL, '2025-09-17 17:11:29', '2025-09-17 18:08:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_15_185334_create_personal_access_tokens_table', 1),
(5, '2025_09_15_185744_create_recuiters_table', 1),
(6, '2025_09_15_185849_create_candidates_table', 1),
(7, '2025_09_15_185951_create_recuiterjobs_table', 1),
(8, '2025_09_15_190028_create_applications_table', 1),
(9, '2025_09_15_190106_create_application_stage_transitions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\Recruiter', 1, 'api-token', 'f280a5c6866e77742bb2e42ccd905953ddfa5bfbd4dad39cebffe46c64a0c7a5', '[\"*\"]', '2025-09-16 16:58:58', NULL, '2025-09-15 17:29:48', '2025-09-16 16:58:58'),
(3, 'App\\Models\\Candidate', 1, 'api-token', '32a346d0da9f38e1b8fc2aeb82dd6dd5ca5f76d4381f73b59c1092a9f0de68ff', '[\"*\"]', NULL, NULL, '2025-09-15 17:35:15', '2025-09-15 17:35:15'),
(4, 'App\\Models\\Candidate', 1, 'api-token', 'b381ef60b43c91f594d7f2fb143f7cc90353806c403153f388fb96ae63f36335', '[\"*\"]', '2025-09-15 17:43:30', NULL, '2025-09-15 17:37:54', '2025-09-15 17:43:30'),
(5, 'App\\Models\\Candidate', 2, 'api-token', 'cc0bf7e17182d3d4de082616e2c95380f4cb2d0a1f6f255e7732872bb12046cf', '[\"*\"]', NULL, NULL, '2025-09-15 17:48:09', '2025-09-15 17:48:09'),
(6, 'App\\Models\\Candidate', 2, 'api-token', 'e7dbc4d78e6f6d21d7703288c9b1874305f17f34db36eeaac97179079ffeaf98', '[\"*\"]', '2025-09-16 16:11:06', NULL, '2025-09-15 17:48:32', '2025-09-16 16:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `recuiterjobs`
--

CREATE TABLE `recuiterjobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recruiter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('draft','open','closed') NOT NULL DEFAULT 'open',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recuiterjobs`
--

INSERT INTO `recuiterjobs` (`id`, `recruiter_id`, `title`, `description`, `location`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 1, 'Front end Developer', 'We are looking for a senior developer', 'On site', 'open', NULL, '2025-09-16 16:04:26', '2025-09-16 16:08:35'),
(5, 2, 'jop 1', 'asdasdasd', 'asd', 'closed', '2025-09-17 17:03:28', '2025-09-17 17:02:03', '2025-09-17 17:03:28'),
(6, 2, 'jop new', 'dasdasdas', 'das', 'open', NULL, '2025-09-17 17:06:47', '2025-09-17 17:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `recuiters`
--

CREATE TABLE `recuiters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recuiters`
--

INSERT INTO `recuiters` (`id`, `name`, `email`, `password`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Amr Recruiter', 'recruiter@test.com', '$2y$12$B2G4b6ZaqZFyXUtPT9iOS.cDtljpdc13YIWwJ9kVkArkxRZUdiLqe', NULL, '2025-09-15 17:23:11', '2025-09-16 16:42:46'),
(2, 'Recruiter  3', 'Recruiter3@yahoo.com', '$2y$12$f7aRoIW1EtlK4ErvvCQ83.Kh4twyU3cWtweVp1/RZJds94m1lHH4W', NULL, '2025-09-17 16:39:42', '2025-09-17 16:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('xin6t0gLdBrYgrVFdF8iX4tr4hrJPPSppZAEeJBn', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGZHTGllY1RkazJWMktKRTBkY3ZKNWVUSzJlNnhwWmN6T2VkTTF0bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYW5kaWRhdGUvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2MDoibG9naW5fY2FuZGlkYXRlLXdlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1758143368),
('ZAavLlq0Vgy9XorWiHUczX1Kjo7psiUNiGJZK42Q', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzhNRnYzQzhvdVRONlFnMWVqTURSUHV0SDY5eUlIN3pmekpkdjZQMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWNydWl0ZXIvYXBwbGljYXRpb25zLzUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjYwOiJsb2dpbl9yZWNydWl0ZXItd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1758144232);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_jobs_id_foreign` (`job_id`),
  ADD KEY `applications_candidate_id_foreign` (`candidate_id`);

--
-- Indexes for table `application_stage_transitions`
--
ALTER TABLE `application_stage_transitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_stage_transitions_application_id_foreign` (`application_id`),
  ADD KEY `application_stage_transitions_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidates_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `recuiterjobs`
--
ALTER TABLE `recuiterjobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recuiterjobs_recruiter_id_foreign` (`recruiter_id`);

--
-- Indexes for table `recuiters`
--
ALTER TABLE `recuiters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recuiters_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `application_stage_transitions`
--
ALTER TABLE `application_stage_transitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recuiterjobs`
--
ALTER TABLE `recuiterjobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recuiters`
--
ALTER TABLE `recuiters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_candidate_id_foreign` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_jobs_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `recuiterjobs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_stage_transitions`
--
ALTER TABLE `application_stage_transitions`
  ADD CONSTRAINT `application_stage_transitions_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_stage_transitions_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `recuiters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recuiterjobs`
--
ALTER TABLE `recuiterjobs`
  ADD CONSTRAINT `recuiterjobs_recruiter_id_foreign` FOREIGN KEY (`recruiter_id`) REFERENCES `recuiters` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
