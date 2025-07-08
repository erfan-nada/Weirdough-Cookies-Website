-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2025 at 03:36 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weirdough`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `cookie_name` varchar(255) DEFAULT NULL,
  `cookie_image` text,
  `quantity` int DEFAULT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `session_id`, `cookie_name`, `cookie_image`, `quantity`, `price`) VALUES
(70, 'spvuga6jgovcs58k4s1vonu029', 'NOT TODAY MR. MUFFIN MAN', 'https://lastcrumb.com/cdn/shop/files/09_BlueberryMuffin_Knockout_002_600x.png?v=1742927320', 1, 13.75),
(68, 'spvuga6jgovcs58k4s1vonu029', 'THE JAMES DEAN', 'https://lastcrumb.com/cdn/shop/files/jamesdean_2x_1024x1024_e3616aad-fba7-4b84-86a0-bd51ae6c9608_600x.webp?v=1736875366', 1, 13),
(69, 'spvuga6jgovcs58k4s1vonu029', 'WHAT THE VELVET', 'https://lastcrumb.com/cdn/shop/files/08_RedVelvet_Knockout_003_600x.png?v=1742926799', 1, 13.5),
(66, 'spvuga6jgovcs58k4s1vonu029', 'EVERYTHING BUT THE CANDLES', 'https://lastcrumb.com/cdn/shop/files/everythingbutthecandles_2x_1024x1024_598451d2-5f07-406d-abc3-1663bd219331_600x.webp?v=1736875374', 1, 13),
(64, 'spvuga6jgovcs58k4s1vonu029', 'THE CLASSIC ONE', 'https://lastcrumb.com/cdn/shop/files/01_ChocolateChip_Knockout_001_3754f278-6b96-48f8-ad0a-38a5bd32ed32_600x.png?v=1742926690', 1, 12),
(67, 'spvuga6jgovcs58k4s1vonu029', 'THE MADONNA', 'https://lastcrumb.com/cdn/shop/files/03_PeanutButter_Knockout_002_600x.png?v=1742927099', 1, 12.5);

-- --------------------------------------------------------

--
-- Table structure for table `cookies`
--

DROP TABLE IF EXISTS `cookies`;
CREATE TABLE IF NOT EXISTS `cookies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `image_url` text,
  `stock` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cookies`
--

INSERT INTO `cookies` (`id`, `name`, `description`, `price`, `image_url`, `stock`) VALUES
(1, 'THE CLASSIC ONE', 'CHOCOLATE CHIP', 12.00, 'https://lastcrumb.com/cdn/shop/files/01_ChocolateChip_Knockout_001_3754f278-6b96-48f8-ad0a-38a5bd32ed32_600x.png?v=1742926690', 89),
(2, 'EVERYTHING BUT THE CANDLES', 'BIRTHDAY CAKE', 13.00, 'https://lastcrumb.com/cdn/shop/files/everythingbutthecandles_2x_1024x1024_598451d2-5f07-406d-abc3-1663bd219331_600x.webp?v=1736875374', 83),
(3, 'THE MADONNA', 'PEANUT BUTTER', 12.50, 'https://lastcrumb.com/cdn/shop/files/03_PeanutButter_Knockout_002_600x.png?v=1742927099', 9),
(4, 'WHEN LIFE GIVES YOU LEMONS', 'LEMON BAR', 12.75, 'https://lastcrumb.com/cdn/shop/files/whenlifegivesyoulemons_2x_1024x1024_1c431318-3897-47d0-9938-1e546bf6fd5f_600x.webp?v=1736875379', 21),
(5, 'THE FLOOR IS LAVA', 'CHOCOLATE LAVA', 13.50, 'https://lastcrumb.com/cdn/shop/files/05_ChocolateLava_Knockout_003_600x.png?v=1740346255', 28),
(6, 'MACADAMNIA', 'SALTED CARAMEL MACADAMIA', 14.00, 'https://lastcrumb.com/cdn/shop/files/06_SaltedCaramelMacadamia_Knockout_002_600x.png?v=1742927088', 29),
(7, 'THE JAMES DEAN', 'OREO MILKSHAKE', 13.00, 'https://lastcrumb.com/cdn/shop/files/jamesdean_2x_1024x1024_e3616aad-fba7-4b84-86a0-bd51ae6c9608_600x.webp?v=1736875366', 17),
(8, 'WHAT THE VELVET', 'RED VELVET', 13.50, 'https://lastcrumb.com/cdn/shop/files/08_RedVelvet_Knockout_003_600x.png?v=1742926799', 22),
(9, 'NOT TODAY MR. MUFFIN MAN', 'BLUEBERRY MUFFIN', 13.75, 'https://lastcrumb.com/cdn/shop/files/09_BlueberryMuffin_Knockout_002_600x.png?v=1742927320', 6),
(10, 'NETFLIX AND CRUNCH', 'CINNAMON TOAST CRUNCH', 13.25, 'https://lastcrumb.com/cdn/shop/files/netflixandcrunch_2x_1024x1024_73ece8de-f153-4b95-aac7-1c0a4de82c8b_600x.webp?v=1740346292', 28),
(11, 'S\'MORE THAN A FEELING', 'S\'MORES', 14.25, 'https://lastcrumb.com/cdn/shop/files/11_Smores_Knockout_001_02d74d68-405a-42d7-8707-22fbe1e2df89_600x.png?v=1737755600', 30),
(12, 'DONKEY KONG', 'BANANA PUDDING', 13.75, 'https://lastcrumb.com/cdn/shop/files/donkeykong_2x_1024x1024_94891e56-7dfa-44f7-b426-48f3b9a12878_600x.webp?v=1736875419', 30);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `orderID` int NOT NULL AUTO_INCREMENT,
  `totalPrice` float NOT NULL,
  `pickupID` int NOT NULL,
  `deliveryID` int NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `promoID` int NOT NULL AUTO_INCREMENT,
  `promoType` varchar(255) NOT NULL,
  `discountAmount` int NOT NULL,
  `expiryDate` date NOT NULL,
  `promoCode` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`promoID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`promoID`, `promoType`, `discountAmount`, `expiryDate`, `promoCode`, `img`) VALUES
