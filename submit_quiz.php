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

if (!$studentId || !$quizId || empty($answers)) {
    echo json_encode(['error' => 'Missing data']);
    exit;
}

// ✅ Check for existing submission
$checkSql = "SELECT id FROM quiz_submissions WHERE student_id = ? AND quiz_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $studentId, $quizId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(['error' => 'You have already attempted this quiz.']);
    exit;
}

// ✅ Calculate Score
$total = count($answers);
$score = 0;

$sql = "SELECT id, correct_option FROM quiz_questions WHERE quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $quizId);
$stmt->execute();
$result = $stmt->get_result();

$correctAnswers = [];
while ($row = $result->fetch_assoc()) {
    $correctAnswers[$row['id']] = strtolower($row['correct_option']); // normalize
}

foreach ($answers as $questionId => $givenAnswer) {
    if (isset($correctAnswers[$questionId]) && $correctAnswers[$questionId] === strtolower($givenAnswer)) {
        $score++;
    }
}

// ✅ Insert score
$insert = "INSERT INTO quiz_submissions (student_id, quiz_id, score) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insert);
$insertStmt->bind_param("iii", $studentId, $quizId, $score);
$insertStmt->execute();

// ✅ Respond
echo json_encode([
    'success' => true,
    'name' => $_SESSION['name'] ?? 'Student',
    'student_id' => $studentId,
    'score' => $score,
    'total' => $total,
    'quiz_id' => $quizId

]);
