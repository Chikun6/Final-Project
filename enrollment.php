<?php
include 'db_connect.php';
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php"); // Redirect to login if not logged in as a student
    exit();
}

$student_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'] ?? 0;

// Check if course_id is valid
if ($course_id <= 0) {
    echo "Invalid course.";
    exit();
}

// Check if already enrolled
$enroll_check = $conn->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
$enroll_check->bind_param("ii", $student_id, $course_id);
$enroll_check->execute();
$enrolled = $enroll_check->get_result()->num_rows > 0;

if ($enrolled) {
    echo "You are already enrolled in this course.";
    exit();
}

// Enroll the student
$enroll_query = $conn->prepare("INSERT INTO enrollments (student_id, course_id,enrolled_at) VALUES (?, ?, NOW())");
$enroll_query->bind_param("ii", $student_id, $course_id);

if ($enroll_query->execute()) {
    header("Location: course-details.php?id=" . $course_id);
    exit();
} else {
    echo "Error enrolling in the course. Please try again later.";
}
?>
