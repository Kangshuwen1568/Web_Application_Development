-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 31, 2023 at 05:43 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shuwen`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`) VALUES
(1, 'Beverages', 'Soft drinks, coffees, teas, beers, and ales'),
(2, 'Condiments', 'Sweet and savory sauces, relishes, spreads, and seasonings'),
(3, 'Confections', 'Desserts, candies, and sweet breads'),
(4, 'Dairy Products', 'Cheeses'),
(5, 'Grains/Cereals', 'Breads, crackers, pasta, and cereal'),
(6, 'Meat/Poultry', 'Prepared meats'),
(7, 'Produce', 'Dried fruit and bean curd'),
(8, 'Seafood', 'Seaweed and fish');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

DROP TABLE IF EXISTS `contactus`;
CREATE TABLE IF NOT EXISTS `contactus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` int NOT NULL,
  `message` text NOT NULL,
  `email` varchar(40) NOT NULL,
  `phonenumber` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(40) NOT NULL,
  `registration` datetime NOT NULL,
  `account_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`, `firstname`, `lastname`, `image`, `gender`, `date_of_birth`, `email`, `registration`, `account_status`) VALUES
(1, 'Vivian_tan', '$2y$10$fvT9QceaI0eyESCAIYFL..1.VdrfpelcDDSecZw1Fy9Jg9VEPxgb.', 'an ling', 'tan', 'user.png', 'female', '2002-02-24', 'vivian@gmail.com', '2023-08-24 22:50:40', 'inactive'),
(2, 'Elaine_tang', '$2y$10$P8WnqRmrZq/AoovV7igwE.S.hVoWkt1n7IQsgllKapdm8hl6H82h6', 'xin yi', 'tang', 'user.png', 'female', '2011-03-22', 'elaine@gmail.com', '2023-08-24 23:00:46', 'active'),
(3, 'Jason_yap', '$2y$10$8mxhKRY13D.w8XLjnnvROuJAhMp1bHJgPjeDi4oqXRAUI6sVOKzUi', 'cheng pin', 'yap', '9934066cead781411c1da7512639b6035dccf6e1-jaimage.jpg', 'male', '1996-03-27', 'jason@gmail.com', '2023-08-27 10:21:16', 'active'),
(4, 'Jack_wong', '$2y$10$3LUmE5QqEYDQiofO.gUWiuU0Ym6IMEDGGz8H1PjHHhd9R2THbEQty', 'xiao ming', 'wong', '1015a9f0d1f4068a26b42cb81a5073588572a0d0-jackprofile.jpg', 'male', '2017-03-27', 'jack@gmail.com', '2023-08-27 12:08:18', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `order_detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 2, 1),
(2, 1, 7, 2),
(3, 2, 8, 4),
(4, 2, 3, 2),
(5, 2, 1, 1),
(6, 3, 8, 4),
(15, 4, 3, 3),
(16, 4, 7, 2),
(17, 4, 2, 2),
(18, 6, 2, 4),
(20, 7, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_date` date NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`order_id`, `customer_id`, `order_date`) VALUES
(1, 1, '2023-08-24'),
(2, 2, '2023-08-24'),
(3, 3, '2023-08-27'),
(4, 4, '2023-08-27'),
(6, 4, '2023-08-30'),
(7, 4, '2023-08-30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category_id` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `promotion_price` int NOT NULL,
  `manufacture_date` date NOT NULL,
  `expired_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created`, `modified`, `promotion_price`, `manufacture_date`, `expired_date`) VALUES
(1, 'Cola-cola', 'Coca-Cola is a carbonated, sweetened soft drink and is the world\'s best-selling soda. ', 12, '20ace714bd333e19c786bbbe9734fe55bc1051c3-cola-cola.jpg', 1, '2023-07-22 17:29:28', '2023-07-22 09:29:28', 5, '2023-07-01', '2024-01-22'),
(2, 'Seaweed', 'Seaweed is a plant belonging to the genus Porphyra of the phylum Rhodophyta. ', 10, '5a70cea59de43eb8245de64b29b8afc3b109c177-seaweed.jpg', 8, '2023-07-22 17:39:43', '2023-07-22 09:40:54', 8, '2023-01-26', '2025-10-22'),
(3, 'Chili pepper', 'Chili pepper are varieties of the berry-fruit of plants from the genus Capsicum.', 7, 'a86ac56aedc4fe7746ef2b53f67211e0a412be65-chilli_pepper.jpg', 7, '2023-07-23 17:25:40', '2023-07-23 09:26:25', 5, '2022-03-23', '2025-12-23'),
(4, 'Pepsi', 'Pepsi is a carbonated soft drink manufactured by PepsiCo.', 10, '3736d040c74ec7117e4a58e6dce860e55eeee30e-pepsi.jpg', 1, '2023-08-19 12:40:13', '2023-08-19 04:40:13', 5, '2023-08-19', '2025-10-19'),
(5, 'Candy', 'Candy is a confection that features sugar as a principal ingredient.', 5, '8ce0e384e1ecf2f60a154d03a98c304cfc20bf48-candy.jpg', 3, '2023-08-19 16:17:55', '2023-08-19 08:17:55', 3, '2023-08-18', '2024-12-19'),
(6, 'Lolipop', 'A lollipop is a type of sugar candy.', 5, 'b1f28e0e5e6ec5146556ce56461fef344ef82b84-lolipop.jpg', 3, '2023-08-19 17:20:57', '2023-08-19 11:59:43', 3, '2023-08-19', '2024-10-19'),
(7, '100plus', '100plus is a brand of isotonic sports drink.', 3, 'product_image_coming_soon.jpg', 1, '2023-08-19 17:47:54', '2023-08-19 09:47:54', 0, '2023-08-19', '2023-10-19'),
(8, 'Mineral Water', 'Mineral Water is also known as spring water because it comes from natural springs.', 2, 'product_image_coming_soon.jpg', 1, '2023-08-21 16:25:19', '2023-08-21 08:25:19', 0, '2023-08-21', '2026-11-21');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_summary` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_summary`
--
ALTER TABLE `order_summary`
  ADD CONSTRAINT `order_summary_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
