-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2024 at 04:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignmentDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `fname` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` char(7) DEFAULT NULL,
  `id` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fname`, `email`, `password`, `role`, `id`) VALUES
('Roshan Thapa', 'roshanrays236@gmail.com', '$2y$10$Jq/WVnv2O71bZ92P8lIVJ.GM4y/SkwKjOvBqiiVv9Xneib0dbmvDy', 'student', '27std'),
('Paul Deitel', 'pauldeitel236@gmail.com', '$2y$10$b5NxC9KLX6dMiOtV8SRvv.i.zukzeHBlB6Rm5eLn7QVsSleVZU0q6', 'teacher', '7tch'),
('Roshan Thapa', 'thaparoshan@gmail.com', '$2y$10$41dWRTVoHL813EJjdmhS5.AMSN60s56n51NxLhLwTfXecR5vjjpq6', 'student', '73std'),
('Ram Bahadur Yadav', 'rambahadur@gmail.com', '$2y$10$ZQR.zjZDuPfKSZcjpIBJ6u/0muxne9PmPojNFTdAFOeSrJ6LDFOKS', 'student', '47std'),
('Samundra', 'samundra236@gmail.com', '$2y$10$KGgtDeIXpzrtnIP0VXNnf.j2xggoLI6UBQTHtNqjI3cKQ.9lnPTiu', 'student', '99std'),
('Prena Gurung', 'lalita236@gmail.com', '$2y$10$G8y6Ym3DunlYfpM1iMHFnebhQvvlNiGeO2w.Fxfpzzudh62nvkevG', 'student', '51std');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
