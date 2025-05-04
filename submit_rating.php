<?php
$course_id = $_POST['course_id'];
$student_id = $_POST['student_id'];
$rating = $_POST['rating'];

$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check if rating exists
$check = "SELECT id FROM ratings WHERE course_id = $course_id AND student_id = $student_id";
$res = $conn->query($check);

if ($res->num_rows > 0) {
    // Update existing rating
    $update = "UPDATE ratings SET rating = $rating, created_at = NOW() WHERE course_id = $course_id AND student_id = $student_id";
    $conn->query($update);
} else {
    // Insert new rating
    $insert = "INSERT INTO ratings (course_id, student_id, rating) VALUES ($course_id, $student_id, $rating)";
    $conn->query($insert);
}

$conn->close();
header("Location: course_rating.php"); // Redirect back
exit;
?>



