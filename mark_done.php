<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id'];
$student_id = $_SESSION['user_id'];

$conn->query("UPDATE study_plan SET completed = 1 WHERE id = $id AND student_id = $student_id");

$_SESSION['message'] = "Task marked as completed!";
header("Location: st_dashboard.php");
exit;
?>
