/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `boat_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boat_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `boat_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boat_images_boat_id_foreign` (`boat_id`),
  CONSTRAINT `boat_images_boat_id_foreign` FOREIGN KEY (`boat_id`) REFERENCES `boats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `boats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year_of_construction` year(4) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `boat_type` varchar(255) NOT NULL,
  `material` varchar(255) DEFAULT NULL,
  `total_length` decimal(5,2) DEFAULT NULL,
  `total_width` decimal(5,2) DEFAULT NULL,
  `berths` tinyint(3) unsigned DEFAULT NULL,
  `engine_type` varchar(255) DEFAULT NULL,
  `engine_power` int(10) unsigned DEFAULT NULL,
  `operating_hours` int(10) unsigned DEFAULT NULL,
  `last_service` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boats_user_id_foreign` (`user_id`),
  CONSTRAINT `boats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `camper_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `camper_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `camper_brands_name_unique` (`name`),
  UNIQUE KEY `camper_brands_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `camper_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `camper_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `camper_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `camper_images_camper_id_foreign` (`camper_id`),
  CONSTRAINT `camper_images_camper_id_foreign` FOREIGN KEY (`camper_id`) REFERENCES `campers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `camper_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `camper_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `camper_brand_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `year_from` int(11) DEFAULT NULL,
  `year_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `camper_models_name_camper_brand_id_unique` (`name`,`camper_brand_id`),
  UNIQUE KEY `camper_models_slug_unique` (`slug`),
  KEY `camper_models_camper_brand_id_foreign` (`camper_brand_id`),
  CONSTRAINT `camper_models_camper_brand_id_foreign` FOREIGN KEY (`camper_brand_id`) REFERENCES `camper_brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `campers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `camper_brand_id` bigint(20) unsigned NOT NULL,
  `camper_model_id` bigint(20) unsigned DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `camper_type` varchar(255) NOT NULL,
  `berths` int(11) NOT NULL,
  `total_length` decimal(4,1) NOT NULL,
  `total_width` decimal(4,1) NOT NULL,
  `total_height` decimal(4,1) NOT NULL,
  `gross_vehicle_weight` int(11) NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `transmission` varchar(255) NOT NULL,
  `emission_class` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campers_user_id_foreign` (`user_id`),
  KEY `campers_camper_brand_id_foreign` (`camper_brand_id`),
  KEY `campers_camper_model_id_foreign` (`camper_model_id`),
  CONSTRAINT `campers_camper_brand_id_foreign` FOREIGN KEY (`camper_brand_id`) REFERENCES `camper_brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `campers_camper_model_id_foreign` FOREIGN KEY (`camper_model_id`) REFERENCES `camper_models` (`id`) ON DELETE SET NULL,
  CONSTRAINT `campers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `car_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_brands_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `car_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_images_vehicle_id_foreign` (`car_id`),
  CONSTRAINT `vehicle_images_vehicle_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `car_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `car_brand_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_models_car_brand_id_name_unique` (`car_brand_id`,`name`),
  UNIQUE KEY `car_models_slug_unique` (`slug`),
  CONSTRAINT `car_models_car_brand_id_foreign` FOREIGN KEY (`car_brand_id`) REFERENCES `car_brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_slug` varchar(255) NOT NULL,
  `car_brand_id` bigint(20) unsigned DEFAULT NULL,
  `car_model_id` bigint(20) unsigned DEFAULT NULL,
  `price` int(10) unsigned DEFAULT NULL,
  `mileage` int(10) unsigned DEFAULT NULL,
  `registration` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `power` int(10) unsigned DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `drive` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `doors` tinyint(3) unsigned DEFAULT NULL,
  `seats` tinyint(3) unsigned DEFAULT NULL,
  `seller_type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vehicles_slug_unique` (`slug`),
  KEY `vehicles_car_brand_id_foreign` (`car_brand_id`),
  KEY `vehicles_car_model_id_foreign` (`car_model_id`),
  KEY `vehicles_user_id_foreign` (`user_id`),
  CONSTRAINT `vehicles_car_brand_id_foreign` FOREIGN KEY (`car_brand_id`) REFERENCES `car_brands` (`id`),
  CONSTRAINT `vehicles_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`),
  CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commercial_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commercial_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commercial_brands_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commercial_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commercial_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commercial_brand_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commercial_models_commercial_brand_id_name_unique` (`commercial_brand_id`,`name`),
  CONSTRAINT `commercial_models_commercial_brand_id_foreign` FOREIGN KEY (`commercial_brand_id`) REFERENCES `commercial_brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commercial_vehicle_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commercial_vehicle_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commercial_vehicle_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commercial_vehicle_images_commercial_vehicle_id_foreign` (`commercial_vehicle_id`),
  CONSTRAINT `commercial_vehicle_images_commercial_vehicle_id_foreign` FOREIGN KEY (`commercial_vehicle_id`) REFERENCES `commercial_vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `commercial_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commercial_vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `commercial_brand_id` bigint(20) unsigned NOT NULL,
  `commercial_model_id` bigint(20) unsigned NOT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(10) unsigned NOT NULL,
  `power` int(10) unsigned DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `commercial_vehicle_type` varchar(255) NOT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `payload_capacity` int(10) unsigned DEFAULT NULL,
  `gross_vehicle_weight` int(10) unsigned DEFAULT NULL,
  `number_of_axles` tinyint(3) unsigned DEFAULT NULL,
  `emission_class` varchar(255) DEFAULT NULL,
  `seats` tinyint(3) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commercial_vehicles_user_id_foreign` (`user_id`),
  KEY `commercial_vehicles_commercial_brand_id_foreign` (`commercial_brand_id`),
  KEY `commercial_vehicles_commercial_model_id_foreign` (`commercial_model_id`),
  CONSTRAINT `commercial_vehicles_commercial_brand_id_foreign` FOREIGN KEY (`commercial_brand_id`) REFERENCES `commercial_brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commercial_vehicles_commercial_model_id_foreign` FOREIGN KEY (`commercial_model_id`) REFERENCES `commercial_models` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commercial_vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `electronic_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `electronic_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `electronic_brands_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `electronic_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `electronic_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `electronic_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `electronic_images_electronic_id_foreign` (`electronic_id`),
  CONSTRAINT `electronic_images_electronic_id_foreign` FOREIGN KEY (`electronic_id`) REFERENCES `electronics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `electronic_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `electronic_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `electronic_models_brand_id_name_unique` (`brand_id`,`name`),
  CONSTRAINT `electronic_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `electronic_brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `electronics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `electronics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `electronic_model_id` bigint(20) unsigned DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `year_of_purchase` int(11) DEFAULT NULL,
  `warranty_status` varchar(255) DEFAULT NULL,
  `accessories` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `usage_time` varchar(255) DEFAULT NULL,
  `power` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL,
  `storage_capacity` varchar(255) DEFAULT NULL,
  `screen_size` varchar(255) DEFAULT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `electronics_user_id_foreign` (`user_id`),
  KEY `electronics_brand_id_foreign` (`brand_id`),
  KEY `electronics_electronic_model_id_foreign` (`electronic_model_id`),
  CONSTRAINT `electronics_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `electronic_brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `electronics_electronic_model_id_foreign` FOREIGN KEY (`electronic_model_id`) REFERENCES `electronic_models` (`id`) ON DELETE SET NULL,
  CONSTRAINT `electronics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `household_item_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `household_item_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `household_item_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `household_item_images_household_item_id_foreign` (`household_item_id`),
  CONSTRAINT `household_item_images_household_item_id_foreign` FOREIGN KEY (`household_item_id`) REFERENCES `household_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `household_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `household_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `household_items_user_id_foreign` (`user_id`),
  CONSTRAINT `household_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `motorcycle_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motorcycle_brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `motorcycle_brands_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `motorcycle_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motorcycle_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `motorcycle_brand_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `motorcycle_models_motorcycle_brand_id_name_unique` (`motorcycle_brand_id`,`name`),
  CONSTRAINT `motorcycle_models_motorcycle_brand_id_foreign` FOREIGN KEY (`motorcycle_brand_id`) REFERENCES `motorcycle_brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `motorrad_ad_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motorrad_ad_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `motorrad_ad_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `motorrad_ad_images_motorrad_ad_id_foreign` (`motorrad_ad_id`),
  CONSTRAINT `motorrad_ad_images_motorrad_ad_id_foreign` FOREIGN KEY (`motorrad_ad_id`) REFERENCES `motorrad_ads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `motorrad_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motorrad_ads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `motorcycle_brand_id` bigint(20) unsigned DEFAULT NULL,
  `motorcycle_model_id` bigint(20) unsigned DEFAULT NULL,
  `first_registration` date NOT NULL,
  `mileage` int(10) unsigned NOT NULL,
  `power` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `color` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `motorrad_ads_user_id_foreign` (`user_id`),
  KEY `motorrad_ads_motorcycle_brand_id_foreign` (`motorcycle_brand_id`),
  KEY `motorrad_ads_motorcycle_model_id_foreign` (`motorcycle_model_id`),
  CONSTRAINT `motorrad_ads_motorcycle_brand_id_foreign` FOREIGN KEY (`motorcycle_brand_id`) REFERENCES `motorcycle_brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `motorrad_ads_motorcycle_model_id_foreign` FOREIGN KEY (`motorcycle_model_id`) REFERENCES `motorcycle_models` (`id`) ON DELETE SET NULL,
  CONSTRAINT `motorrad_ads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `other_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `other_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `other_images_other_id_foreign` (`other_id`),
  CONSTRAINT `other_images_other_id_foreign` FOREIGN KEY (`other_id`) REFERENCES `others` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `others`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `others` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_slug` varchar(255) NOT NULL DEFAULT 'sonstiges',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `others_user_id_foreign` (`user_id`),
  CONSTRAINT `others_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_slug` varchar(255) NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `car_model_id` bigint(20) unsigned DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `price_from` decimal(10,2) DEFAULT NULL,
  `registration_to` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parts_brand_id_foreign` (`brand_id`),
  KEY `parts_car_model_id_foreign` (`car_model_id`),
  CONSTRAINT `parts_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `parts_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `real_estate_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `real_estate_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `real_estate_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `real_estate_images_real_estate_id_foreign` (`real_estate_id`),
  CONSTRAINT `real_estate_images_real_estate_id_foreign` FOREIGN KEY (`real_estate_id`) REFERENCES `real_estates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `real_estates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `real_estates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_slug` varchar(255) NOT NULL DEFAULT 'immobilien',
  `immobilientyp` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `purchase_price` decimal(12,2) DEFAULT NULL,
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
  `price` decimal(10,2) DEFAULT NULL,
  `wohnflaeche` decimal(10,2) DEFAULT NULL,
  `grundflaeche` decimal(10,2) DEFAULT NULL,
  `kaution` decimal(10,2) DEFAULT NULL,
  `maklerprovision` decimal(10,2) DEFAULT NULL,
  `abloese` decimal(10,2) DEFAULT NULL,
  `ausstattung` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ausstattung`)),
  `heizung` varchar(255) DEFAULT NULL,
  `grundriss_path` varchar(255) DEFAULT NULL,
  `energieausweis_path` varchar(255) DEFAULT NULL,
  `rundgang_link` varchar(255) DEFAULT NULL,
  `objektinformationen_link` varchar(255) DEFAULT NULL,
  `zustandsbericht_link` varchar(255) DEFAULT NULL,
  `verkaufsbericht_link` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `real_estates_user_id_foreign` (`user_id`),
  CONSTRAINT `real_estates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `service_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_images_service_id_foreign` (`service_id`),
  CONSTRAINT `service_images_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_slug` varchar(255) NOT NULL DEFAULT 'dienstleistungen',
  `service_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_user_id_foreign` (`user_id`),
  CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `used_vehicle_part_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `used_vehicle_part_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `used_vehicle_part_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `used_vehicle_part_images_used_vehicle_part_id_foreign` (`used_vehicle_part_id`),
  CONSTRAINT `used_vehicle_part_images_used_vehicle_part_id_foreign` FOREIGN KEY (`used_vehicle_part_id`) REFERENCES `used_vehicle_parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `used_vehicle_parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `used_vehicle_parts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `part_category` varchar(255) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `manufacturer_part_number` varchar(255) DEFAULT NULL,
  `condition` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `compatible_brand` varchar(255) DEFAULT NULL,
  `compatible_model` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `compatible_year_from` year(4) DEFAULT NULL,
  `compatible_year_to` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `used_vehicle_parts_user_id_foreign` (`user_id`),
  CONSTRAINT `used_vehicle_parts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2025_07_15_110000_create_car_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2025_07_15_111132_create_categories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2025_07_18_103422_create_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2025_07_18_103422_create_car_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2025_07_18_141736_create_vehicles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_07_18_144328_create_vehicle_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_07_20_085911_create_parts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_07_20_094130_create_real_estates_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_07_20_095055_create_services_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_07_20_131538_create_boats_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_07_20_131543_create_others_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_07_21_081605_create_motorcycle_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_07_21_081605_create_motorcycle_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_07_21_093444_create_camper_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_07_21_093447_create_camper_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_07_22_080008_create_motorrad_ads_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2025_07_22_085627_create_campers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2025_07_22_091033_create_used_vehicle_parts_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2025_07_22_112112_create_household_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2025_07_24_142757_create_real_estate_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2025_07_24_143018_create_service_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2025_07_24_143129_create_other_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2025_07_24_151544_remove_image_paths_from_household_items_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_07_25_122639_rename_vehicle_id_to_car_id_in_car_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2025_07_25_124012_rename_vehicles_table_to_cars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2025_07_25_124102_rename_vehicle_images_table_to_car_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2025_07_26_084011_create_household_item_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_07_26_090028_remove_images_column_from_real_estates_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_07_26_111317_rename_path_to_image_path_in_other_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2025_07_26_111400_rename_path_to_image_path_in_service_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2025_07_29_071532_create_electronic_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2025_07_29_071555_create_electronic_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_07_29_071616_create_electronics_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_07_29_071641_create_electronic_images_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_07_29_123211_rename_brands_table_and_columns',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2025_07_30_071842_add_price_to_motorrad_ads_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_07_30_171200_add_role_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2025_08_01_053700_create_commercial_brands_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2025_08_01_053710_create_commercial_models_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2025_08_01_053800_create_commercial_vehicles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2025_08_01_061816_rename_brand_and_model_columns_in_commercial_vehicles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2025_08_02_065554_add_profile_fields_to_users_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_08_02_070831_create_personal_access_tokens_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_08_03_073917_alter_used_vehicle_parts_compatibility_columns',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_08_03_085330_add_profile_image_to_users_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_08_03_103456_rename_gesamtmiete_to_price_in_real_estate_table',6);
