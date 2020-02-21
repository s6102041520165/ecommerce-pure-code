-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2020 at 02:15 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activities_heading`
--

CREATE TABLE `tbl_activities_heading` (
  `id` int(11) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_activities_heading`
--

INSERT INTO `tbl_activities_heading` (`id`, `caption`, `description`) VALUES
(3, 'kjklj', 'asfaf\r\nasdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_activity`
--

CREATE TABLE `tbl_sub_activity` (
  `id` int(11) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sub_activity`
--

INSERT INTO `tbl_sub_activity` (`id`, `picture`, `activity_id`) VALUES
(4, 'activity__0.png', 1),
(5, 'activity__1.png', 1),
(6, 'activity__2.jpg', 1),
(11, 'activity_993879131_0.png', 0),
(12, 'activity_993879131_1.png', 0),
(13, 'activity__0.png', 2),
(14, 'activity__1.jpg', 2),
(15, 'activity__0.png', 3),
(16, 'activity__1.png', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activities_heading`
--
ALTER TABLE `tbl_activities_heading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_activity`
--
ALTER TABLE `tbl_sub_activity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activities_heading`
--
ALTER TABLE `tbl_activities_heading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_sub_activity`
--
ALTER TABLE `tbl_sub_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
