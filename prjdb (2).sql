-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 05:50 AM
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
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Cmt_Id` int(11) NOT NULL,
  `Sender_Id` int(11) DEFAULT NULL,
  `Receiver_Id` int(11) DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `U_Id` int(10) DEFAULT NULL,
  `Guide_Id` varchar(30) NOT NULL,
  `G_Name` varchar(50) DEFAULT NULL,
  `No_of_Students` int(1) DEFAULT NULL,
  `Gender` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guide`
--

INSERT INTO `guide` (`U_Id`, `Guide_Id`, `G_Name`, `No_of_Students`, `Gender`) VALUES
(123, 's11', 'Sree', 1, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `Noti_Id` int(10) NOT NULL,
  `Sender_Id` int(11) DEFAULT NULL,
  `Receiver_Id` int(11) DEFAULT NULL,
  `Message` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Prj_Id` varchar(10) NOT NULL,
  `Stu_Id` varchar(10) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Prj_Name` varchar(50) DEFAULT NULL,
  `Prj_Desc` varchar(300) DEFAULT NULL,
  `Prj_Status` varchar(20) DEFAULT NULL,
  `Date_of_Submission` date DEFAULT NULL,
  `Time_of_Submission` time DEFAULT NULL,
  `rejection_reason` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`Prj_Id`, `Stu_Id`, `Guide_Id`, `Prj_Name`, `Prj_Desc`, `Prj_Status`, `Date_of_Submission`, `Time_of_Submission`, `rejection_reason`) VALUES
('1', 'Computer S', 's11', 'nj', 'mk', 'In-Progress', '2024-02-11', '08:08:50', 'no ne');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Review_Id` int(11) NOT NULL,
  `Prj_id` varchar(10) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Date_of_Review` date DEFAULT NULL,
  `Time_of_Review` time DEFAULT NULL,
  `Review1_Mark` float DEFAULT NULL,
  `Review2_Mark` float DEFAULT NULL,
  `Review3_Mark` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Review_Id`, `Prj_id`, `Guide_Id`, `Date_of_Review`, `Time_of_Review`, `Review1_Mark`, `Review2_Mark`, `Review3_Mark`) VALUES
(6, '1', NULL, NULL, NULL, 109, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `U_Id` int(10) DEFAULT NULL,
  `Dept_No` varchar(10) NOT NULL,
  `Stu_Name` varchar(50) DEFAULT NULL,
  `Dept_Name` varchar(30) DEFAULT NULL,
  `Cur_Year` int(10) DEFAULT NULL,
  `Section` varchar(2) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Degree` varchar(30) DEFAULT NULL,
  `Gender` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`U_Id`, `Dept_No`, `Stu_Name`, `Dept_Name`, `Cur_Year`, `Section`, `Guide_Id`, `Degree`, `Gender`) VALUES
(1215, 'Computer S', 'Darren Christopher Antony', 'Computer Science', 0, 'B', 's11', 'Bsc', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `U_Id` int(11) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `OTP` varchar(6) DEFAULT NULL,
  `User_Type` varchar(10) DEFAULT NULL,
  `D.O.B` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`U_Id`, `Email`, `Password`, `OTP`, `User_Type`, `D.O.B`) VALUES
(123, 'staff1@gmail.com', '$2y$10$4mQMJj8aEluxTT3/pc4WyeImIwTcD9QcFnbjeoUy02v2EygUrjePi', NULL, 'Guide', NULL),
(1215, 'darrenca007@gmail.com', '$2y$10$4mQMJj8aEluxTT3/pc4WyeImIwTcD9QcFnbjeoUy02v2EygUrjePi', NULL, 'student', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Cmt_Id`),
  ADD KEY `sender_id` (`Sender_Id`),
  ADD KEY `receiver_id` (`Receiver_Id`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`Guide_Id`),
  ADD KEY `fk_uid_staff` (`U_Id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`Noti_Id`),
  ADD KEY `Sender_Id` (`Sender_Id`),
  ADD KEY `Recevier_Id` (`Receiver_Id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Prj_Id`),
  ADD KEY `fk_prj_stu` (`Stu_Id`),
  ADD KEY `fk_staff_id` (`Guide_Id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_Id`),
  ADD KEY `Prj_id` (`Prj_id`),
  ADD KEY `Guide_Id` (`Guide_Id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Dept_No`),
  ADD KEY `fk_guide_name` (`Guide_Id`),
  ADD KEY `fk_uid` (`U_Id`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`U_Id`),
  ADD UNIQUE KEY `unique_email` (`Email`),
  ADD UNIQUE KEY `unique_otp` (`OTP`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Cmt_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Noti_Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `U_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1216;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`Sender_Id`) REFERENCES `user_credentials` (`U_Id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`Receiver_Id`) REFERENCES `user_credentials` (`U_Id`);

--
-- Constraints for table `guide`
--
ALTER TABLE `guide`
  ADD CONSTRAINT `fk_uid_staff` FOREIGN KEY (`U_Id`) REFERENCES `user_credentials` (`U_Id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`Sender_Id`) REFERENCES `user_credentials` (`U_Id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`Receiver_Id`) REFERENCES `user_credentials` (`U_Id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_prj_stu` FOREIGN KEY (`Stu_Id`) REFERENCES `student` (`Dept_No`),
  ADD CONSTRAINT `fk_staff_id` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Prj_id`) REFERENCES `project` (`Prj_Id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`);

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
