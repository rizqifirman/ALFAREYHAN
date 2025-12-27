-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Des 2025 pada 05.10
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
-- Struktur dari tabel `garapans`
--

CREATE TABLE `garapans` (
  `id` int(11) UNSIGNED NOT NULL,
  `no_faktur` varchar(50) NOT NULL,
  `worker_id` int(11) UNSIGNED NOT NULL,
  `tanggal_spk` date NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `status` enum('Proses','Selesai','Batal','Revisi') NOT NULL DEFAULT 'Proses',
  `total_biaya` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bonus` decimal(15,2) DEFAULT 0.00,
  `potongan` decimal(15,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `garapans`
--

INSERT INTO `garapans` (`id`, `no_faktur`, `worker_id`, `tanggal_spk`, `tanggal_selesai`, `status`, `total_biaya`, `bonus`, `potongan`, `created_at`, `updated_at`) VALUES
(1, 'GP-251226-676', 2, '2025-12-26', '2025-12-26 19:03:53', 'Batal', 0.00, 0.00, 0.00, '2025-12-26 16:58:38', '2025-12-26 19:03:53'),
(2, 'GP-251226-766', 2, '2025-12-26', '2025-12-26 19:03:18', 'Batal', 0.00, 0.00, 0.00, '2025-12-26 17:01:46', '2025-12-26 19:03:18'),
(3, 'GP-251226-501', 1, '2025-12-28', '2025-12-26 19:02:39', 'Revisi', 180000.00, 0.00, 0.00, '2025-12-26 17:08:51', '2025-12-26 19:02:39'),
(4, 'GP-251226-561', 1, '2025-12-26', '2025-12-26 19:05:03', 'Revisi', 380.00, 0.00, 0.00, '2025-12-26 19:04:34', '2025-12-26 19:05:03'),
(5, 'GP-251226-419', 1, '2025-12-26', '2025-12-26 19:10:13', 'Revisi', 2380000.00, 0.00, 0.00, '2025-12-26 19:09:52', '2025-12-26 19:10:13'),
(6, 'GP-251226-908', 1, '2025-12-26', '2025-12-26 19:16:30', 'Selesai', 400000.00, 0.00, 0.00, '2025-12-26 19:16:11', '2025-12-26 19:16:30'),
(7, 'GP-251226-302', 1, '2025-12-26', '2025-12-26 19:17:38', 'Revisi', 120.00, 0.00, 0.00, '2025-12-26 19:17:23', '2025-12-26 19:17:38'),
(8, 'GP-251227-494', 1, '2025-12-27', '2025-12-27 03:28:18', 'Selesai', 600000.00, 0.00, 0.00, '2025-12-27 03:17:46', '2025-12-27 03:28:18'),
(9, 'GP-251227-770', 1, '2025-12-27', '2025-12-27 03:33:40', 'Selesai', 240.00, 0.00, 0.00, '2025-12-27 03:33:05', '2025-12-27 03:33:40'),
(10, 'GP-251227-945', 1, '2025-12-27', '2025-12-27 03:41:29', 'Selesai', 400.00, 0.00, 0.00, '2025-12-27 03:41:13', '2025-12-27 03:41:29'),
(11, 'GP-251227-298', 1, '2025-12-27', '2025-12-27 03:46:31', 'Selesai', 4000000.00, 0.00, 0.00, '2025-12-27 03:46:10', '2025-12-27 03:46:31'),
(12, 'GP-251227-237', 2, '2025-12-27', '2025-12-27 03:49:16', 'Selesai', 6000000.00, 0.00, 0.00, '2025-12-27 03:48:47', '2025-12-27 03:49:16'),
(13, 'GP-251227-461', 1, '2025-12-27', '2025-12-27 03:55:51', 'Selesai', 4000000.00, 0.00, 0.00, '2025-12-27 03:54:46', '2025-12-27 03:55:51'),
(14, 'GP-251227-432', 1, '2025-12-27', '2025-12-27 04:04:50', 'Selesai', 4000.00, 20000.00, 0.00, '2025-12-27 04:04:40', '2025-12-27 04:04:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `garapan_materials`
--

CREATE TABLE `garapan_materials` (
  `id` int(11) UNSIGNED NOT NULL,
  `garapan_id` int(11) UNSIGNED NOT NULL,
  `material_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `garapan_materials`
--

INSERT INTO `garapan_materials` (`id`, `garapan_id`, `material_id`, `qty`) VALUES
(1, 1, 1, 20),
(2, 3, 1, 10),
(3, 4, 1, 1),
(4, 5, 2, 1),
(5, 6, 1, 1),
(6, 7, 1, 10),
(7, 8, 2, 1),
(8, 9, 1, 1),
(9, 10, 1, 10),
(10, 11, 1, 1),
(11, 12, 1, 20),
(12, 13, 1, 20),
(13, 14, 2, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `garapan_products`
--

CREATE TABLE `garapan_products` (
  `id` int(11) UNSIGNED NOT NULL,
  `garapan_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `ongkos_satuan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `qty_target` int(11) NOT NULL,
  `qty_hasil` int(11) NOT NULL DEFAULT 0,
  `qty_retur` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `garapan_products`
--

INSERT INTO `garapan_products` (`id`, `garapan_id`, `product_id`, `ongkos_satuan`, `qty_target`, `qty_hasil`, `qty_retur`) VALUES
(1, 3, 2, 20000.00, 10, 9, 1),
(2, 4, 1, 20.00, 20, 19, 1),
(3, 5, 2, 20000.00, 120, 119, 1),
(4, 6, 2, 20000.00, 20, 20, 0),
(5, 7, 1, 20.00, 10, 6, 4),
(6, 8, 2, 20000.00, 30, 30, 0),
(7, 9, 1, 20.00, 12, 12, 0),
(8, 10, 1, 20.00, 20, 20, 0),
(9, 11, 2, 20000.00, 200, 200, 0),
(10, 12, 2, 20000.00, 300, 300, 0),
(11, 13, 2, 20000.00, 200, 200, 0),
(12, 14, 1, 20.00, 200, 200, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `labor_costs`
--

CREATE TABLE `labor_costs` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `kode_ongkos` varchar(20) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `detail` text DEFAULT NULL,
  `biaya` decimal(15,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) NOT NULL DEFAULT 'default_ongkos.png',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `labor_costs`
--

INSERT INTO `labor_costs` (`id`, `product_id`, `kode_ongkos`, `nama_produk`, `detail`, `biaya`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'O879', 'Koko Modern Al-Fatih', '{\"Size\":\"XL\"}', 20.00, '1766511795_bb895e95efeede0b49bd.webp', '2025-12-23 17:43:15', '2025-12-23 17:43:15'),
(2, 2, 'O751', 'Gamis Syar\'i Aisyah', '[]', 20000.00, 'default_ongkos.png', '2025-12-23 17:49:55', '2025-12-23 17:49:55');

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
(1, 'M-1766330648', 'Kain Toyobo Premium', 'Maroon', 'Yard', 106.00, 200000000.00, NULL, '1766330648_995d66729a41a9683f40.jpg', '2025-12-21 15:24:08', '2025-12-21 15:40:10'),
(2, 'M-1766331472', 'Kancing', 'Hitam', 'Pcs', 88.00, 50000.00, NULL, '1766331472_eeceaa91da4ab233b43a.jpg', '2025-12-21 15:37:52', '2025-12-21 15:40:10');

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
(28, '2025-12-21-023145', 'App\\Database\\Migrations\\Workers', 'default', 'App', 1766284512, 2),
(29, '2025-12-23-171649', 'App\\Database\\Migrations\\LaborCosts', 'default', 'App', 1766510350, 3),
(30, '2025-12-26-164812', 'App\\Database\\Migrations\\Garapan', 'default', 'App', 1766767730, 4),
(31, '2025-12-26-173007', 'App\\Database\\Migrations\\AddReturToGarapan', 'default', 'App', 1766770241, 5);

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
(1, 'P-1766283731', 'Koko Modern Al-Fatih', 'Maroon', 'Koko', 'Ayah', 'XL', 'Toyobo', 347, '1766283731_6fd358c7737954ba0c09.webp', '2025-12-21 02:22:11', '2025-12-21 15:15:33'),
(2, 'P-1766283789', 'Gamis Syar\'i Aisyah', 'Hijau', 'Gamis', 'Ibu', 'L', 'Jetblack', 898, '1766283789_791099d4004e53fd3d0b.webp', '2025-12-21 02:23:09', '2025-12-21 15:15:33');

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
-- Indeks untuk tabel `garapans`
--
ALTER TABLE `garapans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`);

--
-- Indeks untuk tabel `garapan_materials`
--
ALTER TABLE `garapan_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `garapan_products`
--
ALTER TABLE `garapan_products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `labor_costs`
--
ALTER TABLE `labor_costs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_ongkos` (`kode_ongkos`);

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
-- AUTO_INCREMENT untuk tabel `garapans`
--
ALTER TABLE `garapans`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `garapan_materials`
--
ALTER TABLE `garapan_materials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `garapan_products`
--
ALTER TABLE `garapan_products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `labor_costs`
--
ALTER TABLE `labor_costs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
