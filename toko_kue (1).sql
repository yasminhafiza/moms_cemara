-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 11:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_kue`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `foto_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `foto_admin`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrator', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Pasta'),
(2, 'Brownies'),
(3, 'Kue Kering'),
(4, 'Jajanan Pasar');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_user`, `nama`, `email`, `phone_number`, `password`) VALUES
(23, 'Yasmin Hafiza Isa Puteri', 'hafiza@gmail.com', '081510294628', '$2y$10$v9w9BZV2YZpaxObmepwBqOk1K0xrcnWcHxkwg5g1TJtnK9jvWxxjq'),
(24, 'yasminhafiza', 'yasmin.h@gmail.com', '081510292719', '$2y$10$/BpLxPgVWlJwrgmCAzmcXuN.Yz8tw3rF6EOZs/itj3tzDbEp2vv3K'),
(25, 'yasminhafiza', 'yayaya@gmail.com', '081510292719', '$2y$10$lVZujKpIypaNJHIuSd1Wa.1trMMEvifnNi.9dFg.xlSR3iidZcBFC');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pesanan`, `metode_pembayaran`, `total_bayar`, `tanggal_bayar`) VALUES
(47, 61, 'BRI', 93000.00, '2025-01-06 04:02:24'),
(48, 62, 'BNI', 260000.00, '2025-01-10 04:42:45'),
(49, 63, 'Mandiri', 90000.00, '2025-01-10 04:52:01'),
(54, 68, 'BTN', 90000.00, '2025-01-10 05:22:08'),
(55, 69, 'BI', 90000.00, '2025-01-10 08:39:34'),
(56, 70, 'BI', 87000.00, '2025-01-10 09:13:04'),
(57, 71, 'BNI', 566500.00, '2025-01-13 06:16:10'),
(58, 72, 'BCA', 58000.00, '2025-01-13 06:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_kurir` int(11) DEFAULT NULL,
  `metode_pengiriman` varchar(50) DEFAULT NULL,
  `waktu_pengiriman` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_pengiriman` varchar(50) DEFAULT NULL,
  `nama_kurir` varchar(255) NOT NULL,
  `nomor_telepon_kurir` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id_pengiriman`, `id_pesanan`, `id_kurir`, `metode_pengiriman`, `waktu_pengiriman`, `status_pengiriman`, `nama_kurir`, `nomor_telepon_kurir`) VALUES
(5, 62, NULL, NULL, '2025-01-10 09:08:00', 'Dikirim', 'yaya', '08152029387');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `catatan` text DEFAULT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'diproses',
  `resi` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `ekspedisi` varchar(255) NOT NULL,
  `shipping` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `alamat_pengiriman`, `catatan`, `tanggal_pesanan`, `status`, `resi`, `total`, `ekspedisi`, `shipping`, `payment_method`) VALUES
