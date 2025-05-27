-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2021 at 10:03 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electrozon`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tbl_ValidateExistingUser` (IN `useremail` VARCHAR(255))  NO SQL
BEGIN
SELECT * FROM customers WHERE username = useremail;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  `city` text NOT NULL,
  `post_code` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `username`, `address`, `verified`, `city`, `post_code`, `phone_number`, `name`) VALUES
(9, 'rohitkrtiwari2002@gmail.com', 'Rz 723 C2 Puran Nagar Palam New Delhi', 1, 'New Delhi', '110012', '9910790607', 'Rohit Tiwari'),
(10, 'rohitkrtiwari2002@gmail.com', 'Pusa Institute Of Technology, Pusa, New Delhi', 1, 'New Delhi', '110012', '9910790607', 'Vimlesh Tiwari'),
(11, 'rohitkrtiwari2002@gmail.com', 'Pusa Institute Of Technology, Pusa, New Delhi', 1, 'New Delhi', '110012', '9910790607', 'Aakash'),
(12, 'rohitkrtiwari2002@gmail.com', 'Pusa Institute Of Technology, Pusa, New Delhi', 0, 'New Delhi', '110046', '9910026324', 'Rohit Tiwari'),
(13, 'rohitkrtiwari2002@gmail.com', 'Rz 723 C2 Puran Nagar Palam New Delhi', 0, 'New Delhi', '110012', '7398087524', 'Rohit'),
(18, 'rohitkrtiwari2002@gmail.com', 'Ward No 12, Sakraura Nagar, Colonelgunj Gonda', 1, 'Gonda', '271502', '9910790607', 'Chaman Aggarwal'),
(25, 'rohitkrtiwari2002@gmail.com', 'Pusa Institute Of Technology, Pusa, New Delhi', 0, 'New Delhi', '110012', '9910790607', 'Rohit Tiwari');

-- --------------------------------------------------------

--
-- Table structure for table `admin_loggedin`
--

CREATE TABLE `admin_loggedin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remote_addr` varchar(255) NOT NULL,
  `http_user_agent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_loggedin`
--

