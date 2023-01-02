-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Okt 2022 pada 18.15
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_jadwal` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_mesin` varchar(40) NOT NULL,
  `point_check` varchar(30) NOT NULL,
  `tanggal_jadwal` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `tanggal_selesai` varchar(20) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `id_jadwal`, `tanggal`, `nama_mesin`, `point_check`, `tanggal_jadwal`, `status`, `tanggal_selesai`) VALUES
(1, 'm0', '0000-00-00', 'KLSWWW', 'Oli0', '0000-00-00', 3, '-'),
(2, 'm1', '2022-09-01', 'KLSWWW', 'Oli1', '2022-09-01', 2, '2022-10-09 20:07:51'),
(3, 'm2', '2022-09-02', 'KLSWWW', 'Oli2', '2022-09-02', 3, '-'),
(4, 'm3', '2022-09-03', 'apa3', 'Oli3', '2022-09-03', 2, '-'),
(5, 'm4', '2022-09-04', 'apa4', 'Oli4', '2022-09-04', 1, '-'),
(6, 'm5', '2022-09-05', 'apa5', 'Oli5', '2022-09-05', 3, '-'),
(7, 'm6', '2022-09-06', 'apa6', 'Oli6', '2022-09-06', 3, '-'),
(8, 'm7', '2022-09-07', 'apa7', 'Oli7', '2022-09-07', 1, '-'),
(9, 'm8', '2022-09-08', 'apa8', 'Oli8', '2022-09-08', 2, '-'),
(10, 'm9', '2022-09-09', 'apa9', 'Oli9', '2022-09-09', 1, '-'),
(11, 'IK0999222', '2022-10-08', 'ewqeq', 'Filter Oil', '2022-10-09', 2, '-'),
(12, 'IK0999222', '2022-10-08', 'ewqeq', 'Filter Oil', '2022-10-09', 1, '2022-10-09 20:08:14'),
(13, 'IK09992222', '2022-10-08', 'ewqeq', 'Filter Pelumas', '2022-10-09', 2, '2022-10-09 20:08:00'),
(14, 'IK09992222', '2022-10-08', 'ewqeq', 'Oil Coller', '2022-10-28', 2, '2022-10-09 20:08:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mesin`
--

CREATE TABLE `mesin` (
  `id` int(11) NOT NULL,
  `id_mesin` varchar(11) NOT NULL,
  `nama_mesin` varchar(150) NOT NULL,
  `merk_mesin` varchar(70) NOT NULL,
  `tahun_pembuatan` year(4) NOT NULL,
  `tahun_pakai` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mesin`
--

INSERT INTO `mesin` (`id`, `id_mesin`, `nama_mesin`, `merk_mesin`, `tahun_pembuatan`, `tahun_pakai`) VALUES
(22, 'klxwewq', 'ewqeq', 'eqwewq', 2022, 2023),
(23, 'eqwweq', 'KLSWWW', 'KLX', 2022, 2023);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notif_admin`
--

CREATE TABLE `notif_admin` (
  `id` int(11) NOT NULL,
  `id_perbaikan` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `tipe` varchar(8) NOT NULL,
  `tanggal` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notif_admin`
--

INSERT INTO `notif_admin` (`id`, `id_perbaikan`, `status`, `tipe`, `tanggal`) VALUES
(1, 'eqewq', 2, 'Segera', '2202-12-12'),
(2, 'ewqeqw1', 2, 'Segera', '2202-12-13'),
(3, 'PRB253614', 2, 'Segera', '2022-10-10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notif_operator`
--

CREATE TABLE `notif_operator` (
  `id` int(11) NOT NULL,
  `id_perbaikan` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `selesai` datetime NOT NULL,
  `nama_mesin` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `notif_operator`
--

INSERT INTO `notif_operator` (`id`, `id_perbaikan`, `status`, `selesai`, `nama_mesin`) VALUES
(1, 'eqewq', 1, '2022-10-01 00:00:00', 'ewqeq'),
(4, 'm122', 2, '2022-10-10 22:44:38', 'KLSWWW'),
(5, 'm9', 1, '2022-10-10 22:45:16', 'apa9'),
(6, 'okqqwewq', 2, '2022-10-10 22:56:30', 'KLSWWW'),
(8, 'm8', 1, '2022-10-10 23:05:58', 'apa8'),
(9, 'PRB253614', 2, '2022-10-10 23:13:40', 'KLSWWW'),
(10, 'eqwewq', 1, '2022-10-10 23:14:03', 'ewqeq');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbaikan`
--

CREATE TABLE `perbaikan` (
  `id` int(11) NOT NULL,
  `id_perbaikan` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `user` varchar(25) NOT NULL,
  `mesin` varchar(40) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `tanggal_selesai` varchar(20) NOT NULL DEFAULT '-',
  `tindakan` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbaikan`
--

INSERT INTO `perbaikan` (`id`, `id_perbaikan`, `tanggal`, `user`, `mesin`, `judul`, `keterangan`, `status`, `tanggal_selesai`, `tindakan`) VALUES
(2, 'm122', '2022-09-02', 'satrio', 'ewqeq', 'Oli1', 'poewqkew  ditambahkan kerusakan', 3, '-', 'Segera'),
(3, 'okqqwewq', '2022-09-02', 'satrio', 'ewqeq', 'Oli2', '2022-09-02', 3, '2022-10-09 00:41:57', ''),
(4, 'm3', '2022-09-03', 'ucup3', 'apa3', 'Oli3', '2022-09-03', 3, '2022-10-10 04:17:21', ''),
(5, 'm4', '2022-09-04', 'ucup4', 'apa4', 'Oli4', '2022-09-04', 1, '-', ''),
(6, 'm5', '2022-09-05', 'ucup5', 'apa5', 'Oli5', '2022-09-05', 2, '-', ''),
(7, 'm6', '2022-09-06', 'ucup6', 'apa6', 'Oli6', '2022-09-06', 1, '-', ''),
(8, 'm7', '2022-09-07', 'ucup7', 'apa7', 'Oli7', '2022-09-07', 2, '-', ''),
(9, 'm8', '2022-09-08', 'ucup8', 'apa8', 'Oli8', '2022-09-08', 3, '2022-10-10 23:05:58', ''),
(10, 'm9', '2022-09-09', 'ucup9', 'apa9', 'Oli9', '2022-09-09', 3, '2022-10-10 22:45:16', ''),
(11, 'm122', '2022-10-08', 'satrio', 'KLSWWW', 'okesiap', 'weqeqeq', 3, '2022-10-10 22:44:38', 'Segera'),
(12, 'okqqwewq', '2022-10-10', 'satrio', 'KLSWWW', 'ewqeq', 'ewqewew', 3, '2022-10-10 22:56:30', 'Segera'),
(13, 'eqwewq', '2022-10-15', 'satrio', 'ewqeq', 'ewqewq', 'ewqewq', 3, '2022-10-10 23:14:03', ''),
(14, 'PRB60512', '2022-10-10', 'satrio', 'weqeqw', 'okesiap', 'eqwewq', 1, '-', 'Segera'),
(15, 'PRB381913', '2022-10-10', 'satrio', 'KLSWWW', 'okesiap1', '123', 1, '-', 'Segera'),
(16, 'PRB253614', '2022-10-10', 'satrio', 'KLSWWW', 'Rusak Di dalem', '123', 3, '2022-10-10 23:13:40', 'Segera');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(70) NOT NULL,
  `role` varchar(15) NOT NULL,
  `mesin` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role`, `mesin`) VALUES
(1, 'satrio', 'wibowosatrio322@gmail.com', '$2y$10$hFnm9LW.XztV2C7YPJZrkOGdAVCcA5theKlQ7OPCqXB62eo4UJkdq', 'Operator', 'KLSWWW'),
(6, 'satrio44', 'wibowo4@gmail.com', '$2y$10$0mkTFjPGRqjT65f9.a8e8.xqxQ8IUnhnpRBW6FxkjLfdur.on8tnq', 'Direktur', NULL),
(7, 'satrio5', 'wibowo5@gmail.com', '$2y$10$0mkTFjPGRqjT65f9.a8e8.xqxQ8IUnhnpRBW6FxkjLfdur.on8tnq', 'Admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notif_admin`
--
ALTER TABLE `notif_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notif_operator`
--
ALTER TABLE `notif_operator`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `perbaikan`
--
ALTER TABLE `perbaikan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `notif_admin`
--
ALTER TABLE `notif_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notif_operator`
--
ALTER TABLE `notif_operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `perbaikan`
--
ALTER TABLE `perbaikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
