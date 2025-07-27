-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 27 Ιουλ 2025 στις 15:05:03
-- Έκδοση διακομιστή: 10.4.32-MariaDB
-- Έκδοση PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `meine-anzeigen`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `boats`
--

CREATE TABLE `boats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `car_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `year_of_construction` year(4) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `boat_type` varchar(255) NOT NULL,
  `material` varchar(255) DEFAULT NULL,
  `total_length` decimal(5,2) DEFAULT NULL,
  `total_width` decimal(5,2) DEFAULT NULL,
  `berths` tinyint(3) UNSIGNED DEFAULT NULL,
  `engine_type` varchar(255) DEFAULT NULL,
  `engine_power` int(10) UNSIGNED DEFAULT NULL,
  `operating_hours` int(10) UNSIGNED DEFAULT NULL,
  `last_service` date DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `boat_images`
--

CREATE TABLE `boat_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boat_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Apple', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(2, 'Samsung', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(3, 'Sony', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(4, 'LG', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(5, 'Bosch', '2025-07-27 10:57:33', '2025-07-27 10:57:33');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `campers`
--

CREATE TABLE `campers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `car_model_id` bigint(20) UNSIGNED NOT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(10) UNSIGNED NOT NULL,
  `power` int(10) UNSIGNED DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `camper_type` varchar(255) NOT NULL,
  `berths` tinyint(3) UNSIGNED DEFAULT NULL,
  `total_length` decimal(4,1) DEFAULT NULL,
  `total_width` decimal(4,1) DEFAULT NULL,
  `total_height` decimal(4,1) DEFAULT NULL,
  `gross_vehicle_weight` int(10) UNSIGNED DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `emission_class` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `camper_images`
--

CREATE TABLE `camper_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `camper_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_slug` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `car_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` int(10) UNSIGNED DEFAULT NULL,
  `mileage` int(10) UNSIGNED DEFAULT NULL,
  `registration` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `power` int(10) UNSIGNED DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `drive` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `doors` tinyint(3) UNSIGNED DEFAULT NULL,
  `seats` tinyint(3) UNSIGNED DEFAULT NULL,
  `seller_type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `car_images`
--

CREATE TABLE `car_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `car_models`
--

CREATE TABLE `car_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Fahrzeuge', 'fahrzeuge', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(2, 'Fahrzeugeteile', 'fahrzeugeteile', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(3, 'Boote', 'boote', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(4, 'Elektronik', 'elektronik', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(5, 'Haushalt', 'haushalt', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(6, 'Immobilien', 'immobilien', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(7, 'Dienstleistungen', 'dienstleistungen', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(8, 'Sonstiges', 'sonstiges', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(9, 'Motorräder', 'motorrad', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(10, 'Nutzfahrzeuge', 'nutzfahrzeuge', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(11, 'Wohnmobile', 'wohnmobile', '2025-07-27 10:57:33', '2025-07-27 10:57:33');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `commercial_vehicles`
--

CREATE TABLE `commercial_vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `car_model_id` bigint(20) UNSIGNED NOT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(10) UNSIGNED NOT NULL,
  `power` int(10) UNSIGNED DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `commercial_vehicle_type` varchar(255) NOT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `payload_capacity` int(10) UNSIGNED DEFAULT NULL,
  `gross_vehicle_weight` int(10) UNSIGNED DEFAULT NULL,
  `number_of_axles` tinyint(3) UNSIGNED DEFAULT NULL,
  `emission_class` varchar(255) DEFAULT NULL,
  `seats` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `commercial_vehicle_images`
--

CREATE TABLE `commercial_vehicle_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commercial_vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `electronics`
--

CREATE TABLE `electronics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `year_of_purchase` year(4) DEFAULT NULL,
  `warranty_status` varchar(255) DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `electronic_model_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `electronic_images`
--

CREATE TABLE `electronic_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `electronic_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `electronic_models`
--

CREATE TABLE `electronic_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_hint` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `electronic_models`
--

