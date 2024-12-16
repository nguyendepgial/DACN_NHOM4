-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 14, 2024 lúc 06:19 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `moc_nguyen`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Phòng Khách', 'phong-khach'),
(2, 'Phòng Ngủ', 'phong-ngu'),
(3, 'Phòng Bếp', 'phong-bep'),
(4, 'Trang Trí', 'trang-tri'),
(5, 'Phòng Thờ', 'phong-tho'),
(6, 'Phòng Làm Việc', 'phong-lam-viec');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','processed') DEFAULT 'pending',
  `resolution` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `category`, `message`, `created_at`, `status`, `resolution`) VALUES
(4, 25, 'nguyen@gmail.com', 'nguyen@gmail.com', 'Vấn đề đặt hàng', 't dat hang dc chưa', '2024-12-10 06:39:39', 'processed', 'ok'),
(5, 10, 'thanhnguyenle123dmx@gmail.com', 'thanhnguyenle123dmx@gmail.com', 'Bảo hành', '2', '2024-12-11 14:08:02', 'processed', 's'),
(6, 10, 'thanhnguyenle123dmx@gmail.com', 'thanhnguyenle123dmx@gmail.com', 'Vấn đề tài khoản', 'sdsd', '2024-12-11 14:11:57', 'processed', 'sd'),
(8, 30, 'levodai12@gmail.com', 'levodai12@gmail.com', 'Vấn đề khác', 'tình yêu là gì>?????\r\n', '2024-12-13 06:28:05', 'processed', 'cc'),
(9, 10, 'thanhnguyenle123dmx@gmail.com', 'thanhnguyenle123dmx@gmail.com', 'Bảo hành', 'a', '2024-12-13 15:38:23', 'processed', 's');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `ma_khach_hang` int(11) NOT NULL,
  `ten_khach_hang` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `so_dien_thoai` varchar(10) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'Chưa cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`ma_khach_hang`, `ten_khach_hang`, `so_dien_thoai`, `email`, `username`, `password`, `role`, `ngay_tao`, `avatar`, `address`) VALUES
