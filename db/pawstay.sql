-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 07:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pawstay`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `food_option` varchar(50) NOT NULL,
  `need_bath` enum('Yes','No') NOT NULL,
  `need_grooming` enum('Yes','No') NOT NULL,
  `remark` text DEFAULT NULL,
  `total_days` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `check_in`, `check_out`, `check_in_time`, `check_out_time`, `food_option`, `need_bath`, `need_grooming`, `remark`, `total_days`, `total_price`, `created_at`) VALUES
(14, 11, '2025-07-16', '2025-07-19', '02:08:00', '01:08:00', 'PawStay Provide', 'Yes', 'No', 'SFSDS', 4, 160.00, '2025-07-11 03:08:24'),
(26, 13, '2025-07-25', '2025-07-29', '14:50:00', '15:49:00', 'Bring Own Food', 'Yes', 'Yes', '', 5, 330.00, '2025-07-15 15:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `daily_slots`
--

CREATE TABLE `daily_slots` (
  `id` int(11) NOT NULL,
  `slot_date` date NOT NULL,
  `slots_left` int(11) NOT NULL DEFAULT 5,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_slots`
--

INSERT INTO `daily_slots` (`id`, `slot_date`, `slots_left`, `updated_at`) VALUES
(10, '2025-07-11', 0, '2025-07-08 09:50:07'),
(11, '2025-07-12', 0, '2025-07-08 09:50:07'),
(12, '2025-07-13', 0, '2025-07-08 09:50:07'),
(13, '2025-07-23', 2, '2025-07-15 13:53:05'),
(14, '2025-07-24', 2, '2025-07-08 13:00:28'),
(15, '2025-07-25', 0, '2025-07-15 15:50:02'),
(16, '2025-07-26', 0, '2025-07-15 15:50:02'),
(17, '2025-07-18', 0, '2025-07-15 09:55:02'),
(18, '2025-07-19', 0, '2025-07-15 13:53:05'),
(19, '2025-07-20', 2, '2025-07-15 13:53:05'),
(20, '2025-07-21', 2, '2025-07-15 13:53:05'),
(21, '2025-07-22', 2, '2025-07-15 13:53:05'),
(22, '2025-07-10', 3, '2025-07-08 13:00:10'),
(23, '2025-07-14', 3, '2025-07-08 13:00:10'),
(24, '2025-07-15', 3, '2025-07-08 13:00:10'),
(25, '2025-07-16', 2, '2025-07-11 03:08:24'),
(26, '2025-07-17', 1, '2025-07-15 09:55:02'),
(27, '2025-07-27', 1, '2025-07-15 15:50:02'),
(28, '2025-07-28', 2, '2025-07-15 15:50:02'),
(29, '2025-07-29', 2, '2025-07-15 15:50:02'),
(30, '2025-07-30', 4, '2025-07-08 13:00:28'),
(31, '2025-07-31', 4, '2025-07-08 13:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `loginusers`
--

CREATE TABLE `loginusers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginusers`
--

INSERT INTO `loginusers` (`id`, `first_name`, `last_name`, `gender`, `phone`, `email`, `birthdate`, `address`) VALUES
(11, 'FDF', 'D', 'Male', '4343', 'DSD@GMAIL.COM', '2025-07-30', 'DFDZF'),
(12, 'Lee', 'jason', 'Male', '0142243611', 'rer@gmail.com', '2025-02-11', '3,JALAN PP 4/1 TAMAN PUTRA PRIMA'),
(13, 'Lim', 'zen', 'Male', '0142243611', 'dasd@gmail.com', '2025-07-02', 'sdasdasds'),
(14, 'sdsa', 'sdad', 'Female', '0142243611', '21076450@imail.sunway.edu.my', '2025-07-04', '3,JALAN PP 4/1 TAMAN PUTRA PRIMA');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pet_name` varchar(100) DEFAULT NULL,
  `pet_age` varchar(10) DEFAULT NULL,
  `pet_species` varchar(100) DEFAULT NULL,
  `pet_breed` varchar(100) DEFAULT NULL,
  `pet_allergy` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `user_id`, `pet_name`, `pet_age`, `pet_species`, `pet_breed`, `pet_allergy`) VALUES
(43, 11, 'DSS12', '12', 'SDSD', 'SDSDSD', ''),
(45, 12, 'Fan Shu', '12', 'Dog', 'Pomeranian', 'Chicken'),
(47, 13, 'dasd', '12', 'dog', 'dsd', 'Chicken'),
(48, 14, 're', '12', 'sdsa', 'dsas', 'dsad'),
(49, 14, 'sddsa', '12', 'sdsa', 'sad', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(10, 'Lim', 'Zen', 'lim.zen1217@gmail.com', '$2y$10$dgp3GIb/VxE0P/HOSJxhC.g.lGj2BEROkgxqiiji8jz/.eNp9mwZq', '2025-07-08 12:59:04'),
(11, 'Lee', 'jason', '21076450@imail.sunway.edu.my', '$2y$10$cps8k2x7fhbGT52VcmMMHu5X7hHRyL/bd17NbFF.v6AZSTNuR9MO2', '2025-07-11 03:06:20'),
(12, 'Lee', 'jason', 'rer@gmail.com', '$2y$10$vrcXK7HjaRETY/9h.37N3eLiuGRLzCV2gJ2bcaZb9xqbFlR80.M7i', '2025-07-15 13:49:45'),
(13, 'Lee', 'jason', 'zen@gmail.com', '$2y$10$1h4TaTmCgFiKSnVFJrbIYeC4niSpQIwoxxL29MQDibhbbYFjjvcFu', '2025-07-15 14:56:48'),
(14, 'Lee', 'jun wei', 'lim@gmail.com', '$2y$10$bPXwbSDNsi7W8ZgGwvTkveeZks3jJ4fnKa420RGCNGHX/NI/bIQKO', '2025-07-18 07:34:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `daily_slots`
--
ALTER TABLE `daily_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slot_date` (`slot_date`);

--
-- Indexes for table `loginusers`
--
ALTER TABLE `loginusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `daily_slots`
--
ALTER TABLE `daily_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `loginusers`
--
ALTER TABLE `loginusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `loginusers` (`id`);

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
