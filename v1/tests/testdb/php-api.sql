-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 07, 2023 at 05:29 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `city`, `country`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Ex exercitation et occaecat excepteur nostrud aute voluptate elit.', 'Dupuyer', 'Bahamas', '2024-04-07', '2024-05-11', '2023-06-05 13:02:10', '2023-06-05 13:02:10'),
(2, 'Laboris nostrud magna consectetur fugiat ea est ut ad id aliqua do aliqua labore sunt.', 'Gorham', 'Greece', '2024-04-25', '2024-05-15', '2023-06-05 13:02:10', '2023-06-05 13:02:10'),
(3, 'Ad sit amet esse dolore fugiat consequat irure in consectetur cupidatat voluptate', 'Somerset', 'Mayotte', '2024-04-26', '2024-05-12', '2023-06-05 13:03:54', '2023-06-05 13:03:54'),
(4, 'Ex elit consequat laborum non ad ad commodo est ad fugiat eiusmod occaecat nulla magna', 'Rose', 'Cambodia', '2024-04-17', '2024-05-30', '2023-06-05 13:03:54', '2023-06-05 13:03:54');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
