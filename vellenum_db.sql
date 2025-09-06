-- -------------------------------------------------------------
-- TablePlus 6.4.4(604)
--
-- https://tableplus.com/
--
-- Database: vellenum_db
-- Generation Time: 2025-09-06 23:07:33.0220
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


INSERT INTO `files` (`id`, `original_name`, `filename`, `path`, `mime_type`, `extension`, `size`, `disk`, `category`, `description`, `metadata`, `uploaded_by`, `is_public`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'abstract-watercolor-geometric-pattern_23-2149203334.jpg', 'f453a247-71ef-4b17-a8ff-87adf2051d40.jpg', 'files/f453a247-71ef-4b17-a8ff-87adf2051d40.jpg', 'image/jpeg', 'jpg', 148769, 'public', 'seller_document', NULL, NULL, 5, 1, 1, '2025-09-06 17:54:16', '2025-09-06 17:54:16'),
(2, 'abstract-organic-shapes-seamless-pattern-vector-hand-drawn-curved-shape-with-drops-spots_775359-375.jpg', '14ad715d-d4c6-4aa0-ad09-b90d8fc8f1f6.jpg', 'files/14ad715d-d4c6-4aa0-ad09-b90d8fc8f1f6.jpg', 'image/jpeg', 'jpg', 269224, 'public', 'seller_document', NULL, NULL, 5, 1, 1, '2025-09-06 17:54:16', '2025-09-06 17:54:16');

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
(10, '2025_09_06_110818_add_common_fields_to_users_table', 2),
(11, '2025_09_06_110911_create_seller_categories_table', 2),
(12, '2025_09_06_110922_create_sellers_table', 2),
(13, '2025_09_06_111021_create_product_categories_table', 2),
(14, '2025_09_06_111053_create_products_table', 2),
(15, '2025_09_06_113915_create_files_table', 3),
(16, '2025_09_06_113926_update_sellers_table_use_file_references', 3),
(17, '2025_09_06_113942_update_products_table_use_file_references', 3),
(18, '2025_09_06_113951_create_product_images_table', 3),
(19, '2025_09_06_113915_create_otp_codes_table', 4);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5);

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('18e18acb6f269f4c71c7fa6ff0a0ea89b20ea744c1d2fd155d41cd1f291addc2b5070d2852f3fd9b', 1, '01991eaf-fd3f-7196-b9ef-9bca113f0779', 'auth_token', '[]', 1, '2025-09-06 13:16:50', '2025-09-06 13:17:05', '2026-09-06 13:16:50'),
('7d6ed22f926479f87270f119ddb9bb6a402f297508be3b66a9795b4598d182fa54b8701568cd5d08', 1, '01991eaf-fd3f-7196-b9ef-9bca113f0779', 'auth_token', '[]', 0, '2025-09-06 13:15:44', '2025-09-06 13:15:44', '2026-09-06 13:15:44'),
('ad4c643b8208bf7e9ab15f99f24b4bd4756082bb3a84eaeecf6cde9a993b423c0d2051bc0193e9ee', 1, '01991eaf-fd3f-7196-b9ef-9bca113f0779', 'auth_token', '[]', 1, '2025-09-06 13:08:14', '2025-09-06 13:15:08', '2026-09-06 13:08:14');

INSERT INTO `oauth_clients` (`id`, `owner_type`, `owner_id`, `name`, `secret`, `provider`, `redirect_uris`, `grant_types`, `revoked`, `created_at`, `updated_at`) VALUES
('01991eaf-fd3f-7196-b9ef-9bca113f0779', NULL, NULL, 'Vellenum', '$2y$12$acocnVxLUJONRRcRqE/VG.VhyR/vxUiYq.66gYgXb0lr.FrJObh3G', 'users', '[]', '[\"personal_access\"]', 0, '2025-09-06 11:01:14', '2025-09-06 11:01:14');

INSERT INTO `otp_codes` (`id`, `email`, `phone`, `otp_code`, `expires_at`, `is_used`) VALUES
(1, 'test@example.com', NULL, '673893', '2025-09-06 13:21:19', 0),
(2, 'test@example.com', NULL, '222426', '2025-09-06 13:21:49', 0),
(3, 'test@example.com', NULL, '701854', '2025-09-06 13:22:00', 0),
(4, 'test@example.com', NULL, '199823', '2025-09-06 13:22:42', 0),
(5, 'test@example.com', NULL, '618816', '2025-09-06 13:23:22', 1);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage-users', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(2, 'view-users', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(3, 'create-users', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(4, 'edit-users', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(5, 'delete-users', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(6, 'manage-sellers', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(7, 'view-sellers', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(8, 'create-sellers', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(9, 'edit-sellers', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(10, 'delete-sellers', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(11, 'manage-products', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(12, 'view-products', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(13, 'create-products', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(14, 'edit-products', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(15, 'delete-products', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(16, 'manage-orders', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(17, 'view-orders', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(18, 'create-orders', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(19, 'edit-orders', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(20, 'delete-orders', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(21, 'manage-categories', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(22, 'view-categories', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(23, 'create-categories', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(24, 'edit-categories', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(25, 'delete-categories', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(26, 'view-admin-dashboard', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(27, 'view-seller-dashboard', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(28, 'view-buyer-dashboard', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(29, 'manage-own-profile', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(30, 'view-own-profile', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24');

