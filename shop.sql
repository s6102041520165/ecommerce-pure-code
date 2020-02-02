-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2020 at 08:13 PM
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
-- Table structure for table `tbl_card`
--

CREATE TABLE `tbl_card` (
  `orderID` smallint(5) NOT NULL,
  `amount` float(15,2) NOT NULL,
  `datepay` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `catgID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `catgName` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`catgID`, `catgName`) VALUES
(00001, 'test1'),
(00002, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `orderID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `username` varchar(30) NOT NULL,
  `payoption` set('card','bank') NOT NULL,
  `status` set('no','yes') NOT NULL,
  `dateOrder` datetime NOT NULL,
  `tracking` varchar(20) NOT NULL,
  `proTotal` float(15,2) NOT NULL,
  `tax` float(15,2) NOT NULL,
  `sumtotal` float(15,2) NOT NULL,
  `showOrder` set('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`orderID`, `username`, `payoption`, `status`, `dateOrder`, `tracking`, `proTotal`, `tax`, `sumtotal`, `showOrder`) VALUES
(00001, 'admin', 'bank', 'no', '2020-02-02 16:38:06', '', 198.00, 13.86, 211.86, 'no'),
(00002, 'admin', 'bank', 'no', '2020-02-02 18:17:31', '', 99.00, 6.93, 105.93, 'no'),
(00003, 'admin', 'bank', 'no', '2020-02-02 19:27:13', 'EF582568151TH', 518.00, 36.26, 554.26, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `detailID` smallint(5) NOT NULL,
  `orderID` smallint(5) NOT NULL,
  `proID` smallint(5) NOT NULL,
  `qty` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`detailID`, `orderID`, `proID`, `qty`) VALUES
(1, 1, 3, 2),
(2, 2, 3, 1),
(3, 3, 4, 1),
(4, 3, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `orderID` smallint(5) NOT NULL,
  `bank` tinytext NOT NULL,
  `location` tinytext NOT NULL,
  `amount` float(15,2) NOT NULL,
  `datepay` datetime NOT NULL,
  `status` set('no','yes') NOT NULL,
  `slipe` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pic_product`
--

CREATE TABLE `tbl_pic_product` (
  `proPicID` smallint(5) NOT NULL,
  `proPicName` varchar(50) NOT NULL,
  `proID` smallint(5) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pic_product`
--

INSERT INTO `tbl_pic_product` (`proPicID`, `proPicName`, `proID`) VALUES
(6, 'product_384460449_0.jpg', 00001),
(7, 'product_384460449_1.jpg', 00001),
(8, 'product_358337402_0.jpg', 00001),
(9, 'product_358337402_1.jpg', 00001),
(10, 'product_211334228_0.jpg', 00001),
(11, 'product_656738281_0.jpg', 00002),
(12, 'product_357788085_0.jpg', 00003),
(13, 'product_357788085_1.jpg', 00003),
(14, 'product_6591796_0.jpg', 00004),
(15, 'product_720245361_0.jpg', 00005),
(16, 'product_720245361_1.jpg', 00005),
(17, 'product_603506270_0.png', 00007),
(18, 'product_603506270_1.png', 00007),
(19, 'product_603506270_2.png', 00007);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `proID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `proName` varchar(150) NOT NULL,
  `proPic` varchar(30) NOT NULL,
  `proDetails` text NOT NULL,
  `proQty` smallint(5) NOT NULL,
  `proPrice` float(15,2) NOT NULL,
  `proDate` datetime NOT NULL,
  `UnitName` varchar(50) NOT NULL COMMENT 'ชื่อหน่วย',
  `catgID` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`proID`, `proName`, `proPic`, `proDetails`, `proQty`, `proPrice`, `proDate`, `UnitName`, `catgID`) VALUES
(00007, 'test01', 'product603506270.png', 'test', 20, 50.00, '2020-02-03 01:35:19', 'ก้อน', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `username` varchar(30) NOT NULL,
  `proID` smallint(5) NOT NULL,
  `rating` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`username`, `proID`, `rating`) VALUES
('admin', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `reviewsID` smallint(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `proID` smallint(5) NOT NULL,
  `comment` text NOT NULL,
  `DateReviews` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store`
--

CREATE TABLE `tbl_store` (
  `storeID` smallint(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `addr` text NOT NULL,
  `locality` varchar(50) NOT NULL COMMENT 'ตำบล',
  `district` varchar(50) NOT NULL COMMENT 'อำเภอ',
  `province` varchar(50) NOT NULL COMMENT 'จังหวัด',
  `zipcode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_store`
--

INSERT INTO `tbl_store` (`storeID`, `name`, `surname`, `email`, `tel`, `addr`, `locality`, `district`, `province`, `zipcode`) VALUES
(1, '-', '-', 'bboy.06gg@gmail.com', '0811383633', '248 วิทยาลัยเทคนิคพัทลุง', 'คูหาสวรรค์', 'เมือง', 'พัทลุง', '93000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `profiles` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `addr` text NOT NULL,
  `locality` varchar(50) NOT NULL COMMENT 'ตำบล',
  `district` varchar(50) NOT NULL COMMENT 'อำเภอ',
  `province` varchar(50) NOT NULL COMMENT 'จังหวัด',
  `zipcode` varchar(10) NOT NULL,
  `level` set('member','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`username`, `password`, `name`, `surname`, `profiles`, `email`, `tel`, `addr`, `locality`, `district`, `province`, `zipcode`, `level`) VALUES
('admin', '$2y$10$JxuWo2u7gtucxQLzhCo4oe2rmTPykfhb8i7N2.lc.AcfMZdo2l/Ie', 'นายวีรชัย', 'ปลอดแก้ว', '', 'bboy.06gg@gmail.com', '0811383633', 'กก', 'นาโหนด', 'เมือง', 'พัทลุง', '93000', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_card`
--
ALTER TABLE `tbl_card`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`catgID`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`detailID`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `tbl_pic_product`
--
ALTER TABLE `tbl_pic_product`
  ADD PRIMARY KEY (`proPicID`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`proID`);

--
-- Indexes for table `tbl_rating`
--
ALTER TABLE `tbl_rating`
  ADD PRIMARY KEY (`username`,`proID`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`reviewsID`);

--
-- Indexes for table `tbl_store`
--
ALTER TABLE `tbl_store`
  ADD PRIMARY KEY (`storeID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `catgID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `orderID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `detailID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_pic_product`
--
ALTER TABLE `tbl_pic_product`
  MODIFY `proPicID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `proID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `reviewsID` smallint(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
