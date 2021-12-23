-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 23, 2021 lúc 11:09 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `at140803`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `author` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantily` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `category_id`, `quantily`) VALUES
(1, 'Chiến tranh và hoà bình', 'Lev Tolstoy', 3, 3),
(3, 'Tam quốc diễn nghĩa', 'La Quán Trung', 7, 2),
(4, 'Harry Potter', 'J. K. Rowling', 3, 2),
(5, 'Truyện Kiều', 'Nguyễn Du', 3, 1),
(6, 'Đắc Nhân Tâm', 'Dale Carnegie', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `borrow_book`
--

CREATE TABLE `borrow_book` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `borrow_book`
--

INSERT INTO `borrow_book` (`id`, `user_id`, `book_id`, `status`) VALUES
(5, 3, 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Văn học đời sống'),
(2, 'Nghệ thuật'),
(3, 'Phiêu lưu'),
(7, 'Toán Học'),
(8, 'Khoa học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `perm_id` int(11) NOT NULL,
  `perm_mod` varchar(5) NOT NULL,
  `perm_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`perm_id`, `perm_mod`, `perm_desc`) VALUES
(1, 'USR', 'Tạo mới người dùng'),
(2, 'USR', 'Chỉnh sửa thông tin người dùng'),
(3, 'USR', 'Xóa người dùng'),
(4, 'USR', 'Xem danh sách người dùng'),
(5, 'LIB', 'Tạo mới sách'),
(6, 'LIB', 'Cập nhật thông tin sách'),
(7, 'LIB', 'Xóa sách'),
(8, 'LIB', 'Xem danh sách sách');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(3, 'Người dùng'),
(1, 'Quản trị viên'),
(2, 'Thủ thư');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `perm_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `email`, `password`, `phone`, `address`) VALUES
(1, 1, 'nguyentruongbinh', 'at140803@gmail.com', 'a18aec381b9088ecbd8820944419172e56c5454d', '0333160020', 'Hà Lội'),
(2, 2, 'thuthu', 'binhnguyen9939@gmail.com', 'c1b9fc70d1ef834a58d006a8ee37221435c72383', '0333160029', 'Lào Cai'),
(3, 3, 'nguoidung', 'nguoidung@gmail.com', 'a18aec381b9088ecbd8820944419172e56c5454d', '0333160027', 'Hải Dương'),
(31, 3, 'nguoidung2', 'nguoidung202@gmail.com', '9d252c27f23cbe86091ad024206b11cee8ce2565', '', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `borrow_book`
--
ALTER TABLE `borrow_book`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`perm_id`),
  ADD KEY `perm_mod` (`perm_mod`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Chỉ mục cho bảng `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`perm_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `borrow_book`
--
ALTER TABLE `borrow_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `perm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