INSERT INTO `electronic_models` (`id`, `brand_id`, `name`, `category_hint`, `created_at`, `updated_at`) VALUES
(1, 1, 'iPhone 15 Pro', 'Mobiltelefone', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(2, 1, 'MacBook Air M3', 'Computer & Laptops', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(3, 2, 'Galaxy S24 Ultra', 'Mobiltelefone', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(4, 2, 'Neo QLED QN90C', 'Fernseher', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(5, 2, 'RS68A Side-by-Side', 'Haushaltsgeräte', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(6, 3, 'PlayStation 5', 'Gaming Konsolen', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(7, 3, 'Bravia XR A95L', 'Fernseher', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(8, 4, 'OLED evo G3', 'Fernseher', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(9, 4, 'Waschmaschine F4WV709S1E', 'Haushaltsgeräte', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(10, 5, 'Kühlschrank KGN36VL30', 'Haushaltsgeräte', '2025-07-27 10:57:33', '2025-07-27 10:57:33'),
(11, 5, 'Geschirrspüler SMS68TI00E', 'Haushaltsgeräte', '2025-07-27 10:57:33', '2025-07-27 10:57:33');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `failed_jobs`
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
-- Δομή πίνακα για τον πίνακα `household_items`
--

CREATE TABLE `household_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `household_item_images`
--

CREATE TABLE `household_item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `household_item_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `jobs`
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
-- Δομή πίνακα για τον πίνακα `job_batches`
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
-- Δομή πίνακα για τον πίνακα `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Άδειασμα δεδομένων του πίνακα `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_15_111132_create_categories_table', 1),
(5, '2025_07_18_103422_create_brands_table', 1),
(6, '2025_07_18_103422_create_models_table', 1),
(7, '2025_07_18_141736_create_vehicles_table', 1),
(8, '2025_07_18_144328_create_vehicle_images_table', 1),
(9, '2025_07_20_085911_create_parts_table', 1),
(10, '2025_07_20_091215_create_electronics_table', 1),
(11, '2025_07_20_094130_create_real_estates_table', 1),
(12, '2025_07_20_095055_create_services_table', 1),
(13, '2025_07_20_131538_create_boats_table', 1),
(14, '2025_07_20_131543_create_others_table', 1),
(15, '2025_07_22_080008_create_motorrad_ads_table', 1),
(16, '2025_07_22_084338_create_commercial_vehicles_table', 1),
(17, '2025_07_22_085627_create_campers_table', 1),
(18, '2025_07_22_091033_create_used_vehicle_parts_table', 1),
(19, '2025_07_22_100734_create_electronic_models_table', 1),
(20, '2025_07_22_100828_add_electronic_model_id_to_electronics_table', 1),
(21, '2025_07_22_110531_add_image_paths_to_electronics_table', 1),
(22, '2025_07_22_112112_create_household_items_table', 1),
(23, '2025_07_24_142757_create_real_estate_images_table', 1),
(24, '2025_07_24_142944_remove_old_real_estate_image_paths_from_real_estates_table', 1),
(25, '2025_07_24_143018_create_service_images_table', 1),
(26, '2025_07_24_143129_create_other_images_table', 1),
(27, '2025_07_24_150259_create_electronic_images_table', 1),
(28, '2025_07_24_150502_remove_image_paths_from_electronics_table', 1),
(29, '2025_07_24_151544_remove_image_paths_from_household_items_table', 1),
(30, '2025_07_25_122639_rename_vehicle_id_to_car_id_in_car_images_table', 1),
(31, '2025_07_25_124012_rename_vehicles_table_to_cars_table', 1),
(32, '2025_07_25_124102_rename_vehicle_images_table_to_car_images_table', 1),
(33, '2025_07_26_084011_create_household_item_images_table', 1),
(34, '2025_07_26_090028_remove_images_column_from_real_estates_table', 1),
(35, '2025_07_26_111317_rename_path_to_image_path_in_other_images_table', 1),
(36, '2025_07_26_111400_rename_path_to_image_path_in_service_images_table', 1),
(37, '2025_07_27_121554_add_location_fields_to_boats_table', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `motorrad_ads`
--

CREATE TABLE `motorrad_ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `car_model_id` bigint(20) UNSIGNED NOT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(10) UNSIGNED NOT NULL,
  `power` int(10) UNSIGNED NOT NULL,
  `color` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `motorrad_ad_images`
--

CREATE TABLE `motorrad_ad_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `motorrad_ad_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `others`
--

CREATE TABLE `others` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_slug` varchar(255) NOT NULL DEFAULT 'sonstiges',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `other_images`
--

CREATE TABLE `other_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `other_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `parts`
--

CREATE TABLE `parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `car_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `price_from` decimal(10,2) DEFAULT NULL,
  `registration_to` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `real_estates`
--

CREATE TABLE `real_estates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_slug` varchar(255) NOT NULL DEFAULT 'immobilien',
  `immobilientyp` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `objekttyp` varchar(255) DEFAULT NULL,
  `zustand` varchar(255) DEFAULT NULL,
  `anzahl_zimmer` int(11) DEFAULT NULL,
  `bautyp` varchar(255) DEFAULT NULL,
  `verfugbarkeit` varchar(255) DEFAULT NULL,
  `befristung` varchar(255) DEFAULT NULL,
  `befristung_ende` date DEFAULT NULL,
  `description` text NOT NULL,
  `objektbeschreibung` text DEFAULT NULL,
  `lage` text DEFAULT NULL,
  `sonstiges` text DEFAULT NULL,
  `zusatzinformation` text DEFAULT NULL,
  `land` varchar(255) NOT NULL DEFAULT 'Österreich',
  `plz` varchar(255) NOT NULL,
  `ort` varchar(255) NOT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `gesamtmiete` decimal(10,2) DEFAULT NULL,
  `wohnflaeche` decimal(10,2) DEFAULT NULL,
  `grundflaeche` decimal(10,2) DEFAULT NULL,
  `kaution` decimal(10,2) DEFAULT NULL,
  `maklerprovision` decimal(10,2) DEFAULT NULL,
  `abloese` decimal(10,2) DEFAULT NULL,
  `ausstattung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ausstattung`)),
  `heizung` varchar(255) DEFAULT NULL,
  `rundgang_link` varchar(255) DEFAULT NULL,
  `objektinformationen_link` varchar(255) DEFAULT NULL,
  `zustandsbericht_link` varchar(255) DEFAULT NULL,
  `verkaufsbericht_link` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_tel` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) NOT NULL,
  `firmenname` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `telefon2` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `immocard_id` varchar(255) DEFAULT NULL,
  `immocard_firma_id` varchar(255) DEFAULT NULL,
  `zusatzkontakt` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `real_estate_images`
--

CREATE TABLE `real_estate_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `real_estate_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_slug` varchar(255) NOT NULL DEFAULT 'dienstleistungen',
  `dienstleistung_kategorie` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `verfugbarkeit` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_tel` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `service_images`
--

CREATE TABLE `service_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `sessions`
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
-- Άδειασμα δεδομένων του πίνακα `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('M2J1Fo6q6hvlrRHvR1oyS4eLINU3le5tr1DbtzCV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVhvNXllalRhS2hWbExYTnhUN0szMDQwVlNuTE9kY1d5SWlRcXFlWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1753621094);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `used_vehicle_parts`
--

CREATE TABLE `used_vehicle_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `part_category` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `manufacturer_part_number` varchar(255) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `compatible_brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `compatible_car_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `compatible_year_from` year(4) DEFAULT NULL,
  `compatible_year_to` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `used_vehicle_part_images`
--

CREATE TABLE `used_vehicle_part_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `used_vehicle_part_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
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
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-27 10:57:33', '$2y$12$V43WUEUP/Fkqj5vhFztQJuXlhdjeZm2eD0oGJCTM4fCkZW8YDwhP2', 'Pmx0FkC69I', '2025-07-27 10:57:34', '2025-07-27 10:57:34');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `boats`
--
ALTER TABLE `boats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boats_user_id_foreign` (`user_id`),
  ADD KEY `boats_brand_id_foreign` (`brand_id`),
  ADD KEY `boats_car_model_id_foreign` (`car_model_id`);

--
-- Ευρετήρια για πίνακα `boat_images`
--
ALTER TABLE `boat_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boat_images_boat_id_foreign` (`boat_id`);

--
-- Ευρετήρια για πίνακα `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Ευρετήρια για πίνακα `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Ευρετήρια για πίνακα `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Ευρετήρια για πίνακα `campers`
--
ALTER TABLE `campers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campers_user_id_foreign` (`user_id`),
  ADD KEY `campers_brand_id_foreign` (`brand_id`),
  ADD KEY `campers_car_model_id_foreign` (`car_model_id`);

--
-- Ευρετήρια για πίνακα `camper_images`
--
ALTER TABLE `camper_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `camper_images_camper_id_foreign` (`camper_id`);

--
-- Ευρετήρια για πίνακα `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_slug_unique` (`slug`),
  ADD KEY `vehicles_brand_id_foreign` (`brand_id`),
  ADD KEY `vehicles_car_model_id_foreign` (`car_model_id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`);

--
-- Ευρετήρια για πίνακα `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_images_vehicle_id_foreign` (`car_id`);

--
-- Ευρετήρια για πίνακα `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_models_slug_unique` (`slug`),
  ADD KEY `car_models_brand_id_foreign` (`brand_id`);

--
-- Ευρετήρια για πίνακα `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Ευρετήρια για πίνακα `commercial_vehicles`
--
ALTER TABLE `commercial_vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_vehicles_user_id_foreign` (`user_id`),
  ADD KEY `commercial_vehicles_brand_id_foreign` (`brand_id`),
  ADD KEY `commercial_vehicles_car_model_id_foreign` (`car_model_id`);

--
-- Ευρετήρια για πίνακα `commercial_vehicle_images`
--
ALTER TABLE `commercial_vehicle_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commercial_vehicle_images_commercial_vehicle_id_foreign` (`commercial_vehicle_id`);

--
-- Ευρετήρια για πίνακα `electronics`
--
ALTER TABLE `electronics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `electronics_user_id_foreign` (`user_id`),
  ADD KEY `electronics_brand_id_foreign` (`brand_id`),
  ADD KEY `electronics_electronic_model_id_foreign` (`electronic_model_id`);

--
-- Ευρετήρια για πίνακα `electronic_images`
--
ALTER TABLE `electronic_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `electronic_images_electronic_id_foreign` (`electronic_id`);

--
-- Ευρετήρια για πίνακα `electronic_models`
--
ALTER TABLE `electronic_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `electronic_models_brand_id_name_unique` (`brand_id`,`name`);

--
-- Ευρετήρια για πίνακα `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Ευρετήρια για πίνακα `household_items`
--
ALTER TABLE `household_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `household_items_user_id_foreign` (`user_id`),
  ADD KEY `household_items_brand_id_foreign` (`brand_id`);

--
-- Ευρετήρια για πίνακα `household_item_images`
--
ALTER TABLE `household_item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `household_item_images_household_item_id_foreign` (`household_item_id`);

--
-- Ευρετήρια για πίνακα `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Ευρετήρια για πίνακα `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `motorrad_ads`
--
ALTER TABLE `motorrad_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorrad_ads_user_id_foreign` (`user_id`),
  ADD KEY `motorrad_ads_brand_id_foreign` (`brand_id`),
  ADD KEY `motorrad_ads_car_model_id_foreign` (`car_model_id`);

--
-- Ευρετήρια για πίνακα `motorrad_ad_images`
--
ALTER TABLE `motorrad_ad_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorrad_ad_images_motorrad_ad_id_foreign` (`motorrad_ad_id`);

--
-- Ευρετήρια για πίνακα `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`id`),
  ADD KEY `others_user_id_foreign` (`user_id`);

--
-- Ευρετήρια για πίνακα `other_images`
--
ALTER TABLE `other_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `other_images_other_id_foreign` (`other_id`);

--
-- Ευρετήρια για πίνακα `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parts_brand_id_foreign` (`brand_id`),
  ADD KEY `parts_car_model_id_foreign` (`car_model_id`);

--
-- Ευρετήρια για πίνακα `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Ευρετήρια για πίνακα `real_estates`
--
ALTER TABLE `real_estates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `real_estates_user_id_foreign` (`user_id`);

--
-- Ευρετήρια για πίνακα `real_estate_images`
--
ALTER TABLE `real_estate_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `real_estate_images_real_estate_id_foreign` (`real_estate_id`);

--
-- Ευρετήρια για πίνακα `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `service_images`
--
ALTER TABLE `service_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_images_service_id_foreign` (`service_id`);

--
-- Ευρετήρια για πίνακα `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Ευρετήρια για πίνακα `used_vehicle_parts`
--
ALTER TABLE `used_vehicle_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `used_vehicle_parts_user_id_foreign` (`user_id`),
  ADD KEY `used_vehicle_parts_compatible_brand_id_foreign` (`compatible_brand_id`),
  ADD KEY `used_vehicle_parts_compatible_car_model_id_foreign` (`compatible_car_model_id`);

--
-- Ευρετήρια για πίνακα `used_vehicle_part_images`
--
ALTER TABLE `used_vehicle_part_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `used_vehicle_part_images_used_vehicle_part_id_foreign` (`used_vehicle_part_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `boats`
--
ALTER TABLE `boats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `boat_images`
--
ALTER TABLE `boat_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `campers`
--
ALTER TABLE `campers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `camper_images`
--
ALTER TABLE `camper_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT για πίνακα `commercial_vehicles`
--
ALTER TABLE `commercial_vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `commercial_vehicle_images`
--
ALTER TABLE `commercial_vehicle_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `electronics`
--
ALTER TABLE `electronics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `electronic_images`
--
ALTER TABLE `electronic_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `electronic_models`
--
ALTER TABLE `electronic_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT για πίνακα `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `household_items`
--
ALTER TABLE `household_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `household_item_images`
--
ALTER TABLE `household_item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT για πίνακα `motorrad_ads`
--
ALTER TABLE `motorrad_ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `motorrad_ad_images`
--
ALTER TABLE `motorrad_ad_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `others`
--
ALTER TABLE `others`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `other_images`
--
ALTER TABLE `other_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `parts`
--
ALTER TABLE `parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `real_estates`
--
ALTER TABLE `real_estates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `real_estate_images`
--
ALTER TABLE `real_estate_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `service_images`
--
ALTER TABLE `service_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `used_vehicle_parts`
--
ALTER TABLE `used_vehicle_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `used_vehicle_part_images`
--
ALTER TABLE `used_vehicle_part_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `boats`
--
ALTER TABLE `boats`
  ADD CONSTRAINT `boats_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `boats_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `boats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `boat_images`
--
ALTER TABLE `boat_images`
  ADD CONSTRAINT `boat_images_boat_id_foreign` FOREIGN KEY (`boat_id`) REFERENCES `boats` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `campers`
--
ALTER TABLE `campers`
  ADD CONSTRAINT `campers_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campers_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `camper_images`
--
ALTER TABLE `camper_images`
  ADD CONSTRAINT `camper_images_camper_id_foreign` FOREIGN KEY (`camper_id`) REFERENCES `campers` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `vehicles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `vehicles_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`),
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `vehicle_images_vehicle_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `car_models`
--
ALTER TABLE `car_models`
  ADD CONSTRAINT `car_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `commercial_vehicles`
--
ALTER TABLE `commercial_vehicles`
  ADD CONSTRAINT `commercial_vehicles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commercial_vehicles_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commercial_vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `commercial_vehicle_images`
--
ALTER TABLE `commercial_vehicle_images`
  ADD CONSTRAINT `commercial_vehicle_images_commercial_vehicle_id_foreign` FOREIGN KEY (`commercial_vehicle_id`) REFERENCES `commercial_vehicles` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `electronics`
--
ALTER TABLE `electronics`
  ADD CONSTRAINT `electronics_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `electronics_electronic_model_id_foreign` FOREIGN KEY (`electronic_model_id`) REFERENCES `electronic_models` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `electronics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `electronic_images`
--
ALTER TABLE `electronic_images`
  ADD CONSTRAINT `electronic_images_electronic_id_foreign` FOREIGN KEY (`electronic_id`) REFERENCES `electronics` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `electronic_models`
--
ALTER TABLE `electronic_models`
  ADD CONSTRAINT `electronic_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `household_items`
--
ALTER TABLE `household_items`
  ADD CONSTRAINT `household_items_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `household_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `household_item_images`
--
ALTER TABLE `household_item_images`
  ADD CONSTRAINT `household_item_images_household_item_id_foreign` FOREIGN KEY (`household_item_id`) REFERENCES `household_items` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `motorrad_ads`
--
ALTER TABLE `motorrad_ads`
  ADD CONSTRAINT `motorrad_ads_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `motorrad_ads_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `motorrad_ads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `motorrad_ad_images`
--
ALTER TABLE `motorrad_ad_images`
  ADD CONSTRAINT `motorrad_ad_images_motorrad_ad_id_foreign` FOREIGN KEY (`motorrad_ad_id`) REFERENCES `motorrad_ads` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `others`
--
ALTER TABLE `others`
  ADD CONSTRAINT `others_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `other_images`
--
ALTER TABLE `other_images`
  ADD CONSTRAINT `other_images_other_id_foreign` FOREIGN KEY (`other_id`) REFERENCES `others` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `parts_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE SET NULL;

--
-- Περιορισμοί για πίνακα `real_estates`
--
ALTER TABLE `real_estates`
  ADD CONSTRAINT `real_estates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `real_estate_images`
--
ALTER TABLE `real_estate_images`
  ADD CONSTRAINT `real_estate_images_real_estate_id_foreign` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estates` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `service_images`
--
ALTER TABLE `service_images`
  ADD CONSTRAINT `service_images_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `used_vehicle_parts`
--
ALTER TABLE `used_vehicle_parts`
  ADD CONSTRAINT `used_vehicle_parts_compatible_brand_id_foreign` FOREIGN KEY (`compatible_brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `used_vehicle_parts_compatible_car_model_id_foreign` FOREIGN KEY (`compatible_car_model_id`) REFERENCES `car_models` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `used_vehicle_parts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Περιορισμοί για πίνακα `used_vehicle_part_images`
--
ALTER TABLE `used_vehicle_part_images`
  ADD CONSTRAINT `used_vehicle_part_images_used_vehicle_part_id_foreign` FOREIGN KEY (`used_vehicle_part_id`) REFERENCES `used_vehicle_parts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
