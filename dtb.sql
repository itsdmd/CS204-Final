-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 19, 2023 at 05:50 AM
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
  `type` int NOT NULL COMMENT '0: reply to post | 1: reply to comment',
  `reply_to` int NOT NULL COMMENT 'ID of post/comment this entry is replying to',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `author`, `type`, `reply_to`, `body`, `date_created`) VALUES
(1, 'John', 0, 25, 'Great post!', '2023-06-19 08:52:46'),
(2, 'Jane', 1, 3, 'I completely agree.', '2023-06-19 08:52:46'),
(3, 'Mark', 0, 27, 'Thanks for sharing!', '2023-06-19 08:52:46'),
(4, 'Sara', 1, 2, 'Interesting point.', '2023-06-19 08:52:46'),
(5, 'Mike', 0, 21, 'I have a question.', '2023-06-19 08:52:46'),
(6, 'Emily', 1, 4, 'I disagree.', '2023-06-19 08:52:46'),
(7, 'David', 0, 30, 'This is helpful.', '2023-06-19 08:52:46'),
(8, 'Lisa', 1, 6, 'I have a similar experience.', '2023-06-19 08:52:46'),
(9, 'Tom', 0, 29, 'I appreciate your insights.', '2023-06-19 08:52:46'),
(10, 'Amy', 1, 8, 'I think you missed something.', '2023-06-19 08:52:46'),
(11, 'Chris', 0, 22, 'Can you explain more?', '2023-06-19 08:52:46'),
(12, 'Olivia', 1, 5, 'I have a different perspective.', '2023-06-19 08:52:46'),
(13, 'Jake', 0, 23, 'This is well-written.', '2023-06-19 08:52:46'),
(14, 'Rachel', 1, 7, 'I have a follow-up question.', '2023-06-19 08:52:46'),
(15, 'Ben', 0, 24, 'I see your point.', '2023-06-19 08:52:46'),
(16, 'Lily', 1, 1, 'I think you are mistaken.', '2023-06-19 08:52:46'),
(17, 'Max', 0, 26, 'I have a suggestion.', '2023-06-19 08:52:46'),
(18, 'Ava', 1, 10, 'I have a question about this.', '2023-06-19 08:52:46'),
(19, 'Luke', 0, 28, 'This is a great resource.', '2023-06-19 08:52:46'),
(20, 'Sophie', 1, 9, 'I found this very helpful.', '2023-06-19 08:52:46'),
(21, 'Jane', 0, 27, 'That\'s awesome!', '2023-06-19 08:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int NOT NULL,
  `format` int NOT NULL COMMENT '0: jpg | 1: png',
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(40, 'Sophie', 'The Art of Dance', 'Dance is a beautiful art form that allows us to express ourselves and connect with others. In this post, we explore the art of dance and share some tips for improving your dancing skills.', NULL, 'art, dance', '2023-06-19 08:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `reported`
--

CREATE TABLE `reported` (
  `id` int NOT NULL,
  `type` int NOT NULL COMMENT '0: post | 1: user',
  `target_id` int NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `description`) VALUES
(1, 'science', 'The study of the natural world, including living and nonliving things, and the processes that govern them. Science encompasses many fields, such as biology, chemistry, physics, and earth science.'),
(2, 'food', 'Any substance that is consumed to provide nutritional support for the body. Food can be derived from plants or animals and can be prepared in many ways.'),
(3, 'sport', 'Physical activities that are competitive or recreational in nature and require skill, strength, and endurance. Sports can be individual or team-based and can include activities such as running, swimming, basketball, and soccer.'),
(4, 'health', 'The state of being free from illness or injury and having a sound mind and body. Health can be influenced by many factors, such as genetics, lifestyle, environment, and access to healthcare.'),
(5, 'art', 'Creative works that are produced by humans and are intended to be appreciated for their beauty, emotional power, or intellectual content. Art can take many forms, such as painting, sculpture, music, literature, and film.'),
(6, 'photography', 'The art and practice of capturing images using a camera or other photographic equipment. Photography can be used for many purposes, such as artistic expression, journalism, scientific research, and commercial advertising.'),
(7, 'technology', 'The application of scientific knowledge for practical purposes, especially in industry and commerce. Technology can include many fields, such as information technology, biotechnology, nanotechnology, and robotics.'),
(8, 'future', 'The time period that is yet to come and the events that will occur during that time. The future is often uncertain and can be influenced by many factors, such as technology, politics, economics, and social trends.'),
(9, 'writing', 'The act of creating written works, such as books, articles, essays, and poems. Writing can be used for many purposes, such as storytelling, education, persuasion, and entertainment.'),
(10, 'music', 'The art and practice of creating and performing sounds that are organized in time and have melody, harmony, rhythm, and timbre. Music can take many forms, such as classical, jazz, rock, pop, and folk.'),
(11, 'news', 'Information about current events that is reported by journalists and media outlets. News can cover many topics, such as politics, business, sports, entertainment, and science.'),
(12, 'film', 'A form of visual art that uses moving images to tell stories or convey ideas. Film can be used for many purposes, such as entertainment, education, propaganda, and artistic expression.'),
(13, 'gadgets', 'Small electronic devices that are designed for a specific purpose and are often portable or wearable. Gadgets can include many types of devices, such as smartphones, tablets, fitness trackers, and smartwatches.'),
(14, 'education', 'The process of acquiring knowledge, skills, values, and attitudes through various forms of learning, such as schooling, training, and self-study. Education can take many forms, such as formal education, informal education, and lifelong learning.'),
(15, 'dance', 'A form of artistic expression that involves rhythmic movement of the body in response to music or other stimuli. Dance can take many forms, such as ballet, hip-hop, salsa, and ballroom.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL DEFAULT '2' COMMENT '0: admin | 1: moderator | 2: user',
  `avatar_id` int DEFAULT NULL COMMENT 'ID of media used as avatar',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `avatar_id`, `date_created`) VALUES
('admin', '$2y$10$mj2xIOWiQRH5.0wtyZRhZ.SPGMjVHly.m3nKf71Jmi2K5qJ2Ekv9C', 0, NULL, '2023-06-17 16:27:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reported`
--
ALTER TABLE `reported`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reported`
--
ALTER TABLE `reported`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
