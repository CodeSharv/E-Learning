-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 06:59 PM
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
-- Database: `e-learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(3) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(0, 'admin@ex.com', '111');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` decimal(5,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `Title`, `description`, `price`) VALUES
(1, 'HTML', 'HTML, or Hypertext Markup Language, is the standard language for creating web pages and defining their structure. It uses a system of elements and tags to annotate content, telling browsers how to display text, images, links, and other media. HTML\'s purpose is to structure web content, and it is a foundational building block of the web, though it is often used with CSS for styling and JavaScript for interactivity. ', '100'),
(2, 'Java', 'Java is a widely-used, object-oriented, and platform-independent programming language designed for creating software applications that can run on billions of devices. It is known for being \"Write Once, Run Anywhere\" (WORA), meaning compiled Java code can be executed on any platform that supports Java without needing to be recompiled. Key applications of Java include Android apps, web applications, enterprise software, and video games. ', '0'),
(6, 'opencv', 'OpenCV is a free, open-source library for real-time computer vision and machine learning. It provides a shared infrastructure for computer vision applications, making it easier to build sophisticated applications for tasks like image and video analysis, object recognition, and face detection. OpenCV is available in several languages, including Python, C++, and Java, and works on multiple platforms like Windows, Linux, macOS, iOS, and Android. ', '0');

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `course_id` int(4) NOT NULL,
  `student_id` int(4) NOT NULL,
  `enrolment_datetime` date NOT NULL,
  `completed_datetime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`course_id`, `student_id`, `enrolment_datetime`, `completed_datetime`) VALUES
(2, 1, '2025-11-07', '0000-00-00'),
(1, 5, '2025-11-08', '2025-11-08'),
(6, 6, '2025-11-08', '2025-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `module_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(4) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `course_order` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `module_id`, `name`, `number`, `video_url`, `details`, `course_order`) VALUES
(1, 1, 'Tags', 1, 'https://youtu.be/HcOc7P5BMi4?si=l67TZkW30FxHXJST', 'HTML tags are the fundamental building blocks used to structure and format content on web pages. They provide instructions to web browsers on how to render text, images, links, and other media. \r\nKey characteristics of HTML tags:\r\nEnclosed in angle bracke', 'unit 1'),
(2, 1, 'HTML Geolocation', 2, 'https://www.youtube.com/watch?v=c_pR2Pzj7fo', 'The HTML Geolocation is used to get the geographical position of a user. Due to privacy concerns, this position requires user approval. Geo-location in HTML5 is used to share the location with some websites and be aware of the exact location. It is mainly', '2'),
(3, 6, 'Introduction', 1, 'https://www.youtube.com/watch?v=Z78zbnLlPUA&t=2s', 'OpenCV (Open Source Computer Vision Library: http://opencv.org) is an open-source library that includes several hundreds of computer vision algorithms. The document describes the so-called OpenCV 2.x API, which is essentially a C++ API, as opposed to the ', '1');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `course_id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `course_order` int(4) NOT NULL,
  `min_pass` int(3) NOT NULL,
  `req_pass` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `course_id`, `name`, `number`, `course_order`, `min_pass`, `req_pass`) VALUES
(2, 1, 'Html', 1, 1, 10, 40),
(3, 6, 'Introduction', 1, 1, 10, 40);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answer`
--

CREATE TABLE `quiz_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(4) NOT NULL,
  `answers` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_answer`
--

INSERT INTO `quiz_answer` (`id`, `question_id`, `answers`, `is_correct`) VALUES
(13, 4, 'HyperText Markup Language', 1),
(14, 4, 'High-Level Text Management Language', 0),
(15, 4, 'Hyperlink and Text Markup Language', 0),
(16, 4, 'Home Tool Markup Language', 0),
(17, 5, 'Open Computer Vector', 0),
(18, 5, 'Open Computer Vision', 1),
(19, 5, 'Open Common Vector', 0),
(20, 5, 'Open Common Vision', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `id` int(11) NOT NULL,
  `quiz_id` int(4) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`id`, `quiz_id`, `question`) VALUES
(4, 2, 'What does HTML stand for?'),
(5, 3, 'What is the full name of OpenCV?');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Name` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `email`, `password`, `Name`) VALUES
(1, 'xrv@gmail.com', '5367687', 'xrv'),
(5, 'abc@gmail.com', '111', 'abc'),
(6, 'xyz@gmail.com', '111', 'xyz'),
(7, 'aryan@gmail.com', '222', 'aryan');

-- --------------------------------------------------------

--
-- Table structure for table `student_lesson`
--

CREATE TABLE `student_lesson` (
  `student_id` int(4) NOT NULL,
  `lesson_id` int(4) NOT NULL,
  `completed_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_quiz`
--

CREATE TABLE `student_quiz` (
  `student_id` int(4) NOT NULL,
  `quiz_id` int(4) NOT NULL,
  `attempt_date` datetime NOT NULL,
  `score` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_quiz`
--

INSERT INTO `student_quiz` (`student_id`, `quiz_id`, `attempt_date`, `score`) VALUES
(5, 2, '2025-11-08 17:51:43', 100),
(5, 2, '2025-11-08 18:10:53', 100),
(5, 2, '2025-11-08 18:11:23', 100),
(6, 3, '2025-11-08 18:41:14', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_answer`
--
ALTER TABLE `quiz_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_answer`
--
ALTER TABLE `quiz_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
