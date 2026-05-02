-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 04:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidicode_lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Emailid` varchar(100) DEFAULT NULL,
  `Contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `Name`, `Password`, `Emailid`, `Contact`) VALUES
(1, 'admin', 'admin123', 'admin@example.com', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `class_links`
--

CREATE TABLE `class_links` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_date` date NOT NULL,
  `class_time` time NOT NULL,
  `topic` varchar(255) NOT NULL,
  `challenge_title` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `challenge_file` varchar(500) DEFAULT NULL,
  `class_link` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_links`
--

INSERT INTO `class_links` (`id`, `instructor_id`, `course_id`, `class_date`, `class_time`, `topic`, `challenge_title`, `instructions`, `challenge_file`, `class_link`, `created_at`) VALUES
(3, 15, 2, '2025-11-05', '18:19:00', 'FrontEnd Introduction', '', '', '../uploads/challenges/License free.txt', 'https://us04web.zoom.us/j/1234567890?pwd=examplepassword', '2025-11-19 00:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_description` text NOT NULL,
  `age_group` varchar(50) NOT NULL,
  `course_type` enum('Free','Premium') DEFAULT 'Free',
  `scorm_xapi_integration` tinyint(1) DEFAULT 0,
  `course_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `instructor_id`, `course_title`, `course_description`, `age_group`, `course_type`, `scorm_xapi_integration`, `course_image`, `created_at`, `updated_at`) VALUES
(2, 15, 'Web Developement', 'All about  full stack dev including Html, Css, Php, Sql', '10-12', 'Premium', 0, '1763569852_1.jpg', '2025-11-18 23:52:59', '2025-11-20 04:07:05'),
(3, 15, 'Machine Learning & Ai ', 'Numerous online courses, specializations, and professional certificate programs offer comprehensive training in Machine Learning (ML) & AI Automation, catering to a range of skill levels from beginner to advanced', 'Advanced', 'Premium', 1, 'uploads/images/1763525420_hq720.jpg', '2025-11-19 04:10:20', '2025-11-19 04:10:20'),
(4, 15, 'Basic Coding for Kids', 'Fun introduction to programming using visual blocks and small creative tasks.', '9-12', 'Free', 0, 'uploads/images/coding_kids.jpg', '2025-11-19 15:47:34', '2025-11-20 04:00:57'),
(5, 15, 'Math with Games', 'Interactive math concepts explained through games, puzzles and hands-on activities.', '3-5', 'Free', 0, '1763567725_hq720.jpg', '2025-11-19 15:47:34', '2025-11-20 04:01:04'),
(6, 15, 'Creative Drawing Basics', 'Step-by-step sketching lessons designed to improve creativity and drawing skills.', '7-9', 'Premium', 1, 'uploads/images/drawing_basics.jpg', '2025-11-19 15:47:34', '2025-11-20 04:01:32'),
(7, 9, 'Kids English Booster', 'Grammar, vocabulary and speaking exercises for improving English confidence.', '3-5', 'Free', 0, 'uploads/images/english_booster.jpg', '2025-11-19 15:47:34', '2025-11-20 04:01:12'),
(8, 9, 'STEM Experiments at Home', 'Easy science and engineering experiments using household materials.', '5-7', 'Premium', 1, 'uploads/images/stem_home.jpg', '2025-11-19 15:47:34', '2025-11-20 04:01:23'),
(9, 9, 'Robotics for Beginners', 'Learn the basics of robotics, sensors and motors with guided demos.', '9-12', 'Premium', 1, 'uploads/images/robotics_beginners.jpg', '2025-11-19 15:47:34', '2025-11-20 04:00:36'),
(10, 9, 'Fun Science Facts', 'Short animated science lessons explaining everyday mysteries and facts.', '5-7', 'Free', 0, 'uploads/images/science_fun.jpg', '2025-11-19 15:47:34', '2025-11-20 04:00:21'),
(11, 15, 'Kids Computer Basics', 'Understanding computers, internet safety, typing skills and digital confidence.', '9-12', 'Free', 0, 'uploads/images/computer_basics.jpg', '2025-11-19 15:47:34', '2025-11-20 04:00:12'),
(12, 15, 'Animation for Kids', 'Learn simple animation techniques using child-friendly tools and creativity.', '12-15', 'Premium', 1, 'uploads/images/animation_kids.jpg', '2025-11-19 15:47:34', '2025-11-20 04:00:08'),
(13, 15, 'Junior Web Developer', 'Learn basics of HTML, CSS and simple webpage creation for young learners.', '9-12', 'Premium', 1, 'uploads/images/junior_web_dev.jpg', '2025-11-19 15:47:34', '2025-11-20 03:59:59'),
(14, 15, 'Math with Games', '', '9-12', 'Free', 0, 'uploads/images/1763611169_WhatsApp Image 2025-11-17 at 12.33.42 AM.jpeg', '2025-11-20 03:59:29', '2025-11-20 03:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `course_materials`
--

CREATE TABLE `course_materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `assignment_path` varchar(255) DEFAULT NULL,
  `reading_material_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_materials`
--

INSERT INTO `course_materials` (`id`, `course_id`, `video_path`, `assignment_path`, `reading_material_path`, `uploaded_at`) VALUES
(2, 2, '1763569852_proctordiary demo.mp4', '1763569852_VU Process Model.docx', '1763569852_1756323512_mypic.png', '2025-11-18 23:52:59'),
(3, 3, 'uploads/videos/1763525420_20251106_162732.mp4', 'uploads/assignments/1763525420_VU Process Model.docx', 'uploads/materials/1763525420_certificate.pdf', '2025-11-19 04:10:20'),
(4, 5, '', '', '', '2025-11-19 15:55:25'),
(5, 14, 'uploads/videos/1763611169_1763569852_proctordiary demo.mp4', 'uploads/assignments/1763611169_1763569852_VU Process Model.docx', 'uploads/materials/1763611170_certificate (1).pdf', '2025-11-20 03:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `instructorName` varchar(100) DEFAULT NULL,
  `instructorQualification` varchar(100) DEFAULT NULL,
  `instructorCategory` varchar(100) DEFAULT NULL,
  `instructorExperience` int(11) DEFAULT NULL,
  `instructorPicture` varchar(255) DEFAULT NULL,
  `instructorAddress` text DEFAULT NULL,
  `instructorMobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `instructorName`, `instructorQualification`, `instructorCategory`, `instructorExperience`, `instructorPicture`, `instructorAddress`, `instructorMobile`, `password`, `resume`, `status`) VALUES
(9, 'Arisha Khan', 'BSSE', 'Content Writing', 2, 'mypic.png', 'Attock Punjab', '03000000000000', '$2y$10$hsLfR9x9cpGmr3Guz6/KD.DFDPjDoDqAwcD2wvxgW3YJZkdRFszGu', NULL, 'approved'),
(15, 'Diya', 'BSCS', 'Web Developement', 3, 'img/instr_1763507393_Pi7_Passport_Photo.jpeg', 'ISB', '03000000000000', '$2y$10$96JUyV7bQr5hUF7pa3DH1ecK.6SUmd/cOx/.b4bV.iPm1D1yX984O', NULL, 'rejected'),
(16, 'Arisha Khan', 'BSCS', 'Seo Expert', 44, 'img/instr_1763599285_WhatsApp_Image_2025-11-17_at_12.33.20_AM.jpeg', 'mmm', '03000000000000', '$2y$10$2.Wglph8NXss0/OGc2/ODe0ihjUcxLKCahu6wTZyqR6Horu0evmRK', NULL, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_skills`
--

CREATE TABLE `instructor_skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `instructor_skills`
--

INSERT INTO `instructor_skills` (`id`, `skill_name`) VALUES
(1, 'Web Development'),
(2, 'SEO Expert'),
(3, 'Content Writing'),
(4, 'Digital Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `parent_student_links`
--

CREATE TABLE `parent_student_links` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parent_student_links`
--

INSERT INTO `parent_student_links` (`id`, `parent_id`, `student_id`, `status`, `requested_at`) VALUES
(3, 15, 16, 'approved', '2025-11-20 04:10:38'),
(4, 15, 13, 'pending', '2025-11-22 11:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quiz_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `instructor_id`, `course_id`, `quiz_title`, `created_at`, `quiz_description`) VALUES
(7, 15, 2, 'Graded Quiz', '2025-11-19 02:06:15', 'imp quiz');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(26, 7, 'SQL stand for', 'Structured query language', 'structured quote language', 'structured quete language', NULL, 'A'),
(27, 7, 'DBMS stand for', 'database', 'database management', 'database management system', NULL, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `obtained_marks` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `quiz_id`, `total_marks`, `obtained_marks`, `submitted_at`) VALUES
(2, 10, 4, 5, 3, '2025-05-06 02:56:29'),
(3, 11, 5, 5, 3, '2025-05-06 05:03:41'),
(4, 10, 5, 5, 1, '2025-05-06 05:29:21'),
(5, 10, 6, 5, 4, '2025-07-14 13:51:34'),
(6, 8, 4, 5, 5, '2025-07-14 14:04:04'),
(7, 8, 5, 5, 3, '2025-07-14 16:29:28'),
(8, 8, 6, 5, 4, '2025-07-14 17:11:46'),
(9, 16, 7, 2, 2, '2025-11-20 16:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `uploadvoucher`
--

CREATE TABLE `uploadvoucher` (
  `id` int(11) NOT NULL,
  `studentName` varchar(100) DEFAULT NULL,
  `instructorID` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uploadvoucher`
--

INSERT INTO `uploadvoucher` (`id`, `studentName`, `instructorID`, `filename`, `uploaded_at`, `email`, `status`, `user_id`) VALUES
(4, 'Diya', NULL, '../uploads/1763524564_WhatsApp Image 2025-11-17 at 12.33.55 AM.jpeg', '2025-11-19 03:56:04', 'diya@gmail.com', 'Verify', 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `role` enum('student','parent') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `contact`, `role`) VALUES
(15, 'Liaqat Ali', 'liaqat@gmail.com', '$2y$10$fwfmAn15O6rLx9Cn.zgEFe3yjxxha21mrQA6YL00w9YUuyJQNJDb2', '03014357855', 'parent'),
(16, 'Diya', 'diya@gmail.com', '$2y$10$Bp6.0AdGRp7I2MF5tI6Ql.sCy66CVfblSFXWGWvEsRragakLzuYNy', '03014357855', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `assignment_submitted` varchar(255) DEFAULT NULL,
  `challenge_submitted` varchar(255) DEFAULT NULL,
  `attendance_marked` tinyint(1) DEFAULT 0,
  `final_grade` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `user_id`, `course_id`, `assignment_submitted`, `challenge_submitted`, `attendance_marked`, `final_grade`) VALUES
(1, 16, 2, '1763617538_1763569852_VU Process Model.docx', '1763616625_srs.docx', 1, 96);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `class_links`
--
ALTER TABLE `class_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_materials`
--
ALTER TABLE `course_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor_skills`
--
ALTER TABLE `instructor_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_student_links`
--
ALTER TABLE `parent_student_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutor_id` (`instructor_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadvoucher`
--
ALTER TABLE `uploadvoucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class_links`
--
ALTER TABLE `class_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_materials`
--
ALTER TABLE `course_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `instructor_skills`
--
ALTER TABLE `instructor_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parent_student_links`
--
ALTER TABLE `parent_student_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `uploadvoucher`
--
ALTER TABLE `uploadvoucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_links`
--
ALTER TABLE `class_links`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_materials`
--
ALTER TABLE `course_materials`
  ADD CONSTRAINT `course_materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploadvoucher`
--
ALTER TABLE `uploadvoucher`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
