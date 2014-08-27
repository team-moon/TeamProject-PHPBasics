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
-- ����� �� ������� �� ������� `access_levels`
--

INSERT INTO `access_levels` (`access_lvl`, `access_name`) VALUES
(1, 'User'),
(2, 'Moderator'),
(3, 'Administrator');

-- --------------------------------------------------------

--
-- ��������� �� ������� `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- ����� �� ������� �� ������� `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Uncategorized'),
(2, 'PHP'),
(3, 'CSS3'),
(4, 'Java'),
(14, 'SPAM'),
(15, 'HTML5');

-- --------------------------------------------------------

--
-- ��������� �� ������� `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(255) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` text NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- ����� �� ������� �� ������� `comments`
--

INSERT INTO `comments` (`comment_id`, `message_id`, `user_id`, `date`, `comment_content`) VALUES
(4, 27, '1', '2014-08-23 15:27:44', 'testttt!');

-- --------------------------------------------------------

--
-- ��������� �� ������� `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_published` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `tags` varchar(250) NOT NULL,
  `views_count` int(11) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- ����� �� ������� �� ������� `messages`
--

INSERT INTO `messages` (`message_id`, `category_id`, `author_id`, `date_published`, `title`, `body`, `tags`, `views_count`) VALUES
(26, 2, 3, '2013-10-08 22:46:30', 'in_array()', 'Checks if given value exists in an array.\r\nReturns TRUE if needle is found in the array, FALSE otherwise.', 'php, array', 1),
(27, 2, 3, '2014-08-07 21:51:09', 'array_dif()', 'Computers the difference of arrays.\r\nReturns an array containing all the entries from array1 that are not present in any of the other arrays.', 'tag', 5),
(28, 15, 1, '2013-10-07 22:20:19', 'What is HTML5?', 'HTML5 is the new standard for HTML.\r\nThe previous version of HTML, HTML 4.01, came in 1999. The web has changed a lot since then.', 'html5', 2),
(29, 15, 1, '2013-10-07 22:21:03', 'Browser Support for HTML5', 'HTML5 is not yet an official standard, and no browsers have full HTML5 support.', 'html5', 2),
(31, 14, 1, '2014-08-23 17:49:14', 'sample new', 'testinggggggg', 'test, tags', 29);

-- --------------------------------------------------------

--
-- ��������� �� ������� `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL DEFAULT '0',
  `access_lvl` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- ����� �� ������� �� ������� `users`
--

INSERT INTO `users` (`user_id`, `name`, `passwd`, `activity`, `access_lvl`) VALUES
(1, 'Atanas', 'f2907bdf21aecc47aed8af7c5566dceb', '1', 3),
(2, 'Martin', '81d6f316d169150d0e8733866c38684d', '0', 2),
(3, 'Stamat', '748af8e48e7ddd5e0baaf7c1a9810892', '0', 1),
(22, 'testuu', 'd21b37dfb136abb311f15ed7be504167', '0', 1),
(23, 'test4o', '3895f0772bd2aefaf62cd39bc36beb16', '0', 1);