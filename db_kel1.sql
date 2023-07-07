-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 07:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: 'db_kel1'
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `price`) VALUES
(1, 'Ekonomi', 20000),
(2, 'Bisnis', 30000),
(3, 'Eksekutif', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `name_short` varchar(6) NOT NULL,
  `route` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `name`, `name_short`, `route`) VALUES
(1, 'Cakung', 'CUK', 6),
(2, 'Bekasi', 'BKS', 7),
(3, 'Karawang', 'KW', 9),
(4, 'Bandung', 'BD', 14),
(5, 'Pasar Senen', 'PSE', 4),
(7, 'Jatinegara', 'JNG', 5),
(8, 'Cikampek', 'CKP', 10),
(10, 'Jakarta-Kota', 'JAKK', 1),
(14, 'Kemayoran', 'KMY', 2),
(15, 'Kramat Sentiong', 'KMT', 3),
(16, 'Purwakarta', 'PWK', 11),
(17, 'Cikarang', 'CKR', 8);

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`id`, `name`, `price`) VALUES
(1, 'Argo Parahyangan', 50000),
(2, 'Cirebon Express', 40000),
(3, 'Serayu', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_by` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `passengers_name` text NOT NULL,
  `amount_ticket` int(11) NOT NULL,
  `train_name` varchar(64) NOT NULL,
  `train_class` varchar(64) NOT NULL,
  `dept_time` date NOT NULL,
  `time` varchar(24) NOT NULL,
  `station_dept` varchar(64) NOT NULL,
  `station_arr` varchar(64) NOT NULL,
  `unique_price` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `order_time` int(11) NOT NULL,
  `is_success` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `booking_by`, `email`, `passengers_name`, `amount_ticket`, `train_name`, `train_class`, `dept_time`, `time`, `station_dept`, `station_arr`, `unique_price`, `price`, `order_time`, `is_success`) VALUES
(619594, 1, 'Aryo Bhodro Irawan', 'ibhodro123@gmail.com', 'Aryo Bhodro Irawan,Btari <3', 2, 'Serayu E11', 'Eksekutif', '2021-05-25', '11:45', 'JAKK', 'PSE', 12, 202012, 1621877601, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birthdate`, `gender`) VALUES
(1, 'Aryo Bhodro Irawan', 'ibhodro123@gmail.com', '$2y$10$d8OV7WpqXRQca02fsKtuqe0NCehiIoLunhK4VLiVIyLdrMuEAuL8O', '2021-05-12', 'Pria'),
(2, 'BTARIIIIIIIIIII', 'btaritest@gmail.com', '$2y$10$363YMRmvVu3opk/7ikT2auXspMKE8wg9n5QMl/mvG2Y3meNKfbDbS', '2006-12-21', 'wanita');

--
-- indexes for dumped tables
--

--
-- indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`);

--
-- indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trains`
--
ALTER TABLE `trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
