-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 05:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sj_projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `message`, `user_id`) VALUES
(1, 'fdaf', 'dsfa', 18),
(2, 'fdaf', 'dsfa', 18),
(3, 'dsad', 'sadas', 18),
(4, 'dsad', 'sadas', 18),
(5, 'dsad', 'sadasd', 18),
(6, 'dsad', 'sadasd', 18),
(7, 'dsad', 'dsad', 18),
(8, 'dsad', 'dsad', 18),
(9, 'dsad', 'dsad', 18),
(10, 'fasfas', 'fsafa', 18);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `author`, `user_id`, `created_at`) VALUES
(41, '2222', '222', '', 'KristianSzabo', 18, '2024-04-24 21:45:54'),
(43, '44', '444', '', 'KristianSzabo', 18, '2024-04-24 21:46:04'),
(44, '555', '555', '', 'KristianSzabo', 18, '2024-04-24 21:46:07'),
(45, '666', '666', '', 'KristianSzabo', 18, '2024-04-24 21:46:09'),
(46, '77777777', '777777', '', 'KristianSzabo', 18, '2024-04-24 21:46:13'),
(50, '88888', '8888', '', 'KristianSzabo', 18, '2024-05-21 17:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `image`, `description`, `created`, `modified`) VALUES
(1, 'nature1.jpg', 'Nature1 images', '2017-07-29 00:00:00', '2017-07-29 00:00:00'),
(2, 'nature2.jpg', 'nature 2 images', '2017-07-29 00:00:00', '2017-07-29 00:00:00'),
(3, 'nature3.jpg', 'nature3 images', '2017-07-29 00:00:00', '2017-07-29 00:00:00'),
(4, 'nature4.jpg', 'nature4 images', '2017-07-29 00:00:00', '2017-07-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_picture`) VALUES
(18, 'KristianSzabo', 'funuguj@gmail.com', '$2y$10$gnVEJIhqRiU/AWbM1o7GU.uQcj7Og7rx8gaNDjU8RpnPj62cAO6Ti', 'admin', 'profile_pictures/WIN_20230227_18_18_08_Pro.jpg'),
(21, 'gaz', 'gay@gmail.com', '$2y$10$TRX7PPq5uDUPT1o1TlOaLeNxhSWLHlLXIOyabEsRb7t2uxqZDUT4K', '', NULL),
(22, 'kiko', 'kikojebest@gmail.com', '$2y$10$EAcZCRlw/rbRG8Ie7HokmekzM5LKrsV.q09f5re5jyW9SoWHKpAcC', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
