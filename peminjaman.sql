-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2024 at 02:25 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `building_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkfloor` tinyint(1) NOT NULL,
  `floor` int(11) NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `building_name`, `checkfloor`, `floor`, `thumbnail`, `created_at`, `updated_at`, `id_user`) VALUES
(1, 'GEDUNG KULIAH BERSAMA MERAH PUTIH A', 0, 6, 'building_images/1705047433_download (1).jpeg', '2024-01-08 05:43:26', '2024-01-12 08:17:13', 3);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_of_department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `head_of_department`, `created_at`, `updated_at`, `faculty_id`) VALUES
(1, 'Teknik Sipil', 'Kaprodi', NULL, NULL, 4),
(2, 'Teknik Informatika', 'Kaprodi', NULL, NULL, 4),
(3, 'Pend. Matematika', 'Kaprodi', NULL, NULL, 1),
(4, 'Pend. Fisika', 'Kaprodi', NULL, NULL, 1),
(5, 'Pend. Kimia', 'Kaprodi', NULL, NULL, 1),
(6, 'Pend. Biologi', 'Kaprodi', NULL, NULL, 1),
(7, 'Pend. Teknik Mesin', 'Kaprodi', NULL, NULL, 1),
(8, 'Pendidikan Teknik Bangunan', 'Kaprodi', NULL, NULL, 1),
(9, 'Pend. Pancasila & Kewarganegaraan (PPKN)', 'Kaprodi', NULL, NULL, 1),
(10, 'Pend. Ekonomi', 'Kaprodi', NULL, NULL, 1),
(11, 'Pend. Bahasa Inggris', 'Kaprodi', NULL, NULL, 1),
(12, 'Pend. Bahasa, Sastra Indonesia & Daerah', 'Kaprodi', NULL, NULL, 1),
(13, 'Pend. Guru Sekolah Dasar (PGSD)', 'Kaprodi', NULL, NULL, 1),
(14, 'Pend. Jasmani, Kesehatan dan Rekreasi', 'Kaprodi', NULL, NULL, 1),
(15, 'Pend. Guru Pend Anak Usia Dini (PG PAUD)', 'Kaprodi', NULL, NULL, 1),
(16, 'Pend. Luar Sekolah', 'Kaprodi', NULL, NULL, 1),
(17, 'Bimbingan dan Konseling', 'Kaprodi', NULL, NULL, 1),
(18, 'Teknologi Pendidikan', 'Kaprodi', NULL, NULL, 1),
(19, 'Manajemen Pendidikan', 'Kaprodi', NULL, NULL, 1),
(20, 'Pendidikan Sendratasik', 'Kaprodi', NULL, NULL, 1),
(21, 'Ekonomi Pembangunan', 'Kaprodi', NULL, NULL, 2),
(22, 'Manajemen', 'Kaprodi', NULL, NULL, 2),
(23, 'Akuntansi', 'Kaprodi', NULL, NULL, 2),
(24, 'Magister Ilmu Ekonomi', 'Kaprodi', NULL, NULL, 2),
(25, 'Magister Manajemen', 'Kaprodi', NULL, NULL, 2),
(26, 'Magister Akuntansi', 'Kaprodi', NULL, NULL, 2),
(27, 'Doktor Ilmu Manajemen', 'Kaprodi', NULL, NULL, 2),
(28, 'Ilmu Sosial Ekonomi Pertanian (Agribisnis)', 'Kaprodi', NULL, NULL, 3),
(29, 'Manajemen Sumberdaya Perairan', 'Kaprodi', NULL, NULL, 3),
(30, 'Budidaya Perairan', 'Kaprodi', NULL, NULL, 3),
(31, 'Agroteknologi', 'Kaprodi', NULL, NULL, 3),
(32, 'Kehutanan', 'Kaprodi', NULL, NULL, 3),
(33, 'Teknologi Hasil Perikanan', 'Kaprodi', NULL, NULL, 3),
(34, 'Peternakan', 'Kaprodi', NULL, NULL, 3),
(35, 'Teknologi Industri Pertanian', 'Kaprodi', NULL, NULL, 3),
(37, 'Arsitektur', 'Kaprodi', NULL, NULL, 4),
(38, 'Teknik Pertambangan', 'Kaprodi', NULL, NULL, 4),
(39, 'Ilmu Hukum', 'Kaprodi', NULL, NULL, 5),
(40, 'Magister Ilmu Hukum', 'Kaprodi', NULL, NULL, 5),
(41, 'Sosiologi', 'Kaprodi', NULL, NULL, 6),
(42, 'Ilmu Administrasi Negara', 'Kaprodi', NULL, NULL, 6),
(43, 'Ilmu Pemerintahan', 'Kaprodi', NULL, NULL, 6),
(44, 'Kedokteran', 'Kaprodi', NULL, NULL, 7),
(45, 'Teknologi Laboratorium Medis', 'Kaprodi', NULL, NULL, 7),
(46, 'Fisika', 'Kaprodi', NULL, NULL, 8),
(47, 'Kimia', 'Kaprodi', NULL, NULL, 8),
(48, 'Biologi', 'Kaprodi', NULL, NULL, 8),
(49, 'Matematika', 'Kaprodi', NULL, NULL, 8),
(50, 'Farmasi', 'Kaprodi', NULL, NULL, 8),
(51, 'Magister Pendidikan Bahasa Inggris', 'Kaprodi', NULL, NULL, 9),
(52, 'Magister Pendidikan Biologi', 'Kaprodi', NULL, NULL, 9),
(53, 'Magister Pendidikan Dasar', 'Kaprodi', NULL, NULL, 9),
(54, 'Magister Pendidikan Ekonomi', 'Kaprodi', NULL, NULL, 9),
(55, 'Magister Pendidikan Ilmu Pengetahuan Sosial', 'Kaprodi', NULL, NULL, 9),
(56, 'Magister Pendidikan Kimia', 'Kaprodi', NULL, NULL, 9),
(57, 'Magister Pendidikan Luar Sekolah', 'Kaprodi', NULL, NULL, 9),
(58, 'Magister Pengelolaan Sumberdaya Alam Dan Lingkungan', 'Kaprodi', NULL, NULL, 9),
(59, 'Magister Perencanaan Wilayah Dan Kota', 'Kaprodi', NULL, NULL, 9),
(60, 'Doktor Program Doktor Ilmu Lingkungan', 'Kaprodi', NULL, NULL, 9),
(61, 'Magister Kehutanan', 'Kaprodi', NULL, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dekan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `dekan`, `created_at`, `updated_at`) VALUES
(1, 'FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN', 'Dr Rinto Alexandro', NULL, NULL),
(2, 'FAKULTAS EKONOMI DAN BISNIS', 'Prof. Dr. Danes Jaya Negara, SE. M.Si., C.EIA', NULL, NULL),
(3, 'FAKULTAS PERTANIAN', 'Ir. Wilson, M.Si', '2024-01-08 05:42:11', '2024-01-12 08:26:44'),
(4, 'FAKULTAS TEKNIK', 'Frieda, S.T., M.T.', NULL, NULL),
(5, 'FAKULTAS HUKUM', 'Dr. H. Suriansyah Murhaini, SH, MH,', NULL, NULL),
(6, 'FAKULTAS ILMU SOSIAL DAN ILMU POLITIK', 'Bhayu Rama, S.T., M.B.A., Ph.D,', NULL, NULL),
(7, 'FAKULTAS KEDOKTERAN', 'Prof. Dr. dr. Syamsul Arifin', NULL, NULL),
(8, 'FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM', 'Dr. Siti Sunariyati, M.Si.', NULL, NULL),
(9, 'PASCASARJANA ', 'Prof. Dr. I Nyoman Sudyana, M.Sc.', NULL, NULL),
(10, 'BAAK', 'BAAK', '2024-01-12 08:26:55', '2024-01-12 08:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_06_26_150056_create_departments_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_06_27_023204_create_rooms_table', 1),
(7, '2023_06_27_043925_create_room_images_table', 1),
(8, '2023_06_28_015833_create_room_reservations_table', 1),
(9, '2023_06_28_081839_add_status_column_to_room_reservation_table', 1),
(10, '2023_06_28_104719_add_column_key_status_to_room_reservations_table', 1),
(11, '2023_06_29_072013_add_role_column_to_users_table', 1),
(12, '2023_06_30_011044_add_ownership_column_to_rooms_table', 1),
(13, '2023_07_01_010004_add_signature_column_to_users_table', 1),
(14, '2023_07_01_070955_add_officer_column_to_room_reservations_table', 1),
(15, '2023_07_17_142719_add_note_column_to_room_reservations_table', 1),
(16, '2023_07_19_172511_create_social_accounts_table', 1),
(17, '2023_11_22_145401_create_tahun_ajaran_table', 1),
(18, '2023_11_22_155335_rename_tahun_ajaran_table', 1),
(19, '2023_11_22_193756_change_defaul_value', 1),
(20, '2023_11_22_225448_create_sessions_table', 1),
(21, '2023_11_23_155543_add_sks_to_roomreservations_table', 1),
(22, '2023_11_23_213729_alter_table_room_reservations_change_start_time', 1),
(23, '2023_11_24_202903_add_column_to_table_tahun_ajarans', 1),
(24, '2023_11_24_234012_add_start_time_foreign_key_to_room_reservations_table', 1),
(25, '2023_11_27_182203_add_recurring_to_room_reservations_table', 1),
(26, '2023_11_27_185042_alter_table_room_reservations_change_recurring', 1),
(27, '2023_11_28_122420_create_buildings_table', 1),
(28, '2023_12_01_162526_add_building_id_to_rooms', 1),
(29, '2023_12_01_192604_add_conditional_to_room_reservation', 1),
(30, '2023_12_01_195903_change_default_value_to_recurring', 1),
(31, '2023_12_01_200037_change_default_value_to_recurring2', 1),
(32, '2023_12_02_003432_add_termohon_to_room_reservation', 1),
(33, '2023_12_03_031641_change_status_value_to_room_reservations', 1),
(34, '2023_12_04_013102_add_dokumen_to_users_table', 1),
(35, '2023_12_06_161429_alter_recurring_to_room_reservation', 1),
(36, '2023_12_06_164015_add_column_to_room_reservation', 1),
(37, '2023_12_06_173014_add_value_to_role_users', 1),
(38, '2023_12_06_173658_add_id_gedung_to_building', 1),
(39, '2023_12_13_194555_add_dosen_to_room_reservations', 1),
(40, '2023_12_15_051239_create_table_faculties', 1),
(41, '2023_12_15_060832_add_faculty_id_to_department', 1),
(42, '2023_12_15_061724_add_faculty_id_to_users', 1),
(43, '2023_12_15_061906_add_value_to_role_users', 1),
(44, '2023_12_15_204617_add_faculty_id_to_rooms', 1),
(45, '2023_12_21_024506_drop_column_faculty_id_from_rooms', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `building_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `thumbnail`, `capacity`, `location`, `availability`, `created_at`, `updated_at`, `building_id`) VALUES
(1, 'Ruang Studio Podcast', 'Gedung merah putih memiliki : lorem ipsum', 'room_images/1699498070_sosialiasasi.jpg', 6, 'Lantai 1', 1, '2024-01-08 05:20:01', '2024-01-12 07:46:30', 1),
(2, 'Ruang Kuliah Teater 2', 'asdasdasd', 'room_images/1704692631_download.jpeg', 56, 'Lantai 1', 1, '2024-01-08 05:43:51', '2024-01-12 13:07:05', 1),
(3, 'Ruang Kuliah Teater 1', 'asdsads', 'room_images/1705046027_upr.png', 56, 'Lantai 1', 0, '2024-01-08 06:11:51', '2024-01-12 13:53:49', 1),
(4, 'Ruang Daring', 'ruang daring', 'room_images/1705045866_ruang.jpeg', 3, 'Lantai 1', 1, '2024-01-12 07:50:21', '2024-01-12 13:53:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_reservations`
--

CREATE TABLE `room_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_date` date NOT NULL,
  `start_time` bigint(20) UNSIGNED DEFAULT 12,
  `end_time` time NOT NULL,
  `necessary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `guarantee` enum('ktp','ktm') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','not approved','cancelled','wait','returned','reschedule','opened','off-day') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `key_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clean_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logistic_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etc_officer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note_admin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sks` tinyint(4) NOT NULL,
  `recurring` date DEFAULT NULL,
  `conditional` tinyint(1) DEFAULT 0,
  `termohon` int(11) DEFAULT NULL,
  `recurring_time` bigint(20) DEFAULT NULL,
  `dosen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_reservations`
--

INSERT INTO `room_reservations` (`id`, `user_id`, `room_id`, `reservation_date`, `start_time`, `end_time`, `necessary`, `guarantee`, `created_at`, `updated_at`, `status`, `key_status`, `building_officer`, `security_officer`, `clean_officer`, `logistic_officer`, `etc_officer`, `note`, `note_admin`, `sks`, `recurring`, `conditional`, `termohon`, `recurring_time`, `dosen`) VALUES
(1, 1, 1, '2024-01-08', 1, '09:15:00', 'kuliah AI', 'ktp', '2024-01-08 05:47:04', '2024-01-08 06:04:29', 'approved', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tahun_ajaran` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` time NOT NULL,
  `mon` tinyint(1) NOT NULL DEFAULT 0,
  `tue` tinyint(1) NOT NULL DEFAULT 0,
  `wed` tinyint(1) NOT NULL DEFAULT 0,
  `thu` tinyint(1) NOT NULL DEFAULT 0,
  `fri` tinyint(1) NOT NULL DEFAULT 0,
  `sat` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `id_tahun_ajaran`, `nama`, `start`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sesi 1', '07:00:00', 1, 1, 1, 1, 1, 0, 1, '2024-01-08 05:45:09', '2024-01-08 05:45:24'),
(2, 1, 'Sesi 2', '09:40:00', 1, 1, 1, 1, 1, 0, 1, '2024-01-08 05:45:09', '2024-01-08 05:45:34'),
(3, 1, 'Sesi 3', '12:20:00', 1, 1, 1, 1, 1, 0, 1, '2024-01-08 05:45:09', '2024-01-08 05:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajarans`
--

CREATE TABLE `tahun_ajarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_tahun_ajaran` date NOT NULL,
  `end_tahun_ajaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajarans`
--

INSERT INTO `tahun_ajarans` (`id`, `tahun_ajaran`, `status`, `created_at`, `updated_at`, `start_tahun_ajaran`, `end_tahun_ajaran`) VALUES
(1, '2022/2023', 1, '2024-01-08 05:19:59', '2024-01-12 13:00:24', '2023-08-01', '2023-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','lecturer','admin','head_baak','staff_baak','head_bm','staff_bm','pengelola_gedung','admin_fakultas') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `signature` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `slug`, `email`, `nim`, `phone_number`, `department_id`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `signature`, `dokumen`, `faculty_id`) VALUES
(1, 'ade chandra', 'ade-chandra', 'ade.chandra.saputra.tumbai@gmail.com', '193011111111', '081314697305', NULL, 'avatars/1704691201.png', NULL, '$2y$10$4nnI7gjNn18EMbAB3TB.UuZawW4QC3lvZYsuEWo4s7IhZIYw0WMJu', NULL, NULL, NULL, 'admin', 'signature/654dc1d4473c7.png', NULL, NULL),
(2, 'ade chandra', 'ade-chandra-2', 'adechandra@it.upr.ac.id', NULL, '12313213132', 2, 'avatars/1704691201.png', NULL, '$2y$10$c69J2.sN26atNVNieg2zwOTJLg6tInO9q2wOhyA1z88PGdjFo8zpS', NULL, NULL, NULL, 'head_baak', NULL, NULL, NULL),
(3, 'Pengelola GMP', 'pengelola-gmp', 'pengelolaGMP@gmail.com', NULL, '1231321', NULL, 'avatars/1704692577.png', NULL, '$2y$10$5Nq14d/WCOOAFOJhV4zNCuEcUy6wSCSwdwqBqlC/vvIFSIcRIQWuy', NULL, '2024-01-08 05:42:57', '2024-01-12 08:27:31', 'pengelola_gedung', NULL, NULL, 10),
(4, 'BAAK', 'baak', 'baak@gmail.com', NULL, '123445532', NULL, 'avatars/1704692871.png', NULL, '$2y$10$4nnI7gjNn18EMbAB3TB.UuZawW4QC3lvZYsuEWo4s7IhZIYw0WMJu', NULL, '2024-01-08 05:47:51', '2024-01-12 08:27:07', 'admin_fakultas', 'signature/659b90649ff78.png', NULL, 10),
(5, 'Admin Pasca Sarjana', 'pascasarjana', 'admin_pascasarjana@gmail.com', NULL, '1234567890', NULL, 'avatars/1705048287.png', NULL, '$2y$10$GkoSYctKvflF5ya/xyBHTe1AzT43isq65s51OoF.aVV4mUgiacuVu', NULL, '2024-01-12 08:31:27', '2024-01-12 13:39:19', 'admin_fakultas', NULL, NULL, 9),
(6, 'Pengelola Gedung Pasca Sarjana', 'pengelola-pasca-sarjana', 'pengelola_pascasarjana@gmail.com', NULL, '1234567890', NULL, 'avatars/1705048362.png', NULL, '$2y$10$VwAFGc98HHwG03a8qU7gWOCYSkvjXjT08iIljAtfqiOMAI5X8UDpK', NULL, '2024-01-12 08:32:43', '2024-01-12 13:39:31', 'pengelola_gedung', NULL, NULL, 9),
(7, 'Admin FMIPA', 'admin-fmipa', 'admin_fmipa@gmail.com', '123', '123', NULL, 'avatars/1705066673.png', NULL, '$2y$10$4DYP4Op9ZnyhBmAamyMCZectn24b.y.sp4TZrQh8Tt8D92helmSVC', NULL, '2024-01-12 13:37:53', '2024-01-12 13:38:58', 'admin_fakultas', NULL, NULL, 8),
(8, 'Pengelola Gedung FMIPA', 'pengelola-gedung-fmipa', 'pengelola_fmipa@gmail.com', NULL, '123', NULL, 'avatars/1705066729.png', NULL, '$2y$10$l4mGhPhrbvmCR7fy6BIhee8wTGRpxFtv8HRaSuXV6.fqyhNkt59Ce', NULL, '2024-01-12 13:38:49', '2024-01-12 13:38:49', 'pengelola_gedung', NULL, NULL, 8),
(9, 'Admin FK', 'admin-fk', 'admin_fk@gmail.com', NULL, '123', NULL, 'avatars/1705066791.png', NULL, '$2y$10$3SRSUbH3nlhvdyz0Mtqs/.ilXA0KuNLNr2qvoD5HFsE2aBEq7RCPe', NULL, '2024-01-12 13:39:51', '2024-01-12 13:39:51', 'admin_fakultas', NULL, NULL, 7),
(10, 'Pengelola Gedung FK', 'pengelola-gedung-fk', 'pengelola_fk@gmail.com', NULL, '123', NULL, 'avatars/1705066817.png', NULL, '$2y$10$qHRSEkQFtT41LGfmBfXU5.oi/GZYG7sdwLoKeSifECRAOvcR27XdK', NULL, '2024-01-12 13:40:17', '2024-01-12 13:40:17', 'pengelola_gedung', NULL, NULL, 7),
(11, 'Admin FISIP', 'admin-fisip', 'admin_fisip@gmail.com', NULL, '123', NULL, 'avatars/1705066884.png', NULL, '$2y$10$q.KVYIuJSaLrECA2Vw.ImOKxKBPvYKmV6qbL3WKco5aQ/Gf5NaaXu', NULL, '2024-01-12 13:41:24', '2024-01-12 13:41:24', 'admin_fakultas', NULL, NULL, 6),
(12, 'Pengelola Gedung FISIP', 'pengelola-gedung-fisip', 'pengelola_fisip@gmail.com', NULL, '123', NULL, 'avatars/1705066918.png', NULL, '$2y$10$A5Uwd/wh9BbypzBwjyCDdOg7hq17ntp6adXR5fPRyTIgXfBY78uq.', NULL, '2024-01-12 13:41:58', '2024-01-12 13:41:58', 'pengelola_gedung', NULL, NULL, 6),
(13, 'Admin FH', 'admin-fh', 'admin_fh@gmail.com', NULL, '123', NULL, 'avatars/1705066941.png', NULL, '$2y$10$I8w9.YCvVjrwJISSS1lXzOadrrQFDVxHFbZJZuKndnXI1H6ebBYQK', NULL, '2024-01-12 13:42:21', '2024-01-12 13:42:21', 'admin_fakultas', NULL, NULL, 5),
(14, 'Pengelola Gedung FH', 'pengelola-gedung-fh', 'pengelola_fh@gmail.com', NULL, '123', NULL, 'avatars/1705066999.png', NULL, '$2y$10$mvdu50xii41mlHIhtLHqFu5G3QwadYBqFA9gn8iDmqjMe0AVCbQmW', NULL, '2024-01-12 13:43:19', '2024-01-12 13:43:19', 'pengelola_gedung', NULL, NULL, 5),
(15, 'Admin FT', 'admin-ft', 'admin_ft@gmail.com', NULL, '123', NULL, 'avatars/1705067018.png', NULL, '$2y$10$NE6OLp5QXVUTiNSkPnqgy.Z8bQnOtExKdyfurcV4Ma2AxBYAwNGkS', NULL, '2024-01-12 13:43:38', '2024-01-12 13:43:38', 'admin_fakultas', NULL, NULL, 4),
(16, 'Pengelola FT', 'pengelola-ft', 'pengelola_ft@gmail.com', NULL, '123', NULL, 'avatars/1705067039.png', NULL, '$2y$10$S9/ONVpUoqXnAG9I31.ODeJPJuoYCaKC9XuFD8ynNEOj9Z/ae0kvy', NULL, '2024-01-12 13:43:59', '2024-01-12 13:43:59', 'pengelola_gedung', NULL, NULL, 4),
(17, 'Admin FP', 'admin-fp', 'admin_fp@gmail.com', NULL, '123', NULL, 'avatars/1705067074.png', NULL, '$2y$10$pWfowKtdfFlCJWXrS5QedeDr2/pNW.cSR/0c0CrprluS0JOU9d55K', NULL, '2024-01-12 13:44:34', '2024-01-12 13:44:34', 'admin_fakultas', NULL, NULL, 3),
(18, 'Pengelola Gedung FP', 'pengelola-gedung-fp', 'pengelola_fp@gmail.com', NULL, '123', NULL, 'avatars/1705067097.png', NULL, '$2y$10$LOJsgUO1N5MOIFFrOBfRue6aIlHN48j5emaLASTo787yvnlVJ6z8W', NULL, '2024-01-12 13:44:57', '2024-01-12 13:44:57', 'pengelola_gedung', NULL, NULL, 3),
(19, 'Admin Ekonomi dan Bisnis', 'admin-ekonomi-dan-bisnis', 'admin_ekonomibisnis@gmail.com', NULL, '123', NULL, 'avatars/1705067132.png', NULL, '$2y$10$rxGLd9CXvXMa.XiuKclQROUhHTdJ7cdap5WPqv6FVVedbIpoS6PWG', NULL, '2024-01-12 13:45:32', '2024-01-12 13:46:18', 'admin_fakultas', NULL, NULL, 2),
(20, 'Pengelola Gedung Ekonomi dan Bisnis', 'pengelola-gedung-ekonomi-dan-bisnis', 'pengelola_ekonomibisnis@gmail.com', NULL, '123', NULL, 'avatars/1705067172.png', NULL, '$2y$10$1Z82Bx5zfhEGUSkdJNM/UOmcLtwcte58Nc/qgKOFDopLmt3RZQNvS', NULL, '2024-01-12 13:46:12', '2024-01-12 13:46:12', 'pengelola_gedung', NULL, NULL, 2),
(21, 'Admin FKIP', 'admin-fkip', 'admin_fkip@gmail.com', NULL, '123', NULL, 'avatars/1705067199.png', NULL, '$2y$10$6esB.a.aCdcbbG/L.YWzK.PX1TYudcnqMwvK9pauT.7Xt6Pjs7OVG', NULL, '2024-01-12 13:46:39', '2024-01-12 13:46:39', 'admin_fakultas', NULL, NULL, 1),
(22, 'Pengelola Gedung FKIP', 'pengelola-gedung-fkip', 'pengelola_fkip@gmail.com', NULL, '123', NULL, 'avatars/1705067223.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-12 13:47:03', '2024-01-12 13:47:03', 'pengelola_gedung', NULL, NULL, 1),
(23, 'User Teknik Sipil', 'user-teknik-sipil', 'user_tekniksipil@gmail.com', NULL, '123', 1, 'avatars/1705105952.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 4),
(24, 'User Teknik Informatika', 'user-teknik-informatika', 'user_teknikinformatika@gmail.com', '213124214', '124', 2, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 01:23:53', 'user', 'signature/65a1e629daeae.png', NULL, 4),
(25, 'User Pend. Matematika', 'user-pend.-matematika', 'user_pend.matematika@gmail.com', NULL, '125', 3, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(26, 'User Pend. Fisika', 'user-pend.-fisika', 'user_pend.fisika@gmail.com', NULL, '126', 4, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(27, 'User Pend. Kimia', 'user-pend.-kimia', 'user_pend.kimia@gmail.com', NULL, '127', 5, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(28, 'User Pend. Biologi', 'user-pend.-biologi', 'user_pend.biologi@gmail.com', NULL, '128', 6, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(29, 'User Pend. Teknik Mesin', 'user-pend.-teknik-mesin', 'user_pend.teknikmesin@gmail.com', NULL, '129', 7, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(30, 'User Pendidikan Teknik Bangunan', 'user-pendidikan-teknik-bangunan', 'user_pendidikanteknikbangunan@gmail.com', NULL, '130', 8, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(31, 'User Pend. Pancasila & Kewarganegaraan (PPKN)', 'user-pend.-pancasila-&-kewarganegaraan-(ppkn)', 'user_pend.pancasila&kewarganegaraan(ppkn)@gmail.com', NULL, '131', 9, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(32, 'User Pend. Ekonomi', 'user-pend.-ekonomi', 'user_pend.ekonomi@gmail.com', NULL, '132', 10, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(33, 'User Pend. Bahasa Inggris', 'user-pend.-bahasa-inggris', 'user_pend.bahasainggris@gmail.com', NULL, '133', 11, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(34, 'User Pend. Bahasa, Sastra Indonesia & Daerah', 'user-pend.-bahasa,-sastra-indonesia-&-daerah', 'user_pend.bahasa,sastraindonesia&daerah@gmail.com', NULL, '134', 12, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(35, 'User Pend. Guru Sekolah Dasar (PGSD)', 'user-pend.-guru-sekolah-dasar-(pgsd)', 'user_pend.gurusekolahdasar(pgsd)@gmail.com', NULL, '135', 13, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(36, 'User Pend. Jasmani, Kesehatan dan Rekreasi', 'user-pend.-jasmani,-kesehatan-dan-rekreasi', 'user_pend.jasmani,kesehatandanrekreasi@gmail.com', NULL, '136', 14, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(37, 'User Pend. Guru Pend Anak Usia Dini (PG PAUD)', 'user-pend.-guru-pend-anak-usia-dini-(pg-paud)', 'user_pend.gurupendanakusiadini(pgpaud)@gmail.com', NULL, '137', 15, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(38, 'User Pend. Luar Sekolah', 'user-pend.-luar-sekolah', 'user_pend.luarsekolah@gmail.com', NULL, '138', 16, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(39, 'User Bimbingan dan Konseling', 'user-bimbingan-dan-konseling', 'user_bimbingandankonseling@gmail.com', NULL, '139', 17, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(40, 'User Teknologi Pendidikan', 'user-teknologi-pendidikan', 'user_teknologipendidikan@gmail.com', NULL, '140', 18, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(41, 'User Manajemen Pendidikan', 'user-manajemen-pendidikan', 'user_manajemenpendidikan@gmail.com', NULL, '141', 19, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(42, 'User Pendidikan Sendratasik', 'user-pendidikan-sendratasik', 'user_pendidikansendratasik@gmail.com', NULL, '142', 20, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 1),
(43, 'User Ekonomi Pembangunan', 'user-ekonomi-pembangunan', 'user_ekonomipembangunan@gmail.com', NULL, '143', 21, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(44, 'User Manajemen', 'user-manajemen', 'user_manajemen@gmail.com', NULL, '144', 22, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(45, 'User Akuntansi', 'user-akuntansi', 'user_akuntansi@gmail.com', NULL, '145', 23, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(46, 'User Magister Ilmu Ekonomi', 'user-magister-ilmu-ekonomi', 'user_magisterilmuekonomi@gmail.com', NULL, '146', 24, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(47, 'User Magister Manajemen', 'user-magister-manajemen', 'user_magistermanajemen@gmail.com', NULL, '147', 25, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(48, 'User Magister Akuntansi', 'user-magister-akuntansi', 'user_magisterakuntansi@gmail.com', NULL, '148', 26, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(49, 'User Doktor Ilmu Manajemen', 'user-doktor-ilmu-manajemen', 'user_doktorilmumanajemen@gmail.com', NULL, '149', 27, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 2),
(50, 'User Ilmu Sosial Ekonomi Pertanian (Agribisnis)', 'user-ilmu-sosial-ekonomi-pertanian-(agribisnis)', 'user_ilmusosialekonomipertanian(agribisnis)@gmail.com', NULL, '150', 28, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(51, 'User Manajemen Sumberdaya Perairan', 'user-manajemen-sumberdaya-perairan', 'user_manajemensumberdayaperairan@gmail.com', NULL, '151', 29, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(52, 'User Budidaya Perairan', 'user-budidaya-perairan', 'user_budidayaperairan@gmail.com', NULL, '152', 30, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(53, 'User Agroteknologi', 'user-agroteknologi', 'user_agroteknologi@gmail.com', NULL, '153', 31, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(54, 'User Kehutanan', 'user-kehutanan', 'user_kehutanan@gmail.com', NULL, '154', 32, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(55, 'User Teknologi Hasil Perikanan', 'user-teknologi-hasil-perikanan', 'user_teknologihasilperikanan@gmail.com', NULL, '155', 33, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(56, 'User Peternakan', 'user-peternakan', 'user_peternakan@gmail.com', NULL, '156', 34, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(57, 'User Teknologi Industri Pertanian', 'user-teknologi-industri-pertanian', 'user_teknologiindustripertanian@gmail.com', NULL, '157', 35, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 3),
(58, 'User Arsitektur', 'user-arsitektur', 'user_arsitektur@gmail.com', NULL, '158', 37, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 4),
(59, 'User Teknik Pertambangan', 'user-teknik-pertambangan', 'user_teknikpertambangan@gmail.com', NULL, '159', 38, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 4),
(60, 'User Ilmu Hukum', 'user-ilmu-hukum', 'user_ilmuhukum@gmail.com', NULL, '160', 39, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 5),
(61, 'User Magister Ilmu Hukum', 'user-magister-ilmu-hukum', 'user_magisterilmuhukum@gmail.com', NULL, '161', 40, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 5),
(62, 'User Sosiologi', 'user-sosiologi', 'user_sosiologi@gmail.com', NULL, '162', 41, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 6),
(63, 'User Ilmu Administrasi Negara', 'user-ilmu-administrasi-negara', 'user_ilmuadministrasinegara@gmail.com', NULL, '163', 42, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 6),
(64, 'User Ilmu Pemerintahan', 'user-ilmu-pemerintahan', 'user_ilmupemerintahan@gmail.com', NULL, '164', 43, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 6),
(65, 'User Kedokteran', 'user-kedokteran', 'user_kedokteran@gmail.com', NULL, '165', 44, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 7),
(66, 'User Teknologi Laboratorium Medis', 'user-teknologi-laboratorium-medis', 'user_teknologilaboratoriummedis@gmail.com', NULL, '166', 45, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 7),
(67, 'User Fisika', 'user-fisika', 'user_fisika@gmail.com', NULL, '167', 46, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 8),
(68, 'User Kimia', 'user-kimia', 'user_kimia@gmail.com', NULL, '168', 47, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 8),
(69, 'User Biologi', 'user-biologi', 'user_biologi@gmail.com', NULL, '169', 48, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 8),
(70, 'User Matematika', 'user-matematika', 'user_matematika@gmail.com', NULL, '170', 49, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 8),
(71, 'User Farmasi', 'user-farmasi', 'user_farmasi@gmail.com', NULL, '171', 50, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 8),
(72, 'User Magister Pendidikan Bahasa Inggris', 'user-magister-pendidikan-bahasa-inggris', 'user_magisterpendidikanbahasainggris@gmail.com', NULL, '172', 51, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(73, 'User Magister Pendidikan Biologi', 'user-magister-pendidikan-biologi', 'user_magisterpendidikanbiologi@gmail.com', NULL, '173', 52, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(74, 'User Magister Pendidikan Dasar', 'user-magister-pendidikan-dasar', 'user_magisterpendidikandasar@gmail.com', NULL, '174', 53, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(75, 'User Magister Pendidikan Ekonomi', 'user-magister-pendidikan-ekonomi', 'user_magisterpendidikanekonomi@gmail.com', NULL, '175', 54, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(76, 'User Magister Pendidikan Ilmu Pengetahuan Sosial', 'user-magister-pendidikan-ilmu-pengetahuan-sosial', 'user_magisterpendidikanilmupengetahuansosial@gmail.com', NULL, '176', 55, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(77, 'User Magister Pendidikan Kimia', 'user-magister-pendidikan-kimia', 'user_magisterpendidikankimia@gmail.com', NULL, '177', 56, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(78, 'User Magister Pendidikan Luar Sekolah', 'user-magister-pendidikan-luar-sekolah', 'user_magisterpendidikanluarsekolah@gmail.com', NULL, '178', 57, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(79, 'User Magister Pengelolaan Sumberdaya Alam Dan Lingkungan', 'user-magister-pengelolaan-sumberdaya-alam-dan-lingkungan', 'user_magisterpengelolaansumberdayaalamdanlingkungan@gmail.com', NULL, '179', 58, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(80, 'User Magister Perencanaan Wilayah Dan Kota', 'user-magister-perencanaan-wilayah-dan-kota', 'user_magisterperencanaanwilayahdankota@gmail.com', NULL, '180', 59, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(81, 'User Doktor Program Doktor Ilmu Lingkungan', 'user-doktor-program-doktor-ilmu-lingkungan', 'user_doktorprogramdoktorilmulingkungan@gmail.com', NULL, '181', 60, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9),
(82, 'User Magister Kehutanan', 'user-magister-kehutanan', 'user_magisterkehutanan@gmail.com', NULL, '182', 61, 'avatars/1705109033_001-user.png', NULL, '$2y$10$GMrIadR0Q7AjIoVafxegkOGMvf7kpKoWAaEVu3vflGA8iYw8UopbK', NULL, '2024-01-13 00:32:32', '2024-01-13 00:32:33', 'user', NULL, NULL, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buildings_id_user_foreign` (`id_user`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD KEY `departments_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_name_unique` (`name`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_images_room_id_foreign` (`room_id`);

--
-- Indexes for table `room_reservations`
--
ALTER TABLE `room_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_reservations_user_id_foreign` (`user_id`),
  ADD KEY `room_reservations_room_id_foreign` (`room_id`),
  ADD KEY `room_reservations_start_time_index` (`start_time`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_accounts_provider_id_unique` (`provider_id`);

--
-- Indexes for table `tahun_ajarans`
--
ALTER TABLE `tahun_ajarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_slug_unique` (`slug`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nim_unique` (`nim`),
  ADD KEY `users_department_id_foreign` (`department_id`),
  ADD KEY `users_faculty_id_foreign` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_reservations`
--
ALTER TABLE `room_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahun_ajarans`
--
ALTER TABLE `tahun_ajarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`);

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_reservations`
--
ALTER TABLE `room_reservations`
  ADD CONSTRAINT `room_reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_reservations_start_time_foreign` FOREIGN KEY (`start_time`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
