-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-06-20 17:17:48
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
-- 表的结构 `shop_product`
--

CREATE TABLE IF NOT EXISTS `shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '产品名称',
  `short_title` varchar(200) NOT NULL DEFAULT '' COMMENT '短标题',
  `body_type` varchar(255) NOT NULL,
  `body_color` varchar(255) NOT NULL,
  `body_weight` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL COMMENT '商品的logo',
  `price` int(255) NOT NULL,
  `if_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，1为是，2为否',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品列表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `shop_product`
--

INSERT INTO `shop_product` (`id`, `name`, `short_title`, `body_type`, `body_color`, `body_weight`, `logo`, `price`, `if_show`) VALUES
(1, '狗狗之家-哈士奇', '哈士奇', '短毛', '黑白', '50', '/static/images/hashiqi.jpg', 10000, 1),
(2, '狗狗之家-藏獒', '藏獒', '短毛', '黑色', '50', '/static/images/zangao.jpg', 20000, 1),
(3, '狗狗之家-贵宾', '贵宾', '短毛', '白色', '10', '/static/images/guibin.jpg', 5000, 1),
(4, '猫之家-波斯猫', '波斯猫', '长毛', '白色', '10', '/static/images/bosimao.jpg', 5000, 1),
(5, '宠物之家-仓鼠', '老公公仓鼠', '迷你', '黄色', '1', '/static/images/cangshu.jpg', 50, 1),
(6, '猫之家-星罗猫', '星罗猫', '短毛', '白色', '20', '/static/images/xingluomao.jpg', 100, 1),
(7, '猫之家-加菲猫', '加菲猫', '中型', '灰色', '50', '/static/images/jiafei.jpg', 5600, 1),
(8, '宠物之家-金丝熊', '金丝熊', '小型', '黄色', '1', '/static/images/jinsixiong.jpg', 20, 1),
(9, '狗狗之家-吉娃娃', '吉娃娃', '小型', '白色', '30', '/static/images/jiwawa.jpg', 500, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
