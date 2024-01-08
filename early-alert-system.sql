-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 09:05 PM
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
-- Database: `early-alert-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'admin',
  `otp` int(11) NOT NULL,
  `otp_expiration` datetime NOT NULL,
  `is_email_activated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `user_type`, `otp`, `otp_expiration`, `is_email_activated`) VALUES
(1, 'Admin', 'mathewsuarez20@gmail.com', 'admin123123', 'admin', 220911, '2024-01-07 06:07:00', 1),
(3, 'admin 2', 'mathewsuarez@gmail.com', 'admin123123', 'admin', 0, '2023-11-29 18:43:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `invite_code` varchar(50) NOT NULL,
  `grade` int(11) NOT NULL,
  `strand` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `teacher_unique_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `unique_id`, `owner`, `invite_code`, `grade`, `strand`, `section`, `class`, `teacher_unique_id`, `created_at`) VALUES
(12, 6399567, 'teachers', 'd3a06d2', 12, 'TVL-ICT', 'Enthusiasm', 'None', 4056405, '2024-01-05 14:11:24'),
(13, 5901172, 'Matthew Suarez', 'da7d65b', 12, 'TVL-ICT', 'Test', 'A', 2002956, '2024-01-05 14:12:09'),
(14, 3373413, 'Boom Panes', '3acc6f8', 12, 'TVL-ICT', 'test2', 'None', 9921261, '2024-01-05 14:19:09'),
(18, 6840634, 'teacher test1', 'd3ff7f7', 12, 'TVL-ICT', 'Test', '', 5149125, '2024-01-07 04:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `early_alert`
--

CREATE TABLE `early_alert` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `teacher` int(11) NOT NULL,
  `teacher_unique_id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `quarter` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_data`
--

CREATE TABLE `students_data` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `parent_phoneNo` int(11) NOT NULL,
  `grade_level` varchar(255) NOT NULL,
  `strand` varchar(255) NOT NULL,
  `section` varchar(50) NOT NULL,
  `strand_class` varchar(50) NOT NULL,
  `class_unique_id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `otp` int(11) NOT NULL,
  `otp_expiration` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_email_activated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_data`
--

INSERT INTO `students_data` (`id`, `unique_id`, `name`, `email`, `password`, `parent_phoneNo`, `grade_level`, `strand`, `section`, `strand_class`, `class_unique_id`, `user_type`, `otp`, `otp_expiration`, `created_at`, `is_email_activated`) VALUES
(119, 5900107, 'Matthew Suarez', 'msuarez.f2f@tracecollege.edu.ph', '$2y$10$n/3uaaJ05prtq/KzF28vAej4cDXBRNFJ5MpeZAYs4GmAMaW9bsVuK', 0, 'g12', 'humss', '', '', 7649037, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 03:45:58', 1),
(122, 2068292, 'Mogewara a', 'mathesdawsuarez20@tracecollege.edu.ph', '$2y$10$x5pm2p5zjDVUY9pa.5xCa.dcTTds8wR9OHS7bHZltdDT9p48t18.O', 0, 'g12', 'humss', '', 'A', 5165019, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:52:01', 0),
(125, 4359796, 'Matthew Suarez', 'msussssarez.f2f@tracecollege.edu.ph', '$2y$10$Gj7.0M9zEC7ZN19SGWv22.00jWyPV6UFnfE9Oxstm8NlhCpnG65eO', 0, 'g12', 'humss', '', '', 5165019, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:52:41', 0),
(126, 4277930, 'Matthew Suarez', 'msuasdarez.f2f@tracecollege.edu.ph', '$2y$10$kA.temGmKQVtroYO2uA5pO336huV964mUU/X.sW6azJGfvSR6y7lS', 0, 'g12', 'humss', '', '', 5165019, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:52:52', 0),
(127, 5249550, 'Matthew Suarez', 'msuarezs.f2f@tracecollege.edu.ph', '$2y$10$pQlILsM7mrbyqenQcbNkLepTiPvrT2KFX94m3scm.6MpCGk/IoWPK', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:53:02', 0),
(128, 4534675, 'Matthew Suarez', 'mddsuarez.f2f@tracecollege.edu.ph', '$2y$10$Z/FUAFCVKZPHNB2JV4mW0.1m13iT3Ql7accB85qZpAgPl.rpI5.Xe', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:53:13', 0),
(129, 4616921, 'Matthew Suarez', 'mssusarez.f2f@tracecollege.edu.ph', '$2y$10$mlh8qlcQQxz5NyTwKHxfs.ZWtUfHLL/ItHOVvPb.6AMF4AnrtMJES', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 18:53:31', 0),
(135, 1673850, 'Matthew Suarez', 'msuearez.f2f@tracecollege.edu.ph', '$2y$10$nnIaximT1dGOTzo8GSMglOAiTMcc8a4nTSlf1CH4jeB3zMffHt6Ye', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:05:50', 0),
(136, 5985031, 'Matthew Suarez', 'msusareasdz.f2f@tracecollege.edu.ph', '$2y$10$5ops1nE.I7RQvlTPDII3Iu7bKWRnNM4BJ9UfcLv2nXem7NcRPHPIW', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:11:03', 0),
(137, 6527523, 'Matthew Suarez', 'msuareasddz.f2f@tracecollege.edu.ph', '$2y$10$nDKNVcTurr9QRqW1jz8QjuzgYNVtT028lA8Q7O2nIFdxVzzWgIx5G', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:11:15', 0),
(138, 4453445, 'Matthew Suarez', 'msuareasddz.f2f@tracecollege.edu.ph', '$2y$10$lj3atmsjiWGZ2DGEl05TcePs3ntiGq.W7Xl8L3/Gqn1eLg8duA1hm', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:19:08', 0),
(139, 272269, 'Matthew Suarez', 'msuareasddz.f2f@tracecollege.edu.ph', '$2y$10$j8aJO4KNhtPP73piiyT4quba1dtzMSnZnvTQESk6zNgb1iER4JN0u', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:20:30', 0),
(140, 6606416, 'Matthew Suarez', 'msuareasddz.f2f@tracecollege.edu.ph', '$2y$10$itTzVcOX4mw0h0dnOTdn9efc0Jk695t3jaHO7ksDZMc6gwQ0eC4cW', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:20:33', 0),
(144, 6415102, 'Matthew Suarez', 'msuaresdsdz.f2f@tracecollege.edu.ph', '$2y$10$CRphHnrff7SKv93j6ZqEhOQ4DucoeiWCMKE8slVnl5VG5w4No34tm', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:23:30', 0),
(145, 4655169, 'Matthew Suarez', 'msdddsuarez.f2f@tracecollege.edu.ph', '$2y$10$2HS6Yl0yqo90csSV2QC2EuAicpDNDp4RKWpbClO/sgJMPGrIiZ38W', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:24:09', 0),
(146, 585636, 'Matthewd ddd', 'mggsuarez.f2f@tracecollege.edu.ph', '$2y$10$hMFbhDGNjl5dIXmDqilDf.L7cg6d/kKmpNFfL6Ar88YcxXup/9Y/q', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-18 21:24:38', 0),
(148, 6076162, 'matthew suarez', 'mathewsuarez@tracecollege.edu.ph', '$2y$10$bqpEtFYi0QqfvPv0HbKPoeItp4k/F29D/fwzeQWndWSIo9CosNOw2', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-30 03:02:41', 0),
(150, 8732977, 'Matthew Suarez', 'sdafads@gmail.com', '$2y$10$oWtZoxNz.ouMWBry8DVWS.MsbdoqUmX7iMJ3ElwfonZI.Os10Nwu.', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-30 03:10:52', 0),
(151, 6582525, 'weqwe qweqwe', 'teachfer@tracecollege.edu.ph', '$2y$10$NdfoXaUJCYsVCCKNWKS8yuWTn8XYZIz0EbmiIF6s7T598dE0EYNXm', 0, 'g12', 'humss', '', '', 0, 'student', 0, '0000-00-00 00:00:00', '2023-12-30 03:25:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_classroom`
--

CREATE TABLE `sub_classroom` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `teacher_uniqueid` int(11) NOT NULL,
  `class_1` int(11) NOT NULL,
  `class_2` int(11) NOT NULL,
  `class_3` int(11) NOT NULL,
  `class_4` int(11) NOT NULL,
  `class_5` int(11) NOT NULL,
  `class_6` int(11) NOT NULL,
  `class_7` int(11) NOT NULL,
  `class_8` int(11) NOT NULL,
  `class_9` int(11) NOT NULL,
  `class_10` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_classroom`
--

INSERT INTO `sub_classroom` (`id`, `unique_id`, `name`, `teacher_uniqueid`, `class_1`, `class_2`, `class_3`, `class_4`, `class_5`, `class_6`, `class_7`, `class_8`, `class_9`, `class_10`) VALUES
(13, 2329216, 'Matthew Suarez', 2002956, 6399567, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 2391133, 'teachers', 4056405, 3373413, 5901172, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 4449431, 'teacher test2', 6564827, 6840634, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_data`
--

CREATE TABLE `teachers_data` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL,
  `user_type` text NOT NULL,
  `otp` int(11) NOT NULL,
  `otp_expiration` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_email_activated` int(11) NOT NULL COMMENT 'Activated = 1 , Inactive = 0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_data`
--

INSERT INTO `teachers_data` (`id`, `unique_id`, `name`, `email`, `password`, `department`, `user_type`, `otp`, `otp_expiration`, `created_at`, `is_email_activated`) VALUES
(17, 5149125, 'teacher test1', 'teacher1@tracecollege.edu.ph', '$2y$10$ZmbfidU3gsaJhLscEqVMte29oBW2toxeB.us3OVJrPQJYcjcKGTLa', '', 'teacher', 2372, '2024-01-07 19:51:00', '2024-01-05 15:21:55', 1),
(18, 6564827, 'teacher test2', 'teacher2@tracecollege.edu.ph', '$2y$10$9QYwk.y024y.D5lDRCRAyOg/PynikRv/ZlNLB5ut/Qg8EE5SxNtV2', '', 'teacher', 598638, '2024-01-07 15:41:00', '2024-01-05 15:22:11', 1),
(19, 5818751, 'teacher test3', 'teacher3@tracecollege.edu.ph', '$2y$10$IAYjK8kk8keCUHqGnDdLTeuaBVpDilmIMR34wBuF9dGJBWQawX0Ja', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:22:24', 0),
(20, 2481143, 'teacher test4', 'teacher4@tracecollege.edu.ph', '$2y$10$95NslGbx6ecvOXFLW9EglOO6jTnJtbqT/29NkbE6YgOfN7MWoSbK.', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:22:37', 0),
(21, 5942525, 'teacher test5', 'teacher5@tracecollege.edu.ph', '$2y$10$4DlJUcGnBiy8El0ec/426OvSX8qAGytsBvIVJnva80T0gDiyz3PV.', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:22:59', 0),
(22, 2043444, 'teacher test6', 'teacher6@tracecollege.edu.ph', '$2y$10$qSShx55MKAohjFpFiO2vf.pqpSr4TiiFNPlX2wM.uaPt3UhM2SfBq', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:23:17', 0),
(23, 7473069, 'teacher test7', 'teacher7@tracecollege.edu.ph', '$2y$10$0/ZdGpF/EYJ4vGeQWfvboO4FTtPRql9ONSEcx2dqf2KrcRVu56Ata', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:23:53', 0),
(24, 4545034, 'teacher test8', 'teacher8@tracecollege.edu.ph', '$2y$10$4UNCn0CgonWzL1NVYIYSLe.lSe/Zm5LE9jEVw3Q999gDwItc9PxT.', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:26:47', 0),
(25, 5278857, 'teacher test9', 'teacher9@tracecollege.edu.ph', '$2y$10$Fr9Qm19i7zsCbAKE5ctZn.w.kmvtRzNBffkld0WI4IFZgzjixiQW.', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:45:07', 0),
(26, 3594168, 'teacher test10', 'teacher10@tracecollege.edu.ph', '$2y$10$rti6rMkYdYZQb/TzGJSWe.Q5B8tG.v0MDS6.92duOeSiVJTRouOhW', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:45:47', 0),
(27, 6916716, 'teacher test11', 'teacher11@tracecollege.edu.ph', '$2y$10$fmr0OX5Jb0znvC7UnMVFZ.4D7K9cySu.0RzWY6RPGi2vhSa.UVxti', '', 'teacher', 0, '0000-00-00 00:00:00', '2024-01-05 15:46:40', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `early_alert`
--
ALTER TABLE `early_alert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_data`
--
ALTER TABLE `students_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_classroom`
--
ALTER TABLE `sub_classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers_data`
--
ALTER TABLE `teachers_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `early_alert`
--
ALTER TABLE `early_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_data`
--
ALTER TABLE `students_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `sub_classroom`
--
ALTER TABLE `sub_classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers_data`
--
ALTER TABLE `teachers_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
