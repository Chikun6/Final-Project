<?php
include './../../db_connect.php';

$course_id = $_GET['course_id'];
$quizzes = $conn->query("SELECT * FROM quizzes WHERE course_id = $course_id ORDER BY id DESC");
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
                        <button class="btn btn-sm btn-success" onclick="loadQuizQuestions(<?= $quiz['id'] ?>)">View</button>
                        <button class="btn btn-sm btn-warning" onclick="editQuiz(<?= $quiz['id'] ?>)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteQuiz(<?= $quiz['id'] ?>)">Delete</button>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</div>

<button class="btn btn-primary mt-3" onclick="createNewQuiz(<?= $course_id ?>)">Add New Quiz</button>


<script src = "../../js/quiz.js"></script>

