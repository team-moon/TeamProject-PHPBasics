CREATE DATABASE `message_board_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'HTML5'),
(2, 'php'),
(3, 'CSS3'),
(4, 'Java');

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(255) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` varchar(250) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
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
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `category_id`, `author_id`, `date_published`, `title`, `body`) VALUES
(26, 2, 3, '2013-10-07 21:46:30', 'in_array()', 'Checks if a value exists in an array.\nReturns TRUE if needle is found in the array, FALSE otherwise.'),
(27, 2, 3, '2013-10-07 21:51:09', 'array_diff()', 'Computes the difference of arrays.\nReturns an array containing all the entries from array1 that are not present in any of the other arrays.'),
(28, 1, 1, '2013-10-07 22:20:19', 'What is HTML5?', 'HTML5 is the new standard for HTML.\r\nThe previous version of HTML, HTML 4.01, came in 1999. The web has changed a lot since then.'),
(29, 1, 1, '2013-10-07 22:21:03', 'Browser Support for HTML5', 'HTML5 is not yet an official standard, and no browsers have full HTML5 support.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `access_lvl` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `passwd`, `access_lvl`) VALUES
(1, 'Atanas', 'Atanas', 3),
(2, 'Martin', 'Martin', 2),
(3, 'Stamat', 'Stamat', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
