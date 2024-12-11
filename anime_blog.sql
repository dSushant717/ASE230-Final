-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 07:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anime_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `content`, `post_id`, `author_id`, `created_at`) VALUES
(1, 'This post is fantastic! I love anime worlds.', 1, 2, '2024-12-10 02:48:35'),
(2, 'Looking forward to visiting these parks.', 1, 3, '2024-12-10 02:48:35'),
(3, 'Great list of parks. My favorite is #3.', 2, 1, '2024-12-10 02:48:35'),
(4, 'Amazing insights into Naruto’s world!', 3, 4, '2024-12-10 02:48:35'),
(5, 'I can’t wait to see the Hero Training Camp!', 5, 2, '2024-12-10 02:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `content`, `author_id`, `created_at`) VALUES
(1, 'Sailing the Grand Line: One Piece Adventure', 'Embark on the adventure of a lifetime with the One Piece Grand Line Adventure! Explore a life-sized replica of the Thousand Sunny, visit iconic locations like Water 7 and Alabasta, and experience thrilling 4D effects that bring the world of One Piece to life. Did you know Eiichiro Oda designed the Straw Hat flag as a personal signature of Luffy\'s freedom-loving spirit? Don\\u2019t miss the chance to meet the Straw Hat crew through interactive holograms!', 3, '2024-11-15 05:00:00'),
(2, 'Wall Maria Defense: Attack on Titan Coaster', 'Join the Scout Regiment and defend Wall Maria from Titans in this heart-pounding roller coaster experience. The ride features Titan-sized animatronics and a gripping storyline that makes you feel like you\\u2019re part of the battle. Fun fact: Hajime Isayama created the Titans based on nightmares he had as a teenager. Immerse yourself in the chaotic world of Attack on Titan and brace yourself for the ultimate drop!', 4, '2024-11-18 05:00:00'),
(3, 'The Hidden Leaf Village: Naruto Training Ground', 'Train like a true ninja in the Hidden Leaf Village! Test your skills at the Chunin Exam obstacle course, throw kunai in the training arena, and enjoy a bowl of Ichiraku Ramen. Did you know Masashi Kishimoto based the village\'s landscape on his childhood hometown? The virtual reality experience lets you battle alongside Naruto, Sasuke, and Sakura against legendary foes!', 5, '2024-11-20 05:00:00'),
(4, 'Infinity Train Ride: Demon Slayer Saga', 'Step aboard the Infinity Train and relive the breathtaking Demon Slayer movie! With state-of-the-art effects, the ride recreates Tanjiro\'s fight against Enmu and Akaza, immersing you in the emotional depth of Koyoharu Gotouge\'s masterpiece. Did you know Demon Slayer: Mugen Train broke box office records worldwide, becoming the highest-grossing anime film of all time? Get ready to face your demons!', 6, '2024-11-22 05:00:00'),
(5, 'UA Hero Training Camp: My Hero Academia', 'Discover your quirk and become the next great hero at UA High\\u2019s Hero Training Camp! Participate in hero simulations with All Might, Deku, and Bakugo, and earn your own hero license. Interesting fact: Kohei Horikoshi based several quirks on animals he observed during his childhood. Don\\u2019t miss the Pro Hero showcase at the arena, where you\\u2019ll see heroes in action!', 7, '2024-11-25 05:00:00'),
(6, 'Test Title', 'Updating the Content', 1, '2024-12-08 05:00:00'),
(7, 'not Nova&#039;s Title', 'not Nova&#039;s Content', 8, '2024-12-10 20:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','member') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
(1, 'Sushant', '$2y$10$dwd47N.yaBlFMAbQ7MdkUOMoad.dO/aSNj1BaBOlFxSl2lEbPGKyu', 'sushant@example.com', '2024-12-10 02:48:35', 'admin'),
(2, 'Ayanokoji', '$2y$10$wezDwChrcaGNnWc9kPa2QubdiWFdVrJoKWdvsshcWK1hfL0gzAa8y', 'ayanokoji@example.com', '2024-12-10 02:48:35', 'member'),
(3, 'Eiichiro Oda', 'placeholder_password', 'oda@example.com', '2024-12-10 02:48:35', 'member'),
(4, 'Hajime Isayama', 'placeholder_password', 'isayama@example.com', '2024-12-10 02:48:35', 'member'),
(5, 'Masashi Kishimoto', 'placeholder_password', 'kishimoto@example.com', '2024-12-10 02:48:35', 'member'),
(6, 'Koyoharu Gotouge', 'placeholder_password', 'gotouge@example.com', '2024-12-10 02:48:35', 'member'),
(7, 'Kohei Horikoshi', 'placeholder_password', 'horikoshi@example.com', '2024-12-10 02:48:35', 'member'),
(8, 'Nova', '$2y$10$CxS2Wz0qTtJUkXXVbwUhfO3sOL4A4PwGYpPg1sAPxBjcCdDCD9XLu', 'nova@gmail.com', '2024-12-10 19:59:31', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
