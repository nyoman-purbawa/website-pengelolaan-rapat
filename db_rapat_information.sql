-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2024 pada 10.07
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rapat_information`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `notulen_upload_download`
--

CREATE TABLE `notulen_upload_download` (
  `id_notulen` int(11) NOT NULL,
  `nama_rapat` varchar(200) NOT NULL,
  `tanggal_rapat` date NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(200) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notulen_upload_download`
--

INSERT INTO `notulen_upload_download` (`id_notulen`, `nama_rapat`, `tanggal_rapat`, `filename`, `filesize`, `filetype`, `upload_date`) VALUES
(95, 'Rapat Siswa', '2024-06-12', '5e10714238962d6c.pdf', 1313441, 'application/pdf', '2024-07-02 20:49:28'),
(96, 'Rapat Wali Murid', '2024-12-12', '10a6f7c8faf97c15.pdf', 1313441, 'application/pdf', '2024-07-02 20:50:39'),
(97, 'Rapat Koperasi Sekolah', '2024-07-02', '4c611fc619d25576.pdf', 1313441, 'application/pdf', '2024-07-02 20:52:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_absen`
--

CREATE TABLE `tb_absen` (
  `id_absen` int(11) NOT NULL,
  `id_rapatt` int(11) NOT NULL,
  `nama_absen` varchar(255) NOT NULL,
  `category_absen` varchar(255) NOT NULL,
  `gambar_ttd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_create_rapat`
--

CREATE TABLE `tb_create_rapat` (
  `id_rapat` int(11) NOT NULL,
  `nama_rapat` mediumtext NOT NULL,
  `tgl_rapat` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan_rapat` mediumtext NOT NULL,
  `gambar_rapat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kop_laporan`
--

CREATE TABLE `tb_kop_laporan` (
  `id_kop` int(11) NOT NULL,
  `title_kop` varchar(1000) NOT NULL,
  `nama_lembaga` varchar(1000) NOT NULL,
  `jalan` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kop_laporan`
--

INSERT INTO `tb_kop_laporan` (`id_kop`, `title_kop`, `nama_lembaga`, `jalan`) VALUES
(1, 'HEADER', 'LEMBAGA NILAI AWLAN DAN INI', 'Jl.Nakula dan nilai awlaan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekap_data_rapat`
--

CREATE TABLE `tb_rekap_data_rapat` (
  `id_rekap_rapat` int(11) NOT NULL,
  `fk_rekap_rapat` int(11) NOT NULL,
  `desc_rekap` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_upload_notula`
--

CREATE TABLE `tb_upload_notula` (
  `id_notula` int(255) NOT NULL,
  `nama_rapat` varchar(255) NOT NULL,
  `tanggal_rapat` date NOT NULL,
  `nama_notula` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_upload_notula`
--

INSERT INTO `tb_upload_notula` (`id_notula`, `nama_rapat`, `tanggal_rapat`, `nama_notula`) VALUES
(1, 'asdf', '0012-12-12', 'Prostate_Cancer.csv'),
(2, 'Rapat Wali Murid', '0012-12-12', 'Artikel Web.pdf'),
(3, 'adf', '0012-12-12', '1462100102_INyomanPurbawa_Tugas_12.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user_login`
--

CREATE TABLE `tb_user_login` (
  `no_induk_guru` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user_login`
--

INSERT INTO `tb_user_login` (`no_induk_guru`, `username`, `password`, `roles`) VALUES
(1462100102, 'inyomanpurbawa', '123', 'admin'),
(1462100103, 'purbawa', '123', 'user'),
(1462100104, 'nyomanpurbawa', '123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `notulen_upload_download`
--
ALTER TABLE `notulen_upload_download`
  ADD PRIMARY KEY (`id_notulen`);

--
-- Indeks untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `id_rapatt` (`id_rapatt`);

--
-- Indeks untuk tabel `tb_create_rapat`
--
ALTER TABLE `tb_create_rapat`
  ADD PRIMARY KEY (`id_rapat`);

--
-- Indeks untuk tabel `tb_kop_laporan`
--
ALTER TABLE `tb_kop_laporan`
  ADD PRIMARY KEY (`id_kop`);

--
-- Indeks untuk tabel `tb_rekap_data_rapat`
--
ALTER TABLE `tb_rekap_data_rapat`
  ADD PRIMARY KEY (`id_rekap_rapat`),
  ADD KEY `fk_rekap_rapat` (`fk_rekap_rapat`);

--
-- Indeks untuk tabel `tb_upload_notula`
--
ALTER TABLE `tb_upload_notula`
  ADD PRIMARY KEY (`id_notula`);

--
-- Indeks untuk tabel `tb_user_login`
--
ALTER TABLE `tb_user_login`
  ADD PRIMARY KEY (`no_induk_guru`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `notulen_upload_download`
--
ALTER TABLE `notulen_upload_download`
  MODIFY `id_notulen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  MODIFY `id_absen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2426;

--
-- AUTO_INCREMENT untuk tabel `tb_create_rapat`
--
ALTER TABLE `tb_create_rapat`
  MODIFY `id_rapat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT untuk tabel `tb_kop_laporan`
--
ALTER TABLE `tb_kop_laporan`
  MODIFY `id_kop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_rekap_data_rapat`
--
ALTER TABLE `tb_rekap_data_rapat`
  MODIFY `id_rekap_rapat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT untuk tabel `tb_upload_notula`
--
ALTER TABLE `tb_upload_notula`
  MODIFY `id_notula` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD CONSTRAINT `tb_absen_ibfk_1` FOREIGN KEY (`id_rapatt`) REFERENCES `tb_create_rapat` (`id_rapat`);

--
-- Ketidakleluasaan untuk tabel `tb_rekap_data_rapat`
--
ALTER TABLE `tb_rekap_data_rapat`
  ADD CONSTRAINT `tb_rekap_data_rapat_ibfk_1` FOREIGN KEY (`fk_rekap_rapat`) REFERENCES `tb_absen` (`id_rapatt`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