INSERT INTO `admin_loggedin` (`id`, `username`, `login_time`, `remote_addr`, `http_user_agent`) VALUES
(1, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-17 09:52:35'),
(2, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-17 09:53:35'),
(3, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-17 09:55:11'),
(4, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-17 09:56:39'),
(5, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-18 01:12:35'),
(6, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36', '2021-02-18 11:26:16'),
(7, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-20 09:31:57'),
(8, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-21 11:30:25'),
(9, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-21 11:32:04'),
(10, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-21 11:32:42'),
(11, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-22 02:15:33'),
(12, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-22 02:19:05'),
(13, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-22 01:56:03'),
(14, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 11:34:02'),
(15, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 11:58:22'),
(16, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 11:58:50'),
(17, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 12:02:49'),
(18, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 12:04:27'),
(19, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-23 12:04:59'),
(20, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 08:28:06'),
(21, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:36:56'),
(22, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:03'),
(23, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:08'),
(24, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:12'),
(25, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:19'),
(26, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:33'),
(27, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:37:37'),
(28, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:38:36'),
(29, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-24 11:41:52'),
(30, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-25 12:45:48'),
(31, 'rohitkrtiwari2002@gmail.com', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', '2021-02-26 01:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'rohitkrtiwari2002@gmail.com', 'd239cc9dd26dda09d425075e65d4f465');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `verfied` tinyint(4) NOT NULL,
  `username` varchar(500) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `qty` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `verfied`, `username`, `pid`, `qty`) VALUES
(2, 0, 'user_6027fa0882499', '12', 1),
(3, 0, 'user_6027f88ccd8d4', '12', 1),
(5, 1, 'rohitkrtiwari2002@gmail.com', '15', 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`) VALUES
(1, 'Boards & Programmers', 1),
(2, 'Sensor and Module', 1),
(3, 'Electronic Components', 1),
(4, 'Power Supply', 1),
(6, 'Solar Panel & Cells', 1),
(10, 'Robotics & Drones', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(75) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `query` text NOT NULL,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `user_id`, `name`, `email`, `mobile`, `query`, `added_on`) VALUES
(1, 'user_6025245d0c1bd', 'Rohit Rohit Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'sfs', '2021-02-22 14:04:47'),
(2, 'user_6025245d0c1bd', 'Rohit Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'Need to remember to pick up some groceries? Set a location-based reminder to pull up your grocery list right when you get to the store. Need to finish a to-do? Set a time-based reminder to make sure you never miss a thing.', '2021-02-22 14:05:59'),
(3, 'rohitkrtiwari2002@gmail.com', 'Rohit Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'website', '2021-02-23 10:44:29'),
(4, 'rohitkrtiwari2002@gmail.com', 'Rohit Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'Python', '2021-02-23 10:45:04'),
(5, 'rohitkrtiwari2002@gmail.com', 'Rohit Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'dsafgsg', '2021-02-23 10:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fname`, `lname`, `username`, `mobile`, `password`, `created_on`, `status`, `token`) VALUES
(12, 'Rohit Kumar', 'Tiwari', 'rohitkrtiwari2002@gmail.com', '9910790607', 'e10adc3949ba59abbe56e057f20f883e', '2021-02-23 12:46:05', 1, 'f1a2ad8fb63c20eb61bbe798da0b225d1f7ee93ec3a315debe5a680d305169b1d984f5f767af72bf56da32230750547e336e');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `shipping_charge` int(255) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `order_status` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `TXNID` varchar(255) DEFAULT NULL,
  `BANKTXNID` varchar(255) DEFAULT NULL,
  `BANKNAME` varchar(255) NOT NULL,
  `PAYMENTMODE` varchar(255) NOT NULL,
  `tracking_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `username`, `address_id`, `total_price`, `shipping_charge`, `payment_status`, `order_status`, `added_on`, `TXNID`, `BANKTXNID`, `BANKNAME`, `PAYMENTMODE`, `tracking_id`) VALUES
(1001, 'rohitkrtiwari2002@gmail.com', 9, 167, 49, 'success', 2, '2021-02-14 07:37:50', '20210214111212800110168020803782875', '777001875119519', 'Bank of Bahrain and Kuwait', 'Debit card', '4234234'),
(1002, 'rohitkrtiwari2002@gmail.com', 9, 10736.8, 0, 'pending', 1, '2021-02-23 10:22:33', NULL, NULL, '', '', ''),
(1003, 'rohitkrtiwari2002@gmail.com', 9, 19470, 0, 'pending', 1, '2021-02-24 09:20:31', NULL, NULL, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(3, 1001, 16, 1, 100),
(4, 1002, 12, 1, 5500),
(5, 1002, 15, 1, 3599),
(6, 1003, 12, 3, 5500);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'pending'),
(2, 'processing'),
(3, 'shipped'),
(4, 'cancelled'),
(5, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `used` int(11) NOT NULL DEFAULT '0',
  `email_sent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `username`, `reset_token`, `created_at`, `used`, `email_sent`) VALUES
(15, 'rohitkrtiwari2002@gmail.com', 'dd128b7fc050d403dd5f6da536547edd9d10e348a78f86cf646f572c507d5e3fc7763657233b947e40f78d24b44fa3cc49e4', '2021-02-24 13:55:57', 1, 1),
(16, 'rohitkrtiwari2002@gmail.com', 'aef99f40fcb0fffdbc79908e404c49750c61aa1b48c74bd5a9c5e4d96404f41ffa11aff65e4abfcd75122e201a4aa6239c27', '2021-02-25 19:41:58', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `mrp` float NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_desc` varchar(2000) NOT NULL,
  `description` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_desc` varchar(2000) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `meta_keyword` varchar(2000) NOT NULL,
  `best_seller` tinyint(4) NOT NULL,
  `sub_categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `short_name`, `mrp`, `price`, `qty`, `image`, `short_desc`, `description`, `meta_title`, `meta_desc`, `status`, `meta_keyword`, `best_seller`, `sub_categories_id`) VALUES
(12, 1, 'Raspberry Pi 4 8GB RAM | All New Raspberry Pi Desktop Computer', 'Respberry Pi 4 8 GB RAM', 7764, 5500, 10, '566594123_respberry.jpg', 'The Raspberry Pi 4 with the 8GB RAM capacity provides a huge scope for various multi-tasking activities, running powerful data servers, projects, virtual machines etc. This mini-computer is a better alternative since it is both energy efficient and cost effective. It is a silent machine and uses less energy than any other computer. It provides faster networking as it comes with a Gigabit Ethernet and onboard wireless networking along with better bluetooth connectivity. It can transfer data 10 times faster with the help of two USB 3.0 ports and two USB 2.0 ports.', 'The Raspberry Pi 4 with the 8GB RAM capacity provides a huge scope for various multi-tasking activities, running powerful data servers, projects, virtual machines etc. This mini-computer is a better alternative since it is both energy efficient and cost effective. It is a silent machine and uses less energy than any other computer. It provides faster networking as it comes with a Gigabit Ethernet and onboard wireless networking along with better bluetooth connectivity. It can transfer data 10 times faster with the help of two USB 3.0 ports and two USB 2.0 ports.', 'The Raspberry Pi 4 with the 8GB RAM capacity provides a huge scope for various multi-tasking activities, running powerful data servers, projects, virtual machines etc. This mini-computer is a better alternative since it is both energy efficient and cost effective. It is a silent machine and uses less energy than any other computer. It provides faster networking as it comes with a Gigabit Ethernet and onboard wireless networking along with better bluetooth connectivity. It can transfer data 10 times faster with the help of two USB 3.0 ports and two USB 2.0 ports.', 'The Raspberry Pi 4 with the 8GB RAM capacity provides a huge scope for various multi-tasking activities, running powerful data servers, projects, virtual machines etc. This mini-computer is a better alternative since it is both energy efficient and cost effective. It is a silent machine and uses less energy than any other computer. It provides faster networking as it comes with a Gigabit Ethernet and onboard wireless networking along with better bluetooth connectivity. It can transfer data 10 times faster with the help of two USB 3.0 ports and two USB 2.0 ports.', 1, 'The Raspberry Pi 4 with the 8GB RAM capacity provides a huge scope for various multi-tasking activities, running powerful data servers, projects, virtual machines etc. This mini-computer is a better alternative since it is both energy efficient and cost effective. It is a silent machine and uses less energy than any other computer. It provides faster networking as it comes with a Gigabit Ethernet and onboard wireless networking along with better bluetooth connectivity. It can transfer data 10 times faster with the help of two USB 3.0 ports and two USB 2.0 ports.', 0, 0),
(13, 1, 'UNO R3 Development Board ATmega328P ATmega16U2 with USB cable for Arduino', 'UNO R3 Development Board', 500, 250, 10, '528323716_arduino.jpg', 'It has 14 digital input/output pins (of which 6 can be used as PWM outputs), 6 analog inputs, a 16 MHz crystal oscillator, a USB connection, a power jack, an ICSP header, and a reset button. It contains everything needed to support the microcontroller; simply connect it to a computer with a USB cable or power it with a AC-to-DC adapter or battery to get started.', 'It has 14 digital input/output pins (of which 6 can be used as PWM outputs), 6 analog inputs, a 16 MHz crystal oscillator, a USB connection, a power jack, an ICSP header, and a reset button. It contains everything needed to support the microcontroller; simply connect it to a computer with a USB cable or power it with a AC-to-DC adapter or battery to get started.', 'It has 14 digital input/output pins (of which 6 can be used as PWM outputs), 6 analog inputs, a 16 MHz crystal oscillator, a USB connection, a power jack, an ICSP header, and a reset button. It contains everything needed to support the microcontroller; simply connect it to a computer with a USB cable or power it with a AC-to-DC adapter or battery to get started.', 'It has 14 digital input/output pins (of which 6 can be used as PWM outputs), 6 analog inputs, a 16 MHz crystal oscillator, a USB connection, a power jack, an ICSP header, and a reset button. It contains everything needed to support the microcontroller; simply connect it to a computer with a USB cable or power it with a AC-to-DC adapter or battery to get started.', 1, 'It has 14 digital input/output pins (of which 6 can be used as PWM outputs), 6 analog inputs, a 16 MHz crystal oscillator, a USB connection, a power jack, an ICSP header, and a reset button. It contains everything needed to support the microcontroller; simply connect it to a computer with a USB cable or power it with a AC-to-DC adapter or battery to get started.', 0, 0),
(14, 1, 'BeagleBone Rev C with 4GB Flash Memory', 'BeagleBone Rev C', 1490, 999, 10, '644766606_beaglebone.jpg', 'A true open hardware, community-supported embedded computer for developers and hobbyists. Boots linux and get started on development in less than 5 minutes with just a single usb cable. Core architecture:arm.Core sub-architecture:cortex-a8.Features:3d graphics/neon floating-point accelerator, 4gb emmc on-board flash storage, usb interface.Kit contents:dev board am3358, usb cable.No. Of bits:32bit.Svhc:to be advised.Silicon core number:am3358.Silicon family name:sitara - am335x.Silicon manufacturer:texas instruments.', 'A true open hardware, community-supported embedded computer for developers and hobbyists. Boots linux and get started on development in less than 5 minutes with just a single usb cable. Core architecture:arm.Core sub-architecture:cortex-a8.Features:3d graphics/neon floating-point accelerator, 4gb emmc on-board flash storage, usb interface.Kit contents:dev board am3358, usb cable.No. Of bits:32bit.Svhc:to be advised.Silicon core number:am3358.Silicon family name:sitara - am335x.Silicon manufacturer:texas instruments.', 'A true open hardware, community-supported embedded computer for developers and hobbyists. Boots linux and get started on development in less than 5 minutes with just a single usb cable. Core architecture:arm.Core sub-architecture:cortex-a8.Features:3d graphics/neon floating-point accelerator, 4gb emmc on-board flash storage, usb interface.Kit contents:dev board am3358, usb cable.No. Of bits:32bit.Svhc:to be advised.Silicon core number:am3358.Silicon family name:sitara - am335x.Silicon manufacturer:texas instruments.', 'A true open hardware, community-supported embedded computer for developers and hobbyists. Boots linux and get started on development in less than 5 minutes with just a single usb cable. Core architecture:arm.Core sub-architecture:cortex-a8.Features:3d graphics/neon floating-point accelerator, 4gb emmc on-board flash storage, usb interface.Kit contents:dev board am3358, usb cable.No. Of bits:32bit.Svhc:to be advised.Silicon core number:am3358.Silicon family name:sitara - am335x.Silicon manufacturer:texas instruments.', 1, 'A true open hardware, community-supported embedded computer for developers and hobbyists. Boots linux and get started on development in less than 5 minutes with just a single usb cable. Core architecture:arm.Core sub-architecture:cortex-a8.Features:3d graphics/neon floating-point accelerator, 4gb emmc on-board flash storage, usb interface.Kit contents:dev board am3358, usb cable.No. Of bits:32bit.Svhc:to be advised.Silicon core number:am3358.Silicon family name:sitara - am335x.Silicon manufacturer:texas instruments.', 0, 0),
(15, 1, 'Buyyart Mini USB Pro EEPROM Universal Programmer', 'Buyyart Mini USB Pro', 5999, 3599, 5, '789167809_buyyart_programmer.jpg', 'Unique universal serial programming interface icsp:(Only TL866A can support, TL866CS cannot use this function) tl866a programmer can program through the 40-pin universal socket and is provided with an icsp serial programming port.', 'Unique universal serial programming interface icsp:(Only TL866A can support, TL866CS cannot use this function) tl866a programmer can program through the 40-pin universal socket and is provided with an icsp serial programming port.', 'Unique universal serial programming interface icsp:(Only TL866A can support, TL866CS cannot use this function) tl866a programmer can program through the 40-pin universal socket and is provided with an icsp serial programming port.', 'Unique universal serial programming interface icsp:(Only TL866A can support, TL866CS cannot use this function) tl866a programmer can program through the 40-pin universal socket and is provided with an icsp serial programming port.', 1, 'Unique universal serial programming interface icsp:(Only TL866A can support, TL866CS cannot use this function) tl866a programmer can program through the 40-pin universal socket and is provided with an icsp serial programming port.', 1, 0),
(16, 3, 'Robokitshop 8-Bit Shift Register ICs for Electronics Arduino PIC Projects -5 Pieces', '8Bit Shift Register IC', 180, 100, 50, '569316490_ICs.jpg', 'The HC595 devices contain a 8-Bit serial-in, parallel-out shift register that feeds an 8-bit D-type storage register. The storage register has parallel 3-state outputs.Separate Clocks are provided for both the shift and storage register. The shift register has a direct overriding clear (SRCLR) input, serial (SER) input, and serial output for cascading. When the output-Enable (OE) input is high, the outputs are in the high-impedance state. Both the shift register clock (SRCLK) and storage register clock (RCLK) are positive edge-triggered. if both clock are connected together, the shift register always is one clock pulse ahead of the storage register.', 'The HC595 devices contain a 8-Bit serial-in, parallel-out shift register that feeds an 8-bit D-type storage register. The storage register has parallel 3-state outputs.Separate Clocks are provided for both the shift and storage register. The shift register has a direct overriding clear (SRCLR) input, serial (SER) input, and serial output for cascading. When the output-Enable (OE) input is high, the outputs are in the high-impedance state. Both the shift register clock (SRCLK) and storage register clock (RCLK) are positive edge-triggered. if both clock are connected together, the shift register always is one clock pulse ahead of the storage register.', 'The HC595 devices contain a 8-Bit serial-in, parallel-out shift register that feeds an 8-bit D-type storage register. The storage register has parallel 3-state outputs.Separate Clocks are provided for both the shift and storage register. The shift register has a direct overriding clear (SRCLR) input, serial (SER) input, and serial output for cascading. When the output-Enable (OE) input is high, the outputs are in the high-impedance state. Both the shift register clock (SRCLK) and storage register clock (RCLK) are positive edge-triggered. if both clock are connected together, the shift register always is one clock pulse ahead of the storage register.', 'The HC595 devices contain a 8-Bit serial-in, parallel-out shift register that feeds an 8-bit D-type storage register. The storage register has parallel 3-state outputs.Separate Clocks are provided for both the shift and storage register. The shift register has a direct overriding clear (SRCLR) input, serial (SER) input, and serial output for cascading. When the output-Enable (OE) input is high, the outputs are in the high-impedance state. Both the shift register clock (SRCLK) and storage register clock (RCLK) are positive edge-triggered. if both clock are connected together, the shift register always is one clock pulse ahead of the storage register.', 1, 'The HC595 devices contain a 8-Bit serial-in, parallel-out shift register that feeds an 8-bit D-type storage register. The storage register has parallel 3-state outputs.Separate Clocks are provided for both the shift and storage register. The shift register has a direct overriding clear (SRCLR) input, serial (SER) input, and serial output for cascading. When the output-Enable (OE) input is high, the outputs are in the high-impedance state. Both the shift register clock (SRCLK) and storage register clock (RCLK) are positive edge-triggered. if both clock are connected together, the shift register always is one clock pulse ahead of the storage register.', 0, 0),
(17, 3, 'Generic Electronic Components Project Kit or Breadboard, Capacitor, Resistor, LED, Switch (Comes in a Box)', 'Generic Electronic Component Project Kit', 430, 350, 75, '397721091_Elec project ki.jpg', 'Cost effective and affordable collection of all basic electronics components and prototyping. Components included and breadboard 1 pieces and 2 meter hookup wire and assorted resistor 50 pieces and assorted ceramic capacitor 50 pieces and assorted capacitor 70 pieces and assorted transistor 40 pieces and assorted 5mm LED 50 pieces and assorted diodes 20 pieces and misc. components assorted resistor(5 pieces each) 1 ohm, 10 ohm, 100 ohm, 150 ohm, 220 ohm, 1k, 10k, 100k, 150k, 220k, 1m assorted ceramic capacitor(10 pieces each) 10 pf, 100 pf, 102 pf, 103 pf, 104 pf assorted transistors 547 10 pieces, 557 10 pieces, kn2222 10 pieces, 2n3904 5 pieces, 2n3906 5 pieces assorted capacitor 1uf 10 pieces, 2. 2Uf 10 pieces, 4. 7Uf 10 pieces, 47uf 10 pieces, 100uf 10 pieces, 220uf 5 pieces, 470uf 5 pieces assorted 5mm LED (10 pieces each) red, blue, green, yellow, infrared diodes (10 pieces each) 4004148 miscellaneous components 5. 1V Zener 2 pieces, 555 timer ic, 741 opamp ic, 4017 counter ic, 100 ohm trim pot, 1k ohm trim pot, 5k ohm trim pot, 10k ohm trim pot, lm317 voltage regulator, 7805 voltage regulator, 7812 voltage regulator, ldr, b20 buzzer thermistor 3 value, 9v battery, 9v battery clip, push buttons 2 pieces, condenser mic.', 'Cost effective and affordable collection of all basic electronics components and prototyping. Components included and breadboard 1 pieces and 2 meter hookup wire and assorted resistor 50 pieces and assorted ceramic capacitor 50 pieces and assorted capacitor 70 pieces and assorted transistor 40 pieces and assorted 5mm LED 50 pieces and assorted diodes 20 pieces and misc. components assorted resistor(5 pieces each) 1 ohm, 10 ohm, 100 ohm, 150 ohm, 220 ohm, 1k, 10k, 100k, 150k, 220k, 1m assorted ceramic capacitor(10 pieces each) 10 pf, 100 pf, 102 pf, 103 pf, 104 pf assorted transistors 547 10 pieces, 557 10 pieces, kn2222 10 pieces, 2n3904 5 pieces, 2n3906 5 pieces assorted capacitor 1uf 10 pieces, 2. 2Uf 10 pieces, 4. 7Uf 10 pieces, 47uf 10 pieces, 100uf 10 pieces, 220uf 5 pieces, 470uf 5 pieces assorted 5mm LED (10 pieces each) red, blue, green, yellow, infrared diodes (10 pieces each) 4004148 miscellaneous components 5. 1V Zener 2 pieces, 555 timer ic, 741 opamp ic, 4017 counter ic, 100 ohm trim pot, 1k ohm trim pot, 5k ohm trim pot, 10k ohm trim pot, lm317 voltage regulator, 7805 voltage regulator, 7812 voltage regulator, ldr, b20 buzzer thermistor 3 value, 9v battery, 9v battery clip, push buttons 2 pieces, condenser mic.', 'Cost effective and affordable collection of all basic electronics components and prototyping. Components included and breadboard 1 pieces and 2 meter hookup wire and assorted resistor 50 pieces and assorted ceramic capacitor 50 pieces and assorted capacitor 70 pieces and assorted transistor 40 pieces and assorted 5mm LED 50 pieces and assorted diodes 20 pieces and misc. components assorted resistor(5 pieces each) 1 ohm, 10 ohm, 100 ohm, 150 ohm, 220 ohm, 1k, 10k, 100k, 150k, 220k, 1m assorted ceramic capacitor(10 pieces each) 10 pf, 100 pf, 102 pf, 103 pf, 104 pf assorted transistors 547 10 pieces, 557 10 pieces, kn2222 10 pieces, 2n3904 5 pieces, 2n3906 5 pieces assorted capacitor 1uf 10 pieces, 2. 2Uf 10 pieces, 4. 7Uf 10 pieces, 47uf 10 pieces, 100uf 10 pieces, 220uf 5 pieces, 470uf 5 pieces assorted 5mm LED (10 pieces each) red, blue, green, yellow, infrared diodes (10 pieces each) 4004148 miscellaneous components 5. 1V Zener 2 pieces, 555 timer ic, 741 opamp ic, 4017 counter ic, 100 ohm trim pot, 1k ohm trim pot, 5k ohm trim pot, 10k ohm trim pot, lm317 voltage regulator, 7805 voltage regulator, 7812 voltage regulator, ldr, b20 buzzer thermistor 3 value, 9v battery, 9v battery clip, push buttons 2 pieces, condenser mic.', 'Cost effective and affordable collection of all basic electronics components and prototyping. Components included and breadboard 1 pieces and 2 meter hookup wire and assorted resistor 50 pieces and assorted ceramic capacitor 50 pieces and assorted capacitor 70 pieces and assorted transistor 40 pieces and assorted 5mm LED 50 pieces and assorted diodes 20 pieces and misc. components assorted resistor(5 pieces each) 1 ohm, 10 ohm, 100 ohm, 150 ohm, 220 ohm, 1k, 10k, 100k, 150k, 220k, 1m assorted ceramic capacitor(10 pieces each) 10 pf, 100 pf, 102 pf, 103 pf, 104 pf assorted transistors 547 10 pieces, 557 10 pieces, kn2222 10 pieces, 2n3904 5 pieces, 2n3906 5 pieces assorted capacitor 1uf 10 pieces, 2. 2Uf 10 pieces, 4. 7Uf 10 pieces, 47uf 10 pieces, 100uf 10 pieces, 220uf 5 pieces, 470uf 5 pieces assorted 5mm LED (10 pieces each) red, blue, green, yellow, infrared diodes (10 pieces each) 4004148 miscellaneous components 5. 1V Zener 2 pieces, 555 timer ic, 741 opamp ic, 4017 counter ic, 100 ohm trim pot, 1k ohm trim pot, 5k ohm trim pot, 10k ohm trim pot, lm317 voltage regulator, 7805 voltage regulator, 7812 voltage regulator, ldr, b20 buzzer thermistor 3 value, 9v battery, 9v battery clip, push buttons 2 pieces, condenser mic.', 1, 'Cost effective and affordable collection of all basic electronics components and prototyping. Components included and breadboard 1 pieces and 2 meter hookup wire and assorted resistor 50 pieces and assorted ceramic capacitor 50 pieces and assorted capacitor 70 pieces and assorted transistor 40 pieces and assorted 5mm LED 50 pieces and assorted diodes 20 pieces and misc. components assorted resistor(5 pieces each) 1 ohm, 10 ohm, 100 ohm, 150 ohm, 220 ohm, 1k, 10k, 100k, 150k, 220k, 1m assorted ceramic capacitor(10 pieces each) 10 pf, 100 pf, 102 pf, 103 pf, 104 pf assorted transistors 547 10 pieces, 557 10 pieces, kn2222 10 pieces, 2n3904 5 pieces, 2n3906 5 pieces assorted capacitor 1uf 10 pieces, 2. 2Uf 10 pieces, 4. 7Uf 10 pieces, 47uf 10 pieces, 100uf 10 pieces, 220uf 5 pieces, 470uf 5 pieces assorted 5mm LED (10 pieces each) red, blue, green, yellow, infrared diodes (10 pieces each) 4004148 miscellaneous components 5. 1V Zener 2 pieces, 555 timer ic, 741 opamp ic, 4017 counter ic, 100 ohm trim pot, 1k ohm trim pot, 5k ohm trim pot, 10k ohm trim pot, lm317 voltage regulator, 7805 voltage regulator, 7812 voltage regulator, ldr, b20 buzzer thermistor 3 value, 9v battery, 9v battery clip, push buttons 2 pieces, condenser mic.', 0, 0),
(18, 2, 'xcluma Sound Sensor Module Sound Detection Module UNO Other Mcu', 'Sound Sensor Module', 199, 149, 25, '631280496_sound sensor module.jpg', 'Sound sensor module sound detection module main chip: Lm393, electret microphoneconnector wire length: 24. 5cmwith 3 sets of servo horns and fittings.', 'Sound sensor module sound detection module main chip: Lm393, electret microphoneconnector wire length: 24. 5cmwith 3 sets of servo horns and fittings.', 'Sound sensor module sound detection module main chip: Lm393, electret microphoneconnector wire length: 24. 5cmwith 3 sets of servo horns and fittings.', 'Sound sensor module sound detection module main chip: Lm393, electret microphoneconnector wire length: 24. 5cmwith 3 sets of servo horns and fittings.', 1, 'Sound sensor module sound detection module main chip: Lm393, electret microphoneconnector wire length: 24. 5cmwith 3 sets of servo horns and fittings.', 1, 0),
(19, 2, 'REES52 Ultrasonic Range Finder Module Sensor Distance Measuring Transducer New', 'Ultrasonic Senson SR-04', 300, 249, 10, '542731794_ultrasonic sesor.jpg', 'The HC-SR04 ultrasonic sensor uses sonar to measure distance to an object. It offers excellent range accuracy and stable readings in an easy-to-use package. It operation is not affected by sunlight or black material like sharp range finders are (soft materials like cloth can be difficult to detect). Module main technical parameters. Working Voltage: 5V(DC). Static Current: Less than 2mA. Output Signal: Electric frequency signal, high level 5V, low level 0V. Sensor Angle: Not more than 15 degrees. Detection Distance: 2 to 450 cm. High Precision: Up to 0.3cm. Input Trigger Signal: 10us TTL impulse. Echo Signal: Output TTL PWL signal mode of connection, VCC, trig(T), echo(R), GND. The basic operation principle is below, use IO port TRIG to trigger ranging. It needs 10 us high level signal at least module will send eight 40kHz square wave automatically and will test if there is any signal returned. If there is signal returned, output will be high level signal via IO port ECHO. The duration of the high level signal is the time from transmitter to receiving with the ultrasonic. Testing distance = duration of high level x sound velocity(340m/s) / 2 You can use the above calculation to find the distance between the obstacle and the ultrasonic module.', 'The HC-SR04 ultrasonic sensor uses sonar to measure distance to an object. It offers excellent range accuracy and stable readings in an easy-to-use package. It operation is not affected by sunlight or black material like sharp range finders are (soft materials like cloth can be difficult to detect). Module main technical parameters. Working Voltage: 5V(DC). Static Current: Less than 2mA. Output Signal: Electric frequency signal, high level 5V, low level 0V. Sensor Angle: Not more than 15 degrees. Detection Distance: 2 to 450 cm. High Precision: Up to 0.3cm. Input Trigger Signal: 10us TTL impulse. Echo Signal: Output TTL PWL signal mode of connection, VCC, trig(T), echo(R), GND. The basic operation principle is below, use IO port TRIG to trigger ranging. It needs 10 us high level signal at least module will send eight 40kHz square wave automatically and will test if there is any signal returned. If there is signal returned, output will be high level signal via IO port ECHO. The duration of the high level signal is the time from transmitter to receiving with the ultrasonic. Testing distance = duration of high level x sound velocity(340m/s) / 2 You can use the above calculation to find the distance between the obstacle and the ultrasonic module.', 'The HC-SR04 ultrasonic sensor uses sonar to measure distance to an object. It offers excellent range accuracy and stable readings in an easy-to-use package. It operation is not affected by sunlight or black material like sharp range finders are (soft materials like cloth can be difficult to detect). Module main technical parameters. Working Voltage: 5V(DC). Static Current: Less than 2mA. Output Signal: Electric frequency signal, high level 5V, low level 0V. Sensor Angle: Not more than 15 degrees. Detection Distance: 2 to 450 cm. High Precision: Up to 0.3cm. Input Trigger Signal: 10us TTL impulse. Echo Signal: Output TTL PWL signal mode of connection, VCC, trig(T), echo(R), GND. The basic operation principle is below, use IO port TRIG to trigger ranging. It needs 10 us high level signal at least module will send eight 40kHz square wave automatically and will test if there is any signal returned. If there is signal returned, output will be high level signal via IO port ECHO. The duration of the high level signal is the time from transmitter to receiving with the ultrasonic. Testing distance = duration of high level x sound velocity(340m/s) / 2 You can use the above calculation to find the distance between the obstacle and the ultrasonic module.', 'The HC-SR04 ultrasonic sensor uses sonar to measure distance to an object. It offers excellent range accuracy and stable readings in an easy-to-use package. It operation is not affected by sunlight or black material like sharp range finders are (soft materials like cloth can be difficult to detect). Module main technical parameters. Working Voltage: 5V(DC). Static Current: Less than 2mA. Output Signal: Electric frequency signal, high level 5V, low level 0V. Sensor Angle: Not more than 15 degrees. Detection Distance: 2 to 450 cm. High Precision: Up to 0.3cm. Input Trigger Signal: 10us TTL impulse. Echo Signal: Output TTL PWL signal mode of connection, VCC, trig(T), echo(R), GND. The basic operation principle is below, use IO port TRIG to trigger ranging. It needs 10 us high level signal at least module will send eight 40kHz square wave automatically and will test if there is any signal returned. If there is signal returned, output will be high level signal via IO port ECHO. The duration of the high level signal is the time from transmitter to receiving with the ultrasonic. Testing distance = duration of high level x sound velocity(340m/s) / 2 You can use the above calculation to find the distance between the obstacle and the ultrasonic module.', 1, 'The HC-SR04 ultrasonic sensor uses sonar to measure distance to an object. It offers excellent range accuracy and stable readings in an easy-to-use package. It operation is not affected by sunlight or black material like sharp range finders are (soft materials like cloth can be difficult to detect). Module main technical parameters. Working Voltage: 5V(DC). Static Current: Less than 2mA. Output Signal: Electric frequency signal, high level 5V, low level 0V. Sensor Angle: Not more than 15 degrees. Detection Distance: 2 to 450 cm. High Precision: Up to 0.3cm. Input Trigger Signal: 10us TTL impulse. Echo Signal: Output TTL PWL signal mode of connection, VCC, trig(T), echo(R), GND. The basic operation principle is below, use IO port TRIG to trigger ranging. It needs 10 us high level signal at least module will send eight 40kHz square wave automatically and will test if there is any signal returned. If there is signal returned, output will be high level signal via IO port ECHO. The duration of the high level signal is the time from transmitter to receiving with the ultrasonic. Testing distance = duration of high level x sound velocity(340m/s) / 2 You can use the above calculation to find the distance between the obstacle and the ultrasonic module.', 0, 0),
(20, 2, 'Robotbanao - EAEC100100-236Ir Infrared Obstacle Avoidance Sensor Module for Arduino Smart Car Robot, Blue', 'IR Senson 236lr - Arduino Sensor', 499, 150, 10, '821619197_infrarred.jpg', 'This IR Proximity Sensor is a multipurpose infrared sensor which can be used for obstacle sensing, color detection, fire detection, line sensing, etc and also as an encoder sensor. The sensor provides a digital output. The sensor outputs a logic one(+5V) at the digital output when an object is placed in front of the sensor and a logic zero(0V), when there is no object in front of the sensor. An onboard LED is used to indicate the presence of an object. This digital output can be directly connected to an Arduino, Raspberry Pi, AVR, PIC, 8051 or any other microcontroller to read the sensor output. IR sensors are highly susceptible to ambient light and the IR sensor on this sensor is suitably covered to reduce effect of ambient light on the sensor. The sensor has a maximum range of around 40-50 cm indoors and around 15-20 cm outdoors. Features: Can be used for obstacle sensing, color detection(between basic contrasting colors) Comes with an easy to use digital output Can be used for wireless communication and sensing IR remote signals Sensor comes with ambient light protection The sensor a hole of 3mm diameter for easy mounting', 'This IR Proximity Sensor is a multipurpose infrared sensor which can be used for obstacle sensing, color detection, fire detection, line sensing, etc and also as an encoder sensor. The sensor provides a digital output. The sensor outputs a logic one(+5V) at the digital output when an object is placed in front of the sensor and a logic zero(0V), when there is no object in front of the sensor. An onboard LED is used to indicate the presence of an object. This digital output can be directly connected to an Arduino, Raspberry Pi, AVR, PIC, 8051 or any other microcontroller to read the sensor output. IR sensors are highly susceptible to ambient light and the IR sensor on this sensor is suitably covered to reduce effect of ambient light on the sensor. The sensor has a maximum range of around 40-50 cm indoors and around 15-20 cm outdoors. Features: Can be used for obstacle sensing, color detection(between basic contrasting colors) Comes with an easy to use digital output Can be used for wireless communication and sensing IR remote signals Sensor comes with ambient light protection The sensor a hole of 3mm diameter for easy mounting', 'This IR Proximity Sensor is a multipurpose infrared sensor which can be used for obstacle sensing, color detection, fire detection, line sensing, etc and also as an encoder sensor. The sensor provides a digital output. The sensor outputs a logic one(+5V) at the digital output when an object is placed in front of the sensor and a logic zero(0V), when there is no object in front of the sensor. An onboard LED is used to indicate the presence of an object. This digital output can be directly connected to an Arduino, Raspberry Pi, AVR, PIC, 8051 or any other microcontroller to read the sensor output. IR sensors are highly susceptible to ambient light and the IR sensor on this sensor is suitably covered to reduce effect of ambient light on the sensor. The sensor has a maximum range of around 40-50 cm indoors and around 15-20 cm outdoors. Features: Can be used for obstacle sensing, color detection(between basic contrasting colors) Comes with an easy to use digital output Can be used for wireless communication and sensing IR remote signals Sensor comes with ambient light protection The sensor a hole of 3mm diameter for easy mounting', 'This IR Proximity Sensor is a multipurpose infrared sensor which can be used for obstacle sensing, color detection, fire detection, line sensing, etc and also as an encoder sensor. The sensor provides a digital output. The sensor outputs a logic one(+5V) at the digital output when an object is placed in front of the sensor and a logic zero(0V), when there is no object in front of the sensor. An onboard LED is used to indicate the presence of an object. This digital output can be directly connected to an Arduino, Raspberry Pi, AVR, PIC, 8051 or any other microcontroller to read the sensor output. IR sensors are highly susceptible to ambient light and the IR sensor on this sensor is suitably covered to reduce effect of ambient light on the sensor. The sensor has a maximum range of around 40-50 cm indoors and around 15-20 cm outdoors. Features: Can be used for obstacle sensing, color detection(between basic contrasting colors) Comes with an easy to use digital output Can be used for wireless communication and sensing IR remote signals Sensor comes with ambient light protection The sensor a hole of 3mm diameter for easy mounting', 1, 'This IR Proximity Sensor is a multipurpose infrared sensor which can be used for obstacle sensing, color detection, fire detection, line sensing, etc and also as an encoder sensor. The sensor provides a digital output. The sensor outputs a logic one(+5V) at the digital output when an object is placed in front of the sensor and a logic zero(0V), when there is no object in front of the sensor. An onboard LED is used to indicate the presence of an object. This digital output can be directly connected to an Arduino, Raspberry Pi, AVR, PIC, 8051 or any other microcontroller to read the sensor output. IR sensors are highly susceptible to ambient light and the IR sensor on this sensor is suitably covered to reduce effect of ambient light on the sensor. The sensor has a maximum range of around 40-50 cm indoors and around 15-20 cm outdoors. Features: Can be used for obstacle sensing, color detection(between basic contrasting colors) Comes with an easy to use digital output Can be used for wireless communication and sensing IR remote signals Sensor comes with ambient light protection The sensor a hole of 3mm diameter for easy mounting', 0, 0),
(21, 4, 'Corsair CV550, CV Series, 80 Plus Bronze Certified, 550 Watt Non-Modular Power Supply - Black', 'Corsair CV550, 550 Watt Non-Modular Power Supply', 5899, 2499, 12, '502702617_corsair power supply.jpg', 'Corsair CV power supplies are ideal for powering your new home or office PC, with 80 PLUS Bronze efficiency guaranteed to continuously deliver full wattage to your system. A 120 mm thermally controlled cooling fan keeps fan noise to a minimum, while a compact casing makes for an easy fit into nearly any modern PC case. Black sleeved cables and a black powder-coated casing seamlessly fit into your PCâ€™s style. CV Series power supplies are a strong start for your next new PC.', 'Corsair CV power supplies are ideal for powering your new home or office PC, with 80 PLUS Bronze efficiency guaranteed to continuously deliver full wattage to your system. A 120 mm thermally controlled cooling fan keeps fan noise to a minimum, while a compact casing makes for an easy fit into nearly any modern PC case. Black sleeved cables and a black powder-coated casing seamlessly fit into your PCâ€™s style. CV Series power supplies are a strong start for your next new PC.', 'Corsair CV power supplies are ideal for powering your new home or office PC, with 80 PLUS Bronze efficiency guaranteed to continuously deliver full wattage to your system. A 120 mm thermally controlled cooling fan keeps fan noise to a minimum, while a compact casing makes for an easy fit into nearly any modern PC case. Black sleeved cables and a black powder-coated casing seamlessly fit into your PCâ€™s style. CV Series power supplies are a strong start for your next new PC.', 'Corsair CV power supplies are ideal for powering your new home or office PC, with 80 PLUS Bronze efficiency guaranteed to continuously deliver full wattage to your system. A 120 mm thermally controlled cooling fan keeps fan noise to a minimum, while a compact casing makes for an easy fit into nearly any modern PC case. Black sleeved cables and a black powder-coated casing seamlessly fit into your PCâ€™s style. CV Series power supplies are a strong start for your next new PC.', 1, 'Corsair CV power supplies are ideal for powering your new home or office PC, with 80 PLUS Bronze efficiency guaranteed to continuously deliver full wattage to your system. A 120 mm thermally controlled cooling fan keeps fan noise to a minimum, while a compact casing makes for an easy fit into nearly any modern PC case. Black sleeved cables and a black powder-coated casing seamlessly fit into your PCâ€™s style. CV Series power supplies are a strong start for your next new PC.', 0, 0),
(22, 4, 'Metravi RPS-3005 DC Regulated Power Supply - Single Output with Backlit LCD of Variable 0-30V / 0-5A DC', 'Metravi RPS-3005 DC Regulated Power Supply', 8708, 7499, 6, '642826401_metravi power supply.jpg', 'Single Output with Backlit LCD of Variable 0 - 30V / 0 - 5A DC. Utilizes SMT Technology. Green LED Display. Voltage and Current displayed together. Multi-turn variable device to provide high precision voltage setting. Auto-tracking on PARALLEL and SERIAL working condition. Presetting the voltage and current. DC Output Switch. Extended output terminals. Continuous working under full load condition. Constant Current and Constant Voltage Protection. Short Circuit protection. input : 220 / 110V Â±10% 50~60Hz. Variable Output Voltage : 0 - 30V DC. Variable Output Current : 0 - 5A.', 'Single Output with Backlit LCD of Variable 0 - 30V / 0 - 5A DC. Utilizes SMT Technology. Green LED Display. Voltage and Current displayed together. Multi-turn variable device to provide high precision voltage setting. Auto-tracking on PARALLEL and SERIAL working condition. Presetting the voltage and current. DC Output Switch. Extended output terminals. Continuous working under full load condition. Constant Current and Constant Voltage Protection. Short Circuit protection. input : 220 / 110V Â±10% 50~60Hz. Variable Output Voltage : 0 - 30V DC. Variable Output Current : 0 - 5A.', 'Single Output with Backlit LCD of Variable 0 - 30V / 0 - 5A DC. Utilizes SMT Technology. Green LED Display. Voltage and Current displayed together. Multi-turn variable device to provide high precision voltage setting. Auto-tracking on PARALLEL and SERIAL working condition. Presetting the voltage and current. DC Output Switch. Extended output terminals. Continuous working under full load condition. Constant Current and Constant Voltage Protection. Short Circuit protection. input : 220 / 110V Â±10% 50~60Hz. Variable Output Voltage : 0 - 30V DC. Variable Output Current : 0 - 5A.', 'Single Output with Backlit LCD of Variable 0 - 30V / 0 - 5A DC. Utilizes SMT Technology. Green LED Display. Voltage and Current displayed together. Multi-turn variable device to provide high precision voltage setting. Auto-tracking on PARALLEL and SERIAL working condition. Presetting the voltage and current. DC Output Switch. Extended output terminals. Continuous working under full load condition. Constant Current and Constant Voltage Protection. Short Circuit protection. input : 220 / 110V Â±10% 50~60Hz. Variable Output Voltage : 0 - 30V DC. Variable Output Current : 0 - 5A.', 1, 'Single Output with Backlit LCD of Variable 0 - 30V / 0 - 5A DC. Utilizes SMT Technology. Green LED Display. Voltage and Current displayed together. Multi-turn variable device to provide high precision voltage setting. Auto-tracking on PARALLEL and SERIAL working condition. Presetting the voltage and current. DC Output Switch. Extended output terminals. Continuous working under full load condition. Constant Current and Constant Voltage Protection. Short Circuit protection. input : 220 / 110V Â±10% 50~60Hz. Variable Output Voltage : 0 - 30V DC. Variable Output Current : 0 - 5A.', 1, 0),
(23, 4, 'Rts International Universal All in One Worldwide Travel Adapter Wall Charger AC Power Plug Adapter with Dual USB Charging Ports for USA EU UK AUS European Cell Phone Laptop', 'Rts International Universal All in One Worldwide Travel Adapter', 4999, 1499, 2, '651976829_Universal Wall Adapter.jpg', 'This Travel Adapter is suitable for use with most 2-pole plugs. It is the safest way to plug in your portable, non-grounded devices around the world. It can be applied in a range of devices, including: MP3 players, digital cameras,mobile phones, GPS, PDAs, travel speakers, etc', 'This Travel Adapter is suitable for use with most 2-pole plugs. It is the safest way to plug in your portable, non-grounded devices around the world. It can be applied in a range of devices, including: MP3 players, digital cameras,mobile phones, GPS, PDAs, travel speakers, etc', 'This Travel Adapter is suitable for use with most 2-pole plugs. It is the safest way to plug in your portable, non-grounded devices around the world. It can be applied in a range of devices, including: MP3 players, digital cameras,mobile phones, GPS, PDAs, travel speakers, etc', 'This Travel Adapter is suitable for use with most 2-pole plugs. It is the safest way to plug in your portable, non-grounded devices around the world. It can be applied in a range of devices, including: MP3 players, digital cameras,mobile phones, GPS, PDAs, travel speakers, etc', 1, 'This Travel Adapter is suitable for use with most 2-pole plugs. It is the safest way to plug in your portable, non-grounded devices around the world. It can be applied in a range of devices, including: MP3 players, digital cameras,mobile phones, GPS, PDAs, travel speakers, etc', 1, 0),
(24, 10, 'DIY Robotic Arm with 5 Degree of Freedom (with Bluetooth Smart phone Control)', 'Robotic Arm - 5 degree freedom', 5600, 3799, 5, '543708659_DIY Robotic Arm.jpg', 'It is an compatible with Arduino Robot Arm which can be wirelessly controlled and programmed using a custom-build Android application. All 3D Parts are Printed with High Quality PLA Pro Special Filament.', 'It is an compatible with Arduino Robot Arm which can be wirelessly controlled and programmed using a custom-build Android application. All 3D Parts are Printed with High Quality PLA Pro Special Filament.', 'It is an compatible with Arduino Robot Arm which can be wirelessly controlled and programmed using a custom-build Android application. All 3D Parts are Printed with High Quality PLA Pro Special Filament.', 'It is an compatible with Arduino Robot Arm which can be wirelessly controlled and programmed using a custom-build Android application. All 3D Parts are Printed with High Quality PLA Pro Special Filament.', 1, 'It is an compatible with Arduino Robot Arm which can be wirelessly controlled and programmed using a custom-build Android application. All 3D Parts are Printed with High Quality PLA Pro Special Filament.', 1, 0),
(25, 10, 'ixora Solar Robot Kit, 13 in 1 Educatioanl STEM Learning Building Kids Toys', 'Solar Robot Kit, 13 in 1 - IXORA', 10000, 6499, 4, '747136882_solar robot kit.jpg', 'This science toys will teach children how to engineer a robot that uses solar power and through testing and operating to confirm their thinking. Helping to develop manual dexterity, problem-solving skills, improve logical thinking, self-confidence.', 'This science toys will teach children how to engineer a robot that uses solar power and through testing and operating to confirm their thinking. Helping to develop manual dexterity, problem-solving skills, improve logical thinking, self-confidence.', 'This science toys will teach children how to engineer a robot that uses solar power and through testing and operating to confirm their thinking. Helping to develop manual dexterity, problem-solving skills, improve logical thinking, self-confidence.', 'This science toys will teach children how to engineer a robot that uses solar power and through testing and operating to confirm their thinking. Helping to develop manual dexterity, problem-solving skills, improve logical thinking, self-confidence.', 1, 'This science toys will teach children how to engineer a robot that uses solar power and through testing and operating to confirm their thinking. Helping to develop manual dexterity, problem-solving skills, improve logical thinking, self-confidence.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_categories` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_categories`, `status`) VALUES
(1, 1, 'Respberry Pi', 1),
(2, 1, 'Arduino', 1),
(3, 2, 'Modules', 1),
(4, 2, 'Sensors', 1),
(5, 2, 'Display Devices', 1),
(6, 3, 'Ics', 1),
(7, 3, 'Microcontrollers', 1),
(8, 3, 'PCB & Solder', 1),
(9, 3, 'Small Components', 1),
(10, 3, 'SMD Components', 1),
(11, 4, 'Adapter', 1),
(12, 4, 'Battery', 1),
(13, 4, 'Relay', 1),
(14, 4, 'SMPS', 1),
(15, 10, 'Robot Parts', 1),
(16, 10, 'Motor', 1),
(17, 10, 'Quadcopter & Drone', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp_user`
--

CREATE TABLE `temp_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_user`
--

INSERT INTO `temp_user` (`id`, `username`, `created_on`, `last_visit`) VALUES
(1, 'user_6023d0c9f1c6c', '2021-02-10 05:55:45', '2021-02-10 05:55:45'),
(2, 'user_6023d0ca48975', '2021-02-10 05:55:46', '2021-02-10 05:55:46'),
(3, 'user_6025245ce6db7', '2021-02-11 06:04:36', '2021-02-11 06:04:36'),
(4, 'user_6025245d0c1bd', '2021-02-11 06:04:37', '2021-02-11 06:04:37'),
(5, 'user_60253de7722fe', '2021-02-11 07:53:35', '2021-02-11 07:53:35'),
(6, 'user_60253de7ab51b', '2021-02-11 07:53:35', '2021-02-11 07:53:35'),
(7, 'user_6027cbb6cf3b8', '2021-02-13 06:23:10', '2021-02-13 06:23:10'),
(8, 'user_6027cbb7016c9', '2021-02-13 06:23:11', '2021-02-13 06:23:11'),
(9, 'user_6027d3d012c35', '2021-02-13 06:57:44', '2021-02-13 06:57:44'),
(10, 'user_6027d3d0385ce', '2021-02-13 06:57:44', '2021-02-13 06:57:44'),
(11, 'user_6027d3d2c1d99', '2021-02-13 06:57:46', '2021-02-13 06:57:46'),
(12, 'user_6027d3d312129', '2021-02-13 06:57:47', '2021-02-13 06:57:47'),
(13, 'user_6027d53033a26', '2021-02-13 07:03:36', '2021-02-13 07:03:36'),
(14, 'user_6027d5304824b', '2021-02-13 07:03:36', '2021-02-13 07:03:36'),
(15, 'user_6027d597a5df4', '2021-02-13 07:05:19', '2021-02-13 07:05:19'),
(16, 'user_6027d597d0d7e', '2021-02-13 07:05:19', '2021-02-13 07:05:19'),
(17, 'user_6027d5da24eae', '2021-02-13 07:06:26', '2021-02-13 07:06:26'),
(18, 'user_6027d5da822f4', '2021-02-13 07:06:26', '2021-02-13 07:06:26'),
(19, 'user_6027d5ead75fb', '2021-02-13 07:06:42', '2021-02-13 07:06:42'),
(20, 'user_6027d5eb03762', '2021-02-13 07:06:43', '2021-02-13 07:06:43'),
(21, 'user_6027d62c78194', '2021-02-13 07:07:48', '2021-02-13 07:07:48'),
(22, 'user_6027d62ca63e6', '2021-02-13 07:07:48', '2021-02-13 07:07:48'),
(23, 'user_6027d6489bd54', '2021-02-13 07:08:16', '2021-02-13 07:08:16'),
(24, 'user_6027d648b9dd3', '2021-02-13 07:08:16', '2021-02-13 07:08:16'),
(25, 'user_6027d65317692', '2021-02-13 07:08:27', '2021-02-13 07:08:27'),
(26, 'user_6027d65328bee', '2021-02-13 07:08:27', '2021-02-13 07:08:27'),
(27, 'user_6027d6af7e438', '2021-02-13 07:09:59', '2021-02-13 07:09:59'),
(28, 'user_6027d6afa880a', '2021-02-13 07:09:59', '2021-02-13 07:09:59'),
(29, 'user_6027d74acf88d', '2021-02-13 07:12:34', '2021-02-13 07:12:34'),
(30, 'user_6027d74b1e4ad', '2021-02-13 07:12:35', '2021-02-13 07:12:35'),
(31, 'user_6027d76c53bc1', '2021-02-13 07:13:08', '2021-02-13 07:13:08'),
(32, 'user_6027d76c6a70e', '2021-02-13 07:13:08', '2021-02-13 07:13:08'),
(33, 'user_6027d9942ae38', '2021-02-13 07:22:20', '2021-02-13 07:22:20'),
(34, 'user_6027d9944f449', '2021-02-13 07:22:20', '2021-02-13 07:22:20'),
(35, 'user_6027da19bff8a', '2021-02-13 07:24:33', '2021-02-13 07:24:33'),
(36, 'user_6027da19ea744', '2021-02-13 07:24:33', '2021-02-13 07:24:33'),
(37, 'user_6027f88ca0a09', '2021-02-13 09:34:28', '2021-02-13 09:34:28'),
(38, 'user_6027f88ccd8d4', '2021-02-13 09:34:28', '2021-02-13 09:34:28'),
(39, 'user_6027f88df174d', '2021-02-13 09:34:29', '2021-02-13 09:34:29'),
(40, 'user_6027f88e468ff', '2021-02-13 09:34:30', '2021-02-13 09:34:30'),
(41, 'user_6027f89d7eed6', '2021-02-13 09:34:45', '2021-02-13 09:34:45'),
(42, 'user_6027f89d88b18', '2021-02-13 09:34:45', '2021-02-13 09:34:45'),
(43, 'user_6027f91fe68e2', '2021-02-13 09:36:55', '2021-02-13 09:36:55'),
(44, 'user_6027f9201e9b4', '2021-02-13 09:36:56', '2021-02-13 09:36:56'),
(45, 'user_6027f95de72d4', '2021-02-13 09:37:57', '2021-02-13 09:37:57'),
(46, 'user_6027f95e16aec', '2021-02-13 09:37:58', '2021-02-13 09:37:58'),
(47, 'user_6027f970d61b7', '2021-02-13 09:38:16', '2021-02-13 09:38:16'),
(48, 'user_6027f97126d17', '2021-02-13 09:38:17', '2021-02-13 09:38:17'),
(49, 'user_6027f99d4c8b4', '2021-02-13 09:39:01', '2021-02-13 09:39:01'),
(50, 'user_6027f99d6766b', '2021-02-13 09:39:01', '2021-02-13 09:39:01'),
(51, 'user_6027f9c51c459', '2021-02-13 09:39:41', '2021-02-13 09:39:41'),
(52, 'user_6027f9c548f3b', '2021-02-13 09:39:41', '2021-02-13 09:39:41'),
(53, 'user_6027fa04f20de', '2021-02-13 09:40:44', '2021-02-13 09:40:44'),
(54, 'user_6027fa051b74d', '2021-02-13 09:40:45', '2021-02-13 09:40:45'),
(55, 'user_6027fa0882499', '2021-02-13 09:40:48', '2021-02-13 09:40:48'),
(56, 'user_6027fa08997b6', '2021-02-13 09:40:48', '2021-02-13 09:40:48'),
(57, 'user_6027fa6d168f9', '2021-02-13 09:42:29', '2021-02-13 09:42:29'),
(58, 'user_6027fa6d22863', '2021-02-13 09:42:29', '2021-02-13 09:42:29'),
(59, 'user_6027fa791fc31', '2021-02-13 09:42:41', '2021-02-13 09:42:41'),
(60, 'user_6027fa792b7b4', '2021-02-13 09:42:41', '2021-02-13 09:42:41'),
(61, 'user_6027fa8502a19', '2021-02-13 09:42:53', '2021-02-13 09:42:53'),
(62, 'user_6027fa8521a38', '2021-02-13 09:42:53', '2021-02-13 09:42:53'),
(63, 'user_6027fa9020925', '2021-02-13 09:43:04', '2021-02-13 09:43:04'),
(64, 'user_6027fa90335f1', '2021-02-13 09:43:04', '2021-02-13 09:43:04'),
(65, 'user_6027fa931e2c0', '2021-02-13 09:43:07', '2021-02-13 09:43:07'),
(66, 'user_6027fa932ade3', '2021-02-13 09:43:07', '2021-02-13 09:43:07'),
(67, 'user_6027fa9dbeb89', '2021-02-13 09:43:17', '2021-02-13 09:43:17'),
(68, 'user_6027fa9de77eb', '2021-02-13 09:43:17', '2021-02-13 09:43:17'),
(69, 'user_6027faa5d8b69', '2021-02-13 09:43:25', '2021-02-13 09:43:25'),
(70, 'user_6027faa61046b', '2021-02-13 09:43:26', '2021-02-13 09:43:26'),
(71, 'user_6027fb5ddcfde', '2021-02-13 09:46:29', '2021-02-13 09:46:29'),
(72, 'user_6027fb5e09146', '2021-02-13 09:46:30', '2021-02-13 09:46:30'),
(73, 'user_6027fb9487d14', '2021-02-13 09:47:24', '2021-02-13 09:47:24'),
(74, 'user_6027fb94aa3e4', '2021-02-13 09:47:24', '2021-02-13 09:47:24'),
(75, 'user_6027fbd18a226', '2021-02-13 09:48:25', '2021-02-13 09:48:25'),
(76, 'user_6027fbd1aa5cd', '2021-02-13 09:48:25', '2021-02-13 09:48:25'),
(77, 'user_6027fc1c9dbcc', '2021-02-13 09:49:40', '2021-02-13 09:49:40'),
(78, 'user_6027fc1cb859a', '2021-02-13 09:49:40', '2021-02-13 09:49:40'),
(79, 'user_6027fc27b41be', '2021-02-13 09:49:51', '2021-02-13 09:49:51'),
(80, 'user_6027fc27cb8c4', '2021-02-13 09:49:51', '2021-02-13 09:49:51'),
(81, 'user_6027fc33a5df2', '2021-02-13 09:50:03', '2021-02-13 09:50:03'),
(82, 'user_6027fc33d24ec', '2021-02-13 09:50:03', '2021-02-13 09:50:03'),
(83, 'user_6027fd554f5ce', '2021-02-13 09:54:53', '2021-02-13 09:54:53'),
(84, 'user_6027fd5565d33', '2021-02-13 09:54:53', '2021-02-13 09:54:53'),
(85, 'user_6027ff4ed80fb', '2021-02-13 10:03:18', '2021-02-13 10:03:18'),
(86, 'user_6027ff4ee53ee', '2021-02-13 10:03:18', '2021-02-13 10:03:18'),
(87, 'user_6027ff653fc92', '2021-02-13 10:03:41', '2021-02-13 10:03:41'),
(88, 'user_6027ff6550e06', '2021-02-13 10:03:41', '2021-02-13 10:03:41'),
(89, 'user_6027ff7c019a7', '2021-02-13 10:04:04', '2021-02-13 10:04:04'),
(90, 'user_6027ff7c10fc3', '2021-02-13 10:04:04', '2021-02-13 10:04:04'),
(91, 'user_6027ffbf335eb', '2021-02-13 10:05:11', '2021-02-13 10:05:11'),
(92, 'user_6027ffbf40cc6', '2021-02-13 10:05:11', '2021-02-13 10:05:11'),
(93, 'user_6027ffd3b0e69', '2021-02-13 10:05:31', '2021-02-13 10:05:31'),
(94, 'user_6027ffd3bba4b', '2021-02-13 10:05:31', '2021-02-13 10:05:31'),
(95, 'user_6027ffff182f9', '2021-02-13 10:06:15', '2021-02-13 10:06:15'),
(96, 'user_6027ffff5112f', '2021-02-13 10:06:15', '2021-02-13 10:06:15'),
(97, 'user_6028000e366d2', '2021-02-13 10:06:30', '2021-02-13 10:06:30'),
(98, 'user_6028000e47c2e', '2021-02-13 10:06:30', '2021-02-13 10:06:30'),
(99, 'user_6028002b2928a', '2021-02-13 10:06:59', '2021-02-13 10:06:59'),
(100, 'user_6028002b34e0d', '2021-02-13 10:06:59', '2021-02-13 10:06:59'),
(101, 'user_60280095044e8', '2021-02-13 10:08:45', '2021-02-13 10:08:45'),
(102, 'user_602800950ece3', '2021-02-13 10:08:45', '2021-02-13 10:08:45'),
(103, 'user_602800be69f59', '2021-02-13 10:09:26', '2021-02-13 10:09:26'),
(104, 'user_602800beafc99', '2021-02-13 10:09:26', '2021-02-13 10:09:26'),
(105, 'user_602800e781ba0', '2021-02-13 10:10:07', '2021-02-13 10:10:07'),
(106, 'user_602800e796b95', '2021-02-13 10:10:07', '2021-02-13 10:10:07'),
(107, 'user_6028011073295', '2021-02-13 10:10:48', '2021-02-13 10:10:48'),
(108, 'user_602801108a99b', '2021-02-13 10:10:48', '2021-02-13 10:10:48'),
(109, 'user_602801339363f', '2021-02-13 10:11:23', '2021-02-13 10:11:23'),
(110, 'user_60280133ab8fd', '2021-02-13 10:11:23', '2021-02-13 10:11:23'),
(111, 'user_6028014611087', '2021-02-13 10:11:42', '2021-02-13 10:11:42'),
(112, 'user_602801462972d', '2021-02-13 10:11:42', '2021-02-13 10:11:42'),
(113, 'user_602801544635c', '2021-02-13 10:11:56', '2021-02-13 10:11:56'),
(114, 'user_602801545de4a', '2021-02-13 10:11:56', '2021-02-13 10:11:56'),
(115, 'user_6028016c2806a', '2021-02-13 10:12:20', '2021-02-13 10:12:20'),
(116, 'user_6028016c38df6', '2021-02-13 10:12:20', '2021-02-13 10:12:20'),
(117, 'user_602801f0685f7', '2021-02-13 10:14:32', '2021-02-13 10:14:32'),
(118, 'user_602801f078f9b', '2021-02-13 10:14:32', '2021-02-13 10:14:32'),
(119, 'user_602802365786f', '2021-02-13 10:15:42', '2021-02-13 10:15:42'),
(120, 'user_602802367ba97', '2021-02-13 10:15:42', '2021-02-13 10:15:42'),
(121, 'user_602802552b47a', '2021-02-13 10:16:13', '2021-02-13 10:16:13'),
(122, 'user_602802553aa95', '2021-02-13 10:16:13', '2021-02-13 10:16:13'),
(123, 'user_602802d9a483c', '2021-02-13 10:18:25', '2021-02-13 10:18:25'),
(124, 'user_602802d9b2eb7', '2021-02-13 10:18:25', '2021-02-13 10:18:25'),
(125, 'user_6028036962a69', '2021-02-13 10:20:49', '2021-02-13 10:20:49'),
(126, 'user_6028036969f9a', '2021-02-13 10:20:49', '2021-02-13 10:20:49'),
(127, 'user_6028037dc5148', '2021-02-13 10:21:09', '2021-02-13 10:21:09'),
(128, 'user_6028037dcf55a', '2021-02-13 10:21:09', '2021-02-13 10:21:09'),
(129, 'user_602803d418f20', '2021-02-13 10:22:36', '2021-02-13 10:22:36'),
(130, 'user_602803d421009', '2021-02-13 10:22:36', '2021-02-13 10:22:36'),
(131, 'user_602803d52b83d', '2021-02-13 10:22:37', '2021-02-13 10:22:37'),
(132, 'user_602803d541002', '2021-02-13 10:22:37', '2021-02-13 10:22:37'),
(133, 'user_60280416ae8ea', '2021-02-13 10:23:42', '2021-02-13 10:23:42'),
(134, 'user_60280416bb7f5', '2021-02-13 10:23:42', '2021-02-13 10:23:42'),
(135, 'user_6028042398c3c', '2021-02-13 10:23:55', '2021-02-13 10:23:55'),
(136, 'user_60280423ab520', '2021-02-13 10:23:55', '2021-02-13 10:23:55'),
(137, 'user_60280426b791f', '2021-02-13 10:23:58', '2021-02-13 10:23:58'),
(138, 'user_60280426ce854', '2021-02-13 10:23:58', '2021-02-13 10:23:58'),
(139, 'user_6028051f697ff', '2021-02-13 10:28:07', '2021-02-13 10:28:07'),
(140, 'user_6028051f7f3ac', '2021-02-13 10:28:07', '2021-02-13 10:28:07'),
(141, 'user_602805da68efe', '2021-02-13 10:31:14', '2021-02-13 10:31:14'),
(142, 'user_602805da7d33b', '2021-02-13 10:31:14', '2021-02-13 10:31:14'),
(143, 'user_6028068023b7d', '2021-02-13 10:34:00', '2021-02-13 10:34:00'),
(144, 'user_60280680321f8', '2021-02-13 10:34:00', '2021-02-13 10:34:00'),
(145, 'user_6028076e589ae', '2021-02-13 10:37:58', '2021-02-13 10:37:58'),
(146, 'user_6028076e7f2e7', '2021-02-13 10:37:58', '2021-02-13 10:37:58'),
(147, 'user_602807a2dfdc4', '2021-02-13 10:38:50', '2021-02-13 10:38:50'),
(148, 'user_602807a30616a', '2021-02-13 10:38:51', '2021-02-13 10:38:51'),
(149, 'user_602807c467f78', '2021-02-13 10:39:24', '2021-02-13 10:39:24'),
(150, 'user_602807c495de3', '2021-02-13 10:39:24', '2021-02-13 10:39:24'),
(151, 'user_602807ccf283a', '2021-02-13 10:39:32', '2021-02-13 10:39:32'),
(152, 'user_602807cd0a17d', '2021-02-13 10:39:33', '2021-02-13 10:39:33'),
(153, 'user_602807e315632', '2021-02-13 10:39:55', '2021-02-13 10:39:55'),
(154, 'user_602807e349e16', '2021-02-13 10:39:55', '2021-02-13 10:39:55'),
(155, 'user_60280817ad004', '2021-02-13 10:40:47', '2021-02-13 10:40:47'),
(156, 'user_60280817cdf64', '2021-02-13 10:40:47', '2021-02-13 10:40:47'),
(157, 'user_6028081bd2699', '2021-02-13 10:40:51', '2021-02-13 10:40:51'),
(158, 'user_6028081bec0c7', '2021-02-13 10:40:51', '2021-02-13 10:40:51'),
(159, 'user_6028084a4ff53', '2021-02-13 10:41:38', '2021-02-13 10:41:38'),
(160, 'user_6028084a637d8', '2021-02-13 10:41:38', '2021-02-13 10:41:38'),
(161, 'user_6028085a51a57', '2021-02-13 10:41:54', '2021-02-13 10:41:54'),
(162, 'user_6028085a652db', '2021-02-13 10:41:54', '2021-02-13 10:41:54'),
(163, 'user_602808cd3e414', '2021-02-13 10:43:49', '2021-02-13 10:43:49'),
(164, 'user_602808cd53021', '2021-02-13 10:43:49', '2021-02-13 10:43:49'),
(165, 'user_6028091b3c2b9', '2021-02-13 10:45:07', '2021-02-13 10:45:07'),
(166, 'user_6028091b77416', '2021-02-13 10:45:07', '2021-02-13 10:45:07'),
(167, 'user_60280932ad88f', '2021-02-13 10:45:30', '2021-02-13 10:45:30'),
(168, 'user_60280932e051b', '2021-02-13 10:45:30', '2021-02-13 10:45:30'),
(169, 'user_602809687eec4', '2021-02-13 10:46:24', '2021-02-13 10:46:24'),
(170, 'user_602809688871f', '2021-02-13 10:46:24', '2021-02-13 10:46:24'),
(171, 'user_602809fe03473', '2021-02-13 10:48:54', '2021-02-13 10:48:54'),
(172, 'user_602809fe15587', '2021-02-13 10:48:54', '2021-02-13 10:48:54'),
(173, 'user_60280a04e9d80', '2021-02-13 10:49:00', '2021-02-13 10:49:00'),
(174, 'user_60280a05068cc', '2021-02-13 10:49:01', '2021-02-13 10:49:01'),
(175, 'user_60280a3146668', '2021-02-13 10:49:45', '2021-02-13 10:49:45'),
(176, 'user_60280a3160096', '2021-02-13 10:49:45', '2021-02-13 10:49:45'),
(177, 'user_60280a37d87d1', '2021-02-13 10:49:51', '2021-02-13 10:49:51'),
(178, 'user_60280a380aae2', '2021-02-13 10:49:52', '2021-02-13 10:49:52'),
(179, 'user_60280a39838d0', '2021-02-13 10:49:53', '2021-02-13 10:49:53'),
(180, 'user_60280a39aa5f1', '2021-02-13 10:49:53', '2021-02-13 10:49:53'),
(181, 'user_60280a7c409c8', '2021-02-13 10:51:00', '2021-02-13 10:51:00'),
(182, 'user_60280a7c61d10', '2021-02-13 10:51:00', '2021-02-13 10:51:00'),
(183, 'user_60280a95d27a0', '2021-02-13 10:51:25', '2021-02-13 10:51:25'),
(184, 'user_60280a95f2760', '2021-02-13 10:51:25', '2021-02-13 10:51:25'),
(185, 'user_60280b73425a0', '2021-02-13 10:55:07', '2021-02-13 10:55:07'),
(186, 'user_60280b735b416', '2021-02-13 10:55:07', '2021-02-13 10:55:07'),
(187, 'user_60280b8ae0659', '2021-02-13 10:55:30', '2021-02-13 10:55:30'),
(188, 'user_60280b8b0eae9', '2021-02-13 10:55:31', '2021-02-13 10:55:31'),
(189, 'user_60280b90bd140', '2021-02-13 10:55:36', '2021-02-13 10:55:36'),
(190, 'user_60280b90ca04b', '2021-02-13 10:55:36', '2021-02-13 10:55:36'),
(191, 'user_60280bea42caf', '2021-02-13 10:57:06', '2021-02-13 10:57:06'),
(192, 'user_60280bea618e6', '2021-02-13 10:57:06', '2021-02-13 10:57:06'),
(193, 'user_60280bfa057d3', '2021-02-13 10:57:22', '2021-02-13 10:57:22'),
(194, 'user_60280bfa28e44', '2021-02-13 10:57:22', '2021-02-13 10:57:22'),
(195, 'user_60280c101898a', '2021-02-13 10:57:44', '2021-02-13 10:57:44'),
(196, 'user_60280c1057969', '2021-02-13 10:57:44', '2021-02-13 10:57:44'),
(197, 'user_60280c15c5489', '2021-02-13 10:57:49', '2021-02-13 10:57:49'),
(198, 'user_60280c15d9cad', '2021-02-13 10:57:49', '2021-02-13 10:57:49'),
(199, 'user_60280c7b58599', '2021-02-13 10:59:31', '2021-02-13 10:59:31'),
(200, 'user_60280c7b68b55', '2021-02-13 10:59:31', '2021-02-13 10:59:31'),
(201, 'user_60280c87a993b', '2021-02-13 10:59:43', '2021-02-13 10:59:43'),
(202, 'user_60280c87c2f80', '2021-02-13 10:59:43', '2021-02-13 10:59:43'),
(203, 'user_60280cb8ef5b6', '2021-02-13 11:00:32', '2021-02-13 11:00:32'),
(204, 'user_60280cb91d275', '2021-02-13 11:00:33', '2021-02-13 11:00:33'),
(205, 'user_60280ccd26f48', '2021-02-13 11:00:53', '2021-02-13 11:00:53'),
(206, 'user_60280ccd307a2', '2021-02-13 11:00:53', '2021-02-13 11:00:53'),
(207, 'user_60280cd1d49ad', '2021-02-13 11:00:57', '2021-02-13 11:00:57'),
(208, 'user_60280cd1f031c', '2021-02-13 11:00:57', '2021-02-13 11:00:57'),
(209, 'user_60280ce74bf0f', '2021-02-13 11:01:19', '2021-02-13 11:01:19'),
(210, 'user_60280ce765555', '2021-02-13 11:01:19', '2021-02-13 11:01:19'),
(211, 'user_60280d2c635e0', '2021-02-13 11:02:28', '2021-02-13 11:02:28'),
(212, 'user_60280d2c7d00e', '2021-02-13 11:02:28', '2021-02-13 11:02:28'),
(213, 'user_60280d40c2043', '2021-02-13 11:02:48', '2021-02-13 11:02:48'),
(214, 'user_60280d40cbc85', '2021-02-13 11:02:48', '2021-02-13 11:02:48'),
(215, 'user_60280e2243cdd', '2021-02-13 11:06:34', '2021-02-13 11:06:34'),
(216, 'user_60280e224e4d7', '2021-02-13 11:06:34', '2021-02-13 11:06:34'),
(217, 'user_60280e2b705da', '2021-02-13 11:06:43', '2021-02-13 11:06:43'),
(218, 'user_60280e2b7b5a4', '2021-02-13 11:06:43', '2021-02-13 11:06:43'),
(219, 'user_60280e43daa9f', '2021-02-13 11:07:07', '2021-02-13 11:07:07'),
(220, 'user_60280e4417d7b', '2021-02-13 11:07:08', '2021-02-13 11:07:08'),
(221, 'user_60280f2c45cf3', '2021-02-13 11:11:00', '2021-02-13 11:11:00'),
(222, 'user_60280f2c4ed7e', '2021-02-13 11:11:00', '2021-02-13 11:11:00'),
(223, 'user_602d2b9a4875f', '2021-02-17 08:13:38', '2021-02-17 08:13:38'),
(224, 'user_602d2b9a74a72', '2021-02-17 08:13:38', '2021-02-17 08:13:38'),
(225, 'user_602e29107b985', '2021-02-18 02:15:04', '2021-02-18 02:15:04'),
(226, 'user_602e29111c616', '2021-02-18 02:15:05', '2021-02-18 02:15:05'),
(227, 'user_602e29135a6b8', '2021-02-18 02:15:07', '2021-02-18 02:15:07'),
(228, 'user_602e2913d28b4', '2021-02-18 02:15:07', '2021-02-18 02:15:07'),
(229, 'user_602e29156b89e', '2021-02-18 02:15:09', '2021-02-18 02:15:09'),
(230, 'user_602e291596058', '2021-02-18 02:15:09', '2021-02-18 02:15:09'),
(231, 'user_602f79109b92a', '2021-02-19 02:08:40', '2021-02-19 02:08:40'),
(232, 'user_602f7910b7680', '2021-02-19 02:08:40', '2021-02-19 02:08:40'),
(233, 'user_602f7959d24e6', '2021-02-19 02:09:53', '2021-02-19 02:09:53'),
(234, 'user_602f795a0152e', '2021-02-19 02:09:54', '2021-02-19 02:09:54'),
(235, 'user_60308336aa0f1', '2021-02-20 09:04:14', '2021-02-20 09:04:14'),
(236, 'user_60308336d7f5c', '2021-02-20 09:04:14', '2021-02-20 09:04:14'),
(237, 'user_60308394e9249', '2021-02-20 09:05:48', '2021-02-20 09:05:48'),
(238, 'user_603083950bb56', '2021-02-20 09:05:49', '2021-02-20 09:05:49'),
(239, 'user_6030cf995fcc2', '2021-02-20 02:30:09', '2021-02-20 02:30:09'),
(240, 'user_6030cf9985e22', '2021-02-20 02:30:09', '2021-02-20 02:30:09'),
(241, 'user_6032b7085c877', '2021-02-22 01:09:52', '2021-02-22 01:09:52'),
(242, 'user_6032b708687e2', '2021-02-22 01:09:52', '2021-02-22 01:09:52'),
(243, 'user_6032e7ad79b09', '2021-02-22 04:37:25', '2021-02-22 04:37:25'),
(244, 'user_6032e7ad9aa68', '2021-02-22 04:37:25', '2021-02-22 04:37:25'),
(245, 'user_603486d140837', '2021-02-23 10:08:41', '2021-02-23 10:08:41'),
(246, 'user_603486d155c14', '2021-02-23 10:08:41', '2021-02-23 10:08:41'),
(247, 'user_6035f9ab9ae3f', '2021-02-24 12:30:59', '2021-02-24 12:30:59'),
(248, 'user_6035f9abccb2a', '2021-02-24 12:30:59', '2021-02-24 12:30:59'),
(249, 'user_6036951e09431', '2021-02-24 11:34:14', '2021-02-24 11:34:14'),
(250, 'user_6036951e2a779', '2021-02-24 11:34:14', '2021-02-24 11:34:14'),
(251, 'user_6037a311016f3', '2021-02-25 06:46:01', '2021-02-25 06:46:01'),
(252, 'user_6037a3111ff42', '2021-02-25 06:46:01', '2021-02-25 06:46:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_loggedin`
--
ALTER TABLE `admin_loggedin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_user`
--
ALTER TABLE `temp_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `admin_loggedin`
--
ALTER TABLE `admin_loggedin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `temp_user`
--
ALTER TABLE `temp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
