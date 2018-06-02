-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2018 at 07:27 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practice`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `id` int(2) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_name` varchar(65) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(60) NOT NULL,
  `state` varchar(5) NOT NULL,
  `description` varchar(500) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `logo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `company_name`, `address`, `city`, `state`, `description`, `picture_name`, `facebook_link`, `twitter_link`, `instagram_link`, `logo_name`) VALUES
(1, 'Mark', 'Cangelosi', '1234567890', 'twincitywatersports@gmail.com', '$2y$11$.Z5J3YTA78CNAHMD7fFiBu./IGmerZnv0uNQBYuA1DOoJ0SfOCGn.', 'Twin City Watersports Inc.', '407 E Cypress St', 'Normal', 'IL', 'Introduction of yourself.', 'HkuAreTcYzuDk9wr.jpg', '', '', '', 'zet7dAWPf5hbvgzp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `blog_url` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_description` text NOT NULL,
  `blog_content` text NOT NULL,
  `date_published` int(11) NOT NULL,
  `author` varchar(65) NOT NULL,
  `video_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `blog_url`, `blog_title`, `blog_description`, `blog_content`, `date_published`, `author`, `video_name`, `status`) VALUES
(7, 'New-Blog', 'New Blog', 'blah blah blah', 'blah blah blah blah blah', 1522904400, 'Suguru', 'a4Ny7vjVHurMr4gw.mp4', 1),
(8, 'Blog-2', 'Blog 2', 'Blogs are everywhere! This can be both wonderful and overwhelming. If you have an interest in a topic, all you have to do is search for that topic plus the word “blog,” and you’re likely to find some excellent blogs out there. Below, you’ll find sample blogs that cover topics like food, education, nursing, and video games. These are just four samples but will give you an opportunity to see how blogs can vary in theme, style, scope, and how entries can vary in length.\r\n\r\nThere is no limit to the topics you’ll find covered in blogs. If you’re working to create your own blog, do a little research on other blogs on that topic. Think about a way your blog can be different!', 'Blogs are everywhere! This can be both wonderful and overwhelming. If you have an interest in a topic, all you have to do is search for that topic plus the word “blog,” and you’re likely to find some excellent blogs out there. Below, you’ll find sample blogs that cover topics like food, education, nursing, and video games. These are just four samples but will give you an opportunity to see how blogs can vary in theme, style, scope, and how entries can vary in length.\r\n\r\nThere is no limit to the topics you’ll find covered in blogs. If you’re working to create your own blog, do a little research on other blogs on that topic. Think about a way your blog can be different!', 1523336400, 'Suguru', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog_pics`
--

CREATE TABLE `blog_pics` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_pics`
--

INSERT INTO `blog_pics` (`id`, `blog_id`, `picture_name`, `priority`) VALUES
(13, 7, 'yUNvTcWspMWxDG9H.jpg', 1),
(14, 8, 'H3YeB3KGefXThe3w.jpg', 1),
(15, 8, 'D7vsV64wQNBmRHpd.jpg', 2),
(16, 7, 'puFzD9aMFX4rB4GT.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `blog_videos`
--

CREATE TABLE `blog_videos` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `video_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `boat_pics`
--