(61, 20, 'Jl. Merdeka No. 25 Jakarta Selatan, 12410', 'Tanpa cabai, ekstra keju', '2025-01-06 11:02:24', 'Diproses', '888888', 93000, 'grab-instan', 17000, 'BRI'),
(62, 22, 'visar indah pratama jl kenanga 3 blok vb 3 no 5', 'di buble wrap semua yaaaa :))', '2025-01-10 11:42:45', 'Dikirim', '12345678900', 260000, 'grab-instan', 17000, 'BNI'),
(63, 22, '', '', '2025-01-10 11:52:01', 'pending', '', 90000, 'gosend-sameday', 20000, 'Mandiri'),
(68, 22, '', '', '2025-01-10 12:22:08', 'pending', '', 90000, 'gosend-sameday', 20000, 'BTN'),
(69, 22, '', '', '2025-01-10 15:39:34', 'pending', '', 90000, 'gosend-sameday', 20000, 'BI'),
(70, 22, '', '', '2025-01-10 16:13:04', 'pending', '', 87000, 'gosend-instan', 19000, 'BI'),
(71, 22, 'Nama Penerima: Yasmin Hafiza Isa Puteri  \r\nAlamat: Jl. Kebon Jeruk Raya No. 123, RT 05/RW 03, Kelurahan Kebon Jeruk,  \r\nKecamatan Kebon Jeruk, Jakarta Barat, DKI Jakarta, 11530  \r\nNomor Telepon: 0812-3456-7890  \r\nEmail (opsional): yasmin@example.com  \r\n', 'Catatan: \r\n- Mohon packing barang dengan bubble wrap agar aman selama pengiriman.\r\n- Kirimkan pesanan pada jam kerja (09.00 - 17.00).\r\n- Jika kurir tidak menemukan alamat, silakan hubungi nomor 0812-3456-7890.\r\n', '2025-01-13 13:16:10', 'pending', '', 566500, 'grab-instan', 17000, 'BNI'),
(72, 22, 'ssssss', 'bahbdad', '2025-01-13 13:27:12', 'pending', '', 58000, 'gosend-sameday', 20000, 'BCA');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_detail`, `id_pesanan`, `id_produk`, `quantity`, `subtotal`) VALUES
(95, 71, 8, 1, 12000),
(96, 71, 9, 1, 3000),
(97, 71, 10, 1, 2000),
(98, 71, 11, 1, 3500),
(99, 71, 2, 1, 5000),
(100, 71, 12, 1, 70000),
(101, 71, 13, 1, 95000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`) VALUES
(1, 1, 'Maccaroni Panggang', 'Gurihnya keju yang berpadu sempurna dengan macaroni panggang lembut, membuat setiap suapan terasa begitu memuaskan.', 38000.00, 13, 'mp.jpeg'),
(2, 2, 'Fudgy Brownies Mini', 'Gurihnya keju yang berpadu sempurna dengan macaroni panggang lembut, membuat setiap suapan terasa begitu memuaskan.mpor', 5000.00, 14, 'fudgy_brownies.png'),
(3, 1, 'Lasagna Panggang', 'Nikmati lapisan keju meleleh dan saus gurih yang lumer di setiap gigitan lasagna panggang kami, sempurna untuk memanjakan lidah Anda!', 70000.00, 12, 'Lasagna.png'),
(4, 1, 'Spagetti Panggang', 'Spaghetti panggang kami hadir dengan saus spesial dan keju melimpah, memberikan cita rasa yang tak terlupakan di setiap suapannya!', 38000.00, 15, 'Spageti panggang.png'),
(5, 3, 'Kastangel', 'Nikmati lapisan keju meleleh dan saus gurih yang lumer di setiap gigitan lasagna panggang kami, sempurna untuk memanjakan lidah Anda!', 70000.00, 13, 'kastangel.png'),
(6, 3, 'Lidah Kucing Ori', 'Gurihnya keju yang berpadu sempurna dengan macaroni panggang lembut, membuat setiap suapan terasa begitu memuaskan.mpor', 68000.00, 3, 'lidah_kucing.png'),
(7, 3, 'Nastar', 'Spaghetti panggang kami hadir dengan saus spesial dan keju melimpah, memberikan cita rasa yang tak terlupakan di setiap suapannya!', 75000.00, 3, 'nastar.png'),
(8, 4, 'Centik Manis', 'Nikmati lapisan keju meleleh dan saus gurih yang lumer di setiap gigitan lasagna panggang kami, sempurna untuk memanjakan lidah Anda!', 12000.00, 3, 'centik_manis.png'),
(9, 4, 'Kue Soes', 'Gurihnya keju yang berpadu sempurna dengan macaroni panggang lembut, membuat setiap suapan terasa begitu memuaskan.', 3000.00, 3, 'kue_sus.png'),
(10, 4, 'Kue Talam', 'Kue talam adalah kue tradisional Indonesia yang terbuat dari tepung beras, santan, dan bahan-bahan lain. Kue ini dimasak dalam cetakan yang disebut talam, yang berarti \"nampan\" dalam bahasa Indonesia. Kue talam memiliki rasa manis dan gurih, serta tekstur yang lembut.', 2000.00, 3, 'kue_talam.png'),
(11, 4, 'Pie Buah', 'Pie buah biasanya disajikan sebagai camilan atau suguhan, dan sering kali berbentuk mini. Buah-buahan yang biasa digunakan untuk topping pie buah adalah stroberi, kiwi, jeruk, dan anggur.', 3500.00, 3, 'pie_buah.png'),
(12, 2, 'Brownies Kukus ', 'Brownies kukus adalah kue lembut dan moist yang dibuat dengan cara dikukus. Memiliki rasa cokelat yang kaya dan tekstur yang lebih basah dibandingkan brownies panggang, membuatnya menjadi pilihan favorit untuk pencinta kue cokelat.', 70000.00, 3, 'brownies_kukus.png'),
(13, 2, 'Fudgy Brownies 20x20 cm', ' brownies panggang bertekstur padat dan lembap dengan rasa cokelat yang intens. Dibuat dalam loyang ukuran 20x20 cm', 95000.00, 3, 'fudgy brownies2.png');

-- --------------------------------------------------------

--
-- Table structure for table `produk_foto`
--

CREATE TABLE `produk_foto` (
  `id_produk_foto` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_foto`
--

INSERT INTO `produk_foto` (`id_produk_foto`, `id_produk`, `nama_produk_foto`) VALUES
(1, 1, 'mp.jpeg'),
(2, 2, 'fudgy_brownies.png'),
(3, 3, 'Lasagna.png'),
(4, 4, 'Spageti panggang.png'),
(5, 5, 'kastangel.png'),
(6, 6, 'lidah_kucing.png'),
(7, 7, 'nastar.png'),
(8, 8, 'centik_manis.png'),
(9, 9, 'kue_sus.png'),
(10, 10, 'kue_talam.png'),
(11, 11, 'pie_buah.png'),
(12, 12, 'brownies_kukus.png'),
(13, 13, 'fudgy brownies2.png');

-- --------------------------------------------------------

--
-- Table structure for table `status_pesanan`
--

CREATE TABLE `status_pesanan` (
  `id_status` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `status` enum('diproses','dikirim','diterima') DEFAULT 'diproses',
  `waktu_status` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pesanan`
--

INSERT INTO `status_pesanan` (`id_status`, `id_pesanan`, `status`, `waktu_status`) VALUES
(47, 61, '', '2025-01-06 11:02:24'),
(48, 62, '', '2025-01-10 11:42:45'),
(49, 63, '', '2025-01-10 11:52:01'),
(54, 68, '', '2025-01-10 12:22:08'),
(55, 69, '', '2025-01-10 15:39:34'),
(56, 70, '', '2025-01-10 16:13:04'),
(57, 71, '', '2025-01-13 13:16:10'),
(58, 72, '', '2025-01-13 13:27:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`,`id_produk`),
  ADD KEY `id_user_2` (`id_user`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_kurir` (`id_kurir`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `produk_foto`
--
ALTER TABLE `produk_foto`
  ADD PRIMARY KEY (`id_produk_foto`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `produk_foto`
--
ALTER TABLE `produk_foto`
  MODIFY `id_produk_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `pengiriman_ibfk_2` FOREIGN KEY (`id_kurir`) REFERENCES `kurir` (`id_kurir`);

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `produk_foto`
--
ALTER TABLE `produk_foto`
  ADD CONSTRAINT `produk_foto_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD CONSTRAINT `status_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
