<?php
require_once 'db_connect.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$studentId = $_POST['student_id'];
$quizId = $_POST['quiz_id'];
$answers = $_POST['answers'] ?? [];

$total = count($answers);
$score = 0;

// Fetch correct answers from DB
$sql = "SELECT id, correct_option FROM quiz_questions WHERE quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quizId);
$stmt->execute();
$result = $stmt->get_result();

$correctAnswers = [];
while ($row = $result->fetch_assoc()) {
    $correctAnswers[$row['id']] = $row['correct_option'];
}

foreach ($answers as $questionId => $givenAnswer) {
    if (isset($correctAnswers[$questionId]) && strtolower($correctAnswers[$questionId]) === strtolower($givenAnswer)) {
        $score++;
    }
}

// Insert into quiz_submissions
$insert = "INSERT INTO quiz_submissions (student_id, quiz_id, score) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insert);
$insertStmt->bind_param("iii", $studentId, $quizId, $score);
$insertStmt->execute();

// Send JSON response
echo json_encode([
    'success' => true,
    'name' => $_SESSION['name'] ?? 'Student',
    'score' => $score,
    'total' => $total,
    'quiz_id' => $quizId
]);
