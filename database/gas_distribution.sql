-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2025 at 09:17 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gas_distribution`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('dealer','commercial','individual') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `credit_limit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_2_8kg` decimal(10,2) DEFAULT NULL,
  `price_5kg` decimal(10,2) DEFAULT NULL,
  `price_12_5kg` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `type`, `contact`, `address`, `credit_limit`, `balance`, `price_2_8kg`, `price_5kg`, `price_12_5kg`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ABC Restaurant', 'commercial', '0771234567', 'Galle Road, Colombo 03', 50000.00, 0.00, 1000.00, 1400.00, 2800.00, '2025-12-10 12:45:29', '2025-12-11 10:32:23', '2025-12-11 10:32:23'),
(2, 'XYZ Hotel', 'commercial', '0771234568', 'Marine Drive, Colombo 04', 100000.00, 0.00, 1000.00, 1400.00, 2800.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(3, 'Gas Dealer - Moratuwa', 'dealer', '0771234569', 'Moratuwa, Sri Lanka', 200000.00, 0.00, 950.00, 1350.00, 2700.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(4, 'John Silva', 'individual', '0771234570', 'Nugegoda, Sri Lanka', 5000.00, 0.00, 1100.00, 1500.00, 3000.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(5, 'Mary Fernando', 'individual', '0771234571', 'Dehiwala, Sri Lanka', 5000.00, 0.00, 1100.00, 1500.00, 3000.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(6, 'samantha', 'individual', '0701234903', 'Matale', 0.00, 0.00, NULL, NULL, NULL, '2025-12-11 10:35:44', '2025-12-12 00:35:14', '2025-12-12 00:35:14'),
(7, 'pawan', 'individual', '0712354686', 'Matale', 3500.00, 0.00, NULL, NULL, NULL, '2025-12-11 10:37:28', '2025-12-12 03:05:34', '2025-12-12 03:05:34'),
(8, 'sharafniyas', 'individual', '0742210065', 'matale', 100000.00, 0.00, 1000.00, 1500.00, 2000.00, '2025-12-11 22:44:09', '2025-12-11 22:44:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_routes`
--

DROP TABLE IF EXISTS `delivery_routes`;
CREATE TABLE IF NOT EXISTS `delivery_routes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `route_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_date` date NOT NULL,
  `planned_start_time` time DEFAULT NULL,
  `actual_start_time` time DEFAULT NULL,
  `planned_end_time` time DEFAULT NULL,
  `actual_end_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_routes`
--

INSERT INTO `delivery_routes` (`id`, `route_name`, `driver_name`, `assistant_name`, `route_date`, `planned_start_time`, `actual_start_time`, `planned_end_time`, `actual_end_time`, `created_at`, `updated_at`) VALUES
(1, 'Colombo Route 1', 'Kamal Perera', 'Nimal Silva', '2025-12-10', '08:00:00', NULL, '17:00:00', NULL, '2025-12-10 12:45:29', '2025-12-10 12:45:29'),
(2, 'Dehiwala Route', 'Sunil Fernando', 'Hashan silva', '2025-12-10', '09:00:00', NULL, '18:00:00', NULL, '2025-12-10 12:45:29', '2025-12-10 13:17:00'),
(3, 'Moratuwa Route', 'Ravi Jayasinghe', 'Chaminda Dias', '2025-12-11', '08:30:00', NULL, '17:30:00', NULL, '2025-12-10 12:45:29', '2025-12-10 12:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grns`
--

