-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-06-20 17:18:00
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mysql`
--

-- --------------------------------------------------------

--
-- 表的结构 `shop_product_car`
--

CREATE TABLE IF NOT EXISTS `shop_product_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(255) NOT NULL,
  `if_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，1为是，2为否',
  `dealed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品列表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `shop_product_car`
--

INSERT INTO `shop_product_car` (`id`, `pro_id`, `if_show`, `dealed`) VALUES
(1, 1, 1, 0),
(2, 4, 1, 0),
(3, 6, 1, 0),
(4, 2, 1, 0),
(5, 3, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
