-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 05, 2013 at 09:53 AM
-- Server version: 5.0.96-community
-- PHP Version: 5.2.6

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a98647sb_linker`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(3) NOT NULL auto_increment,
  `cat_desc` varchar(30) NOT NULL,
  `linker_id` int(5) NOT NULL,
  PRIMARY KEY  (`cat_id`),
  UNIQUE KEY `cat_id` (`cat_id`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `linker`
--

DROP TABLE IF EXISTS `linker`;
CREATE TABLE IF NOT EXISTS `linker` (
  `linker_id` int(5) NOT NULL auto_increment,
  `linker_title` varchar(30) NOT NULL,
  `user_id` int(5) NOT NULL,
  PRIMARY KEY  (`linker_id`),
  UNIQUE KEY `linker_id` (`linker_id`)
) TYPE=MyISAM  AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `link_id` int(5) NOT NULL auto_increment,
  `cat_id` int(3) NOT NULL,
  `link_title` varchar(30) NOT NULL,
  `link_desc` varchar(50) default NULL,
  `link_url` varchar(200) NOT NULL,
  `link_target` int(2) default NULL,
  `linker_id` int(5) NOT NULL,
  PRIMARY KEY  (`link_id`),
  UNIQUE KEY `link_id` (`link_id`)
) TYPE=MyISAM  AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `sys_targets`
--

DROP TABLE IF EXISTS `sys_targets`;
CREATE TABLE IF NOT EXISTS `sys_targets` (
  `target_id` int(3) NOT NULL auto_increment,
  `target_desc` varchar(30) NOT NULL,
  `target_text` varchar(10) NOT NULL,
  PRIMARY KEY  (`target_id`),
  UNIQUE KEY `target_id` (`target_id`,`target_text`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(5) NOT NULL auto_increment,
  `user_name` varchar(15) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_key` varchar(20) NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_id` (`user_id`,`user_email`)
) TYPE=MyISAM  AUTO_INCREMENT=7 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
