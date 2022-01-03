-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 03, 2022 lúc 04:29 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lab08`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `SDT` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` bit(1) DEFAULT b'0',
  `activate_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `firstname`, `lastname`, `address`, `email`, `SDT`, `password`, `activated`, `activate_token`) VALUES
('khoailang', 'Lăng', 'Khoa', '161/11 Hậu Giang P8 Q6 TP HCM', '19521692@gm.uit.edu.vn', '0909991122', '$2y$10$aHmpPz/0i2.Fz7KbpMA/neA6TmXNFYt21Y8EQI5JNi9s/XThCgtMa', b'1', 'ccc521e92280890830ac655bf4811479'),
('mvmanh', 'Mai', 'Văn Mạnh', 'aaaa', 'mvmanh@gmail.com', '090999999', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', b'1', '123456'),
('susuacvn', 'Nguyễn', 'Thiện', 'bbbb', 'nguyenngocthien749@gmail.com', '123456780', '$2y$10$ZbCCqVDxtEAwep9k7T01xOCMVotuPAPhkOgt.UFaDhrCa2yGmZhQS', b'1', ''),
('tdt', 'Tôn', 'Đức Thắng', 'ccccc', 'mvmanh@it.tdt.edu.vn', '123456789', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', b'1', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MANV` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `TENNV` text COLLATE utf8_unicode_ci NOT NULL,
  `DIACHI` text COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` text COLLATE utf8_unicode_ci NOT NULL,
  `SDT` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `PASS` text COLLATE utf8_unicode_ci NOT NULL,
  `ACTIVATED` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MANV`, `TENNV`, `DIACHI`, `EMAIL`, `SDT`, `PASS`, `ACTIVATED`) VALUES
('admin', 'Nguyễn Ngọc Thiện', '161/29 Phạm Căn Chí P3 Q6 Tp HCM', 'tieuthien951@gmail.com', '', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', b'1'),
('NV001', 'Nguyễn Minh Trí', '334/24 Phạm Phú Thứ P4 Q5 TP HCM', 'nguyenminhtri@gamil.com', '0912345678', '$2y$10$plkumLOgM3P2mPht0TmtJ.CeOPDPUt28P3gq26gZdf6g0ue6Nwt6.', b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `image`) VALUES
(1, 'iPhone XS MAX 64GB', 24490000, 'Hàng xách tay chính hãng', 'iphone-6s-128gb-hong-1-400x450.png'),
(2, 'Samsung Galaxy J7 Plus', 12990000, 'Bao test bào xài 6 tháng', 'samsung-galaxy-j7-plus-1-400x460.png'),
(3, 'iPhone 7 Plus 128GB Black', 14490000, 'Hàng cũ mới 99%', 'iphone-7-plus-128gb-de-400x460.png'),
(4, 'Oppo F3 Plus', 7990000, 'Hàng chợ Bà Chiểu', 'oppo-f3-plus-1-1-400x460.png'),
(6, 'd', 10000, 'b', 'c');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('mvmanh@gmail.com', '', 0),
('mvmanh@it.tdt.edu.vn', '', 0),
('nguyenngocthien749@gmail.com', '445bb9448adbd5e35042511797de20ac', 1638971578);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MANV`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
