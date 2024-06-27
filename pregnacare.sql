-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 29, 2024 at 09:17 PM
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
-- Database: `pregnacare`
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_glucose`
--

INSERT INTO `blood_glucose` (`record_id`, `user_id`, `glucose_level`, `timestamp`, `status`) VALUES
(76, 9, '60.00', '2023-06-12 15:55:10', NULL),
(77, 9, '95.00', '2023-06-16 18:23:03', NULL),
(78, 9, '8.00', '2023-06-17 08:09:35', NULL),
(79, 9, '86.00', '2024-01-03 19:33:46', NULL),
(81, 9, '85.00', '2024-01-03 19:34:18', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_oxygen`
--

INSERT INTO `blood_oxygen` (`record_id`, `user_id`, `percentage`, `timestamp`) VALUES
(5, 28, 98, '2023-06-12 16:50:11'),
(6, 9, 95, '2023-06-16 18:23:08'),
(7, 9, 8, '2023-06-17 08:09:30'),
(8, 9, 95, '2024-01-03 19:34:25'),
(9, 9, 90, '2024-01-03 19:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `blood_pressure`
--

DROP TABLE IF EXISTS `blood_pressure`;
CREATE TABLE IF NOT EXISTS `blood_pressure` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `systolic` int DEFAULT NULL,
  `diastolic` int DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `fk_patient` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_pressure`
--

INSERT INTO `blood_pressure` (`record_id`, `user_id`, `timestamp`, `systolic`, `diastolic`) VALUES
(22, 9, '2023-06-12 18:13:20', 120, 80),
(23, 9, '2023-06-12 18:13:24', 120, 80),
(24, 9, '2023-06-12 18:13:27', 120, 80),
(25, 9, '2023-06-16 18:22:49', 120, 70),
(26, 9, '2024-01-03 19:34:00', 120, 80),
(27, 9, '2024-01-03 19:34:05', 130, 70),
(28, 9, '2024-01-03 19:34:10', 140, 80);

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

DROP TABLE IF EXISTS `clinics`;
CREATE TABLE IF NOT EXISTS `clinics` (
  `clinic_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `clinic_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`clinic_id`),
  UNIQUE KEY `fk_clinics_user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`clinic_id`, `user_id`, `clinic_name`, `phone_number`, `clinic_location`) VALUES
(28, 30, 'Ouvatech', '81838298', 'Beirut'),
(29, 9, 'tech', '81838298', 'Beirut');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `doctor_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `education` varchar(255) NOT NULL,
  `biography` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`doctor_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `location`, `date_of_birth`, `education`, `biography`) VALUES
(7, 9, 'Jounieh', '1990-06-22', 'PHD IN micro..', ' Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias aliquam culpa et excepturi, perferendis adipisci pariatur nobis, velit fugit facere animi soluta quae tenetur. Aliquid perspiciatis cum harum aspernatur laborum.'),
(8, 30, 'Jdeideh', '1990-07-22', 'PHD in ....', '81838298');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fetus`
--

INSERT INTO `fetus` (`record_id`, `user_id`, `gestational_age`, `weight`, `heart_rate`, `timestamp`) VALUES
(5, 9, 122, '200.00', 70, '2023-06-16 18:23:13'),
(6, 9, 123, '200.00', 70, '2023-06-17 08:09:26'),
(7, 9, 170, '200.00', 70, '2024-01-03 19:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `heart_rate`
--

DROP TABLE IF EXISTS `heart_rate`;
CREATE TABLE IF NOT EXISTS `heart_rate` (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `BPM` int DEFAULT NULL,
  PRIMARY KEY (`record_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `heart_rate`
--

INSERT INTO `heart_rate` (`record_id`, `user_id`, `timestamp`, `BPM`) VALUES
(4, 9, '2023-06-12 18:22:55', 85),
(5, 9, '2023-06-12 18:22:59', 86),
(6, 9, '2023-06-16 15:59:51', 85),
(7, 9, '2023-06-16 15:59:53', 90),
(8, 9, '2023-06-16 15:59:57', 75),
(9, 9, '2023-06-16 15:59:59', 70),
(10, 9, '2023-06-16 18:22:54', 85),
(11, 9, '2024-01-03 19:33:51', 75),
(13, 9, '2024-05-07 07:38:38', 70),
(14, 9, '2024-05-07 07:39:00', 80);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_text` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `timestamp`) VALUES
(39, 30, 86, 'hello', '2024-05-30 00:16:53'),
(38, 86, 30, 'hello', '2024-05-30 00:12:48'),
(37, 86, 30, 'test', '2024-05-30 00:04:29'),
(36, 86, 30, 'hallo', '2024-05-30 00:03:17'),
(35, 86, 30, 'good', '2024-05-29 23:58:30'),
(34, 30, 86, 'good', '2024-05-29 23:58:22'),
(31, 30, 86, 'are you fine', '2024-05-29 23:48:51'),
(30, 30, 86, 'how are you', '2024-05-29 23:48:17'),
(33, 30, 86, 'hello', '2024-05-29 23:53:44'),
(32, 86, 30, 'Hello', '2024-05-29 23:50:45'),
(29, 30, 86, 'hello', '2024-05-29 23:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `location`, `date_of_birth`, `previous_pregnancies`, `pregnancy_stage`, `diabetic`, `hypertension`, `LMP`, `EDD`, `gestational_age`) VALUES
(1, 9, 'Beirut', '1990-04-18', 1, 3, 0, 1, '2023-07-10', '2024-04-22', 317),
(9, 28, 'Beirut', '1995-04-18', 1, 3, 0, 0, '2023-01-18', '2023-10-31', 491),
(11, 30, 'Beirut', '1990-12-31', 1, 3, 0, 0, '2023-06-01', '2024-03-14', 356),
(12, 86, 'Beirut', '1992-02-06', 1, 1, 1, 1, '2024-04-01', '2025-01-14', 50),
(13, 87, 'Beirut', '2003-01-04', 0, 1, 1, 0, '2024-05-08', '2025-02-22', 11);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_doctor`
--

