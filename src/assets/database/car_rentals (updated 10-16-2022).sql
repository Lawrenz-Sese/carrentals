-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2022 at 07:14 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rentals`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_email` text NOT NULL,
  `user_password` text NOT NULL,
  `user_fname` text NOT NULL,
  `user_mname` text NOT NULL,
  `user_lname` text NOT NULL,
  `user_contact` int(11) NOT NULL,
  `user_address` text NOT NULL,
  `user_type` text NOT NULL DEFAULT 'user',
  `userAddedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `isVerified` int(1) NOT NULL DEFAULT 0,
  `rider_license` text NOT NULL,
  `rider_registration` text NOT NULL,
  `isAllowedToBook` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_email`, `user_password`, `user_fname`, `user_mname`, `user_lname`, `user_contact`, `user_address`, `user_type`, `userAddedDate`, `isVerified`, `rider_license`, `rider_registration`, `isAllowedToBook`) VALUES
(1, 'sejey54@gmail.com', '$2y$10$OWRjODkxMzFlNTU2YmY4N.fjh5p2hR1lAD9Bkv75S6yYJiLOyq8aa', 'hello', 'john', 'doe', 2147483647, 'sample address', 'user', '2022-10-15 14:20:30', 0, '', '', 0),
(2, 'chrisjohn.ifl@gmail.com', '$2y$10$M2I5ZmU4MDIzMjhiMzRkYuyxb8fO5NzSl23yChbFBO4hh3kIwFzqa', 'John', 'Hello', 'Doe', 2147483647, 'sample address', 'rider', '2022-10-15 23:47:43', 0, 'C:fakepath7b88e682860d4362b5a3cdb74b92ee96 (1).png', 'C:fakepath7b88e682860d4362b5a3cdb74b92ee96.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userverification`
--

CREATE TABLE `tbl_userverification` (
  `user_verification_id` int(11) NOT NULL,
  `user_otp` text NOT NULL,
  `user_email` text NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_userverification`
--

INSERT INTO `tbl_userverification` (`user_verification_id`, `user_otp`, `user_email`, `dateAdded`) VALUES
(1, 'aa439d', 'sejey54@gmail.com', '2022-10-15 06:20:30'),
(2, '8420c4', 'chrisjohn.ifl@gmail.com', '2022-10-15 15:47:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_userverification`
--
ALTER TABLE `tbl_userverification`
  ADD PRIMARY KEY (`user_verification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_userverification`
--
ALTER TABLE `tbl_userverification`
  MODIFY `user_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
