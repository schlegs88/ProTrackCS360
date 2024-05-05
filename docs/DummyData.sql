-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 07:41 PM
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
-- Database: `auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `UserName` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `Pass` varchar(64) NOT NULL,
  `UserType` int(1) NOT NULL,
  `id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`UserName`, `email`, `Pass`, `UserType`, `id`) VALUES
('Bob', 'bob@email.net', '$2y$10$j8vP0m.LF.KA3QVtlOCDKuS0QyOJXBGQfHWWPmCjLAjgYzAlh3HmC', 0, 9128315),
('Jim', 'jimerson@email.net', '$2y$10$usF423Iqb3pYiU/x4RzfUeGPojQFVWo1cSJ0tjKc0iGx77uducliy', 0, 9128311),
('JohnDoe', 'jj@email.net', '$2y$10$4FVtN8Az.ZNHtSKYkL5kD.Zxn2zFWzh5.BvIK4X14hm05aUcqC2nO', 0, 9128310),
('newteacher', 'new@email.net', '$2y$10$GtlCOPzwJ4JcZSMRxGp0q.PgvLvSII6m.rTHFtNL1PFSDDVXeHWtq', 1, 9128313),
('Teacher42', 'newTeacher@email.net', '$2y$10$yafJ6ibNgI5XhIcdDyEDm.7s60dUvbvbpiTYgdwsQ83I8DwVZA5k.', 1, 9128316),
('teacher1', 'teach@email.net', '$2y$10$yIIPGxCrWRSF.d81.YrHeugjACKfdbUeby4nC7fTsOm8dMoEKPW4O', 1, 9128312),
('newTeach', 'tester@email.net', '$2y$10$1sIVFWcKvEDuNzWuYtidjeMpMymlXFkZjleRotch9wrtv.wGtvd/e', 1, 9128314);

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `Pid` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `score` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`Pid`, `StudentID`, `InstructorID`, `number`, `score`) VALUES
(3, 9128311, 9128312, 997, 8),
(2, 9128311, 9128312, 998, 10),
(1, 9128310, 9128312, 999, 10),
(5, 9128311, 0, 1000, 0),
(4, 9128311, 9128312, 1003, 0),
(5, 9128310, 9128312, 1004, 0),
(8, 9128310, 9128312, 1005, 3),
(7, 9128315, 9128312, 1006, 20),
(7, 9128310, 9128312, 1007, 0),
(3, 9128310, 9128312, 1008, 0),
(11, 9128310, 9128316, 1009, 40),
(11, 9128311, 9128316, 1010, 100);

-- --------------------------------------------------------

--
-- Table structure for table `deliverables`
--

CREATE TABLE `deliverables` (
  `deliverableid` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `duedate` date NOT NULL,
  `phase` int(11) NOT NULL,
  `delivName` text NOT NULL,
  `Pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliverables`
--

INSERT INTO `deliverables` (`deliverableid`, `task`, `duedate`, `phase`, `delivName`, `Pid`) VALUES
(1, 1, '2024-05-11', 1, 'Class Diagram', 5),
(2, 1, '2024-05-16', 2, 'ER Diagram', 5),
(3, 1, '2024-05-17', 10, 'ER Diagram', 3),
(4, 0, '2024-05-18', 3, 'Programming', 5),
(5, 0, '2024-05-31', 3, 'Final Demo', 5),
(6, 0, '2024-05-30', 1, 'ER Diagram', 2),
(7, 0, '2024-05-14', 1, 'ER Diagram', 11),
(8, 0, '2024-05-20', 2, 'Programming', 11),
(9, 0, '2024-05-25', 3, 'Final Demo', 11);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserType` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Username`, `Password`, `UserType`) VALUES
('testuser', 'password', 0),
('testuser', 'password', 0),
('testInst', 'password', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `Pid` int(11) NOT NULL,
  `ProjectName` varchar(255) NOT NULL,
  `possibleScore` int(11) NOT NULL,
  `InstructorID` int(11) NOT NULL,
  `ProjectDescription` text NOT NULL,
  `DueDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`Pid`, `ProjectName`, `possibleScore`, `InstructorID`, `ProjectDescription`, `DueDate`) VALUES
(2, 'Project47', 100, 9128312, 'blank', '2024-05-18'),
(3, 'Project 10', 320, 9128312, 'description102', '2024-05-01'),
(5, 'Project 2', 10, 9128312, 'des', '2024-05-24'),
(6, 'Tester32', 320, 9128312, '32 project descrip', '2024-05-03'),
(7, 'ProTrack', 300, 9128312, 'blank', '2024-05-07'),
(11, 'NewProject', 100, 9128316, 'This is my project description', '2024-05-25'),
(12, 'Test Project', 200, 9128316, 'New Description 2.0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `StudentID` (`id`);

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `deliverables`
--
ALTER TABLE `deliverables`
  ADD PRIMARY KEY (`deliverableid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`Pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9128317;

--
-- AUTO_INCREMENT for table `assigned`
--
ALTER TABLE `assigned`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `deliverables`
--
ALTER TABLE `deliverables`
  MODIFY `deliverableid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `Pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
