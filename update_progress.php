<?php
session_start();
require_once 'db_connect.php';

// Validate session
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['lecture_id'], $data['progress_percent'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$studentId = $_SESSION['user_id'];
$lectureId = (int) $data['lecture_id'];
$progressPercent = (int) $data['progress_percent'];

// Get course_id using lecture_id
$stmt = $conn->prepare("
    SELECT ch.course_id 
    FROM lectures l 
    JOIN chapters ch ON l.chapter_id = ch.id 
    WHERE l.id = ?
");
$stmt->bind_param('i', $lectureId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Lecture not found']);
    exit;
}

$course = $result->fetch_assoc();
$courseId = $course['course_id'];

// Check existing progress
$checkStmt = $conn->prepare("
    SELECT id 
    FROM lecture_progress 
    WHERE student_id = ? AND lecture_id = ?
");
$checkStmt->bind_param('ii', $studentId, $lectureId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

$watched = $progressPercent >= 90 ? 1 : 0;

if ($checkResult->num_rows > 0) {
    // Update
    $updateStmt = $conn->prepare("
        UPDATE lecture_progress 
        SET progress_percent = ?, watched = ?, watched_at = NOW() 
        WHERE student_id = ? AND lecture_id = ?
    ");
    $updateStmt->bind_param('iiii', $progressPercent, $watched, $studentId, $lectureId);
    $updateStmt->execute();
} else {
    // Insert
    $insertStmt = $conn->prepare("
        INSERT INTO lecture_progress 
        (student_id, course_id, lecture_id, progress_percent, watched, watched_at) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $insertStmt->bind_param('iiiii', $studentId, $courseId, $lectureId, $progressPercent, $watched);
    $insertStmt->execute();
}

echo json_encode(['status' => 'success']);
?>
