-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Des 2025 pada 17.52
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
-- Database: `db_alfareyhan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `materials`
--

CREATE TABLE `materials` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_material` varchar(50) NOT NULL,
  `nama_material` varchar(100) NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) NOT NULL,
  `stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_beli` decimal(15,2) NOT NULL DEFAULT 0.00,
  `atribut` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL DEFAULT 'default.png',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materials`
--

INSERT INTO `materials` (`id`, `kode_material`, `nama_material`, `warna`, `satuan`, `stok`, `harga_beli`, `atribut`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'M-1766330648', 'Kain Toyobo Premium', 'Maroon', 'Yard', 200.00, 200000000.00, NULL, '1766330648_995d66729a41a9683f40.jpg', '2025-12-21 15:24:08', '2025-12-21 15:40:10'),
(2, 'M-1766331472', 'Kancing', 'Hitam', 'Pcs', 100.00, 50000.00, NULL, '1766331472_eeceaa91da4ab233b43a.jpg', '2025-12-21 15:37:52', '2025-12-21 15:40:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(25, '2025-12-16-134259', 'App\\Database\\Migrations\\User', 'default', 'App', 1766283608, 1),
(26, '2025-12-17-182525', 'App\\Database\\Migrations\\Products', 'default', 'App', 1766283608, 1),
(27, '2025-12-19-133012', 'App\\Database\\Migrations\\Materials', 'default', 'App', 1766283608, 1),
(28, '2025-12-21-023145', 'App\\Database\\Migrations\\Workers', 'default', 'App', 1766284512, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `jenis` varchar(50) NOT NULL,
  `target` varchar(50) NOT NULL,
  `size` varchar(10) NOT NULL,
  `kain` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) NOT NULL DEFAULT 'default.png',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `kode_barang`, `nama_barang`, `warna`, `jenis`, `target`, `size`, `kain`, `stok`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'P-1766283731', 'Koko Modern Al-Fatih', 'Maroon', 'Koko', 'Ayah', 'XL', 'Toyobo', 90, '1766283731_6fd358c7737954ba0c09.webp', '2025-12-21 02:22:11', '2025-12-21 15:15:33'),
(2, 'P-1766283789', 'Gamis Syar\'i Aisyah', 'Hijau', 'Gamis', 'Ibu', 'L', 'Jetblack', 20, '1766283789_791099d4004e53fd3d0b.webp', '2025-12-21 02:23:09', '2025-12-21 15:15:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('owner','produksi','kasir','accounting') NOT NULL DEFAULT 'kasir',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`, `created_at`, `updated_at`) VALUES
(1, 'owner', '$2y$10$THb51t9uWv/7KgTn64qvU.uBBUaqQm0lRKQyy/Lx8yZcDY4TxTmda', 'Bapak Owner', 'owner', '2025-12-21 15:03:00', '2025-12-21 15:03:00'),
(2, 'produksi', '$2y$10$f3ViYm/qDlUTSOqNqfd2pupNP2CVDUOztXjHd8FeIf17g07qAQaWC', 'Staff Produksi', 'produksi', '2025-12-21 15:03:00', '2025-12-21 15:03:00'),
(3, 'kasir', '$2y$10$DP4NoQbSBA7gz5TBe/KYfOmrbVvAT3rJ2W7PLzyrXDSJNmnsqfRPC', 'Mba Kasir', 'kasir', '2025-12-21 15:03:01', '2025-12-21 15:03:01'),
(4, 'accounting', '$2y$10$2Pp5XW8RRGK4KnX5a0HCEu5jTdpmZ7CnW4e2LS3Ej8hLNTemmf1A.', 'Staff Akunting', 'accounting', '2025-12-21 15:03:01', '2025-12-21 15:03:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `workers`
--

CREATE TABLE `workers` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_tukang` varchar(50) NOT NULL,
  `nama_tukang` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `workers`
--

INSERT INTO `workers` (`id`, `kode_tukang`, `nama_tukang`, `telepon`, `alamat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'T-1766285788', 'Joko Widodo', '081298273833', 'Solo', 'Aktif', '2025-12-21 02:56:28', '2025-12-21 02:56:28'),
(2, 'T-1766331114', 'Bahlil', '109282828833', 'Pasuruan', 'Aktif', '2025-12-21 15:31:54', '2025-12-21 15:31:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_material` (`kode_material`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_tukang` (`kode_tukang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
