-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2022 at 03:43 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `authpass` varchar(200) DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ----------------------------------------------------------
-- Inserting data in `Products` table

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`) VALUES
(1, 'Canned Tuna', 'seafood', 'Premium Quality Fish. Imported from Thailand. Excellent source of Omega 3.', 195, 'tuna_fish.png'),
(2, 'Frozen Prawns', 'seafood', 'These prawns be used instantly to cook a variety of delicious dishes without going through the pain of cleaning and deveining them. These are seawater prawns that are peeled.', 320, 'prawns.png'),
(3, 'Crab claws', 'seafood', 'These prawns be used instantly to cook a variety of delicious dishes without going through the pain of cleaning and deveining them. These are seawater prawns that are peeled.', 350, 'crab_claw.png'),
(4, 'classic chocolate Ice-cream', 'icecream', 'Utterly delicious ice cream made from fresh milk available in a wide range of flavours and packs only in bigbasket.', 220, 'chocolate_icecream.png'),
(5, 'Mango Ice-cream', 'icecream', 'The colourful ice Cream with its scrumptious and unique flavours is sure to add different shades of dynamism to the lives of many children.', 40, 'mango_icecream.png'),
(6, 'Raspberry Icecream', 'icecream', 'Raspberry Flavoured Icecream', 35, 'raspberry.png'),
(7, 'Chicken', 'meat', 'Quality chicken Meat ', 309, 'chicken.png'),
(8, 'Mutton', 'meat', 'They have been expertly butchered by our meat technicians and turn soft and juicy when cooked, adding richness to your lip-smacking biryanis.', 249, 'mutton.png'),
(9, 'Apple', 'fruits', 'Best Quality Apples', 195, 'apple.png'),
(10, 'Banana', 'fruits', 'Best Quality Bananas', 45, 'banana.png'),
(11, 'Blue Grapes', 'fruits', 'Best Quality Grapes', 80, 'blue_grapes.png'),
(12, 'Orange', 'fruits', 'Best Quality Oranges', 89, 'orange.png'),
(13, 'Mango', 'fruits', 'Best Quality Mango', 78, 'mango.png'),
(14, 'Tomato', 'vegetables', 'Best Quality Tomato', 120, 'tomato.png'),
(15, 'Broccoli', 'vegetables', 'Best Quality Broccoli', 289, 'broccoli.png'),
(16, 'Cabbage', 'vegetables', 'Best Quality Cabbage', 109, 'cabbage.png'),
(17, 'Milk', 'dairy', 'Best Quality Milk to buy', 20, 'milk.png'),
(18, 'Butter', 'dairy', 'Best Quality Butter to buy', 23, 'butter.png'),
(19, 'Pepsi', 'softdrink', 'Cool yourself with Pepsi', 72, 'pepsi.png'),
(20, 'Mirinda', 'softdrink', 'Cool yourself with Mirinda', 68, 'mirinda.png'),
(21, 'Sprite', 'softdrink', 'Cool yourself with Sprite', 70, 'sprite.png'),
(22, 'Water', 'bottledwater', 'Mount Franklin', 10, 'water.png'),
(23, 'Blk.', 'bottledwater', 'Pure mineral water ', 432, 'blk.png'),
(24, 'Minute Maid', 'juice', 'Minute Maid Pulpy Orange', 25, 'minute_maid.png'),
(25, 'Fruite juice', 'juice', 'Best fruit juice', 35, 'fruitejuice.png');


-- -----------------------------------------------------------

-- Inserting data in `Users` table

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `authpass`) VALUES
(1, 'user', 'user1@gmail.com', '4dd4d811222717195c9b69ede42c0fb7', 'user', NULL),
(2, 'Har', '1by19is067@bmsit.in', '4dd4d811222717195c9b69ede42c0fb7', 'admin', 'nhqibazqutdqxedy'),
(3, 'Angela', 'angela19971114@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'admin', 'ueqzheukoluoqjdy');



--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
