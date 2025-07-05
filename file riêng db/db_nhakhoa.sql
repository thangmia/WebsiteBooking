-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 05, 2025 lúc 07:40 PM
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
-- Cơ sở dữ liệu: `db_nhakhoa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `appointment_time` datetime NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `service_id`, `appointment_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, '2025-06-20 09:00:00', 'completed', 'Bệnh nhân có răng nhạy cảm.', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(2, 6, 2, 2, '2025-06-22 14:30:00', 'completed', '', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(3, 7, 1, 2, '2025-06-30 10:00:00', 'confirmed', 'Trám răng cửa, yêu cầu thẩm mỹ cao.', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(4, 7, 3, 4, '2025-07-01 09:30:00', 'completed', 'Bệnh nhân hơi lo lắng.', '2025-06-28 07:07:31', '2025-07-04 08:28:09'),
(5, 5, 2, 3, '2025-07-02 11:00:00', 'confirmed', '', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(6, 6, 1, 1, '2025-07-03 15:00:00', 'completed', 'Lần đầu tới khám.', '2025-06-28 07:07:31', '2025-07-04 08:12:40'),
(7, 7, 3, 1, '2025-06-25 11:00:00', 'completed', 'Bệnh nhân báo bận đột xuất.', '2025-06-28 07:07:31', '2025-07-04 08:28:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialty`, `bio`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 2, 'Chuyên khoa Tổng quát', 'Tốt nghiệp Đại học Y Dược TP.HCM với hơn 10 năm kinh nghiệm trong lĩnh vực nha khoa tổng quát và phục hình răng.', 'images/avatars/doctor_tuan.jpg', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(2, 3, 'Chuyên khoa Chỉnh nha', 'Chuyên gia về niềng răng và các giải pháp chỉnh nha thẩm mỹ. Đã hoàn thành nhiều khóa đào tạo chuyên sâu tại Hàn Quốc.', 'images/avatars/doctor_lan.jpg', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(3, 4, 'Chuyên khoa Tiểu phẫu', 'Bác sĩ Minh chuyên về các ca tiểu phẫu trong miệng như nhổ răng khôn, cấy ghép implant. Luôn đặt sự an toàn và nhẹ nhàng cho bệnh nhân lên hàng đầu.', 'images/avatars/doctor_minh.jpg', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(4, 9, 'Chuyên niềng răng đẳng cấp vip pro', '', NULL, '2025-07-04 08:17:48', '2025-07-04 08:17:48'),
(5, 11, 'Chuyên niềng răng đẳng cấp vip pro đẳng cấp siêu vũ trụ', '', NULL, '2025-07-04 08:19:14', '2025-07-04 08:19:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` int(11) NOT NULL COMMENT '1 = Monday, 2 = Tuesday, ..., 7 = Sunday',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `schedules`
--

INSERT INTO `schedules` (`id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(1, 1, 1, '08:00:00', '17:00:00'),
(2, 1, 2, '08:00:00', '17:00:00'),
(3, 1, 3, '08:00:00', '17:00:00'),
(4, 1, 4, '08:00:00', '17:00:00'),
(5, 1, 5, '08:00:00', '17:00:00'),
(6, 2, 2, '09:00:00', '18:00:00'),
(7, 2, 4, '09:00:00', '18:00:00'),
(8, 2, 6, '10:00:00', '19:00:00'),
(9, 2, 7, '10:00:00', '19:00:00'),
(10, 3, 1, '08:30:00', '12:00:00'),
(11, 3, 1, '13:30:00', '18:00:00'),
(12, 3, 3, '08:30:00', '12:00:00'),
(13, 3, 3, '13:30:00', '18:00:00'),
(14, 3, 5, '08:30:00', '18:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `duration_minutes`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Cạo vôi răng & Đánh bóng', 'Làm sạch mảng bám và vôi răng, giúp răng trắng sáng và khỏe mạnh hơn.', 30, 300000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(2, 'Trám răng thẩm mỹ', 'Sử dụng vật liệu composite để phục hình răng sâu hoặc sứt mẻ, màu sắc tự nhiên như răng thật.', 45, 500000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(3, 'Tẩy trắng răng', 'Phương pháp làm trắng răng bằng công nghệ laser, hiệu quả nhanh chóng và an toàn.', 60, 2500000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(4, 'Nhổ răng khôn', 'Tiểu phẫu loại bỏ răng khôn mọc lệch, mọc ngầm, tránh các biến chứng nguy hiểm.', 60, 1500000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(5, 'Lấy tủy răng', 'Điều trị tủy răng bị viêm nhiễm, giúp bảo tồn răng thật và loại bỏ cơn đau.', 90, 1200000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(6, 'Niềng răng mắc cài kim loại', 'Chỉnh nha, sắp xếp lại các răng mọc lệch lạc về đúng vị trí, cải thiện thẩm mỹ và chức năng ăn nhai.', 45, 30000000.00, '2025-06-28 07:07:31', '2025-06-28 07:07:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `time_offs`
--

CREATE TABLE `time_offs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `time_offs`
--

INSERT INTO `time_offs` (`id`, `doctor_id`, `start_time`, `end_time`, `reason`) VALUES
(1, 1, '2025-07-02 14:00:00', '2025-07-02 16:00:00', 'Họp chuyên môn'),
(2, 2, '2025-07-05 00:00:00', '2025-07-05 23:59:59', 'Việc cá nhân');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('patient','doctor','admin') NOT NULL DEFAULT 'patient',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Quản Trị', 'admin@nhakhoa.com', '$2y$10$skzNIaTqlW4MCGj8YvOawuhVa68hDKvDfbXGNN2JLNWPqGx2elRHC', '0901112221', 'admin', '2025-06-28 07:07:31', '2025-07-01 15:24:21'),
(2, 'Bác sĩ Trần Công Tuấn', 'bs.tuan@nhakhoa.com', '$2y$10$skzNIaTqlW4MCGj8YvOawuhVa68hDKvDfbXGNN2JLNWPqGx2elRHC', '0901112222', 'doctor', '2025-06-28 07:07:31', '2025-07-01 15:24:25'),
(3, 'Bác sĩ Nguyễn Thị Lan', 'bs.lan@nhakhoa.com', '$2y$10$skzNIaTqlW4MCGj8YvOawuhVa68hDKvDfbXGNN2JLNWPqGx2elRHC', '0901112223', 'doctor', '2025-06-28 07:07:31', '2025-07-01 15:24:28'),
(4, 'Bác sĩ Lê Văn Minh', 'bs.minh@nhakhoa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0901112224', 'doctor', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(5, 'Trần Văn An', 'an.tran@email.com', '$2y$10$skzNIaTqlW4MCGj8YvOawuhVa68hDKvDfbXGNN2JLNWPqGx2elRHC', '0987654321', 'patient', '2025-06-28 07:07:31', '2025-07-01 15:25:39'),
(6, 'Nguyễn Thị Bình', 'binh.nguyen@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987123456', 'patient', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(7, 'Lê Thị Châu', 'chau.le@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0912345678', 'patient', '2025-06-28 07:07:31', '2025-06-28 07:07:31'),
(9, 'Trần Mạnh Dũng', 'bsdung@gmail.com', '$2y$10$kKtGv8V7P0EsvyafFREDSu9FeDpzujg83agzitaUeniUCivF4hffq', '0914877797', 'doctor', '2025-07-04 08:17:48', '2025-07-04 08:17:48'),
(11, 'Thanh Lâm', 'tthanhlam437@gmail.com', '$2y$10$xd9JTJOVvj.Sayof6IUBL.6ZPExfRF/3sQclkMNVYcWwbvddHzcwG', '0823160256', 'doctor', '2025-07-04 08:19:14', '2025-07-04 08:19:14');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_service_id_foreign` (`service_id`);

--
-- Chỉ mục cho bảng `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_doctor_id_foreign` (`doctor_id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `time_offs`
--
ALTER TABLE `time_offs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_offs_doctor_id_foreign` (`doctor_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `time_offs`
--
ALTER TABLE `time_offs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `time_offs`
--
ALTER TABLE `time_offs`
  ADD CONSTRAINT `time_offs_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
