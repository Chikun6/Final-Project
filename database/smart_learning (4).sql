-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 10:02 AM
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
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `certificate_path` varchar(255) NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `student_id`, `course_id`, `certificate_path`, `issued_at`) VALUES
(1, 19, 11, 'certificates/certificate_19_11.pdf', '2025-05-07 07:09:39');

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
(14, 11, 'Chapter - 1', '2025-05-04 04:33:42'),
(15, 11, 'Chapter-2', '2025-05-11 04:08:04'),
(16, 11, 'Chapter - 3', '2025-05-11 04:12:33');

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
(11, 14, 'Variables in Java | Lecture - 2', 42, 'uploads/videos/1746337580_Lecture 2.mp4', 1, '2025-05-04 05:46:20'),
(12, 15, 'Conditional Statements | Lecture - 3', 25, 'uploads/videos/1746936484_Lecture 3.mp4', 0, '2025-05-11 04:08:04'),
(14, 15, 'Loops In Java | Lecture - 4', 25, 'uploads/videos/1746936668_Lecture 3.mp4', 1, '2025-05-11 04:11:08'),
(15, 16, 'Functions & Methods | Lecture - 5', 27, 'uploads/videos/1746936754_Lecture 7.mp4', 0, '2025-05-11 04:12:34'),
(16, 16, 'Exercise Question | Lecture- 6', 2, 'uploads/videos/1746936893_Lecture 8.mp4', 1, '2025-05-11 04:14:53');

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

--
-- Dumping data for table `lecture_progress`
--

