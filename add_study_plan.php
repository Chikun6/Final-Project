<?php
session_start();
include 'db_connect.php';

$student_id = $_SESSION['user_id'];
$subject = $_POST['subject'];
$task = $_POST['task'];
$datetime = $_POST['datetime'];

$stmt = $conn->prepare("INSERT INTO study_plan (student_id, subject, task, datetime) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $student_id, $subject, $task, $datetime);
$stmt->execute();

header("Location: study_plan.php");
exit;
?>