-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 01, 2015 at 07:17 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inkstock`
--
CREATE DATABASE IF NOT EXISTS `inkstock` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `inkstock`;

-- --------------------------------------------------------

--
-- Table structure for table `audittrail`
--

DROP TABLE IF EXISTS `audittrail`;
CREATE TABLE IF NOT EXISTS `audittrail` (
`AID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` text NOT NULL,
  `UserID` int(11) NOT NULL,
  `Printer` text NOT NULL,
  `InkName` text NOT NULL,
  `Cost` float NOT NULL,
  `Department` text NOT NULL,
  `Detail` text NOT NULL,
  `Note` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=551 DEFAULT CHARSET=latin1 COMMENT='Audit data for building reports etc.';

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
`DID` int(11) NOT NULL,
  `Room` text NOT NULL,
  `PID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1 COMMENT='Departments, ';

-- --------------------------------------------------------

--
-- Table structure for table `eod`
--

DROP TABLE IF EXISTS `eod`;
CREATE TABLE IF NOT EXISTS `eod` (
`EODID` int(11) NOT NULL,
  `PID` text NOT NULL,
  `InkName` text NOT NULL,
  `Price` float NOT NULL,
  `Stock` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2749 DEFAULT CHARSET=latin1 COMMENT='Table containing Ink, price and stock data.';

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
`OID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PONO` varchar(20) NOT NULL,
  `OrderArray` text NOT NULL,
  `OrderStatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
CREATE TABLE IF NOT EXISTS `printers` (
`PID` int(11) NOT NULL,
  `PrinterMake` text NOT NULL,
  `PrinterModel` text NOT NULL,
  `SupportLink` text NOT NULL,
  `Colour` tinyint(1) NOT NULL,
  `Media` text NOT NULL,
  `Type` text NOT NULL,
  `Deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COMMENT='Table Containing Printers, used for sorting.';

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
`IID` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `InkName` text NOT NULL,
  `Price` float NOT NULL,
  `Stock` int(11) NOT NULL,
  `StockWarning` int(11) NOT NULL,
  `StockDefault` int(11) NOT NULL,
  `ProductCode` text NOT NULL,
  `Description` text NOT NULL,
  `OrderURL` text NOT NULL,
  `OnOrder` int(11) NOT NULL,
  `UPC` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1 COMMENT='Table containing Ink, price and stock data.';

-- --------------------------------------------------------

--
-- Table structure for table `stockchecks`
--

DROP TABLE IF EXISTS `stockchecks`;
CREATE TABLE IF NOT EXISTS `stockchecks` (
`SCID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `UserID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `OldStock` int(11) NOT NULL,
  `NewStock` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`UserID` int(11) NOT NULL COMMENT 'Auto Incrementing UserID',
  `Email` text NOT NULL,
  `Name` text NOT NULL,
  `Password` text NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Mail` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='User table for Authentication and Auditing';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audittrail`
--
ALTER TABLE `audittrail`
 ADD PRIMARY KEY (`AID`), ADD UNIQUE KEY `AID` (`AID`), ADD KEY `AID_2` (`AID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
 ADD UNIQUE KEY `DID` (`DID`);

--
-- Indexes for table `eod`
--
ALTER TABLE `eod`
 ADD PRIMARY KEY (`EODID`), ADD UNIQUE KEY `IID` (`EODID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`OID`), ADD KEY `OID` (`OID`);

--
-- Indexes for table `printers`
--
ALTER TABLE `printers`
 ADD UNIQUE KEY `PID_3` (`PID`), ADD KEY `PID` (`PID`), ADD KEY `PID_2` (`PID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
 ADD UNIQUE KEY `IID` (`IID`);

--
-- Indexes for table `stockchecks`
--
ALTER TABLE `stockchecks`
 ADD PRIMARY KEY (`SCID`), ADD KEY `SCID` (`SCID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`UserID`), ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audittrail`
--
ALTER TABLE `audittrail`
MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=551;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
MODIFY `DID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `eod`
--
ALTER TABLE `eod`
MODIFY `EODID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2749;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `printers`
--
ALTER TABLE `printers`
MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
MODIFY `IID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `stockchecks`
--
ALTER TABLE `stockchecks`
MODIFY `SCID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=331;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto Incrementing UserID',AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
