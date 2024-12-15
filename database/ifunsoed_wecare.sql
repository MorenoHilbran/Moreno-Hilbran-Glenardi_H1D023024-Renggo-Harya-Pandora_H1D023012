-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2024 at 09:42 AM
-- Server version: 8.0.33-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ifunsoed_wecare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` char(4) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
('A001', 'renggo', 'renggo123'),
('A002', 'moreno', 'moreno123');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_periksa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diagnosa` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tindak_lanjut` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `username`, `tanggal_periksa`, `diagnosa`, `tindak_lanjut`) VALUES
(1, 'ahmad', '2024-11-17 21:29:36', 'Aortic Dissection', NULL),
(2, 'ahmad', '2024-11-17 21:35:46', 'Perform ECG', NULL),
(3, 'ahmad', '2024-11-17 21:37:01', 'stable angina', 'minum obat pereda nyeri\r\n'),
(4, 'Demas Herdinanda', '2024-11-17 21:49:27', 'Chronic Obstructive Pulmonary Disease (COPD)', 'Suntik vitamin'),
(9, 'ahmad', '2024-11-19 23:22:44', 'Diseksi Aorta', 'obat pill anjuran dokter'),
(10, 'ahmad', '2024-11-19 23:22:54', 'Pulmonary Embolism atau Chronic Respiratory Diseas', NULL),
(11, 'ahmad', '2024-11-19 23:23:03', 'Diseksi Aorta (Aortic Dissection)', NULL),
(12, 'ahmad', '2024-11-19 23:24:00', 'Diseksi Aorta (Aortic Dissection)', NULL),
(13, 'ahmad', '2024-11-19 23:24:41', 'Diseksi Aorta (Aortic Dissection)', NULL),
(14, 'ahmad', '2024-11-19 23:25:52', 'Diseksi Aorta (Aortic Dissection)', NULL),
(15, 'ahmad', '2024-11-19 23:26:23', 'Diseksi Aorta (Aortic Dissection)', NULL),
(16, 'ahmad', '2024-11-19 23:26:53', 'Diseksi Aorta (Aortic Dissection)', NULL),
(17, 'ahmad', '2024-11-19 23:27:49', 'Diseksi Aorta (Aortic Dissection)', NULL),
(18, 'ahmad', '2024-11-19 23:28:10', 'Diseksi Aorta (Aortic Dissection)', NULL),
(19, 'ahmad', '2024-11-19 23:28:45', 'Diseksi Aorta (Aortic Dissection)', NULL),
(20, 'ahmad', '2024-11-19 23:29:29', 'Diseksi Aorta (Aortic Dissection)', NULL),
(21, 'ahmad', '2024-11-19 23:29:34', 'Diseksi Aorta (Aortic Dissection)', NULL),
(22, 'ahmad', '2024-11-19 23:29:59', 'Diseksi Aorta (Aortic Dissection)', NULL),
(23, 'ahmad', '2024-11-19 23:30:18', 'Diseksi Aorta (Aortic Dissection)', NULL),
(24, 'ahmad', '2024-11-19 23:30:34', 'Diseksi Aorta (Aortic Dissection)', 'kurangi makan kolestrol'),
(25, 'ahmad', '2024-11-19 23:30:54', 'Diseksi Aorta (Aortic Dissection)', 'minum\r\n'),
(26, 'ahmad', '2024-11-19 23:31:45', 'Diseksi Aorta (Aortic Dissection)', 'makan'),
(27, 'ahmad', '2024-11-19 23:33:11', 'Diseksi Aorta (Aortic Dissection)', 'olahraga'),
(28, 'ahmad', '2024-11-22 15:28:08', 'Angina Stabil(Stable Angina)', 'minum obat\r\n'),
(29, 'ahmad', '2024-12-15 09:01:28', 'Serangan Jantung (Acute Coronary Syndrome)', NULL),
(30, 'Shierra ', '2024-12-15 09:20:23', 'Pulmonary Embolism atau Chronic Respiratory Diseas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `password`) VALUES
('ahmad', 'ahmad07@gmail.com', '$2y$10$FzUFwPMEjlwbRIfz5jDd4OTLAXNu17./Dh7bKMYtsjVJvoYVRhaJK'),
('beni', 'beni@gmail.com', '$2y$10$eEYz8aR6PQSOgdOOk51aFOUBKosKd2dKPtVryVh0TG7UhhVNlhOWe'),
('Demas Herdinanda', 'demas.herdinanda@mhs.unsoed.ac.id', '$2y$10$ruCr0vMkW1o7L946k0NkoeUOUIj6gGzJALufZ6.rWJ5MDDmMtBKPm'),
('kya', 'kya@gmail.com', '$2y$10$kvrLzijzaXHcE3G70H0P2uBMKSyRoHRAKgVv5Oqn.VTI4X8.0hyHS'),
('Shierra ', 'aashadrs@gmail.com', '$2y$10$mzJZmjVwdU9Oc0ehJ/jcYOlQHSRPiXZB9nO9yQO8oMuhAjxs3bqNu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
