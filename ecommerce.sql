-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2018 at 05:34 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_card`
--

CREATE TABLE `tbl_card` (
  `orderID` smallint(5) NOT NULL,
  `amount` float(15,2) NOT NULL,
  `datepay` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `catgID` smallint(5) UNSIGNED ZEROFILL NOT NULL,
  `catgName` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`catgID`, `catgName`) VALUES
(00001, 'มาสคาร่า'),
(00002, 'แป้ง');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `detailID` smallint(5) NOT NULL,
  `orderID` smallint(5) NOT NULL,
  `proID` smallint(5) NOT NULL,
  `qty` smallint(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pic_product`
--

CREATE TABLE `tbl_pic_product` (
  `proPicID` smallint(5) NOT NULL,
  `proPicName` varchar(50) NOT NULL,
  `proID` smallint(5) UNSIGNED ZEROFILL NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pic_product`
--

INSERT INTO `tbl_pic_product` (`proPicID`, `proPicName`, `proID`) VALUES
(7, 'product_384460449_1.jpg', 00001),
(6, 'product_384460449_0.jpg', 00001),
(9, 'product_358337402_1.jpg', 00001),
(8, 'product_358337402_0.jpg', 00001),
(10, 'product_211334228_0.jpg', 00001),
(11, 'product_656738281_0.jpg', 00002),
(12, 'product_357788085_0.jpg', 00003),
(13, 'product_357788085_1.jpg', 00003),
(14, 'product_6591796_0.jpg', 00004),
(15, 'product_720245361_0.jpg', 00005),
(16, 'product_720245361_1.jpg', 00005);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`proID`, `proName`, `proPic`, `proDetails`, `proQty`, `proPrice`, `proDate`, `UnitName`, `catgID`) VALUES
(00003, 'เมย์เบลลีน นิวยอร์ก วอลุ่ม เอ็กซ์เพรส ไฮเปอร์เคิร์ล อีซี่ วอช มาสคาร่า 9.2 มล.', 'product357788085.jpg', 'มาสคาร่าสูตรล้างออกง่ายจากเมย์เบลลีน นิวยอร์ก สูตรที่พัฒนาขึ้นเพื่อสาวเอเชียโดยเฉพาะ ช่วยเพิ่มความหนาขนตาขึ้นไปอีก 3 เท่า ล้างออกง่ายและติดทนยาวนานถึง 18 ชม.\r\n\r\nเหตุผลที่ทำให้คุณหลงรัก\r\nช่วยให้ขนตาของคุณสาวๆ โค้งงอนขึ้น 75%\r\nให้ขนตาหนาขึ้น 3 เท่า แบบทันใจอย่างเห็นได้ชัด \r\nขนแปรงแบบพิเศษที่สามารถเข้าถึงขนตาได้แบบเส้นต่อเส้น\r\nเนื้อแว๊กซ์เคลือบขนตาทุกเส้น ตั้งแต่โคนจรดปลาย\r\nจึงให้ความรู้สึกเบาสบาย ไม่หนักตา ไม่จับตัวเป็นก้อน \r\nด้วยสูตร Curl Lock formula ทำให้ขนตาคงความโค้งงอนได้ ยาวนานขึ้น\r\nทนนานตลอดวัน และอยู่ทนนานตลอด 18 ชม.\r\nสูตรล้างออกง่าย ให้สาวๆ ล้างเครื่องสำอางออกได้อย่างง่าย\r\n\r\nประเทศที่ผลิต\r\nจีน\r\n\r\nเลขที่ใบรับแจ้ง\r\n10-2-5519478\r\n\r\nวิธีการใช้งาน\r\n1.ปัดมาสค่าร่าจากขนตาด้านนอกเข้าสู่ขนตาด้านใน\r\n2.ปัดมาสคาร่าช้าๆ จากโคนขนตาสู่ปลายขนตา\r\n3.ระวังอย่าให้แห้งระหว่างปัด\r\n4.สามารถล้างออกง่ายๆ เพียงใช้น้ำอุ่น\r\nจะหน้าเป๊ะ ต้องมีมาสคาร่า เติมเต็มลุคสุดเริดของคุณ ด้วยเมย์เบลลีน นิวยอร์ก วอลุ่ม เอ็กซ์เพรส ไฮเปอร์เคิร์ล อีซี่ วอช ให้คุณเติมแต่งได้เต็มที่ไม่ต้องกังวล ด้วยสูตรที่พัฒนาให้ล้างออกได้อย่างง่ายดาย\r\n\r\nส่วนประกอบ\r\nIsododecane,Ceraalba/Beeswax,Disteardimonium, Hectorite', 17, 99.00, '2018-06-29 17:02:28', 'หน่วย', 1),
(00004, 'Maybelline เมย์เบลลีน จีจี้ ฮาดิด ลาช เซนเซชั่นแนล มาสคาร่า', 'product6591796.jpg', 'มาสคาร่าลิมิเต็ด เอดิชั่นจากจีจี้ ฮาดิดที่มาพร้อมหัวแปรงสุดพิเศษ 10 ชั้นเพื่อขนตาหนา งอน แผ่สวย\r\n\r\nประเทศที่ผลิต\r\nจีน\r\n\r\nเลขที่ใบรับแจ้ง\r\n10-2-6010038267\r\n\r\nวิธีการใช้งาน\r\nปัดขนตาจากโคนจรดปลายโดยใช้แปรงด้านที่เว้าเข้า\r\n\r\nส่วนประกอบ\r\nG995219 INGREDIENTS: DIMETHICONE SYNTHETIC WAX TRIMETHYLSILOXYSILICATE PHENYLPROPYLDIMETHYLSILOXYSILICATE POLYETHYLENE DICALCIUM PHOSPHATE DISILOXANE ALUMINA POLYHYDROXYSTEARIC ACID ASCORBYL PALMITATE BHT CAPRYLYL TRIMETHICONE CITRIC ACID DISTEARDIMONIUM HECTORITE LECITHIN PROPYLENE CARBONATE TOCOPHEROL [+/- MAY CONTAIN / PEUT CONTENIR CI 15850 / RED 6 CI 15850 / RED 7 LAKE CI 17200 / RED 33 LAKE CI 19140 / YELLOW 5 LAKE CI 42090 / BLUE 1 LAKE CI 45410 / RED 28 LAKE CI 77120 / BARIUM SULFATE CI 77491, CI 77492, CI 77499 / IRON OXIDES CI 77742 / MANGANESE VIOLET CI 77891 / TITANIUM DIOXIDE MICA ] F.I.L. D190454/1', 28, 159.00, '2018-06-29 17:02:28', 'หน่วย', 1),
(00005, 'Maybelline เมย์เบลลีน จีจี้ ฮาดิด ดูอัล เอนด์ ไฟเบอร์ มาสคาร่า', 'product720245361.jpg', 'ตาสวยมีเสน่ห์แบบจีจ้ำสร้างได้! ด้วยมาสคาร่าสูตรไฟเบอร์ 2 หัวจากจี้จี้ ฮาดิดเพื่อขนตา หนา ยาว ฟูฟ่องถึงขีดสุดในแค่ 3 สเต็ป !\r\n\r\nประเทศที่ผลิต\r\nจีน\r\n\r\nเลขที่ใบรับแจ้ง\r\n10-2-6010036964\r\n\r\nวิธีการใช้งาน\r\n1 ให้ขนตาหนา โดยปัดด้วยมาสคาร่าสีดำ\r\n2 ต่อขนตาให้ดูยาวขึ้นด้วยไฟเบอร์สีขาว\r\n3 ปัดด้านสีดำซ้ำเพื่อเคลือบให้ขนตาฟูฟ่องขีดสุด\r\n\r\nส่วนประกอบ\r\nFiber : NYLON-66 ●\r\nDIMETHICONE ●\r\nPARAFFINUM LIQUIDUM / MINERAL OIL ●\r\nPHENOXYETHANOL ●\r\nCAPRYLYL GLYCOL ●\r\nETHYLHEXYLGLYCERIN ●\r\nSILICA ●\r\nTOCOPHEROL ●\r\n[+/- MAY CONTAIN\r\nCI 77891 / TITANIUM DIOXIDE ● ]\r\n\r\nMascara: AQUA / WATER ●\r\nACRYLATES/ETHYLHEXYL ACRYLATE COPOLYMER ●\r\nCOPERNICIA CERIFERA CERA / CARNAUBA WAX ●\r\nCERA ALBA / BEESWAX ●\r\nPROPYLENE GLYCOL ●\r\nCYCLOPENTASILOXANE ●\r\nDIMETHICONE ●\r\nISODODECANE ●\r\nPOLYSORBATE 80 ●\r\nGLYCERYL STEARATE SE ●\r\nPROPYLENE GLYCOL STEARATE ●\r\nTRIETHANOLAMINE ●\r\nCYCLOHEXASILOXANE ●\r\nPALMITIC ACID ●\r\nSTEARIC ACID ●\r\nPHENOXYETHANOL ●\r\nCAPRYLYL GLYCOL ●\r\nXANTHAN GUM ●\r\nLAURETH-23 ●\r\nETHYLHEXYLGLYCERIN ●\r\nLAURETH-21 ●\r\nBHT ●\r\nPEG-40 HYDROGENATED CASTOR OIL ●\r\nSTYRENE/ACRYLATES/AMMONIUM METHACRYLATE COPOLYMER ●\r\nARGININE ●\r\nBUTYLENE GLYCOL ●\r\nSODIUM LAURETH SULFATE ●\r\nTETRASODIUM EDTA ●\r\nPOTASSIUM SORBATE ●\r\n[+/- MAY CONTAIN\r\nCI 77266 / BLACK 2 ● ]', 18, 359.00, '2018-06-29 10:07:10', 'หน่วย', 1),
(00006, 'Srichand ศรีจันทร์ ลูมิเนสเซนส์ โกลว์อิ้ง บริเลี่ยนส์ เพอร์เพคติ้ง พาวเดอร์ รีฟิล สี SC10', 'product2899169.jpg', 'แป้งอัดแข็งผสมรองพื้นสูตรพิเศษที่มีเนื้อละเอียดละมุน ช่วยมอบความเนียนนวลให้กับผิวหน้าพร้อมการปกปิดผิวระดับปานกลาง ช่วยให้ผิวของคุณแลดูเปล่งประกายอย่างเป็นธรรมชาติตลอดวัน ด้วยวัตถุดิบคุณภาพสูงที่ผ่านการคัดสรรจากทั่วโลก ทำให้ได้แป้งผสมรองพื้นสูตรควบคุมความมันที่เหมาะสำหรับผู้หญิงเอเชียที่มีผิวมันหรือผิวผสม เมื่อใช้พัฟเนื้อดีของเราจะช่วยให้การทาและเกลี่ยอณูแป้งให้กระจายตัวเกาะติดผิวหน้าของคุณได้ดียิ่งขึ้น\r\n\r\nSPF 20 PA+++ ปราศจากน้ำหอมและ พาราเบน ผ่านการทดสอบการระคายเคือง\r\n\r\nประเทศที่ผลิต\r\nญี่ปุ่น', 18, 117.00, '2018-06-30 10:32:23', 'หน่วย', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE `tbl_rating` (
  `username` varchar(30) NOT NULL,
  `proID` smallint(5) NOT NULL,
  `rating` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `password` varchar(32) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`username`, `password`, `name`, `surname`, `profiles`, `email`, `tel`, `addr`, `locality`, `district`, `province`, `zipcode`, `level`) VALUES
('admin', '81dc9bdb52d04dc20036dbd8313ed055', '', '', '', '', '', '', '', '', '', '', 'admin');

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
  MODIFY `orderID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `detailID` smallint(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_pic_product`
--
ALTER TABLE `tbl_pic_product`
  MODIFY `proPicID` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `proID` smallint(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `reviewsID` smallint(5) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
