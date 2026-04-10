-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 12:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `medicine_id`, `quantity`, `created_at`, `updated_at`) VALUES
(41, 5, 38, 1, '2025-12-20 12:11:39', '2025-12-20 12:11:39'),
(66, 19, 37, 1, '2026-02-12 05:39:40', '2026-02-12 05:42:38'),
(67, 19, 35, 1, '2026-02-12 05:42:28', '2026-02-12 05:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Pain Relief', 'pain-relief', NULL, '2026-01-11 09:11:12', '2026-01-11 09:11:12'),
(2, 'Antibiotics', 'antibiotics', NULL, '2026-01-11 09:11:12', '2026-01-11 09:11:12'),
(3, 'Vitamins', 'vitamins', NULL, '2026-01-11 09:11:12', '2026-01-11 09:11:12'),
(4, 'First Aid', 'first-aid', NULL, '2026-01-11 09:11:12', '2026-01-11 09:11:12'),
(5, 'Personal Care', 'personal-care', NULL, '2026-01-11 09:11:12', '2026-01-11 09:11:12');

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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `prescription_required` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `description`, `price`, `image`, `stock`, `category`, `prescription_required`, `created_at`, `updated_at`, `category_id`) VALUES
(3, 'Antacid Tablets', 'For relief from acidity and indigestion.', 45.00, 'medicine_images/V2bC9h1D5BJtB94WcGFrW3jmnRGvoojDZwhXNsG0.png', 75, 'Stomach', 0, '2025-10-31 15:15:25', '2025-11-07 13:44:40', NULL),
(5, 'Paracetamol 500mg', 'For relief from fever and mild pain.', 20.50, 'medicine_images/e8m397ZGWTTTKbX1g0tOfG6XtxJxwd3DsPpg2HuG.png', 84, 'Pain Relief', 0, '2025-10-31 22:33:44', '2026-01-26 05:01:53', NULL),
(7, 'Antacid Tablets', 'For relief from acidity and indigestion.', 45.00, 'medicine_images/2NR6I3t77V7dd3xP5jzJc4tVreWu6drSR7BaNoAt.png', 70, 'Stomach', 0, '2025-10-31 22:33:44', '2026-01-11 10:07:01', 5),
(8, 'Amoxicillin 250mg', 'Antibiotic for bacterial infections. Requires prescription.', 120.00, 'medicine_images/aaJAdTizYZJgLA311bXGY3c4OxzL2P29smRNXTDd.png', 30, 'Antibiotic', 1, '2025-10-31 22:33:44', '2025-11-07 13:44:20', NULL),
(9, 'Combiflam Plus Headache Relief Tablet - Strip Of 10 Tablets', 'Combiflam Plus Tablets are a part of a group of medicines known as analgesics. Each tablet contains paracetamol and caffeine. These tablets are generally prescribed to deal with mild or moderate headaches, toothaches, pain due to periods and migraines. Combiflam tablets also help with osteoarthritis and musculoskeletal pains. Paracetamol and caffeine work hand in hand to stop the pain. While paracetamol stops the release of enzymes that cause pain in the body, caffeine helps increase its efficacy. Paracetamol also helps reduce body temperature and brings down fever. Combiflam for headache is an over-the-counter medicine, but it is safe to consult your physician before use.\r\n\r\nBenefits\r\nIt is an over the counter medicine for mild to moderate pain in the body.\r\nIs ideal for headaches, migraine, toothaches and pain due to periods.\r\nThe tablets also reduce osteoarthritis and musculoskeletal pains.\r\nIngredients\r\nParacetamol (650mg)\r\nCaffeine (50mg)\r\nUses\r\nThe tablets help with mild and moderate headaches, migraine, toothaches and period cramps and pain.\r\nAlso, help with osteoarthritis and musculoskeletal pain.\r\nHow to Use\r\nTake one tablet and swallow it with the help of water.\r\nTake the tablet either before or after a meal.\r\nPreferably take the tablet post a meal to prevent gastric issues.\r\nAvoid chewing the tablet if you can\'t swallow it whole. Break the tablet into 2  pieces and swallow both separately with water.\r\nMake sure to take each dose at a fixed time evenly spaced apart for best results.\r\nSafety Information\r\nStore it in a cool and dry place, away from sunlight. The temperature should not exceed 30° celsius.\r\nKeep it away from children’s reach.\r\nCheck the expiry date before use.\r\nPregnant and lactating mothers should check with their doctor before taking these tablets.\r\nIndividuals who are taking other medication should consult their doctor before taking these tablets.\r\nPatients with liver or kidney disease should consult their doctor before taking these tablets.\r\nDo not take the tablet with alcohol as it can lead to abdominal pain and nausea.\r\nIn case of an allergic reaction to the medicine such as the appearance of skin rash, wheezing, problems with breathing, etc., get in touch with your doctor immediately.\r\nFAQ\r\nQ1. Can you take the Combiflam tablet for headaches daily?\r\n\r\nAns: Do not make it a habit to take the tablet daily for headache. You can take the tablet 2-3 days a week. Excessive use can result in rebound headaches.\r\n\r\nQ2. What dose of Combiflam Plus should I take for a headache?\r\n\r\nAns: The dosage depends on several factors like severity of pain, existing health issues, etc. Check with your doctor for the right dose before taking these tablets.\r\n\r\nQ3.  What to do in case of an overdose of Combiflam Plus?\r\n\r\nAns: In case you experience signs of liver damage, which can occur because of an overdose such as vomiting, nausea, reach, etc., immediately consult your doctor.', 25.70, 'medicine_images/ycAxL8K5hXWTzT5wi71pzAhsMJ4oCZQKtZZKXmnh.png', 50, 'Headache Relief', 1, '2025-11-01 06:15:56', '2025-11-07 13:42:20', NULL),
(10, 'Crocin Advance', 'Pain and fever reliever', 30.00, 'medicine_images/VWQbXJtPZhHSsBVyiXipA9jO6pnEsrvACOjVyYxk.png', 80, 'Fever / Pain Relief', 0, '2025-11-07 09:53:29', '2025-11-07 13:41:37', NULL),
(11, 'Dolo 650', 'Effective for high fever and body pain', 35.00, 'medicine_images/ifwrcTgkyOyiVmgaUZaIvTXhpKWp8xzUybHEVNZf.png', 60, 'Fever / Pain Relief', 1, '2025-11-07 11:03:20', '2025-11-07 13:40:40', NULL),
(12, 'Calpol 650', 'Reduces fever and headaches', 32.00, 'medicine_images/tEPbbZkejMTC8lgrUDA9eJC2f2gAGz20QTLTrPtl.png', 89, 'Fever / Pain Relief', 0, '2025-11-07 11:04:44', '2025-11-07 13:40:24', NULL),
(13, 'Ibuprofen 400mg', 'Relieves pain, fever, and inflammation', 45.00, 'medicine_images/rUhHAuasMLcWzSPLn5n77r2ssITJAXlYmaSosHlr.png', 70, 'Pain Relief / Anti-inflammatory', 1, '2025-11-07 11:05:56', '2025-11-07 13:40:04', NULL),
(14, 'Combiflam', 'Combination of paracetamol and ibuprofen', 40.00, 'medicine_images/iXjq4rug36TQONonUho9b8499qfPqFnwL5eVCGjN.png', 100, 'Pain Relief / Fever', 0, '2025-11-07 12:22:38', '2025-11-07 13:39:47', NULL),
(15, 'Sinarest', 'Used for cold, cough, and nasal congestion', 50.00, 'medicine_images/YuXT5MBla6i7fq1hujSz7qx3jOFVAF4VvwqPnTXR.png', 70, 'Cold & Cough', 1, '2025-11-07 12:23:49', '2025-11-07 13:39:26', NULL),
(16, 'Cetrizine', 'Allergy relief and sneezing due to cold', 25.00, 'medicine_images/aUvz5mDhuKbWN1XJwFMk1IE3y1tkLlU58QuYLMUE.png', 58, 'Anti-Allergic', 0, '2025-11-07 12:24:44', '2025-11-07 13:39:10', NULL),
(17, 'Benadryl', 'Cough syrup for dry and allergic cough', 90.00, 'medicine_images/loO9L84qYqRdxA9Lds4atxDygWa9hgO5N2032w1t.png', 110, 'Cold & Cough', 1, '2025-11-07 12:25:49', '2025-11-07 13:38:53', NULL),
(18, 'Ascoril LS', 'Syrup for productive (wet) cough', 110.00, 'medicine_images/59qX6wulDRL0fUM4OqXNO05Dgs50P84YMq8CmPvJ.png', 39, 'Cold & Cough', 0, '2025-11-07 12:26:41', '2025-11-13 07:53:04', NULL),
(19, 'Vicks Action 500', 'Tablet for cold, cough, and fever', 35.00, 'medicine_images/nP1rrbMzh7IZ24av2E2wsotwozOLgo2bFYhVwcQY.png', 90, 'Cold & Fever', 0, '2025-11-07 12:27:39', '2025-11-07 13:20:12', NULL),
(20, 'Pan D', 'Treats acidity and bloating', 90.00, 'medicine_images/ULBIWHGpzFa7Jnow0rhjiFRnJUZ9J3yHLqUeWvLq.png', 48, 'Stomach / Antacid', 1, '2025-11-07 12:29:05', '2025-11-07 13:19:49', NULL),
(21, 'Digene', 'For acidity and gas relief', 25.00, 'medicine_images/cZFEhK74nFGugyvVydcunCavPGtENKyKr1QK1zm3.png', 26, 'Stomach', 0, '2025-11-07 12:29:52', '2025-12-01 06:42:23', NULL),
(22, 'Eno Lemon', 'Instant relief from acidity', 15.00, 'medicine_images/dz6KRtFWdZRbWdYI3xZmJt6P2nyM6Jl1nPz9I2VK.png', 96, 'Stomach', 0, '2025-11-07 12:30:38', '2025-11-07 13:19:03', NULL),
(23, 'Omez 20', 'Treats acid reflux and ulcers', 60.00, 'medicine_images/wlSHXkAIrMUZnsxAXuPS2D3aZWdfPogOR5RTxbJn.png', 45, 'Stomach', 1, '2025-11-07 12:31:28', '2025-11-07 13:18:37', NULL),
(24, 'Rantac 150', 'Reduces stomach acid', 45.00, 'medicine_images/elwlMmc7rowyIpSDUBPeIQrsyjgPbMGsqjUWGuUW.png', 60, 'Stomach', 1, '2025-11-07 12:32:21', '2025-11-07 13:18:19', NULL),
(25, 'Cyclopam', 'Relieves stomach cramps and pain', 55.00, 'medicine_images/uYrY8jD8x0EYKwtjb8Og2Hf6DUbrlWtKYIw6LAKN.png', 89, 'Stomach / Pain Relief', 0, '2025-11-07 12:35:04', '2025-11-07 13:17:43', NULL),
(26, 'Buscopan', 'Treats abdominal and menstrual cramps', 60.00, 'medicine_images/tSFkKLqoCFD2L4ITDAcwylZguensOqppQteYBVpM.png', 78, 'Stomach', 0, '2025-11-07 12:36:30', '2025-11-07 13:17:21', NULL),
(27, 'Metrogyl 400', 'Antibiotic for stomach infections', 65.00, 'medicine_images/acyw2oXLmLpT6wp3U13Uf74pljRrvRWPiTgPKhep.png', 296, 'Antibiotic', 0, '2025-11-07 12:37:46', '2026-01-02 09:43:23', NULL),
(28, 'Norflox TZ', 'Used for diarrhea and stomach infection', 75.00, 'medicine_images/OkgJbjCOkdW8r8Scl2kxNNDj6mdkqW46j7eLdJNL.png', 40, 'Antibiotic / Stomach', 0, '2025-11-07 12:38:42', '2025-11-07 13:23:23', NULL),
(29, 'Augmentin 625', 'Broad-spectrum antibiotic', 150.00, 'medicine_images/jiu7wEOJ8o0cyfzzFpJDWNsK74nBT7X0vOBVlcvB.png', 27, 'Broad-spectrum antibiotic', 1, '2025-11-07 12:39:53', '2026-01-11 10:04:59', 2),
(30, 'Azithral 500', 'Antibiotic for bacterial infections', 120.00, 'medicine_images/9bJO1bokJZi7FDm7oXD6SIretx4z6rNl02Majf8n.png', 50, 'Antibiotic', 0, '2025-11-07 12:41:05', '2025-11-07 13:05:40', NULL),
(31, 'Amoxycillin 500', 'Common antibiotic for infections', 80.00, 'medicine_images/4baqfzPzjnu1QjfhIEogxvZkuzHCG580EwMogyqn.png', 59, 'Antibiotic', 0, '2025-11-07 12:42:03', '2026-01-11 11:31:06', NULL),
(32, 'Allegra 120mg', 'For allergy, sneezing, and itching', 130.00, 'medicine_images/33XnRXR8lisXuGhoELNUFZzD4HRe3v2312EwHwJZ.png', 42, 'Anti-Allergic', 0, '2025-11-07 12:43:06', '2026-01-11 12:21:02', NULL),
(33, 'Saridon', 'Headache and mild pain relief', 30.00, 'medicine_images/bTUa4nxTX6qrJACKMc7bw9Jylctl1JuFHb17QgYb.png', 70, 'Pain Relief / Headache', 1, '2025-11-07 12:44:10', '2025-11-07 13:04:37', NULL),
(34, 'Disprin', 'Fast-acting pain reliever for headaches', 25.00, 'medicine_images/GxIqsDQYnMPMtCzhQCEMHohvEakfhoBsuUKbATDH.png', 86, 'Pain Relief', 1, '2025-11-07 12:44:52', '2025-12-26 10:18:02', NULL),
(35, 'Moov Spray', 'Moov Spray', 95.00, 'medicine_images/UquCYdrzwVWlnoqjiUoFFhMsAWUdC5RQSGZGZs66.png', 56, 'Pain Relief', 0, '2025-11-07 12:45:39', '2025-12-01 06:43:22', NULL),
(36, 'Volini Gel', 'Relieves back, neck, and muscle pain', 120.00, 'medicine_images/PI4mnx7VqdRuWpSjTn86ejI1AnmEgZc1ZOuvbflJ.png', 24, 'Pain Relief', 0, '2025-11-07 12:46:35', '2026-01-02 09:41:34', NULL),
(37, 'Flexura D', 'Muscle relaxant and pain relief', 180.00, 'medicine_images/1nMeCiiQhgAuQtqVTfNuCcQSmmXHh3FnBXXDbQvv.jpg', 58, 'Pain Relief / Muscle Relaxant', 0, '2025-11-07 12:47:29', '2026-02-04 23:16:41', NULL),
(38, 'Meftal Spas', 'Painkiller for menstrual and abdominal pain', 70.00, 'medicine_images/gJzmplt64EI2M2PAw4w4QHm7p0EVRQc5bVfNxAhb.jpg', 54, 'Pain Relief / Stomach', 0, '2025-11-07 12:48:23', '2026-01-11 09:56:08', 2);

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_31_201903_add_role_to_users_table', 2),
(5, '2025_10_31_202255_create_medicines_table', 2),
(6, '2025_10_31_202528_create_carts_table', 2),
(7, '2025_10_31_202808_create_orders_table', 2),
(8, '2025_10_31_203003_create_order_items_table', 2),
(9, '2025_10_31_203133_create_symptom_sessions_table', 2),
(10, '2025_10_31_203236_create_prescriptions_table', 2),
(11, '2025_11_01_202448_add_payment_method_to_orders_table', 3),
(12, '2025_11_13_125554_add_payment_details_to_orders_table', 4),
(13, '2025_12_20_183212_add_google_id_to_users_table', 5),
(14, '2025_12_30_174024_add_details_to_users_table', 6),
(15, '2025_12_30_180714_update_users_table_for_otp_and_address', 7),
(16, '2025_12_30_181012_add_delivery_details_to_orders_table', 8),
(17, '2025_12_30_213803_add_detailed_address_to_users_and_orders', 9),
(18, '2026_01_11_141529_create_categories_table', 10),
(19, '2026_01_11_141725_add_category_id_to_medicines', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `delivery_address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `alternate_phone` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'card',
  `payment_id` varchar(255) DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `delivery_address`, `city`, `state`, `country`, `pincode`, `landmark`, `alternate_phone`, `payment_method`, `payment_id`, `razorpay_order_id`, `created_at`, `updated_at`) VALUES
(10, 1, 46.20, 'pending_approval', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'card', NULL, NULL, '2025-11-01 06:21:46', '2025-11-01 07:38:02'),
(13, 1, 41.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'card', NULL, NULL, '2025-11-01 13:07:40', '2025-11-01 13:07:40'),
(24, 1, 45.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'card', NULL, NULL, '2025-11-07 09:13:06', '2025-11-07 09:13:06'),
(27, 1, 65.00, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cod', NULL, NULL, '2025-11-09 14:01:29', '2025-11-11 06:33:05'),
(28, 1, 20.50, 'shipped', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cod', NULL, NULL, '2025-11-12 09:00:45', '2025-11-12 11:16:51'),
(30, 1, 250.00, 'shipped', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cod', NULL, NULL, '2025-11-13 08:03:25', '2026-01-11 10:41:15'),
(31, 1, 65.00, 'processing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'card', 'pay_RfFCoLynJp0hKa', 'order_RfF9VmAaQEvadS', '2025-11-13 08:10:42', '2025-11-13 08:10:42'),
(32, 4, 20.50, 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'card', 'pay_RfFPDpgRVmVtwz', 'order_RfFOyOg6QdFmWc', '2025-11-13 08:22:35', '2025-11-13 08:24:50'),
(43, 1, 540.00, 'shipped', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', 'Near satish petrolpump', '07050358946', 'card', 'pay_Ryy6PkwPkSHnWO', 'order_Ryy6GMXfmXSjGz', '2026-01-02 04:27:00', '2026-01-02 04:29:39'),
(44, 9, 500.50, 'cancelled', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', 'Near satish petrolpump', NULL, 'cod', NULL, NULL, '2026-01-02 09:41:34', '2026-01-02 11:34:56'),
(47, 1, 140.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', 'Near satish petrolpump', NULL, 'cod', NULL, NULL, '2026-01-03 14:13:18', '2026-01-03 14:13:18'),
(48, 1, 180.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'cod', NULL, NULL, '2026-01-11 11:14:38', '2026-01-11 11:14:38'),
(49, 1, 80.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'cod', NULL, NULL, '2026-01-11 11:31:06', '2026-01-11 11:31:06'),
(50, 1, 180.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'card', 'pay_S2e9tkkAGv2tTo', 'order_S2e9UXhYnhYRxJ', '2026-01-11 11:32:27', '2026-01-11 11:32:27'),
(51, 1, 130.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'cod', NULL, NULL, '2026-01-11 12:21:02', '2026-01-11 12:21:02'),
(52, 1, 180.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'card', 'pay_S8TUrDlhJsQQ2R', 'order_S8TUfwj1ytJBed', '2026-01-26 05:00:38', '2026-01-26 05:00:38'),
(53, 1, 20.50, 'shipped', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'cod', NULL, NULL, '2026-01-26 05:01:53', '2026-01-26 05:02:18'),
(54, 1, 180.00, 'processing', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'card', 'pay_SCKyhPdhhQW9ds', 'order_SCKyWPS47QGE1S', '2026-02-04 23:16:41', '2026-02-04 23:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `medicine_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 10, 5, 1, 20.50, '2025-11-01 06:21:46', '2025-11-01 06:21:46'),
(2, 10, 9, 1, 25.70, '2025-11-01 06:21:46', '2025-11-01 06:21:46'),
(7, 13, 5, 2, 20.50, '2025-11-01 13:07:40', '2025-11-01 13:07:40'),
(19, 24, 7, 1, 45.00, '2025-11-07 09:13:06', '2025-11-07 09:13:06'),
(22, 27, 27, 1, 65.00, '2025-11-09 14:01:29', '2025-11-09 14:01:29'),
(23, 28, 5, 1, 20.50, '2025-11-12 09:00:45', '2025-11-12 09:00:45'),
(25, 30, 32, 1, 130.00, '2025-11-13 08:03:25', '2025-11-13 08:03:25'),
(26, 30, 36, 1, 120.00, '2025-11-13 08:03:25', '2025-11-13 08:03:25'),
(27, 31, 27, 1, 65.00, '2025-11-13 08:10:42', '2025-11-13 08:10:42'),
(28, 32, 5, 1, 20.50, '2025-11-13 08:22:35', '2025-11-13 08:22:35'),
(41, 43, 37, 3, 180.00, '2026-01-02 04:27:00', '2026-01-02 04:27:00'),
(42, 44, 37, 2, 180.00, '2026-01-02 09:41:34', '2026-01-02 09:41:34'),
(43, 44, 36, 1, 120.00, '2026-01-02 09:41:34', '2026-01-02 09:41:34'),
(44, 44, 5, 1, 20.50, '2026-01-02 09:41:34', '2026-01-02 09:41:34'),
(47, 47, 38, 2, 70.00, '2026-01-03 14:13:18', '2026-01-03 14:13:18'),
(48, 48, 37, 1, 180.00, '2026-01-11 11:14:38', '2026-01-11 11:14:38'),
(49, 49, 31, 1, 80.00, '2026-01-11 11:31:06', '2026-01-11 11:31:06'),
(50, 50, 37, 1, 180.00, '2026-01-11 11:32:27', '2026-01-11 11:32:27'),
(51, 51, 32, 1, 130.00, '2026-01-11 12:21:02', '2026-01-11 12:21:02'),
(52, 52, 37, 1, 180.00, '2026-01-26 05:00:38', '2026-01-26 05:00:38'),
(53, 53, 5, 1, 20.50, '2026-01-26 05:01:53', '2026-01-26 05:01:53'),
(54, 54, 37, 1, 180.00, '2026-02-04 23:16:41', '2026-02-04 23:16:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('example@gmail.com', '$2y$12$BxcHbtl1OklNBSnCYizEVeFICYO.HNiUCpZAW4In3R.YIn0mahOwe', '2025-11-01 03:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('rqdf8ihZMPP8EvoruCyLOJnrUX0WLypLXBFGS5ht', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV1RLbUZVS0RVS3dlNHZJR1pnejk1ZEJjelFaU2xoUzQzNnJGTWV4diI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1762116096);

-- --------------------------------------------------------

--
-- Table structure for table `symptom_sessions`
--

CREATE TABLE `symptom_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `symptoms_input` text NOT NULL,
  `ai_response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `symptom_sessions`
--

INSERT INTO `symptom_sessions` (`id`, `user_id`, `symptoms_input`, `ai_response`, `created_at`, `updated_at`) VALUES
(89, 1, 'i am feeling tired', '{\"analysis\":\"Feeling tired is a very general symptom and can be caused by many factors, such as lack of sleep, stress, or other underlying conditions. Our available OTC stock does not include specific remedies for general tiredness.\",\"severity\":\"mild\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 09:05:47', '2025-11-12 09:05:47'),
(90, 1, 'can you suggest me any medicine for that?', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 09:06:48', '2025-11-12 09:06:48'),
(91, 1, 'fever', '{\"analysis\":\"You are experiencing a fever. This is a common symptom that can often be managed with over-the-counter medication.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for reducing fever and mild pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"This is a pain and fever reliever that can help bring down your temperature.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 09:07:05', '2025-11-12 09:07:05'),
(92, 1, 'my neck is eitching', '{\"analysis\":\"You are experiencing itching on your neck. This could be due to a mild allergic reaction or skin irritation.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Allegra 120mg\",\"reason\":\"This is an anti-allergic medication that can help relieve itching.\",\"type\":\"OTC\"},{\"medicine_name\":\"Cetrizine\",\"reason\":\"This is an anti-allergic medication effective for allergy relief, which includes itching.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 10:34:35', '2025-11-12 10:34:35'),
(93, 1, 'fever', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 12:29:01', '2025-11-12 12:29:01'),
(94, 1, 'fever', '{\"analysis\":\"You are experiencing a fever. This is a common symptom often associated with various mild illnesses.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for reducing fever and mild pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"This is a pain and fever reliever that can help bring down your temperature.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 12:29:21', '2025-11-12 12:29:21'),
(95, NULL, 'headache', '{\"analysis\":\"You are experiencing a headache. This is a common and usually mild symptom.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for relieving mild pain, including headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is known to reduce headaches and fever.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-12 12:44:37', '2025-11-12 12:44:37'),
(96, NULL, 'cough and cold', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 07:50:35', '2025-11-13 07:50:35'),
(97, NULL, 'cough and cold', '{\"analysis\":\"You are experiencing symptoms commonly associated with a cold, including a cough and general cold discomfort.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Ascoril LS\",\"reason\":\"This syrup is suitable for relieving productive (wet) cough.\",\"type\":\"OTC\"},{\"medicine_name\":\"Vicks Action 500\",\"reason\":\"This tablet can help alleviate general cold symptoms, including cough and fever.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 07:50:56', '2025-11-13 07:50:56'),
(98, 4, 'headache', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 08:18:49', '2025-11-13 08:18:49'),
(99, 4, 'headache', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 08:19:04', '2025-11-13 08:19:04'),
(100, 4, 'headache', '{\"analysis\":\"Gemini service unavailable. HTTP status: 503. The model is overloaded. Please try again later.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 08:19:17', '2025-11-13 08:19:17'),
(101, 4, 'headache', '{\"analysis\":\"The user is experiencing a headache.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"For relief from mild pain such as headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"Helps in reducing headaches and fever.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 08:20:45', '2025-11-13 08:20:45'),
(102, 4, 'fever', '{\"analysis\":\"You are experiencing a fever. This is a common symptom often associated with minor infections or colds.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for reducing fever and mild pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"This is a pain and fever reliever that can help bring down your temperature.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-13 08:23:26', '2025-11-13 08:23:26'),
(103, 1, 'pain in hand', '{\"analysis\":\"You are experiencing pain in your hand. This sounds like a localized musculoskeletal pain, which can often be managed with topical pain relief.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Moov Spray\",\"reason\":\"This spray is designed for localized pain relief and can be applied directly to the affected area of your hand.\",\"type\":\"OTC\"},{\"medicine_name\":\"Volini Gel\",\"reason\":\"This gel is effective for relieving muscle and joint pain, which could be contributing to your hand pain.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-11-14 07:27:05', '2025-11-14 07:27:05'),
(104, NULL, 'headache', '{\"analysis\":\"You are experiencing a headache, which is a common symptom often relieved by over-the-counter pain relievers.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This can help relieve mild pain, including headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is effective in reducing headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-01 06:37:22', '2025-12-01 06:37:22'),
(105, NULL, 'eye pain', '{\"analysis\":\"Eye pain can be caused by various factors, some of which may require medical attention. Since there are no specific over-the-counter medications in our stock for eye pain, and it\'s important to determine the underlying cause, it\'s best to consult a healthcare professional.\",\"severity\":\"moderate\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-01 06:38:15', '2025-12-01 06:38:15'),
(106, NULL, 'ear pain', '{\"analysis\":\"You are experiencing ear pain. Ear pain can have various causes, some of which may require medical attention.\",\"severity\":\"moderate\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-01 06:41:10', '2025-12-01 06:41:10'),
(107, NULL, 'gas', '{\"analysis\":\"You are experiencing gas, which is a common form of stomach discomfort.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Digene\",\"reason\":\"Digene is specifically formulated for acidity and gas relief.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-01 06:41:29', '2025-12-01 06:41:29'),
(108, NULL, 'fever', '{\"analysis\":\"You are experiencing a fever. This is a common symptom that can often be managed with over-the-counter medication.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"For relief from fever and mild pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"A pain and fever reliever.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 08:38:06', '2025-12-20 08:38:06'),
(109, NULL, 'cold', '{\"analysis\":\"You are experiencing symptoms consistent with a common cold.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Vicks Action 500\",\"reason\":\"This tablet is specifically formulated for relief from cold, cough, and fever symptoms.\",\"type\":\"OTC\"},{\"medicine_name\":\"Cetrizine\",\"reason\":\"This can help with allergy relief and sneezing often associated with a cold.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 08:38:26', '2025-12-20 08:38:26'),
(110, 5, 'im feel like sexual harasment', '{\"analysis\":\"Gemini service unavailable. HTTP status: 404. models\\/gemini-1.5-flash is not found for API version v1beta, or is not supported for generateContent. Call ListModels to see the list of available models and their supported methods.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:07:26', '2025-12-20 12:07:26'),
(111, 5, 'body pain', '{\"analysis\":\"Gemini service unavailable. HTTP status: 404. models\\/gemini-1.5-flash is not found for API version v1beta, or is not supported for generateContent. Call ListModels to see the list of available models and their supported methods.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:07:46', '2025-12-20 12:07:46'),
(112, NULL, 'body pain', '{\"analysis\":\"Gemini service unavailable. HTTP status: 404. models\\/gemini-1.5-flash is not found for API version v1beta, or is not supported for generateContent. Call ListModels to see the list of available models and their supported methods.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:08:58', '2025-12-20 12:08:58'),
(113, NULL, 'body pain', '{\"analysis\":\"You are experiencing general body pain.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"For relief from mild body pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Combiflam\",\"reason\":\"A combination of paracetamol and ibuprofen, effective for various types of pain including body pain.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:10:46', '2025-12-20 12:10:46'),
(114, 5, 'body pain', '{\"analysis\":\"You are experiencing general body pain. This is a common symptom that can often be managed with over-the-counter pain relievers.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"For relief from mild pain, including general body aches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"A pain and fever reliever that can help alleviate body pain.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:11:02', '2025-12-20 12:11:02'),
(115, 5, 'i m tired', '{\"analysis\":\"Tiredness is a very general symptom and can be caused by many factors such as lack of sleep, stress, or other underlying conditions. Our available OTC stock does not have specific medicines for general tiredness.\",\"severity\":\"mild\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:12:47', '2025-12-20 12:12:47'),
(116, 5, 'body pain', '{\"analysis\":\"You are experiencing general body pain.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Combiflam\",\"reason\":\"This medicine is effective for general pain relief, combining paracetamol and ibuprofen.\",\"type\":\"OTC\"},{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This is a common and effective medicine for relieving mild pain.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-20 12:13:19', '2025-12-20 12:13:19'),
(117, NULL, 'body pain and headache', '{\"analysis\":\"You are experiencing general body pain and a headache. These are common mild symptoms often associated with fatigue, stress, or the onset of a common cold.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This can help relieve mild body pain and headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Crocin Advance\",\"reason\":\"This is a pain and fever reliever that can effectively address headaches and general body aches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-21 12:52:30', '2025-12-21 12:52:30'),
(118, NULL, 'back pain', '{\"analysis\":\"You are experiencing back pain. This is a common symptom that can often be managed with over-the-counter pain relief.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Volini Gel\",\"reason\":\"This gel is specifically formulated to relieve back, neck, and muscle pain when applied topically.\",\"type\":\"OTC\"},{\"medicine_name\":\"Flexura D\",\"reason\":\"This medicine acts as a muscle relaxant and provides pain relief, which can be helpful for back pain.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2025-12-26 10:40:59', '2025-12-26 10:40:59'),
(119, NULL, 'tiredness', '{\"analysis\":\"Tiredness is a very general symptom that can be caused by many factors, including lack of sleep, stress, or underlying health conditions. Our available OTC stock does not have specific medications for general tiredness.\",\"severity\":\"mild\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-02 04:37:31', '2026-01-02 04:37:31'),
(120, NULL, 'headache', '{\"analysis\":\"You are experiencing a headache, which is a common and usually mild symptom.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is effective in reducing headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This is a general pain reliever suitable for mild pain like headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-02 04:38:04', '2026-01-02 04:38:04'),
(121, 9, 'fever', '{\"analysis\":\"Gemini service unavailable. HTTP status: 404. models\\/gemini-1.5-flash is not found for API version v1beta, or is not supported for generateContent. Call ListModels to see the list of available models and their supported methods.\",\"severity\":\"error\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-02 09:39:11', '2026-01-02 09:39:11'),
(122, 9, 'fever', '{\"analysis\":\"You are experiencing a fever. This is a common symptom that can often be managed with over-the-counter medication.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for reducing fever and mild pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is specifically formulated to reduce fever and headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-02 09:40:09', '2026-01-02 09:40:09'),
(123, 1, 'headache', '{\"analysis\":\"You are experiencing a headache, which is a common mild symptom.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for relief from mild pain, including headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is specifically formulated to reduce headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:02:36', '2026-01-11 10:02:36'),
(124, 1, 'I have a severe headache and fever.', '{\"analysis\":\"You are experiencing a severe headache and fever. These are common symptoms that can often be managed with over-the-counter pain and fever reducers.\",\"severity\":\"moderate\",\"recommendations\":[{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is effective in reducing fever and headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Combiflam\",\"reason\":\"This medicine is a combination of paracetamol and ibuprofen, which helps relieve both pain and fever.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:20:04', '2026-01-11 10:20:04'),
(125, 1, 'Where is my last order?', '{\"analysis\":\"The user\'s query is about order tracking, not symptoms or medical advice. As a MediAI Assistant, I am designed to analyze symptoms and suggest suitable OTC medicines.\",\"severity\":\"not applicable\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:23:05', '2026-01-11 10:23:05'),
(126, 1, 'Suggest some skin care medicines.', '{\"analysis\":\"You are looking for skin care medicines. Our current stock primarily includes medicines for pain relief, fever, stomach issues, cold & cough, and allergies. We do not have specific skin care medicines available in our current inventory.\",\"severity\":\"mild\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:23:13', '2026-01-11 10:23:13'),
(127, 1, 'I have a severe headache and fever.', '{\"analysis\":\"You are experiencing a severe headache and fever. These symptoms are commonly associated with viral infections like the flu or common cold, or general body malaise.\",\"severity\":\"moderate\",\"recommendations\":[{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is effective in reducing fever and alleviating headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Combiflam\",\"reason\":\"This combines paracetamol and ibuprofen, providing effective relief for both fever and severe headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:24:55', '2026-01-11 10:24:55'),
(128, 1, 'What are some good vitamins for immunity?', '{\"analysis\":\"You\'re asking about vitamins to boost immunity. Our current stock focuses on symptom relief rather than general vitamin supplements. We do not have specific immunity-boosting vitamins available.\",\"severity\":\"mild\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:25:55', '2026-01-11 10:25:55'),
(129, 1, 'I am experiencing nausea and vomiting.', '{\"analysis\":\"You are experiencing nausea and vomiting. These symptoms can be caused by various factors, including mild stomach upset or other conditions. Since there are no specific anti-nausea or anti-vomiting medications available in our current OTC stock, it would be best to consult a healthcare professional.\",\"severity\":\"moderate\",\"recommendations\":[],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:28:21', '2026-01-11 10:28:21'),
(130, 1, 'I am experiencing Acidity and stomach discomfort.', '{\"analysis\":\"You are experiencing symptoms commonly associated with acidity and general stomach discomfort. These are typically mild and can often be managed with over-the-counter remedies.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Antacid Tablets\",\"reason\":\"These tablets are specifically formulated for relief from acidity and indigestion, which aligns with your symptoms.\",\"type\":\"OTC\"},{\"medicine_name\":\"Digene\",\"reason\":\"Digene provides relief from acidity and gas, which can contribute to stomach discomfort.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 10:28:47', '2026-01-11 10:28:47'),
(131, 1, 'I have a severe headache and fever.', '{\"analysis\":\"The user is experiencing a severe headache and fever, which are common symptoms often associated with viral infections or general malaise.\",\"severity\":\"moderate\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This can help reduce fever and alleviate headache pain.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medicine is effective in reducing fever and headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-11 12:12:28', '2026-01-11 12:12:28'),
(132, 1, 'I have a severe headache and fever.', '{\"analysis\":\"You are experiencing a severe headache and fever. These symptoms commonly indicate a viral infection like a cold or flu, but a severe headache can also be a sign of other conditions. For immediate relief of fever and headache, certain over-the-counter medicines can be helpful.\",\"severity\":\"moderate\",\"recommendations\":[{\"medicine_name\":\"Paracetamol 500mg\",\"reason\":\"This medicine is effective for reducing fever and alleviating mild to moderate pain, including headaches.\",\"type\":\"OTC\"},{\"medicine_name\":\"Calpol 650\",\"reason\":\"This medication helps to reduce fever and relieve headaches.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-01-26 05:01:28', '2026-01-26 05:01:28'),
(133, 9, 'I am experiencing Acidity and stomach discomfort.', '{\"analysis\":\"You are experiencing symptoms of acidity and general stomach discomfort. These are common issues often related to indigestion or acid reflux.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Antacid Tablets\",\"reason\":\"These tablets are specifically formulated for relief from acidity and indigestion, which aligns with your symptoms.\",\"type\":\"OTC\"},{\"medicine_name\":\"Digene\",\"reason\":\"Digene provides relief from acidity and gas, which can contribute to stomach discomfort.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-02-04 23:18:26', '2026-02-04 23:18:26'),
(134, 19, 'I have muscle pain and stiffness.', '{\"analysis\":\"You are experiencing muscle pain and stiffness. These are common symptoms often associated with muscle strain, overuse, or minor injuries.\",\"severity\":\"mild\",\"recommendations\":[{\"medicine_name\":\"Volini Gel\",\"reason\":\"This gel is effective for relieving muscle pain and stiffness when applied topically.\",\"type\":\"OTC\"},{\"medicine_name\":\"Flexura D\",\"reason\":\"This medicine acts as a muscle relaxant and provides pain relief, which can help alleviate stiffness and discomfort.\",\"type\":\"OTC\"}],\"disclaimer\":\"This AI is not a medical professional. Please consult a doctor for an accurate diagnosis.\"}', '2026-02-12 05:38:53', '2026-02-12 05:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT 'India',
  `pincode` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `city`, `state`, `country`, `pincode`, `landmark`, `google_id`, `role`, `email_verified_at`, `phone_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'manish731315@gmail.com', '7543943553', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', NULL, NULL, 'admin', NULL, NULL, '$2y$12$djcc2zjdNPc11kLpJTzpDOG7v2aToyUoHiBHyY81A6kkvu/Zey7o2', 'rwMQmzeQnwsu3Cn2DXnu2gquYMMYvwkysVWCMvJS1z2ehcDrdQxTgGe8cXUh', '2025-10-31 22:42:51', '2026-01-11 11:14:38'),
(4, 'aditya kumar', 'aditya@gmail.com', NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, 'user', NULL, NULL, '$2y$12$Qz2NXC0YHgfc/j0SYHgdeuMMOg5cVDylxVF2xuAo62Zz7QYxflUta', NULL, '2025-11-13 08:17:20', '2025-11-13 08:17:20'),
(5, 'Adityakumar', 'adit1213@gmail.com', NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, 'user', NULL, NULL, '$2y$12$gD9QUFCEWul4UUWKOXN0gOiSMtLPiE6N5DrmGgS6F4ESLjl1J/DJC', NULL, '2025-12-20 12:06:55', '2025-12-20 12:06:55'),
(9, 'Manish Kumar', 'yadavmanishji12345@gmail.com', '7070635358', 'Sahnaura, Barh, Patna', 'Patna', 'Bihar', 'India', '803213', 'Near satish petrolpump', '105808469673241506095', 'user', NULL, NULL, '$2y$12$DIdiSSi5ywuVCvIaw.eQXeYELJY5UBoPD8OxoJVvFMdYTpsfTJHNu', NULL, '2025-12-30 14:05:06', '2026-01-02 09:41:34'),
(19, 'Demo Account', 'demo731315@gmail.com', NULL, NULL, NULL, NULL, 'India', NULL, NULL, '112738408543266467597', 'user', NULL, NULL, '$2y$12$lLKMIWa5HEn5E6ptcIrM/OSC9QU2.R8JAA1QvWLjUA67/07fuir0i', 'tqWgJuUD74YtyE9kO2tyNAuLkFq8IKbHcWca4aYomLGkgrtAzwoGb08WgIXO', '2026-01-11 11:56:21', '2026-02-12 05:36:21');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_medicine_id_foreign` (`medicine_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicines_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_medicine_id_foreign` (`medicine_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescriptions_user_id_foreign` (`user_id`),
  ADD KEY `prescriptions_order_id_foreign` (`order_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `symptom_sessions`
--
ALTER TABLE `symptom_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symptom_sessions_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `symptom_sessions`
--
ALTER TABLE `symptom_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prescriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `symptom_sessions`
--
ALTER TABLE `symptom_sessions`
  ADD CONSTRAINT `symptom_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
