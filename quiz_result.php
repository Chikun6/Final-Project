<?php
require_once 'db_connect.php';
include_once 'student_navbar.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$quizId = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
$studentId = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;

if ($quizId <= 0 || $studentId <= 0) {
    echo "<div class='alert alert-danger'>Quiz ID or Student ID is missing or invalid.</div>";
    exit;
}

// Get quiz title
$quizTitle = '';
$titleQuery = $conn->prepare("SELECT title FROM quizzes WHERE id = ?");
$titleQuery->bind_param("i", $quizId);
$titleQuery->execute();
$titleResult = $titleQuery->get_result();
if ($row = $titleResult->fetch_assoc()) {
    $quizTitle = $row['title'];
}

// Get student's score
$score = 0;
$submissionQuery = $conn->prepare("SELECT score FROM quiz_submissions WHERE quiz_id = ? AND student_id = ? ORDER BY submitted_at DESC LIMIT 1");
$submissionQuery->bind_param("ii", $quizId, $studentId);
$submissionQuery->execute();
$submissionResult = $submissionQuery->get_result();
if ($row = $submissionResult->fetch_assoc()) {
    $score = $row['score'];
} else {
    echo "<div class='alert alert-warning'>No submission found for this quiz.</div>";
    exit;
}

// Get all questions and correct answers
$questionQuery = $conn->prepare("SELECT question_text, option_a, option_b, option_c, option_d, correct_option, explanation FROM quiz_questions WHERE quiz_id = ?");
$questionQuery->bind_param("i", $quizId);
$questionQuery->execute();
$questions = $questionQuery->get_result()->fetch_all(MYSQLI_ASSOC);

// Leaderboard
$leaderboardQuery = $conn->prepare("SELECT u.name, qs.score FROM quiz_submissions qs JOIN users u ON qs.student_id = u.id WHERE qs.quiz_id = ? ORDER BY qs.score DESC, qs.submitted_at ASC LIMIT 10");
$leaderboardQuery->bind_param("i", $quizId);
$leaderboardQuery->execute();
$leaders = $leaderboardQuery->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-4 text-primary">Your Score: <?= $score ?></h2>
        <a href="mylearning.php" class="btn btn-outline-secondary">← Back to Course</a>
    </div>
    <div class="card mb-5">
        <div class="card-header bg-success text-white">Leaderboard (Top 10)</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($leaders as $index => $leader): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= ($index+1) . '. ' . htmlspecialchars($leader['name']) ?>
                        <span class="badge bg-primary rounded-pill"><?= $leader['score'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Add this inside your existing <div class="container my-5"> -->
        <div class="text-end mb-3">
            <button class="btn btn-outline-primary" id="toggleAnswersBtn">Show Answers & Explanations</button>
        </div>

        <!-- Wrap accordion in a div for toggling -->
        <div id="answersSection" style="display: none;">
            <div class="accordion" id="questionAccordion">
                <?php foreach ($questions as $i => $q): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $i ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>">
                                Q<?= $i+1 ?>. <?= htmlspecialchars($q['question_text']) ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#questionAccordion">
                            <div class="accordion-body">
                                <p><strong>A:</strong> <?= $q['option_a'] ?></p>
                                <p><strong>B:</strong> <?= $q['option_b'] ?></p>
                                <p><strong>C:</strong> <?= $q['option_c'] ?></p>
                                <p><strong>D:</strong> <?= $q['option_d'] ?></p>
                                <p class="text-success"><strong>Correct Answer:</strong> <?= $q['correct_option'] ?></p>
                                <p class="text-muted"><strong>Explanation:</strong> <?= nl2br(htmlspecialchars($q['explanation'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('toggleAnswersBtn').addEventListener('click', function() {
    const answersSection = document.getElementById('answersSection');
    if (answersSection.style.display === 'none') {
        answersSection.style.display = 'block';
        this.textContent = 'Hide Answers & Explanations';
    } else {
        answersSection.style.display = 'none';
        this.textContent = 'Show Answers & Explanations';
    }
});
</script>
</body>
<?php include_once 'footer.php'?>
</html>
