-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2023 at 10:39 PM
-- Server version: 10.5.19-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pedbuat`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `agency_id` bigint(20) NOT NULL,
  `agency_name` varchar(500) NOT NULL,
  `owner_name` varchar(500) NOT NULL,
  `contact_person` varchar(500) NOT NULL,
  `email_address` varchar(500) NOT NULL,
  `phone_1` varchar(25) NOT NULL,
  `phone_2` varchar(25) DEFAULT NULL,
  `specialization_id` varchar(25) DEFAULT NULL,
  `province_id` varchar(25) NOT NULL,
  `capability_id` varchar(25) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Inactive',
  `unit_number` varchar(100) DEFAULT NULL,
  `house_number` varchar(100) DEFAULT NULL,
  `street_name` varchar(500) DEFAULT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `subdivision_id` bigint(20) DEFAULT NULL,
  `barangay_id` bigint(20) NOT NULL,
  `town_id` bigint(20) NOT NULL,
  `address_province_id` bigint(20) NOT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `email_address_secondary` varchar(255) DEFAULT NULL,
  `reason_for_inactive` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`agency_id`, `agency_name`, `owner_name`, `contact_person`, `email_address`, `phone_1`, `phone_2`, `specialization_id`, `province_id`, `capability_id`, `status`, `unit_number`, `house_number`, `street_name`, `building_name`, `subdivision_id`, `barangay_id`, `town_id`, `address_province_id`, `zip_code`, `floor`, `created_by`, `created_at`, `updated_at`, `updated_by`, `email_address_secondary`, `reason_for_inactive`) VALUES
(1, 'Forest Agency', 'V. Ramos', 'Forest Agent', 'victorsubs@yahoo.com', '09889896', NULL, NULL, '3,5', NULL, 'Active', NULL, '1', 'Railway Road', 'star building', NULL, 6, 6, 3, '4234', '1', 1, '2023-03-02 18:21:03', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `agri_type`
--

CREATE TABLE `agri_type` (
  `agri_type_id` bigint(20) NOT NULL,
  `agri_type_name` varchar(500) NOT NULL,
  `agri_type_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `agri_type`
--