CREATE TABLE `boat_pics` (
  `id` int(11) NOT NULL,
  `boat_rental_id` int(11) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boat_pics`
--

INSERT INTO `boat_pics` (`id`, `boat_rental_id`, `picture_name`, `priority`) VALUES
(1, 3, 'F2W5mgJJAfnJHeYD.jpg', 1),
(2, 5, 'CQVxJgqCSwjH3kzx.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `boat_rental`
--

CREATE TABLE `boat_rental` (
  `id` int(11) NOT NULL,
  `boat_name` varchar(255) NOT NULL,
  `boat_description` varchar(255) NOT NULL,
  `boat_capacity` varchar(255) NOT NULL,
  `year_made` varchar(255) NOT NULL,
  `boat_rental_fee` decimal(7,2) NOT NULL,
  `boat_url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `make` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boat_rental`
--

INSERT INTO `boat_rental` (`id`, `boat_name`, `boat_description`, `boat_capacity`, `year_made`, `boat_rental_fee`, `boat_url`, `status`, `make`) VALUES
(3, 'My Boat', 'A nice boat', '21', '2018', '21.00', '123bBrWHd', 1, 'Boat Maker'),
(5, 'Boat 2', '234', '23', '32', '33.00', '123ZBhQPK', 1, 'Make'),
(6, 'New boat', 'Desc', '20', '2018', '20.00', 'New-boatkVSmYu', 1, 'Make');

-- --------------------------------------------------------

--
-- Table structure for table `boat_rental_basket`
--

CREATE TABLE `boat_rental_basket` (
  `id` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `boat_name` varchar(255) NOT NULL,
  `boat_fee` decimal(7,2) NOT NULL,
  `boat_id` int(11) NOT NULL,
  `booking_start_date` int(11) NOT NULL,
  `booking_end_date` int(11) NOT NULL,
  `hours` int(11) DEFAULT NULL,
  `date_added` int(11) NOT NULL,
  `shopper_id` int(11) NOT NULL,
  `ip_address` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boat_rental_basket`
--

INSERT INTO `boat_rental_basket` (`id`, `session_id`, `boat_name`, `boat_fee`, `boat_id`, `booking_start_date`, `booking_end_date`, `hours`, `date_added`, `shopper_id`, `ip_address`) VALUES
(2, '124e3cc6ff32226da227a54d9d00209adc6568eb', 'Boat 2', '66.00', 5, 1524888000, 1524895200, NULL, 1525031737, 0, '::1'),
(3, 'ccfce9b40f148e9094c29b1f716adeb1f25e96fd', 'Boat 2', '66.00', 5, 1524888000, 1524895200, NULL, 1525032288, 0, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `boat_rental_schedules`
--

CREATE TABLE `boat_rental_schedules` (
  `id` int(11) NOT NULL,
  `boat_rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `boat_start_date` int(8) NOT NULL,
  `boat_end_date` int(8) NOT NULL,
  `session_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boat_rental_schedules`
--

INSERT INTO `boat_rental_schedules` (`id`, `boat_rental_id`, `user_id`, `boat_start_date`, `boat_end_date`, `session_id`) VALUES
(10, 3, 7, 1524924000, 1524931200, ''),
(11, 3, 7, 1524902400, 1524909600, ''),
(12, 3, 7, 1524916800, 1524924000, '');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `picture_name`, `priority`) VALUES
(7, 'Sru77Xzxa6WeNZRM.jpg', 1),
(8, 'VrHqc2uhud78uePH.jpg', 2),
(9, 'wCEyMPfaKXy2yw8e.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('c279d4feb80701ea8ee13a98498cb671651da162', '::1', 1527960389, 0x5f5f63695f6c6173745f726567656e65726174657c693a313532373935393936363b69735f61646d696e7c733a313a2231223b);

-- --------------------------------------------------------

--
-- Table structure for table `homepage_blocks`
--

CREATE TABLE `homepage_blocks` (
  `id` int(11) NOT NULL,
  `block_title` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `homepage_blocks`
--

INSERT INTO `homepage_blocks` (`id`, `block_title`, `priority`) VALUES
(2, 'Half price sale for a used boat', 2);

-- --------------------------------------------------------

--
-- Table structure for table `item_pics`
--

CREATE TABLE `item_pics` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pics`
--

INSERT INTO `item_pics` (`id`, `item_id`, `picture_name`, `priority`) VALUES
(1, 32, 'ZufNeQfpgkk2Q5T8.jpg', 1),
(5, 33, 'pSXCGTkHzpSSuvwD.jpg', 3),
(6, 33, '8C6B3DBFy7WRNCsE.jpg', 2),
(8, 33, 'nCUzjuGHcbFQGwyV.jpg', 1),
(9, 36, 'DKD6aQ9fMy6ZdBJy.jpg', 1),
(10, 36, 'U7bhpYNFbGRWq72x.jpg', 2),
(11, 37, 'P3kttdmasuYRX5cv.jpg', 1),
(12, 37, 'svZDcEDssCNwGcDM.jpg', 2),
(13, 38, '8WqW9bgwJpyknw5N.jpg', 1),
(14, 39, 'xGXMVZSrqUw4j7Dn.jpg', 1),
(16, 41, 'a5DHMVDNubm5wrkW.jpg', 1),
(17, 40, 'uuyXsUuNVGJdeXfV.jpg', 1),
(18, 42, 'KJC6nYMpwTvNt6mM.jpg', 1),
(19, 43, 'SZXtfHBQYpKhPcG4.jpg', 1),
(22, 49, 'wvZeRXwJyPSYqXm5.jpg', 1),
(23, 51, 'r9YkaGCz2zmtdwcD.jpg', 1),
(24, 50, 'xdj9yPT5zpvP6U8G.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `lesson_description` varchar(255) NOT NULL,
  `lesson_url` varchar(255) NOT NULL,
  `lesson_capacity` int(3) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `lesson_fee` decimal(7,2) NOT NULL,
  `status` int(1) NOT NULL,
  `date_made` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `lesson_name`, `lesson_description`, `lesson_url`, `lesson_capacity`, `address`, `city`, `state`, `lesson_fee`, `status`, `date_made`) VALUES
(6, 'new lesson', 'new lesson', 'new-lessonNgFgrB', 20, 'Here', 'Normal', 'IL', '0.01', 1, 1525128554);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_basket`
--

CREATE TABLE `lesson_basket` (
  `id` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `lesson_fee` decimal(7,2) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `lesson_start_date` int(11) NOT NULL,
  `lesson_end_date` int(11) NOT NULL,
  `booking_qty` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  `shopper_id` int(11) NOT NULL,
  `ip_address` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson_basket`
--

INSERT INTO `lesson_basket` (`id`, `session_id`, `lesson_name`, `lesson_fee`, `lesson_id`, `schedule_id`, `lesson_start_date`, `lesson_end_date`, `booking_qty`, `date_added`, `shopper_id`, `ip_address`) VALUES
(1, '8bf07508e6e39ea93f7f434362543e82bdfd216e', 'Lesson 1', '50.00', 4, 10, 1524574800, 1524582000, 4, 1524522060, 0, '::1'),
(3, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 10, 1525093200, 1525100400, 1, 1524670113, 0, '::1'),
(4, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 10, 1525093200, 1525100400, 1, 1524670148, 0, '::1'),
(5, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 10, 1525093200, 1525100400, 1, 1524670162, 0, '::1'),
(6, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 16, 1524921840, 1524921840, 1, 1524670180, 0, '::1'),
(7, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 16, 1524921840, 1524921840, 1, 1524670264, 0, '::1'),
(8, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 16, 1524921840, 1524921840, 1, 1524670361, 0, '::1'),
(9, 'a75c60dca7a61ac538bb2a876fb81ac4c5aa7bb1', 'Lesson 1', '50.00', 4, 16, 1524921840, 1524921840, 1, 1524670411, 0, '::1'),
(10, '93b99adba0920c87e43f4c5c2527e8be2cf44024', 'Lesson 1', '50.00', 4, 19, 1525440240, 1525440240, 1, 1524670602, 0, '::1'),
(11, '8c153e6f1cad295c87fc0e4ecae8b39594a38e61', 'Lesson 1', '50.00', 4, 10, 1525093200, 1525100400, 1, 1524673417, 0, '::1'),
(14, 'a8e57e40e709b50fd05ba16bc0a745e9e39e7c15', 'Lesson 1', '50.00', 4, 10, 1525093200, 1525100400, 1, 1525018317, 0, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_bookings`
--

CREATE TABLE `lesson_bookings` (
  `id` int(11) NOT NULL,
  `lesson_schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_booking_qty` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson_bookings`
--

INSERT INTO `lesson_bookings` (`id`, `lesson_schedule_id`, `user_id`, `lesson_booking_qty`, `session_id`) VALUES
(1, 10, 7, 3, ''),
(2, 11, 7, 3, ''),
(3, 12, 7, 3, ''),
(4, 13, 7, 3, ''),
(5, 1, 7, 1, 'c535644ce8a0fa260c9b5984bbfe4f52c7a8bb6c');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_pics`
--

CREATE TABLE `lesson_pics` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `picture_name` varchar(60) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson_pics`
--

INSERT INTO `lesson_pics` (`id`, `lesson_id`, `picture_name`, `priority`) VALUES
(1, 2, '7ua6ghG9BJqe42Gj.jpg', 1),
(2, 2, 'sVq57E4PwBsfDgAj.jpg', 2),
(3, 3, 'UrWy7hDVYXT84fA3.jpg', 1),
(4, 3, 'BBGZ2yhhTpRwuzzS.jpg', 2),
(5, 4, 'J2aBHYAZXEXHqHqB.jpg', 1),
(6, 4, 'z9cRbKsfUd2ffqPV.jpg', 2),
(7, 6, 'yuYW5kd6CSDXyh27.jpg', 1),
(10, 6, 'hkuQC7euTzF4JpbV.jpg', 2),
(11, 6, 'VgAXuzG48GXJ7r75.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_schedules`
--

CREATE TABLE `lesson_schedules` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `lesson_start_date` int(11) NOT NULL,
  `lesson_end_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson_schedules`
--

INSERT INTO `lesson_schedules` (`id`, `lesson_id`, `lesson_start_date`, `lesson_end_date`) VALUES
(1, 6, 1528549200, 1528560000);

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `posted_information` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_cookies`
--

CREATE TABLE `site_cookies` (
  `id` int(11) NOT NULL,
  `cookie_code` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_cookies`
--

INSERT INTO `site_cookies` (`id`, `cookie_code`, `user_id`, `expiry_date`) VALUES
(37, 'nMG4bM72xkrcGsPhS2fbGDtWQVDuTMcQ3dvXKJjXQAXGVkJ8QDj8eMj9mP5PmHX5euspUy3C7dftXBKGcZg4AqCENxzrXtpSYS5gWNdEbBCa7bjkFVEFpFRufEt9Ycgm', 88, 1503976965),
(38, 'VBfQ4Bu8vSV8N4mV6Vzh6ZTsC2G8y3JST9xAbR55RqBxPJVJzJJQc3XK7FVYBZUTQveNfzG9y8uVCyaXZvPrkCg2qfe7s39C9SqXFUeNnTVC936VPrjhPbckgQMPmJSQ', 88, 1503976967),
(39, 'z6pv4taFejJqXdaqkXg4Ua2mAetZkr42qWMRW3Rk6TPQWcYBkHEKMEGax23xSvpmt2zsApU7t44JXn2TV5aB49rsqmEfWFvDWH6CfJHcsfBWghJY5JXKmGqRuzsBbhN7', 88, 1503976975);

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

CREATE TABLE `store_categories` (
  `id` int(11) NOT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `parent_cat_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `cat_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `parent_cat_id`, `priority`, `cat_url`) VALUES
(15, 'Boats', 0, 1, 'Boats'),
(16, 'Skis', 0, 4, 'Skis'),
(17, 'Wakeboard', 0, 2, 'Wakeboard'),
(18, 'Kneeboard', 0, 3, 'Kneeboard'),
(19, 'Ropes/Hardles', 0, 5, 'RopesHardles'),
(20, 'Floatres', 0, 6, 'Floatres'),
(21, 'PWC (Personal Water Craft)', 0, 7, 'PWC-Personal-Water-Craft'),
(22, 'Accessories', 0, 8, 'Accessories'),
(23, 'Other', 0, 9, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `store_cat_assign`
--

CREATE TABLE `store_cat_assign` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_cat_assign`
--

INSERT INTO `store_cat_assign` (`id`, `cat_id`, `item_id`) VALUES
(47, 17, 36),
(48, 17, 37),
(49, 17, 38),
(50, 17, 39),
(51, 17, 40),
(52, 17, 41),
(53, 17, 42),
(54, 17, 43),
(55, 15, 44),
(57, 17, 46),
(59, 17, 48),
(60, 15, 49),
(61, 15, 51),
(64, 17, 47);

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

CREATE TABLE `store_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_price` decimal(7,2) NOT NULL,
  `item_description` varchar(5000) NOT NULL,
  `city` varchar(60) NOT NULL,
  `state` varchar(5) NOT NULL,
  `was_price` decimal(7,2) NOT NULL,
  `status` int(1) NOT NULL,
  `date_made` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `user_id`, `item_title`, `item_url`, `item_price`, `item_description`, `city`, `state`, `was_price`, `status`, `date_made`) VALUES
(36, 0, 'Wakeboard', 'Wakeboard', '300.00', '                                                      An awesome wakeboard.                                                ', 'Normal', 'IL', '0.00', 1, 1505255180),
(37, 7, 'Wakeboard', 'WakeboardMzvWE9', '250.00', 'A wakeboard', 'Normal', 'IL', '0.00', 1, 1505257041),
(38, 7, 'Wakeboard', 'WakeboardX4upZa', '400.00', 'Wakeboard', 'Normal', 'IL', '0.00', 1, 1522350856),
(39, 7, 'Wakeboard 2', 'Wakeboard-2uHC4Br', '500.00', 'Wakeboard 2', 'Bloomington', 'IL', '0.00', 1, 1522355935),
(40, 0, 'Board', 'BoardkBk5yc', '200.00', 'Desc', 'Normal', 'IL', '0.00', 1, 1524601843),
(41, 0, 'Board', 'BoardHwqfxE', '200.00', 'Desc', 'Bloomington', 'IL', '0.00', 1, 1524601868),
(42, 0, 'Board', 'BoardHRh3Wk', '200.00', 'Intro', 'Normal', 'IL', '0.00', 1, 1524608933),
(43, 0, 'Board', 'Boardeh9Zeg', '300.00', 'Intro', 'Normal', 'IL', '0.00', 1, 1524608989),
(44, 0, 'Boat', 'Boat3D6xwU', '20000.00', 'desc', 'Normal', 'ID', '0.00', 1, 1524655845),
(46, 0, 'Board', 'Boardt6pR5n', '200.00', 'Desc', 'Normal', 'IL', '0.00', 1, 1524655915),
(47, 0, 'Board', 'Board', '300.00', 'DESC', 'Bloomington', 'IL', '0.00', 1, 1524655949),
(48, 0, 'Board', 'BoardN4wj6C', '400.00', 'Desc ', 'Normal', 'IL', '0.00', 1, 1524655978),
(49, 7, 'Board', 'Boardkk2dgG', '1.00', 'Hello', 'Normal', 'IL', '0.00', 1, 1524931901),
(50, 7, 'Board', 'BoardSgkR7E', '400.00', 'A nice board.', 'Normal', 'IL', '0.00', 1, 1524932059),
(51, 0, 'Boat 5', 'Boat-5dJ36rh', '500.00', 'Nice boat', 'Bloomington', 'IL', '0.00', 1, 1525039886);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(65) NOT NULL,
  `first_name` varchar(120) NOT NULL,
  `last_name` varchar(65) NOT NULL,
  `email` varchar(65) NOT NULL,
  `date_made` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  `ran_str` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `date_made`, `password`, `last_login`, `ran_str`) VALUES
(7, 'stokuda', 'Suguru', 'Tokuda', 'stokuda@ilstu.edu', 1523543686, '$2y$11$1jYxu3Y4CX4NgECCh/wbzO6dydE3KmERXuoufhCQCAMUa0CJjZHyG', 1527913712, NULL),
(8, 'suguru', 'Suguru', 'Tokuda', 'suguru@gmail.com', 1524495032, '$2y$11$fji.3rov3dQGg..m9y.hKeTY/Ewzv4nsarpAgR6Oqut1JACEFa1fi', 1524495120, NULL),
(10, 'stokuda12', 'Suguru', 'Tokuda', 'suguru.tokuda@gmail.com', 1527737322, '$2y$11$H.D22I1R/4NzPUOUd4F1wOuJqk6aVll7dPW4D8Wj5ftio8eJewXum', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `webpages`
--

CREATE TABLE `webpages` (
  `id` int(11) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_keywords` text NOT NULL,
  `page_description` text NOT NULL,
  `page_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webpages`
--

INSERT INTO `webpages` (`id`, `page_url`, `page_title`, `page_keywords`, `page_description`, `page_content`) VALUES
(1, '', 'The Homepage', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_pics`
--
ALTER TABLE `blog_pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_videos`
--
ALTER TABLE `blog_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boat_pics`
--
ALTER TABLE `boat_pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boat_rental`
--
ALTER TABLE `boat_rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boat_rental_basket`
--
ALTER TABLE `boat_rental_basket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boat_rental_schedules`
--
ALTER TABLE `boat_rental_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `homepage_blocks`
--
ALTER TABLE `homepage_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_pics`
--
ALTER TABLE `item_pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_basket`
--
ALTER TABLE `lesson_basket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_bookings`
--
ALTER TABLE `lesson_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_pics`
--
ALTER TABLE `lesson_pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_schedules`
--
ALTER TABLE `lesson_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_cookies`
--
ALTER TABLE `site_cookies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_categories`
--
ALTER TABLE `store_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_cat_assign`
--
ALTER TABLE `store_cat_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_items`
--
ALTER TABLE `store_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webpages`
--
ALTER TABLE `webpages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blog_pics`
--
ALTER TABLE `blog_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blog_videos`
--
ALTER TABLE `blog_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boat_pics`
--
ALTER TABLE `boat_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `boat_rental`
--
ALTER TABLE `boat_rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `boat_rental_basket`
--
ALTER TABLE `boat_rental_basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `boat_rental_schedules`
--
ALTER TABLE `boat_rental_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `homepage_blocks`
--
ALTER TABLE `homepage_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_pics`
--
ALTER TABLE `item_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lesson_basket`
--
ALTER TABLE `lesson_basket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lesson_bookings`
--
ALTER TABLE `lesson_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lesson_pics`
--
ALTER TABLE `lesson_pics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lesson_schedules`
--
ALTER TABLE `lesson_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_cookies`
--
ALTER TABLE `site_cookies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `store_categories`
--
ALTER TABLE `store_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `store_cat_assign`
--
ALTER TABLE `store_cat_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `store_items`
--
ALTER TABLE `store_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `webpages`
--
ALTER TABLE `webpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
