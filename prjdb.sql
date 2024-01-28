-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2024 at 05:15 PM
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
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `U_Id` int(10) DEFAULT NULL,
  `Guide_Id` varchar(30) NOT NULL,
  `G_Name` varchar(50) DEFAULT NULL,
  `No_of_Students` int(1) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `pfp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Prj_Id` varchar(10) NOT NULL,
  `Stu_Id` varchar(10) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Pr_Name` varchar(50) DEFAULT NULL,
  `Prj_Desc` varchar(300) DEFAULT NULL,
  `Prj_Status` varchar(10) DEFAULT NULL,
  `DOMAIN` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `U_Id` int(10) DEFAULT NULL,
  `DEPT_NO` varchar(10) NOT NULL,
  `Stu_Name` varchar(50) DEFAULT NULL,
  `Dept_Name` varchar(30) DEFAULT NULL,
  `Crr_Year` int(10) DEFAULT NULL,
  `Section` varchar(2) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Degree` varchar(30) DEFAULT NULL,
  `Gender` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`U_Id`, `DEPT_NO`, `Stu_Name`, `Dept_Name`, `Crr_Year`, `Section`, `Guide_Id`, `Degree`, `Gender`) VALUES
(64, '21', 'test1', '21', 0, 'A', NULL, 'Bsc', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `U_Id` int(11) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `OTP` varchar(6) DEFAULT NULL,
  `user_Type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`U_Id`, `Email`, `Password`, `OTP`, `user_Type`) VALUES
(64, 'sty@e.com', '$2y$10$EJNPhG2mxu6r8DzyyTcVXOBEWIp8s1kiLjBEo4tFOBY5y925eGjue', NULL, 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`Guide_Id`),
  ADD KEY `fk_uid_staff` (`U_Id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Prj_Id`),
  ADD KEY `fk_prj_stu` (`Stu_Id`),
  ADD KEY `fk_staff_id` (`Guide_Id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`DEPT_NO`),
  ADD KEY `fk_guide_name` (`Guide_Id`),
  ADD KEY `fk_uid` (`U_Id`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`U_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `U_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guide`
--
ALTER TABLE `guide`
  ADD CONSTRAINT `fk_uid_staff` FOREIGN KEY (`U_Id`) REFERENCES `user_credentials` (`U_Id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_prj_stu` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`DEPT_NO`),
  ADD CONSTRAINT `fk_staff_id` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_guide_name` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`),
  ADD CONSTRAINT `fk_uid` FOREIGN KEY (`U_Id`) REFERENCES `user_credentials` (`U_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
