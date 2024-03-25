-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2024 at 05:17 PM
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
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customerID` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customerID`, `userID`, `customer_name`) VALUES
(1, 1, 'pki'),
(2, 1, 'pki');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_entry`
--

CREATE TABLE `tbl_entry` (
  `EntryID` int(100) NOT NULL,
  `userID` int(100) NOT NULL,
  `customerID` int(100) NOT NULL,
  `paintID` int(100) NOT NULL,
  `date` date NOT NULL,
  `batchNumber` int(100) NOT NULL,
  `diameter` int(100) NOT NULL,
  `height` int(100) NOT NULL,
  `Initialvolume` double NOT NULL,
  `initialPLiter` double NOT NULL,
  `initialALiter` double NOT NULL,
  `paintRatio` double NOT NULL,
  `acetateRatio` double NOT NULL,
  `NewacetateL` double NOT NULL,
  `NewpaintL` double NOT NULL,
  `sprayViscosity` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `Endingdiameter` int(100) NOT NULL,
  `Endingheight` int(100) NOT NULL,
  `Endingvolume` double NOT NULL,
  `endingPLiter` double NOT NULL,
  `endingALiter` double NOT NULL,
  `EndingpaintRatio` double NOT NULL,
  `EndingacetateRatio` double NOT NULL,
  `totalPLiter` double NOT NULL,
  `totalALiter` double NOT NULL,
  `paintYield` double NOT NULL,
  `acetateYield` double NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_entry`
--

INSERT INTO `tbl_entry` (`EntryID`, `userID`, `customerID`, `paintID`, `date`, `batchNumber`, `diameter`, `height`, `Initialvolume`, `initialPLiter`, `initialALiter`, `paintRatio`, `acetateRatio`, `NewacetateL`, `NewpaintL`, `sprayViscosity`, `quantity`, `Endingdiameter`, `Endingheight`, `Endingvolume`, `endingPLiter`, `endingALiter`, `EndingpaintRatio`, `EndingacetateRatio`, `totalPLiter`, `totalALiter`, `paintYield`, `acetateYield`, `remarks`) VALUES
(2, 1, 2, 2, '2024-03-01', 12345, 15, 10, 28.96, 22.01, 6.95, 0.76, 0.24, 5, 16, 18, 107, 15, 9, 26.06, 19.81, 6.25, 0.76, 0.24, 18.2, 5.7, 5.88, 18.77, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paint`
--

CREATE TABLE `tbl_paint` (
  `paintID` int(100) NOT NULL,
  `supplierID` int(100) NOT NULL,
  `paint_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_paint`
--

INSERT INTO `tbl_paint` (`paintID`, `supplierID`, `paint_color`) VALUES
(2, 2, 'Royal Blue');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplierID` int(100) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `newSupplier_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`supplierID`, `supplier_name`, `newSupplier_name`) VALUES
(2, 'Nippon', 'Nippon');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userID` int(100) NOT NULL,
  `Level` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Contact` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Profile_image` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userID`, `Level`, `Name`, `Username`, `Contact`, `Address`, `Profile_image`, `Email`, `Password`) VALUES
(1, 'Admin', 'Rey June', 'Admin', '09066672527', 'Dayawan, Villanueva, Misamis oriental', 'download.jpg', 'ucabreyjune2001@gmail.com', '1234'),
(2, 'Operator', 'Charismae Dinsay', 'Operator', '09874837938', 'Tambobong', 'sample.jpeg', 'dinsay@gmail.com', '1234');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customerID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_entry`
--
ALTER TABLE `tbl_entry`
  MODIFY `EntryID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_paint`
--
ALTER TABLE `tbl_paint`
  MODIFY `paintID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `supplierID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `CustomeruserID_fk` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_entry`
--
ALTER TABLE `tbl_entry`
  ADD CONSTRAINT `customerID_fk` FOREIGN KEY (`customerID`) REFERENCES `tbl_customer` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
