-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 08:03 PM
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
  `Time` time DEFAULT NULL,
  `prj_Id` int(10) DEFAULT NULL
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
(123, 's11', 'Sree', 4, 'M');

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
  `Prj_Id` int(10) NOT NULL,
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
(2, '108', 's11', 'Academic project tracker', 'it is a website academic projects', 'In-Progress', '2024-02-15', '18:20:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Review_Id` int(11) NOT NULL,
  `Prj_id` int(10) DEFAULT NULL,
  `Guide_Id` varchar(30) DEFAULT NULL,
  `Review1_Mark` float DEFAULT NULL,
  `Review2_Mark` float DEFAULT NULL,
  `Review3_Mark` float DEFAULT NULL,
  `Review1_Date` date DEFAULT NULL,
  `Review2_Date` date DEFAULT NULL,
  `Review3_Date` date DEFAULT NULL,
  `Rv1_fdback` varchar(255) NOT NULL,
  `Rv2_fdback` varchar(255) NOT NULL,
  `Rv3_fdback` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Review_Id`, `Prj_id`, `Guide_Id`, `Review1_Mark`, `Review2_Mark`, `Review3_Mark`, `Review1_Date`, `Review2_Date`, `Review3_Date`, `Rv1_fdback`, `Rv2_fdback`, `Rv3_fdback`) VALUES
(8, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vghfcfcfgfcg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `review_doc`
--

CREATE TABLE `review_doc` (
  `Doc_Id` int(10) NOT NULL,
  `rv_Id` int(11) DEFAULT NULL,
  `Prj_Id` int(10) DEFAULT NULL,
  `Doc_Name` varchar(255) DEFAULT NULL,
  `Doc_Path` varchar(255) NOT NULL,
  `review_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_doc`
--

INSERT INTO `review_doc` (`Doc_Id`, `rv_Id`, `Prj_Id`, `Doc_Name`, `Doc_Path`, `review_no`) VALUES
(24, 8, 2, '../../../uploads/1st REVIEW  REPORT.pdf', '1st REVIEW  REPORT.pdf', 1);

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
(1220, '108', 'darren antony', 'Computer Science', 3, 'B', 's11', 'Bsc', 'M'),
(1229, '12121', 'wqdyqy', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1226, '1213131', 'jkhaskh', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1225, '12212', 'hdkje', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1227, '123123', 'dqhjdhj', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1219, '146', 'john Bilkeds', 'Computer Science', 3, 'B', 's11', 'Bsc', 'M'),
(1221, '147', 'Gladson', 'Computer Science', 3, 'B', 's11', 'Bsc', 'M'),
(1222, '152', 'karthik', 'Computer Science', 3, 'B', NULL, 'Bsc', 'M'),
(1224, '21323', 'xsx', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1228, '231232', 'dhk', 'Computer Science', 1, 'A', NULL, 'Bsc', 'M'),
(1215, 'Computer S', 'Darren Christopher Antony', 'Computer Science', 3, 'B', 's11', 'Bsc', 'M');

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
  `Proj_Id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timesheet`
--

INSERT INTO `timesheet` (`tsId`, `startDate`, `mondayActivity`, `tuesdayActivity`, `wednesdayActivity`, `thursdayActivity`, `fridayActivity`, `saturdayActivity`, `STATUS`, `Proj_Id`) VALUES
(9, '2024-02-12', '1', '1', '1', '11', '1', '1', 'approved', 2);

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
(1215, 'darrenca007@gmail.com', '$2y$10$4mQMJj8aEluxTT3/pc4WyeImIwTcD9QcFnbjeoUy02v2EygUrjePi', NULL, 'student', NULL),
(1219, 'jb@g.com', '$2y$10$qf2wZ4xr1uOwuGVANWKwo.1Vx7u4qY332yxputoOXt5js/1hiznFi', NULL, 'student', NULL),
(1220, 'darren@g.com', '$2y$10$iU7r89UoFkNJFgK8BgHzbOX0Uj6rzyK5nvfB/vi./k5MHZE2qS4fC', NULL, 'student', NULL),
(1221, 'glad@g.com', '$2y$10$oThKPuPNF5ANK9kBd6q2xOny1OYvbAezFILPn.l8uzlF3R1t86oSi', NULL, 'student', NULL),
(1222, 'karthik1@gmail.com', '$2y$10$QUf8MKw9uKUTjx3UVt9sxuDU/AcnoIGfmTqurFZA1jUaBt6nQDPhq', NULL, 'student', NULL),
(1223, 'karthik12@gmail.com', '$2y$10$gtwZ9xd/rRGoI.XuLZWFduOwQffgAR6uHbMDypSFDZd3fMC1eSejK', NULL, 'student', NULL),
(1224, 'darren1@fh.com', '$2y$10$Jgp.lM9YHSgnNXqVb7Zi4eNL8SdKWMAi8MDAs1l6s7h5IEbA2PkbW', NULL, 'student', NULL),
(1225, 'dijdklfjl@h.com', '$2y$10$gjGa8DNzm/z4vdTUJahay.Duxg3dWi8WgTEEh7PyJgEwF5/acAstG', NULL, 'student', NULL),
(1226, 'darren1@12.com', '$2y$10$10ilUesZHgFi5W5zQOLC7ujucjrSAxu5kui6Xh1SeBOM/6zRVKJsS', NULL, 'student', NULL),
(1227, 'darren1@1212.com', '$2y$10$1EstuiRZ3ShQy8EeBJOkBeOSLRa4SFINgLiNRe4R6tMtu4hWoECBK', NULL, 'student', NULL),
(1228, 'darren1@hdagshdj.com', '$2y$10$aJSAd9Y5a9DerrcedshQGej.VJ3SKEn57cMBL6rNL7tuhsDASMysW', NULL, 'student', NULL),
(1229, 'darren1@ssjdj.com', '$2y$10$sDwVPQBoMJMNYvobUEVCIOPou/kQmVqRjzb1GijO8RRzbw0mY4SC.', NULL, 'student', NULL),
(1230, 'darren1@g.com', '$2y$10$vwfEG6NuTrX6WgRC6X/96eXGenLPz4/uHL3DzbDt70WaMa2qGheDG', NULL, 'student', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Cmt_Id`),
  ADD KEY `sender_id` (`Sender_Id`),
  ADD KEY `receiver_id` (`Receiver_Id`),
  ADD KEY `prj_Id` (`prj_Id`);

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
  ADD KEY `Guide_Id` (`Guide_Id`),
  ADD KEY `Prj_id` (`Prj_id`);

