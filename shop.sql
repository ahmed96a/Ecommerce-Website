-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2018 at 07:58 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id6692548_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=> true, 0=> false',
  `comment` tinyint(1) NOT NULL DEFAULT '1',
  `ads` tinyint(4) NOT NULL DEFAULT '1',
  `parent` int(11) NOT NULL DEFAULT '0' COMMENT 'if 0=> the category is main ,, if != 0 => the category is sub and that num represnt the id of the main category that the sub belong to'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `visibility`, `comment`, `ads`, `parent`) VALUES
(7, 'Pc Games', 'For Computer Games', 1, 1, 1, 0),
(8, 'Computers', 'Computer Items', 1, 1, 1, 0),
(9, 'Smart Phones', 'Smart phones', 1, 1, 1, 0),
(10, 'Clothing', 'different types of clothes', 1, 1, 1, 0),
(11, 'Tools', 'Home Tools', 1, 1, 1, 0),
(12, 'Nokia', 'Nokia Phones', 1, 1, 1, 9),
(13, 'Samsung', 'Samsung Phones', 1, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `itemId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `status`, `date`, `itemId`, `memberId`) VALUES
(1, 'It''s Good', 1, '2018-07-10', 4, 2),
(2, 'Asd', 1, '2018-08-01', 4, 13),
(3, 'Asd', 1, '2018-08-01', 4, 13),
(4, 'A Good Item A Good Item A Good Item A Good Item A Good Item', 1, '2018-08-01', 4, 13),
(5, 'Very Good Item', 1, '2018-08-01', 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `price` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `country` varchar(50) NOT NULL,
  `image` int(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `catId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `tags` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `date`, `country`, `image`, `status`, `rating`, `catId`, `memberId`, `approve`, `tags`) VALUES
(1, 'Hard Disk SD2000', 'hard disk with 2000 GB {SD} hard disk with 2000 GB {SD} hard disk with 2000 GB {SD} hard disk with 2000 GB {SD}', '1500$', '2018-07-29', 'Egypt', 0, 'New', 0, 8, 2, 1, ''),
(2, 'Keyboard silver200', 'Keyboard type silver 200', '110$', '2018-07-29', 'Canada', 0, 'Used', 0, 8, 3, 1, ''),
(3, 'Trausours', 'Trauosures m32', '60$', '2018-07-29', 'Egypt', 0, 'New', 0, 10, 1, 1, ''),
(4, 'Mouse 99', 'Mouse type 99', '50$', '2018-07-29', 'Italy', 0, 'New', 0, 8, 1, 0, ''),
(5, 'Network Cable', 'Network Cable Lan 1235', '30$', '2018-07-29', 'Canada', 0, 'New', 0, 8, 3, 0, ''),
(6, 'Mic 2300', 'Mic 2300 italy made', '1500$', '2018-07-29', 'Italy', 0, 'New', 0, 8, 2, 0, ''),
(7, 'Car BMW', 'A Good Car', '5000', '2018-07-31', 'USA', 0, 'New', 0, 11, 13, 1, ''),
(8, 'A', 'Golden Edition', '50$', '2018-08-01', 'Egypt', 0, 'New', 0, 10, 2, 0, ''),
(9, 'b', 'kklkj', '150$', '2018-08-01', 'Egypt', 0, 'New', 0, 10, 2, 0, ''),
(10, 'm', ';kjlkjlkjlkj ;kjlkjlkjlkj ;kjlkjlkjlkj ;kjlkjlkjlkj ;kjlkjlkjlkj;kjlkjlkjlkj;kjlkjlkjlkj', '150$', '2018-08-01', 'Egypt', 0, 'New', 0, 10, 2, 1, ''),
(11, 'Diablo 3', 'RBG game', '110$', '2018-08-04', 'Egypt', 0, 'New', 0, 7, 13, 1, 'rbg, game, discount'),
(12, 'clow', 'Golden Edition', '150$', '2018-08-04', 'Egypt', 0, 'New', 0, 7, 1, 1, 'game ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fullName` varchar(60) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT '0' COMMENT 'Identity the user permissons {1 => Admin, 0 => User}',
  `trustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `regStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Accepting {1 => Accepted, 0 => Decline}',
  `regDate` date NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `email`, `fullName`, `permission`, `trustStatus`, `regStatus`, `regDate`, `image`) VALUES
(1, 'Ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'asd96@gmail.com', 'Ahmed Asd', 1, 0, 1, '2018-07-23', ''),
(2, 'Assad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Assad@gmail.com', 'Assad Ali', 0, 1, 1, '2018-05-09', ''),
(3, 'Fathi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'fathi@gmail.com', 'Fathi Asd', 1, 1, 1, '2018-07-23', ''),
(4, 'Qassem', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Q@gmail.com', 'Qassem Ali', 0, 0, 1, '2018-07-24', ''),
(5, 'Yasser', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'yasser@gmail.com', 'Yasser', 0, 0, 1, '2018-07-24', ''),
(13, 'Asd', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Asd@gmail.com', 'Asd', 0, 0, 0, '2018-07-30', ''),
(16, 'Youssef', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Youssef@gmail.com', 'Youssef Ali', 1, 0, 0, '2018-08-04', '654633_hqdefault.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_items_itemId` (`itemId`),
  ADD KEY `comments_users_memberId` (`memberId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `items_users_memberId` (`memberId`),
  ADD KEY `items_categories_catId` (`catId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_items_itemId` FOREIGN KEY (`itemId`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_users_memberId` FOREIGN KEY (`memberId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_categories_catId` FOREIGN KEY (`catId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_users_memberId` FOREIGN KEY (`memberId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
