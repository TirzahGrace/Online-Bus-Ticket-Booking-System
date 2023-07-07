-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 10, 2023 at 06:22 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `OBTBS`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(100) NOT NULL,
  `booking_id` varchar(255) NOT NULL DEFAULT '',
  `customer_id` varchar(255) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `customer_route` varchar(200) NOT NULL,
  `booked_amount` int(100) NOT NULL,
  `booked_seat` varchar(100) NOT NULL,
  `booking_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_id`, `customer_id`, `route_id`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES
(61, 'QK0MT61', 'CUST-2017936', 'RT-9941455', 'EDROISCHESTER &rarr; BRUGOW', 110, '15', '2021-10-17 22:36:10'),
(67, '1L2HJ0', 'CUST-8996235', 'RT-196990', 'HYD &rarr; DEL', 125, '14', '2023-04-09 22:05:45'),
(69, '9AL0M0', 'CUST-2114034', 'RT-162290', 'HYD &rarr; DEL', 132, '17', '2023-04-09 22:12:19'),
(71, 'BN4PL0', 'CUST-2114034', 'RT-775557', 'ENCEFORD &rarr; VLIRGINIA', 131, '4', '2023-04-10 10:29:34'),
(73, 'QJUWW0', 'CUST-8996235', 'RT-162290', 'HYD &rarr; DEL', 132, '16', '2023-04-10 10:34:17'),
(74, 'CUKS60', 'CUST-2017936', 'RT-775557', 'ENCEFORD &rarr; VLIRGINIA', 131, '26', '2023-04-10 10:41:46'),
(75, 'GEGUA0', 'CUST-9474738', 'RT-6028759', 'BELRITH &rarr; ARKBY', 166, '25', '2023-04-10 10:42:11'),
(76, '3YA5U0', 'CUST-5585037', 'RT-6028759', 'BELRITH &rarr; ARKBY', 166, '14', '2023-04-10 10:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(100) NOT NULL,
  `bus_no` varchar(255) NOT NULL,
  `bus_assigned` tinyint(1) NOT NULL DEFAULT '0',
  `bus_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_no`, `bus_assigned`, `bus_created`) VALUES
