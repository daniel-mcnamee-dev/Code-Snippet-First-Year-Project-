-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2026 at 08:49 PM
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
-- Database: `webdevproj`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `content`, `folder_id`, `created_at`, `user_id`) VALUES
(5, 'File1', 'abba cadabba', 7, '2026-03-17 18:55:05', 0),
(6, 'File2', 'abshc', 6, '2026-03-17 18:56:13', 0),
(7, 'Array Methods', 'JavaScript array methods:\r\n\r\nmap()\r\nfilter()\r\nreduce()\r\n\r\nExample:\r\nconst nums = [1,2,3];\r\nconst doubled = nums.map(n => n * 2);', 12, '2026-03-17 19:40:21', 2),
(8, 'SQL JOIN Example', 'Example SQL JOIN:\r\n\r\nSELECT users.name, files.filename\r\nFROM users\r\nJOIN files ON users.id = files.user_id;', 13, '2026-03-17 19:40:21', 2),
(9, 'Flexbox Layout', 'Flexbox basics:\r\n\r\ndisplay: flex;\r\njustify-content: center;\r\nalign-items: center;', 14, '2026-03-17 19:40:21', 2),
(10, 'Web Dev Exam Prep', 'Topics to review:\r\n\r\nHTML semantics\r\nCSS Grid\r\nSQL joins\r\nREST APIs', 15, '2026-03-17 19:40:21', 2),
(12, 'Async Await Example', 'async function fetchData() {...}', 12, '2026-03-17 19:47:35', 2),
(13, 'Joins Explained', 'INNER JOIN vs LEFT JOIN...', 13, '2026-03-17 19:47:35', 2),
(14, 'Group By Example', 'SELECT department, COUNT(*)...', 13, '2026-03-17 19:47:35', 2),
(16, 'CSS Grid Notes', 'grid-template-columns...', 14, '2026-03-17 19:47:35', 2),
(17, 'OOP Principles', 'Encapsulation Inheritance...', 15, '2026-03-17 19:47:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `foldername` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `foldername`, `created_at`, `user_id`) VALUES
(6, 'Folder1', '2026-03-17 18:54:52', 0),
(7, 'Folder2', '2026-03-17 18:55:31', 0),
(12, 'JavaScript Notes', '2026-03-17 19:39:35', 2),
(13, 'SQL Queries', '2026-03-17 19:39:35', 2),
(14, 'Web Development', '2026-03-17 19:39:35', 2),
(15, 'College Modules', '2026-03-17 19:39:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `security_question` varchar(100) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `security_question`, `security_answer`) VALUES
(0, 'DanDev', 'dandev@email.com', '$2y$10$Q86BQl0hjg2.tuC/F5AI2uVAt2SnFSFkGtpOb5gz4CAOg0QgEamp2', 'maiden', '$2y$10$uLxJE.LGdc77oU/fmEWsnupUIAYsSqncqlVZXw0T9dlrUiNj.l9iW'),
(2, 'Guest', 'guest@example.ie', '$2y$10$2wXUmG.47znaZuhliQgBeemjeJ/CkHmu.kdzRZk0s8OIBtthOJURq', 'guest', 'guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folder_id` (`folder_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`folder_id`) REFERENCES `folders` (`id`),
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
