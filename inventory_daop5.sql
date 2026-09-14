-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2026 at 11:40 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_daop5`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--



-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `capacity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--



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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_10_075715_create_categories_table', 1),
(5, '2026_09_10_075715_create_locations_table', 1),
(6, '2026_09_10_075715_create_spare_parts_table', 1),
(7, '2026_09_10_075715_create_stock_movements_table', 1),
(8, '2026_09_11_061950_update_categories_table_add_icon_drop_status', 1),
(9, '2026_09_11_082018_add_image_to_spare_parts_table', 1);

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7pnWLE43KVYow3zm0j4isQTZiJM58WxQoqsktZi1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ5UGJ2Y1Y2TU9MQ2tZalFuS2xibXlRbW5paWo4TGxxQmd0MU44WlRLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJkYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1789126736);

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts`
--

CREATE TABLE `spare_parts` (
  `id` bigint UNSIGNED NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventory_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_parts`
--



-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint UNSIGNED NOT NULL,
  `spare_part_id` bigint UNSIGNED NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spare_parts_location_id_foreign` (`location_id`),
  ADD KEY `spare_parts_category_id_foreign` (`category_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_spare_part_id_foreign` (`spare_part_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `spare_parts`
--
ALTER TABLE `spare_parts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD CONSTRAINT `spare_parts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `spare_parts_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_spare_part_id_foreign` FOREIGN KEY (`spare_part_id`) REFERENCES `spare_parts` (`id`) ON DELETE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Data Diimpor dari CSV oleh AI --



-- Data Diimpor dari PDF oleh AI --



-- Data Diimpor dari CSV oleh AI --



-- Data Kategori --


-- Data Lokasi --


-- Data Spare Parts --





-- Data Kategori --


-- Data Lokasi --


-- Data Spare Parts --





-- Data Kategori --
INSERT INTO `categories` (`id`, `name`, `description`, `icon`, `created_at`, `updated_at`) VALUES 
(1, 'MONITOR', 'Kategori MONITOR', 'Box', NOW(), NOW()),
(2, 'PC', 'Kategori PC', 'Box', NOW(), NOW()),
(3, 'PRINTER', 'Kategori PRINTER', 'Box', NOW(), NOW()),
(4, 'SWITCH', 'Kategori SWITCH', 'Box', NOW(), NOW()),
(5, 'UPS', 'Kategori UPS', 'Box', NOW(), NOW()),
(6, 'AIO', 'Kategori AIO', 'Box', NOW(), NOW()),
(7, 'HARD DRIVE', 'Kategori HARD DRIVE', 'Box', NOW(), NOW());

-- Data Lokasi --
INSERT INTO `locations` (`id`, `name`, `description`, `status`, `capacity`, `created_at`, `updated_at`) VALUES 
(1, 'GUDANG IT', 'Lokasi Gudang Pusat IT', 'active', 500, NOW(), NOW());

