-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 03:19 AM
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
(9, 'rlAaJiuB5PZt6u9E6yS2OQ==', 'rlAaJiuB5Pb4eYzABbxZG07yn5ngyY6PaSJ3ThiCJ3KgzzcfhRb5nuOC8AW17klRmdBKdUm8USeDhmrB42dGWiZh80RrJOZwnCD9vzlNNKt1s55bSiXk7qAUH/giOfHy9tGI7KBFpDebMJwIAKB05cnEoD7ujIlEEgTbFSayMmULrZh1Rg2dcxW2HDynm4q31dwuPhskJyP2yZtBYhArOOLjp0TxHRIM98Sgsn2CeTIezfzcbn9TTWoFNvRLUnvb+m9/U4eVz7biaGb2sOvTuBRGw8vUgMFfaofw0vZV2toYfJDwcSqYPUC5qXBleicgXSSRpUtFRA/bEuIjJa7b+haTEvLjrTPgch7dDMpnVO5PU/CoSv1hY8dX9bnE0p3CYgPUZr4ZcGazL/TqcobV5fvUF0Bh3KkYl0FiZEOQIzQNxqwikN56TNVrs3PXZ5JCyaLHx+emikrc1hPQO/1QUmFBv3h5Bf+hk03G79+Q/Qm3Z8yJMKsEZg==', 'Jogja', '1789', 'Rusak Ringan', 'Sejarah', 'Mohammad Hatta', 0x656e636f6465645f696d616765732f617263615f67616e657368615f656e636f6465642e706e67, 'arca_ganesha.jpeg', 'arca_ganesha_encoded.png', 0x656e636f6465645f66696c65732f617263615f67616e657368615f656e636f6465642e646f6378, 'arca_ganesha.docx', 'arca_ganesha_encoded.docx'),
(13, '/yrfvMpbymnWIHIgJIKxzw==', 'j8RMMPvo+tanEwZDjyIAf0xZEOpMOCKPmWZxXlr0Ny4XiNo7qkqew2alSx+BFhOUirqteU07ZTbDz6Ov66lQWTMuV9IYdDQDiI4Awxf9wLDcYNDgZSgCKr6CExXDCNYJQ9kh/4aAs/SvgpqkGEpcUffbfxK1g8AVkIQOvpTURAjfgWzkTwLcu4icjusJqIc5rVmPM3saQZcUpJqMi5GartH0gLcse4aQeuItpQMoPKO3/lV0qMCYeY6ZzPUU2SJsKQAB+wIKXoEqPldNnEwp7JC/ziaF9s3kIt2jQ4fKEz763Rq7cxhMKF4gv+CYxegsR1f4LLHATPQiyTVTVTjxmrEmR1IGa2D98k5e5giPnHB94C13GbBy1g==', 'Banten', '1677', 'Baik', 'Budaya', 'Soekarno Hatta', 0x656e636f6465645f696d616765732f62756a616e6767615f6d616e696b5f656e636f6465642e706e67, 'bujangga_manik.jpg', 'bujangga_manik_encoded.png', 0x656e636f6465645f66696c65732f62756a616e6767615f6d616e696b5f656e636f6465642e646f6378, 'bujangga_manik.docx', 'bujangga_manik_encoded.docx'),
(14, 'h/gOa7z15J2n2HHZG1f38w==', 'h/gOa7z15J2Qvr+BxsrgN5824Z9nADzBi8UI5FrOdIUgaWPgAIjcSNCcfqZGNU0Ud4Rjh6gAYLYYvOdOOJcmlB8wt4o4lRF5yM9uVNYCob7cz/nLdrveWRj3atTeMBSLORhBciWthwANMEz7VKdzdj7NgoqmZKvZK+cMLISQZClOiFXjvxIZ2m4X5PEuYv1vCmEYnayDjvVIyz/63Uu71xOaUVuAxhw+zf5MOQ+D37ElbFrf4pVodw==', 'Kalimantan', '1564', 'Baik', 'Seni', 'Albert Einstein', 0x656e636f6465645f696d616765732f70726173617374695f6a616d62755f656e636f6465642e706e67, 'prasasti_jambu.jpg', 'prasasti_jambu_encoded.png', 0x656e636f6465645f66696c65732f70726173617374695f6a616d62755f656e636f6465642e706466, 'prasasti_jambu.pdf', 'prasasti_jambu_encoded.pdf');

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
  MODIFY `id_koleksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
