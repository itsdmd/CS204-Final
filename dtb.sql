-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 01, 2023 at 11:58 AM
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
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `author` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int NOT NULL COMMENT 'the post this comment belongs to',
  `replied_to` int DEFAULT NULL COMMENT 'ID of post/comment this entry is replying to. NULL for top level comment.',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `author`, `post_id`, `replied_to`, `content`, `date_created`) VALUES
(127, 'test', 40, NULL, 'Comment 1', '2023-07-01 18:22:22'),
(128, 'test', 40, 127, 'replying to comment 1', '2023-07-01 18:22:34'),
(129, 'test', 40, NULL, 'Comment 2', '2023-07-01 18:25:42'),
(130, 'test', 40, 129, 'replying to comment 2', '2023-07-01 18:25:57'),
(131, 'test', 40, 130, 'testing nesting comment', '2023-07-01 18:26:00'),
(132, 'test', 40, 129, 'second reply to comment 2', '2023-07-01 18:26:15'),
(133, 'test', 40, 131, 'even deeper nesting comment', '2023-07-01 18:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `deleted`
--

CREATE TABLE `deleted` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `comment_id` int DEFAULT NULL,
  `deleted_by` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploader` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `path`, `uploader`) VALUES
(1, 'default_avatar.png', 'admin'),
(7, '64998c35dd7344.74870275.png', 'admin'),
(12, '649a9299a32698.73479700.png', 'test'),
(18, '649e8f7d99bdc3.65469515.jpg', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `author` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_id` int DEFAULT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `author`, `title`, `content`, `media_id`, `tags`, `date_created`, `date_modified`) VALUES
(21, 'John', 'The Science of Cooking', 'In this post, we explore the science behind cooking and how it affects the taste and texture of food.', NULL, 'science, food', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(22, 'Jane', 'The Benefits of Running', 'Running is a great way to stay in shape and improve your overall health. In this post, we discuss the many benefits of running and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(23, 'Mark', 'The Art of Photography', 'Photography is a beautiful art form that allows us to capture and preserve memories. In this post, we explore the art of photography and share some tips for taking great photos.', NULL, 'art, photography', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(24, 'admin', 'The Future of Technology', 'Technology is constantly evolving and changing the way we live our lives. In this post, we discuss some of the latest technological advancements and their potential impact on society.', NULL, 'technology, future', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(25, 'Mike', 'The Science of Sleep', 'Sleep is essential for our health and well-being. In this post, we explore the science behind sleep and how to improve the quality of your sleep.', NULL, 'science, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(26, 'Emily', 'The Benefits of Yoga', 'Yoga is a great way to reduce stress and improve your overall health. In this post, we discuss the many benefits of yoga and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(27, 'David', 'The Art of Writing', 'Writing is a beautiful art form that allows us to express ourselves and share our ideas with the world. In this post, we explore the art of writing and share some tips for improving your writing skills.', NULL, 'art, writing', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(28, 'Lisa', 'The Latest Technology Trends', 'Technology is constantly changing and evolving. In this post, we discuss some of the latest technology trends and their potential impact on our lives.', NULL, 'technology, future', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(29, 'Tom', 'The Science of Nutrition', 'Nutrition is essential for our health and well-being. In this post, we explore the science behind nutrition and how to make healthy food choices.', NULL, 'science, health, food', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(30, 'Amy', 'The Benefits of Meditation', 'Meditation is a great way to reduce stress and improve your overall well-being. In this post, we discuss the many benefits of meditation and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(31, 'Chris', 'The Art of Music', 'Music is a beautiful art form that allows us to express ourselves and connect with others. In this post, we explore the art of music and share some tips for improving your musical skills.', NULL, 'art, music', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(32, 'admin', 'The Latest Science News', 'Science is constantly making new discoveries and pushing the boundaries of what we know. In this post, we discuss some of the latest science news and breakthroughs.', NULL, 'science, news', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(33, 'Jake', 'The Benefits of Hiking', 'Hiking is a great way to stay in shape and explore the great outdoors. In this post, we discuss the many benefits of hiking and how to get started.', NULL, 'sport, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(34, 'Rachel', 'The Art of Film', 'Film is a beautiful art form that allows us to tell stories and share our experiences with others. In this post, we explore the art of film and share some tips for making great movies.', NULL, 'art, film', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(35, 'Ben', 'The Latest Technology Gadgets', 'Technology is constantly producing new gadgets and devices that make our lives easier and more convenient. In this post, we discuss some of the latest technology gadgets and their potential impact on our lives.', NULL, 'technology, gadgets', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(36, 'Lily', 'The Science of Exercise', 'Exercise is essential for our health and well-being. In this post, we explore the science behind exercise and how to make the most of your workouts.', NULL, 'science, health, sport', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(37, 'Max', 'The Benefits of Reading', 'Reading is a great way to expand your knowledge and improve your cognitive abilities. In this post, we discuss the many benefits of reading and how to make it a habit.', NULL, 'art, education', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(38, 'admin', 'The Latest Technology Innovations', 'Technology is constantly innovating and creating new solutions to old problems. In this post, we discuss some of the latest technology innovations and their potential impact on our lives.', NULL, 'technology, future', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(39, 'Luke', 'The Science of Aging', 'Aging is a natural process that affects us all. In this post, we explore the science behind aging and how to age gracefully.', NULL, 'science, health', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(40, 'Sophie', 'The Art of Dance', 'Dance is a beautiful art form that allows us to express ourselves and connect with others. In this post, we explore the art of dance and share some tips for improving your dancing skills.', NULL, 'art, dance', '2023-06-19 08:58:23', '2023-06-24 08:31:36'),
(43, 'test', 'This is a test post', 'Written as user named \"test\". Testing `date_modified` field. Presenting editing post.', 18, 'science, health', '2023-06-20 14:03:08', '2023-06-30 15:17:01');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `comment_id` int DEFAULT NULL,
  `reporter` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `post_id`, `comment_id`, `reporter`, `reason`, `date_created`) VALUES
(25, 27, NULL, 'test', 'It\'s misleading', '2023-06-29 20:45:13'),
(29, NULL, 129, 'test', 'It\'s inappropriate', '2023-07-01 18:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '2' COMMENT '-1: guest | 0: admin | 1: user',
  `avatar_id` int DEFAULT NULL COMMENT 'ID of media used as avatar',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `avatar_id`, `date_created`) VALUES
('admin', '$2y$10$mj2xIOWiQRH5.0wtyZRhZ.SPGMjVHly.m3nKf71Jmi2K5qJ2Ekv9C', 0, 7, '2023-06-17 16:27:25'),
('test', '$2y$10$aqQxvrw5Tc01guZc7BJTsufIQmUDxEtBBhhMiuiU.lKdYgHmbLoWm', 1, 12, '2023-06-20 13:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `voting`
--

CREATE TABLE `voting` (
  `id` int NOT NULL,
  `post_id` int DEFAULT NULL,
  `comment_id` int DEFAULT NULL,
  `voter` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_upvote` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voting`
--

INSERT INTO `voting` (`id`, `post_id`, `comment_id`, `voter`, `is_upvote`) VALUES
(71, 27, NULL, 'admin', 1),
(74, 27, NULL, 'test', 1),
(80, 40, NULL, 'test', 1),
(81, NULL, 128, 'test', 0),
(82, NULL, 130, 'test', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `author` (`author`,`replied_to`),
  ADD KEY `id_2` (`id`,`author`,`replied_to`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `replied_to` (`replied_to`);

--
-- Indexes for table `deleted`
--
ALTER TABLE `deleted`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `target_id` (`post_id`,`deleted_by`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `uploader` (`uploader`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `target_id` (`comment_id`,`reporter`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `reporter` (`reporter`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `voting`
--
ALTER TABLE `voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `target_id` (`comment_id`,`voter`),
  ADD KEY `voter` (`voter`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `deleted`
--
ALTER TABLE `deleted`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `voting`
--
ALTER TABLE `voting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`replied_to`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deleted`
--
ALTER TABLE `deleted`
  ADD CONSTRAINT `deleted_ibfk_1` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deleted_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deleted_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploader`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`reporter`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voting`
--
ALTER TABLE `voting`
  ADD CONSTRAINT `voting_ibfk_1` FOREIGN KEY (`voter`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voting_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voting_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