-- Data Spare Parts --
INSERT INTO `spare_parts` (`category_id`, `location_id`, `brand`, `type`, `serial_number`, `inventory_number`, `description`, `condition`, `created_at`, `updated_at`) VALUES 
(1, 1, 'DELL', 'P2217H', 'CN-0M84D9-QDC00-85O-0P0L-A05', NULL, 'EX PUSDAL', 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203026799', 'IT.002.0522.1.B050.00013', 'GUDANG IT', 'Perbaikan', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '0190012203035022', NULL, 'GUDANG IT', 'Perbaikan', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '0190012203035188', NULL, 'GUDANG IT', 'Perbaikan', NOW(), NOW()),
(1, 1, 'LG', '20MK400A-B', '907INYD25010', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E1916H', 'CN-OJF27G-FCC00-7BN-DFJU-A04', 'IT.002.0119.2.B050.00001', 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'HP', '20WD', '3CQ53720MD', 'IT.002.0319.1.B050.00005', 'GUDANG IT', 'Perbaikan', NOW(), NOW()),
(1, 1, 'LG', '16M38A-B', '610INKH0Q221', NULL, 'IT PWT', 'Normal', NOW(), NOW()),
(1, 1, 'ACER', 'P166HQL', 'ETLTJ0D0101480D17A8501', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'SAMSUNG', 'B1630N', 'E688HRHZ205124Z', 'IT.002.1020.1.B050.00010', 'SDM', 'Normal', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM32530TQ', 'IT.102.1013.2.0043.5', 'EX JJ KB5', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E2020H', 'CN-07TR2H-QDC00-1BP-0URI-A06', NULL, 'EX KRV KA', 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '0190012203035014', 'IT.002.0522.1.B050.000E', 'EX LB6', 'Perbaikan', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203039065', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'HP', 'L2105TM', '4CU10500MQ', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'SAMSUNG', 'S16A100N', 'ZTP5H4L', 'IT.002.0123.1.B050.00001', 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'ACER', 'MONITOR V', 'URTYESD00541400C9B0601', 'IT.057.0824.6.A010.00132', 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203026765', 'IT.002.0522.1.B050.00014', 'EX ADM KRETEK', 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203036152', 'IT.002.0422.1.B050.00010', 'GUDANG IT', 'Perbaikan', NOW(), NOW()),
(1, 1, 'DELL', 'E1916HV', 'CN-0779TP-FCC00-7CD-ADNI-A04', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'VK706AV', 'SGH103S2XH', 'IT.001.0118.2.A010.00101', 'EX RESOR JJ PPK', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3330', 'SGH329TYLZ', 'IT.001.0218.2.A010.00237', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3330', 'SGH329TYKS', 'IT.001.0518.2.B050.00012', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'SBX380110710102', 'IT.001.0312.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3622L', '4CE1210M75', 'IT.001.0911.1.B080.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'ASUS', 'K30AD', 'E7PDCG000VH0', 'IT.005.0120.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'DELL', '', 'rakit4n', 'IT.001.0610.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'ACER', 'ASPIRE XC600', 'DTSLJSN002314023043000', 'IT.001.0418.1.B050.00014', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', '4CE0511B74', 'IT.001.0120.2.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', '4CE05006P5', 'IT.001.0211.1.B050.00007', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3330', 'SGH329TZB9', 'IT.001.0218.2.A010.00236', 'EX KDK KTA', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'Rakit', 'IT.001.1020.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'DELL', '', '36F8R42', 'IT.001.0119.2.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'RAKITAN52', 'IT.001.0918.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', '', 'SGH329TYZC', 'IT.001.0518.2.B050.00005', 'EX JJ KEBUMEN', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', '', 'CNX8141F5C', 'IT.001.0419.1.B050.00011', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3330', 'SGH329TYT9', 'IT.001.0218.2.A010.00020', 'EX KEUANGAN', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP 110 DESK PC SERIES', '4CE4130CVK', 'IT.005.0120.1.B050.00020', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3330', 'SGH329TZ1K', 'IT.001.0218.2.A010.00041', 'EX JJ PPK', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PRO 3005', 'SGH104T9FF', 'IT.001.0118.2.A010.00108', 'EX SDM', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', '4CE05119MQ', NULL, 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'ACER', 'ASPIRE XC600', 'DTSLJSN00231208FF43000', 'IT.001.1113.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'RAKITAN67', 'IT.001.0312.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PR0 3330', 'SGH329TYFW', 'IT.001.0218.2.A010.00034', 'SK 5.4 Krr', 'Rusak', NOW(), NOW()),
(2, 1, 'ACER', 'ASPIRE XC-605', 'DTSRPSN00235003F463000', 'IT.001.0120.1.B050.00002', 'EX TD KTA', 'Rusak', NOW(), NOW()),
(2, 1, 'ASUS', '', 'CCPDAG00082C', 'IT.005.1219.1.B050.00008', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3132L', 'CNX9370C27', 'IT.001.0318.1.B050.00001', 'EX SARPEN', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', 'CNX038052Y', 'IT.001.0221.1.B050.00045', 'EX KEUANGAN', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'a6630l', 'CNX8362WFH', 'IT.001.0318.1.B050.00017', 'KR LUAR', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3622L', '4CE1350F4K', 'IT.001.0318.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP PAVILION 500', '4CE43609M3', 'IT.001.1122.1.B050.00001', 'PBJ', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'RAK1T4N', 'IT.001.1110.1.B050.00004', 'EX YUDIS/SARANA', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'RAKITAN-IT-52', 'IT.001.0221.1.B050.00046', 'EX KEUANGAN', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', '', 'RAK1TAN', 'IT.001.0418.1.B050.00018', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', '4CE0511B2D', 'IT.001.1111.1.B050.00001', 'EX KTA', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3138L', 'CNX02106HV', 'IT.001.0918.1.B050.00007', 'EX KPT KTA', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3132L', 'CNX9370BP7', 'IT.001.0418.1.B050.00009', NULL, 'Rusak', NOW(), NOW()),
(2, 1, 'HP', '', 'SGH92004MQ', 'IT.001.0818.1.B050.00008', 'EX UNIT IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'p6000', 'CNX9300545', 'IT.001.1020.1.B050.00009', NULL, 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'CQ3320L', 'CNX0270295', 'IT.001.0318.1.B050.00010', 'EX UNIT IT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', '', 'CNX8141F6Z', 'IT.001.0318.1.B050.00015', 'EX OPERATOR PWT', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP Pro 3005 MT', 'SGH103S1FS', 'IT.001.0118.2.A010.00106', 'EX ADM PHENOM', 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'HP Pro 3005 MT', 'SGH103S25F', 'IT.001.0118.2.A010.00103', 'EX ADM PHENOM', 'Rusak', NOW(), NOW()),
(2, 1, 'ASUS', '', 'D2PDAG00027X', 'IT.001.0819.1.B050.00006', 'EX SARANA', 'Rusak', NOW(), NOW()),
(2, 1, 'RAKITAN', 'RAKIT', 'KOSONG1234', 'IT.001.0419.1.B050.00012', NULL, 'Rusak', NOW(), NOW()),
(2, 1, 'HP', 'a6630l', 'CNX8362WFR', NULL, NULL, 'Normal', NOW(), NOW()),
(2, 1, 'Dell', 'OPTIPLEX 3020', '73F8R42', 'IT.001.0819.2.A010.00049', NULL, 'Normal', NOW(), NOW()),
(2, 1, 'asus', '', 'D2PDAG0002DT', NULL, NULL, 'Normal', NOW(), NOW()),
(2, 1, 'Hp', 'CQ3321L', 'CNX03507V1', 'IT.005.0320.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(2, 1, 'Dell', 'OPTIPLEX 3020', '2GBDR42', 'IT.001.0119.2.B050.00001', 'Ex JJ PPK', 'Normal', NOW(), NOW()),
(2, 1, 'Dell', 'OPTIPLEX 3020', 'GR7HR42', 'IT.001.0119.2.B050.00005', 'Ex KNA', 'Normal', NOW(), NOW()),
(2, 1, 'Acer', 'ASPIRE M3970', NULL, 'IT.005.0120.1.B050.00008', 'Ex UK', 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'HP 110 DESK PC SERIES', '4CE4130CK2', NULL, 'Ex ADM KYA', 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'CQ3321L', '4CE05006JW', 'IT.001.0418.1.B050.00019', 'Ex TMS', 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'P2-1450d', '3CR3170SGH', NULL, 'Ex PPKA KTA', 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'p6130I', 'CNX932025F', 'IT.001.0120.1.B050.00006', 'Ex Crew KA CP3', 'Normal', NOW(), NOW()),
(2, 1, 'HP', '251-121d', '4CE54402DF', NULL, 'Ex POSKES CP', 'Normal', NOW(), NOW()),
(2, 1, 'HP', '251-122d', '4CE54905MG', 'IT.005.0620.1.B050.00004', 'Ex KNA', 'Normal', NOW(), NOW()),
(2, 1, 'Dell', 'OPTIPLEX 3020', '7XF7R42', 'IT.001.0918.2.B050.00005', 'Ex KNA', 'Normal', NOW(), NOW()),
(2, 1, 'Hp', '570-p033I', 'CNV748041T', 'IT.001.0418.1,B050.00005', 'Ex KNA', 'Normal', NOW(), NOW()),
(2, 1, 'Dell', '', NULL, 'IT.001.0918.2.B050.00004', 'STL 55 JRL', 'Normal', NOW(), NOW()),
(2, 1, '', '', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(2, 1, 'HP', 'p2-1450d', '3CR3170SGH', NULL, 'EX PPKA KTA', 'Rusak', NOW(), NOW()),
(2, 1, '3 POWER UP', '', 'RAKITAN-JJKM', 'IT.001.0722.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(2, 1, 'Dell', '', NULL, 'IT.001.0518.2.B050.00009', 'EX GOMBONG', 'Normal', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM3253HWY', 'IT.002.0118.2.A010.00277', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'E1916HV', 'CN-09YKV7-FCC00-763-DK7B-A00', 'IT.002.0312.1.B050.00004', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM325304J', 'IT.002.0518.2.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM3252YLV', 'IT.002.0118.2.A010.00267', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2F4B', 'IT.002.0211.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'LG', 'E1600SI', '104UXQA0C948', 'IT.002.1110.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM3253JCW', 'IT.002.0118.2.A010.00246', 'EX SINTEL KARANG SARI', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'W2072a', 'CNC314QPF1', 'IT.002.0119.1.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV2011', 'CNC644P3F1', 'IT.002.0610.1.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2DNB', 'IT.002.0818.2.B050.00004', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2ECB', 'IT.002.0918.2.B050.00004', 'EX KROYA', 'Rusak', NOW(), NOW()),
(1, 1, 'ACER', 'P166HQL', 'MMLTYSS002334026F34201', 'IT.002.0321.1.B050.00003', 'EX OP', 'Rusak', NOW(), NOW()),
(1, 1, 'ACER', 'P166HQL', 'ETLTJ0D010147066B18501', 'IT.002.0310.1.B050.00002', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2WBB', 'IT.002.1118.2.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV1911', '6CM3253061', 'IT.002.0118.2.A010.00278', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203044867\'', 'IT.002.1212.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'ACER', 'P166HQL', 'ETLTJ0D0102260C0258501', 'IT.002.0419.1.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'LG', 'W1643SV', '012INJL5Z764', 'IT.002.1120.1.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'LG', '19M38A', '212INSE3T622', 'IT.002.1112.1.B050.00005', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', 'LV1561w', 'CNC042PYR3', 'IT.002.1117.2.A010.00015', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', 'SM 19HD', 'IT.002.0209.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'ACER', '', '4712842088462\'', 'IT.002.0211.1.B050.00011', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'COMPAQ', '', 'CNC012PXTG', 'IT.002.1020.1.B050.00024', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', '', 'CN-0657PN-64180-552-0A5B', 'IT.002.1020.1.B050.00047', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'COMPAQ', '', 'CNC012Q0G6', 'IT.002.0318.1.B050.00007', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'ASUS', '', 'E4LMTF026456', 'IT.002.0711.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', '', '6CM32530J2', 'IT.002.0518.2.B050.00013', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'LENOVO', '', '4ML1489D43N0259', 'IT.002.0318.1.B050.00012', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', '', '6CM325312V', 'IT.002.1020.1.B050.00045', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'ACER', '', '4712842088462\'', 'IT.002.1110.1.B050.00003', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'COMPAQ', '', 'CNC003R8NJ', 'IT.002.0318.1.B050.00012', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'SPC', '', '190012203044891\'', 'IT.002.0208.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', '', '6CM3253HWT', 'IT.002.0118.2.A010.00260', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'SPC', '', '190012209040869\'', 'IT.002.0810.1.B050.00001', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'HP', '', '6CM3121NSV', 'IT.002.0118.2.A010.00269', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'SPC', '', '190012203033050\'', 'IT.002.0522.1.B050.00022', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, '', '', 'CNC102RNKG', 'IT.002.0118.2.A010.00018', 'GUDANG IT', 'Rusak', NOW(), NOW()),
(1, 1, 'DELL', 'P2217H', 'CN-0M84D9-QDC00-85O-0P0L-A05', NULL, 'EX PUSDAL', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2F8B', 'IT.002.0818.1.B050.00002', 'EX LOKET BMA', 'Normal', NOW(), NOW()),
(1, 1, 'HP', '19Ka', 'CNC62909Y8', 'IT.002.0319.1.B050.00006', 'EX JJ SLW', 'Normal', NOW(), NOW()),
(1, 1, 'LG', '20MK400A', '907INYD25010', NULL, 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E1914Hc', 'CN-0657PN-64180-525-2VBB', 'IT.002.0418.2.B050.00010', 'GUDANG IT', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E1916HI', 'CN-0DFDMY-72872-58U-C9DU-A00', NULL, 'EX KNA', 'Normal', NOW(), NOW()),
(1, 1, 'ACER', 'X163WL', 'ETLHZ0C001008130524003', 'IT.002.0819.1.B050.00006', 'EX KNA', 'Normal', NOW(), NOW()),
(1, 1, 'Dell', 'E1916HV', 'CN-0Y0YJ6-FCC00-827-A05U-A06', 'IT.002.1020.1.B050.00003', 'EX KNA', 'Normal', NOW(), NOW()),
(1, 1, 'Panasonic', 'TH-32L400G', 'TH-32L400GRB3320863', NULL, NULL, 'Normal', NOW(), NOW()),
(1, 1, 'Panasonic', 'TH-22E302G', 'TH-22E302G1708020625', NULL, NULL, 'Normal', NOW(), NOW()),
(1, 1, 'acer', 'P166HQL', 'MMLTYSS0025510EED84201', 'IT.002.1020.1.B050.00038', 'EX PUSDAL', 'Normal', NOW(), NOW()),
(1, 1, 'DELL', 'E1916HV', 'CN-0Y0YJ6-FCC00-827-A05U-A06', 'IT. 002.1020.1.B050.00003', 'EX KNA', 'Normal', NOW(), NOW()),
(1, 1, 'Dell', 'E2020H', 'CN-07TR2H-QDC00-31V-10XI-A09', 'IT.002.0226.1.B050.00002', 'EX RUANG SERAYU', 'Normal', NOW(), NOW()),
(1, 1, 'AEVISION', 'XR22PQR', '2310180840', 'IT. 002.0418.2.B050.00011', NULL, 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203026799', 'IT.002.0522.1.B050.00013', NULL, 'Normal', NOW(), NOW()),
(1, 1, 'HP', '', '6CM3253148', 'IT. 002.0226.1.B050.00001', 'EX STL 52 KRR', 'Normal', NOW(), NOW()),
(1, 1, 'ACER', 'K202HQL', 'MMT0CSS004842040B58509', 'IT.002.0419.1.B050.00011', NULL, 'Normal', NOW(), NOW()),
(1, 1, 'SPC', 'SM 19HD', '190012203036145', 'IT.002.0422.1.B050.00009', NULL, 'Normal', NOW(), NOW()),
(3, 1, 'EPSON', 'L210', 'RAEK224211', 'IT.067.0319.1.B050.00011', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'L210', 'RAEK192797', 'IT.067.0319.1.B050.00008', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'L3110', 'X5DX142257', 'IT.067.0819.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY440724', 'IT.067.0819.1.B050.00003', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'HP', 'DESKJET 2622', 'CN86M5B31206MD', 'IT.067.0918.1.B050.00002', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY281374', 'IT.067.0818.1.B050.00006', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'MP237', 'LTGE01764', 'IT.067.1020.1.B050.00028', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'MP237', 'LTGE21792', 'IT.067.1020.1.B050.00016', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'IP2770', 'C1HSFT15811M', 'IT.067.0119.1.B050.00016', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY381240', 'IT.067.0918.1.B050.00016', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'MP287', 'KLCA32847', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY228983', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY335215', 'IT.067.0118.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY066462', 'IT.067.0118.2.A010.00201', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY344074', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY072987', NULL, 'EX LOKET 4 PWT', 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'MP237', 'MP237KEU5PWT', 'IT.067.1120.1.B050.00003', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'BROTHER', 'DCP T710W', 'E78669H8H303015', 'IT.067.0419.1.B050.00005', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'G2000', 'VGEK069792', 'IT.067.0818.1.B050.00004', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'L5190', 'X5NZ022373', 'IT.067.1020.1.B050.00023', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY088976', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY065YW', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY070185', 'IT.067.0418.1.B050.00009', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY281410', 'IT.067.0318.1.B050.00004', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY205088', 'IT.067.0318.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY312406', 'IT.067.0222.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY091156', 'IT.067.0120.1.B050.00004', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-300+II', 'G8QY228335', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FYJ10362', 'IT.067.1022.1.B050.00021', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY420422', 'IT.067.0519.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CANON', 'iX6560', 'ACMR37081M', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'L120', 'TP2K460238', 'IT.067.0418.1.B050.00007', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'OKI', 'MICROLINE 320', 'GE7000BAK09050517H0', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'OKI', 'MICROLINE 320', NULL, 'IT.103.0000.1.00226.05', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY098520', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LX-310', 'Q7FY098528', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LQ-2190', 'MK4Y096579', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LQ-2190', 'MK4Y032536', 'IT.067.0118.2.A010.00043', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LQ-2190', 'MK4Y096667', 'IT.067.1113.2.A010.00003', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'EPSON', 'LQ-2090', 'FT8Y015108', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS5004815480391', 'IT.067.0518.1.B050.00003', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS5004815480386', 'IT.067.0818.1.B050.00007', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS9004019210117', 'IT.067.1021.1.B050.00001', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS7004317290294', 'IT.067.0518.1.B050.00023', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS6000216030629', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS9004419230378', 'IT.067.1220.1.B050.00012', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS7004317290299', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS5004815480371', 'IT.067.1120.1.A010.00025', 'EX LKT MAOS', 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS9004019210047', 'IT.067.1220.1.B050.00014', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'NEC', '', '2348012080410640\'', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'NEC', '', '2348012080410530\'', 'IT.067.0715.1.B080.00027', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'NEC', '', '2348012080410346\'', 'IT.067.1218.1.B050.00004', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'NEC', '', '2348012080410700\'', NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'JANZ', '', '3108180730', 'IT.067.1118.1.A010.00054', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'JANZ', '', '3108180545', 'IT.067.0419.1.A010.00020', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'JANZ', '', '706170071', 'IT.067.0318.1.A010.00059', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'JANZ', '', '1512210088', 'IT.067.1022.1.A010.00021', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'CUSTOM', 'KUBE II', 'SGS9004019210121', 'IT.067.1220.1.B050.00018', NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'FUJITSU', '', NULL, NULL, NULL, 'Rusak', NOW(), NOW()),
(3, 1, 'Canon', 'ip2770', 'HSFL26368', 'IT.067.1020.1.B050.00010', NULL, 'Normal', NOW(), NOW()),
(3, 1, 'Epson', 'L220', 'WN5P143142', 'IT.067.1020.1.B050.00021', NULL, 'Normal', NOW(), NOW()),
(3, 1, 'Epson', 'L550', 'S4RY000626', 'IT.067.0119.1.B050.00018', NULL, 'Normal', NOW(), NOW()),
(3, 1, 'Brother', 'DCP-T710W', 'E78669G8H128446', 'IT.067.0419.1.B050.00007', NULL, 'Normal', NOW(), NOW()),
(3, 1, 'Epson', 'L5190', 'X5NZ026482', 'IT.067.1020.1.B050.00013', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003173', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003171', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ALLIED TELESIS', 'AT-FSW708', '101400719', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217A314005940', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217A314004876', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003640', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217A314005948', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217A314005948', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003566', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003180', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003177', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003631', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'RAISECOM', 'ISCOM2008', '101600000010813227s00076', 'IT.016.0918.1.B050.00004', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ALLIED TELESIS', 'AT-GS900/16', 'A04357R133300079 A1', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'RAISECOM', 'ISCOM2008', '101600000010B113227S0022G', 'IT.016.0418.1.B050.00014', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'RAISECOM', 'ISCOM2008', '101600000010B13227S0004G', 'IT.016.0918.1.B050.00007', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016A', 'QS4V1G1000070', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2169670000564', 'IT.016.0418.1.B050.00009', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '219C964000070', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2167447001558', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2169670000193', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2201739000980', 'IT.016.0521.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1016D', '2141645000290', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008PE', '2147068000491', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016C', 'QS7P1H5000150', 'IT.016.0518.1.B050.00005', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2169670000196', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2158296003334', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2165188002528', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2169670000194', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2147071002169', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2159879001752', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2169670000199', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2167498001365', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SF1016DS', '2165188002526', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HPE 1420 24G', 'JH-017A', 'CN21GVH0D4', 'IT.016.0123.1.B050.00005', 'EX PBJ', 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '217C721003602', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '216C022000059', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '216B629001253', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '216C022000069', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', '216C022000068', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008PE', '2149576000327', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2147071002171', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '219C964000072', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1016D', '2141645000296', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '2147071002107', NULL, 'ada delay di port 5 dan 4', 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1024C', 'QS7Q1H3009653', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016C', 'QS7P204000684', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DES-1008A', 'R3UO1F6010846', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SF1005D', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DES-1008A', 'R3UO1F3011487', 'IT.016.0818.1.B050.00008', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SF1005D', '10B84510904', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008D', '218B241010270', 'IT.016.0519.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SF1008D', '13CA9504315', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG108E', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1008', '22244E1001668', 'IT.016.0223.1.B050.00014', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', '', 'J66933149', 'IT.016.0223.1.B050.00019', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'DS-3E0109P-E/M', 'J67198784', 'IT.016.0522.1.B050.00009', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'DS-3E0109P-E/M', 'J67198713', 'IT.016.0622.1.B050.00008', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'DS-3E0109P-E/M', 'J67198706', 'IT.016.0622.1.B050.00010', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'DS-3E0109P-E/M', 'J67198783', 'IT.016.0522.1.B050.00004', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', '', '265092509', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', '', '265280876', 'IT.016.1123.1.B050.00008', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', '', 'QX5R1G7000174', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'BLAZZ', '', 'BL1008P100820170290', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', '', '22182H2001414', 'IT.016.0122.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP LINK', 'TL-SG1016D(UN)', '22290A4001444', 'IT.016.0223.1.B050.00009', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016C', 'QS7P1I3000704', 'IT.016.1218.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'Allied Tellesys', 'AT 9000', 'A04760R142200261 A1', 'IT.016.0518.1.B050.00003', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HP', 'HPE 1420 24G/JG708B', 'CN8BGXW3VV', 'IT.016.0619.1.A010.00015', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP - LINK', 'TL-SG1024D(UN)', '22264U6000609', 'IT.016.0223.1.B050.00016', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', '', 'QS7Q1H3009653', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22244E1000807', 'IT.016.0621.1.B050.00003', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HP', 'HPE 1620 48G', 'CN87GNS040', 'IT.016.0619.1.A010.00018', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ARUBA', 'OC 1930-24GT-4GF', 'CN33KPD7F8', 'IT.016.0325.1.B050.00003', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ARUBA', 'IOn 1430 26G 2SFP', 'CN28L4C0LX', 'IT.016.1223.1.B050.00047', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ARUBA', 'OC 1930-24GT-4GF', 'CN33KPDBMW', 'IT.016.0325.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HP', 'HPE 1620 48G', 'CN78GNS0QF', 'IT.016.0619.1.A010.00019', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'ARUBA', 'IOn 1430 26G 2SFP', 'CN32L4C04G', 'IT.016.1224.1.B050.00010', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '2255934000615', NULL, 'JJ BMA (Hanya dusbox)', 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22244E1001623', 'IT.016.0223.1.B050.00004', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1016D', '22264B9001196', 'IT.016.0223.1.B050.00008', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1024D', '22264U6000611', 'IT.016.0223.1.B050.00017', 'masih di box', 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22244E1001671', 'IT.016.0223.1.B050.00015', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22244E1001670', 'IT.016.0223.1.B050.00005', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22251F4000151', 'IT.016.0223.1.B050.00002', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1016D', '22264B9001105', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016C', 'QS7P1HB000441', 'IT.016.0719.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'D-LINK', 'DGS-1016C', 'QS7P1HB000445', 'IT.016.0719.1.B050.00002', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SF1024D', '2172212006821', 'IT.016.0318.1.A010.00006', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22244E1000807', 'IT.016.1222.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'TP-LINK', 'TL-SG1008', '22044H6000040', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HP', 'HPE 1420 24G', 'CN21GXW1DK', 'IT.016.0422.1.B050.00003', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HP', 'HPE 1620 48G', 'CN87GNS0DL', 'IT.016.0619.1.A010.00017', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'Alied Telesis', 'AT-GS950/16', 'A04374R123100855 A1', NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265421265', 'IT.016.0624.1.B050.00030', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265421155', 'IT.016.0624.1.B050.00032', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265421157', 'IT.016.0624.1.B050.00033', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0106P-E/M', 'L02685878', 'IT.016.0823.1.B050.00006', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265223128', 'IT.016.1223.1.B050.00044', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265421226', 'IT.016.0624.1.B050.00029', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'HIKVISION', 'DS-3E0505P-E/M', '265283357', 'IT.016.1223.1.B050.00041', NULL, 'Normal', NOW(), NOW()),
(4, 1, 'Aruba', '7', NULL, NULL, NULL, 'Normal', NOW(), NOW()),
(4, 1, 'aruba', '', 'CN33KPDC5F', NULL, NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B2050A15894', 'IT.042.1121.1.B050.00008', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501180205026', 'IT.042.0318.1.B050.00002', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501173805659', NULL, 'sn sesuai dgn barang', 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501170914590', 'IT.042.0818.1.B050.00006', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX650LI-MS', NULL, NULL, 'sn dan inventaris mmg hilang', 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501170915626', 'IT.042.0222.1.B050.00005', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BV800I-MS', '9B1930A06326', 'IT.042.1122.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B2050A15735', 'IT.042.0222.1.B050.00006', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B2050A15676', 'IT.042.1121.1.B050.00003', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B1838A28556', 'IT.042.0319.1.B050.00037', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G51503968', 'IT.042.0319.1.B050.00048', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G51409556', NULL, 'sn sesuai dg barang', 'Perbaikan', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G51409560', NULL, 'sn sesuai dg barang', 'Perbaikan', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G51406447', NULL, 'sn sesuai dg barang', 'Perbaikan', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G52300016', NULL, 'sn sesuai dgn barang', 'Perbaikan', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B1838A28553', 'IT.042.0319.1.B050.00024', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B2050A15673', 'IT.042.1121.1.B050.00002', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B2050A15895', 'IT.042.1121.1.B050.00006', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B1839A15959', 'IT.042.0319.1.B050.00013', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'BX659LI-MS', '9B1838A28496', 'IT.042.0319.1.B050.00044', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501180204627', 'IT.042.1020.1.B050.00006', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '530501203406498', 'IT.042.0121.1.B050.00001', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700SFC', '508601140407649', NULL, 'sn sesuai dgn barang', 'Normal', NOW(), NOW()),
(5, 1, 'PROLINK', 'PRO700V', '508601140304812', 'IT.016.0418.1.B050.00007', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'ICA', 'CP700', '1C1G51406322', 'IT.042.0518.1.B050.00009', NULL, 'Normal', NOW(), NOW()),
(5, 1, 'APC', 'SC 1000', '5S1047T24453', NULL, NULL, 'Normal', NOW(), NOW()),
(5, 1, 'ICA', 'CE600', '1B1D11808627', 'IT.042.1218.1.B040.00006', NULL, 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '0', 'MP151W6E', NULL, 'IT.005.0418.1.B050.00008', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'C20-30', 'MP1522Q6', NULL, 'IT.005.0418.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240', '4WSWSF2', NULL, 'IT.005.0218.2.A010.00125', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', NULL, NULL, 'VS81018830VS1312C9EM', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240 AIO', '4W54TF2', NULL, 'IT.005.0218.2.A010.00124', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'F0BB00VYID', 'MP1522T8', NULL, 'IT.005.0818.1.B050.00006', 'Normal', NOW(), NOW()),
(6, 1, 'HP', 'HP ProOne 400 G2 20-in Non-Touch AiO', 'SGH611RG98', NULL, 'IT.005.0918.1.B050.00002', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'F0BB0088ID', 'MP09XTDC', NULL, 'IT.005.1123.1.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'QS00729801', NULL, 'IT.005.0418.1.B050.00006', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'C20-30', 'MP151W78', NULL, 'IT.005.0918.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'VS81018696', NULL, 'IT.005.0618.1.B050.00007', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'CS00925585', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'HP', '24-9027L', '8CC6200SH7', NULL, 'IT.005.0217.1.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Inspiron 3064 AIO', '2P63YH2', NULL, 'IT.005.0518.1.B050.00018', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'Lenovo C225', 'QS00729868', NULL, 'IT.005.0120.1.B050.00009', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'MP1FGEL2', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'MP1522TD', NULL, 'IT.005.0218.1.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'C20-30', 'MP151B0D', NULL, 'IT.005.0119.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '10147', 'VS81685887', NULL, 'IT.005.1219.1.B050.00011', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'C20-30', 'MP1518VT', NULL, 'IT.005.0418.1.B050.00003', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', '', 'VS8101868', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240', '4WT0TF2', NULL, 'IT.005.0218.2.A010.00123', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Inspiron 3064 AIO', '3G63YH2', NULL, 'IT.005.0618.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240 AIO', '4VNZSF2', NULL, 'IT.005.0218.2.A010.00095', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Inspiron 3264', '4XGVXH2', NULL, 'IT.005.0518.1.B050.00006', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240', '4XDYSF2', NULL, 'IT.005.0218.2.A010.00112', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240 AIO', '4WTYSF2', NULL, 'IT.005.0218.2.A010.00129', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Inspiron 3277 AIO', 'GPQBL42', NULL, 'IT.005.0818.1.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'HP', '20-C302D', '8CC91644ZS', NULL, 'IT.005.0519.1.A010.00014', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3030 AIO', 'DY51T92', NULL, 'IT.005.0819.2.A010.00010', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'OptiPlex 3240 AIO', '4TNZSF2', NULL, 'IT.005.0218.2.A010.00106', 'Normal', NOW(), NOW()),
(6, 1, 'ASUS', 'Vivo AIO 22 V222UA', 'JAPTCJ006741427', NULL, 'IT.005.0319.1.B050.00003', 'Normal', NOW(), NOW()),
(6, 1, 'HP', '', 'SGH551SZ1Z', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'asus', '', 'HCPTCJ045943', NULL, 'IT.005.0518.1.B050.00016', 'Normal', NOW(), NOW()),
(6, 1, 'dell', '', '4YF4TF2', NULL, 'IT.005.0218.2.A010.00146', 'Normal', NOW(), NOW()),
(6, 1, 'lenovo', '', NULL, NULL, 'IT.005.0418.1.B050.00007', 'Normal', NOW(), NOW()),
(6, 1, 'lenovo', '', 'VS81018739', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'hp', '', NULL, NULL, 'IT.005.0120.1.B050.00013', 'Normal', NOW(), NOW()),
(6, 1, 'lenovo', '', NULL, NULL, 'IT.005.0518.1.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'Dell', '', '4X51TF2', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'HP', '22-C0035D', '8CC90322S1', NULL, 'IT.005.0519.1.B050.00002', 'Normal', NOW(), NOW()),
(6, 1, 'Lenovo', 'C20-00', 'MP1522PD', NULL, 'IT.005.0418.1.B050.00005', 'Normal', NOW(), NOW()),
(6, 1, 'Dell', 'Inspiron 20-3064', '8L63YH2', NULL, 'IT.005.0518.1.B050.00008', 'Normal', NOW(), NOW()),
(6, 1, 'Lenovo', 'C20-30', 'MP05GYZZR', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '22-DD2010MD', '8CC24810MD', NULL, 'IT.005.0723.1.B050.00014', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '22-DD2010D', '8CC24810KL', NULL, 'IT.005.0723.1.B050.00008', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', 'E6D47AV', 'SGH341TJRN', NULL, 'IT.005.0318.2.B050.00001', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '24-DF1008D', '8CC10605TT', NULL, 'IT.005,0921.1.B050.00009', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Opti 3240 AIO', '4V82TF2', NULL, 'IT. 005.0218.2.A010.00118', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '24-f0051d', '8CC94533FV', NULL, 'IT.005.1020.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'HP', '24-df1008d', '8CC10605TT', NULL, 'IT. 005.0921.1.B050.00009', 'Normal', NOW(), NOW()),
(6, 1, 'LENOVO', 'F0BB', 'MP1522PD', NULL, 'IT.005.0418.1.B050.00005', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '22-c00311', '8CC9323RDR', NULL, 'IT.005.1219.1.B050.00004', 'Normal', NOW(), NOW()),
(6, 1, 'Hp', '22-dd2010d', '8CC24810LS', NULL, 'IT.005.0723.1.B050.00020', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'W29C001', NULL, NULL, 'IT. 005.1224.1.B050.00002', 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'Opti 3240 AIO', '4YHXSF2', NULL, NULL, 'Normal', NOW(), NOW()),
(6, 1, 'DELL', 'W21B001', NULL, NULL, 'IT. 005.0122.1.A010.00004', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', '', 'WFL18D2Y', NULL, 'Kapasitas: 2TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EZEX', 'WCC6Y0CZA6AZ', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', 'SkyHawk', 'Z9C1QM8J', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10PURX', 'WCC4J7XA3P57', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', 'Barracuda', 'Z9ASC89P', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', '', 'ZN12N1GJ', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '88J1773NS HJD', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '98M2L6WMS PKG', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '184K1JWNS HJD', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '88I06LLMS HJD', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '59KAES3MS FWC', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '59K7V0RMS FWC', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', 'Y88YAWVMS L1F', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '88IZUMENS HJD', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '88IZX9YNS HJD', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'TOSHIBA', 'DT01ACA100', '59K9VHPMS FWC', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', 'BARRACUDA', '26ESZ2E3', NULL, 'Kapasitas: 500GB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', 'BARRACUDA', 'ST500SM002', NULL, 'Kapasitas: 500GB', 'Normal', NOW(), NOW()),
(7, 1, 'SEAGATE', 'SURVEILLANCE', 'W513P3RJ', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EZEX', 'WCC3FHDLL9VV', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EZEX', 'WCC6Y1NJTL20', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EZEX', 'WCC6Y3KDL9UP', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EZEX', 'WCC6Y6NUY694', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EURX', 'WMC1U5758318', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EADS', 'WMAVU0364093', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW()),
(7, 1, 'Western Digital', 'WD10EURX', 'WMC1U8614399', NULL, 'Kapasitas: 1TB', 'Normal', NOW(), NOW());

COMMIT;
