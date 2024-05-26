CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(30) NOT NULL,
  `img` varchar(255),
  `description` varchar(255),
  `price` DECIMAL(11,3),
  `is_trend` BOOLEAN,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ;


CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
);

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
);