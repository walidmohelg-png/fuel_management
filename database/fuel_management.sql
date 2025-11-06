-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2025 at 11:40 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_companies`
--

CREATE TABLE `beneficiary_companies` (
  `id` bigint UNSIGNED NOT NULL,
  `distributor_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'نشطة',
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beneficiary_companies`
--

INSERT INTO `beneficiary_companies` (`id`, `distributor_id`, `name`, `activity_type`, `fuel_code`, `current_status`, `region`, `city`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 1, 'شركة الزاد للخبز والخبيز', 'كوشة', 'ON-0006', 'موثقة', 'طرابلس', 'جنزور', 'بلسبلى سثقلسقا', 33.545000, 13.355600, '2025-11-03 07:27:37', '2025-11-03 07:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `fuel_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthly_allowance` int DEFAULT NULL,
  `supply_warehouse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_passport_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_national_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_passport_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_person_photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative_photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `company_id`, `fuel_type`, `monthly_allowance`, `supply_warehouse`, `authorized_person_name`, `authorized_person_phone`, `authorized_person_email`, `authorized_person_national_id`, `authorized_person_passport_no`, `representative_name`, `representative_phone`, `representative_email`, `representative_national_id`, `representative_passport_no`, `authorized_person_nid`, `authorized_person_passport`, `authorized_person_photo_path`, `representative_nid`, `representative_passport`, `representative_photo_path`, `effective_date`, `notes`, `region`, `city`, `created_at`, `updated_at`) VALUES
