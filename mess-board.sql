-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2014 at 05:41 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `message_board_db`
--
CREATE DATABASE IF NOT EXISTS `message_board_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `message_board_db`;

-- --------------------------------------------------------

--
-- Table structure for table `access_levels`
--

CREATE TABLE IF NOT EXISTS `access_levels` (
  `access_lvl` tinyint(4) NOT NULL AUTO_INCREMENT,
  `access_name` varchar(50) NOT NULL,
  PRIMARY KEY (`access_lvl`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `access_levels`
--

INSERT INTO `access_levels` (`access_lvl`, `access_name`) VALUES
(1, 'User'),
(2, 'Moderator'),
(3, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'uncategorized'),
(2, 'php'),
(3, 'CSS3'),
(4, 'Java'),
(14, 'javascript');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(255) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` varchar(250) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `message_id`, `user_id`, `date`, `comment_content`) VALUES
(5, 29, '1', '2014-08-23 20:06:44', 'Test administration of comment');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_published` datetime NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(250) NOT NULL,
  `tags` varchar(250) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `category_id`, `author_id`, `date_published`, `title`, `body`, `tags`) VALUES
(26, 2, 3, '2013-10-07 23:46:32', 'in_array()', 'Checks if a value exists in an array.\r\nReturns TRUE if needle is found in the array, FALSE otherwise.', 'array'),
(27, 2, 3, '2013-10-07 21:51:09', 'array_diff()', 'Computes the difference of arrays.\nReturns an array containing all the entries from array1 that are not present in any of the other arrays.', ''),
(28, 1, 1, '2013-10-07 22:20:19', 'What is HTML5?', 'HTML5 is the new standard for HTML.\r\nThe previous version of HTML, HTML 4.01, came in 1999. The web has changed a lot since then.', ''),
(29, 1, 1, '2013-10-07 22:21:03', 'Browser Support for HTML5', 'HTML5 is not yet an official standard, and no browsers have full HTML5 support.', ''),
(31, 4, 1, '2014-08-23 18:11:01', 'Java test', 'Test java post', 'java, main');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `access_lvl` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `passwd`, `activity`, `access_lvl`) VALUES
(1, 'Atanas', 'f2907bdf21aecc47aed8af7c5566dceb', '2', 3),
(2, 'Martin', '81d6f316d169150d0e8733866c38684d', '', 2),
(3, 'Stamat', '748af8e48e7ddd5e0baaf7c1a9810892', '', 1);