INSERT INTO `product_categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Food & Beverage', 'food-beverage', 'Food and beverage products', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(2, 'Clothing & Accessories', 'clothing-accessories', 'Clothing and fashion accessories', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(3, 'Automotive', 'automotive', 'Automotive products and services', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(4, 'Insurance', 'insurance', 'Insurance products and services', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(5, 'Books & Media', 'books-media', 'Books and digital media', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(6, 'Real Estate', 'real-estate', 'Real estate properties and services', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(7, 'Beauty & Wellness', 'beauty-wellness', 'Beauty and wellness services', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(8, 'Legal Services', 'legal-services', 'Legal services and consultation', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19'),
(9, 'Seafood', 'seafood', 'Fresh seafood and fish products', NULL, 1, '2025-09-06 11:36:19', '2025-09-06 11:36:19');

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
(1, 'admin', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(2, 'seller', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24'),
(3, 'buyer', 'web', '2025-09-06 11:22:24', '2025-09-06 11:22:24');

INSERT INTO `seller_categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Restaurant', 'restaurant', 'Food and beverage services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(2, 'Apparel', 'apparel', 'Clothing and fashion items', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(3, 'Fleet', 'fleet', 'Fleet management services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(4, 'Automobile Sales Representative', 'automobile-sales-representative', 'Automobile sales and representation', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(5, 'Car Rental Marketplace', 'car-rental-marketplace', 'Car rental services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(6, 'Car Wash', 'car-wash', 'Vehicle cleaning services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(7, 'Insurance Marketplace', 'insurance-marketplace', 'Insurance services and products', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(8, 'Digital Bookstore', 'digital-bookstore', 'Digital books and publications', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(9, 'Real Estate Broker', 'real-estate-broker', 'Real estate services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(10, 'Black Clothing Lines & Accessories', 'black-clothing-lines-accessories', 'Black-owned clothing and accessories', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(11, 'LegalShield Marketplace', 'legalshield-marketplace', 'Legal services and protection', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(12, 'Barber Beauty Salon', 'barber-beauty-salon', 'Hair and beauty services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(13, 'Personal Injury Attorney', 'personal-injury-attorney', 'Personal injury legal services', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27'),
(14, 'Mississippi Catfish Company', 'mississippi-catfish-company', 'Fresh seafood and catfish products', 1, '2025-09-06 11:22:27', '2025-09-06 11:22:27');

INSERT INTO `sellers` (`id`, `user_id`, `seller_category_id`, `operating_hours`, `menu_items`, `service_packages`, `insurance_offerings`, `books_details`, `property_details`, `vehicle_information`, `product_details`, `delivery_partner_name`, `delivery_partner_phone`, `delivery_partner_ssn`, `insurance_license_number`, `license_expiry_date`, `bar_association_number`, `years_of_experience`, `specialization`, `pricing_model`, `price`, `service_description`, `cuisine_type`, `service_name`, `service_category`, `insurance_offering_name`, `insurance_type`, `coverage_options`, `rate_basic`, `property_title`, `property_type`, `property_features`, `property_listing_type`, `property_price`, `property_address`, `property_city`, `property_zipcode`, `property_size`, `bedrooms`, `other_features`, `number_of_vehicles`, `vehicle_name`, `vehicle_photos`, `vehicle_make`, `vehicle_model`, `vehicle_year`, `vehicle_mileage`, `vehicle_license_number`, `vehicle_registration_date`, `rate_start_time`, `rate_amount`, `rate_type`, `book_title`, `book_author`, `book_price`, `book_genre`, `book_format`, `what_you_sell`, `product_price`, `product_quantity`, `is_approved`, `rejection_reason`, `approved_at`, `created_at`, `updated_at`, `license_number`, `text_identification_file_id`, `proof_of_business_registration_file_id`, `food_safety_certifications_file_id`, `government_issued_id_file_id`, `business_registration_certificate_file_id`, `professional_license_file_id`, `legal_certifications_file_id`, `vehicle_registration_document_file_id`, `vehicle_insurance_document_file_id`, `book_cover_file_id`, `book_file_id`, `product_photo_file_id`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-09-06 11:36:52', '2025-09-06 11:36:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-09-06 13:17:37', '2025-09-06 13:17:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 1, '{\"monday\": {\"end\": \"21:00\", \"start\": \"09:00\"}}', '[{\"price\": 9.99, \"quantity\": 100, \"dish_name\": \"Burger\", \"cuisine_type\": \"American\"}]', NULL, NULL, NULL, NULL, NULL, NULL, 'Speedy Delivery', '+15550987654', '123-45-6789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-09-06 13:18:28', '2025-09-06 13:18:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 1, '\"{\\\"monday\\\":{\\\"start\\\":\\\"09:00\\\",\\\"end\\\":\\\"21:00\\\"}}\"', '\"[{\\\"dish_name\\\":\\\"Burger\\\",\\\"cuisine_type\\\":\\\"American\\\",\\\"price\\\":9.99,\\\"quantity\\\":100}]\"', NULL, NULL, NULL, NULL, NULL, NULL, 'Speedy Delivery', '+15550987654', '123-45-6789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-09-06 17:50:05', '2025-09-06 17:50:05', '123321123ABC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 1, '\"{\\\"monday\\\":{\\\"start\\\":\\\"09:00\\\",\\\"end\\\":\\\"21:00\\\"}}\"', '\"[{\\\"dish_name\\\":\\\"Burger\\\",\\\"cuisine_type\\\":\\\"American\\\",\\\"price\\\":9.99,\\\"quantity\\\":100}]\"', NULL, NULL, NULL, NULL, NULL, NULL, 'Speedy Delivery', '+15550987654', '123-45-6789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-09-06 17:54:16', '2025-09-06 17:54:16', '1231231', NULL, NULL, 1, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `business_name`, `business_email`, `business_phone`, `business_address`, `country`, `state`, `city`, `zip_code`, `otp`, `otp_expires_at`, `is_verified`, `is_active`, `profile_image`) VALUES
(1, 'Test Seller', 'test@example.com', NULL, '$2y$12$bIrPIduCcVDLd0ljxksX8u1siR.8oIbvj1kKxe7c4d9LqLHKZxYp.', NULL, '2025-09-06 11:36:52', '2025-09-06 13:04:16', NULL, 'Test Restaurant', 'business@test.com', '1234567890', '123 Test St', 'USA', 'CA', 'Los Angeles', '90210', NULL, NULL, 0, 1, NULL),
(2, 'John Seller', 'john.seller@example.com', NULL, '$2y$12$7O.OK3yQMyfJwXdnqn4HsebPh7B7mY2TcK9bsmhHUxwYQy/H9A3Cu', NULL, '2025-09-06 13:17:37', '2025-09-06 13:17:37', '+15551234567', 'Johns Goods', 'business@example.com', '+15557654321', '123 Market St', 'USA', 'CA', 'San Francisco', '94105', NULL, NULL, 0, 1, NULL),
(3, 'Joe\'s Diner', 'restaurant@example.com', NULL, '$2y$12$FXLrOWqfRzaljefBIxM5OugvqG.xrYXbgtjVcwb23wHppEQS385EO', NULL, '2025-09-06 13:18:28', '2025-09-06 13:18:28', '+15550123456', 'Joe\'s Diner', 'contact@joesdiner.com', '+15550123456', '10 Food St', 'USA', 'TX', 'Austin', '73301', NULL, NULL, 0, 1, NULL),
(4, 'Joe\'s Diner', 'restaurant2@example.com', NULL, '$2y$12$8IVaV7bXCZUbnl4g5TUEhOPlGH1jFFITp98gfNEeAyyWNeZt/4KpC', NULL, '2025-09-06 17:50:05', '2025-09-06 17:50:05', '+15550123456', 'Joe\'s Diner', 'contact@joesdiner.com', '+15550123456', '10 Food St', 'USA', 'TX', 'Austin', '73301', NULL, NULL, 0, 1, NULL),
(5, 'Joe\'s Diner', 'restauran3t@example.com', NULL, '$2y$12$4jG88UWRlhxWmM1OE5F24eUXBZgfRq2XIVk20YYi1UmINbPWj0Jbu', NULL, '2025-09-06 17:54:16', '2025-09-06 17:54:16', '+15550123456', 'Joe\'s Diner', 'contact@joesdiner.com', '+15550123456', '10 Food St', 'USA', 'TX', 'Austin', '73301', NULL, NULL, 0, 1, NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;