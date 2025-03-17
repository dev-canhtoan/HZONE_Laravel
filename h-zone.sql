-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 17, 2025 lúc 09:19 PM
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
-- Cơ sở dữ liệu: `h-zone`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại', '2023-10-13 02:02:40', '2023-11-05 10:41:01'),
(2, 'Máy tính bảng', '2023-10-13 02:02:40', '2023-10-13 02:02:40'),
(3, 'Máy tính xách tay', '2023-10-13 02:02:40', '2024-10-21 03:10:18'),
(4, 'Đồng hồ thông minh', '2023-10-13 02:02:40', '2023-10-13 02:02:40'),
(5, 'Máy tính để bàn', '2023-10-13 02:02:40', '2023-10-13 02:02:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `percent` int(11) NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`id`, `name`, `percent`, `start_at`, `end_at`, `created_at`) VALUES
(1, 'Test', 25, '2023-10-31 03:52:00', '2024-10-26 15:55:00', '2023-10-31 05:03:58'),
(2, 'hallowen', 10, '2023-11-01 13:20:00', '2023-11-30 13:20:00', '2023-10-31 06:20:51'),
(4, '20/11', 10, '2023-11-06 12:40:00', '2023-11-08 07:09:00', '2023-10-31 11:43:57'),
(5, 'flash sale', 80, '2023-11-01 09:05:00', '2023-11-25 13:08:00', '2023-11-01 06:04:32'),
(7, 'Kiểm tra', 30, '2024-10-21 09:46:00', '2024-10-22 09:46:00', '2024-10-21 02:46:32'),
(9, 'Nguyen Canh Toan', 23, '2024-10-27 20:07:00', '2024-10-29 20:07:00', '2024-10-27 13:07:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `user_id`, `status`, `created_at`, `updated_at`, `total`, `order_code`) VALUES
(13, 21, 3, '2023-10-14 23:36:53', '2023-10-14 23:37:25', 10000000, 'HZ-20231015-55lC2K'),
(18, 21, 2, '2023-10-15 18:57:32', '2023-10-15 18:57:47', 10000000, 'HZ-20231016-mlmuTz'),
(19, 21, 1, '2023-10-15 19:25:20', '2023-10-15 19:25:20', 1000000, 'HZ-20231016-ie2eDs'),
(32, 21, 1, '2023-10-15 19:49:43', '2023-10-15 19:49:43', 100000, 'HZ-20231016-X20K2z'),
(90, 27, 1, '2023-10-23 05:26:52', '2023-10-23 05:26:52', 10200000, 'HZ-20231023-zmX0RX'),
(91, 27, 2, '2023-10-23 05:28:45', '2023-10-23 05:48:00', 10200000, 'HZ-20231023-EGEi8v'),
(92, 27, 3, '2023-10-23 05:29:37', '2023-10-23 05:47:58', 30000000, 'HZ-20231023-ePFDzW'),
(93, 27, 1, '2023-10-23 05:44:14', '2023-10-23 05:44:19', 10000000, 'HZ-20231023-opZIHu'),
(94, 21, 1, '2023-10-25 04:20:40', '2023-10-25 04:20:48', 200000, 'HZ-20231025-nDWBrI'),
(95, 21, 3, '2023-10-26 04:56:24', '2023-10-26 04:56:41', 10000000, 'HZ-20231026-44yvsN'),
(96, 21, 1, '2023-10-28 03:48:18', '2023-10-28 03:48:18', 10999999, 'HZ-20231028-AocHT6'),
(97, 27, 1, '2023-10-28 09:24:56', '2023-10-28 09:24:56', 10000000, 'HZ-20231028-NzldXC'),
(98, 30, 1, '2023-10-28 09:31:01', '2023-10-28 09:31:01', 20000000, 'HZ-20231028-JGCDGS'),
(100, 21, 1, '2023-10-28 10:46:31', '2023-10-28 10:46:31', 10000000, 'HZ-20231028-0eSOkJ'),
(104, 21, 1, '2023-10-31 03:15:34', '2023-10-31 03:15:34', 8000000, 'HZ-20231031-HFbJxX'),
(105, 21, 1, '2023-10-31 03:16:51', '2023-10-31 03:16:51', 200000, 'HZ-20231031-MGEeIa'),
(106, 21, 1, '2023-10-31 11:02:51', '2023-10-31 11:02:51', 17500000, 'HZ-20231031-O0ytZD'),
(109, 21, 1, '2023-10-31 04:43:16', '2023-10-31 16:44:25', 1000000, 'HZ-20231031-rAQp0X'),
(110, 27, 1, '2023-10-31 04:49:36', '2023-10-31 16:50:14', 1000000, 'HZ-20231031-9KKlI7'),
(111, 31, 1, '2023-11-01 05:59:31', '2023-11-01 06:00:32', 1170000, 'HZ-20231101-xpidUA'),
(112, 31, 1, '2023-10-31 20:46:17', '2023-11-01 08:48:18', 200000, 'HZ-20231101-O7KOa8'),
(113, 31, 1, '2023-11-01 08:49:25', '2023-11-01 08:49:33', 7500000, 'HZ-20231101-gzugRX'),
(114, 21, 1, '2023-11-01 08:53:25', '2023-11-01 08:53:25', 52500000, 'HZ-20231101-Tvq87m'),
(119, 32, 1, '2023-10-31 21:09:18', '2023-11-01 09:10:28', 200000, 'HZ-20231101-SyrgZV'),
(121, 21, 1, '2023-11-01 03:05:57', '2023-11-01 15:06:58', 14700000, 'HZ-20231101-AciRjw'),
(122, 21, 1, '2023-11-01 03:08:32', '2023-11-01 15:09:08', 7500000, 'HZ-20231101-S24Axp'),
(123, 21, 1, '2023-11-01 15:30:47', '2023-11-01 15:31:31', 7500000, 'HZ-20231101-iCsu4f'),
(124, 21, 1, '2023-11-01 15:36:27', '2023-11-01 15:36:38', 19980000, 'HZ-20231101-8IW9Qd'),
(127, 49, 1, '2023-11-04 05:37:26', '2023-11-04 05:37:26', 7500000, 'HZ-20231104-PP1tIR'),
(130, 21, 2, '2023-11-05 05:18:34', '2023-11-05 05:19:04', 7500000, 'HZ-20231105-8hinCM'),
(132, 21, 1, '2023-11-05 05:22:42', '2023-11-05 05:22:42', 39960000, 'HZ-20231105-JsHWfN'),
(133, 21, 1, '2023-11-05 05:37:47', '2023-11-05 05:37:52', 7500000, 'HZ-20231105-YvXRNW'),
(134, 49, 1, '2023-11-05 05:40:51', '2023-11-05 05:40:51', 7500000, 'HZ-20231105-sS3jVn'),
(135, 49, 1, '2023-11-05 05:40:59', '2023-11-05 05:40:59', 7500000, 'HZ-20231105-QI127R'),
(136, 49, 1, '2023-11-05 05:41:43', '2023-11-05 05:41:43', 7500000, 'HZ-20231105-DZtZxa'),
(137, 49, 1, '2023-11-05 05:41:45', '2023-11-05 05:41:45', 7500000, 'HZ-20231105-aBTZaH'),
(138, 49, 1, '2023-11-05 05:41:45', '2023-11-05 05:41:45', 7500000, 'HZ-20231105-c3aSrF'),
(139, 49, 1, '2023-11-05 05:41:53', '2023-11-05 05:41:53', 7500000, 'HZ-20231105-kk1FhG'),
(140, 49, 1, '2023-11-05 05:41:56', '2023-11-05 05:41:56', 7500000, 'HZ-20231105-Bvo7Bd'),
(141, 49, 1, '2023-11-05 05:42:00', '2023-11-05 05:42:00', 7500000, 'HZ-20231105-pYqW9T'),
(142, 49, 1, '2023-11-05 05:42:05', '2023-11-05 05:42:05', 7500000, 'HZ-20231105-vEahg2'),
(143, 49, 1, '2023-11-05 05:42:09', '2023-11-05 05:42:09', 7500000, 'HZ-20231105-aCnXvc'),
(144, 49, 1, '2023-11-05 05:42:13', '2023-11-05 05:42:13', 7500000, 'HZ-20231105-MUQIyj'),
(145, 49, 1, '2023-11-05 05:42:17', '2023-11-05 05:42:17', 7500000, 'HZ-20231105-qroozC'),
(146, 49, 1, '2023-11-05 05:42:22', '2023-11-05 05:42:22', 7500000, 'HZ-20231105-WNjGRK'),
(147, 49, 1, '2023-11-05 05:42:28', '2023-11-05 05:42:28', 7500000, 'HZ-20231105-1jpCmk'),
(148, 49, 1, '2023-11-05 05:42:28', '2023-11-05 05:42:28', 7500000, 'HZ-20231105-4UyLij'),
(149, 49, 1, '2023-11-05 05:42:37', '2023-11-05 05:42:37', 7500000, 'HZ-20231105-WuA0UW'),
(150, 49, 1, '2023-11-05 05:43:44', '2023-11-05 05:43:44', 7500000, 'HZ-20231105-DCYXFE'),
(152, 49, 2, '2023-11-05 05:44:31', '2023-11-05 05:54:20', 7500000, 'HZ-20231105-vK3dJW'),
(153, 49, 3, '2023-11-05 05:46:15', '2023-11-05 05:54:19', 9000000, 'HZ-20231105-VAhiOY'),
(154, 49, 3, '2023-11-05 05:51:29', '2023-11-05 05:54:17', 1500000, 'HZ-20231105-3j1tCi'),
(155, 49, 1, '2023-11-05 05:52:34', '2023-11-05 05:53:12', 1500000, 'HZ-20231105-ueHCbU'),
(160, 21, 1, '2023-11-05 07:20:17', '2023-11-05 07:21:00', 200000, 'HZ-20231105-7mdhxz'),
(161, 21, 1, '2023-11-05 07:22:21', '2023-11-05 07:23:14', 7500000, 'HZ-20231105-e5wuVE'),
(162, 21, 1, '2023-11-05 07:24:33', '2023-11-05 07:24:38', 200000, 'HZ-20231105-vq4stn'),
(167, 21, 1, '2023-11-05 07:40:31', '2023-11-05 07:40:36', 7500000, 'HZ-20231105-YjOqZq'),
(168, 21, 1, '2023-11-05 07:41:20', '2023-11-05 07:42:01', 7500000, 'HZ-20231105-hGxPL0'),
(169, 31, 1, '2023-11-22 08:39:19', '2023-11-22 08:39:37', 7900000, 'HZ-20231122-D4vo6z'),
(170, 31, 1, '2023-11-22 08:41:10', '2023-11-22 08:42:24', 7500000, 'HZ-20231122-1fdMSu'),
(171, 31, 1, '2024-10-07 08:44:36', '2024-10-07 08:44:36', 20000000, 'HZ-20241007-yVyu8X'),
(172, 31, 1, '2024-10-21 02:50:36', '2024-10-21 02:50:36', 10000000, 'HZ-20241021-e5iCzy'),
(173, 31, 1, '2024-10-27 13:04:39', '2024-10-27 13:04:39', 10000000, 'HZ-20241027-BiYGWz'),
(174, 31, 1, '2024-10-28 00:04:52', '2024-10-28 00:04:52', 44990000, 'HZ-20241028-ZGmyjF'),
(175, 31, 3, '2024-10-28 00:10:22', '2024-10-28 00:11:47', 60000000, 'HZ-20241028-PDYnza'),
(176, 31, 1, '2024-11-30 11:08:45', '2024-11-30 11:08:45', 20000000, 'HZ-20241130-pP9NFv'),
(177, 31, 2, '2024-11-30 11:09:39', '2024-11-30 11:12:31', 10000000, 'HZ-20241130-rosk6h'),
(178, 31, 3, '2024-11-30 11:10:21', '2024-11-30 11:12:21', 4000000, 'HZ-20241130-FBQtU7');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `total_pro`) VALUES
(11, 13, 31, 1, 10000000),
(18, 18, 27, 1, 10000000),
(19, 19, 8, 1, 1000000),
(32, 32, 3, 1, 100000),
(96, 90, 28, 1, 200000),
(97, 90, 31, 1, 10000000),
(98, 91, 33, 1, 200000),
(99, 91, 27, 1, 10000000),
(100, 92, 27, 1, 10000000),
(101, 92, 31, 2, 20000000),
(102, 93, 6, 1, 10000000),
(103, 94, 11, 1, 200000),
(104, 95, 7, 1, 10000000),
(105, 96, 4, 1, 999999),
(106, 96, 6, 1, 10000000),
(107, 97, 2, 1, 10000000),
(108, 98, 2, 2, 20000000),
(109, 100, 6, 1, 10000000),
(113, 104, 3, 1, 8000000),
(114, 105, 30, 1, 200000),
(115, 106, 2, 1, 7500000),
(116, 106, 32, 1, 10000000),
(118, 109, 8, 1, 1000000),
(119, 110, 8, 1, 1000000),
(120, 111, 10, 1, 1170000),
(121, 112, 8, 1, 200000),
(122, 113, 2, 1, 7500000),
(123, 114, 2, 7, 52500000),
(126, 119, 8, 1, 200000),
(128, 121, 2, 1, 7500000),
(129, 121, 3, 1, 7200000),
(130, 122, 2, 1, 7500000),
(131, 123, 2, 1, 7500000),
(132, 124, 4, 2, 19980000),
(135, 127, 2, 1, 7500000),
(138, 130, 2, 1, 7500000),
(140, 132, 4, 4, 39960000),
(141, 133, 2, 1, 7500000),
(142, 134, 2, 1, 7500000),
(143, 135, 2, 1, 7500000),
(144, 136, 2, 1, 7500000),
(145, 137, 2, 1, 7500000),
(146, 138, 2, 1, 7500000),
(147, 139, 2, 1, 7500000),
(148, 140, 2, 1, 7500000),
(149, 152, 2, 1, 7500000),
(150, 153, 27, 1, 9000000),
(151, 154, 28, 1, 1500000),
(152, 155, 28, 1, 1500000),
(154, 160, 8, 1, 200000),
(155, 161, 2, 1, 7500000),
(156, 162, 8, 1, 200000),
(160, 167, 2, 1, 7500000),
(161, 168, 2, 1, 7500000),
(162, 169, 2, 1, 7500000),
(163, 169, 8, 2, 400000),
(164, 170, 2, 1, 7500000),
(165, 171, 34, 1, 20000000),
(166, 172, 2, 1, 10000000),
(167, 173, 2, 1, 10000000),
(168, 174, 54, 1, 44990000),
(169, 175, 34, 1, 20000000),
(170, 175, 27, 4, 40000000),
(171, 176, 26, 1, 20000000),
(172, 177, 6, 1, 10000000),
(173, 178, 30, 1, 4000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `dis_id` int(11) DEFAULT NULL,
  `img` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `des` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `cate_id`, `dis_id`, `img`, `name`, `price`, `quantity`, `des`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'a.png', 'iphone 15', 10000000, 159, 'iPhone 15 Pro Max thiết kế mới với chất liệu titan chuẩn hàng không vũ trụ bền bỉ, trọng lượng nhẹ, đồng thời trang bị nút Action và cổng sạc USB-C tiêu chuẩn giúp nâng cao tốc độ sạc. Khả năng chụp ảnh đỉnh cao của iPhone 15 bản Pro Max đến từ camera chính 48MP, camera UltraWide 12MP và camera telephoto có khả năng zoom quang học đến 5x. Bên cạnh đó, iPhone 15 ProMax sử dụng chip A17 Pro mới mạnh mẽ. Xem thêm chi tiết những điểm nổi bật của sản phẩm qua thông tin sau!', '2023-09-28 04:47:00', '2024-10-27 13:04:39'),
(3, 1, 2, 'b.png', 'Samsung Galaxy A54', 8000000, 198, 'samsung A54 đột phá với màn hình Super AMOLED 6.4 inch tràn viền vô cực Infinity-O, độ sáng đến 1000nits, tần số quét lên đến 120Hz. Dòng điện thoại này cũng sở hữu cụm 3 camera phân giải cao 50.0 MP + 12.0 MP + 5.0 MP với tính năng ổn định kỹ thuật số và Auto-framing kết hợp chống rung OIS.', '2023-09-28 06:08:06', '2023-11-05 05:22:08'),
(4, 2, 4, 'c.png', 'SamSung Tab', 9990000, 196, 'Mô tả sản phẩm', '2023-10-10 02:47:20', '2023-11-05 05:22:42'),
(6, 3, NULL, '1696947921.png', 'nitro 5', 10000000, 199, 'đây là mô tả sản phẩm', '2023-10-10 07:25:21', '2024-11-30 11:09:39'),
(7, 3, NULL, '1696947988.png', 'legion 5', 10000000, 200, 'đây là mô tả sản phẩm', '2023-10-10 07:26:28', '2023-10-31 02:41:06'),
(8, 1, 5, '1696949387.png', 'Xiaomi', 1000000, 194, 'đây là mô tả sản phẩm', '2023-10-10 07:49:47', '2023-11-22 08:39:37'),
(9, 4, NULL, '1696991487.png', 'apple watch', 10000000, 0, 'aa', '2023-10-10 19:31:27', '2023-11-04 13:00:04'),
(10, 2, 4, '1697030899.png', 'Ipad', 1300000, 200, 'Product 1 Description', '2023-10-11 06:28:19', '2023-10-31 17:04:06'),
(11, 3, 5, '1697035396.png', 'macbook pro', 30000000, 200, 'aa', '2023-10-11 07:43:16', '2023-11-01 12:31:10'),
(26, 5, NULL, '1697119123.png', 'imac', 20000000, 199, 'đây là mô tả sản phẩm', '2023-10-12 06:58:43', '2024-11-30 11:08:45'),
(27, 3, 2, '1697127505.png', 'Laptop gaming MSI GF63', 10000000, 195, 'Laptop MSI Gaming GF63 Thin 11SC-664VN là sản phẩm thuộc phân khúc giá tầm trung, phù hợp với những game thủ. Đây là dòng laptop có vẻ ngoài nhỏ gọn nhưng vẫn mang đậm phong cách gaming.', '2023-10-12 09:18:25', '2024-10-28 00:10:22'),
(28, 2, 1, '1697127621.png', 'Xiaomi Pad 5', 2000000, 197, 'Xiaomi Mi Pad 5 được cung cấp sức mạnh bởi con chip Snapdragon 860 kết hợp RAM 6GB mang lại hiệu năng mạnh mẽ cùng bộ nhớ trong lên đến 256GB giúp bạn tha hồ lưu trữ dữ liệu, hình ảnh và video.', '2023-10-12 09:20:04', '2023-11-05 05:53:12'),
(29, 1, NULL, '1697127736.png', 'OnePlus Nord 3 5G', 9999990, 0, 'OnePlus Nord 3 5G thiết kế màn hình đục lỗ, kích thước 6.74 inch, độ phân giải cao, tần số quét 120Hz. Đặc biệt, sản phẩm sở hữu con chip Dimensity 9000, trang bị 2 ống kính với cảm biến chính 50MP. Cuối cùng, thiết bị có viên pin 5.000 mAh, xuất xưởng với giao diện OxygenOS 13.1 mới nhất dựa trên hệ điều hành Android 13.', '2023-10-12 09:21:58', '2023-11-04 12:54:06'),
(30, 1, NULL, '1697127791.png', 'iPhone 11', 4000000, 198, 'iPhone 11 128GB giá bao nhiêu ở thời điểm hiện tại, có vừa túi tiền người mua hay không? Với cấu hình, thiết kế, hiệu năng được đánh giá cao, có thể thấy sản phẩm đến từ nhà Táo này là sự lựa chọn tối ưu trong tầm giá.', '2023-10-12 09:23:11', '2024-11-30 11:10:22'),
(31, 1, NULL, '1697127938.png', 'Samsung Galaxy S23 Ultra', 10000000, 200, 'Sau sự đổ bộ thành công của Samsung Galaxy S22 những chiếc điện thoại dòng Flagship tiếp theo - Điện thoại Samsung Galaxy S23 Ultra là đối tượng được Samfans hết mực săn đón. Kiểu dáng thanh lịch sang chảnh kết hợp với những bước đột phá trong công nghệ đã kiến tạo nên siêu phẩm Flagship nhà Samsung.', '2023-10-12 09:25:38', '2023-10-31 03:29:27'),
(32, 1, 1, '1697128027.png', 'Samsung Galaxy A05S', 10000000, 199, 'Samsung Galaxy A05s được trang bị con chip Qualcomm Snapdragon 680 cùng với đó là dung lượng pin lớn, công nghệ sạc nhanh 25W và màn hình chất lượng. Đặc biệt, hãng còn nâng cấp cả camera sau lên tới 50 MP và camera selfie:13MP để mang tới cho người dùng trải nghiệm trọn vẹn nhất. Hứa hẹn đây sẽ là mẫu smartphone trong tầm giá giúp người dùng thoải mái khám phá thế giới đầy sắc màu.', '2023-10-12 09:27:07', '2023-10-31 17:01:26'),
(33, 1, NULL, '1697128125.png', 'ASUS ROG Phone 7 Ultimate', 2000000, 200, 'Asus ROG phone 7 Ultimate 16GB 512GB sở hữu con chip Snapdragon 8 Gen 2 với sức mạnh siêu khủng đến từ nhà Qualcomm. Màn hình được làm từ màn amoled có kích thước khủng tận 6.78 inch cho chất lượng hình ảnh Full HD Plus. Camera siêu xịn với độ phân giải lên đến 50MP đi kèm viên pin dung lượng vô đối 6000mAh và chế độ sạc HyperCharge 65W.', '2023-10-12 09:28:45', '2023-10-31 04:33:29'),
(34, 3, NULL, '1697128280.png', 'ASUS TUF Gaming F15 FX506HC-HN144W', 20000000, 198, 'Laptop Asus TUF Gaming F15 FX506HC-HN144W sở hữu thiết kế táo bạo và độc đáo bậc nhất trên thị trường với gam màu Graphite black nổi bật mà cực huyền bí. Với hiệu năng đỉnh cao và linh kiện cấu thành có chất lượng đứng đầu thị trường, chiếc laptop Asus Gaming này được kỳ vọng dễ dàng chinh phục mọi thử thách và đồng hành với các game thủ trên mọi đấu trường.', '2023-10-12 09:31:20', '2024-10-28 00:10:22'),
(35, 3, NULL, '1697128509.png', 'Laptop Lenovo Gaming Legion 5', 10000000, 200, 'Dù là mẫu laptop gaming nhưng với vẻ bề ngoài trang nhã, laptop Lenovo Gaming Legion 5 15ARH7 82RE002VVN còn rất phù hợp để sử dụng trong môi trường công sở. Với hiệu năng mạnh mẽ của mình, sản phẩm laptop Lenovo Gaming hứa hẹn sẽ làm hài lòng cả những yêu cầu khắt khe nhất dù là công việc hay giải trí.', '2023-10-12 09:35:09', '2023-10-31 02:41:06'),
(43, 1, NULL, '1698636067.png', 'iphone 13', 14000000, 200, 'Về kích thước, iPhone 13 sẽ có 4 phiên bản khác nhau và kích thước không đổi so với series iPhone 12 hiện tại. Nếu iPhone 12 có sự thay đổi trong thiết kế từ góc cạnh bo tròn (Thiết kế được duy trì từ thời iPhone 6 đến iPhone 11 Pro Max) sang thiết kế vuông vắn (đã từng có mặt trên iPhone 4 đến iPhone 5S, SE).  Thì trên điện thoại iPhone 13 vẫn được duy trì một thiết kế tương tự. Máy vẫn có phiên bản khung viền thép, một số phiên bản khung nhôm cùng mặt lưng kính. Tương tự năm ngoái, Apple cũng sẽ cho ra mắt 4 phiên bản là iPhone 13, 13 mini, 13 Pro và 13 Pro Max.', '2023-10-30 03:21:07', '2023-10-31 02:41:06'),
(44, 4, NULL, '1698636980.png', 'Huawei Watch GT3', 3990000, 200, 'Tích hợp hàng loạt công nghệ đo lường sức khỏe hiện đại, cùng với thiết kế dây silicone mềm mại êm tay, đồng hồ thông minh Huawei Watch GT3 46mm dây silicone góp phần giúp bạn luôn tận hưởng lối sống năng động của riêng mình một cách trọn vẹn.', '2023-10-30 03:36:20', '2023-10-31 02:41:06'),
(45, 5, NULL, '1698637135.png', 'All In One ASUS A3402WBAK-WA070W', 14000000, 200, 'Máy tính AIO ASUS A3402WBAK WA070W là chiếc máy tính để bàn All in One hiện đại đến từ thương hiệu ASUS đình đám. Thiết bị sở hữu vẻ ngoài tinh tế, được trang bị màn hình rộng 23.8 inch cùng bộ vi xử lý i3 1215U, RAM 8GB đem lại hiệu năng ổn định.', '2023-10-30 03:38:55', '2023-10-31 02:41:06'),
(47, 4, NULL, '1698637460.png', 'Apple Watch SE 2022', 4000000, 200, 'Tiếp tục là sản phẩm đồng hồ thông minh thuộc phân khúc tầm trung, đồng hồ Apple Watch SE 2022 là phiên bản kế nhiệm Apple Watch SE được ra mắt trước đó. Đồng hồ thông minh Apple Watch SE 2022 được trang bị con chip Apple S8 cùng tính năng ấn tượng như phát hiện té ngã và tai nạn thông minh.', '2023-10-30 03:44:20', '2023-10-31 02:41:06'),
(48, 3, NULL, '1698637750.png', 'Macbook Pro 13 M2 2022', 30000000, 200, 'Sau sự thành công của Macbook Pro M1, Apple tiếp tục cho ra mắt phiên bản nâng cấp với con chip mạnh hơn mang tên Macbook Pro M2 vào năm 2022. Macbook Pro M2 2022 sở hữu một hiệu năng vượt trội với con chip M2, card đồ họa 10 nhân GPU hứa hẹn mang lại cho người dùng những trải nghiệm vượt trội.', '2023-10-30 03:49:10', '2023-10-31 02:41:06'),
(49, 5, NULL, '1698637919.png', 'Mac mini M2 2023', 14000000, 200, 'Mac Mini M2 là sản phẩm được đánh giá cao từ tính năng đến thiết kế, nhà sản xuất đã cải tiến để đáp ứng các nhu cầu khác nhau của khách hàng so với bản tiền nhiệm trước đó. Sản phẩm đã được mong đợi từ trước khi ra mắt với số lượng đặt trước tăng lên liên tục khi được chính thức tung ra thị trường.', '2023-10-30 03:51:59', '2023-10-31 02:41:06'),
(51, 3, NULL, '1698638208.png', 'Acer Gaming Aspire 7', 14000000, 200, NULL, '2023-10-30 03:56:48', '2023-10-31 02:41:06'),
(52, 3, 5, '1698638457.png', 'Macbook Pro M1', 70000000, 200, 'Không chỉ là điểm nhận biết trên các thiết bị smartphone, hiện nay tai thỏ đã xuất hiện trên thế hệ Macbook mới nhất. Macbook Pro 16 M1 Max với thiết kế độc đáo, màn hình chất lượng mang lại trải nghiệm vượt  trội. Máy tính Macbook Pro 16 inch 2021 được trang bị cấu hình cực khủng với chip Apple M1 Max với 10CPU, 32GPU đi kèm dung lượng lên đến RAM 32GB và bộ nhớ SSD 1TB mang lại hiệu suất vượt trội.', '2023-10-30 04:00:57', '2023-11-01 13:00:33'),
(53, 3, NULL, '1698638606.png', 'Asus VivoBook 14X OLED', 20000000, 200, 'Laptop Asus Vivobook 14X OLED S3405VA KM071W là dòng laptop phổ thông ẩn chứa những thông số kỹ thuật ấn tượng. Hướng đến đối tượng học sinh sinh viên, phiên bản laptop Asus Vivobook này hứa hẹn sẽ mang đến những trải nghiệm thú vị dành cho bạn.', '2023-10-30 04:03:26', '2023-10-31 02:41:06'),
(54, 1, NULL, '1698639189.png', 'OPPO Find N3 Fold', 44990000, 199, 'OPPO Find N3 Fold được trình làng chỉ sau một thời gian ngắn sau khi phiên bản Find N2 ra mắt, mang nhiều cập nhật mới. Trên phiên bản điện thoại gập thế hệ thứ 3 này, OPPO sẽ mang tới một mẫu flagship mạnh mẽ hơn, được trang bị vi xử lý Qualcomm Snapdragon® 8 Gen 2 Mobile Platform, 16GB RAM, màn hình chính 7.82 inch, màn hinh ngoài 6.31 inch cùng hệ thống camera Hasselblad đầy ấn tượng.', '2023-10-30 04:13:09', '2024-10-28 00:04:52'),
(55, 1, NULL, '1698639369.png', 'OPPO Reno8 T 5G', 7000000, 200, 'OPPO Reno8 T sở hữu hiệu năng mạnh mẽ, trang bị bộ vi xử lý thế hệ mới Snapdragon 695, tấm nền AMOLED 6.7 inch, màn hình 1 tỉ màu mang lại chất lượng hình ảnh siêu sắc nét và sống động tới từng chi tiết.  Dung lượng Pin điện thoại Reno8 T 5G lên tới 4800mAh cùng thông số bộ nhớ đạt 8GB RAM và 128GB ROM giúp người dùng có thể thoải mái trải nghiệm mà không cần lo về vấn đề năng lượng hay bộ nhớ lưu trữ trong quá trình sử dụng.', '2023-10-30 04:16:09', '2023-10-31 02:41:06'),
(56, 1, NULL, '1698639518.png', 'iPhone XR', 8000000, 200, 'Được ra mắt cùng Apple iPhone XS và XS Max, iPhone XR không chỉ được thừa kế những tính năng đặc trưng nổi trội của người tiền nhiệm iPhone X được ra mắt một năm trước đó và còn có những cải tiến nhằm mang lại trải nghiệm mới lạ và thú vị cho người dùng.', '2023-10-30 04:18:38', '2023-10-31 02:41:06'),
(57, 1, NULL, '1698639744.png', 'Samsung Galaxy M34 5G', 7000000, 200, 'Samsung M34 5G là chiếc điện thoại làm nên ấn tượng nhờ chip Exynos 1280 mạnh mẽ và ROM 128 GB, RAM 8GB. Cùng với đó là hệ thống 3 camera với cảm biến chính 50MP, góc siêu rộng 8 MP + macro 2 MP và camera selfie 13MP. Cạnh đó, màn hình Super AMOLED cao cấp, tần số quét 120Hz và viên pin 6000mAh còn tạo nên những điểm nhấn đặc biệt cho chiếc smartphone này.', '2023-10-30 04:22:24', '2023-10-31 02:41:06'),
(58, 1, NULL, '1698639858.png', 'Samsung Galaxy Z Flip5', 20000000, 200, 'Samsung Galaxy Z Flip 5 có thiết kế màn hình rộng 6.7 inch và độ phân giải Full HD+ (1080 x 2640 Pixels), dung lượng RAM 8GB, bộ nhớ trong 256GB. Màn hình Dynamic AMOLED 2X của điện thoại này hiển thị rõ nét và sắc nét, mang đến trải nghiệm ấn tượng khi sử dụng.', '2023-10-30 04:24:18', '2023-10-31 02:41:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rate`
--

INSERT INTO `rate` (`id`, `user_id`, `product_id`, `star`, `comment`, `created_at`) VALUES
(1, 21, 2, 4, 'Very good', '2023-10-28 08:09:44'),
(2, 21, 2, 5, 'abc', '2023-10-28 08:12:24'),
(3, 27, 2, 5, 'abc', '2023-10-28 08:32:23'),
(4, 27, 2, 1, 'verybad', '2023-10-28 08:47:59'),
(5, 27, 2, 5, 'good', '2023-10-28 09:09:04'),
(6, 30, 2, 2, 'bad', '2023-10-28 09:31:29'),
(7, 21, 6, 4, 'nice', '2023-10-28 10:46:52'),
(8, 21, 10, 3, 'abc', '2023-10-28 10:55:40'),
(9, 21, 30, 4, 'good', '2023-10-31 03:17:10'),
(10, 31, 10, 1, 'shop như lon', '2023-11-01 06:39:39'),
(11, 21, 8, 5, NULL, '2023-11-01 10:46:15'),
(12, 49, 2, 3, 'nice', '2023-11-04 05:37:59'),
(13, 31, 8, 5, 'abc', '2023-11-22 08:40:01'),
(14, 31, 2, 1, 'Ngon bổ rẻ chất lượng tuyệt vời', '2023-11-22 08:40:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `spec`
--

CREATE TABLE `spec` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `brand` varchar(25) DEFAULT NULL,
  `chip` varchar(25) DEFAULT NULL,
  `storage` varchar(15) DEFAULT NULL,
  `ram` varchar(15) DEFAULT NULL,
  `screen` varchar(20) DEFAULT NULL,
  `camera` varchar(20) DEFAULT NULL,
  `vga` varchar(40) DEFAULT NULL,
  `pin` varchar(15) DEFAULT NULL,
  `os` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `spec`
--

INSERT INTO `spec` (`id`, `product_id`, `brand`, `chip`, `storage`, `ram`, `screen`, `camera`, `vga`, `pin`, `os`) VALUES
(2, 2, 'apple', 'A17 Pro', '512 GB', '12 GB', '6.7 inches', '12MP, ƒ/1.9', NULL, '4000 mAh', 'IOS'),
(3, 35, 'lenovo', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(4, 32, 'samsung', NULL, '256 GB', '4 GB', '6.4 inches', NULL, NULL, NULL, NULL),
(5, 9, 'Apple', 'A2', '16 GB', '2 GB', '2 inches', NULL, NULL, '1000 mAh', 'watch os'),
(6, 3, 'samsung', 'Exynos 1380 (5 nm)', '256 GB', '8 GB', '6.4 inches', '12MP, f/2.2', NULL, '5000 mAh', 'Android'),
(7, 4, 'samsung', NULL, '512 GB', '12 GB', '12 inches', NULL, NULL, '11200 mAh', NULL),
(8, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 11, 'apple', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(10, 43, 'apple', 'Apple A15', '128 GB', '4 GB', '6.1 inches', '12MP, f/2.2', NULL, '4000 mAh', 'iOS 15'),
(11, 44, 'huawei', NULL, '4 GB', NULL, '1.43 inch', NULL, NULL, NULL, NULL),
(13, 47, 'apple', 'Apple S8 SiP', '32 GB', NULL, '2 inches', NULL, NULL, NULL, 'WatchOS'),
(14, 48, 'apple', 'Apple M2', '256 GB', '8 GB', '13 inches', 'FaceTime HD', '10 nhân GPU', '58.2 Whrs', 'MacOS'),
(16, 51, 'acer', 'Intel Core i5 - 12450H', '256 GB', '8 GB', '15.6 inches', 'HD Webcam', 'Intel UHD', '50 Wh', 'Windows 11'),
(17, 52, 'apple', 'Apple M1', '1 TB', '32 GB', '16.2 inches', NULL, '32 GPU', NULL, 'MacOS'),
(18, 53, 'asus', 'Intel Core i9-13900H', '512 GB', '8 GB', '14 inches', NULL, 'Intel Iris Xe Graphics', '63 WHrs', 'Windows 11'),
(19, 54, 'oppo', 'Snapdragon 8 Gen 2', '512 GB', '16 GB', '7.82 inches', '64MP, f/2.6', NULL, '4805 mAh', 'Android 13'),
(20, 55, 'oppo', 'Snapdragon 695 5G 8 nhân', '128 GB', '8 GB', '6.7 inches', '32 MP', NULL, '4800 mAh', 'Coloros 13'),
(21, 56, 'apple', 'Apple A12', '128 GB', '4 GB', '6.1 inches', '12MP', NULL, '2942mAh', 'iOS 14'),
(22, 57, 'samsung', 'Exynos 1380', '128 GB', '8 GB', '6.5 inches', '12MP, ƒ/1.9', NULL, '4000 mAh', 'Android'),
(23, 58, 'samsung', 'Snapdragon 8 Gen 2', '256 GB', '8 GB', '6.7 inches', '10MP, F2.4', NULL, '3700 mAh', 'Android 13'),
(24, 31, 'samsung', NULL, '512 GB', '8 GB', '7 inches', NULL, NULL, NULL, NULL),
(25, 34, 'asus', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(26, 33, 'asus', NULL, '512 GB', '8 GB', '6.7 inches', NULL, NULL, NULL, NULL),
(27, 28, 'xiaomi', NULL, '256 GB', '4 GB', '9.7 inches', NULL, NULL, NULL, NULL),
(28, 30, 'apple', NULL, '512 GB', '8 GB', '6.7 inches', NULL, NULL, NULL, NULL),
(29, 29, 'oneplus', NULL, '512 GB', '8 GB', '6.7 inches', NULL, NULL, NULL, NULL),
(30, 26, 'apple', NULL, '256 GB', '8 GB', '20 inches', NULL, NULL, NULL, NULL),
(31, 27, 'msi', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(32, 8, 'xiaomi', NULL, '128 GB', '8 GB', '6.7 inches', NULL, NULL, NULL, NULL),
(33, 6, 'acer', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(34, 7, 'lenovo', NULL, '512 GB', '8 GB', '15.6 inches', NULL, NULL, NULL, NULL),
(35, 45, 'asus', NULL, '128 GB', '12 GB', '23.8 inches', NULL, NULL, NULL, NULL),
(36, 49, 'apple', NULL, '512 GB', '8 GB', 'không có', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `u_level` char(1) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `provider` varchar(25) DEFAULT NULL,
  `provider_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `u_level`, `username`, `email`, `phone`, `password`, `address`, `created_at`, `updated_at`, `provider`, `provider_id`) VALUES
(20, '1', 'NC Toàn', 'titot2003@gmail.com', '1234567890', '$2y$10$4mQa0XAx0aYxD/R/edjzWOp2DcmjYjl5KPviGSTqGtUzHLkey2Qxe', 'Hanoi, Vietnam', '2023-10-13 23:46:09', '2025-03-17 20:18:39', 'google', '116776910662046333294'),
(21, '2', 'admin', 'toan@example.com', '1234567890', '$2y$10$vRsH0zUTHtbnhHsiB2mgcO8TnfBv6s2KaaUH7LplEIOqINn.H2RSS', 'Hanoi, Vietnam', '2023-10-13 23:46:35', '2024-10-21 02:41:14', NULL, NULL),
(27, '1', 'Toàn', 'nguyencanhtoanabc@gmail.c', '1234567890', '$2y$10$yn0IPxp62tpY0icZCuaLfe1J0aFXaOgdN.rbO4x/DCPQ90D77vG4i', 'Hanoi, Vietnam', '2023-10-23 03:32:00', '2024-10-21 02:41:42', 'google', '116833891608129224762'),
(29, '1', '1233132', 'aj8@mail.com', '1234567890', '$2y$10$5XJXtkg7VfAE5sjWlAIkxOGr49TNg.e4nxmdJDOVKSfreCkZma5fG', 'Hanoi, Vietnam', '2023-10-23 08:02:59', '2023-10-23 08:02:59', NULL, NULL),
(30, '1', '123123', 'cjd73872@omeie.com', '17124845023', '$2y$10$AZbtisurzGHvX5YPNdZ.Y.OARyx0UuOFtU/UqvEhc5ADwGsaOEXGy', 'Hanoi, Vietnam', '2023-10-23 11:20:18', '2023-10-23 11:22:39', NULL, NULL),
(31, '1', 'admin123', 'quanduilonggio@gmail.com', '7823642112', '$2y$10$IiUCXw30I8COUlnY2Lv66eOW44eAdJYZF9z1yJwBJ1ixwUVSL8T1q', 'Hanoi, Vietnam', '2023-11-01 05:53:52', '2024-10-07 08:42:42', NULL, NULL),
(32, '1', 'taikhoan', 'toan2003@gmail.com', '7823642112', '$2y$10$mERbo4RCdkMTpkj9yxqvIu2YyLlQjbnXwKTVn2eZwBYzMOsUv3JvC', 'Hanoi, Vietnam', '2023-11-01 09:07:00', '2024-10-21 02:41:54', NULL, NULL),
(49, '1', 'Toàn ', 'toan@gmail.com', '7823642112', '$2y$10$7XidPR5k1YprUqRX9pSZsOUDvqFf5g/pW0AXA52pI17Wdsfj8DD8.', 'Hanoi, Vietnam', '2023-11-02 12:15:09', '2024-10-21 02:32:30', 'facebook', '865084384965646'),
(51, '1', 'admin', 'xaxixe3624@rdluxe.com', '1234567890', '$2y$10$yXMN/asPCqbEz3.3EcRtzexIAAbptnGsjqn.a5BM8pdo5nCMZqFSq', 'Hanoi, Vietnam', '2023-11-05 10:07:23', '2023-11-05 10:07:23', NULL, NULL),
(52, '2', 'toan admin', 'toanadmin@example.com', '0373736102', '$2y$10$yQj/t8TjHLLv44Q/8DbpF.0T7XomkGdSH/1PAlzUd.YVP0q08iVp6', NULL, '2024-10-21 02:57:42', '2024-10-21 02:57:42', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_ibfk_1` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_ibfk_3` (`order_id`),
  ADD KEY `fk_order_details_product` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ibfk_1` (`cate_id`),
  ADD KEY `product_ibfk_2` (`dis_id`);

--
-- Chỉ mục cho bảng `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rate_ibfk_1` (`user_id`),
  ADD KEY `rate_ibfk_2` (`product_id`);

--
-- Chỉ mục cho bảng `spec`
--
ALTER TABLE `spec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spec_ibfk_1` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `spec`
--
ALTER TABLE `spec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`dis_id`) REFERENCES `discount` (`id`);

--
-- Các ràng buộc cho bảng `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `spec`
--
ALTER TABLE `spec`
  ADD CONSTRAINT `spec_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
