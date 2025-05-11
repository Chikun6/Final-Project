<?php

include './../../db_connect.php';
$course_id = $_POST['course_id'];

$res = $conn->query("SELECT COUNT(*) AS total FROM quizzes WHERE course_id = $course_id");
$row = $res->fetch_assoc();
$quiz_name = "Test-" . ($row['total'] + 1);

$stmt = $conn->prepare("INSERT INTO quizzes (course_id, title, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $course_id, $quiz_name);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
