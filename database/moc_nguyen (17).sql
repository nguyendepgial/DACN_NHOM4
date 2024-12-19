-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 19, 2024 lúc 05:54 PM
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
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'nguyen1', '0354331794', 'thanhnguyenle123dmx@gmail.com', NULL, '$2y$10$vhpkzGIPAmNHKd8QYoSIfuoZse3nbp.o20X35os/VxbpNDsMcvxQe', 'user', '2024-11-24 12:48:03', 'uploads/avatars/675fde2cc76db-avthjhj.jpg', '290/34'),
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
(78, 10, '2024-12-13 23:47:41', 'nguyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 89996000.00),
(79, 10, '2024-12-16 13:11:00', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 99999999.99),
(80, 10, '2024-12-16 13:29:00', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'awaiting confirmation', NULL, 45000000.00),
(81, 10, '2024-12-16 13:30:03', 'nguyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 99999999.99),
(82, 10, '2024-12-16 13:31:13', 'nguyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 45000000.00),
(83, 10, '2024-12-16 13:31:48', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 25000000.00),
(84, 10, '2024-12-16 14:07:02', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 45000000.00),
(85, 10, '2024-12-16 15:25:32', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 90000000.00),
(86, 10, '2024-12-16 15:29:53', 'nguyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 45000000.00),
(87, 10, '2024-12-16 15:49:02', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'awaiting confirmation', NULL, 88000000.00),
(88, 10, '2024-12-16 15:49:46', 'ngueyen', '0354331794', 'a b c', 'cash', 'pending', 'awaiting confirmation', NULL, 18000000.00),
(89, 10, '2024-12-16 15:49:57', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 45000000.00),
(90, 10, '2024-12-18 23:35:27', 'ngueyen', '0354331794', 'a b c', 'bank', 'pending', 'awaiting confirmation', NULL, 46000000.00);

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
(61, 79, 41, 2, 45000000.00),
(62, 79, 42, 1, 25000000.00),
(63, 80, 41, 1, 45000000.00),
(64, 81, 41, 3, 45000000.00),
(65, 82, 41, 1, 45000000.00),
(66, 83, 42, 1, 25000000.00),
(67, 84, 41, 1, 45000000.00),
(68, 85, 41, 2, 45000000.00),
(69, 86, 41, 1, 45000000.00),
(70, 87, 42, 1, 25000000.00),
(71, 87, 40, 1, 18000000.00),
(72, 87, 41, 1, 45000000.00),
(73, 88, 40, 1, 18000000.00),
(74, 89, 41, 1, 45000000.00),
(75, 90, 47, 2, 23000000.00);

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
(40, 'Kệ Góc Trang Trí ', 'trang-tri', 18000000.00, '../../public/uploads/products/sp-.jpg', 'Kệ góc trang trí hiện đại, thiết kế nhỏ gọn phù hợp với không gian sống.'),
(41, 'Giường Kiểu Hiện Đại', 'phong-ngu', 45000000.00, '../../public/uploads/products/sp-1.png', 'Giường phong cách hiện đại, chất liệu cao cấp mang đến sự thoải mái.'),
(42, 'Bàn Làm Việc Trắng Đơn Giản', 'phong-khach', 25000000.00, '../../public/uploads/products/sp-2.png', 'Bàn làm việc với thiết kế tối giản, phù hợp với mọi không gian làm việc.'),
(43, 'Tủ Quần Áo Cánh Trắng ', 'phong-ngu', 49000000.00, '../../public/uploads/products/sp-3.png', 'Tủ quần áo cánh trắng hiện đại, giúp không gian phòng ngủ thêm sáng sủa.'),
(44, 'Tủ Nhiều Tầng', 'trang-tri', 32000000.00, '../../public/uploads/products/sp-4.png', 'Tủ nhiều tầng đa năng, thích hợp cho việc lưu trữ quần áo hoặc đồ dùng cá nhân.'),
(45, 'Bộ Bàn Ăn Gỗ Sồi', 'phong-bep', 79000000.00, '../../public/uploads/products/sp-5.png', NULL),
(46, 'Kệ Trang Trí', 'trang-tri', 12000000.00, '../../public/uploads/products/sp-6.jpg', 'Kệ trang trí sang trọng, phù hợp với không gian phòng khách hoặc phòng làm việc.'),
(47, 'Giường Bệt', 'phong-ngu', 23000000.00, '../../public/uploads/products/sp-7.jpg', 'Giường bệt phong cách tối giản, mang lại sự thoải mái và hiện đại.'),
(48, 'Giường Hộp', 'phong-ngu', 34000000.00, '../../public/uploads/products/sp-8.jpg', 'Giường hộp với ngăn kéo lưu trữ tiện lợi, tối ưu không gian phòng ngủ.'),
(49, 'Giường Gỗ Ép', 'phong-ngu', 32000000.00, '../../public/uploads/products/sp-9.jpg', 'Giường gỗ ép chắc chắn, thiết kế hiện đại, giá cả phải chăng.'),
(50, 'Giường Ngủ Đơn Giản', 'phong-ngu', 32000000.00, '../../public/uploads/products/sp-10.jpg', 'Giường ngủ đơn giản với chất liệu gỗ tự nhiên, phù hợp với mọi gia đình.'),
(51, 'Giường Thoáng Gầm', 'phong-ngu', 23000000.00, '../../public/uploads/products/sp-11.jpg', NULL),
(52, 'Giường Thiết Kế Đẹp', 'phong-ngu', 22000000.00, '../../public/uploads/products/sp-12.jpg', 'Giường thiết kế đẹp, phù hợp với không gian phòng ngủ hiện đại.'),
(53, 'Quầy Bar Gỗ Sang Trọng', 'phong-bep', 56000000.00, '../../public/uploads/products/sp-13.jpg', NULL),
(54, 'Bộ Bàn Ăn Gỗ Nguyên Khối', 'phong-bep', 54000000.00, '../../public/uploads/products/sp-14.jpg', NULL),
(55, 'Bộ Bàn Làm Việc Gỗ Nguyên Khối ', 'phong-lam-viec', 99999999.99, '../../public/uploads/products/sp-15.jpg', NULL),
(56, 'Bộ Bàn Ăn Nhỏ', 'phong-bep', 12000000.00, '../../public/uploads/products/sp-16.jpg', 'Bộ bàn ăn nhỏ gọn, tiết kiệm không gian, phù hợp cho căn hộ nhỏ.'),
(57, 'Kệ TV Phòng Khách', 'phong-khach', 23000000.00, '../../public/uploads/products/sp-17.jpg', 'Kệ TV cho phòng khách, thiết kế đơn giản và tinh tế.'),
(58, 'Bàn Làm Việc Nhỏ', 'phong-lam-viec', 11000000.00, '../../public/uploads/products/sp-18.jpg', NULL),
(59, 'Tủ Đầu Giường Gỗ Trà', 'phong-ngu', 22000000.00, '../../public/uploads/products/sp-19.jpg', 'Tủ đầu giường làm từ gỗ trà, thiết kế đẹp mắt và tiện dụng.'),
(60, 'Tủ Quần Áo Hiện Đại', 'phong-ngu', 45000000.00, '../../public/uploads/products/sp-20.png', NULL),
(61, 'Bàn Kiểu Nhật', 'phong-khach', 55000000.00, '../../public/uploads/products/sp-21.jpg', 'Bàn kiểu Nhật với thiết kế tinh tế, mang phong cách tối giản.'),
(62, 'Tủ Gỗ Thoáng', 'phong-ngu', 21000000.00, '../../public/uploads/products/sp-26.jpg', NULL),
(63, 'Bộ Bàn Tiếp Khách Tổng Thống', 'phong-khach', 99999999.99, '../../public/uploads/products/sp-28.jpg', NULL),
(64, 'Kệ TV Gỗ Sồi', 'phong-khach', 34000000.00, '../../public/uploads/products/sp-22.png', NULL),
(65, 'Gian Thờ Gỗ Cẩm Lai Bản Thiết Kế', 'phong-khach', 99999999.99, '../../public/uploads/products/sp-32.jpg', NULL),
(66, 'Gian Thờ Gỗ Căm Xe', 'phong-tho', 99999999.99, '../../public/uploads/products/sp-33.jpg', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `khachhang` (`ma_khach_hang`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
