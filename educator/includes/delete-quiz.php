<?php
include './../../db_connect.php'; // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $quiz_id = intval($_POST['quiz_id']);

    // Check if the quiz exists
    $checkStmt = $conn->prepare("SELECT id FROM quizzes WHERE id = ?");
    $checkStmt->bind_param("i", $quiz_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Optionally delete related quiz questions
        $deleteQuestionsStmt = $conn->prepare("DELETE FROM quiz_questions WHERE quiz_id = ?");
        $deleteQuestionsStmt->bind_param("i", $quiz_id);
        $deleteQuestionsStmt->execute();
        $deleteQuestionsStmt->close();

        // Now delete the quiz
        $deleteQuizStmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
        $deleteQuizStmt->bind_param("i", $quiz_id);

        if ($deleteQuizStmt->execute()) {
            echo 'success';
        } else {
            echo 'error: ' . $deleteQuizStmt->error;
        }

        $deleteQuizStmt->close();
    } else {
        echo 'not_found';
    }

    $checkStmt->close();
} else {
    echo 'invalid_request';
}

$conn->close();
?>