(44, 'MVL1000', 0, '2021-10-16 22:05:16'),
(45, 'ABC0010', 1, '2021-10-17 22:32:46'),
(46, 'XYZ7890', 0, '2021-10-17 22:33:15'),
(47, 'BCC9999', 1, '2021-10-17 22:33:22'),
(48, 'RDH4255', 1, '2021-10-17 22:33:36'),
(49, 'TTH8888', 1, '2021-10-18 00:05:32'),
(50, 'MMM9969', 0, '2021-10-18 00:06:02'),
(51, 'LLL7699', 1, '2021-10-18 00:06:42'),
(52, 'SSX6633', 0, '2021-10-18 00:06:52'),
(53, 'NBS4455', 0, '2021-10-18 09:27:49'),
(56, 'MA45235', 0, '2023-03-27 00:13:50'),
(59, 'TS32454', 0, '2023-03-27 17:20:01'),
(60, 'CAS3304', 0, '2023-04-02 02:05:39'),
(61, 'CSS3308', 1, '2023-04-02 21:07:24'),
(62, 'AP12345', 0, '2023-04-03 09:09:35'),
(66, 'BCC99983', 1, '2023-04-03 11:26:47'),
(69, 'AB1267894', 0, '2023-04-07 22:52:54'),
(71, 'AP23434', 1, '2023-04-08 22:39:25'),
(72, 'AP23439', 1, '2023-04-08 22:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_id`, `customer_name`, `customer_phone`, `customer_password`, `customer_created`) VALUES
(34, 'CUST-2114034', 'Dfirst Dlast', '7002001200', 'ritesh', '2021-10-16 22:09:12'),
(35, 'CUST-8996235', 'Willian Hobbs', '4012222222', 'ritesh', '2021-10-17 22:30:23'),
(36, 'CUST-2017936', 'George Watts', '7011111111', 'ritesh', '2021-10-17 22:30:53'),
(37, 'CUST-5585037', 'Bobb Horn', '1111111110', 'ritesh', '2021-10-17 22:31:20'),
(38, 'CUST-9474738', 'Alan Moore', '7900000000', 'ritesh', '2021-10-18 09:32:02'),
(39, 'CUST-4031139', 'Jamie Rhoades', '1003000010', 'ritesh', '2021-10-18 09:33:08'),
(40, 'CUST-9997540', 'Demo Customer1', '7777777709', 'ritesh', '2021-10-18 09:39:10'),
(41, 'CUST-0', 'KEERTHI GJHK', '7777777709', 'ritesh', '2023-03-26 22:51:41'),
(44, 'CUST-891320', 'Demo Tapaswini', '34678906', 'ritesh', '2023-03-27 00:19:56'),
(45, 'CUST-524180', 'Demo GJHK', '34678906', 'ritesh', '2023-03-27 00:26:45'),
(48, 'CUST-65470', 'KEERTHI ', '7777777709', 'ritesh', '2023-03-27 11:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(100) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `bus_no` varchar(155) NOT NULL,
  `route_cities` varchar(255) NOT NULL,
  `route_from` varchar(255) NOT NULL,
  `route_to` varchar(255) NOT NULL,
  `route_dep_date` date NOT NULL,
  `route_journey_time` int(100) NOT NULL DEFAULT 0,
  `route_dep_time` time NOT NULL,
  `route_step_cost` int(100) NOT NULL,
  `route_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `route_id`, `bus_no`, `route_cities`, `route_from`, `route_to`, `route_dep_date`, `route_dep_time`, `route_step_cost`, `route_created`) VALUES
(55, 'RT-9941455', 'RDH4255', 'EDROISCHESTER,BRUGOW', 'EDROISCHESTER', 'BRUGOW', '2023-09-18', '10:00:00', 110, '2021-10-17 22:34:47'),
(56, 'RT-9069556', 'XYZ7890', 'ANTALAND,ZREGOW', 'ANTALAND', 'ZREGOW', '2023-10-19', '11:40:00', 85, '2021-10-17 23:39:57'),
(57, 'RT-775557', 'ABC0010', 'ENCEFORD,VLIRGINIA', 'ENCEFORD', 'VLIRGINIA', '2023-10-19', '13:30:00', 131, '2021-10-17 23:42:12'),
(58, 'RT-753558', 'TTH8888', 'ARKBY,VEIM', 'ARKBY', 'VEIM', '2023-10-20', '12:04:00', 55, '2021-10-18 00:04:42'),
(59, 'RT-6028759', 'LLL7699', 'BELRITH,ARKBY', 'BELRITH', 'ARKBY', '2023-10-20', '13:50:00', 166, '2021-10-18 00:07:50'),
(60, 'RT-5887160', 'CAS3304', 'FLORIA,BRISBANE', 'FLORIA', 'BRISBANE', '2023-03-31', '22:30:00', 125, '2021-10-18 09:38:30'),
(61, 'RT-196990', 'CSS3308', 'HYD,DEL', 'HYD', 'DEL', '2023-04-06', '11:23:00', 125, '2023-03-27 11:27:48'),
(63, 'RT-841490', 'BCC9998', 'HYD,KGPJN', 'HYD', 'KGPJN', '2023-04-19', '14:54:00', 100, '2023-04-01 23:54:17'),
(64, 'RT-843130', 'AP23434', 'HYD,BGL', 'HYD', 'BGL', '2023-04-21', '23:36:00', 145, '2023-04-03 11:32:39'),
(65, 'RT-162290', 'AP23439', 'HYD,DEL', 'HYD', 'DEL', '2023-04-19', '10:42:00', 132, '2023-04-08 22:39:53'),
(66, 'RT-894190', 'CSS3308', 'VIZAG,TIRUPATHI', 'VIZAG', 'TIRUPATHI', '2023-04-13', '22:24:00', 123, '2023-04-09 22:20:03'),
(67, 'RT-803470', 'BCC9999', 'VIJAG,DEL', 'VIJAG', 'DEL', '2023-04-20', '22:26:00', 235, '2023-04-09 22:25:40'),
(68, 'RT-445740', 'BCC99983', 'VIZAG,GWD', 'VIZAG', 'GWD', '2023-04-29', '03:51:00', 234, '2023-04-10 11:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `route_id` varchar(155) NOT NULL,
  `seat_booked` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`route_id`, `seat_booked`) VALUES
('RT-162290', '17,16'),
('RT-196990', '14'),
('RT-5887160', '16'),
('RT-6028759', '25,14'),
('RT-753558', NULL),
('RT-775557', '4,26'),
('RT-841490', NULL),
('RT-843130', ''),
('RT-9069556', NULL),
('RT-9941455', '15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_name`, `user_password`, `user_created`) VALUES
(21, 'B Ambika', 'ambika', '$2y$10$q05DXUrLwBVVOK18ZO6UZ.Id3ekYw5GGi/QM8aGBGQG7jq5IvS0oq', '2023-04-08 15:37:12'),
(22, 'Sourangshu B', 'admin', 'WvcRwG03iy48o', '2023-04-08 19:12:30'),
(27, 'chchjkj', 'check', 'IQ3V1.4g3mxS2', '2023-04-10 01:39:56'),
(29, 'Tapaswini', 'ta43', '$2y$10$0k8gaz68c8eLGq9/GxgMZu5FIsuZ/G35Mj30IxKi3vhOahLpxBr.G', '2023-04-10 11:44:12'),
(30, 'Tapaswini', 'Admin', '$2y$10$di6MXFscV2XJgmMROlhty.Q2nVVZ1DkyW3WQkRlLDHMxmVSD4FSz.', '2023-04-10 11:49:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
