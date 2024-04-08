-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 07:09 AM
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
-- Database: `dbpayms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acetatereport`
--

CREATE TABLE `tbl_acetatereport` (
  `acetateReportID` int(25) NOT NULL,
  `userID` int(25) NOT NULL,
  `Date` date NOT NULL,
  `Beginning` int(25) NOT NULL,
  `Withdrawal` int(25) NOT NULL,
  `ProductPUsage` int(25) NOT NULL,
  `Cleaning` int(25) NOT NULL,
  `Remaining` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_acetatereport`
--

INSERT INTO `tbl_acetatereport` (`acetateReportID`, `userID`, `Date`, `Beginning`, `Withdrawal`, `ProductPUsage`, `Cleaning`, `Remaining`) VALUES
(21, 2, '2024-03-01', 400, 0, 100, 50, 250),
(22, 2, '2024-03-02', 250, 100, 50, 100, 200),
(23, 2, '2024-03-03', 200, 0, 50, 5, 145),
(24, 2, '2024-03-04', 145, 100, 100, 50, 90),
(25, 2, '2024-03-04', 95, 100, 50, 55, 90);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customerID` int(25) NOT NULL,
  `userID` int(25) NOT NULL,
  `customer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customerID`, `userID`, `customer_name`) VALUES
(3, 1, 'PKI'),
(4, 1, 'PKI'),
(5, 1, 'PKI'),
(6, 1, 'PKI'),
(7, 1, 'PKI'),
(8, 2, 'pki'),
(9, 1, 'PKI'),
(10, 2, 'KKK'),
(11, 1, 'KKK'),
(12, 1, 'KKK'),
(13, 1, 'KKK'),
(14, 1, 'KKK'),
(15, 1, 'KKK'),
(16, 2, 'pki'),
(17, 1, 'KKK'),
(18, 2, 'KKK'),
(19, 2, 'KKK'),
(20, 2, 'KKK'),
(21, 1, 'KKK'),
(22, 1, 'KKK'),
(23, 1, 'KKK'),
(24, 1, 'KKK'),
(25, 1, 'KKK'),
(26, 2, 'PKI'),
(27, 1, 'KKK'),
(28, 1, 'KKK'),
(29, 1, 'KKK'),
(30, 1, 'KKK'),
(31, 1, 'KKK'),
(32, 2, 'KK'),
(33, 2, 'KK');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_entry`
--

CREATE TABLE `tbl_entry` (
  `EntryID` int(25) NOT NULL,
  `userID` int(25) NOT NULL,
  `customerID` int(25) NOT NULL,
  `paintID` int(25) NOT NULL,
  `date` date NOT NULL,
  `batchNumber` int(25) NOT NULL,
  `diameter` int(25) NOT NULL,
  `height` int(25) NOT NULL,
  `Initialvolume` double NOT NULL,
  `initialPLiter` double NOT NULL,
  `initialALiter` double NOT NULL,
  `paintRatio` double NOT NULL,
  `acetateRatio` double NOT NULL,
  `NewacetateL` double NOT NULL,
  `NewpaintL` double NOT NULL,
  `sprayViscosity` int(25) NOT NULL,
  `quantity` int(25) NOT NULL,
  `Endingdiameter` int(25) NOT NULL,
  `Endingheight` int(25) NOT NULL,
  `Endingvolume` double NOT NULL,
  `endingPLiter` double NOT NULL,
  `endingALiter` double NOT NULL,
  `EndingpaintRatio` double NOT NULL,
  `EndingacetateRatio` double NOT NULL,
  `totalPLiter` double NOT NULL,
  `totalALiter` double NOT NULL,
  `paintYield` double NOT NULL,
  `acetateYield` double NOT NULL,
  `remarks` varchar(25) NOT NULL,
  `totalEntries` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_entry`
--

