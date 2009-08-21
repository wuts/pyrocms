-- phpMyAdmin SQL Dump
-- version 2.11.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2009 at 08:00 PM
-- Server version: 5.0.41
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pyrocms`
--

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `area` text NOT NULL,
  `active` enum('true','false') NOT NULL default 'false',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` VALUES(1, 'recent_news', '{"title":"Recent News","display":"all","category":"category-1","archive_year":"2008","archive_month":"03","article_limit":"2","show_intro":"false"}', 'sidebar', 'true');
INSERT INTO `widgets` VALUES(2, 'navigation', '{"title":"Navigation","group":"sidebar"}', 'sidebar', 'true');