INSERT INTO `patient_doctor` (`patient_id`, `doctor_id`) VALUES
(9, 7),
(1, 8),
(12, 8);

-- --------------------------------------------------------

--
-- Table structure for table `resend_activation_counts`
--

DROP TABLE IF EXISTS `resend_activation_counts`;
CREATE TABLE IF NOT EXISTS `resend_activation_counts` (
  `user_id` int NOT NULL,
  `resend_count` int DEFAULT '0',
  `last_resend_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `resend_activation_counts`
--

INSERT INTO `resend_activation_counts` (`user_id`, `resend_count`, `last_resend_timestamp`) VALUES
(9, 3, '2023-06-15 16:34:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `temperature`
--

INSERT INTO `temperature` (`record_id`, `user_id`, `temp`, `timestamp`) VALUES
(19, 9, '36.00', '2023-06-16 18:22:59'),
(20, 9, '37.30', '2023-06-17 08:09:38'),
(21, 9, '37.00', '2024-01-03 19:33:36'),
(22, 9, '36.00', '2024-01-03 19:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
CREATE TABLE IF NOT EXISTS `tests` (
  `ID` int NOT NULL,
  `test_name` varchar(10) NOT NULL,
  `hi_1st` int NOT NULL,
  `hi_2nd` int NOT NULL,
  `hi_3rd` int NOT NULL,
  `lo_1st` int NOT NULL,
  `lo_2nd` int NOT NULL,
  `lo_3rd` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`ID`, `test_name`, `hi_1st`, `hi_2nd`, `hi_3rd`, `lo_1st`, `lo_2nd`, `lo_3rd`) VALUES
(1, 'hr_bp', 120, 110, 100, 60, 50, 55);

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
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT './default_profile_pic/default_pp.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `account_password`, `confirmation_code`, `confirmed`, `created_at`, `access_level`, `profile_picture`) VALUES
(9, 'Mary', 'Jane', '+961 81838298', 'marounP@gmail.com', '$2y$10$3UXlHzX.N60i/hCFlTMi5.RG6buItpHrxkTREueim0RJmiR8xMF7G', 'S9PMQZ', 1, '2023-04-03 17:22:41', 1, './default_profile_pic/default_pp.png'),
(28, 'John', 'DOE', '+961 81838', 'marounA@gmail.com', '$2y$12$457/50.li5rMbEjQABvO0O1Cat45RMhzks/BqqvqzeUnYo7LmnV2u', '16vOVB', 1, '2023-04-06 11:02:18', 3, './default_profile_pic/default_pp.png'),
(30, 'John', 'Doe', '+961 81838', 'marounD@gmail.com', '$2y$12$3RmwGAxNo4lV5XwuyN3C0OW71cFRO/pfooZkcBIjr9zrBVnNakLRS', 'h9xBKM', 1, '2023-05-03 19:00:09', 2, './default_profile_pic/default_pp.png'),
(86, 'Mary', 'Jane', '+961 70329828', 'maroun233243@gmail.com', '$2y$12$uJuZ/BpeXvKIvwZOwU2ihe6Hjq2OpDiZSBVOrhkNvWIHxpsxzymie', 'EqLNnk', 1, '2024-05-16 10:03:23', 1, './default_profile_pic/default_pp.png'),
(87, 'joe', 'koko', '+961 76536806', 'WIRDIGT@GMAIL.COM', '$2y$12$kKR.CIFhEf09uOlN1enfvutQAgNCPbNDKNo71FYZoviM8nLRK3LMG', 'UphZEw', 1, '2024-05-28 11:54:55', 1, './default_profile_pic/default_pp.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`record_id`, `user_id`, `timestamp`, `file_path`) VALUES
(2, 9, '2023-06-16 16:06:28', './tests/9_IMG-648c88849ecfe6.83338934.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_glucose`
--
ALTER TABLE `blood_glucose`
  ADD CONSTRAINT `fk_glucose_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_oxygen`
--
ALTER TABLE `blood_oxygen`
  ADD CONSTRAINT `fk_oxygen_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_pressure`
--
ALTER TABLE `blood_pressure`
  ADD CONSTRAINT `fk_hrbp_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clinics`
--
ALTER TABLE `clinics`
  ADD CONSTRAINT `fk_clinic_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `fk_doctors_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fetus`
--
ALTER TABLE `fetus`
  ADD CONSTRAINT `fk_fetus_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_fetus_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `heart_rate`
--
ALTER TABLE `heart_rate`
  ADD CONSTRAINT `heart_rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patients_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_doctor`
--
ALTER TABLE `patient_doctor`
  ADD CONSTRAINT `fk_doctor_user_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patient_user_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `temperature`
--
ALTER TABLE `temperature`
  ADD CONSTRAINT `fk_temp_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_files`
--
ALTER TABLE `user_files`
  ADD CONSTRAINT `fk_files_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `update_gestational_age_patients`$$
CREATE DEFINER=`root`@`localhost` EVENT `update_gestational_age_patients` ON SCHEDULE EVERY 1 DAY STARTS '2023-05-19 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE patients
    SET
        gestational_age = (DATEDIFF(CURRENT_DATE, EDD) / 7 + 40) * 7,
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
