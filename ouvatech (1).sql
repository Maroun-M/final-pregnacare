-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 05, 2023 at 02:39 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ouvatech`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_glucose`
--

DROP TABLE IF EXISTS `blood_glucose`;
CREATE TABLE IF NOT EXISTS `blood_glucose` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `glucose_level` decimal(5,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_glucose`
--

INSERT INTO `blood_glucose` (`record_id`, `user_id`, `glucose_level`, `timestamp`, `status`) VALUES
(56, 9, '105.00', '2022-01-10 14:00:00', NULL),
(55, 9, '100.00', '2022-01-05 10:00:00', NULL),
(54, 9, '95.00', '2022-01-01 06:00:00', NULL),
(53, 9, '155.00', '2023-04-10 13:00:00', NULL),
(52, 9, '150.00', '2023-04-05 09:00:00', NULL),
(51, 9, '145.00', '2023-04-01 05:00:00', NULL),
(50, 9, '140.00', '2023-03-30 15:00:00', NULL),
(49, 9, '135.00', '2023-03-25 12:00:00', NULL),
(48, 9, '130.00', '2023-03-20 08:00:00', NULL),
(47, 9, '125.00', '2023-03-15 18:00:00', NULL),
(46, 9, '120.00', '2023-03-10 14:00:00', NULL),
(45, 9, '115.00', '2023-03-05 10:00:00', NULL),
(44, 9, '110.00', '2023-03-01 06:00:00', NULL),
(43, 9, '125.00', '2023-04-21 20:25:31', NULL),
(42, 9, '120.00', '2023-04-22 20:25:31', NULL),
(41, 9, '115.00', '2023-04-23 20:25:31', NULL),
(40, 9, '110.00', '2023-04-24 20:25:31', NULL),
(39, 9, '105.00', '2023-04-25 20:25:31', NULL),
(38, 9, '100.00', '2023-04-26 20:25:31', NULL),
(27, 9, '86.67', '2023-04-27 07:24:22', NULL),
(28, 9, '190.94', '2023-04-23 07:24:22', NULL),
(29, 9, '147.88', '2023-04-20 07:24:22', NULL),
(30, 9, '191.32', '2023-04-14 07:24:22', NULL),
(31, 9, '54.14', '2023-04-19 07:24:22', NULL),
(32, 9, '56.81', '2023-04-03 07:24:22', NULL),
(33, 9, '142.08', '2023-04-25 07:24:22', NULL),
(59, 9, '120.00', '2022-01-25 12:00:00', NULL),
(60, 9, '125.00', '2022-01-30 16:00:00', NULL),
(61, 9, '130.00', '2022-02-01 06:00:00', NULL),
(62, 9, '135.00', '2022-02-05 10:00:00', NULL),
(63, 9, '140.00', '2022-02-10 14:00:00', NULL),
(64, 9, '145.00', '2022-02-15 18:00:00', NULL),
(65, 9, '150.00', '2022-02-20 08:00:00', NULL),
(66, 9, '155.00', '2022-02-25 12:00:00', NULL),
(67, 9, '160.00', '2022-02-28 16:00:00', NULL),
(68, 9, '165.00', '2022-03-01 06:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blood_oxygen`
--

DROP TABLE IF EXISTS `blood_oxygen`;
CREATE TABLE IF NOT EXISTS `blood_oxygen` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_oxygen`
--

INSERT INTO `blood_oxygen` (`record_id`, `user_id`, `percentage`, `timestamp`) VALUES
(4, 9, 99, '2023-06-03 18:32:11'),
(3, 9, 85, '2023-04-29 20:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `doctor_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `clinic_number` varchar(20) NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  PRIMARY KEY (`doctor_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `location`, `education`, `clinic_number`, `clinic_name`, `date_of_birth`) VALUES
(2, 9, 'Aley', 'Phd in ', '+961 81 838298', 'dr clinic', '2023-05-09'),
(3, 72, 'Location4611', 'Education6602', '917', 'Clinic6084', '2015-06-18'),
(4, 74, 'Location6193', 'Education2299', '291', 'Clinic7676', '1996-12-25'),
(5, 75, 'Location5163', 'Education6899', '900', 'Clinic4344', '2010-07-05'),
(6, 76, 'Location457', 'Education8192', '958', 'Clinic3367', '2001-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `fetus`
--

DROP TABLE IF EXISTS `fetus`;
CREATE TABLE IF NOT EXISTS `fetus` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `gestational_age` int NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `heart_rate` int NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fetus`
--

INSERT INTO `fetus` (`record_id`, `user_id`, `gestational_age`, `weight`, `heart_rate`, `timestamp`) VALUES
(4, 9, 115, '200.00', 70, '2023-05-19 10:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `hr_bp`
--

DROP TABLE IF EXISTS `hr_bp`;
CREATE TABLE IF NOT EXISTS `hr_bp` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bpm` int DEFAULT NULL,
  `systolic` int DEFAULT NULL,
  `diastolic` int DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `fk_patient` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hr_bp`
--

INSERT INTO `hr_bp` (`record_id`, `user_id`, `timestamp`, `bpm`, `systolic`, `diastolic`) VALUES
(21, 9, '2023-06-03 09:46:19', 70, 120, 80),
(18, 9, '2023-04-29 20:00:34', 70, 120, 80),
(19, 9, '2023-05-17 17:15:46', 79, 118, 59),
(20, 9, '2023-05-17 17:16:56', 58, 120, 78);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `previous_pregnancies` tinyint(1) DEFAULT NULL,
  `pregnancy_stage` int DEFAULT NULL,
  `diabetic` tinyint(1) DEFAULT '0',
  `hypertension` tinyint(1) DEFAULT '0',
  `LMP` date DEFAULT NULL,
  `EDD` date DEFAULT NULL,
  `gestational_age` int DEFAULT NULL,
  PRIMARY KEY (`patient_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `location`, `date_of_birth`, `previous_pregnancies`, `pregnancy_stage`, `diabetic`, `hypertension`, `LMP`, `EDD`, `gestational_age`) VALUES
(1, 9, 'Beirut', '2020-04-18', 1, 2, 0, 0, '2023-01-18', '2023-10-31', 119),
(2, 68, 'Location81', '2004-06-24', 2, 3, 0, 1, NULL, NULL, NULL),
(3, 69, 'Location3682', '2017-11-08', 4, 3, 1, 0, NULL, NULL, NULL),
(4, 70, 'Location8306', '2003-01-08', 1, 3, 1, 0, NULL, NULL, NULL),
(5, 71, 'Location962', '2007-03-09', 3, 3, 1, 0, NULL, NULL, NULL),
(6, 73, 'Location5078', '2013-05-22', 1, 3, 0, 0, NULL, NULL, NULL),
(7, 77, 'Location6570', '2021-07-06', 1, 3, 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_doctor`
--

DROP TABLE IF EXISTS `patient_doctor`;
CREATE TABLE IF NOT EXISTS `patient_doctor` (
  `patient_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  PRIMARY KEY (`patient_id`,`doctor_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_doctor`
--

INSERT INTO `patient_doctor` (`patient_id`, `doctor_id`) VALUES
(1, 3),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `temperature`
--

DROP TABLE IF EXISTS `temperature`;
CREATE TABLE IF NOT EXISTS `temperature` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `temp` decimal(5,2) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `temperature`
--

INSERT INTO `temperature` (`record_id`, `user_id`, `temp`, `timestamp`) VALUES
(18, 9, '35.00', '2023-06-03 10:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `account_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `confirmation_code` varchar(255) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access_level` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `account_password`, `confirmation_code`, `confirmed`, `created_at`, `access_level`) VALUES
(9, 'Maroun', 'Mourad', '+961 81838298', 'maroun233243@gmail.com', '$2y$12$LXTdTJ20ukQxRlI6CXKSB.7ropRaTgR6VngF5GuV90B.65UDs0T/K', 'XLvpmN', 1, '2023-04-03 20:22:41', 1),
(28, 'Maroun', 'Mourad', '+961 81838', 'maroun360p@gmail.com', '$2y$12$457/50.li5rMbEjQABvO0O1Cat45RMhzks/BqqvqzeUnYo7LmnV2u', '16vOVB', 0, '2023-04-06 11:02:18', 1),
(30, 'Maroun', 'Mourad', '+961 81838', 'maroun233245@gmail.com', '$2y$12$3RmwGAxNo4lV5XwuyN3C0OW71cFRO/pfooZkcBIjr9zrBVnNakLRS', 'h9xBKM', 0, '2023-05-03 19:00:09', 2),
(68, 'First9004', 'Last7323', '555-555-9602', 'user6041@example.com', '106fe10c064346d6e802f312fbca8184', '8885', 1, '2022-12-05 06:58:22', 1),
(69, 'First4626', 'Last8340', '555-555-7826', 'user4107@example.com', 'a7c6f8f4a4304456fd544113829558ef', '2967', 0, '2022-06-07 05:58:22', 1),
(70, 'First2320', 'Last3248', '555-555-9280', 'user6659@example.com', '7da48542bc4428c18cbdc2314275b53d', '7287', 1, '2022-07-09 05:58:22', 1),
(71, 'First6472', 'Last5124', '555-555-6206', 'user5657@example.com', 'd50dbb9b6cd900ba06b6a130ff78e684', '1378', 2, '2022-11-05 06:58:22', 1),
(72, 'First7799', 'Last824', '555-555-0722', 'user1138@example.com', '49668f68ba7de9a51fb2f89292a0a593', '4221', 0, '2022-05-18 05:58:22', 2),
(73, 'First1290', 'Last1744', '555-555-4851', 'user9025@example.com', '4f7d588309970c0336140d41fb49b911', '5793', 1, '2022-06-28 05:58:22', 1),
(74, 'First5725', 'Last1289', '555-555-9271', 'user2490@example.com', 'ecd1ffd6a744d742ce8c110b989d7f32', '5715', 0, '2022-10-03 05:58:22', 2),
(75, 'First6054', 'Last9509', '555-555-9381', 'user8379@example.com', '8423d245459cf11530b9c583800f74ea', '3631', 1, '2023-01-06 06:58:22', 2),
(76, 'First5326', 'Last4993', '555-555-8987', 'user9957@example.com', '1f4d8658f6a96624a76db8418c3ba5ac', '4260', 0, '2023-03-29 05:58:22', 2),
(77, 'First7042', 'Last581', '555-555-1779', 'user7152@example.com', 'a5d8322eb43f8a3e57a4ef2d7e686369', '0663', 0, '2022-07-20 05:58:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

DROP TABLE IF EXISTS `user_files`;
CREATE TABLE IF NOT EXISTS `user_files` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `update_gestational_age_patients`$$
CREATE DEFINER=`root`@`localhost` EVENT `update_gestational_age_patients` ON SCHEDULE EVERY 1 DAY STARTS '2023-05-19 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE patients
    SET gestational_age = gestational_age + 1,
        pregnancy_stage = CASE
            WHEN (gestational_age + 1) <= 84 THEN 1
            WHEN (gestational_age + 1) <= 168 THEN 2
            ELSE 3
        END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
