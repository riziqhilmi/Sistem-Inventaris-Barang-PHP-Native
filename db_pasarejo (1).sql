-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 08:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pasarejo`
--

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `NIS` varchar(16) NOT NULL,
  `NISN` varchar(10) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `agama` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama`, `NIS`, `NISN`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `agama`, `alamat`) VALUES
(1, 'Dian Pratama', '1234567890123456', '9876543210', 'Laki-laki', 'Bondowoso', '2007-05-14', 'Islam', 'Jl. Merdeka No. 5, Bondowoso'),
(2, 'Siti Nurhaliza', '2345678901234567', '8765432109', 'Perempuan', 'Jember', '2008-09-25', 'Islam', 'Jl. Diponegoro No. 10, Jember'),
(3, 'Andi Santoso', '3456789012345678', '7654321098', 'Laki-laki', 'Situbondo', '2006-12-15', 'Kristen', 'Jl. Pemuda No. 20, Situbondo'),
(4, 'Rina Puspita', '4567890123456789', '6543210987', 'Perempuan', 'Banyuwangi', '2010-03-05', 'Islam', 'Jl. Ahmad Yani No. 15, Banyuwangi'),
(5, 'Budi Gunawan', '5678901234567890', '5432109876', 'Laki-laki', 'Bondowoso', '2009-08-20', 'Islam', 'Jl. Pahlawan No. 12, Bondowoso'),
(6, 'Rini Wulandari', '6789012345678901', '4321098765', 'Perempuan', 'Probolinggo', '2007-11-11', 'Islam', 'Jl. Gatot Subroto No. 7, Probolinggo'),
(7, 'Ahmad Fauzi', '7890123456789012', '3210987654', 'Laki-laki', 'Bondowoso', '2006-04-01', 'Islam', 'Jl. Kenangan No. 3, Bondowoso'),
(8, 'Lisa Marlina', '8901234567890123', '2109876543', 'Perempuan', 'Bondowoso', '2009-07-14', 'Katolik', 'Jl. Sudirman No. 8, Bondowoso'),
(9, 'Tono Haryanto', '9012345678901234', '1098765432', 'Laki-laki', 'Jember', '2010-02-22', 'Islam', 'Jl. Gajah Mada No. 11, Jember'),
(10, 'Desi Ananda', '0123456789012345', '0987654321', 'Perempuan', 'Situbondo', '2008-06-09', 'Buddha', 'Jl. Basuki Rahmat No. 2, Situbondo');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `c_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `c_password`) VALUES
(1, 'riziq', '123', 'riziqhilmi27@gmail.com', ''),
(2, 'samsul', '$2y$10$oHymwvvpjkDXgDsY5AHEnu1HydmDu1hNL5/TMq0WeR0', 'samsul@gmail.com', ''),
(3, 'caca', '$2y$10$IT9YdOrYtv.bjGX9n/FIXuNuLMH19tbrOU.VkvYhipU', 'caca@gmail.com', ''),
(4, 'rizka', '123', 'rizka@gmail.com', ''),
(5, 'jono', '123', 'jono@gmail.com', '123'),
(6, 'joko', '123', 'joko@gmail.com', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
