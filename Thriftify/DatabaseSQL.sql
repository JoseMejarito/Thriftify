-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2024 at 02:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `database`;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `core` enum('1','2','3','4','5','6','7') NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `seller_name` varchar(255) DEFAULT NULL,
  `popularity_score` int(11) DEFAULT 0,
  `status` varchar(10) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `user_id`, `product_name`, `product_description`, `product_price`, `location`, `category`, `core`, `image_path`, `created_at`, `seller_name`, `popularity_score`, `status`) VALUES
(57, 22, 'The North Face Hyvent Windbreaker Jacket', 'Mens/ Large Size/ 24x27 dimension\r\nExcellent condition\r\nNo major flaws', 2000.00, 'santa rosa, laguna', 1, '4', 'public/1_6640b6a12608e.jpg', '2024-05-12 12:31:29', 'mark', 67, 'Available'),
(58, 22, 'Arc\'teryx Mens - Beta AR Gore-tex Jacket', 'Mens/ Medium Size/ 22x26 dimension\r\nExcellent condition\r\nNo major flaws', 5000.00, 'santa rosa, laguna', 1, '4', 'public/2_6640b6d510b90.jpg', '2024-05-12 12:32:21', 'mark', 15, 'Available'),
(59, 22, 'Vintage Nike Windbreaker Jacket', 'Mens/ Large-XL Size/ 24x28 dimension\r\nExcellent condition\r\nNo major flaws', 1000.00, 'santa rosa, laguna', 1, '4', 'public/3_6640b71c0f1a7.jpg', '2024-05-12 12:33:32', 'mark', 75, 'Available'),
(60, 22, 'Nike Tech Fleece (Dark Gray)', 'Mens/ Medium Size/ 22x24 dimension\r\nExcellent condition\r\nNo major flaws', 1000.00, 'santa rosa, laguna', 1, '4', 'public/4_6640b7a543f36.jpg', '2024-05-12 12:35:49', 'mark', 32, 'Available'),
(61, 22, 'The North Face Hyvent Pants', 'Mens/ One Size / Size 32-34\r\nExcellent condition\r\nNo major flaws', 1000.00, 'santa rosa, laguna', 1, '4', 'public/5_6640b7e3ca02d.jpg', '2024-05-12 12:36:51', 'mark', 33, 'Sold'),
(62, 23, 'Maison Margiela 10 NUMERIC LOGO TEE', 'Mens/ Medium Size/ 21x24 dimension\r\nExcellent condition\r\nNo major flaws', 1000.00, 'santa rosa, laguna', 1, '3', 'public/1_6640b8ae7a702.jpg', '2024-05-12 12:40:14', 'niel', 69, 'Available'),
(63, 23, 'Balenciaga Yellow Shirt', 'Mens/ Large Size/ 23x26 dimension\r\nExcellent condition\r\nNo major flaws', 500.00, 'santa rosa, laguna', 1, '3', 'public/2_6640b8d99f15c.jpg', '2024-05-12 12:40:57', 'niel', 48, 'Available'),
(64, 23, 'LOEWE ELN FACE PRINT T-SHIRT', 'Mens/ Medium Size/ 21x25 dimension\r\nExcellent condition\r\nNo major flaws', 1000.00, 'santa rosa, laguna', 1, '3', 'public/3_6640b906db953.jpg', '2024-05-12 12:41:42', 'niel', 35, 'Available'),
(65, 23, 'Lacoste Polo Shirt', 'Mens/ Large Size/ 22x27 dimension\r\nExcellent condition\r\nNo major flaws', 1500.00, 'santa rosa, laguna', 1, '3', 'public/4_6640b92eb6c4a.jpg', '2024-05-12 12:42:22', 'niel', 30, 'Available'),
(66, 23, 'CHRISTIAN DIOR MOTHERPEACE JUDGEMENT TEE', 'Mens/ Medium Size/ 21x24 dimension\r\nExcellent condition\r\nSemi Bacon Neckline', 500.00, 'santa rosa, laguna', 1, '3', 'public/5_6640b9615a28c.jpg', '2024-05-12 12:43:13', 'niel', 44, 'Available'),
(67, 24, 'Y2K Stussy Lightning', 'Dimensions: 20x27\r\nNo Issue', 4000.00, 'binan, laguna', 2, '6', 'public/1_6640b9d19a14f.jpg', '2024-05-12 12:45:05', 'CANTORNA', 31, 'Available'),
(68, 24, 'JNCO Y2k Era(Hoodie)', 'L for womens tag \r\n22x26\r\nNo Issue', 2000.00, 'binan, laguna', 2, '6', 'public/2_6640ba0a62038.jpg', '2024-05-12 12:46:02', 'CANTORNA', 23, 'Available'),
(69, 24, 'Y2k Ecko Unltd. Gold Graffiti Track Jacket', 'Condition: Excellent \r\nColor rate: 10/10\r\nIssue 2 pin holes', 500.00, 'binan, laguna', 2, '6', 'public/3_6640ba5fbf12f.jpg', '2024-05-12 12:47:27', 'CANTORNA', 23, 'Available'),
(70, 24, 'Bapesta Y2K Hoodie', 'Size S 19x22\r\nColor Rate 9/10\r\nNo Issue', 1000.00, 'binan, laguna', 2, '6', 'public/4_6640ba88e3c36.jpg', '2024-05-12 12:48:08', 'CANTORNA', 49, 'Available'),
(71, 24, 'Nike x Fear of God Double Hood', 'Size Medium 22X26\r\nBrand New Condition\r\nNo Issue', 2000.00, 'binan, laguna', 2, '6', 'public/5_6640babf06d4f.jpg', '2024-05-12 12:49:03', 'CANTORNA', 73, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `seller_id`, `message`, `timestamp`, `is_read`, `image_path`) VALUES
(1, 19, 18, 'pre', '2023-12-06 12:38:26', 0, NULL),
(2, 18, 19, 'yo', '2023-12-06 12:38:46', 0, NULL),
(3, 19, 18, 'pabili', '2023-12-06 12:39:07', 0, NULL),
(4, 19, 18, 'eto', '2023-12-06 12:39:28', 0, 'public/1.jpg'),
(5, 18, 19, 'ge', '2023-12-06 12:39:58', 0, NULL),
(6, 19, 16, 'hi', '2023-12-10 14:15:30', 0, NULL),
(7, 19, 16, 'Is this still available?', '2023-12-10 15:16:05', 0, 'public/Screenshot 2023-12-10 at 11.14.16 PM.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`) VALUES
(22, 'mark', 'mark@yahoo.com', '$2y$10$ckhtKW2Bojv17L./LxN9B.3qLkKE09r2ZSxMzcniFEcHWZl2abHxe'),
(23, 'niel', 'niel@yahoo.com', '$2y$10$JnZqQdtHcf4Z3C5lkJfR9O7CCUUqHSTiFNbc/sq7ccq1zMfm0xNKy'),
(24, 'CANTORNA', 'CANTORNA@YAHOO.COM', '$2y$10$cXcl7yXkjNEg1tkDIplgBO21pamhM2XbpKQK.HRKl7fg77dukM2jO');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `listing_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `listing_id` (`listing_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`listing_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