DROP TABLE IF EXISTS `grns`;
CREATE TABLE IF NOT EXISTS `grns` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `grn_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_date` date NOT NULL,
  `status` enum('pending','approved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grns_grn_number_unique` (`grn_number`),
  KEY `grns_purchase_order_id_foreign` (`purchase_order_id`),
  KEY `grns_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grns`
--

INSERT INTO `grns` (`id`, `purchase_order_id`, `supplier_id`, `grn_number`, `received_date`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'GRN-20251211-0001', '2025-12-11', 'approved', NULL, '2025-12-11 10:31:38', '2025-12-11 22:49:29'),
(2, 2, 2, 'GRN-20251211-0002', '2025-12-11', 'approved', NULL, '2025-12-11 11:23:17', '2025-12-11 22:48:45'),
(3, 2, 2, 'GRN-20251211-0003', '2025-12-11', 'approved', 'All items received in good condition', '2025-12-11 11:35:45', '2025-12-11 22:39:02'),
(4, 2, 2, 'GRN-20251212-0004', '2025-12-12', 'approved', 'All items received in good condition', '2025-12-11 22:01:25', '2025-12-11 22:14:23'),
(5, 2, 2, 'GRN-20251212-0005', '2025-12-12', 'approved', 'All items received in good condition', '2025-12-11 22:13:09', '2025-12-11 22:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `grn_items`
--

DROP TABLE IF EXISTS `grn_items`;
CREATE TABLE IF NOT EXISTS `grn_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `grn_id` bigint UNSIGNED NOT NULL,
  `gas_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered_qty` int NOT NULL,
  `received_qty` int NOT NULL,
  `short_supply` int NOT NULL DEFAULT '0',
  `damaged` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grn_items_grn_id_foreign` (`grn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grn_items`
--

INSERT INTO `grn_items` (`id`, `grn_id`, `gas_type`, `ordered_qty`, `received_qty`, `short_supply`, `damaged`, `created_at`, `updated_at`) VALUES
(1, 5, '2.8kg', 10, 10, 0, 1, '2025-12-11 22:13:09', '2025-12-11 22:13:09'),
(2, 5, '12.5kg', 10, 10, 0, 0, '2025-12-11 22:13:09', '2025-12-11 22:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_10_072639_create_suppliers_table', 1),
(5, '2025_12_10_072656_create_purchase_orders_table', 1),
(6, '2025_12_10_072703_create_purchase_order_items_table', 1),
(7, '2025_12_10_072711_create_grns_table', 1),
(8, '2025_12_10_072724_create_grn_items_table', 1),
(9, '2025_12_10_072733_create_supplier_payments_table', 1),
(10, '2025_12_10_072741_create_customers_table', 1),
(11, '2025_12_10_072748_create_orders_table', 1),
(12, '2025_12_10_072755_create_order_items_table', 1),
(13, '2025_12_10_072802_create_delivery_routes_table', 1),
(14, '2025_12_10_072808_create_stock_table', 1),
(15, '2025_12_11_134351_add_soft_deletes_to_suppliers_and_customers', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `delivery_route_id` bigint UNSIGNED DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','loaded','delivered','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_urgent` tinyint(1) NOT NULL DEFAULT '0',
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_delivery_route_id_foreign` (`delivery_route_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `delivery_route_id`, `order_number`, `total_amount`, `status`, `is_urgent`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 3, 3, 'ORD-20251210-0001', 135000.00, 'completed', 1, '2025-12-10', '2025-12-10 13:17:55', '2025-12-11 10:33:43'),
(2, 6, 1, 'ORD-20251211-0002', 0.00, 'loaded', 0, '2025-12-11', '2025-12-11 10:36:19', '2025-12-11 22:49:05'),
(3, 7, 1, 'ORD-20251211-0003', 0.00, 'delivered', 0, '2025-12-11', '2025-12-11 10:37:49', '2025-12-12 02:04:44'),
(4, 8, 1, 'ORD-20251212-0004', 10000.00, 'completed', 1, '2025-12-12', '2025-12-11 22:44:58', '2025-12-11 22:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `gas_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `gas_type`, `quantity`, `price`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, '12.5kg', 50, 2700.00, 135000.00, '2025-12-10 13:17:55', '2025-12-10 13:17:55'),
(2, 2, '12.5kg', 2, 0.00, 0.00, '2025-12-11 10:36:19', '2025-12-11 10:36:19'),
(3, 3, '2.8kg', 1, 0.00, 0.00, '2025-12-11 10:37:49', '2025-12-11 10:37:49'),
(4, 4, '2.8kg', 10, 1000.00, 10000.00, '2025-12-11 22:44:58', '2025-12-11 22:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `po_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','approved','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  KEY `purchase_orders_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `po_number`, `total_amount`, `status`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'PO-20251210-0001', 2500.00, 'completed', '2025-12-10', '2025-12-10 13:06:39', '2025-12-11 22:49:29'),
(2, 2, 'PO-20251211-0002', 34100.00, 'completed', '2025-12-11', '2025-12-11 11:07:59', '2025-12-11 22:39:02');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
CREATE TABLE IF NOT EXISTS `purchase_order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint UNSIGNED NOT NULL,
  `gas_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `gas_type`, `quantity`, `rate`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, '12.5kg', 1, 2500.00, 2500.00, '2025-12-10 13:06:39', '2025-12-10 13:06:39'),
(2, 2, '2.8kg', 10, 860.00, 8600.00, '2025-12-11 11:07:59', '2025-12-11 11:07:59'),
(3, 2, '12.5kg', 10, 2550.00, 25500.00, '2025-12-11 11:07:59', '2025-12-11 11:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `gas_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_gas_type_unique` (`gas_type`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `gas_type`, `quantity`, `created_at`, `updated_at`) VALUES
(1, '2.8kg', 100, '2025-12-10 12:45:29', '2025-12-10 12:45:29'),
(2, '5kg', 150, '2025-12-10 12:45:29', '2025-12-10 12:45:29'),
(3, '12.5kg', 200, '2025-12-10 12:45:29', '2025-12-10 12:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `rate_2_8kg` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate_5kg` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rate_12_5kg` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact`, `address`, `rate_2_8kg`, `rate_5kg`, `rate_12_5kg`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Laugfs Gas', '0112345678', 'Colombo 03, Sri Lanka', 850.00, 1200.00, 2500.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(2, 'Litro Gas', '0112345679', 'Colombo 05, Sri Lanka', 860.00, 1220.00, 2550.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(3, 'Shell Gas', '0112345680', 'Colombo 07, Sri Lanka', 870.00, 1250.00, 2600.00, '2025-12-10 12:45:29', '2025-12-10 12:45:29', NULL),
(4, 'ECO Gas', '0660000001', 'Colombo', 3000.00, 5500.00, 6600.00, '2025-12-11 10:29:57', '2025-12-11 10:30:01', '2025-12-11 10:30:01'),
(5, 'Saman', '0712354686', 'Matale', 1000.00, 2500.00, 3500.00, '2025-12-12 02:04:03', '2025-12-12 02:04:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

DROP TABLE IF EXISTS `supplier_payments`;
CREATE TABLE IF NOT EXISTS `supplier_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `purchase_order_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_mode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cheque',
  `cheque_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_payments_supplier_id_foreign` (`supplier_id`),
  KEY `supplier_payments_purchase_order_id_foreign` (`purchase_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_payments`
--

INSERT INTO `supplier_payments` (`id`, `supplier_id`, `purchase_order_id`, `amount`, `payment_mode`, `cheque_number`, `payment_date`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2500.00, 'cheque', NULL, '2025-12-10', NULL, '2025-12-10 13:08:37', '2025-12-10 13:08:37'),
(2, 2, 2, 24100.00, 'cheque', 'CHQ-12345', '2025-12-12', NULL, '2025-12-11 22:42:43', '2025-12-11 22:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@gas.com', NULL, '$2y$12$jbPmEz5HSQ8i89ki/fD2XOgIqhVGQ3E4Q8hDUhcoiNfnRFkLyPqx2', NULL, '2025-12-10 12:45:29', '2025-12-10 12:45:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
