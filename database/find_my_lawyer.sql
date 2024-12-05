-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 04:01 PM
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
-- Database: `find_my_lawyer`
--

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_appointment`
--

CREATE TABLE `confirmed_appointment` (
  `id` int(255) NOT NULL,
  `lawyer_email` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `confirmed_appointment`
--

INSERT INTO `confirmed_appointment` (`id`, `lawyer_email`, `client_email`, `client_name`, `client_phone`, `note`, `date`) VALUES
(1, 'nowshin@gmail.com', 'abdmgalib2001@gmail.com', 'Abdullah Mohammad Galib', '01518784990', 'hello this is a test note....', '2024-12-29'),
(2, 'nowshin@gmail.com', 'abdmgalib2001@gmail.com', 'Abdullah Mohammad Galib', '01518784990', 'Test 2', '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `general_user`
--

CREATE TABLE `general_user` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `district` varchar(50) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_user`
--

INSERT INTO `general_user` (`id`, `name`, `email`, `district`, `phone`) VALUES
(1, 'Abdullah Mohammad Galib', 'abdmgalib2001@gmail.com', 'Chattogram', '01518784990');

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_user`
--

CREATE TABLE `lawyer_user` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `education` text NOT NULL,
  `district` varchar(50) NOT NULL,
  `expertise` varchar(100) NOT NULL,
  `experience` int(50) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lawyer_user`
--

INSERT INTO `lawyer_user` (`id`, `name`, `email`, `phone`, `education`, `district`, `expertise`, `experience`, `address`) VALUES
(3, 'Nowshin Tabassum', 'nowshin@gmail.com', '01518784990', 'LLB(hon\'s), LLM\r\nPort City International University', 'Chattogram', 'Environmental', 5, 'Random Street, Random City'),
(4, 'Saiful Alom', 'saiful@gmail.com', '01815140095', 'LLB, LLM\r\nChittagong University', 'Dhaka', 'Criminal', 2, '123 Annex Budling, Chittagong Court Building, Chittagong ');

-- --------------------------------------------------------

--
-- Table structure for table `request_appointment`
--

CREATE TABLE `request_appointment` (
  `id` int(255) NOT NULL,
  `lawyer_email` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_note` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_appointment`
--

INSERT INTO `request_appointment` (`id`, `lawyer_email`, `client_email`, `client_phone`, `client_name`, `client_note`, `status`, `date`) VALUES
(1, 'nowshin@gmail.com', 'abdmgalib2001@gmail.com', '01518784990', 'Abdullah Mohammad Galib', 'hello this is a test note....', 'approved', '2024-12-29'),
(2, 'nowshin@gmail.com', 'abdmgalib2001@gmail.com', '01518784990', 'Abdullah Mohammad Galib', 'Test 2', 'approved', '2024-12-05'),
(3, 'nowshin@gmail.com', 'abdmgalib2001@gmail.com', '01518784990', 'Abdullah Mohammad Galib', 'Test 3', 'rejected', '2024-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`id`, `email`, `password`, `confirm_password`, `user_type`) VALUES
(1, 'abdmgalib2001@gmail.com', '$2y$10$dx5UTfX5Lph6A78/zlVWUeSrQ3iWgLWoOz.16D6dxq2Bdh2gbtAbm', '$2y$10$dx5UTfX5Lph6A78/zlVWUeSrQ3iWgLWoOz.16D6dxq2Bdh2gbtAbm', 'general_user'),
(3, 'nowshin@gmail.com', '$2y$10$8lJbMnigiZPAkffSYQOfH.tmlq6wqkqPTDklV7uhHUA90gVqnIc8O', '$2y$10$8lJbMnigiZPAkffSYQOfH.tmlq6wqkqPTDklV7uhHUA90gVqnIc8O', 'lawyer_user'),
(4, 'saiful@gmail.com', '$2y$10$iiVJ8Hp6wB3rcYEEnlfMsOWmcAR3/acT6KnuKM9PlW/Os5DrYNdR.', '$2y$10$iiVJ8Hp6wB3rcYEEnlfMsOWmcAR3/acT6KnuKM9PlW/Os5DrYNdR.', 'lawyer_user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `confirmed_appointment`
--
ALTER TABLE `confirmed_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_user`
--
ALTER TABLE `general_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lawyer_user`
--
ALTER TABLE `lawyer_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_appointment`
--
ALTER TABLE `request_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `confirmed_appointment`
--
ALTER TABLE `confirmed_appointment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_user`
--
ALTER TABLE `general_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lawyer_user`
--
ALTER TABLE `lawyer_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request_appointment`
--
ALTER TABLE `request_appointment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