--
-- Indexes for table `review_doc`
--
ALTER TABLE `review_doc`
  ADD PRIMARY KEY (`Doc_Id`),
  ADD KEY `rv_Id` (`rv_Id`),
  ADD KEY `Prj_Id` (`Prj_Id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Dept_No`),
  ADD KEY `fk_guide_name` (`Guide_Id`),
  ADD KEY `fk_uid` (`U_Id`);

--
-- Indexes for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD PRIMARY KEY (`tsId`),
  ADD KEY `Proj_Id` (`Proj_Id`);

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
  MODIFY `Cmt_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Noti_Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `Prj_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `review_doc`
--
ALTER TABLE `review_doc`
  MODIFY `Doc_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `timesheet`
--
ALTER TABLE `timesheet`
  MODIFY `tsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `U_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1231;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`Sender_Id`) REFERENCES `user_credentials` (`U_Id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`Receiver_Id`) REFERENCES `user_credentials` (`U_Id`),
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`prj_Id`) REFERENCES `project` (`Prj_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`Prj_id`) REFERENCES `project` (`Prj_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review_doc`
--
ALTER TABLE `review_doc`
  ADD CONSTRAINT `review_doc_ibfk_1` FOREIGN KEY (`rv_Id`) REFERENCES `review` (`Review_Id`),
  ADD CONSTRAINT `review_doc_ibfk_2` FOREIGN KEY (`Prj_Id`) REFERENCES `project` (`Prj_Id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_guide_name` FOREIGN KEY (`Guide_Id`) REFERENCES `guide` (`Guide_Id`),
  ADD CONSTRAINT `fk_uid` FOREIGN KEY (`U_Id`) REFERENCES `user_credentials` (`U_Id`);

--
-- Constraints for table `timesheet`
--
ALTER TABLE `timesheet`
  ADD CONSTRAINT `timesheet_ibfk_1` FOREIGN KEY (`Proj_Id`) REFERENCES `project` (`Prj_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
