-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 29, 2025 at 06:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

CREATE TABLE `chefs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `culinary_school` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chefs`
--

INSERT INTO `chefs` (`id`, `name`, `email`, `contact`, `experience`, `password`, `reset_token`, `reset_token_expiry`, `country`, `culinary_school`, `bio`, `photo`, `facebook_link`, `instagram_link`, `linkedin_link`) VALUES
(30, 'Tagwa bashir kubur', 'tagwaabdullkubur1999915@gmail.com', '0184086720', 444, '$2y$10$96qHtsznNWON9xBBfuUwpOE9Py.cxT98zQ/i5uQY/bY1DWaI9SH3G', NULL, NULL, 'Malaysia', 'nan ', 'hi', NULL, 'https://www.facebook.com/tagwakubur', 'https://www.facebook.com/tagwaKubur', 'https://www.facebook.com/username'),
(35, 'HIII ', 'tagwaabdullkubur1999915WEW@gmail.com', '0184086720', 2, '$2y$10$qAUFcOiSoH6MrUyUkGx/M.VCfyaPGuhxiWhuYXgJq9XY/cycO0982', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

CREATE TABLE `learners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `preferred_cuisine` varchar(100) DEFAULT NULL,
  `skill_level` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learners`
--

INSERT INTO `learners` (`id`, `name`, `email`, `contact`, `password`, `bio`, `preferred_cuisine`, `skill_level`, `photo`) VALUES
(8, 'Tagwa bashir kubur', 'bashirabdulla@graduate.utm.my', '01234567', '$2y$10$D9HtAW4D08CtpKV6mbpR2O7RJOZZjM8hZy72ZvOieZpP3ylf69Vne', NULL, NULL, NULL, NULL),
(18, 'Tagwa bashir kubur', 'tagwaabdullkubur1999915@gmail.com', '0912222', '$2y$10$ZBlF/tbkjsAk07Tn7YpMt.Ak5RddMZ1c.kF8WxLCR0qDRprwxPh5q', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chefs`
--
ALTER TABLE `chefs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chefs`
--
ALTER TABLE `chefs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
