-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 27, 2024 lúc 11:05 AM
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
-- Cơ sở dữ liệu: `bookinghotel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `seri_num` varchar(20) NOT NULL,
  `people` int(11) NOT NULL,
  `status` enum('pending','confirmed','cancelled','checkin','checkout') NOT NULL DEFAULT 'pending',
  `amount` double(10,2) NOT NULL,
  `booking_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `seri_num`, `people`, `status`, `amount`, `booking_date`) VALUES
(38, 'CT-241227-043635', 5, 'checkin', 3580000.00, '2024-12-27 16:36:35'),
(39, 'CT-241227-044224', 5, 'confirmed', 4400000.00, '2024-12-27 16:42:24'),
(40, 'CT-241227-045447', 2, 'pending', 1380000.00, '2024-12-27 16:54:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_guests`
--

CREATE TABLE `booking_guests` (
  `id` int(11) NOT NULL,
  `booking_rooms_id` int(11) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_phone` varchar(20) NOT NULL,
  `guest_email` varchar(255) NOT NULL,
  `guest_id_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_guests`
--

INSERT INTO `booking_guests` (`id`, `booking_rooms_id`, `guest_name`, `guest_phone`, `guest_email`, `guest_id_number`) VALUES
(53, 58, 'Phạm Mạnh Tuấn', '0981191651', 'tuan@gmail.com', NULL),
(54, 59, 'Minh Trị', '0981191651', 'tri@gmail.com', NULL),
(55, 60, 'Minh Trị', '0981191651', 'tri@gmail.com', NULL),
(56, 61, 'Thanh Phương', '0981191651', 'phuong@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_rooms`
--

CREATE TABLE `booking_rooms` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `early_checkout` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_rooms`
--

INSERT INTO `booking_rooms` (`id`, `booking_id`, `room_id`, `user_id`, `amount`, `check_in_date`, `check_out_date`, `early_checkout`) VALUES
(58, 38, 110, 84, 3580000.00, '2024-12-27', '2024-12-29', NULL),
(59, 39, 66, 86, 2200000.00, '2024-12-31', '2025-01-03', NULL),
(60, 39, 67, 86, 2200000.00, '2024-12-31', '2025-01-03', NULL),
(61, 40, 66, 87, 1380000.00, '2024-12-28', '2024-12-30', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number_1` varchar(20) DEFAULT NULL,
  `phone_number_2` varchar(20) DEFAULT NULL,
  `email1` varchar(255) DEFAULT NULL,
  `email2` varchar(255) NOT NULL,
  `sc1` varchar(255) NOT NULL,
  `sc2` varchar(255) NOT NULL,
  `sc3` varchar(255) NOT NULL,
  `sc4` varchar(255) NOT NULL,
  `iframe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `is_shutdown` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `room_type_id`, `image_url`) VALUES
(25, 36, 'room1.jpg'),
(26, 37, 'room2.jpg'),
(27, 38, 'room3.jpg'),
(28, 39, 'room4.jpg'),
(29, 40, 'room5.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `total_amount` double(10,2) NOT NULL,
  `total_people` int(11) NOT NULL,
  `status` enum('paid','unpaid') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `managements`
--

CREATE TABLE `managements` (
  `id` int(11) NOT NULL,
  `manager_name` varchar(50) DEFAULT NULL,
  `manager_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `booking_rooms_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reservations`
--

INSERT INTO `reservations` (`id`, `booking_rooms_id`, `service_id`) VALUES
(37, 58, 10),
(38, 58, 12),
(39, 59, 11),
(40, 60, 11),
(41, 61, 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `status` enum('available','booked','','') NOT NULL DEFAULT 'available',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `status`, `description`) VALUES
(66, '101', 36, 'available', ''),
(67, '102', 36, 'available', ''),
(68, '103', 36, 'available', ''),
(69, '104', 36, 'available', ''),
(70, '105', 36, 'available', ''),
(71, '106', 36, 'available', ''),
(72, '107', 36, 'available', ''),
(73, '108', 36, 'available', ''),
(74, '109', 36, 'available', ''),
(75, '110', 36, 'available', ''),
(76, '111', 36, 'available', ''),
(77, '112', 36, 'available', ''),
(78, '113', 36, 'available', ''),
(82, '114', 36, 'available', ''),
(83, '115', 36, 'available', ''),
(85, '116', 36, 'available', ''),
(86, '117', 36, 'available', ''),
(87, '118', 36, 'available', ''),
(88, '119', 36, 'available', ''),
(89, '120', 36, 'available', ''),
(90, '201', 37, 'available', ''),
(91, '202', 37, 'available', ''),
(92, '203', 37, 'available', ''),
(93, '204', 37, 'available', ''),
(94, '205', 37, 'available', ''),
(95, '206', 37, 'available', ''),
(96, '207', 37, 'available', ''),
(97, '208', 37, 'available', ''),
(98, '209', 37, 'available', ''),
(99, '210', 37, 'available', ''),
(100, '211', 40, 'available', ''),
(101, '212', 40, 'available', ''),
(102, '213', 40, 'available', ''),
(103, '214', 40, 'available', ''),
(104, '215', 40, 'available', ''),
(105, '216', 40, 'available', ''),
(106, '217', 40, 'available', ''),
(107, '218', 40, 'available', ''),
(108, '219', 40, 'available', ''),
(109, '220', 40, 'available', ''),
(110, '301', 38, 'booked', ''),
(111, '302', 38, 'available', ''),
(112, '303', 38, 'available', ''),
(113, '304', 38, 'available', ''),
(114, '305', 38, 'available', ''),
(115, '306', 38, 'available', ''),
(116, '307', 38, 'available', ''),
(117, '308', 38, 'available', ''),
(118, '309', 38, 'available', ''),
(119, '310', 38, 'available', ''),
(120, '401', 39, 'available', ''),
(121, '402', 39, 'available', ''),
(122, '403', 39, 'available', ''),
(123, '404', 39, 'available', ''),
(124, '405', 39, 'available', ''),
(125, '406', 39, 'available', ''),
(126, '407', 39, 'available', ''),
(127, '408', 39, 'available', ''),
(128, '409', 39, 'available', ''),
(129, '410', 39, 'available', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_changes`
--

CREATE TABLE `room_changes` (
  `id` int(11) NOT NULL,
  `booking_rooms_id` int(11) NOT NULL,
  `old_room_id` int(11) NOT NULL,
  `new_room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `change_date` datetime NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_types`
--

CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_types`
--

INSERT INTO `room_types` (`id`, `type_name`, `adult`, `child`, `price`, `quantity`, `description`) VALUES
(36, 'Phòng Standard', 2, 1, 650000.00, 20, 'Phòng Standard được thiết kế với không gian nhỏ gọn nhưng đầy đủ tiện nghi cơ bản, mang lại cảm giác thoải mái cho khách lưu trú. Đây là sự lựa chọn lý tưởng cho khách du lịch hoặc công tác với ngân sách hạn chế.'),
(37, 'Phòng Superior', 3, 1, 1000000.00, 10, 'Với diện tích lớn hơn và vị trí đẹp trong khách sạn, phòng Superior đem lại trải nghiệm lưu trú thoải mái với không gian rộng rãi và nội thất cao cấp hơn. Phù hợp cho khách yêu cầu mức độ tiện nghi cao hơn.'),
(38, 'Phòng Deluxe', 3, 2, 1650000.00, 10, 'Phòng Deluxe mang lại sự sang trọng với thiết kế hiện đại và view đẹp, thích hợp cho các cặp đôi hoặc khách hàng mong muốn sự tinh tế và đẳng cấp trong chuyến đi.'),
(39, 'Phòng Suite', 4, 2, 2800000.00, 10, 'Loại phòng cao cấp nhất với không gian rộng lớn, thiết kế đẳng cấp và tiện nghi vượt trội. Phòng Suite là lựa chọn hoàn hảo cho gia đình hoặc khách hàng VIP cần sự riêng tư và sang trọng.'),
(40, 'Phòng Family', 6, 2, 3500000.00, 10, 'Phòng Family được thiết kế dành riêng cho các gia đình hoặc nhóm bạn, với không gian rộng rãi, tiện nghi đa dạng và thiết kế ấm cúng. Phòng này mang lại cảm giác như ở nhà trong chuyến du lịch.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `price` double(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `service_name`, `price`, `description`) VALUES
(10, 'Bữa sáng buffet', 200000.00, ''),
(11, 'Spa', 250000.00, ''),
(12, 'Phòng xông hơi', 80000.00, ''),
(13, 'Phòng gym', 150000.00, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `numphone` varchar(10) NOT NULL,
  `role` enum('admin','customer','','') NOT NULL DEFAULT 'customer',
  `forgot_token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `numphone`, `role`, `forgot_token`) VALUES
(84, 'Phạm Mạnh Tuấn', 'tuanpham', '202cb962ac59075b964b07152d234b70', 'tuanpham68@gmail.com', '0981191651', 'customer', ''),
(85, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '', 'admin', ''),
(86, 'Phạm Minh Trị', 'minhtri123', '202cb962ac59075b964b07152d234b70', 'minhtri@gmail.com', '', 'customer', ''),
(87, 'Trần Thanh Phương', 'thanhphuong', '202cb962ac59075b964b07152d234b70', 'phuong@gmail.com', '', 'customer', ''),
(88, 'Trần Quí Kiệt', 'quikit123', '202cb962ac59075b964b07152d234b70', 'kiet@gmail.com', '', 'customer', ''),
(89, 'Duy Tùng', 'tung123', '202cb962ac59075b964b07152d234b70', 'tung@gmail.com', '', 'customer', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `booking_guests`
--
ALTER TABLE `booking_guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_guests_ibfk_1` (`booking_rooms_id`);

--
-- Chỉ mục cho bảng `booking_rooms`
--
ALTER TABLE `booking_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Chỉ mục cho bảng `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_ibfk_2` (`room_type_id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `managements`
--
ALTER TABLE `managements`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_rooms_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_room_type` (`room_type_id`);

--
-- Chỉ mục cho bảng `room_changes`
--
ALTER TABLE `room_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_newroom_room` (`new_room_id`),
  ADD KEY `fk_oldroom_room` (`old_room_id`),
  ADD KEY `fk_roomchanges_booking` (`booking_rooms_id`);

--
-- Chỉ mục cho bảng `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `booking_guests`
--
ALTER TABLE `booking_guests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `booking_rooms`
--
ALTER TABLE `booking_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `managements`
--
ALTER TABLE `managements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT cho bảng `room_changes`
--
ALTER TABLE `room_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_guests`
--
ALTER TABLE `booking_guests`
  ADD CONSTRAINT `booking_guests_ibfk_1` FOREIGN KEY (`booking_rooms_id`) REFERENCES `booking_rooms` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_rooms`
--
ALTER TABLE `booking_rooms`
  ADD CONSTRAINT `booking_rooms_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_rooms_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`booking_rooms_id`) REFERENCES `booking_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `fk_room_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `room_changes`
--
ALTER TABLE `room_changes`
  ADD CONSTRAINT `fk_newroom_room` FOREIGN KEY (`new_room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_oldroom_room` FOREIGN KEY (`old_room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_roomchanges_booking` FOREIGN KEY (`booking_rooms_id`) REFERENCES `booking_rooms` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
