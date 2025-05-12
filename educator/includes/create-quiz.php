<?php
include './../../db_connect.php';

$course_id = $_POST['course_id'];


$res = $conn->query("SELECT COUNT(*) AS total FROM quizzes WHERE course_id = $course_id");

$row = $res->fetch_assoc();
$total_quizzes = $row['total'];


if ($total_quizzes >= 5) {
    echo "max_quizzes_reached";
    exit;
}


$quiz_name = "Test-" . ($total_quizzes + 1);


$stmt = $conn->prepare("INSERT INTO quizzes (course_id, title, created_at, quiz_number) VALUES (?, ?, NOW(), ?)");
$quiz_number = $total_quizzes + 1;
$stmt->bind_param("isi", $course_id, $quiz_name, $quiz_number);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
?>
