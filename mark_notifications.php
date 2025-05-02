<?php
session_start();
require_once 'db_connect.php';

// Get student_id from session
$student_id = $_SESSION['user_id'] ?? null;

if ($student_id) {
    $stmt = $conn->prepare("UPDATE notifications SET status = 'seen' WHERE student_id = ? AND status = 'new'");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}

$conn->close();
?>
