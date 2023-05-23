CREATE DATABASE `arbuz_db`;

CREATE TABLE `Products` (
 `product_id` int(11) NOT NULL AUTO_INCREMENT,
 `product_name` varchar(150) NOT NULL,
 `price` int(11) NOT NULL,
 `is_available` tinyint(1) NOT NULL,
 PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Clients` (
 `client_id` int(11) NOT NULL AUTO_INCREMENT,
 `client_name` varchar(150) NOT NULL,
 `phone_number` varchar(15) NOT NULL,
 `address` varchar(255) NOT NULL,
 PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Orders` (
 `order_id` int(11) NOT NULL AUTO_INCREMENT,
 `client_id` int(11) NOT NULL,
 `datetime` datetime NOT NULL,
 `duration_weeks` int(11) NOT NULL,
 PRIMARY KEY (`order_id`),
 KEY `client_id` (`client_id`),
 CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `Clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Order_Items` (
 `item_id` int(11) NOT NULL AUTO_INCREMENT,
 `order_id` int(11) NOT NULL,
 `product_id` int(11) NOT NULL,
 `quantity` int(11) NOT NULL DEFAULT 1,
 PRIMARY KEY (`item_id`),
 KEY `order_id` (`order_id`),
 KEY `product_id` (`product_id`),
 CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;