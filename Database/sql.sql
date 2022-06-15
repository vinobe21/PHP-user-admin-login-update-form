-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2022 at 07:35 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `form_validation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'adminadmin');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `cityname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `cityname`) VALUES
(1, 1, 'Sivakasi'),
(2, 1, 'Madurai'),
(3, 1, 'Virudhunagar'),
(4, 1, 'Chennai'),
(5, 1, 'Tiruppur'),
(6, 1, 'ooty'),
(7, 1, 'Erode'),
(8, 1, 'Salem'),
(9, 2, 'Kochi'),
(10, 2, 'kozhikode'),
(11, 2, 'Kollam'),
(12, 2, 'thrissur'),
(13, 2, 'Alappuzha'),
(14, 2, 'Ponnani'),
(15, 2, 'Malappuram'),
(16, 2, 'Vayala');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state_name`) VALUES
(1, 'TamilNadu'),
(2, 'Kerala');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` text DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `password` varchar(500) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `gender`, `state`, `city`, `hobby`, `file`, `status`) VALUES
(319, 'vinoth', 'kumar', 'v@gmail.com', 1234567896, 'vinoth', 'male', 2, 16, 'reading', '27-05-2022-1653628024-photo-1494790108377-be9c29b29330.jpg', 1),
(320, 'leela', 'leela', 'l@gmail.com', 1234567899, 'vinoth', 'female', 2, 9, 'reading,writing', '20-05-2022-1653051899-photo-1494790108377-be9c29b29330.jpg', 1),
(321, 'sam', 'sam', 's@gmail.com', 1234567898, 'vinoth', 'others', 2, 15, 'Writing', '20-05-2022-1653047488-download.jpg', 1),
(322, 'kholi', 'kholi', 'k@gmail.com', 1234567897, 'vinoth', 'male', 2, 10, 'reading,dancing', '20-05-2022-1653051753-download.jpg', 1),
(323, 'spidar', 'man', 'sm@gmail.com', 1234567894, 'vinoth', 'male', 2, 10, 'Writing,Painting', '20-05-2022-1653047624-Spiderman-Desktop-Wallpaper.jpg', 1),
(324, 'peter', 'peter', 'p@gmail.com', 1234567895, 'vinoth', 'others', 2, 14, 'Painting', '20-05-2022-1653047673-Spiderman-Desktop-Wallpaper.jpg', 1),
(325, 'downey', 'downey', 'd@gmail.com', 1234566541, 'vinoth', 'male', 2, 15, 'Reading,Writing,Painting,Dancing', '20-05-2022-1653047855-ben-parker-OhKElOkQ3RE-unsplash.jpg', 1),
(326, 'thor', 'thor', 't@gmail.com', 2147483647, 'vinoth', 'male', 1, 4, 'Reading', '20-05-2022-1653047936-ben-parker-OhKElOkQ3RE-unsplash.jpg', 1),
(327, 'nick', 'fury', 'nf@gmail.com', 1234566543, 'vinoth', 'others', 2, 12, 'Reading', '20-05-2022-1653048062-photo-1494790108377-be9c29b29330.jpg', 1),
(328, 'doctor', 'strange', 'ds@gmail.com', 2147483647, 'vinoth', 'male', 2, 16, 'Reading', '20-05-2022-1653048123-download.jpg', 1),
(329, 'block', 'panther', 'bp@gmail.com', 1458745484, 'vinoth', 'female', 2, 12, 'Reading,Writing', '20-05-2022-1653048254-ben-parker-OhKElOkQ3RE-unsplash.jpg', 1),
(330, 'natalie', 'natalie', 'n@gmail.com', 2147483647, 'vinoth', 'female', 2, 13, 'Reading', '20-05-2022-1653048333-photo-1494790108377-be9c29b29330.jpg', 1),
(331, 'test', 'test', 'test@gmail.com', 2147483647, 'vinoth', 'others', 1, 3, 'Writing', '20-05-2022-1653048391-download.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`state_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `name` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
