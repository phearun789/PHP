-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2025 at 10:20 AM
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
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `total_stock` int(11) NOT NULL,
  `available_stock` int(11) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `publication_year`, `total_stock`, `available_stock`, `cover_image`, `created_at`, `updated_at`) VALUES
(12, 'កូននាគ', 'Run', '9781234567899', 2021, 6, 6, '1755922430_bba.jpg', '2025-08-23 04:13:50', '2025-08-23 04:13:50'),
(14, 'ព្រះវេស្សន្តរ', 'Phearun', '9781234567880', 2019, 3, 2, '1756012376_cca.jpg', '2025-08-24 05:12:56', '2025-08-24 07:29:41'),
(18, 'Bayon The OGEAN Door', 'Run', '9781234567887', 2021, 2, 2, '1756016605_Beyon.jpg', '2025-08-24 06:23:25', '2025-08-24 06:23:25'),
(19, 'Walk Into The Forest', 'Runzy', '978123456555324', 2011, 7, 6, '1756017027_walk.jpg', '2025-08-24 06:30:27', '2025-08-24 07:29:26'),
(20, 'Khmer Art', 'Phea', '978123456555327', 2024, 2, 2, '1756017787_early.jpg', '2025-08-24 06:43:07', '2025-08-24 07:23:33'),
(25, 'កំណត់ហេតុពណ៏ស្វាយ', 'Savry', '97812345678០2', 2025, 11, 10, '1756022236_konmnothet.jpg', '2025-08-24 07:57:16', '2025-08-24 08:19:32'),
(26, 'បុត្រីនាគ', 'Phearun', '97812345678០3', 2022, 10, 10, '1756022564_dragon\'sdaoghter.jpg', '2025-08-24 08:02:44', '2025-08-24 08:02:44'),
(29, 'បុរសឈុតស', 'Savry', '9781234567888', 2023, 1, 0, '1756023137_boros.png', '2025-08-24 08:12:17', '2025-08-24 08:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_return`
--

CREATE TABLE `borrow_return` (
  `borrow_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Borrowed','Returned') DEFAULT 'Borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_return`
--

INSERT INTO `borrow_return` (`borrow_id`, `book_id`, `member_id`, `borrow_date`, `return_date`, `status`) VALUES
(2, 14, 1, '2025-08-02', '2025-08-24', 'Returned'),
(3, 14, 1, '2025-08-23', NULL, 'Borrowed'),
(5, 20, 3, '2025-08-15', NULL, 'Borrowed'),
(6, 19, 4, '2025-08-10', NULL, 'Borrowed'),
(8, 29, 3, '2025-08-18', NULL, 'Borrowed'),
(9, 25, 5, '2025-08-09', NULL, 'Borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Run Rickky', 'rickky@example.com', '0123456789', 'Phnom Penh', '2025-08-23 03:33:13', '2025-08-23 03:33:13'),
(3, 'Phoeun Phearun', 'phearunphoeun@gmail.com', '0964140136', 'Phnom Penh', '2025-08-24 05:04:13', '2025-08-24 05:04:13'),
(4, 'Runzy Dio', 'rundy@gmail.com', '098765432', 'Kampot', '2025-08-24 05:12:10', '2025-08-24 05:12:10'),
(5, 'Sanh Savry', 'savry161@gmail.com', '098765432', 'Kandal', '2025-08-24 06:39:11', '2025-08-24 06:39:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `borrow_return`
--
ALTER TABLE `borrow_return`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `borrow_return`
--
ALTER TABLE `borrow_return`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_return`
--
ALTER TABLE `borrow_return`
  ADD CONSTRAINT `borrow_return_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_return_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
