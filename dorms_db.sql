-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2026 at 05:20 PM
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
-- Database: `dorms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(15) NOT NULL,
  `adminName` varchar(100) NOT NULL,
  `adminEmail` varchar(100) NOT NULL,
  `adminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminEmail`, `adminPassword`) VALUES
('admin01', 'Fahmi', 'harithfahmi72@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `bookingDate` datetime NOT NULL,
  `bookingStatus` varchar(20) NOT NULL,
  `studentID` varchar(15) NOT NULL,
  `roomID` varchar(10) NOT NULL,
  `bedNumber` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `bookingDate`, `bookingStatus`, `studentID`, `roomID`, `bedNumber`) VALUES
(28, '2026-06-29 15:35:59', 'Approved', '2024288856', 'K101', 2),
(29, '2026-06-29 15:35:59', 'Approved', '2024668001', 'K102', 1),
(30, '2026-06-29 15:35:59', 'Approved', '2024668002', 'K102', 2),
(31, '2026-06-29 15:35:59', 'Approved', '2024668003', 'K102', 3),
(32, '2026-06-29 15:35:59', 'Approved', '2024668004', 'K102', 4),
(33, '2026-06-29 15:35:59', 'Approved', '2024668005', 'K201', 1),
(34, '2026-06-29 15:35:59', 'Approved', '2024437516', 'S101', 1),
(35, '2026-06-29 15:35:59', 'Approved', '2024257016', 'S101', 2),
(36, '2026-06-29 15:35:59', 'Approved', '2024669001', 'S201', 1),
(37, '2026-06-29 15:35:59', 'Approved', '2024669002', 'S201', 2),
(38, '2026-06-29 15:35:59', 'Approved', '2024669003', 'S201', 3),
(39, '2026-06-29 15:35:59', 'Approved', '2024669004', 'S201', 4);

-- --------------------------------------------------------

--
-- Table structure for table `eligibility`
--

CREATE TABLE `eligibility` (
  `eligibilityID` int(11) NOT NULL,
  `studentID` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eligibility`
--

INSERT INTO `eligibility` (`eligibilityID`, `studentID`, `status`) VALUES
(1, '2024668444', 'YES'),
(2, '2024437516', 'YES'),
(4, '2024288856', 'YES'),
(5, '2024257016', 'YES'),
(6, '2024668001', 'Pending'),
(7, '2024668002', 'Pending'),
(8, '2024668003', 'Pending'),
(9, '2024668004', 'Pending'),
(10, '2024668005', 'Pending'),
(11, '2024669001', 'Pending'),
(12, '2024669002', 'Pending'),
(13, '2024669003', 'Pending'),
(14, '2024669004', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomID` varchar(10) NOT NULL,
  `roomNumber` varchar(10) NOT NULL,
  `blockName` varchar(20) NOT NULL,
  `floorLevel` int(11) NOT NULL,
  `roomCapacity` int(11) NOT NULL,
  `currentOccupancy` int(11) DEFAULT 0,
  `roomStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomID`, `roomNumber`, `blockName`, `floorLevel`, `roomCapacity`, `currentOccupancy`, `roomStatus`) VALUES
('K001', 'K001', 'Kasa', 0, 4, 0, 'Available'),
('K101', 'K101', 'Kasa', 1, 4, 1, 'Available'),
('K102', 'K102', 'Kasa', 1, 4, 4, 'Full'),
('K201', 'K201', 'Kasa', 2, 4, 1, 'Available'),
('S101', 'S101', 'Sutera', 1, 4, 2, 'Available'),
('S201', 'S201', 'Sutera', 2, 4, 4, 'Full');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` varchar(15) NOT NULL,
  `studentName` varchar(100) NOT NULL,
  `studentEmail` varchar(100) NOT NULL,
  `studentPassword` varchar(255) NOT NULL,
  `studentGender` varchar(10) DEFAULT NULL,
  `collegeStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `studentName`, `studentEmail`, `studentPassword`, `studentGender`, `collegeStatus`) VALUES
('2024257016', 'Syauqina Adlina Binti Mohamad Shahar', '2024257016@student.uitm.edu.my', '123456', 'Female', 'YES'),
('2024288856', 'Adam Khairi Bin Mohd Khair', '2024288856@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024437516', 'Nurin Fathiah Adriana Binti Iskandar Razali', '2024437516@student.uitm.edu.my', '123456', 'Female', 'YES'),
('2024668001', 'Amir Hakim', 'amir@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024668002', 'Hakimi Azman', 'hakimi@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024668003', 'Danish Firdaus', 'danish@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024668004', 'Aiman Rosli', 'aiman@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024668005', 'Firdaus Karim', 'firdaus@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024668444', 'Harith Fahmi Bin Mat Rahim', '2024668444@student.uitm.edu.my', '123456', 'Male', 'YES'),
('2024669001', 'Alya Sofea', 'alya@student.uitm.edu.my', '123456', 'Female', 'YES'),
('2024669002', 'Balqis Hana', 'balqis@student.uitm.edu.my', '123456', 'Female', 'YES'),
('2024669003', 'Sofia Aisyah', 'sofia@student.uitm.edu.my', '123456', 'Female', 'YES'),
('2024669004', 'Farah Nabila', 'farah@student.uitm.edu.my', '123456', 'Female', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ticket_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `message` text NOT NULL,
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`ticket_id`, `student_id`, `student_name`, `email`, `subject`, `priority`, `message`, `status`, `created_at`) VALUES
(1, '2024668444', 'Harith Fahmi', 'harithfahmi72@gmail.com', 'Unable to book room', 'Medium', 'I cannot book room K101. The system says the room is available, but the booking fails. Please assist me.', 'Resolved', '2026-06-28 14:36:12'),
(2, '2024668444', 'Harith Fahmi Bin Mat Rahim', '2024668444@student.uitm.edu.my', 'Cannot Login', 'High', 'I cannot login using my student account.', 'Pending', '2026-06-29 12:21:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `eligibility`
--
ALTER TABLE `eligibility`
  ADD PRIMARY KEY (`eligibilityID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `eligibility`
--
ALTER TABLE `eligibility`
  MODIFY `eligibilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`);

--
-- Constraints for table `eligibility`
--
ALTER TABLE `eligibility`
  ADD CONSTRAINT `eligibility_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
