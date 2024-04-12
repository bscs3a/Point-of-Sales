-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 06:57 PM
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
-- Database: `bscs3a`
--
CREATE DATABASE IF NOT EXISTS `bscs3a` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bscs3a`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_ID` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `employee` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_ID`, `username`, `password`, `employee`) VALUES
(1, 'marc', 'admin123', 'David,Marc');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `audit_ID` int(11) NOT NULL,
  `account_ID` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time_in` time NOT NULL DEFAULT current_timestamp(),
  `time_out` time NOT NULL DEFAULT current_timestamp(),
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`audit_ID`, `account_ID`, `date`, `time_in`, `time_out`, `action`) VALUES
(31, 1, '2024-04-11', '22:24:26', '00:00:00', 'Logged In'),
(32, 1, '2024-04-11', '22:24:26', '22:26:50', 'Logged Out'),
(33, 1, '2024-04-11', '22:29:19', '00:00:00', 'Logged In'),
(34, 1, '2024-04-11', '22:29:19', '22:29:26', 'Logged Out'),
(35, 1, '2024-04-11', '22:29:38', '00:00:00', 'Logged In'),
(36, 1, '2024-04-11', '22:29:38', '22:59:46', 'Logged Out'),
(37, 1, '2024-04-11', '23:00:00', '00:00:00', 'Logged In');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL,
  `Category_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `Category_Name`) VALUES
(1, 'Bang'),
(2, 'Bing'),
(3, 'Boom'),
(4, 'Hand Tools');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `Order_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Request_ID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Date_Ordered` date DEFAULT current_timestamp(),
  `Time_Ordered` time DEFAULT current_timestamp(),
  `Order_Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`Order_ID`, `Product_ID`, `Request_ID`, `Supplier_ID`, `Category_ID`, `Date_Ordered`, `Time_Ordered`, `Order_Status`) VALUES
(1, 2, 1, 1, 4, '2024-04-11', '12:39:38', 'Completed'),
(2, 4, 2, 2, 4, '2024-04-11', '12:41:37', 'Completed'),
(3, 4, 3, 2, 4, '2024-04-12', '00:19:41', 'to receive');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `ProductImage` varchar(250) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Supplier` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `DeliveryRequired` varchar(3) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Stocks` int(11) DEFAULT NULL,
  `UnitOfMeasurement` varchar(20) DEFAULT NULL,
  `TaxRate` decimal(5,2) DEFAULT NULL,
  `ProductWeight` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Supplier_ID`, `Category_ID`, `ProductImage`, `ProductName`, `Supplier`, `Description`, `Category`, `DeliveryRequired`, `Price`, `Stocks`, `UnitOfMeasurement`, `TaxRate`, `ProductWeight`) VALUES
(1, 1, 4, 'uploads/hammer.jpg', 'Hammer', 'Edgward Tools', 'A hammer is a tool, most often a hand tool, consisting of a weighted \"head\" fixed to a long handle that is swung to deliver an impact to a small area of an object.', 'Hand Tools', NULL, 250.00, NULL, NULL, NULL, 18.00),
(2, 1, 4, 'uploads/pliers.jpg', 'Pliers', 'Edgward Tools', 'Pliers are a hand tool used to hold objects firmly, possibly developed from tongs used to handle hot metal in Bronze Age Europe.', 'Hand Tools', NULL, 120.00, NULL, NULL, NULL, 8.00),
(3, 2, 3, 'uploads/staple gun.jpg', 'Staple Gun', 'Markiplier Dept', 'A staple gun or powered stapler is a hand-held machine used to drive heavy metal staples into wood, plastic, or masonry.', 'Boom', NULL, 420.00, NULL, NULL, NULL, 12.00),
(4, 2, 4, 'uploads/1.jpg', 'WaterMellon', 'Markiplier Dept', 'Watermellon', 'Hand Tools', NULL, 200.00, NULL, NULL, NULL, 18.00),
(5, 2, 4, 'uploads/drill.jpg', 'Drill', 'Markiplier Dept', 'A drill is a tool used for making round holes or driving fasteners.', 'Hand Tools', NULL, 450.00, NULL, NULL, NULL, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `Request_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Product_Quantity` int(11) DEFAULT NULL,
  `Product_Total_Price` int(11) DEFAULT NULL,
  `Items_Subtotal` int(11) DEFAULT NULL,
  `Total_Amount` int(11) DEFAULT NULL,
  `request_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`Request_ID`, `Product_ID`, `Supplier_ID`, `Product_Quantity`, `Product_Total_Price`, `Items_Subtotal`, `Total_Amount`, `request_Status`) VALUES
(1, 2, 1, 1, 120, NULL, NULL, 'accepted'),
(2, 4, 2, 100, 20000, NULL, NULL, 'accepted'),
(3, 4, 2, 1, 200, NULL, NULL, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `Supplier_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Transcation_ID` int(11) NOT NULL,
  `Supplier_Name` varchar(50) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL,
  `Contact_Number` int(20) DEFAULT NULL,
  `Status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`Supplier_ID`, `Category_ID`, `Transcation_ID`, `Supplier_Name`, `Location`, `Contact_Number`, `Status`) VALUES
(1, 0, 0, 'Edgward Tools', 'xd', 23, 'Active'),
(2, 0, 0, 'Markiplier Dept', 'xd', 123, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `Transaction_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Request_ID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Date_Delivered` date DEFAULT current_timestamp(),
  `Time_Delivered` time DEFAULT current_timestamp(),
  `Order_Status` varchar(50) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Feedback` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`Transaction_ID`, `Order_ID`, `Request_ID`, `Supplier_ID`, `Date_Delivered`, `Time_Delivered`, `Order_Status`, `Rating`, `Feedback`) VALUES
(1, 1, 1, 1, '2024-04-11', '12:40:36', 'Completed', NULL, NULL),
(2, 2, 2, 2, '2024-04-11', '12:41:43', 'Completed', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_ID`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`audit_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`Order_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`Request_ID`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`Transaction_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `audit_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
