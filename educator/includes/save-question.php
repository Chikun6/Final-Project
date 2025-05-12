<?php
include './../../db_connect.php';
header('Content-Type: application/json');

$quiz_id = $_POST['quiz_id'] ?? '';
$question_id = $_POST['question_id'] ?? '';
$q = $_POST['question_text'] ?? '';
$a = $_POST['option_a'] ?? '';
$b = $_POST['option_b'] ?? '';
$c = $_POST['option_c'] ?? '';
$d = $_POST['option_d'] ?? '';
$correct = $_POST['correct_option'] ?? '';
$exp = $_POST['explanation'] ?? '';

$a = strtolower($a);
$b = strtolower($b);
$c = strtolower($c);
$d = strtolower($d);
$correct = strtolower($correct);

// Validate required fields
if (!$quiz_id || !$q || !$a || !$b || !$c || !$d || !$correct) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

if ($question_id) {
    $stmt = $conn->prepare("UPDATE quiz_questions SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=?, explanation=? WHERE id=?");
    $stmt->bind_param("sssssssi", $q, $a, $b, $c, $d, $correct, $exp, $question_id);
} else {
    $stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option, explanation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $quiz_id, $q, $a, $b, $c, $d, $correct, $exp);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Question saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $stmt->error]);
}
?>
