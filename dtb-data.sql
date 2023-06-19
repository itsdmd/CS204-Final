-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc37
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 19, 2023 at 02:26 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
