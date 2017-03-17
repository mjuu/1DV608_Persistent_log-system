-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2017 at 08:20 AM
-- Server version: 5.5.53-0+deb8u1
-- PHP Version: 7.0.14-1~bpo8+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `logger`
--
CREATE DATABASE IF NOT EXISTS `logger` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `logger`;

-- --------------------------------------------------------

--
-- Table structure for table `default_videos`
--

CREATE TABLE IF NOT EXISTS `default_videos` (
`id` int(50) NOT NULL,
  `video_id` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1048837 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `default_videos`
--

INSERT INTO `default_videos` (`id`, `video_id`) VALUES
(1048699, 'BWDqy0zZAsY'),
(1048821, 'BXAhEWeeVcU'),
(1048836, 'dCgsyc6SPuQ'),
(1048700, 'HiRl1VcUv1Q'),
(1048815, 'OrZWyeI4Am0'),
(1048828, 'O_Lvget3jl4'),
(1048720, 'QsieDcbt310'),
(1048735, 'Sw2JU9wSi7g'),
(1048701, 'UprcpdwuwCg');

-- --------------------------------------------------------

--
-- Table structure for table `logg`
--

CREATE TABLE IF NOT EXISTS `logg` (
`id` int(10) NOT NULL,
  `ip` text,
  `time` date DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `default_videos`
--
ALTER TABLE `default_videos`
 ADD UNIQUE KEY `id` (`id`), ADD UNIQUE KEY `video_id` (`video_id`);

--
-- Indexes for table `logg`
--
ALTER TABLE `logg`
 ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `default_videos`
--
ALTER TABLE `default_videos`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1048837;
--
-- AUTO_INCREMENT for table `logg`
--
ALTER TABLE `logg`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
