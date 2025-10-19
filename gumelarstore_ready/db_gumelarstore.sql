-- safe schema (IF NOT EXISTS)
CREATE DATABASE IF NOT EXISTS `gumelar_store_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `gumelar_store_db`;
CREATE TABLE IF NOT EXISTS `admins` (`id` int NOT NULL AUTO_INCREMENT, `username` varchar(100) NOT NULL, `password` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `categories` (`id` int NOT NULL AUTO_INCREMENT, `name` varchar(150) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `products` (`id` int NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL, `description` text, `price` decimal(10,2) DEFAULT '0.00', `image` varchar(255) DEFAULT NULL, `category_id` int DEFAULT NULL, `created_at` datetime DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `orders` (`id` int NOT NULL AUTO_INCREMENT, `user_id` int DEFAULT NULL, `customer_name` varchar(255), `phone` varchar(100), `address` text, `total` decimal(12,2) DEFAULT '0.00', `status` varchar(50) DEFAULT 'pending', `created_at` datetime DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `order_items` (`id` int NOT NULL AUTO_INCREMENT, `order_id` int NOT NULL, `product_id` int NOT NULL, `quantity` int DEFAULT 1, `price` decimal(10,2) DEFAULT '0.00', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `users` (`id` int NOT NULL AUTO_INCREMENT, `username` varchar(100) NOT NULL, `email` varchar(150) NOT NULL, `password` varchar(255) NOT NULL, `created_at` datetime DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `wishlist` (`id` int NOT NULL AUTO_INCREMENT, `user_id` int NOT NULL, `product_id` int NOT NULL, `created_at` datetime DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