(1, '', 20, '2025-05-31', 'WEEKEND20', 'https://ik.imagekit.io/5yvgym2qm/tr:w-0,h-0/products/6693c5e685dc7/66a44f2c19fb6productimage66a44250ae70d.jpg?ik-sdk-version=react-1.1.1'),
(2, '', 25, '2025-05-30', 'DOUGHLOVE', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/676c3e555a48cproductimage676c378e465bb.jpg'),
(3, '', 15, '2025-06-02', 'TREAT15', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/66ad61c47e0d5productimage66ad605638a19.jpg'),
(4, '', 5, '2025-05-28', 'BOX5', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/66a44fe9b60bfproductimage66a44250ae74c.jpg'),
(5, '', 10, '2025-07-02', 'SPRINKLE10', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/66a44fe255910productimage66a44250ae72a.jpg'),
(6, '', 30, '2025-05-27', 'SWEETDEAL', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/676c3e567167aproductimage676c378e465ab.jpg'),
(7, '', 33, '2025-06-19', 'DOUGHS33', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/66a44fea0f5ecproductimage66a44250ae74e.jpg?ik-sdk-version=react-1.1.1'),
(8, '', 80, '2025-05-27', 'WEIRDO80', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/676c3e2505e06productimage676c378e46669.jpg?ik-sdk-version=react-1.1.1'),
(9, '', 50, '2025-06-22', 'NOMNOM', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/672d2b53865f1productimage66a44250ae705.jpeg?ik-sdk-version=react-1.1.1'),
(10, '', 18, '2025-05-30', 'SWEETOOTH', 'https://ik.imagekit.io/5yvgym2qm/tr:w-500,h-500/products/6693c5e685dc7/66a44fe7e3fc0productimage66a44250ae73e.jpg?ik-sdk-version=react-1.1.1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(135, 'Fajr', 'fajr@gmail.com', '$2y$10$dvrFI3R65CuEeZxO7ngyBeZiaHJ9aI21s0yVK4YNfy18mN5.kQO3S', 'admin'),
(136, 'mahmoud', 'mahdm@gmail.com', '$2y$10$cjoDGGUHCozwh8BM055IXesMKqFNVvOqprhpNk8LjLtkjWhaags8W', 'customer'),
(133, 'Omar', 'omar@gmail.com', '$2y$10$gn29MaOgfWs6QCjx/xI5IOmYVO2O69N/QbO4O94h3vvuKWvb/Tb8.', 'guest'),
(132, 'Erfan', 'erfannada8@gmail.com', '$2y$10$cz9sXZVakkmeQuG6Ddbk0ODmV98PO9Me9xgZXYMqbsbPV91Nf6lyC', 'admin'),
(138, 'Mostafa Mohamed', 'omar@gmail.com', '$2y$10$B0qagcnuGusCQbd20Ep8j.VyYrSzS6KK0CxzFr2h671MY8nL69SHa', 'customer'),
(139, 'Mostafa Mohamed', 'omarkw34@gmail.com', '$2y$10$KlRRyW.Kh2iJE5Hq0HsUAOjosmBORwehUDgImTjd.7ncouMBxFCyS', 'customer'),
(140, 'Mohammed Ammar', 'mohammed@gmail.com', '$2y$10$yAVDod2QRHIcBXJIptHNZuIHOpGQVhRhxdoBwf.FHfww.0S3iy.da', 'customer'),
(141, 'Salah Elsherif Elabd', 'salahelabd000@gmail.com', '$2y$10$cp/U9wcVSL2xx5xBt.cNAefMPdCZRv0AHkYopXIDLU0Jd/8exAzia', 'admin'),
(142, 'msagm', 'sss@gmail.com', '$2y$10$W7Ve8NnPn3VW1MydexA.me7X579QpI7tLiHVX5xVvOYF/xawXo6JC', 'customer'),
(143, 'salal', 'eee@gmail.com', '$2y$10$0yRzY.6niAK7FUIJEPjHDej5HOMYCYmaU.QSpRwKprWL/2vh3sGDO', 'customer'),
(144, 'salah', 'salahelabd0@gmail.com', '$2y$10$lhkk9OjPtPBr4lS/HXbTDOujZSM8Z4ddM9P7Zzr1jcOa8ooV9trQq', 'customer'),
(145, 'ammar', 'ammar@msa.edu.eg', '$2y$10$XaCJQwec4QEDYYG7XGGiIu12vVjVs7fJ5mIjIa3WnsiMGMOK2EUVG', 'customer');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
