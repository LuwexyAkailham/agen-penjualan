-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2024 at 09:44 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agenpenjualan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `image_url` text,
  `kategori` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `deskripsi`, `harga`, `lokasi`, `image_url`, `kategori`, `name`, `user_id`) VALUES
(1, 'baret dikit gk ngaruh nego ngotak dikit', '123456789', 'bandung', 'https://auto2000.co.id/berita-dan-tips/_next/image?url=https%3A%2F%2Fastradigitaldigiroomuat.blob.core.windows.net%2Fstorage-uat-001%2Fmobil-mpv-adalah.jpg&w=800&q=75', 'Kendaraan', '', NULL),
(10, 'minus kaca nego otak dikit', '12345678', 'bandung', 'https://completeselular.co.id/wp-content/uploads/2022/05/infinix-note-10-6gb-blk-500x500.webp', 'Gadget', '', NULL),
(11, 'penyok dikit gk ngaruh', '3456754234567', 'garut', 'https://www.electrolux.co.id/globalassets/appliances/fridge/etb4600b-a/etb4600b-a-fr-cl-1500x1500.png?width=464', 'Elektronik', '', NULL),
(12, 'baret dikit gk ngaruh nego ngotak dikit', '999999999', 'bekasi', 'https://imgcdn.oto.com/large/gallery/exterior/84/1366/yamaha-mio-z-slant-rear-view-full-image-202676.jpg', 'Kendaraan', '', NULL),
(14, 'hero lengkap emblem lengkap', '9999999988888', 'jakarta utara', 'https://imgop.itemku.com/?url=https%3A%2F%2Fd1x91p7vw3vuq8.cloudfront.net%2Fitemku-upload%2F202443%2F6jxatlj4e6t6l44n5coq.jpg&w=1033&q=75', 'Akun Game', '', NULL),
(17, 'ko', '1234567', 'bandung', 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUSEhIWFRUVFxcVFRUVFRgVFxUXFxcXFhcVFRcYHSggGBolHRYVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGw8PGS0dIB8tNy0tKy8vLzcrLzAuKysuLSstKy0zKy8tKy0rKysvLS0tLS8tKzYrKy0tLS0tLS0tLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAwEBAQEBAAAAAAAAAAAABAUGAwcCAQj/xABBEAACAQIDBAUHCgUEAwAAAAAAAQIDBAURIQYxNEEScnORsVFhcYGywdETFiIjM1KCkqGiJDKD0vAUQlNiQ2Ph/8QAGgEBAAMBAQEAAAAAAAAAAAAAAAECAwUGBP/EACsRAQACAAQFAwQCAwAAAAAAAAABAgMRMTIEITNBcRITFAUiUWGR8BXB0f/aAAwDAQACEQMRAD8A9xAAAAAAAAAPmpNRTk3kkm2/Ilq2B83FeMIuU5KMVvbeSKr5z22eXSn6fkqiX6x1MNtBjk69XNtqK/lh5M+bXOX+I+rCdTe1LLzvLPy5dJpv07j6K4HLm5eL9QmLZUjNufnJbfff5JfAfOS2++/yS+BS2ty8v5ZP0ZP3n1XxBZbpft/uJ9mPyj5+JlnkufnHbfff5JfAfOO2++/yS+Bk6l10s1qmt6eno8z9KbIdWb8r7yfYhSfqOJHaG4+cdt99/kl8B847b77/ACS+BhITflfeWFtN+UexB/kb/iGr+cdt99/kl8B847b77/JL4FbaM63D0K+zC/zr5aQlS2ntl/ul6qc34IsLK+p1l0qc1Jc+TXpT1XrMLiM3no33lVaYlUpVozjJ55pPn0k+Uvvev9N5M4HLkU+oz6srxyesAiYXfRr0o1Y/7s015JRbjJeppolnzOpE5xnAAAkAAAAAAAAAAAAAAAAK7aPhLjsavsSLEgY/wtfsansSJjVW+2XktV510v8AtFfok', 'Elektronik', 'mobile', 2),
(18, 'pecah', '14567890', 'bandung', 'https://auto2000.co.id/berita-dan-tips/_next/image?url=https%3A%2F%2Fastradigitaldigiroomuat.blob.core.windows.net%2Fstorage-uat-001%2Fmobil-mpv-adalah.jpg&w=800&q=75', 'Elektronik', 'infinix', 2),
(19, 'galaxy', '9999999999999999999999999999', 'sun', '', 'Elektronik', 'infinix', 4),
(20, 'galaxy', '9999999999999999999999999999', 'sun', '../uploads/peakpx (2).jpg', '', 'infinix', 4),
(21, 'minus kaca nego otak dikit', '12345678', 'jakarta utara', '../uploads/Screenshot (2).png', 'Elektronik', 'ilham', 5);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `user_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `item_id`, `user_id`, `jumlah`, `tanggal`) VALUES
(1, 1, 2, 1, '2024-10-05 20:05:00'),
(2, 1, 2, 1, '2024-10-05 20:05:04'),
(3, 1, 2, 1, '2024-10-05 20:06:42'),
(4, 1, 2, 1, '2024-10-05 20:08:52'),
(5, 1, 2, 1, '2024-10-05 20:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `user_role` enum('user','admin') DEFAULT 'user',
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `alamat`, `user_role`, `nomor_telepon`, `role`) VALUES
(2, 'ilham', '$2y$10$mpDNVqUAVZdT/8xdzTkRyeC/rUTYor4RBtVJNg16SGXXsIUK3WtG.', 'bandung', 'user', '0987654321', 'admin'),
(3, 'admin', '$2y$10$VMsZBZSFCJU7XTqq98U9x.QF0lEU2vz/aQys3waal00RewKi03d/i', 'bandung', 'admin', '0812345678', 'user'),
(4, 'rafly', '$2y$10$SGSEnwgdvbz4l25GA94TuuAhwUHTYArBIMHcpSLuf88PuxtbIykBa', 'badnung', 'user', '0812345678', 'user'),
(5, 'iqbal', '$2y$10$Ki51duP6UkupV.5kf/c5n.D8ucpNrNuJgz31H1WuVqwg2T88Lfmr.', 'garut', 'user', '0987654321', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
