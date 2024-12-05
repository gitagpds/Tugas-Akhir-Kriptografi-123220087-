-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 02:19 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `museum`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_museum`
--

CREATE TABLE `data_museum` (
  `id_koleksi` int(11) NOT NULL,
  `nama_koleksi` varchar(255) NOT NULL,
  `deskripsi_koleksi` text NOT NULL,
  `asal_koleksi` varchar(255) NOT NULL,
  `tahun_ditemukan` varchar(255) NOT NULL,
  `kondisi_koleksi` varchar(255) NOT NULL,
  `kategori_koleksi` varchar(255) NOT NULL,
  `nama_penemu` varchar(255) NOT NULL,
  `gambar_koleksi` blob NOT NULL,
  `nama_gambar_asli` varchar(255) NOT NULL,
  `nama_gambar_encoded` varchar(255) NOT NULL,
  `dokumen` blob NOT NULL,
  `nama_file_asli` varchar(255) NOT NULL,
  `nama_file_encoded` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_museum`
--

INSERT INTO `data_museum` (`id_koleksi`, `nama_koleksi`, `deskripsi_koleksi`, `asal_koleksi`, `tahun_ditemukan`, `kondisi_koleksi`, `kategori_koleksi`, `nama_penemu`, `gambar_koleksi`, `nama_gambar_asli`, `nama_gambar_encoded`, `dokumen`, `nama_file_asli`, `nama_file_encoded`) VALUES
(21, 'mMP+yoaVavhc2cB5DuYjLw==', 'tEb4DkkMRoN89rQ9TLO3cgtmK09KQzCXTpXK/ikMxlJBzQYhgj9jQQv8RwfgxtIOtBJlThZ2aIF2zBmFdw2DCMtuFawCR55VTeKQrE7oG66BwDPQQkMTeKDxbd7ytWw/CCMpH7mvMf0tv8BB1j0Y0twdjDoIkN3OKoczYErcZtbgas/hM9UDBie8evG31IQtc05Rj4jbgPLUgLqYYzVKwfYJiH4ZwIgXqNI+QxnMhlxAXas2BV7sYa8b5lG0xtP52/EBpVxn8wRbtWb/KUTYZi90qlKvy6Tp76UhFD/wktxZPwhPQnHvhqV65n/ga0MI3/q0ajPMIdKpwi2TRAdqJQ9f2ft5tZqS8AFOCjQX5cyVtRxrmzN4GPy0kYGI5i+iUK+gIrurYjC1hKSOGBLHRj2UJ8DTdb+5gTUPmnWOSJFOxoo3Zir3SHFwbye+V0WKyDxbIO/kqKrOm4JWxME5lrDXPvz8vicF2rpMrzSMJ1z81rog1V4xU6d6iIi5tMgiBZSYUwjCNbiRIatXrvvs99AhWZKCWbT+kUYAa2UyIecs9lhz3Szz0oDNu6KDsRcxKH+hVdhkaDC2Tr8U5jT0b3uro4sBfBTggaG+UO5+LhkUqVu3C1YJGYWrJvQJF1RquRACXVUR5Agk05XBOjIK944CYIJ5b1/FVDsTjaJ5xx3X/bV8/1uMB+9cgKkDgYCcu82CNFzwt6K2JZ7Rfk2US1VMkZlBdXjwLNjmNyJEP/Fm+3uI4bPSQnXHn3HtlVU3C2bWuoiSEu7d08hbqQJyHEe8GS+2XkAvNAbLMYb6fLv5gz+ezwJebbBrJMv7MGBY6XtpkdVYNSgNfzdpAOVvk6qa9r4VIkWY4893YyJGAGWK61dmaGREE1X3Thvx6z9n3oMpnqvUq4Dd9CzgW/PMJBLrZBw13D8rvsLlv4vJExagC9j246YRMecMZYaB6+20RK1lIvSmWrWRgGJTCEng134GKZPIgLIh+gLyOTt6o8/TyqxjkN73wpqINkxmaqh+ygO7LEOZ1VSW/kAT6ansqR7Q9gPZ2FfFCjUGaNnTuA+qvUj9SJT4toqn3mVW/qAdgVA/ic1vFMM=', 'Bandung', '1789', 'Baik', 'Budaya', 'Gita Poetri', 0x656e636f6465645f696d616765732f70726173617374695f6a616d62755f656e636f6465642e706e67, 'prasasti_jambu.jpg', 'prasasti_jambu_encoded.png', 0x656e636f6465645f66696c65732f70726173617374695f6a616d62755f656e636f6465642e646f6378, 'prasasti_jambu.docx', 'prasasti_jambu_encoded.docx');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`) VALUES
(7, 'gitagpds', 'gita@gmail.com', 'c02ded4e1a87a53e4741c7ce40fc1d810b722a4e32c63d2fcb821795ad0b8ab1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_museum`
--
ALTER TABLE `data_museum`
  ADD PRIMARY KEY (`id_koleksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_museum`
--
ALTER TABLE `data_museum`
  MODIFY `id_koleksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
