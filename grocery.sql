-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 16, 2020 at 07:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `remember_token` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `remember_token`, `image`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$vfph0Bb2iX3UhQTQmjwsAuP4Km6AaP6GgwuBIu6jhQgaaKmsxXwTG', NULL, 'admin.png', 1, '2019-11-04 00:00:00', '2020-06-06 04:38:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 'egg', '1600420207.jpg', 0, '2020-06-04 09:26:02', '2020-09-18 09:10:07'),
(3, 'veggies', '1600420189.jpg', 0, '2020-06-04 09:26:27', '2020-09-18 09:09:49'),
(4, 'fruits', '1600420164.jpg', 0, '2020-06-04 09:26:56', '2020-09-18 09:09:24'),
(7, 'Best Selling Item', '1600154047.jpg', 0, '2020-09-15 07:14:07', '2020-09-15 07:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `category_langs`
--

CREATE TABLE `category_langs` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desciption` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_langs`
--

INSERT INTO `category_langs` (`id`, `lang_id`, `name`, `desciption`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 1, 'electricity', NULL, 18, '2020-12-16 14:24:08', '2020-12-16 14:24:08', NULL),
(8, 2, 'كهرباء', NULL, 18, '2020-12-16 14:24:08', '2020-12-16 14:24:08', NULL),
(9, 1, 'electrecity', NULL, 19, '2020-12-16 14:29:14', '2020-12-16 14:29:14', NULL),
(10, 2, 'electrecity', NULL, 19, '2020-12-16 14:29:14', '2020-12-16 14:29:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_setting`
--

CREATE TABLE `company_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(50) NOT NULL,
  `favicon` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_setting`
--

INSERT INTO `company_setting` (`id`, `name`, `address`, `location`, `phone`, `email`, `website`, `description`, `logo`, `favicon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'edah', '22,GreenLand, Icepark', 'ddd', '8769543456', 'contact@saasmonks.in', 'saasmonks.in', 'The entire food industry is booming with Application launches and campaigns to generate a user base.\r\nThe restaurant business is in revolutionizing pace. Food chain business is competing in the market with technology but the sure-shot solution is Applicat', '5fd9a6d42022b.png', '5f65d34dcc3bc.png', '2019-11-15 00:00:00', '2020-12-16 06:21:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `discount` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `max_use` int(11) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `use_count` int(11) NOT NULL,
  `use_for` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `name`, `code`, `shop_id`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `use_for`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'Bumper Offer', 'TECS-7509', 1, 'test description', 'amount', 10, '1592196221.jpg', 10, '2020-06-17', '2020-06-25', 10, 'Grocery', 0, '2020-06-11 07:27:55', '2020-06-18 11:26:04', '0000-00-00 00:00:00'),
(6, 'new offer', 'CIBQ-6469', 1, 'test description', 'percentage', 10, '1592541293.jpg', 10, '2020-06-19', '2020-06-30', 1, 'Grocery', 0, '2020-06-19 04:34:53', '2020-06-19 04:35:38', '0000-00-00 00:00:00'),
(9, 'latest new offer', 'JZTI-9648', 2, NULL, 'percentage', 20, '1598075721.jpg', 5, '2020-08-30', '2020-09-30', 0, 'Grocery', 0, '2020-08-22 05:15:02', '2020-09-15 07:08:10', '2020-09-15 07:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `symbol` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `country`, `currency`, `code`, `symbol`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek'),
(2, 'America', 'Dollars', 'USD', '$'),
(3, 'Afghanistan', 'Afghanis', 'AFN', '؋'),
(4, 'Argentina', 'Pesos', 'ARS', '$'),
(5, 'Aruba', 'Guilders', 'AWG', 'Afl'),
(6, 'Australia', 'Dollars', 'AUD', '$'),
(7, 'Azerbaijan', 'New Manats', 'AZN', '₼'),
(8, 'Bahamas', 'Dollars', 'BSD', '$'),
(9, 'Barbados', 'Dollars', 'BBD', '$'),
(10, 'Belarus', 'Rubles', 'BYR', 'p.'),
(11, 'Belgium', 'Euro', 'EUR', '€'),
(12, 'Beliz', 'Dollars', 'BZD', 'BZ$'),
(13, 'Bermuda', 'Dollars', 'BMD', '$'),
(14, 'Bolivia', 'Bolivianos', 'BOB', '$b'),
(15, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM'),
(16, 'Botswana', 'Pula', 'BWP', 'P'),
(17, 'Bulgaria', 'Leva', 'BGN', 'Лв.'),
(18, 'Brazil', 'Reais', 'BRL', 'R$'),
(19, 'Britain (United Kingdom)', 'Pounds', 'GBP', '£\r\n'),
(20, 'Brunei Darussalam', 'Dollars', 'BND', '$'),
(21, 'Cambodia', 'Riels', 'KHR', '៛'),
(22, 'Canada', 'Dollars', 'CAD', '$'),
(23, 'Cayman Islands', 'Dollars', 'KYD', '$'),
(24, 'Chile', 'Pesos', 'CLP', '$'),
(25, 'China', 'Yuan Renminbi', 'CNY', '¥'),
(26, 'Colombia', 'Pesos', 'COP', '$'),
(27, 'Costa Rica', 'Colón', 'CRC', '₡'),
(28, 'Croatia', 'Kuna', 'HRK', 'kn'),
(29, 'Cuba', 'Pesos', 'CUP', '₱'),
(30, 'Cyprus', 'Euro', 'EUR', '€'),
(31, 'Czech Republic', 'Koruny', 'CZK', 'Kč'),
(32, 'Denmark', 'Kroner', 'DKK', 'kr'),
(33, 'Dominican Republic', 'Pesos', 'DOP ', 'RD$'),
(34, 'East Caribbean', 'Dollars', 'XCD', '$'),
(35, 'Egypt', 'Pounds', 'EGP', '£'),
(36, 'El Salvador', 'Colones', 'SVC', '$'),
(37, 'England (United Kingdom)', 'Pounds', 'GBP', '£'),
(38, 'Euro', 'Euro', 'EUR', '€'),
(39, 'Falkland Islands', 'Pounds', 'FKP', '£'),
(40, 'Fiji', 'Dollars', 'FJD', '$'),
(41, 'France', 'Euro', 'EUR', '€'),
(42, 'Ghana', 'Cedis', 'GHC', 'GH₵'),
(43, 'Gibraltar', 'Pounds', 'GIP', '£'),
(44, 'Greece', 'Euro', 'EUR', '€'),
(45, 'Guatemala', 'Quetzales', 'GTQ', 'Q'),
(46, 'Guernsey', 'Pounds', 'GGP', '£'),
(47, 'Guyana', 'Dollars', 'GYD', '$'),
(48, 'Holland (Netherlands)', 'Euro', 'EUR', '€'),
(49, 'Honduras', 'Lempiras', 'HNL', 'L'),
(50, 'Hong Kong', 'Dollars', 'HKD', '$'),
(51, 'Hungary', 'Forint', 'HUF', 'Ft'),
(52, 'Iceland', 'Kronur', 'ISK', 'kr'),
(53, 'India', 'Rupees', 'INR', '₹'),
(54, 'Indonesia', 'Rupiahs', 'IDR', 'Rp'),
(55, 'Iran', 'Rials', 'IRR', '﷼'),
(56, 'Ireland', 'Euro', 'EUR', '€'),
(57, 'Isle of Man', 'Pounds', 'IMP', '£'),
(58, 'Israel', 'New Shekels', 'ILS', '₪'),
(59, 'Italy', 'Euro', 'EUR', '€'),
(60, 'Jamaica', 'Dollars', 'JMD', 'J$'),
(61, 'Japan', 'Yen', 'JPY', '¥'),
(62, 'Jersey', 'Pounds', 'JEP', '£'),
(63, 'Kazakhstan', 'Tenge', 'KZT', '₸'),
(64, 'Korea (North)', 'Won', 'KPW', '₩'),
(65, 'Korea (South)', 'Won', 'KRW', '₩'),
(66, 'Kyrgyzstan', 'Soms', 'KGS', 'Лв'),
(67, 'Laos', 'Kips', 'LAK', '	₭'),
(68, 'Latvia', 'Lati', 'LVL', 'Ls'),
(69, 'Lebanon', 'Pounds', 'LBP', '£'),
(70, 'Liberia', 'Dollars', 'LRD', '$'),
(71, 'Liechtenstein', 'Switzerland Francs', 'CHF', 'CHF'),
(72, 'Lithuania', 'Litai', 'LTL', 'Lt'),
(73, 'Luxembourg', 'Euro', 'EUR', '€'),
(74, 'Macedonia', 'Denars', 'MKD', 'Ден\r\n'),
(75, 'Malaysia', 'Ringgits', 'MYR', 'RM'),
(76, 'Malta', 'Euro', 'EUR', '€'),
(77, 'Mauritius', 'Rupees', 'MUR', '₹'),
(78, 'Mexico', 'Pesos', 'MXN', '$'),
(79, 'Mongolia', 'Tugriks', 'MNT', '₮'),
(80, 'Mozambique', 'Meticais', 'MZN', 'MT'),
(81, 'Namibia', 'Dollars', 'NAD', '$'),
(82, 'Nepal', 'Rupees', 'NPR', '₹'),
(83, 'Netherlands Antilles', 'Guilders', 'ANG', 'ƒ'),
(84, 'Netherlands', 'Euro', 'EUR', '€'),
(85, 'New Zealand', 'Dollars', 'NZD', '$'),
(86, 'Nicaragua', 'Cordobas', 'NIO', 'C$'),
(87, 'Nigeria', 'Nairas', 'NGN', '₦'),
(88, 'North Korea', 'Won', 'KPW', '₩'),
(89, 'Norway', 'Krone', 'NOK', 'kr'),
(90, 'Oman', 'Rials', 'OMR', '﷼'),
(91, 'Pakistan', 'Rupees', 'PKR', '₹'),
(92, 'Panama', 'Balboa', 'PAB', 'B/.'),
(93, 'Paraguay', 'Guarani', 'PYG', 'Gs'),
(94, 'Peru', 'Nuevos Soles', 'PEN', 'S/.'),
(95, 'Philippines', 'Pesos', 'PHP', 'Php'),
(96, 'Poland', 'Zlotych', 'PLN', 'zł'),
(97, 'Qatar', 'Rials', 'QAR', '﷼'),
(98, 'Romania', 'New Lei', 'RON', 'lei'),
(99, 'Russia', 'Rubles', 'RUB', '₽'),
(100, 'Saint Helena', 'Pounds', 'SHP', '£'),
(101, 'Saudi Arabia', 'Riyals', 'SAR', '﷼'),
(102, 'Serbia', 'Dinars', 'RSD', 'ع.د'),
(103, 'Seychelles', 'Rupees', 'SCR', '₹'),
(104, 'Singapore', 'Dollars', 'SGD', '$'),
(105, 'Slovenia', 'Euro', 'EUR', '€'),
(106, 'Solomon Islands', 'Dollars', 'SBD', '$'),
(107, 'Somalia', 'Shillings', 'SOS', 'S'),
(108, 'South Africa', 'Rand', 'ZAR', 'R'),
(109, 'South Korea', 'Won', 'KRW', '₩'),
(110, 'Spain', 'Euro', 'EUR', '€'),
(111, 'Sri Lanka', 'Rupees', 'LKR', '₹'),
(112, 'Sweden', 'Kronor', 'SEK', 'kr'),
(113, 'Switzerland', 'Francs', 'CHF', 'CHF'),
(114, 'Suriname', 'Dollars', 'SRD', '$'),
(115, 'Syria', 'Pounds', 'SYP', '£'),
(116, 'Taiwan', 'New Dollars', 'TWD', 'NT$'),
(117, 'Thailand', 'Baht', 'THB', '฿'),
(118, 'Trinidad and Tobago', 'Dollars', 'TTD', 'TT$'),
(119, 'Turkey', 'Lira', 'TRY', 'TL'),
(120, 'Turkey', 'Liras', 'TRL', '₺'),
(121, 'Tuvalu', 'Dollars', 'TVD', '$'),
(122, 'Ukraine', 'Hryvnia', 'UAH', '₴'),
(123, 'United Kingdom', 'Pounds', 'GBP', '£'),
(124, 'United States of America', 'Dollars', 'USD', '$'),
(125, 'Uruguay', 'Pesos', 'UYU', '$U'),
(126, 'Uzbekistan', 'Sums', 'UZS', 'so\'m'),
(127, 'Vatican City', 'Euro', 'EUR', '€'),
(128, 'Venezuela', 'Bolivares Fuertes', 'VEF', 'Bs'),
(129, 'Vietnam', 'Dong', 'VND', '₫\r\n'),
(130, 'Yemen', 'Rials', 'YER', '﷼'),
(131, 'Zimbabwe', 'Zimbabwe Dollars', 'ZWD', 'Z$');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `owner_id`, `shop_id`, `image`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 42, 6, '1591439233.jpeg', 'Egg Elite', '2020-06-06 10:27:13', '2020-06-06 10:31:57', '0000-00-00 00:00:00'),
(2, 42, 6, '1591439303.jpeg', 'Egg & Cheese Burger', '2020-06-06 10:28:23', '2020-06-06 10:28:23', '0000-00-00 00:00:00'),
(3, 42, 7, '1591439348.jpeg', 'Buttermilk Pancakes', '2020-06-06 10:29:08', '2020-06-06 10:29:08', '0000-00-00 00:00:00'),
(4, 42, 7, '1591439376.jpeg', 'Veggie Breakfast Bowl', '2020-06-06 10:29:36', '2020-06-06 10:29:36', '0000-00-00 00:00:00'),
(5, 42, 5, '1591439427.jpeg', 'Hot Salad Bowl', '2020-06-06 10:30:27', '2020-06-06 10:30:27', '0000-00-00 00:00:00'),
(6, 42, 5, '1591439451.jpg', 'Yummy', '2020-06-06 10:30:51', '2020-06-06 10:30:51', '0000-00-00 00:00:00'),
(7, 42, 8, '1591439551.jpeg', 'Quesadilla Cravings Box', '2020-06-06 10:32:31', '2020-06-06 10:32:31', '0000-00-00 00:00:00'),
(8, 42, 8, '1591439582.jpeg', '6 Churros + Dips', '2020-06-06 10:33:02', '2020-06-06 10:33:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `general_setting`
--

CREATE TABLE `general_setting` (
  `id` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `request_duration` int(11) DEFAULT NULL,
  `default_driver_radius` int(11) DEFAULT NULL,
  `sell_product` int(11) NOT NULL DEFAULT 0,
  `default_food_order_status` varchar(50) DEFAULT NULL,
  `default_grocery_order_status` varchar(50) DEFAULT NULL,
  `map_key` varchar(255) DEFAULT NULL,
  `push_notification` int(11) NOT NULL,
  `onesignal_app_id` varchar(255) DEFAULT NULL,
  `onesignal_project_number` varchar(255) DEFAULT NULL,
  `onesignal_api_key` varchar(255) DEFAULT NULL,
  `onesignal_auth_key` varchar(255) DEFAULT NULL,
  `web_notification` int(11) NOT NULL DEFAULT 0,
  `web_onesignal_app_id` varchar(255) DEFAULT NULL,
  `web_onesignal_api_key` varchar(255) DEFAULT NULL,
  `web_onesignal_auth_key` varchar(255) DEFAULT NULL,
  `sms_twilio` int(11) NOT NULL,
  `twilio_account_id` varchar(255) DEFAULT NULL,
  `twilio_auth_token` varchar(255) DEFAULT NULL,
  `twilio_phone_number` varchar(50) DEFAULT NULL,
  `mail_notification` int(11) NOT NULL,
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `delivery_charge_amount` int(11) DEFAULT 0,
  `delivery_charge_per` int(11) DEFAULT 0,
  `commission_amount` int(11) NOT NULL DEFAULT 0,
  `commission_per` int(11) NOT NULL DEFAULT 0,
  `user_verify` int(11) NOT NULL,
  `phone_verify` int(11) NOT NULL,
  `email_verify` int(11) NOT NULL,
  `license_key` varchar(255) DEFAULT NULL,
  `license_name` varchar(255) DEFAULT NULL,
  `license_status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_setting`
--

INSERT INTO `general_setting` (`id`, `currency`, `request_duration`, `default_driver_radius`, `sell_product`, `default_food_order_status`, `default_grocery_order_status`, `map_key`, `push_notification`, `onesignal_app_id`, `onesignal_project_number`, `onesignal_api_key`, `onesignal_auth_key`, `web_notification`, `web_onesignal_app_id`, `web_onesignal_api_key`, `web_onesignal_auth_key`, `sms_twilio`, `twilio_account_id`, `twilio_auth_token`, `twilio_phone_number`, `mail_notification`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `sender_email`, `delivery_charge_amount`, `delivery_charge_per`, `commission_amount`, `commission_per`, `user_verify`, `phone_verify`, `email_verify`, `license_key`, `license_name`, `license_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'USD', 60000, 30, 2, 'Pending', 'Pending', 'AIzaSyDOz5oWyuWCeyh-9c1W5gexDzRakcRP-eM', 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 50, 5, 20, 10, 0, 0, 0, 'b0991edd-95ab-4ab6-b8e1-c4c4308d53fe', 'emAor', 1, '2019-11-15 00:00:00', '2020-12-12 17:05:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_category`
--

CREATE TABLE `grocery_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `category_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocery_category`
--

INSERT INTO `grocery_category` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`, `category_description`) VALUES
(1, 'Household', '1591440807.png', 0, '2020-05-30 07:32:49', '2020-06-06 10:53:27', NULL),
(2, 'Frozen', '1591440910.jpg', 0, '2020-05-30 08:48:52', '2020-06-06 10:55:10', NULL),
(3, 'Food cupboard', '1591440771.png', 0, '2020-05-30 08:49:24', '2020-06-06 10:52:51', NULL),
(4, 'Meat & Fish', '1591440739.png', 0, '2020-05-30 08:50:02', '2020-06-06 10:52:19', NULL),
(5, 'Fruit & Veg', '1591440693.png', 0, '2020-05-30 08:51:19', '2020-06-06 10:51:52', NULL),
(18, NULL, NULL, 0, '2020-12-16 16:24:08', '2020-12-16 16:24:08', NULL),
(19, NULL, NULL, 0, '2020-12-16 16:29:14', '2020-12-16 16:29:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grocery_item`
--

CREATE TABLE `grocery_item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `fake_price` int(11) DEFAULT NULL,
  `sell_price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `stoke` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocery_item`
--

INSERT INTO `grocery_item` (`id`, `name`, `shop_id`, `user_id`, `category_id`, `subcategory_id`, `fake_price`, `sell_price`, `image`, `description`, `brand`, `weight`, `status`, `stoke`, `created_at`, `updated_at`) VALUES
(1, 'Sainsbury\'s Carrots', 1, 42, 5, 1, 2, 1, '1591442644.jpg', 'Eating plenty of fruit and vegetables is one of the most important dietary changes needed to improve your diet and health.', 'Sainsbury', '750G', 0, 500, '2020-06-06 11:24:04', '2020-06-06 11:24:04'),
(2, 'Sainsbury\'s Celery', 1, 42, 5, 1, 5, 2, '1591442810.jpg', 'fresh and crunchy', 'Sainsbury', '350G', 0, 20, '2020-06-06 11:26:50', '2020-06-06 11:26:50'),
(3, 'Sainsbury\'s Fairtrade Bananas Loose', 1, 42, 5, 2, 7, 2, '1591442993.jpg', 'Fairtrade contributes to sustainable development for certified producers by enabling fairer trading conditions, social change and environmental protection.', 'Sainsbury', '1KG', 0, 500, '2020-06-06 11:29:53', '2020-06-06 11:29:53'),
(4, 'Milton Delight Pack of 3 Thermoware Casserole Set', 2, 42, 1, 7, 550, 500, '1600407952.jpeg', 'nothing', 'Milton', '250', 0, 30, '2020-09-18 05:45:52', '2020-09-18 05:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_order`
--

CREATE TABLE `grocery_order` (
  `id` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `deliveryBoy_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `items` varchar(255) DEFAULT NULL,
  `payment` int(11) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `delivery_charge` int(11) NOT NULL,
  `delivery_type` varchar(50) DEFAULT NULL,
  `coupon_price` int(11) DEFAULT 0,
  `discount` int(11) DEFAULT 0,
  `order_status` varchar(50) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `payment_token` varchar(50) DEFAULT NULL,
  `order_otp` int(11) DEFAULT NULL,
  `reject_by` varchar(255) DEFAULT NULL,
  `review_status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grocery_order_child`
--

CREATE TABLE `grocery_order_child` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grocery_review`
--

CREATE TABLE `grocery_review` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `deliveryBoy_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `rate` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grocery_shop`
--

CREATE TABLE `grocery_shop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `radius` int(11) NOT NULL,
  `open_time` varchar(255) NOT NULL,
  `close_time` varchar(255) NOT NULL,
  `delivery_charge` int(11) NOT NULL,
  `delivery_type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocery_shop`
--

INSERT INTO `grocery_shop` (`id`, `name`, `user_id`, `location`, `category_id`, `image`, `cover_image`, `description`, `address`, `latitude`, `longitude`, `website`, `phone`, `radius`, `open_time`, `close_time`, `delivery_charge`, `delivery_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Seelans Superstore', 42, 2, '5,4,3', '1591442215.png', '5ee2014937f61.jpg', 'Seelans Superstore', '150 feet road, rajkot', '22.283781', '70.799828', 'https://www.latlong.net/', '787878787', 100, '10:00 AM', '8:00 PM', 10, 'Both', 0, '2020-06-06 11:16:55', '2020-06-22 07:12:50'),
(2, 'Supermarket', 42, 2, '3,1', '5edf1243d1e18.png', '5ee2013d2cd8d.jpg', 'Supermarket  Cardiff City Stadium', 'Cardiff City Stadium, Leckwith Rd · In Cardiff City Stadium', '21.9612', '70.7939', 'https://www.latlong.net/', '787878787', 20, '8:00 AM', '6:00 PM', 20, 'Home', 0, '2020-06-06 11:20:56', '2020-09-19 04:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_sub_category`
--

CREATE TABLE `grocery_sub_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocery_sub_category`
--

INSERT INTO `grocery_sub_category` (`id`, `name`, `category_id`, `owner_id`, `shop_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vegetables', 5, 42, NULL, '1591441173.jpg', 0, '2020-06-06 10:59:33', '2020-06-06 10:59:33'),
(2, 'Fruit', 5, 42, 1, '1591441254.jpg', 0, '2020-06-06 11:00:54', '2020-06-09 06:14:20'),
(3, 'Chicken', 4, 42, 1, '1591441375.jpg', 0, '2020-06-06 11:02:55', '2020-06-09 06:14:10'),
(4, 'Lamb', 4, 42, 1, '1591441425.jpg', 0, '2020-06-06 11:03:45', '2020-06-09 06:14:00'),
(5, 'Fish', 4, 42, 1, '1591441465.jpg', 0, '2020-06-06 11:04:25', '2020-06-09 06:13:48'),
(6, 'Food cupboard', 3, 42, 1, '1591441583.jpeg', 0, '2020-06-06 11:06:23', '2020-06-09 06:13:37'),
(7, 'Fabric conditioner', 1, 42, 2, '1591441717.jpg', 0, '2020-06-06 11:08:37', '2020-06-09 06:13:15'),
(8, 'Kitche roll', 3, 42, 1, '1591441764.jpg', 0, '2020-06-06 11:09:24', '2020-06-09 06:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `file`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'english', 'english.json', '1580901280.png', 1, '2020-02-05 11:14:40', '2020-02-05 11:14:40'),
(2, 'arebic', 'arebic.json', '1580901435.png', 1, '2020-02-05 11:17:15', '2020-02-05 11:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `radius` int(11) DEFAULT NULL,
  `popular` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `description`, `latitude`, `longitude`, `radius`, `popular`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'London', 'London, the capital of England and the United Kingdom', '51.5074', '0.1278', 50, 1, 0, '2020-06-06 09:35:45', '2020-06-06 09:35:45', '0000-00-00 00:00:00'),
(2, 'Rajkot', 'Test description', '22.3039', '70.8022', 100, 1, 0, '2020-06-06 09:38:11', '2020-06-22 04:55:04', '0000-00-00 00:00:00'),
(3, 'Cardiff', 'Cardiff is a city and the capital of Wales. It is the United Kingdom\'s eleventh-largest city.', '51.4816', '3.1791', 90, 0, 0, '2020-06-06 09:39:16', '2020-06-06 09:39:16', '0000-00-00 00:00:00'),
(4, 'Dubai', NULL, '25.2048', '55.2708', 50, 1, 0, '2020-08-21 12:02:15', '2020-08-22 04:04:58', '2020-08-22 04:04:58'),
(5, 'Dubai', NULL, '26.2048', '56.2708', 60, 1, 0, '2020-08-22 04:15:37', '2020-08-24 10:29:17', '2020-08-24 10:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(5, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(7, '2016_06_01_000004_create_oauth_clients_table', 2),
(8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `notification_type` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_template`
--

CREATE TABLE `notification_template` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `mail_content` text NOT NULL,
  `message_content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_template`
--

INSERT INTO `notification_template` (`id`, `title`, `subject`, `mail_content`, `message_content`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'User Verification', 'User Verification', 'Dear {{name}},<br>&nbsp; &nbsp;<br>&nbsp; &nbsp; Your registration is completed successfully.<br><br>&nbsp; &nbsp; Your Verification code is <b>{{otp}}</b>.<br><br>From {{shop_name}}', 'Dear {{name}}, Your Verification code is {{otp}}. From {{shop_name}}', '1574854450.png', '2019-11-27 11:34:10', '2019-11-27 13:13:54', '0000-00-00 00:00:00'),
(2, 'Forget Password', 'Forget Password', 'Dear {{name}},<br>&nbsp; &nbsp; &nbsp;&nbsp;<br>&nbsp; &nbsp; Your new passowrd is <b>{{password}}</b>.<br><br>From {{shop_name}}<br><br>', 'Dear {{name}},  Your new passowrd is {{password}}. From {{shop_name}}', '1574860457.jpg', '2019-11-27 11:42:00', '2019-11-27 13:14:17', '0000-00-00 00:00:00'),
(3, 'Create Order', 'Create Order', 'Dear {{name}},<br><br>&nbsp; &nbsp;Your Order is successfully created in {{shop}}.<br>&nbsp; &nbsp;<br>&nbsp; &nbsp;Thank you for using our application.<br><br>From {{shop_name}}', 'Dear {{name}}, Your Order is successfully created in {{shop}}. From {{shop_name}}', '1581055777.png', '2019-11-27 13:17:14', '2020-02-07 06:09:37', '0000-00-00 00:00:00'),
(4, 'Cancel Order', 'Cancel Order', 'Dear {{name}},<br><br>&nbsp; &nbsp;Your Order {{order_no}} on {{shop}} is Rejected by Restaurant.<br><br>From {{shop_name}}', 'Dear {{name}}, Your Order {{order_no}} on {{shop}} is Rejected by Restaurant. From {{shop_name}}', '1574861383.png', '2019-11-27 13:27:27', '2020-02-07 10:41:59', '0000-00-00 00:00:00'),
(6, 'Order Arrive', 'Order Arrive', 'Dear {{name}},<br>&nbsp; &nbsp; &nbsp;&nbsp;<br>&nbsp; &nbsp;You have new order {{order_no}} in {{shop}} from {{customer_name}}.<br><br>From {{shop_name}}', 'Dear {{name}}, You have new order {{order_no}} in {{shop}} from {{customer_name}}. From {{shop_name}}', '1574940643.png', '2019-11-28 11:30:43', '2019-12-24 07:42:41', '0000-00-00 00:00:00'),
(7, 'Order Status', 'Order Status', 'Dear {{name}},<br><br>&nbsp; &nbsp;Your Order {{order_no}} on {{shop}} is successfully {{status}}.<br><br>From {{shop_name}}', 'Dear {{name}}, Your Order {{order_no}} on {{shop}} is successfully {{status}}. From {{shop_name}}', '1600767832.png', '2019-12-24 07:38:55', '2020-09-22 09:43:52', '0000-00-00 00:00:00'),
(8, 'Payment Status', 'Payment Status', 'Dear {{name}},<br><br>&nbsp; &nbsp;Your Payment for order {{order_no}} is successfully {{payment_status}}.<br><br>From {{shop_name}}', 'Dear {{name}}, Your Payment for order {{order_no}} is successfully {{payment_status}}. From {{shop_name}}', '1577267855.png', '2019-12-25 09:57:35', '2019-12-25 10:20:56', '0000-00-00 00:00:00'),
(9, 'Order Request', 'Order Request', 'Dear {{name}},<br><br>&nbsp; &nbsp; &nbsp; You have new request for order {{order_no}}&nbsp;at {{user_address}} by {{shop}}.<br><br>from {{shop_name}}<br><br>', 'Dear {{name}}, You have new request for order {{order_no}} at {{user_address}} by {{shop}}. from {{shop_name}}', '1579160492.png', '2020-01-16 07:41:32', '2020-01-16 07:45:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'B89nQIIEsLiCebp7k1CuW0WpRQzAMDX64kA60gSW', 'http://localhost', 1, 0, 0, '2019-11-17 23:02:47', '2019-11-17 23:02:47'),
(2, NULL, 'Laravel Password Grant Client', '0xQbOjfOLo0R6YA8v86jnWdm2OVQArLHpWs5JlTr', 'http://localhost', 0, 1, 0, '2019-11-17 23:02:47', '2019-11-17 23:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-11-17 23:02:47', '2019-11-17 23:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner_setting`
--

CREATE TABLE `owner_setting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `web_notification` int(11) DEFAULT 0,
  `play_sound` int(11) NOT NULL DEFAULT 0,
  `sound` varchar(255) DEFAULT NULL,
  `coupon` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `default_food_order_status` varchar(50) DEFAULT 'Pending',
  `default_grocery_order_status` varchar(50) DEFAULT 'Pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner_setting`
--

INSERT INTO `owner_setting` (`id`, `user_id`, `web_notification`, `play_sound`, `sound`, `coupon`, `status`, `default_food_order_status`, `default_grocery_order_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 42, 1, 0, NULL, 0, 0, 'Pending', 'Pending', '2020-06-06 04:43:17', '2020-06-06 08:38:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_setting`
--

CREATE TABLE `payment_setting` (
  `id` int(11) NOT NULL,
  `cod` int(11) NOT NULL,
  `stripe` int(11) NOT NULL,
  `paypal` int(11) NOT NULL,
  `razor` int(11) NOT NULL,
  `paytabs` int(11) NOT NULL DEFAULT 0,
  `stripePublicKey` varchar(255) DEFAULT NULL,
  `stripeSecretKey` varchar(255) DEFAULT NULL,
  `paypalSendbox` varchar(255) DEFAULT NULL,
  `paypalProduction` varchar(255) DEFAULT NULL,
  `razorPublishKey` varchar(255) DEFAULT NULL,
  `razorSecretKey` varchar(255) DEFAULT NULL,
  `paytab_email` varchar(255) DEFAULT NULL,
  `paytab_secret_key` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_setting`
--

INSERT INTO `payment_setting` (`id`, `cod`, `stripe`, `paypal`, `razor`, `paytabs`, `stripePublicKey`, `stripeSecretKey`, `paypalSendbox`, `paypalProduction`, `razorPublishKey`, `razorSecretKey`, `paytab_email`, `paytab_secret_key`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-11-15 00:00:00', '2020-09-21 04:20:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'order.show', 0, '2020-01-03 12:39:45', '2020-01-03 12:39:45'),
(2, 'order.delete', 0, '2020-01-03 12:56:16', '2020-01-03 12:56:16'),
(3, 'user.create', 0, '2020-01-03 12:56:55', '2020-01-03 12:56:55'),
(4, 'user.edit', 0, '2020-01-03 12:57:13', '2020-01-03 12:57:13'),
(5, 'user.show', 0, '2020-01-03 12:57:22', '2020-01-03 12:57:22'),
(6, 'user.delete', 0, '2020-01-03 12:57:32', '2020-01-03 12:57:32'),
(7, 'user.profile', 0, '2020-01-03 12:58:02', '2020-01-03 12:58:02'),
(8, 'category.show', 0, '2020-01-03 13:16:16', '2020-01-03 13:16:16'),
(10, 'category.create', 0, '2020-01-03 13:18:24', '2020-01-03 13:18:24'),
(11, 'category.edit', 0, '2020-01-03 13:19:50', '2020-01-03 13:19:50'),
(12, 'category.delete', 0, '2020-01-03 13:20:03', '2020-01-03 13:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `point_setting`
--

CREATE TABLE `point_setting` (
  `id` int(11) NOT NULL,
  `enable_point` int(11) DEFAULT NULL,
  `point_per_order` int(11) DEFAULT NULL,
  `value_per_point` int(11) DEFAULT NULL,
  `max_order_for_point` int(11) DEFAULT NULL,
  `min_cart_value_for_point` int(11) DEFAULT NULL,
  `max_redeem_amount` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point_setting`
--

INSERT INTO `point_setting` (`id`, `enable_point`, `point_per_order`, `value_per_point`, `max_order_for_point`, `min_cart_value_for_point`, `max_redeem_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 5, 5, 500, 400, '2020-06-15 00:00:00', '2020-06-15 12:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'User', 0, '2020-01-03 12:21:22', '2020-01-03 12:21:22'),
(2, 'Shop Owner', 0, '2020-01-03 12:22:12', '2020-01-03 12:22:12'),
(3, 'Delivery Boy', 0, '2020-01-03 12:22:26', '2020-01-03 12:22:26'),
(4, 'Support Staff', 0, '2020-01-03 12:22:54', '2020-01-03 12:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateOfBirth` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'user.png',
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favourite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friend_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_user` int(11) NOT NULL DEFAULT 0,
  `free_order` int(11) NOT NULL DEFAULT 0,
  `verify` int(11) NOT NULL DEFAULT 0,
  `provider` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'LOCAL',
  `provider_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `lat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_radius` int(11) DEFAULT NULL,
  `driver_available` int(11) DEFAULT NULL,
  `enable_notification` int(11) NOT NULL DEFAULT 0,
  `enable_location` int(11) NOT NULL DEFAULT 0,
  `enable_call` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_code`, `phone`, `dateOfBirth`, `location`, `address`, `address_id`, `email_verified_at`, `password`, `image`, `cover_image`, `favourite`, `remember_token`, `otp`, `referral_code`, `friend_code`, `referral_user`, `free_order`, `verify`, `provider`, `provider_token`, `device_token`, `role`, `status`, `lat`, `lang`, `driver_radius`, `driver_available`, `enable_notification`, `enable_location`, `enable_call`, `created_at`, `updated_at`, `deleted_at`) VALUES
(41, 'user', 'user-foodlands@saasmonks.in', NULL, '455677890234', '2020-02-18', NULL, NULL, 14, NULL, '$2y$10$gYSQm/etPQdXy8iHh7u6neqZjxiV2jMNUSvszPNO08JcnxX0sHFgC', '1589113973.jpg', '5f689c0f5fd88.png', '', NULL, NULL, '4760092', NULL, 0, 0, 0, 'LOCAL', NULL, NULL, 0, 0, '22.25991342318802', '70.78774034476537', NULL, NULL, 1, 1, 1, '2020-05-10 16:32:53', '2020-09-21 06:56:55', '0000-00-00 00:00:00'),
(42, 'عدة', 'admin@admin.com', NULL, '12345378', '1997-11-10', NULL, NULL, NULL, NULL, '$2y$10$z.mC7PCB7fnVijkt7iLqnOWhec/W/NrhnPGynjbBrwORnqKj9ILdi', '1608099807.jpg', NULL, NULL, NULL, '331861', '8807524', NULL, 0, 0, 1, 'LOCAL', NULL, 'null', 1, 0, NULL, NULL, NULL, NULL, 0, 0, 0, '2020-06-05 23:13:17', '2020-12-16 04:23:41', '0000-00-00 00:00:00'),
(43, 'James Johnson', 'driver@gmail.com', NULL, '788778787', '1997-11-10', NULL, NULL, NULL, NULL, '$2y$10$zHDxK8xd9/XCHwVjml4fH.DeCEVJ7HD7jWg7bLMY4loW7JQLF1Xu6', '1591446404.jpeg', NULL, '', NULL, '800320', NULL, NULL, 0, 0, 1, 'LOCAL', NULL, NULL, 2, 0, '22.2914218', '70.8000912', 35, 1, 0, 0, 0, '2020-06-06 06:56:44', '2020-09-17 00:59:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_type` varchar(255) NOT NULL,
  `soc_name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lang` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address_type`, `soc_name`, `street`, `city`, `zipcode`, `lat`, `lang`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 41, 'Home', 'rajkot', 'rajkot', 'rajkot', '360003', '22.2914218', '70.8000912', '2020-05-11 04:43:42', '2020-05-11 04:43:42', '0000-00-00 00:00:00'),
(10, 41, 'Office', 'aakansha complex', 'vijay plot 11', 'rajkot', '360002', '22.28678010928698', '70.79998089951005', '2020-05-11 06:21:48', '2020-05-11 06:21:48', '0000-00-00 00:00:00'),
(14, 41, 'Home', 'radhe hotel', 'mavdi', 'rajkot', '360004', '22.25991342318802', '70.78774034476537', '2020-09-19 06:45:35', '2020-09-19 06:45:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_gallery`
--

CREATE TABLE `user_gallery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_langs`
--
ALTER TABLE `category_langs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_setting`
--
ALTER TABLE `company_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_setting`
--
ALTER TABLE `general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grocery_category`
--
ALTER TABLE `grocery_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grocery_item`
--
ALTER TABLE `grocery_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`category_id`,`subcategory_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `grocery_order`
--
ALTER TABLE `grocery_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`,`customer_id`,`deliveryBoy_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `deliveryBoy_id` (`deliveryBoy_id`);

--
-- Indexes for table `grocery_order_child`
--
ALTER TABLE `grocery_order_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grocery_review`
--
ALTER TABLE `grocery_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grocery_shop`
--
ALTER TABLE `grocery_shop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `location` (`location`);

--
-- Indexes for table `grocery_sub_category`
--
ALTER TABLE `grocery_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_template`
--
ALTER TABLE `notification_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `owner_setting`
--
ALTER TABLE `owner_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_setting`
--
ALTER TABLE `payment_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_gallery`
--
ALTER TABLE `user_gallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_notification`
--
ALTER TABLE `admin_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category_langs`
--
ALTER TABLE `category_langs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `company_setting`
--
ALTER TABLE `company_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `general_setting`
--
ALTER TABLE `general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grocery_category`
--
ALTER TABLE `grocery_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `grocery_item`
--
ALTER TABLE `grocery_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grocery_order`
--
ALTER TABLE `grocery_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grocery_order_child`
--
ALTER TABLE `grocery_order_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grocery_review`
--
ALTER TABLE `grocery_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grocery_shop`
--
ALTER TABLE `grocery_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grocery_sub_category`
--
ALTER TABLE `grocery_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_template`
--
ALTER TABLE `notification_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `owner_setting`
--
ALTER TABLE `owner_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_setting`
--
ALTER TABLE `payment_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_gallery`
--
ALTER TABLE `user_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grocery_item`
--
ALTER TABLE `grocery_item`
  ADD CONSTRAINT `grocery_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `grocery_category` (`id`),
  ADD CONSTRAINT `grocery_item_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `grocery_sub_category` (`id`);

--
-- Constraints for table `grocery_order`
--
ALTER TABLE `grocery_order`
  ADD CONSTRAINT `grocery_order_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `grocery_shop` (`id`),
  ADD CONSTRAINT `grocery_order_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grocery_order_ibfk_3` FOREIGN KEY (`deliveryBoy_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `grocery_shop`
--
ALTER TABLE `grocery_shop`
  ADD CONSTRAINT `grocery_shop_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grocery_shop_ibfk_2` FOREIGN KEY (`location`) REFERENCES `location` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
