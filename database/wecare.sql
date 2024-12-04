-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2024 pada 03.29
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wecare`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` char(4) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
('A001', 'renggo', 'renggo123'),
('A002', 'moreno', 'moreno123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `tanggal_periksa` datetime NOT NULL DEFAULT current_timestamp(),
  `diagnosa` varchar(50) DEFAULT NULL,
  `tindak_lanjut` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `username`, `tanggal_periksa`, `diagnosa`, `tindak_lanjut`) VALUES
(1, 'ahmad', '2024-11-17 21:29:36', 'Aortic Dissection', NULL),
(2, 'ahmad', '2024-11-17 21:35:46', 'Perform ECG', NULL),
(3, 'ahmad', '2024-11-17 21:37:01', 'stable angina', 'minum obat pereda nyeri\r\n'),
(4, 'Demas Herdinanda', '2024-11-17 21:49:27', 'Chronic Obstructive Pulmonary Disease (COPD)', 'Suntik Mati'),
(9, 'ahmad', '2024-11-19 23:22:44', 'Diseksi Aorta', 'Suntik mati'),
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
(24, 'ahmad', '2024-11-19 23:30:34', 'Diseksi Aorta (Aortic Dissection)', NULL),
(25, 'ahmad', '2024-11-19 23:30:54', 'Diseksi Aorta (Aortic Dissection)', NULL),
(26, 'ahmad', '2024-11-19 23:31:45', 'Diseksi Aorta (Aortic Dissection)', NULL),
(27, 'ahmad', '2024-11-19 23:33:11', 'Diseksi Aorta (Aortic Dissection)', NULL),
(28, 'ahmad', '2024-11-22 15:28:08', 'Angina Stabil(Stable Angina)', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `email`, `password`) VALUES
('ahmad', 'ahmad07@gmail.com', '$2y$10$FzUFwPMEjlwbRIfz5jDd4OTLAXNu17./Dh7bKMYtsjVJvoYVRhaJK'),
('Demas Herdinanda', 'demas.herdinanda@mhs.unsoed.ac.id', '$2y$10$ruCr0vMkW1o7L946k0NkoeUOUIj6gGzJALufZ6.rWJ5MDDmMtBKPm'),
('Khansa', 'sasa123@gmail.com', '$2y$10$QebSVipaqGgnqZi1B0Avm.OuhD4Wt75fXAcmvfZnl1d5AsPyxZ92u'),
('moreno', 'moren@gmail.com', '$2y$10$vPBf6jPxChbkFquGK6pQ8.NZu.BNXFZgajpr58xxRzm6X6Z..ZXeO');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `username` (`username`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
