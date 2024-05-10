-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Bulan Mei 2024 pada 12.09
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
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti`
--

CREATE TABLE `bukti` (
  `id_bukti` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `foto_bukti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_pesanan` int(11) NOT NULL,
  `subtotal_harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah_pesanan`, `subtotal_harga`) VALUES
(28, 'IZIK7D6I20240509', 2, 2, '960000'),
(29, 'PD3CPB7620240509', 5, 1, '350000'),
(30, 'KK4P5C2L20240510', 5, 1, '350000'),
(31, 'SLNER15N20240510', 4, 1, '430000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `nama_member` varchar(100) NOT NULL,
  `nohp_member` varchar(15) NOT NULL,
  `alamat_member` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id_member`, `nama_member`, `nohp_member`, `alamat_member`, `email`, `username`, `password`, `create_datetime`) VALUES
(1, 'Imelda Putri', '08123731823', 'Tenggarong', 'imelda@gmail.com', 'imeldaputri', '12345', '2024-04-30 19:56:15'),
(4, 'lisya', '098877665544', 'jl.sentosa', 'alisya@gmail.com', 'lisya', '123', '2024-05-10 12:57:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `nohp_pembeli` varchar(15) NOT NULL,
  `alamat_pembeli` varchar(255) NOT NULL,
  `email_pembeli` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(255) NOT NULL,
  `nama_pesanan` varchar(255) NOT NULL,
  `alamat_pesanan` varchar(255) NOT NULL,
  `no_hp_pesanan` varchar(255) NOT NULL,
  `email_pesanan` varchar(255) NOT NULL,
  `total_harga_pesanan` varchar(255) NOT NULL,
  `status_pesanan` enum('Menunggu Pembayaran','Diproses','Dikirim','Ditolak','Selesai') NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `jenis_pembayaran` enum('COD','Transfer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama_pesanan`, `alamat_pesanan`, `no_hp_pesanan`, `email_pesanan`, `total_harga_pesanan`, `status_pesanan`, `tanggal_pesanan`, `jenis_pembayaran`) VALUES
('KK4P5C2L20240510', 'Imelda Putri', 'Tenggarong', '08123731823', 'imelda@gmail.com', '325000', 'Menunggu Pembayaran', '2024-05-10', 'COD'),
('SLNER15N20240510', 'Imelda Putri', 'Tenggarong', '08123731823', 'imelda@gmail.com', '397000', 'Menunggu Pembayaran', '2024-05-10', 'COD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_model` varchar(255) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `foto_produk` varchar(255) NOT NULL,
  `deskripsi_produk` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_model`, `harga_produk`, `foto_produk`, `deskripsi_produk`) VALUES
(1, 'Angela Raya Mom Regina', 480000, 'Angela Raya Mom Regina.PNG', '- Dada jersey printing, mix organza bagian lengan\r\n- Rok ceruty\r\n- LD 110-115 cm\r\n- PB 143 cm\r\n- Busui dan karet pinggang samping\r\n- Khimar ceruty printing uk. mini'),
(2, 'Angela Raya Mom Ika', 480000, 'Angela Raya Mom Ika.PNG', '- Dada jersey printing, mix organza bagian lengan\r\n- Rok ceruty\r\n- LD 110-115 cm\r\n- PB 143 cm\r\n- Busui dan karet pinggang samping\r\n- Khimar ceruty printing uk. mini'),
(3, 'Alqiblat Daily', 315000, 'Alqiblat Daily.jpeg', '- LD 110 cm\r\n- PB 142 cm\r\n- Resleting depan busui\r\n- Saku kanan kiri\r\n- Tangan resleting aplikasi kancing dan tali\r\n- Jilbab : french khimar bisa dijadikan niqab'),
(4, 'Arsyila Series', 430000, 'Arsyila Series.jpeg', '- Armani silk print mix armani silk polos premium\r\n- LD 110 cm\r\n- PB 143 cm\r\n- Zipper belakang non busui\r\n- Wudhu friendly\r\n- Aplikasi payet di sulam manual'),
(5, 'Asyarifah Raya', 350000, 'Asyarifah Raya.jpeg', '- Dada jersey printing, mix organza bagian lengan\r\n- Rok ceruty printing epson\r\n- LD 110-115 cm\r\n- PB 143 cm\r\n- Busui & karet pinggang samping\r\n- Khimar ceruty printing '),
(6, 'Delisa Set Hijab Arsyakayla', 380000, 'Delisa Set Hijab Arsyakayla.jpeg', '- LD 110 cm\r\n- PB 143 cm'),
(7, 'Hawwa Syari', 410000, 'Hawwa Syari.jpeg', '- LD 110 cm\r\n- PB 142 cm\r\n- Dada jersey\r\n- Resleting depan (busui)\r\n- Zipper tangan (Wudhu friendly)\r\n- Saku kanan kiri\r\n- karet kanan kiri'),
(8, 'Jeans Set', 300000, 'Jeans Set.jpeg', '- PB 130 cm\r\n- LD 110 cm'),
(9, 'Lunara Series by Alya Syari', 395000, 'Lunara Series by Alya Syari.jpeg', '- LD 110-115 cm\r\n- PB 145 cm\r\n- Busui Dan Karet Pinggang Samping\r\n- Zipper Tangan (Wudhu Friendly)'),
(10, 'Marwah Series by Dzira', 415000, 'Marwah Series by Dzira.jpeg', '- LD 110 cm\r\n- PB 142 cm\r\n- Dada jersey\r\n- Resleting depan (busui)\r\n- Zipper tangan (wudhu friendly)\r\n- karet kanan kiri'),
(11, 'Umayra Series by Alya', 450000, 'Umayra Series by Alya.jpeg', '- LD 110 cm\r\n- PB 142 cm\r\n- Tangan resleting\r\n- Resleting belakang\r\n- Full puring'),
(12, 'Salwah Serief by Farfadh', 415000, 'Salwah Serief by Farfadh.jpeg', '- LD 110 cm\r\n- PB 142 cm\r\n- Resleting belakang'),
(13, 'Nirmala Maxidress', 350000, 'Nirmala Maxidress.PNG', '- material jeans wash\r\n- Bordir\r\n- LD 120 cm\r\n- PB 135 cm\r\n- Full kancing'),
(14, 'Syarifah Series', 310000, 'Syarifah Series.jpeg', '- Resleting depan (busui)\r\n- saku kanan kiri\r\n- karet sanoubg\r\n- tangan sleting\r\n- LD 110 cm\r\n- PB 142 cm'),
(15, 'Syahnaz Series', 380000, 'Syahnaz Series.jpeg', '- Ceruty armany mix brukat katun france\r\n- ukuran hijab 110x110\r\n- LD 110 cm\r\n- PB 142 cm\r\n- Busui dan wudhu friendly');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `tanggal_rating` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id_rating`, `id_produk`, `review`, `rating`, `tanggal_rating`) VALUES
(1, 2, 'Bagus', 5, '2024-05-07'),
(2, 2, 'Bahan haluss', 4, '2024-05-07'),
(4, 13, 'Baguss skliiii ', 5, '2024-05-08'),
(5, 14, 'bagus', 4, '2024-05-10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bukti`
--
ALTER TABLE `bukti`
  ADD PRIMARY KEY (`id_bukti`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indeks untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_produk` (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `bukti`
--
ALTER TABLE `bukti`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pembeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
