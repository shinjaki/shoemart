-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 01:58 PM
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
-- Database: `shoemart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `size_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(58, 3, 7, 6, 1, '2025-01-24 12:10:51', '2025-01-24 12:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Nike', '2024-12-15 13:58:00', '2025-01-18 14:09:04'),
(2, 'Adidas', '2024-12-15 13:58:10', '2025-01-18 14:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_id` int(11) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`payment_id`, `method_name`, `created_at`, `updated_at`) VALUES
(1, 'Cash', '2024-12-15 18:35:11', '2024-12-15 18:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(4, 1, 'Nike G.T. Hustle 3 Blueprint EP', 'Men\'s Shoes', 10295.00, 50, 'uploads/products/678bcbf0e566e.jpg', '2024-12-16 11:35:28', '2025-01-24 11:42:07'),
(5, 1, 'KD17 EP ASW', 'Men\'s Shoes', 9095.00, 25, 'uploads/products/678bcbc40f5b0.png', '2024-12-16 11:50:23', '2025-01-24 11:46:20'),
(6, 1, 'Air Jordan 1 Low OG', 'Shoes', 7895.00, 29, 'uploads/products/678bcb92b83a0.png', '2024-12-16 11:51:17', '2025-01-24 11:46:20'),
(7, 1, 'Nike Air VaporMax Plus', 'Men\'s Shoes', 9445.00, 10, 'uploads/products/678bcb549bf86.png', '2024-12-16 11:51:58', '2025-01-24 11:46:20'),
(8, 1, 'Nike Dunk Low Retro SE Leather/Suede', 'Men\'s Shoes', 6895.00, 50, 'uploads/products/678bcb13d8e72.png', '2024-12-16 11:52:25', '2025-01-24 11:46:20'),
(9, 1, 'Nike C1TY', 'Men\'s Shoes', 5495.00, 50, 'uploads/products/678bcae656d65.png', '2024-12-16 11:52:54', '2025-01-24 11:46:20'),
(10, 1, 'Nike P-6000', 'Shoes', 4995.00, 29, 'uploads/products/678bcabe6f6b2.png', '2024-12-16 11:53:28', '2025-01-24 11:46:20'),
(11, 1, 'Nike Dunk Low Retro', 'Men\'s Shoes', 7295.00, 15, 'uploads/products/678bca8a52ed7.png', '2024-12-16 12:01:07', '2025-01-24 11:46:20'),
(12, 1, 'Nike Air Force 107', 'Men\'s Shoes', 7595.00, 55, 'uploads/products/678bca5e2b23e.png', '2024-12-16 12:01:34', '2025-01-24 11:46:20'),
(13, 2, 'SL 72 OG Shoes', 'Originals', 4800.00, 5, 'uploads/products/678bc9f1824e9.png', '2024-12-16 12:05:24', '2025-01-24 11:46:20'),
(14, 2, 'Samba OG Shoes', 'Originals', 4080.00, 50, 'uploads/products/678bc991c4733.png', '2024-12-16 12:06:29', '2025-01-24 11:46:20'),
(15, 2, 'Harden Volume 8 Shoes', 'Basketball Shoes', 7600.00, 15, 'uploads/products/678bc931902fc.png', '2024-12-16 12:08:25', '2025-01-24 11:46:20'),
(16, 2, 'Rod Laver Shoes', 'Mens Originals', 3290.00, 10, 'uploads/products/678bc8dbbe422.png', '2024-12-16 12:09:53', '2025-01-24 11:46:20'),
(17, 2, 'Campus 00s Shoes', 'Originals', 4400.00, 50, 'uploads/products/678bc8843be9a.png', '2024-12-16 12:11:17', '2025-01-24 11:46:20'),
(18, 2, 'UBounce DNA Shoes', 'Men Sportswear', 3850.00, 27, 'uploads/products/678bc81d5f64e.png', '2024-12-16 12:13:39', '2025-01-24 11:46:20'),
(19, 2, 'Adiform Superstar Shoes', 'Originals', 1800.00, 100, 'uploads/products/678bc7d58ae6f.png', '2024-12-21 01:25:06', '2025-01-24 11:46:20'),
(20, 2, 'Ultimashow 2.0 Shoes', 'Men Sportswear', 1750.00, 20, 'uploads/products/678bbe6f358bb.png', '2024-12-21 01:36:56', '2025-01-24 11:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size`) VALUES
(1, 35.00),
(2, 36.00),
(3, 37.00),
(4, 38.00),
(5, 39.00),
(6, 40.00),
(7, 41.00),
(8, 42.00),
(9, 43.00),
(10, 44.00),
(11, 45.00),
(12, 46.00),
(13, 47.00),
(14, 48.00),
(15, 49.00),
(16, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `total_amount`, `payment_id`, `status`, `transaction_date`) VALUES
(13, 3, 1170.00, 1, 'Completed', '2024-12-21 02:21:22'),
(14, 3, 570.00, 1, 'Pending', '2025-01-17 21:27:01'),
(15, 3, 570.00, 1, 'Pending', '2025-01-17 21:29:14'),
(16, 3, 570.00, 1, 'Pending', '2025-01-17 21:31:20'),
(17, 3, 300.00, 1, 'Pending', '2025-01-17 21:31:47'),
(18, 3, 150.00, 1, 'Pending', '2025-01-17 21:39:46'),
(19, 3, 150.00, 1, 'Pending', '2025-01-18 06:26:23'),
(20, 3, 120.00, 1, 'Pending', '2025-01-18 06:29:49'),
(21, 3, 180.00, 1, 'Pending', '2025-01-18 06:30:16'),
(22, 3, 7895.00, 1, 'Completed', '2025-01-18 09:01:02'),
(23, 3, 10295.00, 1, 'Completed', '2025-01-18 09:01:19'),
(24, 3, 15290.00, 1, 'Cancelled', '2025-01-18 09:13:11'),
(25, 3, 11890.00, 1, 'Pending', '2025-01-18 09:27:27'),
(26, 3, 27485.00, 1, 'Pending', '2025-01-24 04:55:30'),
(27, 3, 4080.00, 1, 'Pending', '2025-01-24 05:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `transaction_item_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`transaction_item_id`, `transaction_id`, `product_id`, `size_id`, `quantity`, `price`) VALUES
(29, 23, 4, 6, 1, 10295.00),
(30, 24, 4, 7, 1, 10295.00),
(31, 24, 10, 12, 1, 4995.00),
(32, 25, 8, 6, 1, 6895.00),
(33, 25, 10, 6, 1, 4995.00),
(37, 27, 14, 11, 1, 4080.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `contact`, `address`, `email`, `password`, `account_type`, `created_at`, `updated_at`) VALUES
(3, 'Paul', 'Wagan', '09123456789', '123 Main Street, City', 'paulwagan123@gmail.com', '$2y$10$cybraq8uP7M1qulLpbzKXuyI67TxN0Oxdb4LYqyvu/udtRt4JzQD2', 2, '2024-12-15 11:31:36', '2025-01-24 12:09:25'),
(4, 'Rylon', 'Morales', '09123456789', 'Balintawak, Lipa City', 'rylon123@gmail.com', '$2y$10$OprHxo/y0E./UszNPnzuSOFh3tbZtvY1uoViq8L5FdWnVd9vDlpDG', 1, '2024-12-15 11:41:13', '2025-01-24 12:10:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`transaction_item_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_size_id` (`size_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `transaction_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `payment_method` (`payment_id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `fk_size_id` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