INSERT INTO `agri_type` (`agri_type_id`, `agri_type_name`, `agri_type_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(2, 'Orchard', 'Active', 1, '2022-04-27 07:40:03', NULL, NULL),
(3, 'Landss', 'Active', 1, '2022-04-27 07:45:24', '2023-01-18 07:01:50', NULL),
(5, 'Livestock', 'Active', 1, '2022-06-01 10:35:47', '2022-12-30 07:39:26', NULL),
(11, 'Land2', 'Active', 1, '2022-11-09 16:19:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `barangay_id` bigint(20) NOT NULL,
  `barangay_name` varchar(500) NOT NULL,
  `town_id` bigint(20) NOT NULL,
  `province_id` bigint(20) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `adjacent_barangay` varchar(500) DEFAULT NULL,
  `barangay_status` varchar(20) NOT NULL DEFAULT 'New',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`barangay_id`, `barangay_name`, `town_id`, `province_id`, `zip_code`, `adjacent_barangay`, `barangay_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Malda Barangay', 3, 1, '4352', NULL, 'Active', 1, '2023-02-03 00:00:51', '2023-02-02 18:34:21', 1),
(2, 'Another Malda Barangay', 3, 1, '3453', '1', 'Active', 1, '2023-02-03 00:07:13', '2023-02-02 18:37:17', 1),
(3, 'Another Another Malda Barnagay', 3, 1, '3425', '2', 'Active', 1, '2023-02-03 00:07:52', '2023-02-03 03:26:19', 1),
(4, 'Barangay Bihar 1', 5, 2, '4235', NULL, 'Active', 1, '2023-02-03 08:55:03', '2023-02-03 03:25:24', 1),
(5, 'Bihar Barangay 2', 5, 2, '6345', '4', 'New', 1, '2023-02-03 08:56:11', NULL, NULL),
(6, 'Brgy 1', 6, 3, '4234', NULL, 'Active', 1, '2023-02-03 13:20:59', '2023-02-03 07:56:28', 1),
(7, 'brgy 2', 6, 3, '4234', NULL, 'Active', 1, '2023-02-03 13:21:24', '2023-02-03 07:56:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `broker`
--

CREATE TABLE `broker` (
  `broker_id` bigint(20) NOT NULL,
  `broker_name` varchar(500) NOT NULL,
  `email_address` varchar(500) NOT NULL,
  `phone_1` varchar(11) NOT NULL,
  `phone_2` varchar(11) DEFAULT NULL,
  `broker_association_id` varchar(11) NOT NULL,
  `broker_license_number` varchar(25) NOT NULL,
  `specialization_id` varchar(20) DEFAULT NULL,
  `province_id` varchar(20) DEFAULT NULL,
  `capability_id` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Inactive',
  `notes_about_broker` varchar(500) DEFAULT NULL,
  `unit_number` varchar(100) DEFAULT NULL,
  `house_number` varchar(100) NOT NULL,
  `street_name` varchar(500) NOT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `subdivision_id` bigint(20) DEFAULT NULL,
  `barangay_id` bigint(20) NOT NULL,
  `town_id` bigint(20) NOT NULL,
  `address_province_id` bigint(20) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `reason_for_inactive` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `broker_association`
--

CREATE TABLE `broker_association` (
  `broker_association_id` bigint(20) NOT NULL,
  `broker_association_name` varchar(500) NOT NULL,
  `contact_person` varchar(500) NOT NULL,
  `email_address` varchar(500) NOT NULL,
  `phone_1` varchar(11) NOT NULL,
  `phone_2` varchar(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Active',
  `unit_number` varchar(100) DEFAULT NULL,
  `house_number` varchar(100) NOT NULL,
  `street_name` varchar(500) NOT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `subdivision_id` bigint(20) DEFAULT NULL,
  `barangay_id` bigint(20) NOT NULL,
  `town_id` bigint(20) NOT NULL,
  `province_id` varchar(20) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `address_province_id` int(11) DEFAULT NULL,
  `capability_id` varchar(45) DEFAULT NULL,
  `reason_for_inactive` varchar(45) DEFAULT NULL,
  `specialization_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `broker_association`
--

INSERT INTO `broker_association` (`broker_association_id`, `broker_association_name`, `contact_person`, `email_address`, `phone_1`, `phone_2`, `status`, `unit_number`, `house_number`, `street_name`, `building_name`, `subdivision_id`, `barangay_id`, `town_id`, `province_id`, `zip_code`, `floor`, `created_by`, `created_at`, `updated_at`, `updated_by`, `address_province_id`, `capability_id`, `reason_for_inactive`, `specialization_id`) VALUES
(1, 'REBA', 'Jaime Jacinto', 'victorsubs@yahoo.com', '9995766055', NULL, 'Active', NULL, '', '1 Mountain View', NULL, 0, 6, 6, '3,4', NULL, NULL, 1, '2023-03-02 18:25:02', NULL, NULL, 3, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `capability`
--

CREATE TABLE `capability` (
  `capability_id` bigint(20) NOT NULL,
  `capability_name` varchar(500) NOT NULL,
  `capability_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `capability`
--

INSERT INTO `capability` (`capability_id`, `capability_name`, `capability_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(3, 'Drone Video', 'Active', 1, '2022-04-27 09:07:52', NULL, NULL),
(5, 'Helicopter Tripping', 'Active', 1, '2022-04-27 09:08:17', '2022-04-27 03:38:30', 1),
(6, 'Assessor', 'Active', 1, '2022-04-27 09:08:27', '2022-11-09 09:51:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `enquiry_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `enquirytype` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `enquiry` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features_master`
--

CREATE TABLE `features_master` (
  `feature_id` int(11) NOT NULL,
  `feature_name` varchar(45) DEFAULT NULL,
  `feature_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `features_master`
--

INSERT INTO `features_master` (`feature_id`, `feature_name`, `feature_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Cooling', 'Active', '1', '1', NULL, NULL),
(2, '\rHeating Type', 'Active', '1', '1', NULL, NULL),
(3, 'Kitchen Features', 'Active', '1', '1', NULL, NULL),
(4, 'Exterior', 'Active', '1', '1', NULL, NULL),
(5, 'Swimming Pool', 'Active', '1', '1', NULL, NULL),
(6, 'Elevator', 'Active', '1', '1', NULL, NULL),
(7, 'Fire Place', 'Active', '1', '1', NULL, NULL),
(8, 'Free Wifi', 'Active', '1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `floor_plan`
--

CREATE TABLE `floor_plan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `floor_area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `floor_plan`
--

INSERT INTO `floor_plan` (`id`, `name`, `property_id`, `floor_area`) VALUES
(1, 'First Floor', 1, '240'),
(2, 'Second Floor', 1, '1500'),
(3, 'First Floor', 3, '400'),
(4, 'Garage', 3, '299'),
(5, 'Garage', 4, '100'),
(6, 'Second Floor ', 4, '200'),
(7, 'First Floor', 6, '750'),
(8, 'Second Floor', 6, '350'),
(9, 'Garage', 6, '150');

-- --------------------------------------------------------

--
-- Table structure for table `master_amenities`
--

CREATE TABLE `master_amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `master_amenities`
--

INSERT INTO `master_amenities` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Swimming Pool', 'Active', NULL, NULL),
(2, 'Air Conditioning', 'Active', NULL, NULL),
(3, 'Window Covering', 'Active', NULL, NULL),
(4, 'Free WiFi', 'Active', NULL, NULL),
(5, 'Central Heating', 'Active', NULL, NULL),
(6, 'Car Parking', 'Active', NULL, NULL),
(7, 'Gym', 'Active', NULL, NULL),
(8, 'Laundry Room', 'Active', NULL, NULL),
(9, 'Window Covering', 'Active', NULL, NULL),
(10, 'Internet', 'Active', NULL, NULL),
(11, 'Alarm', 'Active', NULL, NULL),
(12, 'Pets Allow', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL DEFAULT 'App\\Models\\User',
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` bigint(20) NOT NULL,
  `notification_type_id` bigint(20) DEFAULT NULL,
  `notification_subject` varchar(500) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `notification_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_type_id`, `notification_subject`, `user_id`, `notification_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 'One Property has been listed', 1, 'Inactive', 1, '2023-02-22 19:17:40', NULL, NULL),
(2, 10, 'Property Details Modified For Property HeadlineSample Property', NULL, 'Active', 1, '2023-02-22 22:29:26', NULL, NULL),
(3, 10, 'Property Details Modified For Property HeadlineSample Property', NULL, 'Inactive', 1, '2023-02-22 22:30:15', NULL, NULL),
(4, 10, 'Property Details Modified For Property HeadlineSample Property', NULL, 'Inactive', 1, '2023-02-22 22:33:20', NULL, NULL),
(5, 10, 'Property Details Modified For Property HeadlineSample Property', NULL, 'Inactive', 1, '2023-02-22 22:33:48', NULL, NULL),
(6, 2, 'One New User Created', 1, 'Active', 1, '2023-03-02 14:16:57', NULL, NULL),
(7, 2, 'One New User Created', 1, 'Active', 1, '2023-03-02 14:26:25', NULL, NULL),
(8, 2, 'One New User Created', 1, 'Deleted', 1, '2023-03-02 16:40:21', NULL, NULL),
(9, 2, 'One New User Created', 1, 'Inactive', 1, '2023-03-02 17:39:40', NULL, NULL),
(10, 2, 'One New User Created', 1, 'Deleted', 1, '2023-03-10 17:14:01', NULL, NULL),
(11, 1, 'One Property has been listed', 3, 'Active', 1, '2023-03-13 11:26:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_type`
--

CREATE TABLE `notification_type` (
  `notification_type_id` bigint(20) NOT NULL,
  `notification_type` varchar(200) NOT NULL,
  `notification_type_icon` varchar(45) DEFAULT NULL,
  `notification_type_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `notification_type`
--

INSERT INTO `notification_type` (`notification_type_id`, `notification_type`, `notification_type_icon`, `notification_type_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'New Property Enlisted', 'mdi-city', 'Active', 1, '2022-07-01 11:11:20', NULL, NULL),
(2, 'New User Created', 'mdi-account-plus', 'Active', 1, '2022-07-01 11:53:25', NULL, NULL),
(3, 'Property Approved', 'mdi-checkbox-marked-circle', 'Active', 1, '2022-07-01 11:53:25', NULL, NULL),
(4, 'Property Declined', 'mdi-close-circle', 'Active', 1, '2022-07-01 12:30:38', NULL, NULL),
(5, 'Contact Us', 'mdi-account-plus', 'Active', 1, '2022-07-19 13:04:28', NULL, NULL),
(6, 'Agent Sign Up ', 'mdi-account-plus', 'Active', 1, '2022-07-20 15:26:21', NULL, NULL),
(7, 'Agent Receives Enquiry', 'mdi-account-plus', 'Active', 1, '2022-07-20 15:54:09', NULL, NULL),
(8, 'Property Enquiry', 'mdi-account-plus', 'Active', 1, '2022-07-20 16:06:56', NULL, NULL),
(9, 'A Property Is Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:13:25', NULL, NULL),
(10, 'Property Details Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:15:34', NULL, NULL),
(11, 'Agent Details A Broker Is Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:58:21', NULL, NULL),
(12, 'Broker Details- Broker Association Is Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 15:15:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'api',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `module_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `module_name`) VALUES
(2, 'Add Role', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Roles'),
(5, 'Add Master', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Master Form Level'),
(6, 'Edit Master', 'api', '2021-06-26 05:57:29', NULL, 'Master Form Level'),
(7, 'Delete Master', 'api', '2021-06-26 05:57:29', NULL, 'Master Form Level'),
(8, 'Add Property', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Property Form Level'),
(9, 'Edit Property', 'api', '2021-06-26 05:57:29', NULL, 'Property Form Level'),
(10, 'Property Image', 'api', '2021-06-26 05:57:29', NULL, 'Property Form Level'),
(11, 'Add User', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'User Form Level'),
(12, 'Edit User', 'api', '2021-06-26 05:57:29', NULL, 'User Form Level'),
(15, 'Add Agency', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Agency Form Level'),
(16, 'Edit Agency', 'api', '2021-06-26 05:57:29', NULL, 'Agency Form Level'),
(17, 'Add Broker', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Broker Form Level'),
(18, 'Edit Broker', 'api', '2021-06-26 05:57:29', NULL, 'Broker Form Level'),
(29, 'Enable Master', 'api', '2022-07-21 06:41:09', NULL, 'Master Form Level'),
(30, 'Role Menu', 'api', '2022-10-22 06:41:09', NULL, 'Master Menu Level'),
(31, 'Province Menu', 'api', '2022-10-22 06:41:09', NULL, 'Master Menu Level'),
(32, 'Town Menu', 'api', '2022-10-07 13:11:04', NULL, 'Master Menu Level'),
(33, 'Barangay Menu', 'api', '2022-10-07 13:11:48', NULL, 'Master Menu Level'),
(34, 'Subdivision Menu', 'api', '2022-10-07 13:12:59', NULL, 'Master Menu Level'),
(35, 'Capability Menu', 'api', '2022-10-07 13:13:46', NULL, 'Master Menu Level'),
(36, 'Category Menu', 'api', '2022-10-07 13:13:46', NULL, 'Master Menu Level'),
(37, 'Product Mode Menu', 'api', '2022-10-07 13:15:15', NULL, 'Master Menu Level'),
(38, 'Property Type Menu', 'api', '2022-10-07 13:16:18', NULL, 'Master Menu Level'),
(39, 'Agri Type Menu', 'api', '2022-10-07 13:17:06', NULL, 'Master Menu Level'),
(40, 'Property Classification Menu', 'api', '2022-10-07 13:17:06', NULL, 'Master Menu Level'),
(41, 'Zoning Code Menu', 'api', '2022-10-07 13:19:36', NULL, 'Master Menu Level'),
(42, 'Specialization Menu', 'api', '2022-10-07 13:19:36', NULL, 'Master Menu Level'),
(43, 'User Skills Menu', 'api', '2022-10-07 13:19:36', NULL, 'Master Menu Level'),
(44, 'Skill Based User Reports', 'api', '2022-10-09 13:48:45', NULL, 'Report Menu Level'),
(45, 'Agents Reports', 'api', '2022-10-09 13:49:31', NULL, 'Report Menu Level'),
(46, 'Agencies Reports', 'api', '2022-10-09 13:50:01', NULL, 'Report Menu Level'),
(47, 'Brokers Reports', 'api', '2022-10-09 13:51:34', NULL, 'Report Menu Level'),
(48, 'Broker Associations Reports', 'api', '2022-10-09 13:52:23', NULL, 'Report Menu Level'),
(49, 'Agents Based Agency Reports', 'api', '2022-10-09 13:52:59', NULL, 'Report Menu Level'),
(50, 'Property Based Broker Reports', 'api', '2022-10-09 13:53:35', NULL, 'Report Menu Level'),
(51, 'Agency Linked Broker Reports', 'api', '2022-10-09 13:54:59', NULL, 'Report Menu Level'),
(52, 'BrokerLinkedBrokerAssociationReports', 'api', '2022-10-09 13:55:42', NULL, 'Report Menu Level'),
(53, 'Sellers Reports', 'api', '2022-10-09 13:56:11', NULL, 'Report Menu Level'),
(54, 'User List Reports', 'api', '2022-10-09 13:56:36', NULL, 'Report Menu Level'),
(55, 'User To Activate Reports', 'api', '2022-10-09 13:57:25', NULL, 'Report Menu Level'),
(56, 'Individuals Reports', 'api', '2022-10-09 13:58:00', NULL, 'Report Menu Level'),
(57, 'Sold Rent Reports', 'api', '2022-10-09 13:58:23', NULL, 'Report Menu Level'),
(58, 'Property attachments Reports', 'api', '2022-10-09 13:58:49', NULL, 'Report Menu Level'),
(59, 'User Count Property Reports', 'api', '2022-10-09 13:59:28', NULL, 'Report Menu Level'),
(61, 'Property List', 'api', '2022-10-10 06:21:07', NULL, 'Property Menu Level'),
(62, 'Approve User', 'api', '2022-10-10 06:22:31', NULL, 'Approval Menu Level'),
(63, 'List of Open/Pending Properties', 'api', '2022-10-10 06:23:24', NULL, 'Approval Menu Level'),
(64, 'Role Permissions', 'api', '2022-10-10 06:25:15', NULL, 'Settings Menu Level'),
(65, 'Notification', 'api', '2022-10-10 06:25:30', NULL, 'Settings Menu Level'),
(66, 'Users', 'api', '2022-10-10 06:26:38', NULL, 'Entity Menu Level'),
(67, 'Agency', 'api', '2022-10-10 06:26:59', NULL, 'Entity Menu Level'),
(68, 'Broker', 'api', '2022-10-10 06:27:15', NULL, 'Entity Menu Level'),
(69, 'Broker Association', 'api', '2022-10-10 06:27:41', NULL, 'Entity Menu Level'),
(70, 'Seller', 'api', '2022-10-10 06:28:01', NULL, 'Entity Menu Level'),
(71, 'Add Broker Association', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Broker Association Form Level'),
(72, 'Edit Broker Association', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Broker Association Form Level'),
(73, 'Add Seller', 'api', '2022-10-10 09:19:50', NULL, 'Seller Form Level'),
(74, 'Edit Seller', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'Seller Form Level'),
(75, 'Delete User', 'api', '2021-06-26 05:50:33', '2021-06-26 05:50:33', 'User Form Level'),
(82, 'Change Status', 'api', '2022-11-01 10:13:59', NULL, 'User Form Level'),
(83, 'Property Tracking Report', 'api', '2023-03-28 08:22:53', NULL, 'Report Menu Level');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(189, 'App\\Models\\User', 27, '631465', 'cd8d6fa691c3ad71e77e02330ab24247b24d429676cd2c08a0555f43aea631a4', '[\"*\"]', '2022-06-04 06:16:21', '2022-06-04 06:16:19', '2022-06-04 06:16:21'),
(511, 'App\\Models\\User', 184, '631661', '81c69e492bff0c455ca2ebbb18ff26ab65b338332b71313ff2f22488295eb283', '[\"*\"]', NULL, '2022-10-06 07:32:43', '2022-10-06 07:32:43'),
(515, 'App\\Models\\User', 184, '884785', '6c5f4707d91d8d012b6684b9aeda5ad8574a99631a4eceeb533d73527eae62a8', '[\"*\"]', '2022-10-06 07:37:42', '2022-10-06 07:36:22', '2022-10-06 07:37:42'),
(516, 'App\\Models\\User', 184, '559603', 'c3d17b30a87943b29254671100000801927461e6cd1549563ef80c4aa821c809', '[\"*\"]', NULL, '2022-10-06 07:41:48', '2022-10-06 07:41:48'),
(766, 'App\\Models\\User', 79, '448416', 'bb42f0afa8382232c2f58495a3b1c34d2759c57c8c5c9e7de89d5ee4855b051c', '[\"*\"]', NULL, '2022-11-01 02:04:49', '2022-11-01 02:04:49'),
(767, 'App\\Models\\User', 79, '354021', '8cae30bbfd78c53d55ddcfa86452c0fd1a1109814e147823a2548c432490478f', '[\"*\"]', NULL, '2022-11-01 02:07:38', '2022-11-01 02:07:38'),
(769, 'App\\Models\\User', 78, '102172', '5fb5490e174f7bda864aba1aa65edc860f218bc2ea95f1233c81776ee44fc177', '[\"*\"]', '2022-11-01 03:49:15', '2022-11-01 03:49:13', '2022-11-01 03:49:15'),
(940, 'App\\Models\\User', 46, '258612', '1238e40bb4ed5f20c50b7b9f506351fde2147b39b06c64bab7c455f61b278a47', '[\"*\"]', '2023-01-30 00:47:22', '2022-11-30 00:39:19', '2023-01-30 00:47:22'),
(1043, 'App\\Models\\User', 7, '444218', '402af3cb76cb8dfdf114e8b8deceec3deaa823bd51f0977b2eadc07e954ed569', '[\"*\"]', '2023-02-08 17:28:03', '2023-01-17 02:57:05', '2023-02-08 17:28:03'),
(1070, 'App\\Models\\User', 9, '680044', '4d8d7fc164501f2aa4b90f07b444d6dc3bb3634acacc2a4506a92c2a729f0c80', '[\"*\"]', '2023-01-22 21:38:38', '2023-01-19 03:14:09', '2023-01-22 21:38:38'),
(1082, 'App\\Models\\User', 8, '468054', '7424d8521f9164644a158a1a90e365c596965a3b93d4ba33d63d0712f14b2065', '[\"*\"]', '2023-02-04 23:48:52', '2023-01-30 00:15:57', '2023-02-04 23:48:52'),
(1126, 'App\\Models\\User', 1, '189975', '54c7348af9caf03c441a70612a4bb2b1f17b3048bb4f84ebd26df2b0c6402e66', '[\"*\"]', NULL, '2023-03-29 04:07:02', '2023-03-29 04:07:02');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_category_id` bigint(20) NOT NULL,
  `product_category_name` varchar(500) NOT NULL,
  `product_category_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `nav_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `product_category_name`, `product_category_status`, `created_by`, `created_at`, `updated_at`, `updated_by`, `nav_id`) VALUES
(1, 'For Rent', 'Active', 1, '2022-04-27 16:39:54', '2022-12-30 06:31:24', NULL, 1),
(3, 'For Sale', 'Active', 1, '2022-04-27 16:42:23', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_mode`
--

CREATE TABLE `product_mode` (
  `product_mode_id` bigint(20) NOT NULL,
  `product_mode` varchar(500) NOT NULL,
  `product_mode_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_mode`
--

INSERT INTO `product_mode` (`product_mode_id`, `product_mode`, `product_mode_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'New', 'Active', 1, '2022-04-27 08:30:03', '2022-04-27 03:07:30', 1),
(3, 'For Resale', 'Active', 1, '2022-04-27 08:31:58', NULL, NULL),
(4, 'Renovated', 'Inactive', 1, '2022-04-27 08:38:24', '2022-04-27 03:28:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `domain` varchar(25) DEFAULT 'Agency',
  `furnishing` varchar(55) DEFAULT NULL,
  `associated_broker_id` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agent2` int(11) DEFAULT NULL,
  `agent3` int(11) DEFAULT NULL,
  `price_asked` int(11) DEFAULT NULL,
  `land_area` varchar(255) DEFAULT NULL,
  `building_area` varchar(255) DEFAULT NULL,
  `property_name` varchar(255) DEFAULT NULL,
  `status` varchar(55) DEFAULT 'Open',
  `property_headline` varchar(255) DEFAULT NULL,
  `property_description` longtext DEFAULT NULL,
  `property_classification_id` int(11) DEFAULT NULL,
  `property_type_id` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `unit_no` varchar(255) DEFAULT NULL,
  `house_lot_no` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `property_building_name` varchar(255) DEFAULT NULL,
  `town_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `subdivision_id` int(11) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `select_floor_level` varchar(255) DEFAULT NULL,
  `no_bedrooms` varchar(20) DEFAULT NULL,
  `no_toilets` varchar(20) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `garage` varchar(255) DEFAULT NULL,
  `cooling` varchar(255) DEFAULT NULL,
  `heatingtype` varchar(255) DEFAULT NULL,
  `elevator` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `freewifi` varchar(255) DEFAULT NULL,
  `exteriour` varchar(255) DEFAULT NULL,
  `kitchen` varchar(255) DEFAULT NULL,
  `isFeatured` tinyint(1) DEFAULT 0,
  `agri_type` int(11) DEFAULT NULL,
  `rental_price_asked` int(11) DEFAULT NULL,
  `date_sold` date DEFAULT NULL,
  `minimum_rental_period_rent` varchar(45) DEFAULT NULL,
  `car_spaces_rent` varchar(45) DEFAULT NULL,
  `date_of_month_rent_due` varchar(45) DEFAULT NULL,
  `period_can_extend` varchar(45) DEFAULT NULL,
  `date_rental_started` date DEFAULT NULL,
  `current_rental_expires` date DEFAULT NULL,
  `rental_switch_on` date DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `sale_switch_on` date DEFAULT NULL,
  `price_per_sq_m` varchar(45) DEFAULT NULL,
  `car_spaces_uncovered_property` varchar(45) DEFAULT NULL,
  `garage_spaces_covered_property` varchar(45) DEFAULT NULL,
  `minimum_rental_period_sale` varchar(45) DEFAULT '6',
  `rental_pricing_unit` varchar(45) DEFAULT 'Month',
  `fireplace` varchar(45) DEFAULT NULL,
  `swimming_pool` varchar(45) DEFAULT NULL,
  `active_property_date_limit` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `price_rented` varchar(45) DEFAULT NULL,
  `zonal_value` varchar(45) DEFAULT NULL,
  `zonning_code` varchar(45) DEFAULT NULL,
  `price_sold_for` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `seller_id`, `domain`, `furnishing`, `associated_broker_id`, `user_type`, `user_id`, `agent_id`, `agent2`, `agent3`, `price_asked`, `land_area`, `building_area`, `property_name`, `status`, `property_headline`, `property_description`, `property_classification_id`, `property_type_id`, `product_category_id`, `unit_no`, `house_lot_no`, `street_name`, `property_building_name`, `town_id`, `province_id`, `barangay_id`, `subdivision_id`, `zipcode`, `select_floor_level`, `no_bedrooms`, `no_toilets`, `longitude`, `latitude`, `slug`, `garage`, `cooling`, `heatingtype`, `elevator`, `year`, `freewifi`, `exteriour`, `kitchen`, `isFeatured`, `agri_type`, `rental_price_asked`, `date_sold`, `minimum_rental_period_rent`, `car_spaces_rent`, `date_of_month_rent_due`, `period_can_extend`, `date_rental_started`, `current_rental_expires`, `rental_switch_on`, `sale_price`, `sale_switch_on`, `price_per_sq_m`, `car_spaces_uncovered_property`, `garage_spaces_covered_property`, `minimum_rental_period_sale`, `rental_pricing_unit`, `fireplace`, `swimming_pool`, `active_property_date_limit`, `created_at`, `created_by`, `updated_by`, `updated_at`, `price_rented`, `zonal_value`, `zonning_code`, `price_sold_for`) VALUES
(1, NULL, 'Personal', 'None', NULL, 1, 1, 1, 1, 1, 1200000, '4000', NULL, 'Sample Property', 'Open', 'Sample Property', 'Sample Property', 4, 2, 3, '11', '11', 'Sample Property Address', 'Sample Property Name', 6, 3, 6, 6, '4234', 'Ground', '2', '2', '87.06371452963481', '23.23064018202039', 'sample-property1677073660', 'Yes', 'Central AC', 'Forced Air', NULL, '2023', 'Yes', 'Finish Brick', NULL, 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 1200000, NULL, '0.0033333333333333', '2', '2', NULL, 'Month', 'Yes', 'Yes', NULL, '2023-02-22 19:17:40', '1', NULL, '2023-02-22 17:03:48', NULL, NULL, NULL, NULL),
(2, NULL, 'Personal', NULL, NULL, 3, 3, 3, NULL, NULL, 1000000, '1000', NULL, 'fantastic view of ocean', 'Open', 'holiday location', 'good for the family', 4, 1, 3, NULL, NULL, 'highway', NULL, 6, 3, 6, NULL, '4234', NULL, NULL, NULL, NULL, NULL, 'holiday-location1678686960', '0', 'No', 'No', '0', '2023', '0', 'No', 'No', 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.001', NULL, NULL, NULL, 'Month', '0', '0', NULL, '2023-03-13 11:26:00', '3', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_agent_mapping`
--

CREATE TABLE `property_agent_mapping` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `agent_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `property_id` int(11) NOT NULL,
  `amenities_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`property_id`, `amenities_id`, `status`, `created_by`, `created_at`, `id`) VALUES
(1, 10, 'Active', 1, '2023-02-22 22:34:23', 1),
(1, 11, 'Active', 1, '2023-02-22 22:34:23', 2),
(1, 12, 'Active', 1, '2023-02-22 22:34:23', 3),
(1, 9, 'Active', 1, '2023-02-22 22:34:23', 4),
(1, 8, 'Active', 1, '2023-02-22 22:34:23', 5);

-- --------------------------------------------------------

--
-- Table structure for table `property_classification`
--

CREATE TABLE `property_classification` (
  `property_classification_id` bigint(20) NOT NULL,
  `property_classification` varchar(500) NOT NULL,
  `property_classification_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_classification`
--

INSERT INTO `property_classification` (`property_classification_id`, `property_classification`, `property_classification_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Commercial', 'Active', 1, '2022-04-27 08:52:11', '2022-04-27 03:26:39', NULL),
(3, 'Agricultural', 'Active', 1, '2022-04-27 08:56:56', '2022-12-30 07:53:25', NULL),
(4, 'Residential', 'Active', 1, '2022-04-27 08:58:08', '2022-09-02 08:47:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_feature_mapping`
--

CREATE TABLE `property_feature_mapping` (
  `mapping_id` int(11) NOT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `mapping_date` date DEFAULT NULL,
  `mapping_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_feature_mapping`
--

INSERT INTO `property_feature_mapping` (`mapping_id`, `feature_id`, `property_id`, `mapping_date`, `mapping_status`) VALUES
(1, 1, 35, '2022-05-28', 'Active'),
(2, 2, 35, '2022-05-28', 'Active'),
(3, 3, 35, '2022-05-28', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `images_video` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `isDefault` tinyint(1) DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `images_video`, `type`, `created_at`, `updated_at`, `isDefault`, `description`, `created_by`, `updated_by`) VALUES
(1, 1, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(2, 1, '71921677085619.jpg', 'Image', NULL, '2023-02-22 17:06:59', 0, 'another image', '1', NULL),
(3, 1, 'https://www.youtube.com/watch?v=UnDK8KAi5ds&ab_channel=PHDotNet', 'Video', NULL, NULL, 0, 'Property Video', '1', NULL),
(4, 2, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_tracking`
--

CREATE TABLE `property_tracking` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `date_first_added` date DEFAULT NULL,
  `date_last_modified` date DEFAULT NULL,
  `date_last_status_change` date DEFAULT NULL,
  `date_suspended` date DEFAULT NULL,
  `suspended_reason` longtext DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `user_type` varchar(45) DEFAULT NULL,
  `date_modified_operator` date DEFAULT NULL,
  `operator_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_tracking`
--

INSERT INTO `property_tracking` (`id`, `property_id`, `date_first_added`, `date_last_modified`, `date_last_status_change`, `date_suspended`, `suspended_reason`, `modified_by`, `user_type`, `date_modified_operator`, `operator_name`) VALUES
(1, 1, '2023-02-22', '2023-02-22', '2023-02-22', NULL, '', '', 'Super Admin', NULL, ''),
(2, 2, '2023-03-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_type`
--

CREATE TABLE `property_type` (
  `property_type_id` bigint(20) NOT NULL,
  `property_type` varchar(500) NOT NULL,
  `property_type_status` varchar(20) NOT NULL DEFAULT 'Active',
  `dwelling_type` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `property_type`
--

INSERT INTO `property_type` (`property_type_id`, `property_type`, `property_type_status`, `dwelling_type`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Land', 'Active', 'No', 1, '2022-04-27 16:17:35', '2022-04-27 10:51:18', 1),
(2, 'House', 'Active', 'Yes', 1, '2022-04-27 16:21:31', '2022-04-27 10:52:55', 1),
(4, 'Apartment', 'Active', 'Yes', 1, '2022-06-01 10:34:58', '2022-11-29 08:41:18', 1),
(5, 'Townhouse', 'Active', 'No', 1, '2022-06-01 10:35:09', NULL, NULL),
(9, 'Jpm', 'Active', 'No', 1, '2022-11-12 09:39:10', '2022-11-12 04:09:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `province_id` bigint(20) NOT NULL,
  `province_name` varchar(500) NOT NULL,
  `province_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`province_id`, `province_name`, `province_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'West Bengal', 'Active', 1, '2023-02-02 17:11:40', NULL, NULL),
(2, 'Bihar', 'Active', 1, '2023-02-03 08:53:56', NULL, NULL),
(3, 'Batangas', 'Active', 1, '2023-02-03 13:18:46', NULL, NULL),
(4, 'Laguna', 'Active', 1, '2023-02-03 13:18:55', NULL, NULL),
(5, 'La Union', 'Active', 1, '2023-02-05 10:28:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL DEFAULT 'api',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_role_active` tinyint(4) DEFAULT 1,
  `user_display_role` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `is_role_active`, `user_display_role`) VALUES
(1, 'Super Admin', 'api', '2021-06-27 16:10:33', '2022-01-12 00:14:14', 1, 0),
(3, 'Admin', 'api', '2021-06-27 16:10:33', '2022-09-26 04:56:32', 1, 0),
(4, 'Operator', 'api', '2021-06-27 16:10:33', '2021-06-27 16:10:33', 1, 0),
(26, 'Agent', 'api', '2022-01-12 01:33:06', NULL, 1, 1),
(30, 'Individual', 'api', '2022-08-10 03:21:37', '2022-08-09 21:52:31', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 1),
(2, 3),
(2, 4),
(5, 1),
(5, 3),
(5, 26),
(6, 1),
(6, 3),
(6, 26),
(7, 1),
(7, 3),
(7, 26),
(8, 1),
(8, 4),
(8, 26),
(8, 30),
(9, 1),
(9, 3),
(9, 4),
(9, 26),
(9, 30),
(10, 1),
(10, 3),
(10, 4),
(10, 26),
(10, 30),
(11, 1),
(11, 3),
(11, 26),
(12, 1),
(12, 3),
(12, 26),
(15, 1),
(15, 3),
(15, 26),
(16, 1),
(16, 3),
(16, 26),
(17, 1),
(17, 3),
(17, 26),
(18, 1),
(18, 3),
(18, 26),
(29, 1),
(29, 3),
(29, 26),
(30, 1),
(30, 3),
(30, 4),
(31, 1),
(31, 3),
(31, 4),
(31, 26),
(32, 1),
(32, 3),
(32, 4),
(32, 26),
(33, 1),
(33, 3),
(33, 4),
(33, 26),
(34, 1),
(34, 3),
(34, 4),
(34, 26),
(35, 1),
(35, 3),
(35, 4),
(35, 26),
(36, 1),
(36, 3),
(36, 4),
(36, 26),
(37, 1),
(37, 3),
(37, 4),
(37, 26),
(38, 1),
(38, 3),
(38, 4),
(38, 26),
(39, 1),
(39, 3),
(39, 4),
(39, 26),
(40, 1),
(40, 3),
(40, 4),
(40, 26),
(41, 1),
(41, 3),
(41, 4),
(41, 26),
(42, 1),
(42, 3),
(42, 4),
(42, 26),
(43, 1),
(43, 3),
(43, 4),
(43, 26),
(44, 1),
(44, 3),
(44, 4),
(45, 1),
(45, 3),
(45, 4),
(46, 1),
(46, 3),
(46, 4),
(47, 1),
(47, 3),
(47, 4),
(48, 1),
(48, 3),
(48, 4),
(49, 1),
(49, 3),
(49, 4),
(50, 1),
(50, 3),
(50, 4),
(51, 1),
(51, 3),
(52, 1),
(52, 3),
(52, 4),
(53, 1),
(53, 3),
(53, 4),
(54, 1),
(54, 3),
(54, 4),
(55, 1),
(55, 3),
(55, 4),
(56, 1),
(56, 3),
(56, 4),
(56, 30),
(57, 1),
(57, 3),
(57, 4),
(58, 1),
(58, 3),
(58, 4),
(59, 1),
(59, 3),
(59, 4),
(61, 1),
(61, 3),
(61, 4),
(61, 26),
(61, 30),
(62, 1),
(62, 3),
(63, 1),
(63, 3),
(63, 4),
(64, 1),
(64, 3),
(65, 1),
(65, 3),
(65, 4),
(66, 1),
(66, 3),
(66, 4),
(67, 1),
(67, 3),
(67, 4),
(67, 26),
(68, 1),
(68, 3),
(68, 4),
(68, 26),
(69, 1),
(69, 3),
(69, 4),
(69, 26),
(70, 1),
(70, 3),
(70, 26),
(70, 30),
(71, 1),
(71, 3),
(71, 26),
(72, 1),
(72, 3),
(72, 26),
(73, 1),
(73, 3),
(73, 26),
(74, 1),
(74, 3),
(74, 26),
(75, 1),
(82, 1),
(83, 1),
(83, 3);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `seller_name` varchar(45) DEFAULT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `phone_1` varchar(45) DEFAULT NULL,
  `phone_2` varchar(45) DEFAULT NULL,
  `property_owner_name` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `notes_about_seller` longtext DEFAULT NULL,
  `unit_number` varchar(45) DEFAULT NULL,
  `house_no` varchar(45) DEFAULT NULL,
  `street_name` varchar(45) DEFAULT NULL,
  `subdivision_id` bigint(20) DEFAULT NULL,
  `barangay_id` bigint(20) DEFAULT NULL,
  `town_id` bigint(20) DEFAULT NULL,
  `province_id` bigint(20) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `associated_agency_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `specialization_id` bigint(20) NOT NULL,
  `specialization` varchar(500) NOT NULL,
  `specialization_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`specialization_id`, `specialization`, `specialization_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(2, 'Property Type SP', 'Active', 1, '2022-03-11 23:25:47', '2022-06-11 13:13:17', 1),
(3, 'Property Type SP2', 'Active', 1, '2022-03-11 23:25:47', '2022-06-11 13:23:04', 1),
(8, 'Property Type SP1', 'Active', 1, '2022-06-11 18:47:18', '2022-06-11 13:24:29', 1),
(10, 'Feng Shui Analyst', 'Active', 1, '2022-06-17 11:42:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subdivisions`
--

CREATE TABLE `subdivisions` (
  `subdivision_id` bigint(20) NOT NULL,
  `barangay_id` bigint(20) NOT NULL,
  `town_id` bigint(20) NOT NULL,
  `province_id` bigint(20) DEFAULT NULL,
  `subdivision_name` varchar(200) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `adjacent_subdivision` varchar(500) DEFAULT NULL,
  `subdivision_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subdivisions`
--

INSERT INTO `subdivisions` (`subdivision_id`, `barangay_id`, `town_id`, `province_id`, `subdivision_name`, `zip_code`, `adjacent_subdivision`, `subdivision_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 1, 3, 1, 'Subdivision 1', '4352', NULL, 'Active', 1, '2023-02-03 00:09:03', NULL, NULL),
(2, 1, 3, 1, 'Subdivision 2', '4352', '1', 'Active', 1, '2023-02-03 00:09:35', NULL, NULL),
(3, 4, 5, 2, 'Subdivision 3', '4235', NULL, 'Active', 1, '2023-02-03 08:57:24', NULL, NULL),
(4, 4, 5, 2, 'sub4', '4235', '3', 'Active', 1, '2023-02-03 08:57:42', NULL, NULL),
(5, 6, 6, 3, 'San Rafael Hghts', '4234', NULL, 'Active', 1, '2023-02-03 13:27:30', NULL, NULL),
(6, 6, 6, 3, 'San Antonio Hghts', '4234', NULL, 'Active', 1, '2023-02-03 13:32:40', NULL, NULL),
(7, 6, 6, 3, 'Brgy3', '4234', NULL, 'Active', 1, '2023-02-22 19:12:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_menu`
--

CREATE TABLE `test_menu` (
  `menu_id` bigint(20) NOT NULL,
  `menu_name` varchar(45) DEFAULT NULL,
  `menu_link` varchar(100) DEFAULT NULL,
  `menu_icon` varchar(100) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `test_menu`
--

INSERT INTO `test_menu` (`menu_id`, `menu_name`, `menu_link`, `menu_icon`, `status`) VALUES
(1, 'Add User', 'add-user', 'person_add', ''),
(2, 'Add Role', 'add-role', 'accessibility_new', ''),
(3, 'Doctors', 'doctor', 'person_outline', NULL),
(4, 'Patients', 'patients', 'supervisor_account', NULL),
(5, 'Reports', 'reports', 'assignment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_menu_permission`
--

CREATE TABLE `test_menu_permission` (
  `menu_permission_id` bigint(20) NOT NULL,
  `role_id` bigint(20) DEFAULT NULL,
  `menu_id` bigint(20) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `test_menu_permission`
--

INSERT INTO `test_menu_permission` (`menu_permission_id`, `role_id`, `menu_id`, `status`) VALUES
(1, 3, 1, NULL),
(2, 3, 2, NULL),
(3, 3, 3, NULL),
(4, 3, 4, NULL),
(5, 3, 5, NULL),
(6, 26, 3, NULL),
(7, 26, 4, NULL),
(8, 26, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE `town` (
  `town_id` bigint(20) NOT NULL,
  `town_name` varchar(500) NOT NULL,
  `is_town_city` varchar(20) DEFAULT NULL,
  `province_id` bigint(20) NOT NULL,
  `adjacent_town` varchar(500) DEFAULT NULL,
  `town_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`town_id`, `town_name`, `is_town_city`, `province_id`, `adjacent_town`, `town_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Kolkata', 'City', 1, NULL, 'Active', 1, '2023-02-02 23:59:36', '2023-02-03 07:47:20', 1),
(2, 'Durgapur', 'City', 1, '1', 'Active', 1, '2023-02-02 23:59:53', NULL, NULL),
(3, 'Malda', 'City', 1, '2', 'Active', 1, '2023-02-03 00:00:12', NULL, NULL),
(4, 'Bihar town', 'Town', 2, NULL, 'Active', 1, '2023-02-03 08:54:21', NULL, NULL),
(5, 'Bihar town 1', 'Town', 2, '4', 'Active', 1, '2023-02-03 08:54:35', NULL, NULL),
(6, 'Sto Tomas', 'City', 3, NULL, 'Active', 1, '2023-02-03 13:19:26', NULL, NULL),
(7, 'Malvar', 'Town', 3, '6', 'Active', 1, '2023-02-03 13:19:51', NULL, NULL),
(8, 'Sto Tomas', 'Town', 5, NULL, 'Active', 1, '2023-02-05 10:29:08', NULL, NULL),
(9, 'Sto Tomas', 'Town', 4, NULL, 'Active', 1, '2023-02-05 10:30:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL DEFAULT 3,
  `password` varchar(100) NOT NULL,
  `password_normal` varchar(100) DEFAULT NULL,
  `user_email` varchar(500) NOT NULL,
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `user_status` varchar(45) NOT NULL DEFAULT 'New',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email_verification` tinyint(1) DEFAULT 1,
  `otp` varchar(45) DEFAULT NULL,
  `is_otp_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `password`, `password_normal`, `user_email`, `created_by`, `created_at`, `updated_at`, `updated_by`, `user_status`, `first_name`, `last_name`, `full_name`, `slug`, `email_verification`, `otp`, `is_otp_verified`) VALUES
(1, 1, '$2y$10$VCZ8IJ1ZXWkLwMotdlZS3eWDdnnfemLULG42L/LZWe/IQtm5gxJcG', '223344', 'superadminA@gmail.com', 1, '2023-02-09 09:33:22', NULL, NULL, 'Active', 'Test', 'SuperAdminA', 'Test SuperAdminA', 'test-superadmina', 1, NULL, 1),
(2, 1, '$2y$10$XTIW4OxaslZvMRBymswbk.bMb/gprrFiWdDX547W6HMfhNwogULXK', '186884', 'gyrovic@gmail.com', 1, '2023-03-02 14:16:57', NULL, NULL, 'New', 'Victor', 'Victor', 'Victor Victor', 'victor-victor1677746817', 1, '9146', 1),
(3, 3, '$2y$10$kUJgDdf9ZR3ihZaFoT7kVuKjX50OPK33aQd8rZayKc8EzwMSFMM6S', 'tbob', 'victorsubs@yahoo.com', 1, '2023-03-02 14:26:25', NULL, NULL, 'Active', 'Robert', 'Esguerra', 'Robert Esguerra', 'robert-esguerra1677747385', 1, '', 0),
(4, 3, '$2y$10$hgLh9pkXWWQyf2bNKIYvI.S/WNx2hd5D./jGyLS5dbAzDgWM0YMBW', '751290', 'victor.esg@gmail.com', 1, '2023-03-02 16:40:21', NULL, NULL, 'Inactive', 'Pat', 'Williams', 'Pat Williams', 'pat-williams1677755421', 1, '', 0),
(5, 4, '$2y$10$4f9Jbq.W8cF0prILpvKRzeVx9ObPc0Wo5rZZ6UFWjLyZYxtp.kJb2', '211713', 'tigerscript@yahoo.com', 1, '2023-03-02 17:39:40', NULL, NULL, 'Active', 'Ella', 'Bleach', 'Ella Bleach', 'ella-bleach1677758980', 1, '', 0),
(6, 1, '$2y$10$EhpaBLJLfLmLUnosN7WbZuT5kRAxr780dPvtzi6msauIEtokZoinm', '674631', 'joxaso3214@gpipes.com', 1, '2023-03-10 17:14:01', NULL, NULL, 'Active', 'AdminA', 'AdminB', 'AdminA AdminB', 'admina-adminb1678448641', 1, '2699', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_details_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `first_name` varchar(500) DEFAULT NULL,
  `last_name` varchar(500) DEFAULT NULL,
  `nick_name` varchar(250) DEFAULT NULL,
  `phone_1` varchar(17) DEFAULT NULL,
  `phone_2` varchar(17) DEFAULT NULL,
  `birth_month` varchar(25) DEFAULT NULL,
  `birth_day` varchar(25) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `user_skills` varchar(200) DEFAULT NULL,
  `open_property_limit` int(11) DEFAULT 0,
  `active_user_date_limit` date DEFAULT NULL,
  `is_address_same_as_agency` varchar(45) DEFAULT NULL,
  `unit_number` varchar(100) DEFAULT NULL,
  `house_number` varchar(100) DEFAULT NULL,
  `street_name` varchar(500) DEFAULT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `subdivision_id` bigint(20) DEFAULT NULL,
  `barangay_id` bigint(20) DEFAULT NULL,
  `town_id` bigint(20) DEFAULT NULL,
  `province_id` bigint(20) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `floor` varchar(10) DEFAULT NULL,
  `re_license` varchar(100) DEFAULT NULL,
  `profile_statement` varchar(500) DEFAULT NULL,
  `self_broker` varchar(10) DEFAULT NULL,
  `associated_broker_id` varchar(200) DEFAULT NULL,
  `associated_agency_id` int(11) DEFAULT NULL,
  `agent_photo` varchar(255) DEFAULT NULL,
  `isFeatured` tinyint(1) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `user_description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_details_id`, `user_id`, `first_name`, `last_name`, `nick_name`, `phone_1`, `phone_2`, `birth_month`, `birth_day`, `website`, `user_skills`, `open_property_limit`, `active_user_date_limit`, `is_address_same_as_agency`, `unit_number`, `house_number`, `street_name`, `building_name`, `subdivision_id`, `barangay_id`, `town_id`, `province_id`, `zip_code`, `floor`, `re_license`, `profile_statement`, `self_broker`, `associated_broker_id`, `associated_agency_id`, `agent_photo`, `isFeatured`, `address`, `year`, `user_description`) VALUES
(1, 1, 'Test', 'SuperAdminA', 'Test', '0987567890', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 6, 6, 6, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28651669983712.jpg', NULL, NULL, NULL, NULL),
(2, 2, 'Victor', 'Victor', NULL, '098765432122', NULL, NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'The second super admin user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Robert', 'Esguerra', NULL, '098765654', NULL, NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'Pat', 'Williams', NULL, '0998775674', NULL, NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'second admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 'Ella', 'Bleach', NULL, '099907868', NULL, NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'AdminA', 'AdminB', NULL, '823742833443', NULL, NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_device_mapping`
--

CREATE TABLE `user_device_mapping` (
  `user_device_mapping_id` bigint(20) NOT NULL,
  `device_id` bigint(20) NOT NULL,
  `device_mapping_date` datetime DEFAULT current_timestamp(),
  `device_mapping_status` int(11) NOT NULL DEFAULT 1,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_device_mapping`
--

INSERT INTO `user_device_mapping` (`user_device_mapping_id`, `device_id`, `device_mapping_date`, `device_mapping_status`, `user_id`) VALUES
(1, 5, '2021-12-29 20:04:38', 0, 1),
(2, 6, '2021-12-29 20:04:46', 0, 1),
(3, 5, '2021-12-30 08:53:49', 0, 1),
(4, 5, '2021-12-30 08:54:58', 0, 1),
(5, 5, '2021-12-30 08:58:25', 0, 1),
(6, 5, '2021-12-30 09:00:18', 0, 1),
(7, 5, '2021-12-31 08:56:48', 0, 1),
(8, 5, '2021-12-31 08:56:53', 0, 1),
(9, 5, '2021-12-31 08:56:54', 0, 1),
(10, 5, '2021-12-31 08:56:56', 0, 1),
(11, 4, '2021-12-31 08:56:59', 0, 1),
(12, 5, '2021-12-31 08:57:00', 1, 1),
(13, 5, '2021-12-31 11:41:28', 1, 1),
(14, 5, '2021-12-31 11:48:50', 1, 1),
(15, 5, '2021-12-31 11:50:55', 1, 1),
(16, 5, '2021-12-31 12:06:48', 1, 1),
(17, 5, '2021-12-31 12:07:42', 1, 1),
(18, 5, '2021-12-31 12:08:01', 1, 1),
(19, 5, '2021-12-31 12:16:55', 1, 1),
(20, 5, '2021-12-31 12:18:08', 1, 1),
(21, 5, '2021-12-31 12:18:52', 1, 1),
(22, 5, '2021-12-31 12:18:57', 1, 1),
(23, 5, '2021-12-31 12:25:40', 1, 1),
(24, 5, '2021-12-31 12:27:11', 1, 1),
(25, 5, '2022-01-02 11:25:10', 1, 1),
(26, 5, '2022-01-07 11:09:43', 1, 1),
(27, 5, '2022-01-10 17:32:06', 1, 2),
(28, 5, '2022-01-24 10:58:48', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `user_skills_id` bigint(20) NOT NULL,
  `user_skills` varchar(500) NOT NULL,
  `user_skills_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`user_skills_id`, `user_skills`, `user_skills_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'Creator', 'Active', 1, '2022-03-11 23:43:54', '2022-08-08 11:47:32', 1),
(2, 'Stager', 'Active', 1, '2022-03-11 23:50:24', '2022-03-11 18:20:44', 1),
(3, 'Assessor', 'Active', 1, '2022-03-11 23:50:34', '2022-12-30 07:58:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_tracking`
--

CREATE TABLE `user_tracking` (
  `user_tracking_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `date_active` datetime DEFAULT NULL,
  `date_inactive` datetime DEFAULT NULL,
  `reason_inactive` varchar(500) DEFAULT NULL,
  `user_who_activated` bigint(20) NOT NULL DEFAULT 0,
  `user_who_deactivated` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_tracking`
--

INSERT INTO `user_tracking` (`user_tracking_id`, `user_id`, `date_active`, `date_inactive`, `reason_inactive`, `user_who_activated`, `user_who_deactivated`) VALUES
(1, 2, '2023-03-02 08:46:57', NULL, NULL, 1, 0),
(2, 3, '2023-03-02 08:56:25', NULL, NULL, 1, 0),
(3, 4, '2023-03-02 11:10:21', NULL, NULL, 1, 0),
(4, 5, '2023-03-02 12:09:40', NULL, NULL, 1, 0),
(5, 6, '2023-03-10 11:44:01', NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `zonning_code`
--

CREATE TABLE `zonning_code` (
  `zonning_code_id` bigint(20) NOT NULL,
  `zonning_code` varchar(500) NOT NULL,
  `zonning_code_status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_by` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `zonning_code`
--

INSERT INTO `zonning_code` (`zonning_code_id`, `zonning_code`, `zonning_code_status`, `created_by`, `created_at`, `updated_at`, `updated_by`) VALUES
(3, '89000', 'Active', 1, '2022-03-11 23:21:19', NULL, NULL),
(5, '82000', 'Active', 1, '2022-09-25 15:24:53', '2022-09-25 09:55:41', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`agency_id`),
  ADD KEY `address_province_id` (`province_id`);

--
-- Indexes for table `agri_type`
--
ALTER TABLE `agri_type`
  ADD PRIMARY KEY (`agri_type_id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`barangay_id`),
  ADD KEY `fk_town` (`town_id`),
  ADD KEY `fk_province_barangay` (`province_id`);

--
-- Indexes for table `broker`
--
ALTER TABLE `broker`
  ADD PRIMARY KEY (`broker_id`),
  ADD KEY `address_province_id` (`province_id`);

--
-- Indexes for table `broker_association`
--
ALTER TABLE `broker_association`
  ADD PRIMARY KEY (`broker_association_id`);

--
-- Indexes for table `capability`
--
ALTER TABLE `capability`
  ADD PRIMARY KEY (`capability_id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `features_master`
--
ALTER TABLE `features_master`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `floor_plan`
--
ALTER TABLE `floor_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_amenities`
--
ALTER TABLE `master_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`notification_type_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `product_mode`
--
ALTER TABLE `product_mode`
  ADD PRIMARY KEY (`product_mode_id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_agent_mapping`
--
ALTER TABLE `property_agent_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_classification`
--
ALTER TABLE `property_classification`
  ADD PRIMARY KEY (`property_classification_id`);

--
-- Indexes for table `property_feature_mapping`
--
ALTER TABLE `property_feature_mapping`
  ADD PRIMARY KEY (`mapping_id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_tracking`
--
ALTER TABLE `property_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type`
--
ALTER TABLE `property_type`
  ADD PRIMARY KEY (`property_type_id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`specialization_id`);

--
-- Indexes for table `subdivisions`
--
ALTER TABLE `subdivisions`
  ADD PRIMARY KEY (`subdivision_id`),
  ADD KEY `fk_subdivision_barangay` (`barangay_id`),
  ADD KEY `fk_town_subdivision` (`town_id`),
  ADD KEY `fk_province_subdivision` (`province_id`);

--
-- Indexes for table `test_menu`
--
ALTER TABLE `test_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `test_menu_permission`
--
ALTER TABLE `test_menu_permission`
  ADD PRIMARY KEY (`menu_permission_id`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`town_id`),
  ADD KEY `fk_province` (`province_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email_UNIQUE` (`user_email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_details_id`);

--
-- Indexes for table `user_device_mapping`
--
ALTER TABLE `user_device_mapping`
  ADD PRIMARY KEY (`user_device_mapping_id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`user_skills_id`);

--
-- Indexes for table `user_tracking`
--
ALTER TABLE `user_tracking`
  ADD PRIMARY KEY (`user_tracking_id`);

--
-- Indexes for table `zonning_code`
--
ALTER TABLE `zonning_code`
  ADD PRIMARY KEY (`zonning_code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `agency_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agri_type`
--
ALTER TABLE `agri_type`
  MODIFY `agri_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `barangay_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `broker`
--
ALTER TABLE `broker`
  MODIFY `broker_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `broker_association`
--
ALTER TABLE `broker_association`
  MODIFY `broker_association_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `capability`
--
ALTER TABLE `capability`
  MODIFY `capability_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `enquiry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features_master`
--
ALTER TABLE `features_master`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `floor_plan`
--
ALTER TABLE `floor_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_amenities`
--
ALTER TABLE `master_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `notification_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1127;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_mode`
--
ALTER TABLE `product_mode`
  MODIFY `product_mode_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_classification`
--
ALTER TABLE `property_classification`
  MODIFY `property_classification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property_feature_mapping`
--
ALTER TABLE `property_feature_mapping`
  MODIFY `mapping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_tracking`
--
ALTER TABLE `property_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `property_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `province_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `specialization_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `subdivisions`
--
ALTER TABLE `subdivisions`
  MODIFY `subdivision_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `test_menu`
--
ALTER TABLE `test_menu`
  MODIFY `menu_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test_menu_permission`
--
ALTER TABLE `test_menu_permission`
  MODIFY `menu_permission_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `town`
--
ALTER TABLE `town`
  MODIFY `town_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_details_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_device_mapping`
--
ALTER TABLE `user_device_mapping`
  MODIFY `user_device_mapping_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `user_skills_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_tracking`
--
ALTER TABLE `user_tracking`
  MODIFY `user_tracking_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zonning_code`
--
ALTER TABLE `zonning_code`
  MODIFY `zonning_code_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subdivisions`
--
ALTER TABLE `subdivisions`
  ADD CONSTRAINT `fk_province_subdivision` FOREIGN KEY (`province_id`) REFERENCES `province` (`province_id`),
  ADD CONSTRAINT `fk_subdivision_barangay` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`barangay_id`),
  ADD CONSTRAINT `fk_town_subdivision` FOREIGN KEY (`town_id`) REFERENCES `town` (`town_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