INSERT INTO `tbl_entry` (`EntryID`, `userID`, `customerID`, `paintID`, `date`, `batchNumber`, `diameter`, `height`, `Initialvolume`, `initialPLiter`, `initialALiter`, `paintRatio`, `acetateRatio`, `NewacetateL`, `NewpaintL`, `sprayViscosity`, `quantity`, `Endingdiameter`, `Endingheight`, `Endingvolume`, `endingPLiter`, `endingALiter`, `EndingpaintRatio`, `EndingacetateRatio`, `totalPLiter`, `totalALiter`, `paintYield`, `acetateYield`, `remarks`, `totalEntries`) VALUES
(3, 1, 3, 3, '2024-03-04', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(4, 1, 4, 4, '2024-03-07', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(5, 1, 5, 5, '2024-03-08', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(6, 1, 6, 6, '2024-03-05', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(7, 1, 7, 7, '2024-03-06', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 16, 5, 6.69, 21.4, '', 0),
(8, 2, 8, 8, '2024-03-11', 1232, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 24, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(9, 1, 9, 9, '2024-03-09', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(10, 2, 10, 10, '2024-03-20', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(11, 1, 11, 11, '2024-03-27', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(12, 1, 12, 12, '2024-03-13', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(13, 1, 13, 13, '2024-03-12', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(14, 1, 14, 14, '2024-03-15', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(15, 1, 15, 15, '2024-03-14', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(16, 2, 16, 16, '2024-03-23', 1232, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 24, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(17, 1, 17, 17, '2024-03-22', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(18, 2, 18, 18, '2024-03-16', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(19, 2, 19, 19, '2024-03-26', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(20, 2, 20, 20, '2024-03-19', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(21, 1, 21, 21, '2024-03-18', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(22, 1, 22, 22, '2024-03-25', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(23, 1, 23, 23, '2024-03-21', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, 'Success', 0),
(24, 1, 24, 24, '2024-03-29', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, 'Success!', 0),
(25, 1, 25, 25, '2024-03-28', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, 'Success', 0),
(26, 2, 26, 26, '2024-04-01', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 25, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '', 0),
(27, 1, 27, 27, '2024-04-02', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 10, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 0.55, 1.75, 'Success', 0),
(28, 1, 28, 28, '2024-04-03', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, 'Success', 0),
(29, 1, 29, 29, '2024-04-04', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 10, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 0.55, 1.75, 'Success', 0),
(30, 1, 30, 30, '2024-04-05', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, 'Success', 0),
(31, 1, 31, 31, '2024-04-06', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 0, 0, 5.88, 18.77, 'Success', 0),
(33, 2, 33, 33, '2024-04-06', 2323423, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 32, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 0, 0, 5.88, 18.77, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paint`
--

CREATE TABLE `tbl_paint` (
  `paintID` int(25) NOT NULL,
  `supplierID` int(25) NOT NULL,
  `paint_color` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_paint`
--

INSERT INTO `tbl_paint` (`paintID`, `supplierID`, `paint_color`) VALUES
(3, 3, 'Clear'),
(4, 4, 'Golden Brown'),
(5, 5, 'Buff'),
(6, 6, 'Deft Blue'),
(7, 7, 'White'),
(8, 8, 'Black'),
(9, 9, 'Alpha Gray'),
(10, 10, 'Nile Green'),
(11, 11, 'Emerald Green'),
(12, 12, 'Jade Green'),
(13, 13, 'Royal Blue'),
(14, 14, 'Deft Blue'),
(15, 15, 'Buff'),
(16, 16, 'Golden Brown'),
(17, 17, 'Pulsating Blue'),
(18, 18, 'Black'),
(19, 19, 'Black'),
(20, 20, 'Black'),
(21, 21, 'White'),
(22, 22, 'Deft Blue'),
(23, 23, 'Pulsating Blue'),
(24, 24, 'Royal Blue'),
(25, 25, 'Golden Brown'),
(26, 26, 'Golden Brown'),
(27, 27, 'Buff'),
(28, 28, 'Pulsating Blue'),
(29, 29, 'Royal Blue'),
(30, 30, 'Alpha Gray'),
(31, 31, 'Black'),
(33, 33, 'Deft Blue');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplierID` int(25) NOT NULL,
  `supplier_name` varchar(25) NOT NULL,
  `newSupplier_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`supplierID`, `supplier_name`, `newSupplier_name`) VALUES
(3, 'Nippon', 'Nippon'),
(4, 'Nippon', 'Nippon'),
(5, 'Nippon', 'Nippon'),
(6, 'Nippon', 'Nippon'),
(7, 'Treasure Island', 'Nippon'),
(8, 'Inkote', 'Nippon'),
(9, 'Inkote', 'Inkote'),
(10, 'Treasure Island', 'Treasure Island'),
(11, 'Treasure Island', 'Treasure Island'),
(12, 'Nippon', 'Century'),
(13, 'Nippon', 'Nippon'),
(14, 'Treasure Island', 'Inkote'),
(15, 'Treasure Island', 'Inkote'),
(16, 'Century', 'Treasure Island'),
(17, 'Treasure Island', 'Treasure Island'),
(18, 'Treasure Island', 'Century'),
(19, 'Treasure Island', 'Century'),
(20, 'Treasure Island', 'Century'),
(21, 'Treasure Island', 'Treasure Island'),
(22, 'Treasure Island', 'Treasure Island'),
(23, 'Inkote', 'Treasure Island'),
(24, 'Nippon', 'Nippon'),
(25, 'Treasure Island', 'Treasure Island'),
(26, 'Treasure Island', 'Treasure Island'),
(27, 'Century', 'Inkote'),
(28, 'Treasure Island', 'Century'),
(29, 'Treasure Island', 'Inkote'),
(30, 'Treasure Island', 'Treasure Island'),
(31, 'Inkote', 'Inkote'),
(33, 'Treasure Island', 'Inkote');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userID` int(25) NOT NULL,
  `Level` varchar(25) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Contact` varchar(25) NOT NULL,
  `Address` varchar(25) NOT NULL,
  `Profile_image` varchar(25) NOT NULL,
  `Email` varchar(25) NOT NULL,
  `Password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userID`, `Level`, `Name`, `Username`, `Contact`, `Address`, `Profile_image`, `Email`, `Password`) VALUES
(1, 'Admin', 'Rey June Ucab', 'Admin', '09066672527', 'Dayawan, Villanueva, Misa', 'download.jpg', 'ucabreyjune2001@gmail.com', '1234'),
(2, 'Operator', 'Charismae Dinsay', 'Operator', '09874837938', 'Tambobong', 'sample.jpeg', 'dinsay@gmail.com', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_acetatereport`
--
ALTER TABLE `tbl_acetatereport`
  ADD PRIMARY KEY (`acetateReportID`),
  ADD KEY `acetateUserID_fk` (`userID`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `CustomeruserID_fk` (`userID`);

--
-- Indexes for table `tbl_entry`
--
ALTER TABLE `tbl_entry`
  ADD PRIMARY KEY (`EntryID`),
  ADD KEY `userID_fk` (`userID`),
  ADD KEY `customerID_fk` (`customerID`),
  ADD KEY `paintID_fk` (`paintID`);

--
-- Indexes for table `tbl_paint`
--
ALTER TABLE `tbl_paint`
  ADD PRIMARY KEY (`paintID`),
  ADD KEY `supplierID_fk` (`supplierID`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`supplierID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_acetatereport`
--
ALTER TABLE `tbl_acetatereport`
  MODIFY `acetateReportID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customerID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_entry`
--
ALTER TABLE `tbl_entry`
  MODIFY `EntryID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_paint`
--
ALTER TABLE `tbl_paint`
  MODIFY `paintID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `supplierID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_acetatereport`
--
ALTER TABLE `tbl_acetatereport`
  ADD CONSTRAINT `acetateUser_fk` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_entry`
--
ALTER TABLE `tbl_entry`
  ADD CONSTRAINT `customerID_fk` FOREIGN KEY (`customerID`) REFERENCES `tbl_customer` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paintID_fk` FOREIGN KEY (`paintID`) REFERENCES `tbl_paint` (`paintID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID_fk` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_paint`
--
ALTER TABLE `tbl_paint`
  ADD CONSTRAINT `supplierID_fk` FOREIGN KEY (`supplierID`) REFERENCES `tbl_supplier` (`supplierID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
