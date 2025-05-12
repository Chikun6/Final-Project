<?php
include './../../db_connect.php';

// Sanitize input to avoid SQL Injection
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

if ($course_id > 0) {
    // Fetch quizzes for the given course ID
    $quizzes = $conn->query("SELECT * FROM quizzes WHERE course_id = $course_id ORDER BY id DESC");
} else {
    echo "<div class='alert alert-danger'>Invalid Course ID.</div>";
    exit;
}
?>

<div id="quiz-list">
    <?php if ($quizzes->num_rows === 0) : ?>
        <div class="alert alert-warning">No quizzes found for this course.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php while ($quiz = $quizzes->fetch_assoc()) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($quiz['title']) ?></span>
                    <div>
                        <button class="btn btn-info show-results-btn" data-quiz-id="<?= $quiz['id'] ?>">Results</button>
                        <button class="btn btn-warning edit-quiz-btn" data-quiz-id="<?= $quiz['id'] ?>">Edit</button>
                        <button class="btn btn-danger delete-quiz-btn" data-quiz-id="<?= $quiz['id'] ?>">Delete</button>
                        <button class="btn btn-success load-questions-btn" data-quiz-id="<?= $quiz['id'] ?>">View</button>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</div>

<button class="btn btn-primary mt-3" onclick="createNewQuiz(<?= $course_id ?>)">Add New Quiz</button>