(10, 'nguyen1', '0354331794', 'thanhnguyenle123dmx@gmail.com', NULL, '$2y$10$vhpkzGIPAmNHKd8QYoSIfuoZse3nbp.o20X35os/VxbpNDsMcvxQe', 'user', '2024-11-24 12:48:03', 'uploads/avatars/675c7b6487c41-avthjhj.jpg', '290/34'),
(13, 'Admin User', NULL, NULL, 'admin', '$2y$10$PKO8iH0xbnW0d/RKllut.eB1o5wtiNIKhsvHIviVraNETVayYIq1K', 'admin', '2024-11-24 12:48:03', NULL, 'Chưa cập nhật'),
(25, 'lethanhnguyen', '0354331795', 'nguyen@gmail.com', NULL, '$2y$10$k.Kvu0EWt7K.gP3aJfN9F.c4yphTwx.xNZXZ2T9UIzAm6OQSqODuq', 'user', '2024-12-10 13:38:29', 'uploads/avatars/6757e2015d2c2-avthjhj.jpg', 'Chưa cập nhật'),
(26, 'quoc tu', '0354331794', 'tu@gmail.com', NULL, '$2y$10$PipiQIknWBCvWSm9P2eQoe7TaL07tUzlBTN8iQ3tFOC8WzIkE5AZC', 'user', '2024-12-10 15:19:12', NULL, 'a b c');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_method` enum('cash','bank') NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `status` varchar(50) NOT NULL DEFAULT 'awaiting confirmation',
  `estimated_delivery_date` date DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `name`, `phone`, `address`, `payment_method`, `order_status`, `status`, `estimated_delivery_date`, `total_price`) VALUES
(51, 10, '2024-12-05 19:21:49', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'confirmed', '2024-12-08', 7499000.00),
(52, 10, '2024-12-05 21:23:17', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-10', 10999000.00),
(53, 10, '2024-12-09 23:17:23', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-12', 7499000.00),
(54, 10, '2024-12-09 23:17:35', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-12', 7499000.00),
(55, 10, '2024-12-09 23:20:18', 'hiep', '0354331794', 'b d e', 'bank', 'pending', 'awaiting confirmation', NULL, 7499000.00),
(56, 10, '2024-12-09 23:25:19', 'hiep', '0354331794', 'b d e', 'bank', 'pending', 'awaiting confirmation', NULL, 7499000.00),
(57, 10, '2024-12-09 23:25:40', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'awaiting confirmation', NULL, 7499000.00),
(58, 10, '2024-12-09 23:26:26', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'confirmed', '2024-12-13', 29996000.00),
(59, 25, '2024-12-10 13:39:18', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-13', 7499000.00),
(60, 10, '2024-12-11 21:50:12', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-14', 7499000.00),
(75, 10, '2024-12-13 13:18:24', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'confirmed', '2024-12-16', 22497000.00),
(77, 10, '2024-12-13 22:41:42', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 34496001.00),
(78, 10, '2024-12-13 23:47:41', 'nguyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 89996000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(43, 51, 2, 1, 7499000.00),
(44, 52, 5, 1, 10999000.00),
(45, 53, 2, 1, 7499000.00),
(46, 54, 2, 1, 7499000.00),
(47, 55, 2, 1, 7499000.00),
(48, 56, 2, 1, 7499000.00),
(49, 57, 2, 1, 7499000.00),
(50, 58, 2, 4, 7499000.00),
(51, 59, 2, 1, 7499000.00),
(52, 60, 2, 1, 7499000.00),
(53, 75, 2, 3, 7499000.00),
(55, 77, 2, 1, 7499000.00),
(56, 77, 3, 3, 8999000.00),
(58, 78, 1, 2, 5999000.00),
(59, 78, 2, 2, 7499000.00),
(60, 78, 15, 3, 21000000.00);

--
-- Bẫy `order_details`
--
DELIMITER $$
CREATE TRIGGER `update_total_price_after_delete` AFTER DELETE ON `order_details` FOR EACH ROW BEGIN
    UPDATE `orders`
    SET `total_price` = (
        SELECT SUM(`price` * `quantity`)
        FROM `order_details`
        WHERE `order_id` = OLD.`order_id`
    )
    WHERE `order_id` = OLD.`order_id`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_price_after_insert` AFTER INSERT ON `order_details` FOR EACH ROW BEGIN
    UPDATE `orders`
    SET `total_price` = (
        SELECT SUM(`price` * `quantity`)
        FROM `order_details`
        WHERE `order_id` = NEW.`order_id`
    )
    WHERE `order_id` = NEW.`order_id`;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_price_after_update` AFTER UPDATE ON `order_details` FOR EACH ROW BEGIN
    UPDATE `orders`
    SET `total_price` = (
        SELECT SUM(`price` * `quantity`)
        FROM `order_details`
        WHERE `order_id` = NEW.`order_id`
    )
    WHERE `order_id` = NEW.`order_id`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_slug` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category_slug`, `price`, `image`, `description`) VALUES
(1, 'Bàn Uống Nước', 'phong-khach', 5999000.00, 'uploads/phong-khach-ban-uong-nuoc-2.png', 'Bàn uống nước hiện đại làm từ gỗ tràm cao cấp và sang trọng.'),
(2, 'Bàn Làm Việc Trắng Đơn Giản ', 'phong-lam-viec', 7499000.00, 'images/AnhCat/sp-2.png', 'Kệ TV thiết kế hiện đại, phù hợp mọi không gian.'),
(3, 'Giường Kiểu Âu', 'phong-ngu', 8999000.00, 'images/AnhCat/sp-3.png', 'Giường phong cách châu Âu, chất liệu gỗ tự nhiên.'),
(4, 'Tủ Đồ Cao Cấp', 'phong-ngu', 12999000.00, 'images/AnhCat/sp-4.png', 'Tủ đồ gỗ cao cấp, phù hợp không gian phòng ngủ sang trọng.'),
(5, 'Bàn Ăn Gỗ', 'phong-bep', 10999000.00, 'uploads/sp-5.png', 'Bàn ăn thiết kế đơn giản, chất liệu gỗ sồi cao cấp và sang trọng.'),
(15, 'Bàn Lười Sang Trọng', 'phong-khach', 21000000.00, 'uploads/products/70384aed5d8e64bfa2430373fc498e83.jpg', NULL),
(16, 'Bộ Bàn Tiếp Khách Tổng Thống ', 'phong-khach', 49000000.00, 'uploads/products/ddd4dae2e7e708feaa8bef9eeb9cc4bd.jpg', NULL),
(17, 'Bàn Kiểu Nhật', 'phong-khach', 14000000.00, 'uploads/products/Ý Tưởng Phòng Khách.jpg', NULL),
(18, 'Kệ TV Phòng Khách ', 'phong-khach', 20000000.00, 'uploads/products/Sự ấm cúng và sang trọng của nội thất gỗ tự nhiên trong không gian sống.jpg', NULL),
(19, 'Tủ Đầu Giường Gỗ Trà ', 'phong-ngu', 8900000.00, 'uploads/products/Tủ Đầu Giường.jpg', NULL),
(20, 'Tủ Quần Áo Hiện Đại ', 'phong-ngu', 35000000.00, 'uploads/products/tu-quan-ao.png', NULL),
(21, 'Giường Ngủ Cách Tân Có Hộc Tủ ', 'phong-ngu', 27000000.00, 'uploads/products/sp-12.jpg', NULL),
(22, 'Giường Ngủ Cao', 'phong-ngu', 12000000.00, 'uploads/products/sp-11.jpg', NULL),
(23, 'Giường Ngủ Gỗ Sồi ', 'phong-ngu', 39000000.00, 'uploads/products/sp-8.jpg', NULL),
(24, 'Quầy Bar Gỗ Sang Trọng', 'phong-bep', 50000000.00, 'uploads/products/sp-13.jpg', NULL),
(25, 'Bàn Ăn Gỗ Sang Trọng', 'phong-bep', 26000000.00, 'uploads/products/sp-15.jpg', NULL),
(26, 'Bàn Ăn Gỗ Nguyên Mảnh ', 'phong-bep', 26000000.00, 'uploads/products/sp-14.jpg', NULL),
(27, 'Kệ Trang Trí Góc ', 'trang-tri', 5000000.00, 'uploads/products/Apartment Entry.jpg', NULL),
(28, 'Kệ Đầu Giường', 'phong-ngu', 8900000.00, 'uploads/products/ke-dau-giuong.png', NULL),
(29, 'Gian Thờ Gỗ Lim', 'phong-tho', 69000000.00, 'uploads/products/4ab70c1d77f00a7b14c6f55c95dfed6b.jpg', NULL),
(30, 'Gian Thờ Gỗ Cẩm Lai', 'phong-tho', 89000000.00, 'uploads/products/7f6e2b188319b4e379e56e638287f645.jpg', NULL),
(31, 'Gian Thờ Gỗ Cẩm Lai Bản Thiết Kế ', 'phong-tho', 99999999.99, 'uploads/products/5cc82b29d3a00535a14fb87ebe8b5fba.jpg', NULL),
(32, 'Bàn Làm Việc Nhỏ', 'phong-lam-viec', 4000000.00, 'uploads/products/9c70d8877d6f02c069b59021ac5c999f.jpg', NULL),
(33, 'Đèn Ngủ Trang Trí Bằng Gỗ ', 'trang-tri', 4200000.00, 'uploads/products/98becab0b61f9f069dc4a405f13283f2.jpg', NULL),
(34, 'Bộ Thờ Nhỏ ', 'phong-tho', 3900000.00, 'uploads/products/a6574946f3d77c96b36e0e5ad37adddd.jpg', NULL),
(35, 'Giá Treo Gỗ Cách Điệu', 'trang-tri', 6000000.00, 'uploads/products/ac4f09cde7484979c16bdc3b2e6c8d8c.jpg', NULL),
(36, 'Kệ Gỗ Nhiều Tầng', 'trang-tri', 7500000.00, 'uploads/products/cc566661061985d82a81cb7bca3eabbe.jpg', NULL),
(37, 'Đồ Gỗ Treo Tường Trang Trí ', 'trang-tri', 3000000.00, 'uploads/products/db2decd283f8d46e0379d9c58af78773.jpg', NULL),
(38, 'Bàn Mini Gỗ Tràm ', 'phong-lam-viec', 2900000.00, 'uploads/products/ffee4214e0397c239c8c50b9ac85184f.jpg', NULL),
(39, 'Kệ Để Đồ', 'trang-tri', 5000000.00, 'uploads/products/Console Tables.jpg', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`ma_khach_hang`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_slug` (`category_slug`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `ma_khach_hang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_slug`) REFERENCES `categories` (`slug`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
