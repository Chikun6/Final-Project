-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 05:32 PM
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
-- Database: `smart_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `chapter_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `course_id`, `chapter_name`, `created_at`) VALUES
(14, 11, 'Chapter - 1', '2025-05-04 04:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `exam_pattern` text NOT NULL,
  `syllabus` text NOT NULL,
  `preparation_roadmap` text NOT NULL,
  `youtube_links` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `exam_pattern`, `syllabus`, `preparation_roadmap`, `youtube_links`) VALUES
(1, 'TCS', 'Sections: Aptitude, Logical Reasoning, Verbal Ability, Programming Logic, Coding.', 'Topics: Quantitative Aptitude, Verbal, C Programming, Data Structures, Basic Algorithms.', 'Step 1: Understand the pattern. Step 2: Solve previous papers. Step 3: Practice Aptitude & Coding.', 'https://youtu.be/c-3G69x3YcM?list=PLYA_1SYVpPQyMIEGlCkE68U7Qd-Q_Naqh,https://youtu.be/c-3G69x3YcM?list=PLYA_1SYVpPQyMIEGlCkE68U7Qd-Q_Naqh'),
(2, 'Wipro', 'Sections: Aptitude Test, Written Communication Test, Online Programming Test, HR Interview.', 'Topics: Quantitative Aptitude, Logical Reasoning, Essay Writing Skills, Programming in C, Java, Python.', 'Step 1: Focus on Aptitude and Essay Writing. Step 2: Practice coding on platforms like HackerRank. Step 3: Prepare for behavioral HR questions.', 'https://youtu.be/fDMtx8rxN6M,https://youtu.be/fDMtx8rxN6M'),
(3, 'Infosys', 'Sections: Reasoning Ability, Mathematical Ability, Verbal Ability, Pseudocode Test, Puzzle Solving.', 'Topics: Data Interpretation, Logical Reasoning, Arithmetic, Grammar, Pseudocode Problems.', 'Step 1: Master logical reasoning and quantitative aptitude. Step 2: Practice pseudocode questions. Step 3: Work on puzzles and brain teasers.', 'https://youtu.be/Jk8-Oa79jgo,https://youtu.be/Jk8-Oa79jgo');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `educator_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `topics` text NOT NULL,
  `category` varchar(200) NOT NULL,
  `level` varchar(200) NOT NULL,
  `thumbnail` varchar(200) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `tags` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `educator_id`, `title`, `description`, `topics`, `category`, `level`, `thumbnail`, `price`, `discount`, `tags`, `created_at`) VALUES
(11, 20, 'Java', 'Java is a powerful, platform-independent, object-oriented programming language widely used for building desktop, web, and mobile applications. It follows the principle of \"write once, run anywhere\" using the Java Virtual Machine (JVM). Java supports multithreading, strong memory management, and robust security features, making it ideal for scalable enterprise-level applications.', 'Java Basics, Data Types, Variables, Operators, Control Flow (if, switch, loops), Methods, Object-Oriented Programming, Classes and Objects, Inheritance, Polymorphism, Abstraction, Encapsulation, Arrays, Strings, Exception Handling, Collections Framework, Generics, File I/O, Multithreading, Synchronization, JDBC, JavaFX, Applets, Servlets, JSP, Lambda Expressions, Stream API, Annotations, Enums, Wrapper Classes, Java Memory Management, Garbage Collection, JVM Architecture, JUnit Testing, Maven, Gradle, Spring Framework, Spring Boot, Hibernate, Microservices, Design Patterns, Networking, Serialization, Java Security, Java 8 Features, Functional Interfaces, Modules (Java 9+).', 'Programming', 'Intermediate', 'uploads/6815bd23b50cb.jpg', 999, 10, 'backend', '2025-05-03 06:52:19'),
(12, 20, 'Web-developement', 'Web development is the process of creating websites or web applications using technologies like HTML, CSS, JavaScript, and backend languages such as PHP, Python, or Java. It involves both frontend (user interface) and backend (server-side logic) development, ensuring functionality, responsiveness, security, and a seamless user experience across devices and platforms.', 'HTML, CSS, JavaScript, Responsive Design, DOM Manipulation, Bootstrap, Tailwind CSS, Git and GitHub, Web Accessibility, SEO Basics, Frontend Frameworks (React, Angular, Vue), Backend Development, Node.js, Express.js, PHP, Python (Flask, Django), Java (Spring Boot), Databases (MySQL, MongoDB), RESTful APIs, Authentication & Authorization, CRUD Operations, MVC Architecture, JSON, AJAX, Web Hosting, Deployment (Netlify, Vercel, Heroku), Version Control, API Integration, Sessions and Cookies, Web Security (HTTPS, SQL Injection, XSS), CMS (WordPress), Testing & Debugging, WebSockets, Progressive Web Apps (PWA), CI/CD Basics.', 'Web Development', 'Advanced', 'uploads/6815bdbbb479e.jpg', 4999, 25, 'fullstack', '2025-05-03 06:54:51'),
(13, 20, 'PHP', 'PHP is a popular server-side scripting language designed for web development. This course covers PHP fundamentals, syntax, form handling, sessions, cookies, file handling, and database connectivity using MySQL. Learners will build dynamic, interactive websites and understand how PHP integrates with HTML, CSS, and JavaScript to power backend web functionality', 'PHP Basics, Syntax, Variables, Data Types, Operators, Control Structures (if, else, switch, loops), Functions, Arrays, Strings, Form Handling, GET and POST Methods, File Handling, Sessions, Cookies, Include/Require, Error Handling, Object-Oriented Programming (OOP), Classes and Objects, Inheritance, Constructors, Database Connectivity (MySQL), PDO, CRUD Operations, User Authentication, File Upload, Email Sending, Date and Time Functions, Regular Expressions, PHP and JavaScript Integration, JSON Handling, Security Practices (SQL Injection Prevention, XSS), PHP Frameworks (Laravel, CodeIgniter), REST API with PHP, MVC Architecture, PHP Configuration, Deployment and Hosting', 'Web Development', 'Intermediate', 'uploads/6815be2aac4ee.png', 1999, 10, 'fullstack', '2025-05-03 06:56:42'),
(14, 20, 'PYTHON', 'This Python course covers the fundamentals of programming, including variables, data types, loops, and functions. It introduces object-oriented programming (OOP) concepts, file handling, and error management. Learners will explore advanced topics like web development with Flask, data analysis with Pandas, and machine learning with popular libraries such as Scikit-learn.\r\n\r\n\r\n\r\nThis Python course covers the fundamentals of programming, including variables, data types, loops, and functions. It introduces object-oriented programming (OOP) concepts, file handling, and error management. Learners will explore advanced topics like web development with Flask, data analysis with Pandas, and machine learning with popular libraries such as Scikit-learn.\r\n\r\n\r\n\r\n\r\n\r\n\r\nThis Python course covers the fundamentals of programming, including variables, data types, loops, and functions. It introduces object-oriented programming (OOP) concepts, file handling, and error management. Learners will explore advanced topics like web development with Flask, data analysis with Pandas, and machine learning with popular libraries such as Scikit-learn.\r\n\r\n', 'Python Basics, Variables, Data Types, Operators, Control Flow (if, else, loops), Functions, Modules and Packages, Lists, Tuples, Dictionaries, Sets, Exception Handling, File I/O, Object-Oriented Programming (OOP), Classes and Objects, Inheritance, Polymorphism, Lambda Functions, Decorators, Generators, Iterators, Regular Expressions, Python Libraries (NumPy, Pandas, Matplotlib), Web Development (Flask, Django), Database Connectivity (SQLite, MySQL), Multithreading, Networking, Unit Testing (unittest, pytest), Virtual Environments, Pythonic Code, Data Structures, Algorithms, JSON Handling, APIs, Data Analysis, Machine Learning (TensorFlow, Scikit-learn), Web Scraping, Flask/Django, Automation, Python Security.', 'Design', 'Advanced', 'uploads/6815beafaf7a9.jpg', 3999, 45, 'backend', '2025-05-03 06:58:55'),
(15, 20, 'IOT', 'The IoT course introduces the fundamentals of Internet of Things, covering device communication, sensors, microcontrollers (e.g., Arduino, Raspberry Pi), wireless protocols (Wi-Fi, Bluetooth), and cloud integration. Students will learn to build and manage IoT systems, create data-driven applications, and explore security and scalability challenges in IoT solutions', 'Introduction to IoT, IoT Architecture, IoT Protocols (MQTT, HTTP, CoAP), Sensors and Actuators, Microcontrollers (Arduino, Raspberry Pi), Wireless Communication (Wi-Fi, Bluetooth, Zigbee), IoT Data Collection and Processing, Cloud Integration (AWS IoT, Google Cloud), IoT Security, Data Analytics, IoT in Smart Homes, Smart Cities, and Healthcare, IoT Platforms, IoT Protocols (LPWAN, NB-IoT), IoT Hardware (GPIO, ADC), Embedded Systems, IoT Application Development, IoT Software Development, IoT Protocols and APIs, Real-time Data Processing, IoT Data Storage, IoT Device Management, IoT Edge Computing, Power Management for IoT Devices, IoT Networking, IoT Application Design, IoT Automation, IoT Data Visualization', 'Design', 'Intermediate', 'uploads/6815bf1d6caab.png', 999, 25, 'database', '2025-05-03 07:00:45'),
(16, 21, 'Cyber Security', 'The Cybersecurity course covers essential topics such as network security, encryption, ethical hacking, penetration testing, risk management, firewalls, and intrusion detection systems (IDS). It explores techniques for securing data, systems, and networks, and focuses on identifying vulnerabilities, preventing cyberattacks, and ensuring compliance with security regulations and best practices.', 'Introduction to Cybersecurity, Cyber Threats and Attacks, Network Security, Cryptography and Encryption, Firewalls and VPNs, Ethical Hacking, Penetration Testing, Vulnerability Assessment, Malware and Ransomware, Intrusion Detection and Prevention Systems (IDS/IPS), Risk Management, Security Protocols, Public Key Infrastructure (PKI), Authentication and Authorization, Security Policies and Frameworks, Incident Response and Handling, Data Protection and Privacy, Cloud Security, Web Application Security, Phishing and Social Engineering, Cybersecurity Compliance (GDPR, HIPAA, PCI-DSS), Security Audits, Security Monitoring, Mobile Security, IoT Security, Security in DevOps, Blockchain Security, Digital Forensics, Security Best Practices, Security Tools (Wireshark, Metasploit), Cybersecurity Threat Intelligence, Cybersecurity in Critical Infrastructure.', 'Programming', 'Intermediate', 'uploads/6815c0b53abd4.jpg', 2999, 20, '', '2025-05-03 07:07:33'),
(17, 22, 'MY SQL', 'MySQL is an open-source relational database management system (RDBMS) that uses SQL (Structured Query Language) for managing and querying data. It offers robust features like data integrity, ACID compliance, scalability, and security. MySQL is widely used in web applications for storing, retrieving, and managing large amounts of structured data efficiently.', 'MySQL Basics, Database Design, Data Types, Operators, SQL Queries (SELECT, INSERT, UPDATE, DELETE), Joins (INNER, LEFT, RIGHT, FULL), Subqueries, Group By, Having, Aggregate Functions (COUNT, AVG, SUM, MIN, MAX), Sorting and Filtering Data, Normalization, Denormalization, Primary Keys, Foreign Keys, Indexes, Transactions, ACID Properties, Stored Procedures, Functions, Triggers, Views, Constraints, Data Integrity, Backup and Restore, User Management, Privileges, Security Best Practices, Query Optimization, Performance Tuning, Foreign Key Constraints, Data Import/Export, Replication, MySQL Workbench, Query Profiling, Backup Strategies, Advanced SQL Techniques, Sharding and Partitioning.', 'Data Science', 'Intermediate', 'uploads/6815c19adf75f.png', 499, 5, 'database', '2025-05-03 07:11:22'),
(18, 22, 'Cloud Computing', 'Cloud Computing is a technology that delivers computing services—such as storage, databases, networking, software, and analytics—over the internet. This course explores cloud models (IaaS, PaaS, SaaS), virtualization, deployment strategies, scalability, and security. Learners gain hands-on experience with platforms like AWS, Azure, and Google Cloud to build cloud-based solutions', 'Introduction to Cloud Computing, Cloud Service Models (IaaS, PaaS, SaaS), Deployment Models (Public, Private, Hybrid, Community), Virtualization, Cloud Architecture, Cloud Storage, Cloud Networking, Cloud Security, Cloud Resource Management, AWS Basics, Azure Fundamentals, Google Cloud Platform (GCP), Identity and Access Management (IAM), Serverless Computing, Containers (Docker, Kubernetes), Auto-scaling, Load Balancing, Cloud Monitoring and Logging, Cost Management, Cloud Migration, Disaster Recovery, Edge Computing, Compliance and Governance in Cloud, DevOps in Cloud, CI/CD Pipelines, Cloud Databases, Cloud Application Development, API Management, Cloud Backup, Multi-Cloud Strategy, Real-time Cloud Use Cases, Cloud Automation Tools (Terraform, Ansible).', 'Design', 'Intermediate', 'uploads/6815c22e6bcb8.png', 3999, 40, '', '2025-05-03 07:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `enrolled_at`) VALUES
(1, 19, 18, '2025-05-03 12:53:29'),
(2, 19, 11, '2025-05-04 11:18:21'),
(3, 19, 17, '2025-05-05 12:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `is_preview` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `chapter_id`, `title`, `duration`, `video_url`, `is_preview`, `created_at`) VALUES
(10, 14, 'Introduction to Java | Lecture - 1', 18, 'uploads/videos/1746333222_Lecture 1.mp4', 0, '2025-05-04 04:33:42'),
(11, 14, 'Variables in Java | Lecture - 2', 42, 'uploads/videos/1746337580_Lecture 2.mp4', 1, '2025-05-04 05:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `lecture_progress`
--

CREATE TABLE `lecture_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `watched` tinyint(1) DEFAULT 0,
  `watched_at` datetime DEFAULT current_timestamp(),
  `progress_percent` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','seen') DEFAULT 'new',
  `type` enum('info','update','alert') DEFAULT 'info',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study_plan`
--

CREATE TABLE `study_plan` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `task` text NOT NULL,
  `datetime` datetime NOT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `study_plan`
--

INSERT INTO `study_plan` (`id`, `student_id`, `subject`, `task`, `datetime`, `completed`) VALUES
(3, 19, 'Web-Developement', 'Create a small Project', '2025-05-06 11:00:00', 1),
(4, 19, 'DBMS', 'Revised Normalisation', '2025-05-05 13:40:00', 0),
(5, 19, 'java', 'JDBC description', '2025-05-07 14:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `image` varchar(200) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `image`, `otp`, `otp_expires_at`, `is_verified`) VALUES
(19, 'Manas Ranjan Mohanta', 'ranjanmohantamanas1@gmail.com', '$2y$10$QAoyKquBVN.2nH8H/FsqOOno4kdzridBg4.ieirKAFz.GgYnT6zIa', 'student', 'uploads/6815bb070d59f.jpg', NULL, NULL, 1),
(20, 'Satyaranjan Sahoo', 'sahoosatyaranjan998@gmail.com', '$2y$10$C9T.iplKCTjZ6BlZ3QjXleRksN67sPf3yq/pFykagITfN0n8Aqu9e', 'educator', 'uploads/6815bb7de6f98.jpeg', NULL, NULL, 1),
(21, 'Hemanta', 'hemantamahanta2950@gmail.com', '$2y$10$zcHvhf1gwEo9h7Obo02YyeSPcdir/aRT2hRBtENvTMZPdu0Jg5P8y', 'educator', 'uploads/6815bff67213c.jpeg', NULL, NULL, 1),
(22, 'Manas', 'lipunkumar805@gmail.com', '$2y$10$yK6W6.yvUa/S3CEc5qCn.u12eLAyaorii6W80zrBGyQtspBXymFF2', 'educator', 'uploads/6815c108d3b7c.jpeg', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educator_id` (`educator_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indexes for table `lecture_progress`
--
ALTER TABLE `lecture_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_lecture` (`student_id`,`lecture_id`),
  ADD KEY `fk_lp_course` (`course_id`),
  ADD KEY `fk_lp_lecture` (`lecture_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `study_plan`
--
ALTER TABLE `study_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lecture_progress`
--
ALTER TABLE `lecture_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `study_plan`
--
ALTER TABLE `study_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`educator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`);

--
-- Constraints for table `lecture_progress`
--
ALTER TABLE `lecture_progress`
  ADD CONSTRAINT `fk_lp_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lp_lecture` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lp_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `study_plan`
--
ALTER TABLE `study_plan`
  ADD CONSTRAINT `study_plan_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
