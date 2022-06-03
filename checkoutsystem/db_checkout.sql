SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `db_checkout` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_checkout`;

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_price` varchar(50) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `total_price` varchar(100) NOT NULL,
  `product_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pmode` varchar(50) NOT NULL,
  `products` varchar(255) NOT NULL,
  `amount_paid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `address`, `pmode`, `products`, `amount_paid`) VALUES
(12, 'Петр', 'petr@mail.com', '89096549872', 'address', 'netbanking', 'Йогуртница Galaxy GL 2696 белый(1), Посудомоечная машина Oursson DW400 красный(1)', '26499'),
(13, 'Иван', 'ivan@test.ru', '89996589652', 'г.Москва, ул.Первая,д.2', 'cards', 'Миксер DEXP MX-700 белый(2), <br/>Термопот Aresa AR-4001 черный(1), <br/>Йогуртница Galaxy GL 2696 белый(1)', '10198');

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `product_qty` int(11) NOT NULL DEFAULT '1',
  `product_image` varchar(255) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code_2` (`product_code`),
  KEY `product_code` (`product_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product` (`id`, `product_name`, `product_price`, `product_qty`, `product_image`, `product_code`) VALUES
(1, 'Посудомоечная машина DEXP M9C7PD белый', '17799', 1, 'image/1.jpg', 'p1000'),
(2, 'Посудомоечная машина Oursson DW400 красный', '24999', 1, 'image/2.jpg', 'p1001'),
(3, 'Йогуртница Galaxy GL 2696 белый', '1500', 1, 'image/3.jpg', 'p1002'),
(4, 'Термопот Aresa AR-4001 черный', '2300', 1, 'image/4.jpg', 'p1003'),
(6, 'Миксер Centek CT-1117 белый', '899', 1, 'image/55.jpg', 'p1005'),
(7, 'Миксер DEXP MX-700 белый', '3199', 1, 'image/6.jpg', 'p1006');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