(1, 1, 'بنزين', 3463, 'مستودع البريقة النفطي', 'سالم سالم سالم', '09187655', 'gjsis@hgkfk.com', NULL, NULL, 'سعد سعيد فرح', '0938476230', 'fdvdfdv@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-03', 'ثقلشقلشقلقشث', 'الجبل الغربي', 'غريان', '2025-11-03 07:27:37', '2025-11-04 05:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `company_documents`
--

CREATE TABLE `company_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'غير محدد',
  `expiry_date` date DEFAULT NULL,
  `document_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_documents`
--

INSERT INTO `company_documents` (`id`, `company_id`, `document_type`, `document_status`, `expiry_date`, `document_file`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'غير محدد', '2025-11-12', NULL, NULL, '2025-11-03 07:27:37', '2025-11-03 07:27:37'),
(2, 1, NULL, 'غير محدد', '2025-11-01', NULL, NULL, '2025-11-03 07:27:37', '2025-11-03 07:27:37'),
(3, 1, NULL, 'غير محدد', '2025-11-26', NULL, NULL, '2025-11-03 07:27:37', '2025-11-03 07:27:37'),
(4, 1, NULL, 'غير محدد', '2025-11-16', NULL, NULL, '2025-11-03 07:27:37', '2025-11-03 07:27:37'),
(5, 1, NULL, 'غير محدد', '2025-11-20', NULL, NULL, '2025-11-03 07:27:37', '2025-11-03 07:27:37'),
(17, 1, NULL, 'ساري', '2025-11-12', NULL, NULL, '2025-11-04 05:16:39', '2025-11-04 05:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delegate_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delegate_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`id`, `name`, `manager_name`, `email`, `phone`, `delegate_name`, `delegate_phone`, `region`, `city`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'شركة البريقة لتوزيع الوقود', 'احمد احمد احمد', 'AHm@example.com', '0917527588', 'علي علي علي', '9018376565', 'منطثة طرابلس', 'طرابلس', 'لسصلاصثصثلاصثلاصث ثصقلصثق', '33.756000', '13.654000', '2025-11-03 04:26:18', '2025-11-03 08:43:45'),
(2, 'شركة ليبيا نفط لتوزيع الوقود', 'نوري فرنكة', 'no@example.com', '0927685944', 'سعيد علي', '09211189787', 'منطقة الجبل الغربي', 'غريان', 'ethwehwt tgetgwt wtgwetg', '33.743400', '13.455000', '2025-11-03 04:27:23', '2025-11-03 04:27:23');

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
-- Table structure for table `fuel_stations`
--

CREATE TABLE `fuel_stations` (
  `id` bigint UNSIGNED NOT NULL,
  `distributor_id` bigint UNSIGNED NOT NULL,
  `station_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='~ٍ';

--
-- Dumping data for table `fuel_stations`
--

INSERT INTO `fuel_stations` (`id`, `distributor_id`, `station_name`, `station_number`, `city`, `region`, `address`, `latitude`, `longitude`, `owner_name`, `owner_phone`, `owner_nid`, `owner_passport`, `owner_photo`, `supervisor_name`, `supervisor_phone`, `supervisor_nid`, `supervisor_passport`, `supervisor_photo`, `created_at`, `updated_at`) VALUES
(1, 1, 'الامانة', '143', 'غريان', 'منطقة الجبل الغربي', 'سثقلثقلثقل صثقلصثقلصثق', 33.847400, 13.654000, 'فرج فتحي على', '0918747565', '191827364557', 'AS7348778', 'owner_photos/SvjJV4J6DEXqmiE2mr2UIBEX5ERswMol6nQQByIV.png', 'محمد سويد', '09283746466', '199374654747466', 'AX6474785487', 'supervisor_photos/Q02vNJtOVCYINZqxsJN2WsKZj714DDU08a7td1fj.jpg', '2025-11-03 04:32:22', '2025-11-03 04:43:52'),
(6, 1, 'الاتجاة', '186', 'طرابلس', 'طرابلس', 'لسيلس صثلصثل', 33.454000, 13.545000, 'محمود شعير', '0917466455', '1998746455467', 'AD7575889', 'owner_photos/2usI2fxQkdQD4obDALYI2cRTO130M2wvOLjA4Sfi.png', 'عبدالعزيز احمد', '0928877654', '199763534434', 'AE74598598', 'supervisor_photos/Huh6LQRB0v7Kk7YGxUMy2B3kmxtFCD0Jll8U3jlr.jpg', '2025-11-05 06:06:12', '2025-11-05 06:08:12'),
(7, 1, 'التباعد', '188', 'زاوية الدهماني', 'طرابلس', 'طرابلس', 33.756000, 13.544500, 'سيلسشيلس', 'سلسشيل', 'سيلسيل', 'سلسيل', 'owner_photos/rIih8siX4sJSh97x2ViHJK9uxCbpqXINIYTIs7fX.jpg', 'سيلشسيل', 'شسيلشسابلب', 'لاتللاتلا', 'بلتابالت', 'supervisor_photos/47vuPCGS499N3S1dXws2dHVzATsfbxSGpUfbRYnG.png', '2025-11-05 06:16:09', '2025-11-05 06:26:46'),
(8, 1, 'الالتزام', '173', 'طرابلس', 'منطقة طرابلس', 'قرب جامع', 33.743400, 13.355600, 'حسن عمر حسن', '09173636355', '1998746455466', 'AC34878734', 'owner_photos/pizJCCHwXS2HLecI82uUi1LYIqDvTttH6Sbzp5GO.png', 'وسام خالد محمد', '092746466', '19984665466', 'AD7347347', 'supervisor_photos/QSYgPEFbNTwsYy8wMh1TKfmdxHmsPUezgBdgao8H.png', '2025-11-06 06:59:42', '2025-11-06 07:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_station_details`
--

CREATE TABLE `fuel_station_details` (
  `id` bigint UNSIGNED NOT NULL,
  `station_id` bigint UNSIGNED NOT NULL,
  `fuel_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuel_quantity` decimal(10,2) DEFAULT NULL,
  `tank_count` int DEFAULT NULL,
  `meter_before` bigint DEFAULT NULL,
  `meter_after` bigint DEFAULT NULL,
  `fire_equipment` tinyint(1) NOT NULL DEFAULT '0',
  `signs` tinyint(1) NOT NULL DEFAULT '0',
  `lighting` tinyint(1) NOT NULL DEFAULT '0',
  `flooring` tinyint(1) NOT NULL DEFAULT '0',
  `electrical_materials` tinyint(1) NOT NULL DEFAULT '0',
  `cameras` tinyint(1) NOT NULL DEFAULT '0',
  `cleanliness` tinyint(1) NOT NULL DEFAULT '0',
  `station_contract` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `station_contract_status` enum('ساري','منتهي') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_status` enum('صالح','منتهي الصلاحية') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workers_health_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_calibration` date DEFAULT NULL,
  `last_inspection` date DEFAULT NULL,
  `number_of_workers` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supply_days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_station_details`
--

INSERT INTO `fuel_station_details` (`id`, `station_id`, `fuel_type`, `fuel_quantity`, `tank_count`, `meter_before`, `meter_after`, `fire_equipment`, `signs`, `lighting`, `flooring`, `electrical_materials`, `cameras`, `cleanliness`, `station_contract`, `station_contract_status`, `license`, `license_status`, `workers_health_status`, `last_calibration`, `last_inspection`, `number_of_workers`, `created_at`, `updated_at`, `supply_days`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2025-11-03 04:44:45', '2025-11-04 09:10:13', NULL),
(6, 6, 'بنزين', 500000.00, 4, 43434344, 989757593, 1, 1, 1, 1, 1, 1, 1, '453232', 'ساري', '56556788', 'صالح', 'موجودة', '2025-11-20', '2025-11-18', NULL, '2025-11-05 06:06:12', '2025-11-05 06:09:01', 'يوم واحد في الأسبوع'),
(7, 7, 'بنزين', 547457.00, 75547457, 4574745, 574575, 1, 1, 1, 1, 1, 1, 1, '457457', 'منتهي', '45745747', NULL, 'موجودة', '2025-11-14', '2025-11-13', 85, '2025-11-05 06:16:09', '2025-11-05 08:17:21', 'يومياً'),
(8, 8, 'بنزين', 300000.00, 4, 463463, 346346, 1, 1, 1, 1, 1, 1, 1, '747477', 'ساري', '949488', 'صالح', 'موجودة', '2025-11-19', '2025-11-19', 60, '2025-11-06 06:59:43', '2025-11-06 07:02:34', 'يومان في الأسبوع');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_station_documents`
--

CREATE TABLE `fuel_station_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `station_id` bigint UNSIGNED NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_status` enum('ساري','منتهي','غير مستوفي','لا يوجد') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'لا يوجد',
  `expiry_date` date DEFAULT NULL,
  `document_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_station_documents`
--

INSERT INTO `fuel_station_documents` (`id`, `station_id`, `document_type`, `document_status`, `expiry_date`, `document_file`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'الترخيص', 'منتهي', '2025-11-12', 'fuel_station_documents/RrZjCu3HSXZ5075BEpgEileXeI9Wn6g6K8QX4VH3.jpg', 'قلقلصقلصثقل', '2025-11-03 04:45:25', '2025-11-03 04:45:25'),
(5, 6, 'شهادة المنشأ', 'غير مستوفي', '2025-11-19', NULL, 'سلسل صلصثلل', '2025-11-05 06:09:01', '2025-11-05 06:09:01'),
(6, 7, 'الترخيص', 'منتهي', '2025-11-19', NULL, 'ثقلسقاسقيا', '2025-11-05 08:17:21', '2025-11-05 08:17:21'),
(7, 8, 'الترخيص', 'ساري', '2025-11-26', 'fuel_station_documents/ZVFh1oehkviTlC2bR40cVrfxtzg52ruOHwN4gxpO.pdf', 'مش عارف', '2025-11-06 07:02:34', '2025-11-06 07:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
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
(50, '0001_01_01_000000_create_users_table', 1),
(51, '0001_01_01_000001_create_cache_table', 1),
(52, '0001_01_01_000002_create_jobs_table', 1),
(53, '2025_10_30_190528_create_distributors_table', 1),
(54, '2025_10_30_190546_create_beneficiary_companies_table', 1),
(55, '2025_10_30_190556_create_company_details_table', 1),
(56, '2025_10_30_190615_create_company_documents_table', 1),
(57, '2025_11_02_104415_create_fuel_stations_table', 1),
(58, '2025_11_02_105217_create_fuel_station_details_table', 1),
(59, '2025_11_02_111710_create_fuel_station_documents_table', 1),
(61, '2025_11_02_191550_add_region_to_fuel_stations_table', 2),
(62, '2025_11_03_071055_add_contract_and_license_status_to_fuel_station_details_table', 3),
(63, '2025_11_03_073703_add_number_of_workers_to_fuel_station_details_table', 4),
(64, '2025_11_03_110821_rename_photo_columns_in_company_details_table', 5),
(65, '2025_11_03_111104_add_id_and_passport_to_company_details_table', 6),
(66, '2025_11_04_095832_alter_supply_days_column_in_fuel_station_details_table', 7),
(67, '2025_11_04_100442_change_supply_days_column_type_in_fuel_station_details_table', 7),
(68, '2025_11_04_123143_alter_meter_columns_to_bigint_in_fuel_station_details_table', 8);

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
('PywVMrZIIy3QQ85UPiCO9MxPInfwOapQUxWMcjFk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYnpUT01PNmZCa2ZLN3ZNaktHMDVuVnVuWFRpclZHRVJhYmRKNkJFRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kaXN0cmlidXRvcnMiO319', 1762426077);

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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@fuel.com', NULL, '$2y$12$ySBU.MeTe3FWneF7EJGxbeBRyP19dX8KwH70Zx/AAuFaJ0FUNu43C', NULL, '2025-11-02 10:46:48', '2025-11-02 10:46:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beneficiary_companies`
--
ALTER TABLE `beneficiary_companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `beneficiary_companies_fuel_code_unique` (`fuel_code`),
  ADD KEY `beneficiary_companies_distributor_id_foreign` (`distributor_id`);

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
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_details_company_id_foreign` (`company_id`);

--
-- Indexes for table `company_documents`
--
ALTER TABLE `company_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_documents_company_id_foreign` (`company_id`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fuel_stations`
--
ALTER TABLE `fuel_stations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fuel_stations_station_number_unique` (`station_number`),
  ADD KEY `fuel_stations_distributor_id_foreign` (`distributor_id`);

--
-- Indexes for table `fuel_station_details`
--
ALTER TABLE `fuel_station_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuel_station_details_station_id_foreign` (`station_id`);

--
-- Indexes for table `fuel_station_documents`
--
ALTER TABLE `fuel_station_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fuel_station_documents_station_id_foreign` (`station_id`);

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
-- AUTO_INCREMENT for table `beneficiary_companies`
--
ALTER TABLE `beneficiary_companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_documents`
--
ALTER TABLE `company_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuel_stations`
--
ALTER TABLE `fuel_stations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fuel_station_details`
--
ALTER TABLE `fuel_station_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fuel_station_documents`
--
ALTER TABLE `fuel_station_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beneficiary_companies`
--
ALTER TABLE `beneficiary_companies`
  ADD CONSTRAINT `beneficiary_companies_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_details`
--
ALTER TABLE `company_details`
  ADD CONSTRAINT `company_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `beneficiary_companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_documents`
--
ALTER TABLE `company_documents`
  ADD CONSTRAINT `company_documents_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `beneficiary_companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_stations`
--
ALTER TABLE `fuel_stations`
  ADD CONSTRAINT `fuel_stations_distributor_id_foreign` FOREIGN KEY (`distributor_id`) REFERENCES `distributors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_station_details`
--
ALTER TABLE `fuel_station_details`
  ADD CONSTRAINT `fuel_station_details_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `fuel_stations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_station_documents`
--
ALTER TABLE `fuel_station_documents`
  ADD CONSTRAINT `fuel_station_documents_station_id_foreign` FOREIGN KEY (`station_id`) REFERENCES `fuel_stations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
