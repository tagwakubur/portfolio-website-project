-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 01:41 PM
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
-- Database: `icook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `class_id`, `title`, `message`, `created_at`, `content`) VALUES
(1, 1, 'Welcome to Pasta Basics', 'Class starts next Monday at 5 PM.', '2025-06-30 11:38:29', NULL),
(2, 2, 'Welcome to Baking 101', 'First lesson: Chocolate chip cookies!', '2025-06-30 11:38:29', NULL),
(3, 3, 'Class Reminder', 'Please join the online class 10 mins early.', '2025-07-01 05:08:24', NULL),
(4, 4, 'Bring Tools', 'Don’t forget your cake tools for tomorrow!', '2025-07-01 05:08:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `class_id`, `file_name`, `file_path`, `uploaded_at`, `upload_time`) VALUES
(1, 1, 'pasta_recipe.pdf', 'uploads/pasta_recipe.pdf', '2025-06-30 11:38:50', '2025-07-01 04:43:20'),
(2, 2, 'cookie_recipe.pdf', 'uploads/cookie_recipe.pdf', '2025-06-30 11:38:50', '2025-07-01 04:43:20'),
(3, 3, 'advanced_pasta.pdf', 'uploads/advanced_pasta.pdf', '2025-07-01 05:08:24', '2025-07-01 05:08:24'),
(4, 4, 'cake_tools_list.pdf', 'uploads/cake_tools_list.pdf', '2025-07-01 05:08:24', '2025-07-01 05:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `chefs`
--

CREATE TABLE `chefs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `culinary_school` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chefs`
--

INSERT INTO `chefs` (`id`, `name`, `email`, `contact`, `experience`, `password`, `reset_token`, `reset_token_expiry`, `country`, `culinary_school`, `bio`, `photo`, `facebook_link`, `instagram_link`, `linkedin_link`) VALUES
(1, 'Tagwa bashir kubur', 'tagwaabdullkubur1999915@gmail.com', '0184086720', 3, '$2y$10$3jTd4W7QpSdpfIU.CV2lUeH7jmBKK0YckRkt6RGa6sxSLhjQZ3V5q', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Chef Ali', 'ali@icook.com', '0123456789', NULL, '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Chef Sara', 'sara@icook.com', '0123456789', NULL, '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `chef_id` int(11) DEFAULT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_details` text NOT NULL,
  `course_type` enum('Free','Paid') NOT NULL,
  `online_link` varchar(255) DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `building` varchar(100) DEFAULT NULL,
  `class_image` varchar(255) DEFAULT NULL,
  `class_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `chef_id`, `class_name`, `description`, `created_at`, `course_details`, `course_type`, `online_link`, `room_number`, `level`, `building`, `class_image`, `class_date`) VALUES
(1, 1, 'Italian Pasta Basics', 'Learn to make fresh pasta.', '2025-06-30 11:37:28', '', 'Free', 'https://webex.com/class2', NULL, NULL, NULL, '', NULL),
(2, 1, 'Baking 101', 'Cakes, cookies, and more.', '2025-06-30 11:37:28', '', 'Paid', NULL, '203', '3', 'N28 Building', '', NULL),
(3, 1, 'Advanced Pasta Mastery', 'Master advanced pasta techniques', '2025-07-01 05:08:24', 'Advanced lessons with real-time demos', 'Paid', 'https://webex.com/class3', NULL, NULL, NULL, '', '2025-07-15'),
(4, 24, 'Cakes & More', 'Decorating and baking techniques', '2025-07-01 05:08:24', 'Hands-on session with cake tools', 'Paid', NULL, '202', '2', 'ICook Building', '', '2025-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `learner_id`, `recipe_id`, `created_at`) VALUES
(1, 1, 1, '2025-06-30 19:37:05'),
(2, 2, 2, '2025-06-30 19:37:05');

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

CREATE TABLE `learners` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `preferred_cuisine` varchar(100) DEFAULT NULL,
  `skill_level` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learners`
--

