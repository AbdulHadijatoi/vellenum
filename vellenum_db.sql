-- -------------------------------------------------------------
-- TablePlus 6.4.4(604)
--
-- https://tableplus.com/
--
-- Database: vellenum_db
-- Generation Time: 2025-09-07 12:36:29.3370
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_file_id` bigint unsigned DEFAULT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_file_id` bigint unsigned DEFAULT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_cover_file_id_foreign` (`cover_file_id`),
  KEY `books_book_file_id_foreign` (`book_file_id`),
  KEY `books_seller_id_foreign` (`seller_id`),
  CONSTRAINT `books_book_file_id_foreign` FOREIGN KEY (`book_file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `books_cover_file_id_foreign` FOREIGN KEY (`cover_file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `books_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delivery_partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ssn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delivery_partners_phone_unique` (`phone`),
  UNIQUE KEY `delivery_partners_ssn_unique` (`ssn`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `insurance_offerings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insurance_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_basic` decimal(10,2) DEFAULT NULL,
  `rate_standard` decimal(10,2) DEFAULT NULL,
  `rate_premium` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `seller_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insurance_offerings_seller_id_foreign` (`seller_id`),
  CONSTRAINT `insurance_offerings_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `otp_codes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `file_id` bigint unsigned NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_images_product_id_file_id_unique` (`product_id`,`file_id`),
  KEY `product_images_file_id_foreign` (`file_id`),
  CONSTRAINT `product_images_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `product_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product',
  `attributes` json DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_file_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_seller_id_foreign` (`seller_id`),
  KEY `products_product_category_id_foreign` (`product_category_id`),
  KEY `products_image_file_id_foreign` (`image_file_id`),
  CONSTRAINT `products_image_file_id_foreign` FOREIGN KEY (`image_file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `listing_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rental_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bedrooms` int DEFAULT NULL,
  `bathrooms` int DEFAULT NULL,
  `other_features` text COLLATE utf8mb4_unicode_ci,
  `seller_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `properties_seller_id_foreign` (`seller_id`),
  CONSTRAINT `properties_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `property_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned NOT NULL,
  `file_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_images_property_id_foreign` (`property_id`),
  KEY `property_images_file_id_foreign` (`file_id`),
  CONSTRAINT `property_images_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `property_images_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seller_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seller_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_menus_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_menus_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `seller_specializations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `specialization_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seller_specializations_seller_id_specialization_id_unique` (`seller_id`,`specialization_id`),
  KEY `seller_specializations_specialization_id_foreign` (`specialization_id`),
  CONSTRAINT `seller_specializations_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seller_specializations_specialization_id_foreign` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sellers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `seller_category_id` bigint unsigned NOT NULL,
  `operating_hours` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `years_of_experience` int DEFAULT NULL,
  `bar_association_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `government_issued_id` bigint unsigned DEFAULT NULL,
  `business_registration_certificate` bigint unsigned DEFAULT NULL,
  `food_safety_certifications` bigint unsigned DEFAULT NULL,
  `professional_license` bigint unsigned DEFAULT NULL,
  `legal_certifications` bigint unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delivery_partner_id` bigint unsigned DEFAULT NULL,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT '2025-09-07 06:08:05',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sellers_user_id_foreign` (`user_id`),
  KEY `sellers_seller_category_id_foreign` (`seller_category_id`),
  KEY `sellers_government_issued_id_foreign` (`government_issued_id`),
  KEY `sellers_business_registration_certificate_foreign` (`business_registration_certificate`),
  KEY `sellers_food_safety_certifications_foreign` (`food_safety_certifications`),
  KEY `sellers_professional_license_foreign` (`professional_license`),
  KEY `sellers_legal_certifications_foreign` (`legal_certifications`),
  KEY `sellers_delivery_partner_id_foreign` (`delivery_partner_id`),
  CONSTRAINT `sellers_business_registration_certificate_foreign` FOREIGN KEY (`business_registration_certificate`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_delivery_partner_id_foreign` FOREIGN KEY (`delivery_partner_id`) REFERENCES `delivery_partners` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_food_safety_certifications_foreign` FOREIGN KEY (`food_safety_certifications`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_government_issued_id_foreign` FOREIGN KEY (`government_issued_id`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_legal_certifications_foreign` FOREIGN KEY (`legal_certifications`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_professional_license_foreign` FOREIGN KEY (`professional_license`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sellers_seller_category_id_foreign` FOREIGN KEY (`seller_category_id`) REFERENCES `seller_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sellers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `pricing_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_seller_id_foreign` (`seller_id`),
  CONSTRAINT `services_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `specializations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `specializations_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Profile Image File ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vehicle_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` bigint unsigned NOT NULL,
  `file_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_photos_vehicle_id_foreign` (`vehicle_id`),
  KEY `vehicle_photos_file_id_foreign` (`file_id`),
  CONSTRAINT `vehicle_photos_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `vehicle_photos_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vehicles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `mileage` int DEFAULT NULL,
  `hourly_rate` decimal(8,2) NOT NULL,
  `license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `registration_document` bigint unsigned DEFAULT NULL,
  `insurance_document` bigint unsigned DEFAULT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicles_registration_document_foreign` (`registration_document`),
  KEY `vehicles_insurance_document_foreign` (`insurance_document`),
  KEY `vehicles_seller_id_foreign` (`seller_id`),
  CONSTRAINT `vehicles_insurance_document_foreign` FOREIGN KEY (`insurance_document`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `vehicles_registration_document_foreign` FOREIGN KEY (`registration_document`) REFERENCES `files` (`id`) ON DELETE SET NULL,
  CONSTRAINT `vehicles_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `books` (`id`, `title`, `author`, `price`, `genre`, `cover_file_id`, `format`, `book_file_id`, `seller_id`, `created_at`, `updated_at`) VALUES
(2, 'The Great Book', 'A. Author', 9.99, NULL, NULL, NULL, 10, 7, '2025-09-07 07:24:03', '2025-09-07 07:24:03'),
(3, 'test', 'A. Author', 9.99, 'test', 11, 'pdf', 12, 7, '2025-09-07 07:25:43', '2025-09-07 07:25:43');

INSERT INTO `delivery_partners` (`id`, `name`, `phone`, `ssn`) VALUES
(3, 'Speedy Delivery', '+15550987654', '123-45-6789');

INSERT INTO `files` (`id`, `original_name`, `filename`, `path`, `mime_type`, `extension`, `size`, `disk`, `category`, `description`, `metadata`, `uploaded_by`, `is_public`, `status`, `created_at`, `updated_at`) VALUES
(1, 'abstract-organic-shapes-seamless-pattern-vector-hand-drawn-curved-shape-with-drops-spots_775359-375.jpg', '23e3c28c-52ea-4b12-aed7-d80e9b9192dd.jpg', 'files/23e3c28c-52ea-4b12-aed7-d80e9b9192dd.jpg', 'image/jpeg', 'jpg', 269224, 'public', 'product_image', 'Primary shoe photo', NULL, 1, 1, 1, '2025-09-07 06:12:39', '2025-09-07 06:12:39'),
(2, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', 'b354e8e0-a45e-4c98-96f8-dff82a89b288.jpg', 'files/b354e8e0-a45e-4c98-96f8-dff82a89b288.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'seller_document', NULL, NULL, 5, 1, 1, '2025-09-07 07:03:12', '2025-09-07 07:03:12'),
(3, 'abstract-brush-stroke-pattern_23-2148702376.jpg', 'befb551b-59d9-4e90-94fd-06253a52aa54.jpg', 'files/befb551b-59d9-4e90-94fd-06253a52aa54.jpg', 'image/jpeg', 'jpg', 565709, 'public', 'seller_document', NULL, NULL, 5, 1, 1, '2025-09-07 07:03:12', '2025-09-07 07:03:12'),
(4, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', 'c2231945-8e5c-4362-9cd8-9169d7c6359c.jpg', 'files/c2231945-8e5c-4362-9cd8-9169d7c6359c.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'seller_document', NULL, NULL, 6, 1, 1, '2025-09-07 07:12:05', '2025-09-07 07:12:05'),
(5, 'abstract-brush-stroke-pattern_23-2148702376.jpg', 'ff1e5d43-d773-41a5-b507-43a0318f5986.jpg', 'files/ff1e5d43-d773-41a5-b507-43a0318f5986.jpg', 'image/jpeg', 'jpg', 565709, 'public', 'seller_document', NULL, NULL, 6, 1, 1, '2025-09-07 07:12:05', '2025-09-07 07:12:05'),
(6, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', '4aaa3f14-1288-49cf-8276-254c5d81d917.jpg', 'files/4aaa3f14-1288-49cf-8276-254c5d81d917.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'seller_document', NULL, NULL, 7, 1, 1, '2025-09-07 07:15:23', '2025-09-07 07:15:23'),
(7, 'abstract-brush-stroke-pattern_23-2148702376.jpg', 'e0a8e1f4-9a64-4b89-ac07-9ab1e47ef203.jpg', 'files/e0a8e1f4-9a64-4b89-ac07-9ab1e47ef203.jpg', 'image/jpeg', 'jpg', 565709, 'public', 'seller_document', NULL, NULL, 7, 1, 1, '2025-09-07 07:15:23', '2025-09-07 07:15:23'),
(8, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', '0fbf3bbb-6861-480d-adbb-4f98b5261fea.jpg', 'files/0fbf3bbb-6861-480d-adbb-4f98b5261fea.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'seller_document', NULL, NULL, 8, 1, 1, '2025-09-07 07:16:24', '2025-09-07 07:16:24'),
(9, 'abstract-brush-stroke-pattern_23-2148702376.jpg', '74411a3a-afbf-4a21-8b0b-5de9170306ca.jpg', 'files/74411a3a-afbf-4a21-8b0b-5de9170306ca.jpg', 'image/jpeg', 'jpg', 565709, 'public', 'seller_document', NULL, NULL, 8, 1, 1, '2025-09-07 07:16:24', '2025-09-07 07:16:24'),
(10, 'abstract-organic-shapes-seamless-pattern-vector-hand-drawn-curved-shape-with-drops-spots_775359-375.jpg', 'd8340727-53de-4f58-b829-baf31f53d7f8.jpg', 'files/d8340727-53de-4f58-b829-baf31f53d7f8.jpg', 'image/jpeg', 'jpg', 269224, 'public', 'book', NULL, NULL, 8, 1, 1, '2025-09-07 07:24:03', '2025-09-07 07:24:03'),
(11, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', '8442c719-1870-4595-bfc7-67d7a39ec218.jpg', 'files/8442c719-1870-4595-bfc7-67d7a39ec218.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'book', NULL, NULL, 8, 1, 1, '2025-09-07 07:25:43', '2025-09-07 07:25:43'),
(12, 'abstract-organic-shapes-seamless-pattern-vector-hand-drawn-curved-shape-with-drops-spots_775359-375.jpg', '22987477-9cab-4044-8475-bb75152c0576.jpg', 'files/22987477-9cab-4044-8475-bb75152c0576.jpg', 'image/jpeg', 'jpg', 269224, 'public', 'book', NULL, NULL, 8, 1, 1, '2025-09-07 07:25:43', '2025-09-07 07:25:43'),
(15, 'abstract-hand-drawn-pattern-collection_23-2148595458.jpg', '9319018c-c6ae-42c4-9093-26600d2a4c4e.jpg', 'files/9319018c-c6ae-42c4-9093-26600d2a4c4e.jpg', 'image/jpeg', 'jpg', 282977, 'public', 'seller_document', NULL, NULL, 10, 1, 1, '2025-09-07 07:35:24', '2025-09-07 07:35:24'),
(16, 'abstract-brush-stroke-pattern_23-2148702376.jpg', '99f40e12-b220-401d-9e29-06fddc4c8732.jpg', 'files/99f40e12-b220-401d-9e29-06fddc4c8732.jpg', 'image/jpeg', 'jpg', 565709, 'public', 'seller_document', NULL, NULL, 10, 1, 1, '2025-09-07 07:35:24', '2025-09-07 07:35:24');

INSERT INTO `insurance_offerings` (`id`, `insurance_name`, `insurance_type`, `rate_basic`, `rate_standard`, `rate_premium`, `description`, `seller_id`, `created_at`, `updated_at`) VALUES
(1, 'Basic Liability', 'Liability', 49.99, NULL, NULL, 'Basic liability plan', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_06_105821_create_permission_tables', 1),
(5, '2025_09_06_105827_create_oauth_auth_codes_table', 1),
(6, '2025_09_06_105828_create_oauth_access_tokens_table', 1),
(7, '2025_09_06_105829_create_oauth_refresh_tokens_table', 1),
(8, '2025_09_06_105830_create_oauth_clients_table', 1),
(9, '2025_09_06_105831_create_oauth_device_codes_table', 1),
(10, '2025_09_06_110818_add_common_fields_to_users_table', 1),
(11, '2025_09_06_110818_create_files_table', 1),
(12, '2025_09_06_110911_create_seller_categories_table', 1),
(13, '2025_09_06_110922_create_sellers_table', 1),
(14, '2025_09_06_111021_create_product_categories_table', 1),
(15, '2025_09_06_111053_create_products_table', 1),
(16, '2025_09_06_113915_create_otp_codes_table', 1),
(17, '2025_09_06_113942_update_products_table_use_file_references', 1),
(18, '2025_09_06_113951_create_product_images_table', 1),
(19, '2025_09_07_021508_create_specializations_table', 1),
(20, '2025_09_07_022007_create_seller_specializations_table', 1),
(21, '2025_09_07_023611_create_insurance_offerings_table', 1),
(22, '2025_09_07_024624_create_books_table', 1),
(23, '2025_09_07_025012_create_properties_table', 1),
(24, '2025_09_07_025350_create_property_images_table', 1),
(25, '2025_09_07_025959_create_services_table', 1),
(26, '2025_09_07_030504_create_seller_menus_table', 1),
(27, '2025_09_07_032951_create_delivery_partners_table', 1),
(28, '2025_09_07_034210_create_vehicles_table', 1),
(29, '2025_09_07_034340_create_vehicle_photos_table', 1),
(30, '2025_09_07_070639_add_delivery_partner_id_to_sellers_table', 2);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10);

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('03c6e570d5e21b6f2d9a3543a844434b013e6b3f99378445dca8993a75df1f5ff60258793793b7d1', 1, '019922cc-1e4c-7342-b6a8-32df75695d5a', 'auth_token', '[]', 0, '2025-09-07 06:11:33', '2025-09-07 06:11:33', '2026-09-07 06:11:33'),
('244d36b6924ccef36d508d9a13b06a23bb8d2c83103c5adbbd642e8b0a32131a5c44ed7cdc710c7d', 9, '019922cc-1e4c-7342-b6a8-32df75695d5a', 'auth_token', '[]', 0, '2025-09-07 07:31:45', '2025-09-07 07:31:45', '2026-09-07 07:31:45'),
('98a1f7a49e9f36bb5be0717ecc213a3e5fca6e11c98876328708d781dba6f4b13e68c9c95390c268', 8, '019922cc-1e4c-7342-b6a8-32df75695d5a', 'auth_token', '[]', 0, '2025-09-07 07:21:18', '2025-09-07 07:21:18', '2026-09-07 07:21:18'),
('d068652ea2d88cc5b380fc489d8ec394d5c12697ecdd0f31510173290ce3d6f38c789d1e83c5a228', 1, '019922cc-1e4c-7342-b6a8-32df75695d5a', 'auth_token', '[]', 1, '2025-09-07 06:10:37', '2025-09-07 06:11:26', '2026-09-07 06:10:37');

INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
('019922cc-1e4c-7342-b6a8-32df75695d5a', NULL, NULL, 'Vellenum', '$2y$12$GwoZjI41G2l304P2jCuY3.QSp9S/151IxgSqTBMcr1ci6Aqir85dK', 'users', '[]', '[\"personal_access\"]', 0, '2025-09-07 06:10:26', '2025-09-07 06:10:26');

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage-users', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(2, 'view-users', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(3, 'create-users', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(4, 'edit-users', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(5, 'delete-users', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(6, 'manage-sellers', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(7, 'view-sellers', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(8, 'create-sellers', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(9, 'edit-sellers', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(10, 'delete-sellers', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(11, 'manage-products', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(12, 'view-products', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(13, 'create-products', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(14, 'edit-products', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(15, 'delete-products', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(16, 'manage-orders', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(17, 'view-orders', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(18, 'create-orders', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(19, 'edit-orders', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(20, 'delete-orders', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(21, 'manage-categories', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(22, 'view-categories', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(23, 'create-categories', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(24, 'edit-categories', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(25, 'delete-categories', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(26, 'view-admin-dashboard', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(27, 'view-seller-dashboard', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(28, 'view-buyer-dashboard', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(29, 'manage-own-profile', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(30, 'view-own-profile', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08');

INSERT INTO `properties` (`id`, `title`, `property_type`, `features`, `listing_type`, `rental_type`, `price`, `address`, `city`, `zipcode`, `size`, `bedrooms`, `bathrooms`, `other_features`, `seller_id`, `created_at`, `updated_at`) VALUES
(1, 'Cozy Cottage', 'House', '[\"garden\", \"fireplace\"]', 'Sale', 'N/A', 250000.00, '1 Ocean View', 'San Diego', '92101', '1200 sqft', 3, 2, NULL, 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09');

INSERT INTO `property_images` (`id`, `property_id`, `file_id`) VALUES
(1, 1, 1);

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(27, 2),
(28, 1),
(28, 3),
(29, 1),
(29, 2),
(29, 3),
(30, 1),
(30, 2),
(30, 3);

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(2, 'seller', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(3, 'buyer', 'web', '2025-09-07 06:08:08', '2025-09-07 06:08:08');

INSERT INTO `seller_categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Restaurant', 'Food and beverage services', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(2, 'Apparel', 'Clothing and fashion items', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(3, 'Fleet', 'Fleet management services', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(4, 'Automobile Sales Representative', 'Automobile sales and representation', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(5, 'Car Rental Marketplace', 'Car rental services', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(6, 'Car Wash', 'Vehicle cleaning services', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(7, 'Insurance Marketplace', 'Insurance services and products', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(8, 'Digital Bookstore', 'Digital books and publications', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(9, 'Real Estate Broker', 'Real estate services', 1, '2025-09-07 06:08:08', '2025-09-07 06:08:08'),
(10, 'Black Clothing Lines & Accessories', 'Black-owned clothing and accessories', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(11, 'LegalShield Marketplace', 'Legal services and protection', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(12, 'Retail Store', 'Retail services and products', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(13, 'Barber Beauty Salon', 'Hair and beauty services', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(14, 'Personal Injury Attorney', 'Personal injury legal services', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(15, 'Mississippi Catfish Company', 'Fresh seafood and catfish products', 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09');

INSERT INTO `seller_menus` (`id`, `seller_id`, `name`, `category`, `description`, `price`, `duration`, `discount`, `created_at`, `updated_at`) VALUES
(1, 1, 'Classic Haircut', 'Hair', 'Classic men\'s haircut', 25.00, '30 mins', NULL, '2025-09-07 06:08:09', '2025-09-07 06:08:09');

INSERT INTO `sellers` (`id`, `user_id`, `seller_category_id`, `operating_hours`, `license_number`, `years_of_experience`, `bar_association_number`, `license_expiry_date`, `government_issued_id`, `business_registration_certificate`, `food_safety_certifications`, `professional_license`, `legal_certifications`, `status`, `delivery_partner_id`, `rejection_reason`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"18:00\"}}', 'LIC-0001', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 06:08:09', '2025-09-07 06:08:09'),
(2, 3, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:01:27', '2025-09-07 07:01:27'),
(3, 4, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:01:57', '2025-09-07 07:01:57'),
(4, 5, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, 3, 2, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:03:12', '2025-09-07 07:03:12'),
(5, 6, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, 5, 4, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:12:05', '2025-09-07 07:12:05'),
(6, 7, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, 7, 6, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:15:23', '2025-09-07 07:15:23'),
(7, 8, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, 9, 8, NULL, NULL, 1, 3, NULL, '2025-09-07 06:08:05', '2025-09-07 07:16:24', '2025-09-07 07:16:24'),
(8, 9, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2025-09-07 06:08:05', '2025-09-07 07:31:25', '2025-09-07 07:31:25'),
(9, 10, 1, '{\"monday\":{\"start\":\"09:00\",\"end\":\"21:00\"}}', 'ABC123456', NULL, NULL, NULL, NULL, 16, 15, NULL, NULL, 1, 3, NULL, '2025-09-07 06:08:05', '2025-09-07 07:35:24', '2025-09-07 07:35:24');

INSERT INTO `services` (`id`, `name`, `description`, `pricing_model`, `price`, `seller_id`, `created_at`, `updated_at`) VALUES
(1, 'Personal Injury Consultation', 'One hour consultation with attorney', 'hourly', 200.00, 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H3L9tO7yvcbKZEPHqTSlA8wNlv8ZUx32pge2BdQS', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZm5kVWhCWmRZTUtFTGxxMEp6WFFMOWZ5Z2VsazVkSDdmR1BmTXhpYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1757226260);

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `country`, `state`, `city`, `zip_code`, `otp`, `status`, `otp_expires_at`, `is_verified`, `created_at`, `updated_at`, `email_verified_at`, `remember_token`, `file_id`) VALUES
(1, 'Test User', 'test@example.com', '$2y$12$i3pbSMv7zZiKsx4dyeBmNepijtgWOcsC47JoKcA1uhYsu6Omz/TM2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2025-09-07 06:08:08', '2025-09-07 06:08:46', '2025-09-07 06:08:08', 'xs13rTrdhE', NULL),
(2, 'Joe\'s Diner', 'restaurant@example.com', '$2y$12$3Kf6oTK53Zqe4StefJQ16u3ztMpbMe/fZuTyd0VX1kl9hF/vPGjrW', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:00:52', '2025-09-07 07:00:52', NULL, NULL, NULL),
(3, 'Joe\'s Diner', 'restaurant2@example.com', '$2y$12$.fjrDrLC1R6yYySDt5iXuu2TuQ6I9GBoeSUIkXsZUixS.KmV6mA2.', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:01:27', '2025-09-07 07:01:27', NULL, NULL, NULL),
(4, 'Joe\'s Diner', 'restaurant3@example.com', '$2y$12$FjcRVraTbpp.FF9o/o6GY.Y6K3xqqwnrsVVrVtaA18jPLFjGxOjgG', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:01:57', '2025-09-07 07:01:57', NULL, NULL, NULL),
(5, 'Joe\'s Diner', 'restaurant4@example.com', '$2y$12$rMVbtpIg2XJua76OIUye2utuoSj4SPzUC5OCTl53wTbLT/N.TEKFS', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:03:12', '2025-09-07 07:03:12', NULL, NULL, NULL),
(6, 'Joe\'s Diner', 'restaurant5@example.com', '$2y$12$/N4IXjObusUtFDdOLtpOV.3FhtD2c6SGGCUz367Nv16j3nLkA2vCe', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:12:05', '2025-09-07 07:12:05', NULL, NULL, NULL),
(7, 'Joe\'s Diner', 'restaurant6@example.com', '$2y$12$9qH3sNu.gy0dAwZN5ck7se5EpVitbVFBGhWdbyp7X1dypyLs85bEm', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:15:23', '2025-09-07 07:15:23', NULL, NULL, NULL),
(8, 'Joe\'s Diner', 'restaurant7@example.com', '$2y$12$T/8QHK3R8PTqtIz1wLEAReTNQtR5EueuBTb2Vk31lfxhyTHXsqb2O', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:16:24', '2025-09-07 07:21:04', NULL, NULL, NULL),
(9, 'Apparel Shop', 'apparel@example.com', '$2y$12$mIKZZ5sw6VLg0B8ABKZz6OnyO7HkmbDk447P/KRAwMPD5azdjNH7y', '+15551230000', NULL, 'USA', 'NY', 'New York', '10001', NULL, 1, NULL, 0, '2025-09-07 07:31:25', '2025-09-07 07:31:25', NULL, NULL, NULL),
(10, 'Joe\'s Diner', 'restaurant8@example.com', '$2y$12$NFxlm7ZiLK69mq81oDntje9JkUDM3zjL4.RJGx5CajP0ynmS5n2ha', '+15550123456', NULL, 'USA', 'TX', 'Austin', '73301', NULL, 1, NULL, 0, '2025-09-07 07:35:24', '2025-09-07 07:35:24', NULL, NULL, NULL);

INSERT INTO `vehicles` (`id`, `name`, `make`, `model`, `year`, `mileage`, `hourly_rate`, `license_number`, `registration_date`, `registration_document`, `insurance_document`, `seller_id`, `created_at`, `updated_at`) VALUES
(1, 'Van A', 'Ford', 'Transit', '2018', 50000, 25.00, 'ABC-123', '2025-09-07', NULL, NULL, 1, '2025-09-07 06:08:09', '2025-09-07 06:08:09');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;