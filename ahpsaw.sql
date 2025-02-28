-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2024 at 08:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahpsaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatives`
--

CREATE TABLE `alternatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `criteria_id` bigint(20) UNSIGNED NOT NULL,
  `criteria_sub_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `alternative_value` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alternatives`
--

INSERT INTO `alternatives` (`id`, `criteria_id`, `criteria_sub_id`, `student_id`, `kelas_id`, `alternative_value`, `created_at`, `updated_at`) VALUES
(30, 9, 32, 4, 1, 1, '2024-07-22 07:49:16', '2024-07-22 07:49:16'),
(31, 10, 33, 4, 1, 1, '2024-07-22 07:49:16', '2024-07-22 07:49:16'),
(32, 15, 38, 4, 1, 1, '2024-07-22 07:49:16', '2024-07-22 07:49:16'),
(33, 9, 30, 5, 2, 3, '2024-07-22 07:49:45', '2024-07-22 07:49:45'),
(34, 10, 35, 5, 2, 3, '2024-07-22 07:49:45', '2024-07-22 07:49:45'),
(35, 15, 40, 5, 2, 3, '2024-07-22 07:49:45', '2024-07-22 07:49:45'),
(36, 9, 28, 6, 3, 5, '2024-07-22 07:50:03', '2024-07-22 07:50:03'),
(37, 10, 37, 6, 3, 5, '2024-07-22 07:50:03', '2024-07-22 07:50:03'),
(38, 15, 43, 6, 3, 5, '2024-07-22 07:50:03', '2024-07-22 07:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE `criterias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `name`, `slug`, `kategori`, `keterangan`, `created_at`, `updated_at`) VALUES
(9, 'Pekerjaan Orang Tua', 'pekerjaan-orang-tua', 'BENEFIT', 'Pekerjaan orang tua mempengaruhi keputusan untuk menerima beasiswa', '2024-07-22 07:24:42', '2024-07-22 08:34:39'),
(10, 'Penghasilan Orang Tua', 'penghasilan-orang-tua', 'COST', 'Penghasilan orang tua tidak mempengaruhi keputusan untuk calon siswa penerima beasiswa', '2024-07-22 07:25:51', '2024-07-22 08:34:12'),
(15, 'Status Anak', 'status-anak', 'BENEFIT', 'Status anak akan mempengaruhi keputusan untuk menerima beasiswa', '2024-07-22 07:41:25', '2024-07-22 08:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_analyses`
--

CREATE TABLE `criteria_analyses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criteria_analyses`
--

INSERT INTO `criteria_analyses` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 1, '2024-07-22 08:35:02', '2024-07-22 08:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_analysis_details`
--

CREATE TABLE `criteria_analysis_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `criteria_analysis_id` bigint(20) UNSIGNED NOT NULL,
  `criteria_id_first` bigint(20) UNSIGNED NOT NULL,
  `criteria_id_second` bigint(20) UNSIGNED NOT NULL,
  `comparison_value` decimal(10,9) NOT NULL DEFAULT 1.000000000,
  `comparison_result` decimal(10,9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criteria_analysis_details`
--

INSERT INTO `criteria_analysis_details` (`id`, `criteria_analysis_id`, `criteria_id_first`, `criteria_id_second`, `comparison_value`, `comparison_result`, `created_at`, `updated_at`) VALUES
(59, 3, 9, 9, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(60, 3, 9, 10, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(61, 3, 9, 15, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(62, 3, 10, 9, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(63, 3, 10, 10, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(64, 3, 10, 15, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(65, 3, 15, 9, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(66, 3, 15, 10, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54'),
(67, 3, 15, 15, 1.000000000, 1.000000000, '2024-07-22 08:35:02', '2024-07-22 08:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_subs`
--

CREATE TABLE `criteria_subs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `criteria_id` bigint(20) UNSIGNED NOT NULL,
  `name_sub` varchar(100) NOT NULL,
  `value` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_subs`
--

INSERT INTO `criteria_subs` (`id`, `criteria_id`, `name_sub`, `value`, `created_at`, `updated_at`) VALUES
(28, 9, 'Karyawan Swasta', 5, '2024-07-22 07:30:01', '2024-07-22 07:30:01'),
(29, 9, 'Buruh', 4, '2024-07-22 07:30:24', '2024-07-22 07:30:24'),
(30, 9, 'Pedagang', 3, '2024-07-22 07:30:55', '2024-07-22 07:30:55'),
(31, 9, 'Nelayan', 2, '2024-07-22 07:31:27', '2024-07-22 07:31:27'),
(32, 9, 'Petani', 1, '2024-07-22 07:31:46', '2024-07-22 07:31:46'),
(33, 10, '< Rp. 1.000.000', 1, '2024-07-22 07:32:32', '2024-07-22 07:32:32'),
(34, 10, 'Rp. 1.000.000', 2, '2024-07-22 07:33:01', '2024-07-22 07:33:01'),
(35, 10, 'Rp. 1.500.000', 3, '2024-07-22 07:33:50', '2024-07-22 07:33:50'),
(36, 10, 'Rp. 2.000.000', 4, '2024-07-22 07:34:23', '2024-07-22 07:34:23'),
(37, 10, 'Rp. 5.000.000', 5, '2024-07-22 07:34:50', '2024-07-22 07:34:50'),
(38, 15, 'Yatim Piatu', 1, '2024-07-22 07:42:04', '2024-07-22 07:42:04'),
(39, 15, 'Yatim', 2, '2024-07-22 07:42:19', '2024-07-22 07:42:19'),
(40, 15, 'Piatu', 3, '2024-07-22 07:42:35', '2024-07-22 07:42:35'),
(42, 15, 'Disabilitas', 4, '2024-07-22 07:45:33', '2024-07-22 07:45:33'),
(43, 15, 'Migran', 5, '2024-07-22 07:46:28', '2024-07-22 07:46:28');

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
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas_name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'IX-A', 'ix-a', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(2, 'IX-B', 'ix-b', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(3, 'IX-C', 'ix-c', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(4, 'IX-D', 'ix-d', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(5, 'IX-E', 'ix-e', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(6, 'IX-F', 'ix-f', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(7, 'IX-G', 'ix-g', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(8, 'IX-H', 'ix-h', '2024-06-03 01:17:41', '2024-06-03 01:17:41'),
(9, 'IX-I', 'ix-i', '2024-06-03 01:17:41', '2024-06-03 01:17:41');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_07_121522_create_criterias_table', 1),
(6, '2023_05_07_163802_create_kelas_table', 1),
(7, '2023_05_07_174344_create_students_table', 1),
(8, '2023_05_08_030611_create_alternatives_table', 1),
(9, '2023_05_08_032021_create_criteria_analyses_table', 1),
(10, '2023_05_08_032110_create_criteria_analysis_details_table', 1),
(11, '2023_05_25_103913_create_priority_values_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priority_values`
--

CREATE TABLE `priority_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `criteria_analysis_id` bigint(20) UNSIGNED NOT NULL,
  `criteria_id` bigint(20) UNSIGNED NOT NULL,
  `value` decimal(10,9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priority_values`
--

INSERT INTO `priority_values` (`id`, `criteria_analysis_id`, `criteria_id`, `value`, `created_at`, `updated_at`) VALUES
(4, 3, 9, 0.333333333, '2024-07-22 08:35:32', '2024-07-22 08:36:54'),
(5, 3, 10, 0.333333333, '2024-07-22 08:35:32', '2024-07-22 08:36:54'),
(6, 3, 15, 0.333333333, '2024-07-22 08:35:32', '2024-07-22 08:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `nis` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `kelas_id`, `nis`, `name`, `gender`, `created_at`, `updated_at`) VALUES
(4, 1, 19010100, 'Anisa', 'Perempuan', '2024-07-22 07:47:40', '2024-07-22 07:47:52'),
(5, 2, 19010101, 'Malas Coding', 'Laki-laki', '2024-07-22 07:48:22', '2024-07-22 07:48:22'),
(6, 3, 190101021, 'Anunya', 'Laki-laki', '2024-07-22 07:48:52', '2024-07-22 07:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'USER',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Operator', 'adminer', 'admin@spk.com', NULL, '$2y$10$Ofu5vJX1hTZWD0Fa9GDC/.5JaorAb9fuIPgOdz4x9XDRyV1JCsj.e', 'ADMIN', NULL, '2024-06-03 01:17:41', '2024-06-03 01:17:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternatives_criteria_id_foreign` (`criteria_id`),
  ADD KEY `alternatives_student_id_foreign` (`student_id`),
  ADD KEY `alternatives_kelas_id_foreign` (`kelas_id`),
  ADD KEY `criteria_sub_id` (`criteria_sub_id`);

--
-- Indexes for table `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `criterias_name_unique` (`name`),
  ADD UNIQUE KEY `criterias_slug_unique` (`slug`);

--
-- Indexes for table `criteria_analyses`
--
ALTER TABLE `criteria_analyses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_analyses_user_id_foreign` (`user_id`);

--
-- Indexes for table `criteria_analysis_details`
--
ALTER TABLE `criteria_analysis_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_analysis_details_criteria_analysis_id_foreign` (`criteria_analysis_id`),
  ADD KEY `criteria_analysis_details_criteria_id_first_foreign` (`criteria_id_first`),
  ADD KEY `criteria_analysis_details_criteria_id_second_foreign` (`criteria_id_second`);

--
-- Indexes for table `criteria_subs`
--
ALTER TABLE `criteria_subs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelas_kelas_name_unique` (`kelas_name`),
  ADD UNIQUE KEY `kelas_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priority_values`
--
ALTER TABLE `priority_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priority_values_criteria_analysis_id_foreign` (`criteria_analysis_id`),
  ADD KEY `priority_values_criteria_id_foreign` (`criteria_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_nis_unique` (`nis`),
  ADD KEY `students_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `criteria_analyses`
--
ALTER TABLE `criteria_analyses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `criteria_analysis_details`
--
ALTER TABLE `criteria_analysis_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `criteria_subs`
--
ALTER TABLE `criteria_subs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priority_values`
--
ALTER TABLE `priority_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternatives`
--
ALTER TABLE `alternatives`
  ADD CONSTRAINT `alternatives_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alternatives_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alternatives_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `criteria_analyses`
--
ALTER TABLE `criteria_analyses`
  ADD CONSTRAINT `criteria_analyses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `criteria_analysis_details`
--
ALTER TABLE `criteria_analysis_details`
  ADD CONSTRAINT `criteria_analysis_details_criteria_analysis_id_foreign` FOREIGN KEY (`criteria_analysis_id`) REFERENCES `criteria_analyses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `criteria_analysis_details_criteria_id_first_foreign` FOREIGN KEY (`criteria_id_first`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `criteria_analysis_details_criteria_id_second_foreign` FOREIGN KEY (`criteria_id_second`) REFERENCES `criterias` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `criteria_subs`
--
ALTER TABLE `criteria_subs`
  ADD CONSTRAINT `fk_criteria_subs` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `priority_values`
--
ALTER TABLE `priority_values`
  ADD CONSTRAINT `priority_values_criteria_analysis_id_foreign` FOREIGN KEY (`criteria_analysis_id`) REFERENCES `criteria_analyses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `priority_values_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
