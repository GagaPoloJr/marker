-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 01:59 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id_agenda` int(11) NOT NULL,
  `id_location` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hasil` text NOT NULL,
  `persetujuan` varchar(255) NOT NULL,
  `dokumentasi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id_agenda`, `id_location`, `judul`, `status`, `hasil`, `persetujuan`, `dokumentasi`, `tanggal`) VALUES
(6, 6, 'kegiatan dipo 1', 'tidak', 'tidak', 'tidak', '348070553_pexels-photo-127513.jpeg', '2022-07-12'),
(7, 6, 'makan', 'makan', 'makan', 'makan', '348070553_pexels-photo-127513.jpeg', '2022-07-12'),
(8, 4, 'lokasi 4', 'lokasi 4', 'lokasi 4', 'lokasi 4', '348070553_pexels-photo-127513.jpeg', '2022-07-12'),
(9, 4, 'lokasi 5 asd asd', 'lokasi 5asd asdas', 'lokasi 4d as', 'asd', '348070553_pexels-photo-127513.jpeg', '2022-07-12');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(4) NOT NULL,
  `kecamatan` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `title`, `lat`, `lng`, `description`, `location_status`, `kecamatan`, `image`) VALUES
(4, 'taman air mancul', -6.17512, 106.824, 'taman', 1, ' asd sad', ''),
(6, 'patung dipo', -6.17308, 106.827, 'patng', 1, 'testt', '1530303602_Screenshot 2022-07-23 205445.png'),
(7, 'gatau ini apa', -6.17709, 106.826, 'asd asd', 1, 'testt', '1530303602_Screenshot 2022-07-23 205445.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `id_location` (`id_location`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `id_location` FOREIGN KEY (`id_location`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