INSERT INTO `learners` (`id`, `name`, `email`, `contact`, `password`, `bio`, `preferred_cuisine`, `skill_level`, `photo`) VALUES
(8, 'Tagwa bashir kubur', 'bashirabdulla@graduate.utm.my', '01234567', '$2y$10$D9HtAW4D08CtpKV6mbpR2O7RJOZZjM8hZy72ZvOieZpP3ylf69Vne', NULL, NULL, NULL, NULL),
(11, 'tagwa', 'tagwaabdullkubur1999915@gmail.com', '123', '$2y$10$k/LOu61SrWbIw1HvqsGP8ebAM.eW0ODKrv8OTZ52yDrXdDA0WLDPO', NULL, NULL, NULL, NULL),
(12, 'Learner Noor', 'noor@icook.com', '0192837465', '123', NULL, NULL, NULL, NULL),
(13, 'Learner Omar', 'omar@icook.com', '0192837466', '123', NULL, NULL, NULL, NULL),
(14, 'Ahmad Zain', 'ahmad@example.com', '0101234567', '123', 'Loves Italian food', 'Italian', 'Beginner', NULL),
(15, 'Sophia Lee', 'sophia@example.com', '0198765432', '123', 'Avid baker', 'Desserts', 'Intermediate', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `quiz_title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `class_id`, `quiz_title`, `created_at`) VALUES
(1, 1, 'Pasta Basics Quiz', '2025-07-01 05:08:24'),
(2, 2, 'Baking 101 Quiz', '2025-07-01 05:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`question_id`, `quiz_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 1, 'What flour is best for pasta?', 'All-purpose', 'Semolina', 'Rice', 'Almond', 'B'),
(2, 1, 'Ideal resting time for pasta dough?', '5 min', '10 min', '30 min', '1 hour', 'C'),
(3, 2, 'Main ingredient in chocolate chip cookies?', 'Butter', 'Chocolate', 'Sugar', 'All of the above', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) UNSIGNED NOT NULL,
  `chef_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `chef_id`, `title`, `description`, `ingredients`, `instructions`, `image_url`, `created_at`) VALUES
(2, 1, 'salad', 'side dish', 'tomatoes, cucumber', 'put them together', '', '2025-06-26'),
(3, 1, 'Garlic Butter Pasta', 'Cook the pasta in salted boiling water according to package instructions. Drain, reserving ½ cup of pasta water.\r\n\r\nIn a pan, melt butter over medium heat. Add minced garlic and chili flakes, sautéing for 1 minute until fragrant.\r\n\r\nAdd the cooked pasta to the pan and toss well.\r\n\r\nStir in Parmesan cheese and a splash of reserved pasta water to make a silky sauce.\r\n\r\nSeason with salt and pepper, garnish with parsley, and serve hot.', '200g spaghetti (or any pasta)\r\n\r\n2 tbsp butter\r\n\r\n3 garlic cloves, minced\r\n\r\n¼ tsp red chili flakes (optional)\r\n\r\n2 tbsp grated Parmesan cheese\r\n\r\nSalt & pepper to taste\r\n\r\nFresh parsley, chopped (for garnish)', NULL, NULL, '2025-06-29'),
(4, 1, 'Classic Lasagna', 'Delicious layers of pasta and cheese', 'Pasta, cheese, sauce', 'Layer pasta, cheese, bake.', 'lasagna.jpg', '2025-06-30'),
(5, 2, 'Chocolate Cake', 'Rich and moist chocolate cake', 'Flour, cocoa, sugar, eggs', 'Mix ingredients, bake.', 'chocolate_cake.jpg', '2025-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `learner_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registration_id`, `learner_id`, `class_id`, `registered_at`) VALUES
(1, 1, 1, '2025-06-30 11:38:04'),
(2, 2, 2, '2025-06-30 11:38:04'),
(3, 1, 2, '2025-06-30 11:53:55'),
(4, 14, 1, '2025-07-01 05:08:24'),
(5, 14, 3, '2025-07-01 05:08:24'),
(6, 15, 4, '2025-07-01 05:08:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `chefs`
--
ALTER TABLE `chefs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chefs`
--
ALTER TABLE `chefs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
