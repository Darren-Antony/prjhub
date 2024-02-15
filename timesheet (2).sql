-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 05:57 AM
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
-- Database: `prjdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE `timesheet` (
  `tsId` int(11) NOT NULL,
  `startDate` date DEFAULT NULL,
  `mondayActivity` varchar(255) DEFAULT NULL,
  `tuesdayActivity` varchar(255) DEFAULT NULL,
  `wednesdayActivity` varchar(255) DEFAULT NULL,
  `thursdayActivity` varchar(255) DEFAULT NULL,
  `fridayActivity` varchar(255) DEFAULT NULL,
  `saturdayActivity` varchar(255) DEFAULT NULL,
  `STATUS` varchar(22) DEFAULT NULL,
  `Proj_Id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`tsId`, `startDate`, `mondayActivity`, `tuesdayActivity`, `wednesdayActivity`, `thursdayActivity`, `fridayActivity`, `saturdayActivity`, `STATUS`, `Proj_Id`) VALUES
(4, '2024-02-12', '12', '13', '1', '1', '1', '1', 'pending-approval', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`tsId`),
  ADD KEY `Proj_Id` (`Proj_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `timesheet`
--
ALTER TABLE `timesheet`
  MODIFY `tsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD CONSTRAINT `timesheet_ibfk_1` FOREIGN KEY (`Proj_Id`) REFERENCES `project` (`Prj_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
