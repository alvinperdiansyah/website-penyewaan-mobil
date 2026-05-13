-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2026 pada 17.47
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
-- Database: `db_rental`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `tipe_sewa` varchar(20) NOT NULL DEFAULT 'Harian',
  `lama_sewa` int(11) NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_harga` int(11) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `status` enum('Menunggu','Disetujui','Ditolak','Selesai') NOT NULL DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`id_booking`, `nama`, `id_mobil`, `tanggal`, `jam_mulai`, `tipe_sewa`, `lama_sewa`, `tanggal_selesai`, `jam_selesai`, `total_harga`, `no_hp`, `alamat`, `status`) VALUES
(1, 'tanu hasyim', 7, '2026-05-12', '12:00:00', 'Harian', 1, '2026-05-13', '12:00:00', 400000, '089758375832', 'jl. perjuangan cirebon', 'Disetujui'),
(2, 'salam', 2, '2026-06-01', '12:59:00', 'Harian', 1, '2026-06-02', '12:59:00', 600000, '0857284729247', 'jl. gebang wetan,cirebon.\r\n', 'Menunggu'),
(3, 'tanu', 1, '2026-05-12', '12:00:00', 'Harian', 2, '2026-05-14', '12:00:00', 1000000, '09867', 'jl.penggung', 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `nama_mobil` varchar(100) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia') NOT NULL DEFAULT 'Tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `nama_mobil`, `merk`, `plat_nomor`, `harga`, `foto`, `status`) VALUES
(1, 'Avanza Veloz', 'Toyota', 'B 1234 XYZ', 500000, '20260511080150_777.webp', 'Tersedia'),
(2, 'Innova Zenix', 'Toyota', 'E 2256 CC', 600000, '20260511080803_576.webp', 'Tersedia'),
(3, 'Daihatsu Xenia', 'Daihatsu', 'E 3421 PC', 500000, '20260511080934_350.jpg', 'Tersedia'),
(4, 'Daihatsu Sigra', 'Daihatsu', 'B 2987 PL', 400000, '20260511081055_759.jpg', 'Tersedia'),
(5, 'Stargazer', 'Hyundai ', 'B 5928 XR', 300000, '20260511081233_582.webp', 'Tersedia'),
(6, 'Almaz RS', 'Wuling ', 'E 4526 YC', 400000, '20260511081417_450.jpg', 'Tersedia'),
(7, 'Wuling Cortez', 'Wuling ', 'E 6587 DC', 400000, '20260511081536_938.jpg', 'Tersedia'),
(8, 'Terios', 'Daihatsu', 'B 3287 XY', 400000, '20260511081757_671.webp', 'Tersedia'),
(9, 'Kijang', 'Toyota', 'E 9807 LC', 200000, '20260511082147_395.webp', 'Tersedia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `id_mobil` (`id_mobil`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id_mobil`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
