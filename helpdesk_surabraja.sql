-- phpMyAdmin SQL Dump (FIXED FOR AIVEN)
-- Compatible with sql_require_primary_key = ON

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

--
-- Database: `helpdesk_surabraja`
--

-- --------------------------------------------------------
-- Table: jobs
-- --------------------------------------------------------

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: migrations
-- --------------------------------------------------------

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_11_03_132249_create_jobs_table', 1),
(3, '2025_11_17_085559_add_foto_to_laporan_table', 2),
(4, '2025_11_17_093213_add_foto_to_reports_table', 3);

-- --------------------------------------------------------
-- Table: personal_access_tokens
-- --------------------------------------------------------

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index`
    (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: reports
-- --------------------------------------------------------

CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelapor` varchar(255) DEFAULT NULL,
  `departemen` varchar(255) DEFAULT NULL,
  `tanggal_laporan` date DEFAULT NULL,
  `jenis_masalah` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('Baru','Sedang Dikerjakan','Selesai') DEFAULT 'Baru',
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `catatan_teknisi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `reports`
(`id`, `nama_pelapor`, `departemen`, `tanggal_laporan`,
 `jenis_masalah`, `deskripsi`, `status`, `foto`,
 `tanggal_selesai`, `catatan_teknisi`, `created_at`, `updated_at`)
VALUES
(5, 'hafidz ariff', 'IT', '2025-11-17', 'Troubleshooting/Helpdesk',
 'kerusakan pc', 'Sedang Dikerjakan',
 '1763348292-WhatsApp Image 2025-11-12 at 11.53.32.jpeg',
 NULL, NULL, '2025-11-17 02:58:12', '2025-11-17 03:25:37'),
(6, 'Pipit', 'Produksi', '2025-11-17', 'Troubleshooting/Helpdesk',
 'adada', 'Baru', NULL, NULL, NULL,
 '2025-11-17 03:25:55', '2025-11-17 03:25:55'),
(7, 'Pipit', 'Keuangan', '2025-11-17', 'Instalasi Software',
 'ada', 'Selesai', NULL, '2025-11-17', NULL,
 '2025-11-17 03:57:13', '2025-11-17 03:57:25');

COMMIT;
