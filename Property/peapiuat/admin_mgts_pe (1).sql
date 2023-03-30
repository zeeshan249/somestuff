-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2023 at 10:40 PM
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
-- Database: `admin_mgts_pe`
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
(2, 'agency7', 'agency7', 'hfhgf', 'ghffhgg@ggh.com', '6767667777', '5665665566', '3,10', '1,3,2', '3,6', 'Active', '75555', '67', 'htrytrtyr', 'uhuhuhui', 19, 22, 6, 3, '6767', 'hftyftyf', 1, '2022-11-08 15:56:00', NULL, NULL, 'gfdgfdg@uyu.com', NULL),
(61, 'Agency12', 'Owner12', 'asdasdas', 'asdasds@adas.com', '2342342353', NULL, '2,3', '1', '3,5', 'Active', NULL, '33', 'asdasda', 'sadasda', 3, 20, 2, 2, '3443', 'asdasdasd', 1, '2022-11-08 22:07:04', NULL, NULL, NULL, NULL),
(62, 'agency51', 'agency51', 'agency51', 'hghgh@bh.com', '6656556655', NULL, '3,10', '1', '3,5', 'Active', NULL, '66', 'hjhjjh', 'vjh', 1, 2, 1, 2, '7788', 'ggchhh', 1, '2022-11-08 23:19:28', NULL, NULL, NULL, NULL),
(63, 'agency3', 'agency3', 'agency3', 'dsfsdfsd@dasasd.com', '3423423553', '3423423523', '2,10', '1,2', '3', 'Inactive', '33', '33', 'fsdfsd', 'sdfsdf', 3, 20, 2, 2, '4353', 'hjkhjk', 1, '2022-11-11 16:47:41', NULL, NULL, NULL, NULL),
(64, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4', '3,5', 'Active', '3', '3', '345345', '34543', 5, 2, 1, 1, '3443', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL),
(65, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4,5', '3,5', 'Inactive', '3', '3', '345345', '34543', 5, 2, 1, 1, '344444', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL),
(66, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4,5', '3,5', 'Inactive', '3', '3', '345345', '34543', 5, 2, 1, 1, '344444', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL),
(67, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4,5', '3,5', 'Inactive', '3', '3', '345345', '34543', 5, 2, 1, 1, '344444', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL),
(68, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4,5', '3,5', 'Inactive', '3', '3', '345345', '34543', 5, 2, 1, 1, '344444', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL),
(69, 'agency jyoti2', 'jyoti', 'Priyabrata Maiti', 'priyo.783@gmail.com', '919800150003', '756567', '2,3,8', '3,4,5', '3,5', 'Inactive', '3', '3', '345345', '34543', 5, 2, 1, 1, '344444', 'Basement', 1, '2022-12-06 11:53:33', NULL, NULL, 'agencyjyotiBC@gmail.com', NULL);

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
(3, 'Landssss', 'Active', 1, '2022-04-27 07:45:24', '2022-09-02 05:15:46', NULL),
(5, 'Livestock', 'Active', 1, '2022-06-01 10:35:47', NULL, NULL),
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
(1, 'jagganath', 1, 3, '4363', NULL, 'Active', 1, '2023-01-31 23:25:54', '2023-01-31 17:56:32', 1),
(2, 'Ganga Dam', 1, 3, '5555', '', 'Active', 1, '2023-01-31 23:27:53', '2023-01-31 17:57:57', 1),
(3, 'Bokaro Mall', 1, 3, '2414', '', 'Active', 1, '2023-01-31 23:28:34', '2023-01-31 17:58:39', 1),
(4, 'Rock  Garden', 2, 2, '3625', NULL, 'Active', 1, '2023-01-31 23:34:21', '2023-01-31 18:04:28', 1),
(5, 'Ranchi Lake', 2, 2, '1442', '4', 'Active', 1, '2023-01-31 23:35:01', '2023-01-31 18:06:01', 1),
(6, 'Pahari Mandir Ranchi', 2, 2, '5345', '4,5', 'Active', 1, '2023-02-01 00:36:46', '2023-01-31 19:06:51', 1),
(7, 'Buxar barangay', 5, 2, '3523', NULL, 'Active', 1, '2023-02-01 17:00:22', '2023-02-01 11:33:08', 1),
(8, 'Another Buxar  Barangay', 5, 2, '2363', '7', 'Active', 1, '2023-02-01 17:21:15', '2023-02-01 11:51:21', 1),
(9, 'Jamshedpur Barangay', 3, 3, '5856', NULL, 'Active', 1, '2023-02-01 17:27:14', '2023-02-01 11:57:20', 1),
(10, 'Anothe Jamshedpur Barangay', 3, 3, '2412', '9', 'Active', 1, '2023-02-01 17:28:59', '2023-02-01 11:59:06', 1),
(11, 'Another 2 Jamshedpur Barangay', 3, 3, '2454', '9,10', 'Active', 1, '2023-02-01 17:30:23', '2023-02-01 12:00:27', 1),
(12, 'Bokaro Mall1', 1, 3, '4253', '2,3', 'Active', 1, '2023-02-08 00:26:19', '2023-02-11 17:33:44', 1);

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

--
-- Dumping data for table `broker`
--

INSERT INTO `broker` (`broker_id`, `broker_name`, `email_address`, `phone_1`, `phone_2`, `broker_association_id`, `broker_license_number`, `specialization_id`, `province_id`, `capability_id`, `status`, `notes_about_broker`, `unit_number`, `house_number`, `street_name`, `building_name`, `subdivision_id`, `barangay_id`, `town_id`, `address_province_id`, `zip_code`, `floor`, `reason_for_inactive`) VALUES
(20, 'Juan Dela Cruzzz', 'askldjaskld@gmail.com', '0494812717', NULL, '3,4', '12124424', NULL, '2', NULL, 'Active', 'asdasasd', '12', '121', '323 San Juan', 'Bagong Alaminos', 8, 14, 2, 2, '1212', 'Basement', NULL),
(21, 'Jomar Young', 'i2u32897@gmail.com', '1234556677', NULL, '3,4', '122312414', '10', '3', '6', 'Active', NULL, '12', '121', 'San Juan', 'Alaminos', 8, 12, 2, 3, '121122', 'Ground', NULL),
(23, 'Broker Ako4', 'brokerako@shurua.xyz', '9495757585', NULL, '4', 'GTYIE8724', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL),
(27, 'asasdas', 'wqewq@sdsfs.com', '3423423423', NULL, '4,3', 'eqwqw', '2,3', '1', '3', 'Inactive', 'dd', NULL, '66', 'sfefesfes', 'sgsfefe', 3, 20, 2, 1, '3242', 'wfaeweffwe', 'Hi Jpm'),
(28, 'sdsdfsd', 'asasda@adas.com', '45345345345', '34534534534', '5', 'adadqwqw', '3', '1', '5', 'Inactive', 'dd', '33', '33', 'asasdsa', 'asfwe', 2, 19, 1, 1, '4534', 'adasdasd', NULL),
(29, 'Broker Ako', 'brokerako@shurua.xyz', '9495757585', NULL, '3,4', 'GTYIE872', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL),
(30, 'Broker Ako', 'brokerako@shurua.xyz', '9495757585', NULL, '3,4', 'GTYIE872', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL),
(31, 'Broker Ako', 'brokerako@shurua.xyz', '9495757585', NULL, '3,4', 'GTYIE872', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL),
(32, 'Broker Ako', 'brokerako@shurua.xyz', '9495757585', NULL, '3,4', 'GTYIE872', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL),
(33, 'Broker Ako', 'brokerako@shurua.xyz', '9495757585', NULL, '3,4', 'GTYIE872', '3,8,10', '1', '3,5,6', 'Active', 'sas', '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 2, 1, 1, '5858', 'Basement', NULL);

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
(3, 'Jpm', 'Agency_Contact1269', 'agency5556@gmail.com', '1234567890', '6789102190', 'Active', '17', '122', 'abcdd', 'def', 2, 2, 2, '1', '3433', 'First', 1, '2022-05-23 17:57:05', NULL, NULL, 1, '3', NULL, '2,3'),
(4, 'Broker Association24', 'Agency_Contact12', 'agency555@gmail.com', '1234567890', '6789102190', 'Active', '17', '122', 'abcdd', 'def', 2, 2, 1, '1', '343324', 'Ground', 1, '2022-06-25 16:26:40', NULL, NULL, 1, '3', NULL, '2,3'),
(5, 'Broker Association Owner14', 'Agency_Contact23', 'agency1223@gmail.com', '1234567890', '6789102190', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '123123', 'Ground', 1, '2022-09-05 16:41:08', NULL, NULL, 1, '3', NULL, '2,3'),
(6, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3'),
(32, 'AssociationA', 'JPMkkkkkk', 'jpm@gmail.com', '7352723644', '4544444545', 'Inactive', '33', '33', 'hjgjjj', 'saddsa', 3, 20, 2, '1,3', '3543', 'sdfsdsd', 1, '2022-11-09 19:26:29', NULL, NULL, 1, '3', 'hi jpmkitee', '2,3'),
(33, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3'),
(34, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3'),
(35, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3'),
(36, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3'),
(37, 'Broker Association Owner15', 'Agency_Contact2', 'agency1223@gmail.com', '123456789', '678910219', 'Active', '17', '122', 'abc', 'def', 2, 2, 1, '1', '1231231', 'Ground', 1, '2022-09-06 09:31:14', NULL, NULL, 1, '3', NULL, '2,3');

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

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`enquiry_id`, `property_id`, `agent_id`, `email`, `phone`, `description`, `enquirytype`, `status`, `updated_at`, `created_at`, `enquiry`) VALUES
(1, 1, 14, 'zeeshan.mymail@gmail.com', '9614431680', 'sa', 'Apartment', 'Active', '2022-05-15 14:40:52', '2022-05-15 14:40:52', NULL),
(2, 1, 14, 'zeeshaen.mymail@gmail.com', '96543210', 'ew', 'Apartment', 'Active', '2022-05-15 14:51:52', '2022-05-15 14:51:52', NULL),
(3, 1, 14, 'zeesharrn.mymail@gmail.com', '96543210', 'ewrwe', 'Apartment', 'Active', '2022-05-15 14:52:52', '2022-05-15 14:52:52', NULL),
(4, 1, 14, 'vcfdd@gcghc.com', '9614431688', 'asdas', 'Apartment', 'Active', '2022-05-15 15:29:00', '2022-05-15 15:29:00', NULL),
(5, 1, 14, 'vcfdd@gcghc.com', '23423', 'sadasdas', 'Apartment', 'Active', '2022-05-15 15:30:57', '2022-05-15 15:30:57', NULL),
(6, 1, 14, 'fdgdfg@sdfsd.com', '3242342', 'dsfsdfsdf', 'Apartment', 'Active', '2022-05-15 15:39:53', '2022-05-15 15:39:53', NULL),
(7, 1, 14, 'vcfertdd@gcghc.com', '3333333333', 'erterter', 'Apartment', 'Active', '2022-05-15 15:40:47', '2022-05-15 15:40:47', NULL),
(8, 1, 14, 'vcfdwerwerd@gcghc.com', '234234234', 'sferwerwerwe', 'Apartment', 'Active', '2022-05-15 15:41:31', '2022-05-15 15:41:31', NULL),
(9, 1, 14, 'vcfertertertdd@gcghc.com', '34534534', 'dfgdfgdfgdf', 'Apartment', 'Active', '2022-05-15 15:42:32', '2022-05-15 15:42:32', NULL),
(10, 1, 14, 'asdasdsa@ddasdsa.com', '3423423', 'dsfsdfsdfsd', 'Apartment', 'Active', '2022-05-15 15:43:31', '2022-05-15 15:43:31', NULL),
(11, 1, 14, 'werwe@safa.com', '32432422', 'sdfsdfsd', 'Apartment', 'Active', '2022-05-15 15:45:27', '2022-05-15 15:45:27', NULL),
(12, 6, 10, 'vcfdddddd@gcghc.com', '96543210', 'asdasdsadas', 'Apartment', 'Active', '2022-05-15 15:46:21', '2022-05-15 15:46:21', NULL),
(13, 3, 14, 'refedi@mailinator.com', '234234', 'dsfsdfsdf', 'Apartment', 'Active', '2022-05-15 16:04:33', '2022-05-15 16:04:33', NULL),
(14, 3, 14, 'amar.rng@gmail.com', '9083213952', 'Test', 'Apartment', 'Active', '2022-05-16 10:36:24', '2022-05-16 10:36:24', NULL),
(15, 3, 14, 'amar.rng@gmail.com', '9083213952', 'Test', 'Apartment', 'Active', '2022-05-16 10:37:14', '2022-05-16 10:37:14', NULL),
(16, 4, 16, 'vcfZXZXdd@gcghc.com', '43534534', 'sdfsdfsdfsdf', 'Apartment', 'Active', '2022-05-16 10:40:20', '2022-05-16 10:40:20', NULL),
(17, 1, 14, 'vcfdsadd@gcghc.com', '96543210', 'asdasdas', 'Apartment', 'Active', '2022-05-16 10:41:02', '2022-05-16 10:41:02', NULL),
(18, 1, 14, 'sadasd@dad.com', '23423423', 'dsfsdfsd', 'Apartment', 'Active', '2022-05-16 10:41:35', '2022-05-16 10:41:35', NULL),
(19, 1, 14, 'amar.rng@gmail.com', '9083213952', 'Test', 'Apartment', 'Active', '2022-05-16 10:43:43', '2022-05-16 10:43:43', NULL),
(20, 6, 10, 'vcfddsfd@gcghc.com', '323432', 'sdfsdfsd', 'Apartment', 'Active', '2022-05-16 17:51:01', '2022-05-16 17:51:01', NULL),
(21, NULL, NULL, 'sdadss@asdas.com', '3232423', 'sdfds', 'General', 'Active', '2022-05-17 07:08:15', '2022-05-17 07:08:15', NULL),
(22, NULL, NULL, 'asdasa@dasdasd.com', '23423234', 'dsfsddsfs', 'General', 'Active', '2022-05-17 07:09:02', '2022-05-17 07:09:02', NULL),
(23, NULL, NULL, 'vcfasddd@gcghc.com', NULL, 'sadasd', 'General', 'Active', '2022-05-17 07:32:19', '2022-05-17 07:32:19', 'asasd'),
(24, NULL, NULL, 'vcfddd@gcghc.com', '43345345', 'fsdfsdfsdf', 'General', 'Active', '2022-05-19 03:27:18', '2022-05-19 03:27:18', NULL),
(25, 1, 14, 'amar.rng@gmail.com', '1234567890', 'asaa', 'Apartment', 'Active', '2022-05-19 04:25:46', '2022-05-19 04:25:46', NULL),
(26, 1, 14, 'amar.rng@gmail.com', '1234567890', 'asaa', 'Apartment', 'Active', '2022-05-19 04:30:44', '2022-05-19 04:30:44', NULL),
(27, 3, 14, 'vcfdddd@gcghc.com', '3423423', 'dsfsdfsd', 'Apartment', 'Active', '2022-05-19 04:50:23', '2022-05-19 04:50:23', NULL),
(28, 3, 14, 'vffffffdd@gcghc.com', '3423423423', 'dsfsdfsdfsd', 'Apartment', 'Active', '2022-05-19 04:52:18', '2022-05-19 04:52:18', NULL),
(29, 3, 14, 'vcfdasasdd@gcghc.com', '3423423', 'asdasdas', 'Apartment', 'Active', '2022-05-19 04:53:34', '2022-05-19 04:53:34', NULL),
(30, 3, 14, 'rgergerg@asdasda.com', '423423423', 'asdasdas', 'Apartment', 'Active', '2022-05-19 04:55:02', '2022-05-19 04:55:02', NULL),
(31, 3, 14, 'red@red.com', '6835435435', 'hjhjghjghj', 'Apartment', 'Active', '2022-05-19 04:57:07', '2022-05-19 04:57:07', NULL),
(32, 3, 14, 'vcfdhhhgvnd@gcghc.com', '87687687', 'jhgghjhjg', 'Apartment', 'Active', '2022-05-19 04:58:29', '2022-05-19 04:58:29', NULL),
(33, 3, 14, 'ygyug@nhk.com', '87676574', 'jygyjguyg', 'Apartment', 'Active', '2022-05-19 04:59:27', '2022-05-19 04:59:27', NULL),
(34, 3, 14, 'wezava@mailinator.com', '54665', 'Et dolores sed eum e', 'Apartment', 'Active', '2022-05-19 05:00:17', '2022-05-19 05:00:17', NULL),
(35, 3, 14, 'oopd@gcghc.com', '7687687', 'jhgjhgjhgjh', 'Apartment', 'Active', '2022-05-19 05:01:15', '2022-05-19 05:01:15', NULL),
(36, 3, 14, 'vcfdfsdfd@gcghc.com', '4534534534', 'dsfsdfsdfsd', 'Apartment', 'Active', '2022-05-19 05:06:08', '2022-05-19 05:06:08', NULL),
(37, 3, 14, 'dsfsd@sfsdf.com', '234234234', 'sdfsdfsdfsdf', 'Apartment', 'Active', '2022-05-19 05:08:15', '2022-05-19 05:08:15', NULL),
(38, 3, 14, 'rtert@asdas.com', '324234234', 'dsfdsfsdfsdf', 'Apartment', 'Active', '2022-05-19 05:14:59', '2022-05-19 05:14:59', NULL),
(39, 3, 14, 'zeeshan.newemail@gcghc.com', '233242342', 'sadasdasdasd', 'Apartment', 'Active', '2022-05-19 05:16:59', '2022-05-19 05:16:59', NULL),
(40, 3, 14, 'vcfddsss@gcghc.com', '5565575', 'sdfsdfsdf', 'Apartment', 'Active', '2022-05-19 05:19:09', '2022-05-19 05:19:09', NULL),
(41, NULL, NULL, 'vcfdjjj@gcghc.com', '78778', 'khhhhj', 'General', 'Active', '2022-05-19 05:21:42', '2022-05-19 05:21:42', NULL),
(42, NULL, NULL, 'vcfdhhhhd@gcghc.com', '54545456', 'kjhhhgjghj', 'General', 'Active', '2022-05-19 05:22:27', '2022-05-19 05:22:27', NULL),
(43, NULL, NULL, 'vcfdhhd@gcghc.com', NULL, 'gghhg', 'General', 'Active', '2022-05-19 05:30:02', '2022-05-19 05:30:02', 'jjhjhhj'),
(44, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'hello', 'General', 'Active', '2022-05-19 05:34:38', '2022-05-19 05:34:38', 'good'),
(45, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'sadasdasdasd', 'General', 'Active', '2022-05-19 05:35:19', '2022-05-19 05:35:19', 'sadasdasdas'),
(46, 1, 14, 'zeeshan.mymail@gmail.com', '32423423', 'dsfdsfsdfs', 'Apartment', 'Active', '2022-05-19 05:37:04', '2022-05-19 05:37:04', NULL),
(47, 1, 14, 'zeeshan.mymail@gmail.com', '23423423', 'gsdgsdsd', 'Apartment', 'Active', '2022-05-19 05:38:30', '2022-05-19 05:38:30', NULL),
(48, 1, 14, 'zeeshan.mymail@gmail.com', '555555444', 'jjbbjbjbhhb', 'Apartment', 'Active', '2022-05-19 05:41:11', '2022-05-19 05:41:11', NULL),
(49, 1, 14, 'zeeshan.mymail@gmail.com', '5564646', 'kjkjkj', 'Apartment', 'Active', '2022-05-19 05:42:15', '2022-05-19 05:42:15', NULL),
(50, 1, 14, 'zeeshan.mymail@gmail.com', '885222', 'mnbjhbjkkjb', 'Apartment', 'Active', '2022-05-19 05:43:29', '2022-05-19 05:43:29', NULL),
(51, 1, 14, 'sadas@sasda.com', '213123123', 'dfsdfsdfsd', 'Apartment', 'Active', '2022-05-19 05:44:24', '2022-05-19 05:44:24', NULL),
(52, 1, 14, 'vcfdd@gcghc.com', '32423423', 'sfasfasfa', 'Apartment', 'Active', '2022-05-19 05:45:16', '2022-05-19 05:45:16', NULL),
(53, 1, 14, 'zeeshan.mymail@gmail.com', '332234', 'sdfsdfsd', 'Apartment', 'Active', '2022-05-19 05:47:32', '2022-05-19 05:47:32', NULL),
(54, 1, 14, 'zeeshan.mymail@gmail.com', '232131231', 'safasdasd', 'Apartment', 'Active', '2022-05-19 05:48:12', '2022-05-19 05:48:12', NULL),
(55, 1, 14, 'zeeshan.newemail@gmail.com', '123123123', 'sdfsdfsdf', 'Apartment', 'Active', '2022-05-19 05:48:31', '2022-05-19 05:48:31', NULL),
(56, 1, 14, 'waraulwara.mailme@gmail.com', '232332', 'sdfsdfsdf', 'Apartment', 'Active', '2022-05-19 05:49:20', '2022-05-19 05:49:20', NULL),
(57, NULL, NULL, 'zeeshan.newemail@gmail.com', '3232131', 'sadasdas', 'General', 'Active', '2022-05-19 05:50:16', '2022-05-19 05:50:16', NULL),
(58, NULL, NULL, 'zeeshan.newemail@gmail.com', NULL, 'adasdasdasdas', 'General', 'Active', '2022-05-19 05:51:40', '2022-05-19 05:51:40', 'asdasdasda'),
(59, 1, 14, 'amar.rng@gmail.com', '1234567890', 'aasd', 'Apartment', 'Active', '2022-05-19 06:22:01', '2022-05-19 06:22:01', NULL),
(60, NULL, NULL, 'amar.rng@gmail.com', NULL, 'asa', 'General', 'Active', '2022-05-19 06:24:27', '2022-05-19 06:24:27', 'sas'),
(61, 1, 14, 'amar.rng@gmail.com', '1234567890', 'aaa', 'Apartment', 'Active', '2022-05-19 06:56:58', '2022-05-19 06:56:58', NULL),
(62, 1, 14, 'logicnmind@gmail.com', '111', 'www', 'Apartment', 'Active', '2022-05-19 06:57:26', '2022-05-19 06:57:26', NULL),
(63, NULL, NULL, 'zeeshan.newemail@gmail.com', '9614431680', 'sadasdasd', 'General', 'Active', '2022-05-19 07:05:12', '2022-05-19 07:05:12', NULL),
(64, NULL, NULL, 'jozazowyd@mailinator.com', '22323', 'Veniam consectetur', 'General', 'Active', '2022-05-19 07:06:03', '2022-05-19 07:06:03', NULL),
(65, NULL, NULL, 'jozazowyd@mailinator.com', '22323', 'Veniam consectetur', 'General', 'Active', '2022-05-19 07:06:08', '2022-05-19 07:06:08', NULL),
(66, NULL, NULL, 'jozazowyd@mailinator.com', '223237', 'Veniam consectetur', 'General', 'Active', '2022-05-19 07:07:10', '2022-05-19 07:07:10', NULL),
(67, NULL, NULL, 'jozazowyd@mailinator.com', '223237', 'Veniam consectetur', 'General', 'Active', '2022-05-19 07:08:51', '2022-05-19 07:08:51', NULL),
(68, NULL, NULL, 'jozazowyd@mailinator.com', '223237', 'Veniam consectetur', 'General', 'Active', '2022-05-19 07:09:28', '2022-05-19 07:09:28', NULL),
(69, NULL, NULL, 'nitotezuse@mailinator.com', '2342342', 'Et earum veritatis p', 'General', 'Active', '2022-05-19 07:10:46', '2022-05-19 07:10:46', NULL),
(70, NULL, NULL, 'nitotezuse@mailinator.com', '2342342', 'Et earum veritatis p', 'General', 'Active', '2022-05-19 07:11:00', '2022-05-19 07:11:00', NULL),
(71, NULL, NULL, 'nitotezuse@mailinator.com', '2342342', 'Et earum veritatis p', 'General', 'Active', '2022-05-19 07:13:12', '2022-05-19 07:13:12', NULL),
(72, NULL, NULL, 'zeeshan.mymail@gmail.com', '324234', 'fsdfsd', 'General', 'Active', '2022-05-19 07:13:42', '2022-05-19 07:13:42', NULL),
(73, NULL, NULL, 'qeremuxi@mailinator.com', '5666', 'Fugit ea non eu sol', 'General', 'Active', '2022-05-19 07:14:25', '2022-05-19 07:14:25', NULL),
(74, NULL, NULL, 'nobifo@mailinator.com', '46656', 'Consequatur veniam', 'General', 'Active', '2022-05-19 07:16:42', '2022-05-19 07:16:42', NULL),
(75, NULL, NULL, 'nobifo@mailinator.com', '46656', 'Consequatur veniam', 'General', 'Active', '2022-05-19 07:17:16', '2022-05-19 07:17:16', NULL),
(76, NULL, NULL, 'qotik@mailinator.com', '453453', 'Ad in ex tempore qu', 'General', 'Active', '2022-05-19 07:17:47', '2022-05-19 07:17:47', NULL),
(77, NULL, NULL, 'qotik@mailinator.com', '453453', 'Ad in ex tempore qu', 'General', 'Active', '2022-05-19 07:19:27', '2022-05-19 07:19:27', NULL),
(78, NULL, 16, 'bicogy@mailinator.com', '3223423', 'Ea sed dicta ullam d', 'General', 'Active', '2022-05-19 07:19:42', '2022-05-19 07:19:42', NULL),
(79, NULL, 16, 'bicogy@mailinator.com', '3223423', 'Ea sed dicta ullam d', 'General', 'Active', '2022-05-19 07:20:04', '2022-05-19 07:20:04', NULL),
(80, NULL, 16, 'bicogy@mailinator.com', '3223423', 'Ea sed dicta ullam d', 'General', 'Active', '2022-05-19 07:29:42', '2022-05-19 07:29:42', NULL),
(81, NULL, 16, 'bicogy@mailinator.com', '3223423', 'Ea sed dicta ullam d', 'General', 'Active', '2022-05-19 07:30:32', '2022-05-19 07:30:32', NULL),
(82, NULL, 16, 'bicogy@mailinator.com', '3223423', 'Ea sed dicta ullam d', 'General', 'Active', '2022-05-19 07:30:55', '2022-05-19 07:30:55', NULL),
(83, NULL, 16, 'zeeshan.newemail@gmail.com', '9614431680', 'huh', 'General', 'Active', '2022-05-19 07:31:31', '2022-05-19 07:31:31', NULL),
(84, NULL, 16, 'zeeshan.newemail@gmail.com', '9614431680', 'good', 'General', 'Active', '2022-05-19 07:36:38', '2022-05-19 07:36:38', NULL),
(85, 1, 14, 'zeeshan.newemail@gmail.com', '9614431680', 'goodie', 'Apartment', 'Active', '2022-05-19 07:50:42', '2022-05-19 07:50:42', NULL),
(86, 1, 14, 'zeeshan.newemail@gmail.com', '9614431680', 'goodie', 'Apartment', 'Active', '2022-05-19 07:51:06', '2022-05-19 07:51:06', NULL),
(87, NULL, NULL, 'zeeshan.newemail@gmail.com', NULL, 'goood', 'General', 'Active', '2022-05-19 07:58:48', '2022-05-19 07:58:48', 'goodies'),
(88, 1, 14, 'amar.rng@gmail.com', '111', 'dd', 'Apartment', 'Active', '2022-05-19 08:18:28', '2022-05-19 08:18:28', NULL),
(89, 4, 16, 'priyo.asn@gmail.com', '9800150003', 'Test', 'Apartment', 'Active', '2022-05-19 09:43:34', '2022-05-19 09:43:34', NULL),
(90, 4, 16, 'priyo.asn@gmail.com', '9800150003', 'Test', 'Apartment', 'Active', '2022-05-19 09:45:14', '2022-05-19 09:45:14', NULL),
(91, NULL, NULL, 'priyo.asn@gmail.com', NULL, 'Test', 'General', 'Active', '2022-05-19 09:46:05', '2022-05-19 09:46:05', 'Test'),
(92, 50, 16, 'vcfddaa@gcghc.com', '2412312', 'sdasdasdas', 'Apartment', 'Active', '2022-05-31 06:14:55', '2022-05-31 06:14:55', NULL),
(93, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'dsfsdfsdf', 'General', 'Active', '2022-05-31 06:15:30', '2022-05-31 06:15:30', 'fsdffs'),
(94, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'man', 'General', 'Active', '2022-07-19 07:49:03', '2022-07-19 07:49:03', 'good'),
(95, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'man', 'General', 'Active', '2022-07-19 07:49:35', '2022-07-19 07:49:35', 'good'),
(96, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'man', 'General', 'Active', '2022-07-19 07:50:05', '2022-07-19 07:50:05', 'good'),
(97, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'a', 'General', 'Active', '2022-07-19 07:50:40', '2022-07-19 07:50:40', 'd'),
(98, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'man', 'General', 'Active', '2022-07-19 07:51:30', '2022-07-19 07:51:30', 'good'),
(99, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'man', 'General', 'Active', '2022-07-19 07:53:49', '2022-07-19 07:53:49', 'good'),
(100, NULL, NULL, 'asd@adas.com', NULL, 'asd', 'General', 'Active', '2022-07-19 07:54:29', '2022-07-19 07:54:29', 'sad'),
(101, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'asd', 'General', 'Active', '2022-07-20 09:45:57', '2022-07-20 09:45:57', 'sad'),
(102, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'asd', 'General', 'Active', '2022-07-20 09:46:45', '2022-07-20 09:46:45', 'sad'),
(103, NULL, NULL, 'da@das.com', NULL, 'das', 'General', 'Active', '2022-07-20 09:49:08', '2022-07-20 09:49:08', 'da'),
(104, NULL, NULL, 'rr@rr.com', NULL, 'rr', 'General', 'Active', '2022-07-20 09:51:20', '2022-07-20 09:51:20', 'rr'),
(105, NULL, NULL, 'sadas@sadas.com', NULL, 'sadasd', 'General', 'Active', '2022-07-20 09:52:27', '2022-07-20 09:52:27', 'asd'),
(106, NULL, NULL, 'asddd@asdasd.com', NULL, 'saddas', 'General', 'Active', '2022-07-20 09:54:52', '2022-07-20 09:54:52', 'saas'),
(107, NULL, NULL, 'newabc@gmial.com', NULL, 'hiii', 'General', 'Active', '2022-07-20 10:03:31', '2022-07-20 10:03:31', 'good'),
(108, NULL, NULL, 'newabc@gmial.com', NULL, 'hiii', 'General', 'Active', '2022-07-20 10:04:46', '2022-07-20 10:04:46', 'good'),
(109, NULL, NULL, 'newme@gmial.com', NULL, 'asd', 'General', 'Active', '2022-07-20 10:05:08', '2022-07-20 10:05:08', 'das'),
(110, NULL, NULL, 'many@gmail.com', NULL, 'sdasda', 'General', 'Active', '2022-07-20 10:06:57', '2022-07-20 10:06:57', 'sadsda'),
(111, NULL, 10, 'syed222@gmail.com', '7456345235', 'saasdas', 'General', 'Active', '2022-07-20 10:32:51', '2022-07-20 10:32:51', NULL),
(112, 1, 14, 'red1@gmail.com', '876543289', 'good', 'Apartment', 'Active', '2022-07-20 10:39:37', '2022-07-20 10:39:37', NULL),
(113, NULL, NULL, 'sadds@adsa.com', NULL, 'sadasd', 'General', 'Active', '2022-08-09 18:01:18', '2022-08-09 18:01:18', 'sdasa'),
(114, NULL, NULL, 'sad@sad.cok', NULL, 'sadsad', 'General', 'Active', '2022-08-10 03:08:40', '2022-08-10 03:08:40', 'sadda'),
(115, NULL, NULL, 'sad@sad.cok', NULL, 'sadsad', 'General', 'Active', '2022-08-10 03:09:05', '2022-08-10 03:09:05', 'sadda'),
(116, NULL, NULL, 'zeeshan.mymaail@gmail.com', NULL, 'sdasa', 'General', 'Active', '2022-08-10 03:10:09', '2022-08-10 03:10:09', 'dsasda'),
(117, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'sadas', 'General', 'Active', '2022-08-10 03:12:22', '2022-08-10 03:12:22', 'sadd'),
(118, NULL, NULL, 'dfgd@fs.com', NULL, 'sdfsdfsdf', 'General', 'Active', '2022-08-10 03:18:32', '2022-08-10 03:18:32', 'fdsdsf'),
(119, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'dsdsf', 'General', 'Active', '2022-08-10 03:19:29', '2022-08-10 03:19:29', 'dsf'),
(120, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'as', 'General', 'Active', '2022-08-10 03:20:19', '2022-08-10 03:20:19', 'asds'),
(121, NULL, NULL, 'wqewe@asdsda.com', NULL, 'assad', 'General', 'Active', '2022-09-05 03:30:08', '2022-09-05 03:30:08', 'sadsda'),
(122, NULL, NULL, 'zeeshan.mymail22@gmail.com', NULL, 'fsdfsdsd', 'General', 'Active', '2022-09-06 11:22:52', '2022-09-06 11:22:52', 'wwqewq'),
(123, NULL, NULL, 'zeeshan.mymail22@gmail.com', NULL, 'fsdfsdsd', 'General', 'Active', '2022-09-06 11:23:03', '2022-09-06 11:23:03', 'wwqewq'),
(124, NULL, NULL, 'tesezug@mailinator.com', NULL, 'Autem ipsum quisqua', 'General', 'Active', '2022-09-06 11:29:18', '2022-09-06 11:29:18', 'Voluptate aut magnam'),
(125, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Hhh', 'General', 'Active', '2022-09-06 12:34:38', '2022-09-06 12:34:38', 'Hh'),
(126, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'sadasddas', 'General', 'Active', '2022-09-06 13:26:36', '2022-09-06 13:26:36', 'asdas'),
(127, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Quibusdam quae volup', 'General', 'Active', '2022-09-06 13:28:20', '2022-09-06 13:28:20', 'Ut odio aliquam dign'),
(128, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Maiores deserunt cul', 'General', 'Active', '2022-09-06 13:31:23', '2022-09-06 13:31:23', 'Provident id delec'),
(129, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Exercitationem conse', 'General', 'Active', '2022-09-06 13:34:13', '2022-09-06 13:34:13', 'Vel perspiciatis ma'),
(130, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'ggjjghjhg', 'General', 'Active', '2022-09-06 14:13:04', '2022-09-06 14:13:04', 'vvbn'),
(131, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'gjggyjggj', 'General', 'Active', '2022-09-06 14:17:24', '2022-09-06 14:17:24', 'hjgghj'),
(132, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'sdadsadsaasd', 'General', 'Active', '2022-09-08 14:33:23', '2022-09-08 14:33:23', 'asddas'),
(133, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'sdadsadsaasd', 'General', 'Active', '2022-09-08 14:33:50', '2022-09-08 14:33:50', 'asddas'),
(134, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'saddasasd', 'General', 'Active', '2022-09-08 14:34:29', '2022-09-08 14:34:29', 'asddas'),
(135, NULL, NULL, 'zeeshan.mymail2@gmail.com', NULL, 'asdsdaasdasd', 'General', 'Active', '2022-09-08 14:35:54', '2022-09-08 14:35:54', 'sdadsa'),
(136, NULL, NULL, 'wexejixok@mailinator.com', NULL, 'Sequi sed qui ad corasddas', 'General', 'Active', '2022-09-08 14:38:39', '2022-09-08 14:38:39', 'Dolor totam eligendi'),
(137, NULL, NULL, 'wexejixok@mailinator.com', NULL, 'Sequi sed qui ad corasddas', 'General', 'Active', '2022-09-08 14:39:14', '2022-09-08 14:39:14', 'Dolor totam eligendi'),
(138, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Distinctio Eos nihi', 'General', 'Active', '2022-09-08 14:39:58', '2022-09-08 14:39:58', 'Architecto pariatur'),
(139, NULL, NULL, 'poda@mailinator.com', NULL, 'Occaecat animi vero', 'General', 'Active', '2022-09-08 14:53:48', '2022-09-08 14:53:48', 'Dolore nisi quis dol'),
(140, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'Distinctio Eos nihi', 'General', 'Active', '2022-09-08 14:54:55', '2022-09-08 14:54:55', 'Architecto pariatur'),
(141, NULL, NULL, 'syedalitest36@gmail.com', NULL, 'assegsefiwebfhjwebfiebwfjhebvhgwevfgwevfuwbfjkweg', 'General', 'Active', '2022-09-08 14:56:48', '2022-09-08 14:56:48', 'goddd'),
(142, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'asfasdasdasdasd', 'General', 'Active', '2022-10-16 15:56:17', '2022-10-16 15:56:17', 'asdasada'),
(143, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'asfasdasdasdasd', 'General', 'Active', '2022-10-16 15:56:32', '2022-10-16 15:56:32', 'asdasada'),
(144, NULL, NULL, 'zeeshan.mymail@gmail.com', NULL, 'asfasdasdasdasd', 'General', 'Active', '2022-10-16 15:56:50', '2022-10-16 15:56:50', 'asdasada'),
(145, 1, 14, 'bapovi5273@haizail.com', '43346343', 'dsfsdsdgsdgsgsegse', 'Apartment', 'Active', '2022-10-16 16:46:19', '2022-10-16 16:46:19', NULL),
(146, NULL, 38, 'haloowakodsaodi@gmail.com', '0987656789', 'Hellow', 'General', 'Active', '2022-11-04 03:37:16', '2022-11-04 03:37:16', NULL),
(147, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:48', '2022-11-04 05:45:48', NULL),
(148, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:49', '2022-11-04 05:45:49', NULL),
(149, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:50', '2022-11-04 05:45:50', NULL),
(150, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:51', '2022-11-04 05:45:51', NULL),
(151, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:51', '2022-11-04 05:45:51', NULL),
(152, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:54', '2022-11-04 05:45:54', NULL),
(153, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:54', '2022-11-04 05:45:54', NULL),
(154, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:54', '2022-11-04 05:45:54', NULL),
(155, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:55', '2022-11-04 05:45:55', NULL),
(156, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:55', '2022-11-04 05:45:55', NULL),
(157, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:55', '2022-11-04 05:45:55', NULL),
(158, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:55', '2022-11-04 05:45:55', NULL),
(159, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:56', '2022-11-04 05:45:56', NULL),
(160, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:45:56', '2022-11-04 05:45:56', NULL),
(161, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:05', '2022-11-04 05:46:05', NULL),
(162, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:05', '2022-11-04 05:46:05', NULL),
(163, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:06', '2022-11-04 05:46:06', NULL),
(164, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:06', '2022-11-04 05:46:06', NULL),
(165, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:07', '2022-11-04 05:46:07', NULL),
(166, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:07', '2022-11-04 05:46:07', NULL),
(167, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:08', '2022-11-04 05:46:08', NULL),
(168, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:09', '2022-11-04 05:46:09', NULL),
(169, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:10', '2022-11-04 05:46:10', NULL),
(170, 1, NULL, 'askdjaskl@gmail.com', '0987654567', 'askldjaskldjsad', 'Apartment', 'Active', '2022-11-04 05:46:11', '2022-11-04 05:46:11', NULL),
(171, 1, NULL, 'jennywigger@gmail.com', '0987654567', 'Hello', 'Apartment', 'Active', '2022-11-04 05:46:36', '2022-11-04 05:46:36', NULL),
(172, 1, NULL, 'jennywigger@gmail.com', '0987654567', 'Hello', 'Apartment', 'Active', '2022-11-04 05:46:37', '2022-11-04 05:46:37', NULL),
(173, NULL, NULL, 'danielasinner@shurua.xyz', NULL, 'hellow', 'General', 'Active', '2022-11-04 06:55:23', '2022-11-04 06:55:23', 'I want to buy'),
(174, NULL, 38, 'asdasdasd@gmail.com', '0983838383', 'asdasdasd', 'General', 'Active', '2022-11-04 07:09:38', '2022-11-04 07:09:38', NULL),
(175, NULL, 38, 'jomarkaskdj@gmail.com', '0987688765', 'Hellow', 'General', 'Active', '2022-11-04 07:14:14', '2022-11-04 07:14:14', NULL),
(176, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:42', '2022-11-05 07:02:42', NULL),
(177, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:46', '2022-11-05 07:02:46', NULL),
(178, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:51', '2022-11-05 07:02:51', NULL),
(179, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:55', '2022-11-05 07:02:55', NULL),
(180, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:58', '2022-11-05 07:02:58', NULL),
(181, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:02:59', '2022-11-05 07:02:59', NULL),
(182, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:00', '2022-11-05 07:03:00', NULL),
(183, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:01', '2022-11-05 07:03:01', NULL),
(184, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:57', '2022-11-05 07:03:57', NULL),
(185, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:57', '2022-11-05 07:03:57', NULL),
(186, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:57', '2022-11-05 07:03:57', NULL),
(187, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:57', '2022-11-05 07:03:57', NULL),
(188, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:03:58', '2022-11-05 07:03:58', NULL),
(189, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:08:53', '2022-11-05 07:08:53', NULL),
(190, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:08:53', '2022-11-05 07:08:53', NULL),
(191, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:08:53', '2022-11-05 07:08:53', NULL),
(192, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:08:53', '2022-11-05 07:08:53', NULL),
(193, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:08:54', '2022-11-05 07:08:54', NULL),
(194, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:10:04', '2022-11-05 07:10:04', NULL),
(195, 75, NULL, 'asdasdsad@gmail.com', '0987654321', 'asdasd', 'Apartment', 'Active', '2022-11-05 07:10:05', '2022-11-05 07:10:05', NULL),
(196, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:35', '2022-11-06 06:59:35', NULL),
(197, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:36', '2022-11-06 06:59:36', NULL),
(198, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:37', '2022-11-06 06:59:37', NULL),
(199, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:37', '2022-11-06 06:59:37', NULL),
(200, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:38', '2022-11-06 06:59:38', NULL),
(201, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:39', '2022-11-06 06:59:39', NULL),
(202, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:39', '2022-11-06 06:59:39', NULL),
(203, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:42', '2022-11-06 06:59:42', NULL),
(204, 1, NULL, 'asdasdsa@gmail.com', '0948575829', 'sdasdasd', 'Apartment', 'Active', '2022-11-06 06:59:51', '2022-11-06 06:59:51', NULL),
(205, NULL, 3, 'aasdasdasd@gmail.com', '0987564788', 'asdasdasd', 'General', 'Active', '2022-11-06 07:00:08', '2022-11-06 07:00:08', NULL),
(206, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:05:50', '2022-11-06 07:05:50', NULL),
(207, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:05:51', '2022-11-06 07:05:51', NULL),
(208, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:47', '2022-11-06 07:08:47', NULL),
(209, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:48', '2022-11-06 07:08:48', NULL),
(210, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:48', '2022-11-06 07:08:48', NULL),
(211, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:48', '2022-11-06 07:08:48', NULL),
(212, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:49', '2022-11-06 07:08:49', NULL),
(213, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:50', '2022-11-06 07:08:50', NULL),
(214, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:51', '2022-11-06 07:08:51', NULL),
(215, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:52', '2022-11-06 07:08:52', NULL),
(216, 1, NULL, 'heloo@gmail.com', '0987565758', 'sadasd', 'Apartment', 'Active', '2022-11-06 07:08:52', '2022-11-06 07:08:52', NULL),
(217, 1, NULL, 'zeeshan.mymail@gmail.com', '5464564565', 'gfhfghfghfg', 'Apartment', 'Active', '2022-11-07 08:32:15', '2022-11-07 08:32:15', NULL),
(218, 1, NULL, 'zeeshan.mymail@gmail.com', '5464564565', 'gfhfghfghfg', 'Apartment', 'Active', '2022-11-07 08:32:32', '2022-11-07 08:32:32', NULL),
(219, 1, NULL, 'zeeshan.mymail@gmail.com', '5463453463', 'jkljkljkljkl', 'Apartment', 'Active', '2022-11-07 08:35:58', '2022-11-07 08:35:58', NULL),
(220, 1, NULL, 'zeeshan.newemail@gmail.com', '5453453434', 'gsdgsdgsdgsd', 'Apartment', 'Active', '2022-11-07 08:37:55', '2022-11-07 08:37:55', NULL),
(221, NULL, 38, 'zeeshan.newemail@gmail.com', '453453466', 'fdgdfgdfgdf', 'General', 'Active', '2022-11-07 08:41:42', '2022-11-07 08:41:42', NULL),
(222, NULL, NULL, 'sadasdsad@gmail.com', NULL, 'asdasd', 'General', 'Active', '2022-11-07 12:17:52', '2022-11-07 12:17:52', 'asdsadsad'),
(223, 92, NULL, 'asdasd32@gmail.com', '2313213123', 'asdasdasd', 'Apartment', 'Active', '2022-11-09 09:45:30', '2022-11-09 09:45:30', NULL),
(224, NULL, NULL, 'zeeshan.mymail3@gmail.com', NULL, 'good', 'General', 'Active', '2022-12-28 08:05:52', '2022-12-28 08:05:52', 'good'),
(225, 1, NULL, 'zeeshan.mymail@gmail.com', '556633445344', 'goood', 'Apartment', 'Active', '2022-12-28 11:21:58', '2022-12-28 11:21:58', NULL),
(226, NULL, 38, 'ewrwer@sasdda.com', '453434534355', 'fdgdfgdfgdf', 'General', 'Active', '2022-12-28 11:26:54', '2022-12-28 11:26:54', NULL);

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

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 78);

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
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 40),
(26, 'App\\Models\\User', 3),
(26, 'App\\Models\\User', 6),
(26, 'App\\Models\\User', 38),
(26, 'App\\Models\\User', 44),
(26, 'App\\Models\\User', 45),
(30, 'App\\Models\\User', 17),
(30, 'App\\Models\\User', 37),
(30, 'App\\Models\\User', 39);

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
(1, 2, 'One New User Created', 1, 'Active', 1, '2022-11-01 15:19:02', NULL, NULL),
(2, 2, 'One New User Created', 1, 'Active', 1, '2022-11-01 15:38:42', NULL, NULL),
(3, 2, 'One New User Created', 1, 'Inactive', 1, '2022-11-02 10:48:20', NULL, NULL),
(4, 2, 'One New User Created', 1, 'Active', 1, '2022-11-02 10:57:39', NULL, NULL),
(5, 2, 'One New User Created', 1, 'Active', 1, '2022-11-02 15:16:34', NULL, NULL),
(6, 2, 'One New User Created', 1, 'Active', 1, '2022-11-02 15:18:53', NULL, NULL),
(7, 2, 'One New User Created', 1, 'Active', 1, '2022-11-03 08:52:28', NULL, NULL),
(8, 6, 'One Agent Has Signed Up', 10, 'Active', 1, '2022-11-04 07:23:29', NULL, NULL),
(9, 6, 'One Agent Has Signed Up', 10, 'Active', 1, '2022-11-04 07:49:43', NULL, NULL),
(10, 6, 'One Agent Has Signed Up', 10, 'Active', 1, '2022-11-04 08:43:54', NULL, NULL),
(11, 6, 'One Agent Has Signed Up', 10, 'Active', 1, '2022-11-04 08:51:51', NULL, NULL),
(12, 7, 'An Agent Enquiry from haloowakodsaodi@gmail.com', 10, 'Active', 1, '2022-11-04 09:07:19', NULL, NULL),
(13, 2, 'One New User Created', 1, 'Active', 1, '2022-11-04 12:14:04', NULL, NULL),
(14, 5, 'One User Has Made An Enquiry', 10, 'Active', 1, '2022-11-04 12:25:25', NULL, NULL),
(15, 7, 'An Agent Enquiry from asdasdasd@gmail.com', 10, 'Active', 1, '2022-11-04 12:39:41', NULL, NULL),
(16, 7, 'An Agent Enquiry from jomarkaskdj@gmail.com', 10, 'Active', 1, '2022-11-04 12:44:17', NULL, NULL),
(17, 7, 'An Agent Enquiry from aasdasdasd@gmail.com', 10, 'Active', 1, '2022-11-06 12:30:12', NULL, NULL),
(18, 8, 'One Property Enquiry from zeeshan.mymail@gmail.com', 10, 'Active', 1, '2022-11-07 14:06:01', NULL, NULL),
(19, 8, 'One Property Enquiry from zeeshan.newemail@gmail.com', 10, 'Active', 1, '2022-11-07 14:07:58', NULL, NULL),
(20, 7, 'An Agent Enquiry from zeeshan.newemail@gmail.com', 10, 'Active', 1, '2022-11-07 14:11:45', NULL, NULL),
(21, 5, 'One User Has Made An Enquiry', 10, 'Active', 1, '2022-11-07 17:47:56', NULL, NULL),
(22, 6, 'One Agent Has Signed Up', 10, 'Active', 1, '2022-11-08 00:35:18', NULL, NULL),
(23, 8, 'One Property Enquiry from asdasd32@gmail.com', 10, 'Active', 1, '2022-11-09 15:15:34', NULL, NULL),
(24, 1, 'One Property has been listed By Admin', 1, 'Active', 1, '2022-11-12 12:53:11', NULL, NULL),
(25, 1, 'One Property has been listed By Admin', 1, 'Deleted', 1, '2022-11-14 11:38:51', NULL, NULL),
(26, 2, 'One New User Created', 1, 'Active', 1, '2022-11-15 17:47:43', NULL, NULL),
(27, 1, 'One Property has been listed By Admin', 1, 'Active', 1, '2022-11-16 12:20:08', NULL, NULL),
(28, 1, 'One Property has been listed By Admin', 45, 'Active', 1, '2022-12-07 10:00:16', NULL, NULL),
(29, 1, 'One Property has been listed By Admin', 45, 'Active', 1, '2022-12-07 14:46:06', NULL, NULL),
(30, 1, 'One Property has been listed By Admin', 45, 'Active', 1, '2022-12-07 15:34:01', NULL, NULL),
(31, 1, 'One Property has been listed By Admin', 45, 'Deleted', 1, '2022-12-07 15:40:51', NULL, NULL),
(32, 1, 'One Property has been listed By Admin', 45, 'Deleted', 1, '2022-12-19 17:48:40', NULL, NULL),
(33, 1, 'One Property has been listed By Admin', 45, 'Active', 1, '2022-12-19 18:09:32', NULL, NULL),
(34, 5, 'One User Has Made An Enquiry', 1, 'Active', 1, '2022-12-28 13:35:55', NULL, NULL),
(35, 8, 'One Property Enquiry from zeeshan.mymail@gmail.com', 10, 'Active', 1, '2022-12-28 16:52:00', NULL, NULL),
(36, 7, 'An Agent Enquiry from ewrwer@sasdda.com', 10, 'Active', 1, '2022-12-28 16:56:56', NULL, NULL),
(38, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 17:22:17', NULL, NULL),
(39, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:04:59', NULL, NULL),
(40, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:26:54', NULL, NULL),
(41, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:32:37', NULL, NULL),
(42, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:35:54', NULL, NULL),
(43, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:40:55', NULL, NULL),
(44, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:46:17', NULL, NULL),
(45, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:49:47', NULL, NULL),
(46, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:54:06', NULL, NULL),
(47, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 19:58:49', NULL, NULL),
(48, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:01:55', NULL, NULL),
(49, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:04:41', NULL, NULL),
(50, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:10:17', NULL, NULL),
(51, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:13:28', NULL, NULL),
(52, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:14:31', NULL, NULL),
(53, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:17:39', NULL, NULL),
(54, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:21:11', NULL, NULL),
(55, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:23:04', NULL, NULL),
(56, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:23:58', NULL, NULL),
(57, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:26:13', NULL, NULL),
(58, 1, 'One Property has been listed', 1, 'Active', 1, '2022-12-28 20:28:19', NULL, NULL),
(59, 9, 'A Property Is Modified', NULL, 'Active', 1, '2022-12-29 14:09:58', NULL, NULL),
(60, 9, 'A Property Is Modified', NULL, 'Active', 1, '2022-12-29 14:19:56', NULL, NULL),
(61, 9, 'A Property Is Modified', NULL, 'Active', 1, '2022-12-29 14:32:20', NULL, NULL),
(62, 10, 'Property Details Modified', NULL, 'Active', 1, '2022-12-29 14:32:20', NULL, NULL),
(63, 11, 'Agent Details A Broker is Modified', NULL, 'Active', 1, '2022-12-29 14:55:21', NULL, NULL),
(64, 12, 'Broker Details - Broker Association Is Modified', NULL, 'Active', 1, '2022-12-29 15:19:10', NULL, NULL),
(65, 10, 'Property Details Modified', NULL, 'Active', 1, '2022-12-30 13:30:29', NULL, NULL),
(66, 11, 'Agent Details A Broker is  ModifiedNewagent Newagent', NULL, 'Active', 1, '2022-12-30 21:17:23', NULL, NULL),
(67, 10, 'Property Details Modified For Property HeadlineGood', NULL, 'Active', 1, '2022-12-30 21:22:15', NULL, NULL),
(68, 9, 'A Property Status Is Modified For Property HeadlineGood', NULL, 'Active', 1, '2022-12-30 21:22:18', NULL, NULL),
(69, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-11 09:18:59', NULL, NULL),
(70, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-11 09:24:17', NULL, NULL),
(71, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-11 09:58:17', NULL, NULL),
(72, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-11 10:30:18', NULL, NULL),
(73, 10, 'Property Details Modified For Property Headlinewq', NULL, 'Active', 1, '2023-01-11 11:01:38', NULL, NULL),
(74, 10, 'Property Details Modified For Property Headlinewq', NULL, 'Active', 1, '2023-01-11 11:02:12', NULL, NULL),
(75, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-11 11:22:00', NULL, NULL),
(76, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-11 11:22:41', NULL, NULL),
(77, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-11 11:22:58', NULL, NULL),
(78, 9, 'A Property Status Is Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-11 11:23:01', NULL, NULL),
(79, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 09:04:07', NULL, NULL),
(80, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 09:04:46', NULL, NULL),
(81, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 09:05:23', NULL, NULL),
(82, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 09:55:46', NULL, NULL),
(83, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 11:05:23', NULL, NULL),
(84, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 11:05:56', NULL, NULL),
(85, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 11:07:40', NULL, NULL),
(86, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 11:51:56', NULL, NULL),
(87, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 12:06:52', NULL, NULL),
(88, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 12:14:22', NULL, NULL),
(89, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 12:14:55', NULL, NULL),
(90, 10, 'Property Details Modified For Property Headlinewqy55', NULL, 'Active', 1, '2023-01-13 12:22:08', NULL, NULL),
(91, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-13 14:12:09', NULL, NULL),
(92, 10, 'Property Details Modified For Property Headlineerter', NULL, 'Active', 1, '2023-01-13 14:12:37', NULL, NULL),
(93, 10, 'Property Details Modified For Property Headlineerter', NULL, 'Active', 1, '2023-01-13 18:57:30', NULL, NULL),
(94, 1, 'One Property has been listed', 45, 'Active', 1, '2023-01-16 13:43:46', NULL, NULL),
(95, 1, 'One Property has been listed', 45, 'Deleted', 1, '2023-01-31 10:22:40', NULL, NULL),
(96, 1, 'One Property has been listed', 1, 'Active', 1, '2023-02-22 09:00:07', NULL, NULL),
(97, 1, 'One Property has been listed', 17, 'Active', 1, '2023-02-24 12:25:00', NULL, NULL),
(98, 1, 'One Property has been listed', 17, 'Active', 1, '2023-02-24 12:38:12', NULL, NULL),
(99, 10, 'Property Details Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-02-24 12:41:15', NULL, NULL),
(100, 10, 'Property Details Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-02-24 12:41:59', NULL, NULL),
(101, 10, 'Property Details Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-02-24 12:43:24', NULL, NULL),
(102, 10, 'Property Details Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-02-24 12:54:03', NULL, NULL),
(103, 2, 'One New User Created', 1, 'Inactive', 1, '2023-03-07 00:13:36', NULL, NULL),
(104, 10, 'Property Details Modified For Property HeadlineProperty Sample B', NULL, 'Active', 1, '2023-03-21 22:52:18', NULL, NULL),
(105, 10, 'Property Details Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-28 09:02:09', NULL, NULL),
(106, 9, 'A Property Status Is Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-28 09:02:12', NULL, NULL),
(107, 10, 'Property Details Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-03-28 09:12:01', NULL, NULL),
(108, 9, 'A Property Status Is Modified For Property HeadlineIndividual2', NULL, 'Active', 1, '2023-03-28 09:12:04', NULL, NULL),
(113, 10, 'Property Details Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-29 14:40:18', NULL, NULL),
(114, 9, 'A Property Status Is Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-29 14:40:20', NULL, NULL),
(115, 10, 'Property Details Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-29 15:21:14', NULL, NULL),
(116, 9, 'A Property Status Is Modified For Property HeadlineIndividual Property', NULL, 'Active', 1, '2023-03-29 15:21:17', NULL, NULL),
(117, 10, 'Property Details Modified For Property HeadlineProperty Final1', NULL, 'Active', 1, '2023-03-30 09:57:11', NULL, NULL),
(118, 9, 'A Property Status Is Modified For Property HeadlineProperty Final1', NULL, 'Active', 1, '2023-03-30 09:57:13', NULL, NULL);

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
(5, 'Contact Us ', 'mdi-account-plus', 'Active', 1, '2022-07-19 13:04:28', NULL, NULL),
(6, 'Agent Sign Up ', 'mdi-account-plus', 'Active', 1, '2022-07-20 15:26:21', NULL, NULL),
(7, 'Agent Receives Enquiry', 'mdi-account-plus', 'Active', 1, '2022-07-20 15:54:09', NULL, NULL),
(8, 'Property Enquiry', 'mdi-account-plus', 'Active', 1, '2022-07-20 16:06:56', NULL, NULL),
(9, 'Property Status Is Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:06:13', NULL, NULL),
(10, 'Property Details Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:16:15', NULL, NULL),
(11, 'Agent Details - A Broker Is Modified', 'mdi-account-plus', 'Active', 1, '2022-12-29 14:56:36', NULL, NULL),
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
(83, 'ChangeStatusofAgent', 'api', '2023-03-18 07:02:29', NULL, 'User Form Level'),
(84, 'ChangeStatusofAdmin', 'api', '2023-03-18 07:02:29', NULL, 'User Form Level'),
(85, 'ChangeStatusofSuperuser', 'api', '2023-03-18 07:02:29', NULL, 'User Form Level'),
(86, 'ChangeStatusofOperator', 'api', '2023-03-18 07:04:24', NULL, 'User Form Level'),
(87, 'ChangeStatusofIndividual', 'api', '2023-03-18 07:05:42', NULL, 'User Form Level'),
(88, 'Property Tracking Report', 'api', '2023-03-28 08:22:53', NULL, 'Report Menu Level');

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
(263, 'App\\Models\\User', 48, '535401', 'f946d6a77b99c659c3f562aae03c22595814c215c094add9089177e03eb52e86', '[\"*\"]', '2022-08-08 07:51:33', '2022-08-08 07:51:24', '2022-08-08 07:51:33'),
(511, 'App\\Models\\User', 184, '631661', '81c69e492bff0c455ca2ebbb18ff26ab65b338332b71313ff2f22488295eb283', '[\"*\"]', NULL, '2022-10-06 07:32:43', '2022-10-06 07:32:43'),
(515, 'App\\Models\\User', 184, '884785', '6c5f4707d91d8d012b6684b9aeda5ad8574a99631a4eceeb533d73527eae62a8', '[\"*\"]', '2022-10-06 07:37:42', '2022-10-06 07:36:22', '2022-10-06 07:37:42'),
(516, 'App\\Models\\User', 184, '559603', 'c3d17b30a87943b29254671100000801927461e6cd1549563ef80c4aa821c809', '[\"*\"]', NULL, '2022-10-06 07:41:48', '2022-10-06 07:41:48'),
(766, 'App\\Models\\User', 79, '448416', 'bb42f0afa8382232c2f58495a3b1c34d2759c57c8c5c9e7de89d5ee4855b051c', '[\"*\"]', NULL, '2022-11-01 02:04:49', '2022-11-01 02:04:49'),
(767, 'App\\Models\\User', 79, '354021', '8cae30bbfd78c53d55ddcfa86452c0fd1a1109814e147823a2548c432490478f', '[\"*\"]', NULL, '2022-11-01 02:07:38', '2022-11-01 02:07:38'),
(769, 'App\\Models\\User', 78, '102172', '5fb5490e174f7bda864aba1aa65edc860f218bc2ea95f1233c81776ee44fc177', '[\"*\"]', '2022-11-01 03:49:15', '2022-11-01 03:49:13', '2022-11-01 03:49:15'),
(863, 'App\\Models\\User', 39, '545605', 'c61c66e0a9fe2f5c2ee353a7fee8b340b02068ef3f9f7c094c9ae3264ea6013c', '[\"*\"]', '2022-11-13 10:44:16', '2022-11-12 09:59:21', '2022-11-13 10:44:16'),
(1087, 'App\\Models\\User', 1, '542176', 'fd98f1ddc2a8ac04236a4d28868a8578b236b0cc0f8a47c6e250a421fd098d22', '[\"*\"]', '2023-03-29 05:33:03', '2023-03-29 04:27:35', '2023-03-29 05:33:03'),
(1088, 'App\\Models\\User', 1, '301731', 'a2d5eef52e4728a4314cbadfac09f1b6e3b00d64786559c9827d1668a835f053', '[\"*\"]', '2023-03-29 07:25:36', '2023-03-29 07:09:03', '2023-03-29 07:25:36'),
(1089, 'App\\Models\\User', 1, '347772', '06b010cf302f04f8cf37990bcade0e2292d4f881be909e03a79f75232c1b4194', '[\"*\"]', '2023-03-29 23:10:17', '2023-03-29 08:22:03', '2023-03-29 23:10:17');

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
(1, 'For Rent', 'Active', 1, '2022-04-27 16:39:54', '2022-04-27 11:10:53', NULL, 1),
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
  `property_headline` varchar(255) NOT NULL,
  `property_description` longtext NOT NULL,
  `property_classification_id` int(11) NOT NULL,
  `property_type_id` int(11) NOT NULL,
  `product_category_id` int(11) NOT NULL,
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
(1, 1, 'Agency', 'None', 21, 1, 1, 1, NULL, NULL, 35000, '2000', '778 Country St. Panama City, FL\n', 'Jannat Graynight Mood In Siver Colony, London', 'Open', 'Banyon Tree Realty', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '11', '11', 'St. Panama City, FL', 'Jannat Graynight Mood In Siver Colony, London', 1, 2, 20, 3, '11122', 'Second', '1', '2', '11', '11', 'banyon-tree-realty', 'Yes', 'yes', 'non', 'yes', '2001', 'Yes', 'Yes', 'Yes', 1, 2, 8990, '2022-09-02', 'Week', 'Day', '2', 'Yes', '2022-09-09', '2022-09-09', '2022-08-09', 7853, '2022-08-09', '200', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, '', NULL, NULL, NULL, NULL),
(3, 1, 'Agency', 'None', 21, 1, 1, 1, NULL, NULL, 95000, '2000', '778 Country St. Panama City, FL\n', 'Cecelia Havens ', 'Open', 'Marriot Hotel', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '11', '11', 'St. Panama City, FL', 'Jannat Graynight Mood In Siver Colony, London', 2, 2, 20, 3, '23123', 'Second', '2', '3', '4523234', '32432423', 'marriot-hotel', 'Yes', 'yes', 'Forced Air', 'no', '1998', 'Yes', 'Yes', 'Yes', 1, 2, 8990, '2022-09-03', 'Week', 'Day', '2', 'Yes', '2022-09-09', '2022-09-09', '2022-08-09', 7853, '2022-08-09', '200', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, '', NULL, NULL, NULL, NULL),
(4, 1, 'Agency', 'None', 21, 1, 1, 1, NULL, NULL, 40000, '1000', 'Blue Reef Properties London United Kingdom', 'Blue Reef Properties', 'Open', 'Blue Reef Properties', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '23', '23', 'Zurik C London', 'Marriout House', 2, 2, 20, 3, '23222', 'Second', '3', '2', '234234', '32423423', 'blue-reef-properties', 'Yes', 'Yes', 'Forced Air', 'Yes', '1987', 'Yes', 'Yes', 'Yes', 0, 2, 8990, '2022-09-04', 'Week', 'Day', '2', 'Yes', '2022-09-09', '2022-09-09', '2022-08-09', 7853, '2022-08-09', '200', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, '', NULL, NULL, NULL, NULL),
(6, 1, 'Agency', 'None', 21, 1, 1, 1, NULL, NULL, 61000, '3600', 'Beacon Homes LLC UK', 'Beacon Homes LLC ', 'Open', 'Beacon Homes LLC ', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n\nSed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '45', '26', 'Blueball Street London', 'Beacon Homes LLC', 2, 2, 20, 3, '43345', 'Second', '5', '5', '5464564', '345345', 'beacon-homes-llc', 'Yes', 'Yes', 'Yes', 'Yes', '2001', 'No', 'Yes', 'Yes', 1, 2, 8990, '2022-09-05', 'Week', 'Day', '2', 'Yes', '2022-09-09', '2022-09-09', '2022-08-09', 7853, '2022-08-09', '200', '1', '1', 'Renovated', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, '', NULL, NULL, NULL, NULL),
(75, 5, 'Personal', 'None', 21, 1, 1, 1, NULL, NULL, 111, '111', 'Somewhere', 'PPPP', 'Open', 'sdsdsd', 'sdds', 4, 2, 3, 'dd', 'ds', 'dsd', 'dsd', 2, 5, 20, 3, '1111', 'Basement', '1', '2', '111', '11', 'sdsdsd', 'Yes', 'Central AC', 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Modern Kitchen', 0, 2, 111, '0000-00-00', 'Day', 'Day', '8', 'Yes', '2022-09-09', '2022-09-09', '2022-08-09', 111, '2022-08-09', '111', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, '2022-09-16 05:56:22', NULL, NULL, NULL, NULL),
(78, 1, 'Personal', 'None', 21, 1, 1, 1, NULL, NULL, 25000, '1000', '500 North Avenue', 'Kolkata Home', 'Open', 'Kolkata Home', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n \n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '56', '67', 'Park Avenue', 'Buffalo Homes LLC', 2, 2, 20, 3, '123124', 'Second', '4', '3', '32424.54', '76867.65', 'kolkata-home', 'Yes', 'Yes', 'No', 'Yes', '2007', 'Yes', 'No', 'Yes', 0, 2, 8990, '2022-09-07', 'Week', 'Day', '2', 'Yes', '2022-05-02', '2022-06-02', '2022-06-02', 7853, '2022-10-02', '200', '1', '1', 'Renovated', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 1, 'Personal', 'None', 21, 1, 1, 1, NULL, NULL, 25000, '1000', '500 North Avenue', 'Digha', 'Open', 'darjeeling', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.\n \n Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 4, 2, 3, '56', '67', 'Park Avenue', 'Buffalo Homes LLC', 2, 2, 20, 3, '123124', 'Second', '4', '3', '32424.54', '76867.65', 'darjeeling', 'Yes', 'Yes', 'No', 'Yes', '2007', 'Yes', 'No', 'Yes', 0, 2, 8990, '2022-09-08', 'Week', 'Day', '2', 'Yes', '2022-05-02', '2022-06-02', '2022-06-02', 7853, '2022-10-02', '200', '1', '1', 'Renovated', 'Month', 'Yes', 'Yes', NULL, '2021-12-13 17:08:46', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 1, 'Personal', 'None', 21, 1, 1, 3, NULL, NULL, 30000, '100', '1500', 'TestPropSup', 'Open', 'Boat House', 'Lovely Boat house', 4, 2, 1, '66D', '1045', 'Armano street', 'SUP HOUSE', 2, 2, 20, 3, '7001', 'Second', '1', '2', '40.125', '43.0125', 'boat-house', 'Yes', 'Central AC', 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Finish Brick', 1, NULL, 888, NULL, '88', '8', '17', 'Yes', '2022-12-15', '2022-10-13', '2022-10-14', 30000, '2022-10-13', '30', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2022-10-13 16:44:57', '1', NULL, '2022-11-15 06:14:04', NULL, NULL, NULL, NULL),
(92, 5, 'Personal', 'None', 21, 1, 1, 1, NULL, NULL, 80000, '5000', '6000', 'jpmKitee', 'Open', 'jpmKitee', 'jpmKitee', 4, 2, 3, '11', '11', 'jpmKitee', 'jpmKitee', 2, 2, 20, 3, '54156', 'Basement', '1', '2', '546.545', '684864.54', 'jpmkitee', 'Yes', 'Central AC', 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Modern Kitchen', 1, NULL, NULL, '2022-09-08', NULL, NULL, NULL, NULL, '2022-10-13', '2022-10-13', '2022-10-13', 56226, '2022-10-13', '6565', '1', '1', 'Renovated', 'Month', 'Yes', 'Yes', NULL, '2022-10-13 17:00:38', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 5, 'Personal', 'Basic Furnishing', 21, 1, 1, 38, NULL, NULL, 5600, '5600', '1000', 'Property Sample', 'Suspended', 'Property Sample', 'Property Sample', 4, 2, 3, '11', '11', 'jhgjhghj', 'ffhhggh', 2, 2, 20, 3, '7878', 'top', '1', '2', '677677.88', '7777.88', 'property-sample', 'Yes', NULL, NULL, 'Yes', '2022', 'Yes', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-12', '2022-11-12', '2022-11-12', 7787, '2022-11-12', '5656', '1', '1', 'Newly Built', 'Month', 'Yes', 'Yes', NULL, '2022-11-12 12:53:11', '1', NULL, '2022-11-12 11:54:36', NULL, NULL, NULL, NULL),
(94, 5, 'Agency', 'Fully Furnished', 21, 1, 1, 1, NULL, NULL, 4353, '3455', '435', 'Property Sample B', 'Sold', 'Property Sample B', 'Property Sample B', 4, 4, 3, '44', '44', 'fsds', 'dsfsdfs', 3, 1, 6, 2, '5345', 'dasdasd', '4', '3', '453453.45', '43534.54', 'property-sample-b', 'Yes', 'No', 'No', 'Yes', '2023', 'Yes', 'No', 'No', 1, NULL, NULL, '2023-03-21', '6', '12', NULL, NULL, '2022-11-14', '2022-11-14', '2022-11-14', 4353, '2022-11-14', '0.79370549046635', '2', '2', 'Renovated', 'Month', 'Yes', 'Yes', '2022-12-22', '2022-11-14 11:38:51', '1', NULL, '2023-03-21 17:22:18', '2222', '333333', '44444', '11111'),
(95, 5, 'Agency', 'Fully Furnished', 21, 1, 1, 38, NULL, NULL, 7744, '55', '55', 'Property Smaple C', 'Open', 'Property Smaple C', 'Property Smaple C', 3, 4, 1, '55', '55', 'dfgdfgd', 'dfgdfgd', 3, 1, 6, 2, '5566', 'good', '4', '3', '7676.77', '887.8', 'property-smaple-c1668581651', 'Yes', 'Central AC', 'Forced Air', 'No', '2022', 'No', 'Finish Brick', 'Modern Kitchen', 1, 3, 88990, NULL, '6', '12', '5', 'Yes', '2022-11-16', '2022-11-16', '2022-11-16', NULL, '2022-11-16', NULL, '1', '1', NULL, 'Month', 'No', 'No', NULL, '2022-11-16 12:20:08', '1', NULL, '2022-12-30 08:00:29', NULL, NULL, NULL, NULL),
(96, 1, 'Agency', NULL, 21, 26, 45, 45, NULL, NULL, 5555, '555', '555', 'jkjkj', 'Open', 'kjj', ': an act of describing\nspecifically : discourse intended to give a mental image of something experienced\nbeautiful beyond description\ngave an accurate description of what he saw', 1, 1, 1, '5', '5', 'jkkj', 'kjkj', 3, 1, 6, 2, '5558', 'kkkk', NULL, NULL, '8998', '7878', 'kjj1670396198', 'Yes', NULL, 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Modern Kitchen', 0, 45, 888, NULL, '6', '12', '5', 'No', '2022-12-07', '2022-12-07', '2022-12-07', NULL, '2022-12-07', NULL, NULL, NULL, NULL, 'Month', 'Yes', 'Yes', NULL, '2022-12-07 10:00:16', '45', NULL, '2022-12-07 07:17:16', NULL, NULL, NULL, NULL),
(97, 5, 'Agency', NULL, 21, 26, 45, 45, NULL, NULL, 666, '444', '44', 'dgdfgdfgdfgdfgd', 'Open', 'dfgdfgdfgdgdg', 'dfgdfgdfgdgdgdg', 3, 1, 1, '44', '44', 'dfgdfgdfg', 'fgdgfdfg', 3, 1, 6, 2, '4554', 'fdgdfg', NULL, NULL, NULL, NULL, 'dfgdfgdfgdgdg1670404566', 'No', NULL, 'Forced Air', 'No', '2022', 'Yes', NULL, NULL, 1, 2, 45345, NULL, '6', '12', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Month', 'Yes', 'No', NULL, '2022-12-07 14:46:06', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 5, 'Agency', 'Fully Furnished', 21, 26, 45, 44, NULL, NULL, 5555, '898', '4455', 'hjhjhj', 'Open', 'hgfhgfgh', 'jfjhfhfghfhg', 3, 4, 1, '55', '55', 'hfhgghf', 'jhfghfhgfh', 3, 1, 6, 2, '5454', 'hfghghfgh', '3', '2', NULL, NULL, 'hgfhgfgh1670407441', 'No', NULL, NULL, 'No', '2022', 'No', NULL, NULL, 0, 2, 55, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4', '3', NULL, 'Month', 'No', 'No', NULL, '2022-12-07 15:34:01', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 5, 'Agency', 'Fully Furnished', 21, 26, 45, 45, NULL, NULL, 56566, '898965', '656565', 'jhghjgjhggjh', 'Open', 'jhghggjhgjhghghjhgg', 'gjhjgjhhggjgghgghj', 3, 2, 1, '555', '5656', 'gghhgfgh', 'jghjhjghjg', 3, 1, 6, 2, '5556', 'gghfhgf', '2', '4', '867', '878', 'jhghggjhgjhghghjhgg1670407851', 'No', 'Central AC', 'Forced Air', 'No', '2022', 'No', 'Finish Brick', 'Modern Kitchen', 0, 2, 656, NULL, '6', '12', '5', 'Yes', NULL, NULL, NULL, NULL, NULL, NULL, '5', '4', NULL, 'Month', 'No', 'No', NULL, '2022-12-07 15:40:51', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 5, 'Agency', 'Semi Furnished', 20, 1, 1, 45, NULL, NULL, 463463, '463434', '44', 'Good', 'Pending', 'Good', 'Good', 1, 2, 1, '4', '6', 'Good', 'Good', 3, 1, 6, 2, '8897', 'sdddf', '4', '5', NULL, NULL, 'sdfsdf1671452320', 'Yes', 'Central AC', 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Modern Kitchen', 0, NULL, 45454, NULL, '6', '12', '7', 'Yes', '2023-02-09', '2023-01-06', '2023-02-10', NULL, NULL, NULL, '5', '3', NULL, 'Month', 'Yes', 'Yes', NULL, '2022-12-19 17:48:40', '45', NULL, '2022-12-30 15:52:15', NULL, NULL, NULL, NULL),
(101, 8, 'Agency', 'Semi Furnished', 20, 1, 1, 45, NULL, NULL, 567567, '65868658', '777', 'yryrtyrty', 'Pending', 'rtrt', 'rtyrty', 1, 2, 3, '55', '55', 'rtyrtyrty', 'rtyrtyrty', 3, 1, 6, 2, '8897', 'yrtyrtyrt', '1', '1', NULL, NULL, 'rtrt1671453572', 'Yes', 'Central AC', 'Forced Air', 'Yes', '2022', 'Yes', 'Finish Brick', 'Modern Kitchen', 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 656565, NULL, '666', '2', '3', NULL, 'Month', 'Yes', 'Yes', NULL, '2022-12-19 18:09:32', '45', NULL, '2022-12-29 09:02:20', NULL, NULL, NULL, NULL),
(124, 5, 'Agency', 'None', 20, 26, 45, 45, 44, 45, 523253, NULL, NULL, 'iuou', 'Open', 'uio', 'uioui', 4, 2, 3, '7', '8', 'yi', NULL, 3, 1, 6, 2, '8897', 'yui', '0', '0', NULL, NULL, 'uio1673408939', 'No', NULL, NULL, 'No', '2023', 'No', NULL, NULL, 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 7686, NULL, '78', '0', '0', NULL, 'Month', 'No', 'No', NULL, '2023-01-11 09:18:59', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(125, 1, 'Agency', NULL, 20, 26, 45, 45, 45, 45, 523253, NULL, NULL, 'sf', 'Open', 'sdf', 'sdf', 1, 2, 3, NULL, NULL, 'fds', NULL, 3, 1, 6, 2, '8897', 'sdf', '0', '0', NULL, NULL, 'sdf1673409257', 'No', NULL, NULL, 'No', '2023', 'No', NULL, NULL, 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 754456, NULL, '56', NULL, NULL, NULL, 'Month', 'No', 'No', NULL, '2023-01-11 09:24:17', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(126, 5, 'Agency', NULL, 20, 26, 45, 45, 44, 45, 523253, NULL, NULL, 'ty', 'Open', 'try', 'rty', 1, 4, 3, NULL, NULL, 'rty', NULL, 3, 1, 6, 2, '8897', NULL, '0', '0', NULL, NULL, 'try1673411297', 'No', NULL, NULL, 'No', '2023', 'No', NULL, NULL, 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 46464, NULL, '45', NULL, NULL, NULL, 'Month', 'No', 'No', NULL, '2023-01-11 09:58:17', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 7, 'Agency', 'Fully Furnished', 20, 26, 45, 45, 45, 44, 5000000, '5333.55', '454.45', 'ewwey55', 'Sold', 'wqy55', 'wwqy55', 1, 4, 3, '44', '44', 'weqew', NULL, 3, 1, 6, 2, '8897', NULL, '0', '0', NULL, NULL, 'wq1673413218', 'Yes', NULL, NULL, 'Yes', '2023', 'Yes', NULL, NULL, 0, NULL, NULL, '2023-01-13', '6', '12', NULL, NULL, NULL, NULL, NULL, 5000000, '2023-01-08', '0.00106671', '0', '0', NULL, 'Month', 'Yes', 'No', NULL, '2023-01-11 10:30:18', '45', NULL, '2023-01-13 06:52:08', NULL, NULL, NULL, NULL),
(128, 5, 'Agency', 'None', 20, 26, 45, 45, 44, 45, 54345, '454555544', '45', 'der', 'Open', 'erter', 'erter', 1, 2, 3, '44', '44', 'ert', 'ert', 3, 1, 6, 2, '8897', 'tetr', '0', '0', '121.06921505865044', '13.759841721437398', 'erter1673599329', '0', NULL, NULL, '0', '2023', '0', NULL, NULL, 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 54345, NULL, '8364.2569509614', '0', '0', NULL, 'Month', '0', '0', NULL, '2023-01-13 14:12:09', '45', NULL, '2023-01-13 13:27:30', NULL, NULL, NULL, NULL),
(130, 7, 'Agency', NULL, 23, 26, 45, 45, 45, 44, 3523, '244535', '3534', 'new props', 'Open', 'new props', 'new props', 3, 5, 3, NULL, NULL, 'This is the Street Address', 'Property Special', 3, 1, 6, 2, '3425', 'Grand Floor', '5', '2', '121.06921505865044', '13.759841721437398', 'new-props1675140760', '0', NULL, NULL, '0', '2023', '0', NULL, NULL, 0, 5, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69.411013340903', '3', NULL, NULL, 'Month', '0', '0', NULL, '2023-01-31 10:22:40', '45', NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, 'Personal', 'None', 20, 1, 1, 1, 1, 1, 2445, '44442', '4223', 'rtyrtyrt', 'Open', 'yrtyrwtrt', 'ertstwer', 1, 2, 3, NULL, NULL, 'werwetwytw', NULL, 1, 3, 3, NULL, '2414', 'wrwer', '5', '2', '87.06053528346908', '23.230759201839252', 'yrtyrwtrt1677036607', '0', 'Central AC', 'Forced Air', '0', '2023', '0', 'Finish Brick', 'Modern Kitchen', 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '18.176687116564', '4', '0', NULL, 'Month', '0', '0', NULL, '2023-02-22 09:00:07', '1', NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, 'Personal', 'Semi Furnished', 21, 4, 40, 40, NULL, NULL, 12000000, '4000', NULL, 'Individual Property', 'Suspended', 'Individual Property', 'Individual Property', 4, 2, 3, NULL, NULL, 'Individual Property Address', NULL, 5, 2, 8, 4, '2363', 'Ground', '2', '4', NULL, NULL, 'individual-property1677221700', '0', 'No', 'No', '0', '2023', '0', 'No', 'No', 0, NULL, NULL, NULL, '6', '12', NULL, NULL, NULL, NULL, NULL, 12000000, NULL, '0.00033333333333333', '3', '3', NULL, 'Month', '0', '0', NULL, '2023-02-24 12:25:00', '17', NULL, '2023-03-29 09:51:14', NULL, NULL, NULL, NULL);

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
(1, 1, 'Active', 1, NULL, 1),
(1, 2, 'Active', 1, NULL, 2),
(1, 3, 'Active', NULL, NULL, 3),
(1, 4, 'Active', NULL, NULL, 4),
(1, 5, 'Active', NULL, NULL, 5),
(1, 6, 'Active', NULL, NULL, 6),
(1, 7, 'Active', NULL, NULL, 7),
(1, 8, 'Active', NULL, NULL, 8),
(1, 9, 'Active', NULL, NULL, 9),
(1, 10, 'Active', NULL, NULL, 10),
(1, 11, 'Active', NULL, NULL, 11),
(1, 12, 'Active', NULL, NULL, 12),
(4, 2, 'Active', NULL, NULL, 14),
(4, 3, 'Active', NULL, NULL, 15),
(4, 4, 'Active', NULL, NULL, 16),
(4, 5, 'Active', NULL, NULL, 17),
(4, 6, 'Active', NULL, NULL, 18),
(3, 4, 'Active', NULL, NULL, 28),
(50, 1, 'Active', NULL, NULL, 53),
(50, 7, 'Active', NULL, NULL, 54),
(50, 11, 'Active', NULL, NULL, 55),
(46, 2, 'Active', NULL, NULL, 77),
(46, 6, 'Active', NULL, NULL, 78),
(46, 8, 'Active', NULL, NULL, 79),
(47, 5, 'Active', NULL, NULL, 80),
(59, 9, 'Active', NULL, NULL, 82),
(1, 18, 'Active', 1, '2022-08-09 17:27:06', 86),
(6, 10, 'Active', 78, '2022-09-13 18:41:47', 92),
(6, 1, 'Active', 78, '2022-09-13 18:41:47', 93),
(84, 1, 'Active', 119, '2022-09-14 09:49:17', 94),
(84, 2, 'Active', 119, '2022-09-14 09:49:17', 95),
(75, 1, 'Active', 119, '2022-09-14 09:58:37', 96),
(75, 2, 'Active', 119, '2022-09-14 09:58:37', 97),
(90, 1, 'Active', 78, '2022-10-11 22:26:44', 98),
(90, 2, 'Active', 78, '2022-10-11 22:26:44', 99),
(90, 3, 'Active', 78, '2022-10-11 22:26:44', 100),
(90, 4, 'Active', 78, '2022-10-11 22:26:44', 101),
(90, 5, 'Active', 78, '2022-10-11 22:26:44', 102),
(90, 6, 'Active', 78, '2022-10-11 22:26:44', 103),
(91, 1, 'Active', 186, '2022-10-13 11:22:31', 104),
(91, 2, 'Active', 186, '2022-10-13 11:22:31', 105),
(92, 1, 'Active', 79, '2022-11-01 10:37:40', 112),
(92, 2, 'Active', 79, '2022-11-01 10:37:40', 113),
(92, 3, 'Active', 79, '2022-11-01 10:37:40', 114),
(92, 4, 'Active', 79, '2022-11-01 10:37:40', 115),
(92, 5, 'Active', 79, '2022-11-01 10:37:40', 116),
(92, 6, 'Active', 79, '2022-11-01 10:37:40', 117),
(92, 7, 'Active', 79, '2022-11-01 10:37:40', 118),
(92, 8, 'Active', 79, '2022-11-01 10:37:40', 119),
(92, 9, 'Active', 79, '2022-11-01 10:37:40', 120),
(92, 10, 'Active', 79, '2022-11-01 10:37:40', 121),
(92, 11, 'Active', 79, '2022-11-01 10:37:40', 122),
(96, 1, 'Active', 1, '2022-12-07 12:20:30', 135),
(96, 2, 'Active', 1, '2022-12-07 12:20:30', 136),
(96, 3, 'Active', 1, '2022-12-07 12:20:30', 137),
(96, 4, 'Active', 1, '2022-12-07 12:20:30', 138),
(96, 5, 'Active', 1, '2022-12-07 12:20:30', 139),
(96, 6, 'Active', 1, '2022-12-07 12:20:30', 140),
(95, 1, 'Active', 1, '2022-12-30 13:29:18', 141),
(95, 2, 'Active', 1, '2022-12-30 13:29:18', 142),
(95, 3, 'Active', 1, '2022-12-30 13:29:18', 143),
(95, 4, 'Active', 1, '2022-12-30 13:29:18', 144),
(95, 5, 'Active', 1, '2022-12-30 13:29:18', 145),
(95, 9, 'Active', 1, '2022-12-30 13:29:18', 146),
(131, 1, 'Active', 1, '2023-03-28 09:22:35', 147),
(131, 2, 'Active', 1, '2023-03-28 09:22:35', 148),
(131, 4, 'Active', 1, '2023-03-28 09:22:35', 149),
(131, 5, 'Active', 1, '2023-03-28 09:22:35', 150);

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
(3, 'Agricultural', 'Active', 1, '2022-04-27 08:56:56', '2022-11-09 10:53:39', NULL),
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
(1, 6, 'https://www.youtube.com/watch?v=Tgkt7ursa6o', 'Video', NULL, NULL, 0, 'test decsription', NULL, NULL),
(2, 1, 'p-1.jpg', 'Image', NULL, NULL, 1, 'Test Description', NULL, NULL),
(4, 3, 'p-2.jpg', 'Image', NULL, NULL, 1, 'Test Description', NULL, NULL),
(5, 1, 'p-2.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(6, 1, 'p-3.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(7, 3, 'p-4.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(8, 3, 'p-6.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(9, 4, 'p-9.jpg', 'Image', NULL, NULL, 1, 'Test Description', NULL, NULL),
(10, 4, 'p-7.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(14, 3, 'https://www.youtube.com/watch?v=Tgkt7ursa6o', 'Video', NULL, NULL, 0, 'Test Description', NULL, NULL),
(17, 6, 'p-3.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(18, 6, 'p-7.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(19, 6, 'p-9.jpg', 'Image', NULL, NULL, 0, 'Test Description', NULL, NULL),
(20, 6, 'p-6.jpg', 'Image', NULL, NULL, 1, 'Test Description', NULL, NULL),
(77, 4, '29361653906176.jpg', 'Image', NULL, NULL, 0, 'Test Desc', NULL, NULL),
(78, 4, 'https://youtu.be/X1SJ8WLJPT8', 'Video', NULL, NULL, 0, 'Test Video', NULL, NULL),
(88, 75, 'default.jpg', 'Image', NULL, NULL, 0, NULL, '12', NULL),
(89, 75, '35871660038155.jpg', 'Image', NULL, NULL, 1, 'Test', '12', NULL),
(90, 78, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '12', NULL),
(93, 81, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '12', NULL),
(94, 82, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '12', NULL),
(95, 83, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '12', NULL),
(96, 84, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '12', NULL),
(97, 85, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '78', NULL),
(98, 86, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '78', NULL),
(99, 87, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '78', NULL),
(100, 88, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '78', NULL),
(105, 90, 'default.jpg', 'Image', NULL, NULL, 0, NULL, '78', NULL),
(106, 90, '48321665507450.jpg', 'Image', NULL, '2022-10-11 16:57:30', 1, 'good', '78', NULL),
(107, 90, 'https://www.youtube.com/watch?v=x7Sh-7m46Rk', 'Video', NULL, NULL, 0, 'video', '78', NULL),
(109, 91, '26531665640330.jpg', 'Image', NULL, '2022-10-13 05:52:10', 1, 'SUP HOUSE', '186', NULL),
(110, 92, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '78', NULL),
(112, 92, '56531665672067.jpg', 'Image', NULL, '2022-10-13 14:41:07', 0, 'anotherone', '78', NULL),
(113, 92, '15791667279384.jpg', 'Image', NULL, '2022-11-01 05:09:44', 0, 'good', '79', NULL),
(114, 93, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(115, 94, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(116, 95, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(117, 96, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(118, 97, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(119, 98, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(120, 99, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(121, 100, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(122, 101, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(123, 103, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(124, 104, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(125, 105, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(126, 106, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(127, 107, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(128, 108, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(129, 109, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(130, 110, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(131, 111, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(132, 112, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(133, 113, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(134, 114, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(135, 115, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(136, 116, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(137, 117, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(138, 118, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(139, 119, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(140, 120, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(141, 121, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(142, 122, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(143, 123, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(144, 124, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(145, 125, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(146, 126, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(147, 127, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(148, 128, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(150, 130, 'default.jpg', 'Image', NULL, NULL, 0, NULL, '45', NULL),
(151, 130, '48321665507450.jpg', 'Image', NULL, NULL, 1, NULL, '45', NULL),
(152, 131, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '1', NULL),
(153, 132, 'default.jpg', 'Image', NULL, NULL, 1, NULL, '17', NULL);

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
(2, 1, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 75, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 78, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 84, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 91, '2022-11-12', '2022-11-15', '2022-11-15', NULL, '', '', 'Super Admin', NULL, ''),
(10, 92, '2022-11-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 93, '2022-11-12', '2022-11-12', '2022-11-12', '2022-11-12', 'fgrt65h7yj8uki', '', 'Super Admin', NULL, ''),
(12, 94, '2022-11-14', '2023-03-21', '2023-03-21', NULL, '', '', 'Super Admin', NULL, ''),
(13, 95, '2022-11-16', '2022-12-30', '2022-12-30', NULL, '', '', 'Super Admin', NULL, ''),
(14, 96, '2022-12-07', '2022-12-07', '2022-12-07', NULL, '', '', 'Agent', NULL, ''),
(15, 97, '2022-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 98, '2022-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 99, '2022-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 100, '2022-12-19', '2022-12-30', '2022-12-30', NULL, '', '', 'Super Admin', NULL, ''),
(19, 101, '2022-12-19', '2022-12-29', '2022-12-29', NULL, '', '', 'Super Admin', NULL, ''),
(41, 124, '2023-01-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 125, '2023-01-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 126, '2023-01-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 127, '2023-01-11', '2023-01-13', '2023-01-13', NULL, '', '', 'Agent', NULL, ''),
(45, 128, '2023-01-13', '2023-01-13', '2023-01-13', NULL, '', '', 'Agent', NULL, ''),
(47, 130, '2023-01-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 131, '2023-02-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 132, '2023-02-24', '2023-03-29', '2023-03-29', '2023-03-29', '', '40', 'Operator', '2023-03-29', 'Opekor Kanor');

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
(4, 'Apartment', 'Active', 'Yes', 1, '2022-06-01 10:34:58', '2022-08-10 06:55:33', 1),
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
(1, 'West Bengal', 'Active', 1, '2023-01-30 14:21:05', NULL, NULL),
(2, 'Bihar', 'Active', 1, '2023-01-30 15:42:21', NULL, NULL),
(3, 'Jharkhand', 'Active', 1, '2023-01-30 16:56:02', NULL, NULL),
(4, 'Uttar Pradesh', 'Active', 1, '2023-01-31 21:01:49', NULL, NULL);

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
(2, 26),
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
(8, 3),
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
(30, 26),
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
(44, 26),
(45, 1),
(45, 3),
(45, 4),
(45, 26),
(46, 1),
(46, 3),
(46, 4),
(46, 26),
(47, 1),
(47, 3),
(47, 4),
(47, 26),
(48, 1),
(48, 3),
(48, 4),
(48, 26),
(49, 1),
(49, 3),
(49, 4),
(49, 26),
(50, 1),
(50, 3),
(50, 4),
(50, 26),
(52, 1),
(52, 3),
(52, 4),
(52, 26),
(53, 1),
(53, 3),
(53, 4),
(53, 26),
(54, 1),
(54, 3),
(54, 4),
(54, 26),
(55, 1),
(55, 3),
(55, 4),
(55, 26),
(56, 1),
(56, 3),
(56, 4),
(56, 26),
(56, 30),
(57, 1),
(57, 3),
(57, 4),
(57, 26),
(58, 1),
(58, 3),
(58, 4),
(58, 26),
(59, 1),
(59, 3),
(59, 4),
(59, 26),
(61, 1),
(61, 3),
(61, 4),
(61, 26),
(61, 30),
(62, 1),
(62, 3),
(62, 26),
(63, 1),
(63, 3),
(63, 4),
(63, 26),
(63, 30),
(64, 1),
(64, 3),
(65, 1),
(65, 3),
(65, 4),
(65, 26),
(65, 30),
(66, 1),
(66, 3),
(66, 4),
(66, 26),
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
(70, 4),
(70, 26),
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
(75, 3),
(75, 26),
(82, 1),
(82, 3),
(82, 26),
(83, 1),
(83, 3),
(84, 1),
(84, 3),
(85, 1),
(86, 1),
(86, 3),
(87, 1),
(87, 3),
(88, 1),
(88, 3);

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

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `seller_name`, `email_address`, `phone_1`, `phone_2`, `property_owner_name`, `created_at`, `notes_about_seller`, `unit_number`, `house_no`, `street_name`, `subdivision_id`, `barangay_id`, `town_id`, `province_id`, `zipcode`, `associated_agency_id`) VALUES
(1, 'Seller12', 'seller152@gmail.com', '1234567890', '567890', 'Test Seller', NULL, 'good', '11', '11', 'street1', 1, 2, 2, 8, NULL, 61),
(5, 'Ako ay Seller', 'akoayseller@shurua.xyz', '0987654321', '1234567890', 'Seller 123', NULL, 'Mabait ako', '1212', '1212', '212 Street', 1, 3, 2, 8, '401111', 61),
(7, 'Seller141', 'seller141@gmail.com', '1234567890', '567890', 'Test Seller', NULL, 'good', '11', '11', 'street1', 1, 2, 2, 8, '713111', 61),
(8, 'Seller181', 'seller181@gmail.com', '1234567890', '567890', 'Test Seller', NULL, 'good', '11', '11', 'street1', 1, 2, 2, 8, '713111', 61),
(9, 'dfgdf', 'dfgdg@dads.com', '4353463345', '4353453664', 'dfgdfg', NULL, 'fsfwewewe', '44', '44', 'dgdfdfgd', 20, 19, 3, 3, '4534', 61);

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
  `zip_code` varchar(6) NOT NULL,
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
(1, 7, 5, 2, 'Buxar1', '3523', NULL, 'Active', 1, '2023-02-11 22:50:12', NULL, NULL),
(2, 8, 5, 2, 'Buxar2', '2363', '1', 'Active', 1, '2023-02-11 22:52:24', NULL, NULL),
(3, 7, 5, 2, 'jhgjh', '3523', '2', 'Active', 1, '2023-02-11 22:56:05', NULL, NULL),
(4, 8, 5, 2, 'Buxar1', '2363', '1,3', 'Active', 1, '2023-02-11 23:42:38', NULL, NULL);

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
  `is_town_city` varchar(20) NOT NULL,
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
(1, 'Bokaro Steel City', 'City', 3, NULL, 'Active', 1, '2023-01-31 23:16:23', NULL, NULL),
(2, 'Ranchi', 'City', 3, '1', 'Active', 1, '2023-01-31 23:16:54', NULL, NULL),
(3, 'Jamshedpur', 'City', 3, '1,2', 'Active', 1, '2023-01-31 23:49:57', NULL, NULL),
(4, 'Patna', 'City', 2, NULL, 'Active', 1, '2023-02-01 16:24:13', NULL, NULL),
(5, 'Buxar', 'City', 2, '4', 'Active', 1, '2023-02-01 16:24:32', NULL, NULL),
(6, 'Gaya', 'City', 2, '4', 'Active', 1, '2023-02-01 16:25:30', NULL, NULL),
(7, 'Kolkata', 'Town', 1, NULL, 'Active', 1, '2023-02-01 16:42:52', NULL, NULL),
(8, 'Jharkhand Old Town', 'Town', 3, '1', 'Active', 1, '2023-02-01 17:32:57', NULL, NULL),
(9, 'Gaya1', 'Town', 2, '4,5', 'Active', 1, '2023-02-08 00:24:25', NULL, NULL);

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
(1, 1, '$2y$10$3c1GENKSai3xPHS6NLu87.4/E8.kjESH2eTKU2nOeqK6iwx14i/iy', '8899', 'superadminA@gmail.com', 1, '2022-11-01 15:03:40', NULL, NULL, 'Active', 'Test3', 'SuperAdminAB', 'Test3 SuperAdminAB', 'test3-superadminab', 1, NULL, 0),
(2, 1, '$2y$10$4o4MLMLW271cusWYsFIsmOSlp7B8K7yzeUHDcg0H78FYXe.KcWzQC', '256714', 'zeeshan.mymail@gmail.com', 1, '2022-11-01 15:19:02', NULL, NULL, 'Active', 'Test', 'SuperAdminB', 'Test SuperAdminB', 'test-superadminb', 1, '3705', 1),
(3, 0, '$2y$10$oYrkckptj5bJ4U8zeer5zuCXDpquKd15lrKE4.diPrKbAy4k6IKFK', '932016', 'zeeshan.newemail@gmail.com', 1, '2022-11-01 15:38:42', NULL, NULL, 'Active', 'Agent', 'A', 'Agent A', 'agent-a', 1, '', 0),
(5, 1, '$2y$10$OhwhlBpr5PnxTQLhzvotau3NIn7UHxUTvig/diTboo28XsB0mmOgO', '851594', 'suprio.b@mgts.co.in', 1, '2022-11-02 10:48:20', NULL, NULL, 'Inactive', 'Suprio', 'Basu', 'Suprio Basu', 'suprio-basu', 1, '7337', 1),
(7, 3, '$2y$10$9j6mLFRfpJMqZ1fGR7TNCeeXdYXv/yBil/YHJAynL1KnC2iYwstCa', '788140', 'gyrovic@yahoo.com', 1, '2022-11-02 15:16:34', NULL, NULL, 'Active', 'Ben', 'Esguerra', 'Ben Esguerra', 'ben-esguerra', 1, '', 0),
(8, 1, '$2y$10$uhKQXvEQp5Sa6oiOdmvAeuK/qKv8J/dEHqS3PjGWqyxg3G9tbTOw2', '948457', 'gyrovic@gmail.com', 1, '2022-11-02 15:18:53', NULL, NULL, 'Active', 'Victor', 'Esguerra', 'Victor Esguerra', 'victor-esguerra', 1, '7631', 1),
(9, 3, '$2y$10$Oc/j3dEgGUxDyr1dNsWQ5OWLSry5p95OMF18F4fZ/f6mWJZaJOH9i', '454805', 'jordanmarabe080802@gmail.com', 1, '2022-11-03 08:52:28', NULL, NULL, 'Active', 'Jordan', 'Marabe', 'Jordan Marabe', 'jordan-marabe', 1, '', 0),
(10, 4, '$2y$10$A7ZaUhLOctSCwp8KrmACP.YzDJGG//jkoDByFTyOUDMyT2Aiaqjcy', '103640', 'askldjaskld@gmail.com', 1, '2022-11-03 17:32:09', NULL, NULL, 'Active', '', '', 'Juan Dela Cruzzz', 'juan-dela-cruzzz', 1, NULL, 0),
(11, 4, '$2y$10$zdk3TzpuiB7WLFssWamtLOZY1zimoLXg0OEErj9GkmTZzFUMRcVUO', '114858', 'i2u32897@gmail.com', 1, '2022-11-03 17:41:42', NULL, NULL, 'Active', '', '', 'Jomar Young', 'jomar-young', 1, NULL, 0),
(12, 4, '$2y$10$H4u04GZhEpAglGjAY7y9GOO5bUQhc/aFhbWwdXlZf48gFWg7ptgye', '474699', 'asdasdasd@gmail.com', 1, '2022-11-03 18:50:35', NULL, NULL, 'New', '', '', 'First Broker', 'first-broker', 1, NULL, 0),
(17, 30, '$2y$10$A9UwNQesE./4qPDi5Ai6z.y6PVESVI3Fb4exelnUTKsXPntZxN/hW', 'Marabe123@', 'joannasinner@gmail.com', 1, '2022-11-04 07:23:26', NULL, NULL, 'Active', 'Joanna', 'Sinner', 'JoannaSinner', 'joannasinner', 1, NULL, 0),
(37, 30, '$2y$10$4oMBhJyu6KQe79Hj6JqkEOM1WSElW4jTTQf8jqDXeViTd.FlrcOXy', 'Marabe123@', 'janinakapo@shurua.xyz', 1, '2022-11-04 07:49:40', NULL, NULL, 'Active', 'Janina', 'Kapo', 'JaninaKapo', 'janinakapo', 1, NULL, 0),
(38, 26, '$2y$10$YfhjqMFdDe4i2dlRQuOBkuWhM3Hv9e4uZp6Ib2PKkFaq2ynO8GHhm', '1234567890', 'tisoybuloy@shurua.xyz', 1, '2022-11-04 08:43:51', NULL, NULL, 'Active', 'Tisoy', 'Buloy', 'Tisoy Buloy', 'tisoy-buloy', 1, NULL, 0),
(39, 30, '$2y$10$WDahPX/0LOV6aCb/4BLqhuJ2jSJeddUA/acQveq8HSdkoTw0t7hEe', '1234567890', 'sellerdalawa@shurua.xyz', 1, '2022-11-04 08:51:48', NULL, NULL, 'Active', 'Seller', 'Dalawa', 'SellerDalawa', 'sellerdalawa', 1, NULL, 0),
(40, 4, '$2y$10$2wy5PIMFB8ptfq8qoAizc.ymUd4wi/3tT7v6apTGVtmEx.MX91aKa', '824137', 'opekorkanor@shurua.xyz', 1, '2022-11-04 12:14:04', NULL, NULL, 'Active', 'Opekor', 'Kanor', 'Opekor Kanor', 'opekor-kanor', 1, '', 0),
(41, 30, '$2y$10$/Wsxlo15VISubP3y1tfWUO1y7ClH9S9Bewi1S.5LJoWcXuan1UL9a', '619108', 'brokerako@shurua.xyz', 1, '2022-11-05 14:30:29', NULL, NULL, 'Active', '', '', 'Broker Ako', 'broker-ako', 1, NULL, 0),
(44, 26, '$2y$10$HpzTfMfOFnVvdmwICMGmB.Ys1wdMufuH6drGVxJKJcKQ62GtpOMpa', '123456', 'yaqntduv@karenkey.com', 1, '2022-11-08 00:35:13', NULL, NULL, 'Active', 'Syed', 'Ali', 'SyedAli', 'syedali', 1, NULL, 0),
(45, 26, '$2y$10$3c1GENKSai3xPHS6NLu87.4/E8.kjESH2eTKU2nOeqK6iwx14i/iy', '8899', 'newagent@gmail.com', 1, '2022-11-15 17:47:43', NULL, NULL, 'Active', 'Newagent', 'Newagent', 'Newagent Newagent', 'newagent-newagent', 1, '', 0),
(46, 1, '$2y$10$i42pwdAMKZ/tlcrMLx1rluMIBPzH79z.FZT6G4nicoMMpecJv94jO', '238805', 'joxaso3214@gpipes.com', 1, '2023-03-07 00:13:36', NULL, NULL, 'Active', 'Rupesh', 'Tilak', 'Rupesh Tilak', 'rupesh-tilak1678128216', 1, '8028', 1);

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
  `phone_1` varchar(11) DEFAULT NULL,
  `phone_2` varchar(11) DEFAULT NULL,
  `birth_month` varchar(25) DEFAULT NULL,
  `birth_day` varchar(25) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `user_skills` varchar(200) DEFAULT NULL,
  `open_property_limit` int(11) DEFAULT 0,
  `active_user_date_limit` date DEFAULT NULL,
  `is_address_same_as_agency` varchar(10) DEFAULT NULL,
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
(1, 1, 'Test3', 'SuperAdminAB', 'Test', '0987567890', '0987567890', NULL, NULL, 'null', 'NaN', 0, NULL, NULL, 'null', 'null', 'null', 'null', 0, 0, 0, 0, 'null', 'null', NULL, 'null', NULL, NULL, 0, '24191669981678.jpg', NULL, NULL, NULL, NULL),
(2, 2, 'Test', 'SuperAdminB', 'SuperAdminB', '9614431680', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Agent', 'A', 'AgentA', '5566435645', '4363463454', NULL, NULL, 'null', 'NaN', 5, NULL, '1', 'null', 'null', 'null', 'null', 1, 2, 6, 7, '7676', 'null', 'L01', 'null', NULL, '20,21', 2, '28011667303490.png', NULL, NULL, NULL, NULL),
(5, 5, 'Suprio', 'Basu', 'Sup', '9432345546', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(7, 7, 'Ben', 'Esguerra', NULL, '0987654321', NULL, NULL, NULL, NULL, '3,1,6', 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(8, 8, 'Victor', 'Esguerra', NULL, '0987654321', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(9, 9, 'Jordan', 'Marabe', 'null', '0987654321', 'null', NULL, NULL, 'null', 'null', 5, NULL, NULL, 'null', 'null', 'null', 'null', 0, 0, 0, 0, 'null', 'null', NULL, 'null', NULL, NULL, 2, '26181667531059.jpg', NULL, NULL, NULL, NULL),
(10, 10, NULL, NULL, NULL, '0494812717', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '12', '121', '323 San Juan', 'Bagong Alaminos', 8, 14, 2, 2, '121212', 'Basement', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(11, 11, NULL, NULL, NULL, '1234556677', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '12', '121', 'San Juan', 'Alaminos', 8, 12, 2, 3, '121122', 'Ground', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(12, 12, NULL, NULL, NULL, '1212121212', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '121', '21212', '12121', '2121', 8, 16, 3, 34, '121212', 'Basement', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(13, 17, 'Joanna', 'Sinner', 'Jowana', '03958574910', '03927172819', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(14, 37, 'Janina', 'Kapo', 'janinay', '04945986575', '09378459581', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(15, 38, 'Tisoy', 'Buloy', 'Tisoy', '0394857563', '0987678909', NULL, NULL, 'null', 'NaN', 5, NULL, '1', '75555', '67', 'htrytrtyr', 'uhuhuhui', 2, 19, 1, 2, '6767', 'hftyftyf', 'a1', 'null', NULL, '21,23', 2, '12411667532893.jpg', NULL, NULL, NULL, NULL),
(16, 39, 'Seller', 'Dalawa', 'Sellerdalawa', '64785957817', '09847483930', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(17, 40, 'Opekor', 'Kanor', 'Mangkanor', '0987645678', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GTFY91901', NULL, NULL, '21', 2, NULL, NULL, NULL, NULL, NULL),
(18, 41, NULL, NULL, NULL, '9495757585', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2312', '12121', 'Broker ako sa alaminos', '1212 Building 1213', 1, 3, 2, 25, '585855', 'Basement', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL),
(19, 44, 'Syed', 'Ali', 'sdsd', '6546546546', '67476476576', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 61, NULL, NULL, NULL, NULL, NULL),
(20, 45, 'Newagent', 'Newagent', 'newagent', '2233423344', 'null', NULL, NULL, 'null', 'NaN', 5, NULL, '1', 'null', '435', 'ewe', 'null', 3, 20, 2, 2, '3445', 'fsfsf', 'eet', 'null', NULL, '20,21,23', 61, '49131670316939.jpg', NULL, NULL, NULL, NULL),
(21, 46, 'Rupesh', 'Tilak', 'rptilak', '9652514252', '09127612626', NULL, NULL, NULL, NULL, 5, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(3, 'Assessor', 'Active', 1, '2022-03-11 23:50:34', '2022-11-09 11:19:54', 1),
(6, 'Dano', 'Active', 1, '2022-11-09 16:39:52', NULL, NULL);

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
(1, 2, '2022-11-01 09:49:02', NULL, NULL, 1, 0),
(2, 3, '2022-11-01 10:08:42', NULL, NULL, 1, 0),
(3, 3, NULL, NULL, NULL, 3, 3),
(5, 5, '2022-11-02 05:18:20', NULL, NULL, 1, 0),
(7, 7, '2022-11-02 09:46:34', NULL, NULL, 1, 0),
(8, 8, '2022-11-02 09:48:53', NULL, NULL, 1, 0),
(9, 9, '2022-11-03 03:22:28', NULL, NULL, 1, 0),
(10, 9, NULL, NULL, NULL, 9, 9),
(11, 38, NULL, NULL, NULL, 38, 38),
(12, 40, '2022-11-04 06:44:04', NULL, NULL, 1, 0),
(13, 3, '2022-11-08 04:59:02', NULL, NULL, 3, 3),
(14, 3, '2022-11-10 07:55:44', NULL, NULL, 3, 3),
(15, 38, '2022-11-15 10:51:19', NULL, NULL, 38, 38),
(16, 38, '2022-11-15 10:52:32', NULL, NULL, 38, 38),
(17, 7, '2022-11-15 12:11:58', NULL, NULL, 7, 7),
(18, 7, '2022-11-15 12:12:34', NULL, NULL, 7, 7),
(19, 7, '2022-11-15 12:14:37', NULL, NULL, 7, 7),
(20, 45, '2022-11-15 12:17:43', NULL, NULL, 1, 0),
(21, 1, NULL, NULL, NULL, 1, 1),
(22, 1, NULL, NULL, NULL, 1, 1),
(23, 1, NULL, NULL, NULL, 1, 1),
(24, 1, NULL, NULL, NULL, 1, 1),
(25, 1, NULL, NULL, NULL, 1, 1),
(26, 1, NULL, NULL, NULL, 1, 1),
(27, 1, NULL, NULL, NULL, 1, 1),
(28, 1, NULL, NULL, NULL, 1, 1),
(29, 1, NULL, NULL, NULL, 1, 1),
(30, 1, NULL, NULL, NULL, 1, 1),
(31, 1, NULL, NULL, NULL, 1, 1),
(32, 1, NULL, NULL, NULL, 1, 1),
(33, 1, NULL, NULL, NULL, 1, 1),
(34, 1, NULL, NULL, NULL, 1, 1),
(35, 1, NULL, NULL, NULL, 1, 1),
(36, 1, NULL, NULL, NULL, 1, 1),
(37, 1, NULL, NULL, NULL, 1, 1),
(38, 1, NULL, NULL, NULL, 1, 1),
(39, 1, NULL, NULL, NULL, 1, 1),
(40, 1, NULL, NULL, NULL, 1, 1),
(41, 1, NULL, NULL, NULL, 1, 1),
(42, 1, NULL, NULL, NULL, 1, 1),
(43, 1, NULL, NULL, NULL, 1, 1),
(44, 1, NULL, NULL, NULL, 1, 1),
(45, 1, NULL, NULL, NULL, 1, 1),
(46, 1, NULL, NULL, NULL, 1, 1),
(47, 45, NULL, NULL, NULL, 45, 45),
(48, 45, '2022-12-29 09:25:18', NULL, NULL, 45, 45),
(49, 45, '2022-12-29 09:27:13', NULL, NULL, 45, 45),
(50, 45, '2022-12-30 15:47:20', NULL, NULL, 45, 45),
(51, 38, '2023-01-13 14:25:04', NULL, NULL, 38, 38),
(52, 38, '2023-01-13 15:16:58', NULL, NULL, 38, 38),
(53, 38, '2023-01-13 15:57:57', NULL, NULL, 38, 38),
(54, 38, '2023-01-14 02:41:53', NULL, NULL, 38, 38),
(55, 38, '2023-01-14 04:25:00', NULL, NULL, 38, 38),
(56, 38, '2023-01-14 04:45:10', NULL, NULL, 38, 38),
(57, 38, '2023-01-14 04:50:57', NULL, NULL, 38, 38),
(58, 38, NULL, '2023-01-14 04:55:54', 'hh', 38, 38),
(59, 38, '2023-01-14 04:57:26', NULL, NULL, 38, 38),
(60, 38, '2023-01-14 04:57:38', NULL, NULL, 38, 38),
(61, 38, '2023-01-14 06:03:31', NULL, NULL, 38, 38),
(62, 38, '2023-01-14 06:22:23', NULL, NULL, 38, 38),
(63, 38, '2023-01-14 06:30:56', NULL, NULL, 38, 38),
(64, 38, '2023-01-14 06:33:58', NULL, NULL, 38, 38),
(65, 38, '2023-01-14 06:34:29', NULL, NULL, 38, 38),
(66, 38, '2023-01-14 06:35:03', NULL, NULL, 38, 38),
(67, 46, '2023-03-06 18:43:36', NULL, NULL, 1, 0);

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
  ADD PRIMARY KEY (`subdivision_id`);

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
  MODIFY `agency_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `agri_type`
--
ALTER TABLE `agri_type`
  MODIFY `agri_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `barangay_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `broker`
--
ALTER TABLE `broker`
  MODIFY `broker_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `broker_association`
--
ALTER TABLE `broker_association`
  MODIFY `broker_association_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `capability`
--
ALTER TABLE `capability`
  MODIFY `capability_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `enquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

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
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `notification_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1090;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_mode`
--
ALTER TABLE `product_mode`
  MODIFY `product_mode_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `property_classification`
--
ALTER TABLE `property_classification`
  MODIFY `property_classification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `property_feature_mapping`
--
ALTER TABLE `property_feature_mapping`
  MODIFY `mapping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `property_tracking`
--
ALTER TABLE `property_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `property_type`
--
ALTER TABLE `property_type`
  MODIFY `property_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `province_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `specialization_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subdivisions`
--
ALTER TABLE `subdivisions`
  MODIFY `subdivision_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_details_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_device_mapping`
--
ALTER TABLE `user_device_mapping`
  MODIFY `user_device_mapping_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_skills`
--
ALTER TABLE `user_skills`
  MODIFY `user_skills_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_tracking`
--
ALTER TABLE `user_tracking`
  MODIFY `user_tracking_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `zonning_code`
--
ALTER TABLE `zonning_code`
  MODIFY `zonning_code_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
