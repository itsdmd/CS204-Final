-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2023 at 07:05 AM
-- Server version: 8.0.33
-- PHP Version: 8.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs204_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `author` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id` int DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `author`, `title`, `body`, `media_id`, `tags`, `date_created`) VALUES
(21, 'John', 'The Science of Cooking', 'In this post, we explore the science behind cooking and how it affects the taste and texture of food.', NULL, 'science, food', '2023-06-19 08:58:23'),
(22, 'Jane', 'The Benefits of Running', 'Running is a great way to stay in shape and improve your overall health. In this post, we discuss the many benefits of running and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23'),
(23, 'Mark', 'The Art of Photography', 'Photography is a beautiful art form that allows us to capture and preserve memories. In this post, we explore the art of photography and share some tips for taking great photos.', NULL, 'art, photography', '2023-06-19 08:58:23'),
(24, 'admin', 'The Future of Technology', 'Technology is constantly evolving and changing the way we live our lives. In this post, we discuss some of the latest technological advancements and their potential impact on society.', NULL, 'technology, future', '2023-06-19 08:58:23'),
(25, 'Mike', 'The Science of Sleep', 'Sleep is essential for our health and well-being. In this post, we explore the science behind sleep and how to improve the quality of your sleep.', NULL, 'science, health', '2023-06-19 08:58:23'),
(26, 'Emily', 'The Benefits of Yoga', 'Yoga is a great way to reduce stress and improve your overall health. In this post, we discuss the many benefits of yoga and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23'),
(27, 'David', 'The Art of Writing', 'Writing is a beautiful art form that allows us to express ourselves and share our ideas with the world. In this post, we explore the art of writing and share some tips for improving your writing skills.', NULL, 'art, writing', '2023-06-19 08:58:23'),
(28, 'Lisa', 'The Latest Technology Trends', 'Technology is constantly changing and evolving. In this post, we discuss some of the latest technology trends and their potential impact on our lives.', NULL, 'technology, future', '2023-06-19 08:58:23'),
(29, 'Tom', 'The Science of Nutrition', 'Nutrition is essential for our health and well-being. In this post, we explore the science behind nutrition and how to make healthy food choices.', NULL, 'science, health, food', '2023-06-19 08:58:23'),
(30, 'Amy', 'The Benefits of Meditation', 'Meditation is a great way to reduce stress and improve your overall well-being. In this post, we discuss the many benefits of meditation and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23'),
(31, 'Chris', 'The Art of Music', 'Music is a beautiful art form that allows us to express ourselves and connect with others. In this post, we explore the art of music and share some tips for improving your musical skills.', NULL, 'art, music', '2023-06-19 08:58:23'),
(32, 'admin', 'The Latest Science News', 'Science is constantly making new discoveries and pushing the boundaries of what we know. In this post, we discuss some of the latest science news and breakthroughs.', NULL, 'science, news', '2023-06-19 08:58:23'),
(33, 'Jake', 'The Benefits of Hiking', 'Hiking is a great way to stay in shape and explore the great outdoors. In this post, we discuss the many benefits of hiking and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23'),
(34, 'Rachel', 'The Art of Film', 'Film is a beautiful art form that allows us to tell stories and share our experiences with others. In this post, we explore the art of film and share some tips for making great movies.', NULL, 'art, film', '2023-06-19 08:58:23'),
(35, 'Ben', 'The Latest Technology Gadgets', 'Technology is constantly producing new gadgets and devices that make our lives easier and more convenient. In this post, we discuss some of the latest technology gadgets and their potential impact on our lives.', NULL, 'technology, gadgets', '2023-06-19 08:58:23'),
(36, 'Lily', 'The Science of Exercise', 'Exercise is essential for our health and well-being. In this post, we explore the science behind exercise and how to make the most of your workouts.', NULL, 'science, health, sport', '2023-06-19 08:58:23'),
(37, 'Max', 'The Benefits of Reading', 'Reading is a great way to expand your knowledge and improve your cognitive abilities. In this post, we discuss the many benefits of reading and how to make it a habit.', NULL, 'art, education', '2023-06-19 08:58:23'),
(38, 'admin', 'The Latest Technology Innovations', 'Technology is constantly innovating and creating new solutions to old problems. In this post, we discuss some of the latest technology innovations and their potential impact on our lives.', NULL, 'technology, future', '2023-06-19 08:58:23'),
(39, 'Luke', 'The Science of Aging', 'Aging is a natural process that affects us all. In this post, we explore the science behind aging and how to age gracefully.', NULL, 'science, health', '2023-06-19 08:58:23'),
(40, 'Sophie', 'The Art of Dance', 'Dance is a beautiful art form that allows us to express ourselves and connect with others. In this post, we explore the art of dance and share some tips for improving your dancing skills.', NULL, 'art, dance', '2023-06-19 08:58:23'),
(43, 'test', 'This is a test post', 'Written as user named \"test\"', NULL, 'science', '2023-06-20 14:03:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