INSERT INTO `lecture_progress` (`id`, `student_id`, `course_id`, `lecture_id`, `watched`, `watched_at`, `progress_percent`) VALUES
(10, 19, 11, 10, 1, '2025-05-11 12:04:09', 100),
(11, 19, 11, 11, 1, '2025-05-11 12:06:48', 100),
(12, 19, 11, 12, 1, '2025-05-11 12:33:22', 100);

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
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `quiz_number` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `quiz_number`, `title`, `created_at`) VALUES
(4, 11, 1, 'Test-1', '2025-05-08 17:53:12'),
(5, 11, 2, 'Test-2', '2025-05-08 17:53:33'),
(6, 11, 3, 'Test-3', '2025-05-08 18:34:43'),
(7, 11, 4, 'Test-4', '2025-05-11 09:57:49'),
(8, 11, 5, 'Test-5', '2025-05-11 09:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` enum('a','b','c','d') NOT NULL,
  `explanation` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation`, `created_at`) VALUES
(1, 4, 'Which of the following is the correct way to declare a variable in Java?', 'int 1x = 10;', 'int x = 10;', 'float x = 10;', 'char = c;', 'b', 'Variable names must start with a letter; \"int x = 10;\" is the correct syntax.', '2025-05-11 11:53:12'),
(2, 4, 'What will be the output of: int x = 5; if (x > 2) { System.out.print(\"Hi\"); }', 'Nothing', 'Error', 'Hi', 'x', 'c', 'Since x > 2, the condition is true, so \"Hi\" will be printed.', '2025-05-11 11:53:12'),
(3, 4, 'Which loop guarantees execution of the loop body at least once?', 'for', 'while', 'do-while', 'foreach', 'c', 'The do-while loop executes the body first and checks the condition afterward.', '2025-05-11 11:53:12'),
(4, 4, 'What is the output of: int x = 3; while(x < 3) { x++; System.out.print(x); }', '3', '4', 'Nothing', 'Error', 'c', 'The condition x < 3 is false initially, so the loop does not execute.', '2025-05-11 11:53:12'),
(5, 4, 'Which keyword is used to terminate a loop immediately in Java?', 'exit', 'return', 'stop', 'break', 'd', 'The \"break\" statement exits a loop or switch statement immediately.', '2025-05-11 11:53:12'),
(6, 4, 'Which of the following is an invalid variable name in Java?', 'value_123', '123value', 'value123', 'value-123', 'b', 'Variable names cannot start with a digit, so \"123value\" is invalid.', '2025-05-11 11:53:12'),
(7, 4, 'What is the output of the following code: int x = 0; for (int i = 0; i < 3; i++) { x += i; } System.out.print(x);', '3', '2', '1', '0', 'a', 'The sum of 0 + 1 + 2 is 3, so x will be 3.', '2025-05-11 11:53:12'),
(8, 4, 'What is the result of: boolean a = true; boolean b = false; System.out.print(a && b);', 'true', 'false', '1', '0', 'b', 'The \"&&\" operator returns true only if both operands are true; in this case, it is false.', '2025-05-11 11:53:12'),
(9, 4, 'What does the \"continue\" statement do in a loop?', 'Stops the loop entirely', 'Skips to the next iteration', 'Exits the loop with return value', 'Restarts the loop', 'b', 'The \"continue\" statement skips the current iteration and continues with the next one.', '2025-05-11 11:53:12'),
(10, 4, 'Which of the following is NOT a valid loop structure in Java?', 'for', 'foreach', 'while', 'loop', 'd', '\"loop\" is not a valid loop keyword in Java.', '2025-05-11 11:53:12'),
(11, 5, 'What will be the output of the following code: int[] arr = {1, 2, 3}; System.out.println(arr[1]);', '1', '2', '3', 'Error', 'b', 'The code prints the value at index 1, which is 2.', '2025-05-11 11:55:03'),
(12, 5, 'Which of the following is the correct syntax to declare an array in Java?', 'int arr[] = new int[5];', 'int[] arr = new int[5];', 'int arr[5];', 'int[] arr = new int();', 'b', 'The correct syntax is \"int[] arr = new int[5];\".', '2025-05-11 11:55:03'),
(13, 5, 'What will be the output of the following code: int[] arr = {1, 2, 3}; System.out.println(arr.length);', '1', '2', '3', 'Error', 'c', 'The length of the array is 3, so it prints 3.', '2025-05-11 11:55:03'),
(14, 5, 'Which of the following statements correctly calls a function in Java?', 'functionName()', 'call functionName()', 'invoke functionName()', 'execute functionName()', 'a', 'To call a function in Java, you simply use the function name followed by parentheses: functionName().', '2025-05-11 11:55:03'),
(15, 5, 'What is the output of the following code: public static void main(String[] args) { int[] arr = {5, 10, 15}; System.out.println(arr[0] + arr[2]); }', '10', '15', '20', '25', 'd', 'The sum of arr[0] + arr[2] is 5 + 15, which equals 20.', '2025-05-11 11:55:03'),
(16, 5, 'Which of the following methods is used to find the length of an array in Java?', 'size()', 'length()', 'getLength()', 'length', 'b', 'The correct method to find the length of an array is \"arr.length\".', '2025-05-11 11:55:03'),
(17, 5, 'How do you pass an array to a function in Java?', 'functionName(arr[]);', 'functionName(arr);', 'functionName(int[] arr);', 'functionName(int arr[]);', 'b', 'To pass an array, you just pass the array name: functionName(arr);', '2025-05-11 11:55:03'),
(18, 5, 'What will be the output of the following code: public static void main(String[] args) { int[] arr = {4, 5, 6}; System.out.println(arr[3]); }', '4', '5', '6', 'Error', 'd', 'The array index is out of bounds since there is no arr[3]. The maximum valid index is 2.', '2025-05-11 11:55:03'),
(19, 5, 'Which of the following can you use to pass an array of integers to a method?', 'int[] arr', 'arr[]', 'int arr[]', 'All of the above', 'd', 'All of the options are valid ways to pass an array to a method.', '2025-05-11 11:55:03'),
(20, 5, 'Which function is used to copy one array to another in Java?', 'copy()', 'clone()', 'arraycopy()', 'copyArray()', 'c', 'The correct function to copy an array in Java is \"System.arraycopy()\".', '2025-05-11 11:55:03'),
(21, 6, 'What will be the output of the following code: String str = \"Hello\"; System.out.println(str.length());', '4', '5', '6', 'Error', 'b', 'The length of the string \"Hello\" is 5.', '2025-05-11 11:56:29'),
(22, 6, 'Which of the following methods is used to convert a string to lowercase in Java?', 'toLowerCase()', 'toLower()', 'lowerCase()', 'toLowerCaseExact()', 'a', 'The correct method to convert a string to lowercase is \"toLowerCase()\".', '2025-05-11 11:56:29'),
(23, 6, 'What is the output of the following code: String str = \"Hello\"; System.out.println(str.charAt(1));', 'H', 'e', 'l', 'o', 'b', 'The character at index 1 of the string \"Hello\" is \"e\".', '2025-05-11 11:56:29'),
(24, 6, 'Which method is used to check if two strings are equal in Java?', 'equals()', 'compare()', 'equalsIgnoreCase()', 'isEqual()', 'a', 'The correct method to check string equality is \"equals()\".', '2025-05-11 11:56:29'),
(25, 6, 'What will be the output of the following code: String str = \"Java\"; str = str.concat(\" Rocks!\"); System.out.println(str);', 'Java Rocks!', 'JavaRocks!', 'Java Rocks!', 'Error', 'a', 'The \"concat()\" method appends the string \"Rocks!\" to \"Java\".', '2025-05-11 11:56:29'),
(26, 6, 'What will the following code output: String str = \"abc\"; System.out.println(str.substring(1));', 'ab', 'bc', 'a', 'bc', 'b', 'The substring starting from index 1 is \"bc\".', '2025-05-11 11:56:29'),
(27, 6, 'Which method is used to split a string into an array in Java?', 'split()', 'divide()', 'substring()', 'separate()', 'a', 'The \"split()\" method is used to split a string into an array.', '2025-05-11 11:56:29'),
(28, 6, 'What will be the output of the following code: String str = \"apple\"; System.out.println(str.toUpperCase());', 'apple', 'APPLE', 'Error', 'apple', 'b', 'The \"toUpperCase()\" method converts the string to uppercase, which results in \"APPLE\".', '2025-05-11 11:56:29'),
(29, 6, 'Which of the following methods is used to replace a character in a string?', 'replace()', 'replaceAll()', 'substitute()', 'change()', 'a', 'The \"replace()\" method is used to replace a character in a string.', '2025-05-11 11:56:29'),
(30, 6, 'What is the output of the following code: String str = \"123\"; System.out.println(Integer.parseInt(str));', '123', 'Error', '123.0', '0', 'a', 'The \"Integer.parseInt()\" method converts the string \"123\" into the integer 123.', '2025-05-11 11:56:29'),
(31, 7, 'What is the result of the following bitwise operation: 5 & 3?', '5', '3', '1', '0', 'c', '5 in binary is 101, 3 is 011. The AND operation results in 001, which is 1.', '2025-05-11 12:00:43'),
(32, 7, 'Which operator is used for bitwise XOR in Java?', '&', '|', '^', '~', 'c', 'The bitwise XOR operator is \"^\".', '2025-05-11 12:00:43'),
(33, 7, 'What will be the output of the following code: System.out.println(5 << 1);', '10', '5', '1', '20', 'a', 'The left shift operator \"<<\" shifts the bits to the left by 1 position, multiplying by 2. 5 << 1 results in 10.', '2025-05-11 12:00:43'),
(34, 7, 'Which of the following is the correct bitwise OR operation between 5 and 3?', '1', '7', '6', '15', 'b', 'The OR operation between 5 (101) and 3 (011) results in 7 (111).', '2025-05-11 12:00:43'),
(35, 7, 'What is the result of the bitwise NOT operation on 5?', '5', '10', '-6', 'Error', 'c', 'The bitwise NOT of 5 (~5) results in -6, as the bits are inverted.', '2025-05-11 12:00:43'),
(36, 7, 'What is the output of the following code: System.out.println(8 >> 2);', '8', '4', '2', '1', 'b', 'The right shift operator \">>\" divides the number by 2 for each shift. 8 >> 2 results in 2.', '2025-05-11 12:00:43'),
(37, 7, 'What will be the result of performing the AND operation on 0 and 1?', '0', '1', 'Error', '0.5', 'a', 'The AND operation between 0 and 1 results in 0.', '2025-05-11 12:00:43'),
(38, 7, 'Which method in Java is used to sort an array of integers?', 'sort()', 'arrange()', 'sortArray()', 'Arrays.sort()', 'd', 'The \"Arrays.sort()\" method is used to sort an array of integers.', '2025-05-11 12:00:43'),
(39, 7, 'What is the time complexity of the merge sort algorithm?', 'O(n)', 'O(n log n)', 'O(log n)', 'O(n^2)', 'b', 'Merge sort has a time complexity of O(n log n).', '2025-05-11 12:00:43'),
(40, 7, 'Which of the following is the correct sorted order of the array [4, 2, 3, 1] using bubble sort?', '1, 2, 3, 4', '4, 3, 2, 1', '2, 1, 4, 3', '4, 2, 3, 1', 'a', 'Bubble sort sorts the array by repeatedly swapping adjacent elements, resulting in [1, 2, 3, 4].', '2025-05-11 12:00:43'),
(41, 8, 'Which of the following is a feature of object-oriented programming?', 'Encapsulation', 'Polymorphism', 'Inheritance', 'All of the above', 'd', 'OOP includes features like Encapsulation, Polymorphism, Inheritance, and Abstraction.', '2025-05-11 12:02:02'),
(42, 8, 'What is encapsulation in Java?', 'Hiding the implementation details', 'Inheritance of objects', 'Sharing methods across classes', 'None of the above', 'a', 'Encapsulation involves hiding the internal details of an object and exposing only necessary functionalities.', '2025-05-11 12:02:02'),
(43, 8, 'Which of the following is true about polymorphism?', 'It allows objects to be created without a class', 'It allows methods to have the same name but different signatures', 'It is the process of hiding an object\'s state', 'None of the above', 'b', 'Polymorphism allows methods to have the same name but behave differently based on their input parameters.', '2025-05-11 12:02:02'),
(44, 8, 'What does inheritance mean in Java?', 'A class can inherit properties and methods from another class', 'A method can inherit another method', 'A class can inherit multiple classes', 'None of the above', 'a', 'Inheritance allows a class to inherit properties and behaviors (methods) from another class.', '2025-05-11 12:02:02'),
(45, 8, 'Which of the following is an example of method overloading in Java?', 'Two methods with the same name but different return types', 'Two methods with the same name but different parameters', 'Two methods with the same name and same parameters', 'None of the above', 'b', 'Method overloading occurs when two methods have the same name but different parameters.', '2025-05-11 12:02:02'),
(46, 8, 'What is the purpose of the \"super\" keyword in Java?', 'To call a method from the parent class', 'To define a class variable', 'To call a constructor in the current class', 'To access private methods of a class', 'a', 'The \"super\" keyword is used to access the methods and constructors of a parent class.', '2025-05-11 12:02:02'),
(47, 8, 'What is the difference between an abstract class and an interface in Java?', 'An abstract class can have method definitions, while an interface cannot', 'An interface can have concrete methods, while an abstract class cannot', 'An interface can have constructors, while an abstract class cannot', 'None of the above', 'a', 'An abstract class can have both abstract and concrete methods, while an interface only defines abstract methods (until Java 8).', '2025-05-11 12:02:02'),
(48, 8, 'What is the output of the following code: System.out.println(10 / 4);', '2', '2.5', '3', 'Error', 'a', 'In integer division, the fractional part is discarded, so the result of 10 / 4 is 2.', '2025-05-11 12:02:02'),
(49, 8, 'Which of the following is used to define a constructor in Java?', 'function()', 'constructor()', 'ClassName()', 'void()', 'c', 'In Java, constructors are defined with the same name as the class, i.e., ClassName().', '2025-05-11 12:02:02'),
(50, 8, 'What is the result of trying to access a private method of a class from another class?', 'The code will run successfully', 'A compilation error will occur', 'It will give a runtime error', 'None of the above', 'b', 'A private method can only be accessed within the class it is defined; trying to access it from another class will result in a compilation error.', '2025-05-11 12:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_submissions`
--

INSERT INTO `quiz_submissions` (`id`, `quiz_id`, `student_id`, `score`, `submitted_at`) VALUES
(8, 4, 19, 8, '2025-05-11 12:32:41'),
(9, 5, 19, 5, '2025-05-11 12:34:51');

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
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

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
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `student_id` (`student_id`);

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
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `lecture_progress`
--
ALTER TABLE `lecture_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

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
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_submissions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quiz_submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

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
