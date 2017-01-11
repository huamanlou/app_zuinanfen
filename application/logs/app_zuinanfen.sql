-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 01 月 11 日 12:43
-- 服务器版本: 5.1.39
-- PHP 版本: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_zuinanfen`
--

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` varchar(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `userId` varchar(32) NOT NULL,
  `ctime` datetime NOT NULL,
  `desc` mediumtext NOT NULL,
  `abstract` text NOT NULL,
  `mtime` datetime NOT NULL,
  `pic` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `title`, `userId`, `ctime`, `desc`, `abstract`, `mtime`, `pic`, `status`) VALUES
('1484105953428084', 'aaaaa', '', '2017-01-11 11:39:13', '%3Cp%3E%0A%09%26nbsp%3B%20%26nbsp%3B%20%26nbsp%3B%20%26nbsp%3B%E8%BF%99%E9%87%8C%E5%86%99%E4%BD%A0%E7%9A%84%E5%88%9D%E5%A7%8B%E5%8C%96%E5%86%85%E5%AE%B9%0A%09%20%26nbsp%3B%26nbsp%3B%3C%2Fp%3E%3Cp%3E%3Cbr%2F%3E%3C%2Fp%3E%3Cp%3E%3Cimg%20src%3D%22http%3A%2F%2Fapp1.zuinanfen.com%2Fupload%2F20170111%2F14841059495549.png%22%2F%3E%26nbsp%3B%3C%2Fp%3E', 'bbbbbbb', '2017-01-11 11:39:13', '/upload/20170111/14841059433644.jpg', 0),
('1484106574412377', 'aaaaa', '', '2017-01-11 11:49:34', '%3Cp%3E%0A%09%26nbsp%3B%20%26nbsp%3B%20%26nbsp%3B%20%26nbsp%3B%E8%BF%99%E9%87%8C%E5%86%99%E4%BD%A0%E7%9A%84%E5%88%9D%E5%A7%8B%E5%8C%96%E5%86%85%E5%AE%B9%0A%09%20%26nbsp%3B%26nbsp%3B%3C%2Fp%3E%3Cp%3E%3Cbr%2F%3E%3C%2Fp%3E%3Cp%3E%3Cimg%20src%3D%22http%3A%2F%2Fapp1.zuinanfen.com%2Fupload%2F20170111%2F14841059495549.png%22%2F%3E%26nbsp%3B%3C%2Fp%3E', 'bbbbbbb', '2017-01-11 11:49:34', '/upload/20170111/14841059433644.jpg', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(32) NOT NULL COMMENT 'id',
  `openId` varchar(64) NOT NULL COMMENT '第三方平台id',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `platformId` tinyint(4) NOT NULL,
  `groupId` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `openId` (`openId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
