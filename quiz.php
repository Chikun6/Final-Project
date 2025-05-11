<?php
include_once 'student_navbar.php';
require_once 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$studentId = $_SESSION['user_id'];

// Step 1: Get all courses the student is enrolled in
$courseQuery = "SELECT c.id AS course_id, c.title AS course_title 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                WHERE e.student_id = ?";
$courseStmt = $conn->prepare($courseQuery);
$courseStmt->bind_param("i", $studentId);
$courseStmt->execute();
$courseResult = $courseStmt->get_result();

$nextQuiz = null;
$quizCourse = null;

while ($course = $courseResult->fetch_assoc()) {
    $courseId = $course['course_id'];

    // Step 2: Find the next unanswered quiz for this course
    $quizStmt = $conn->prepare("
        SELECT q.id, q.title, q.quiz_number 
        FROM quizzes q
        WHERE q.course_id = ? 
        AND NOT EXISTS (
            SELECT 1 FROM quiz_submissions s 
            WHERE s.quiz_id = q.id AND s.student_id = ?
        )
        ORDER BY q.quiz_number ASC
        LIMIT 1
    ");
    $quizStmt->bind_param("ii", $courseId, $studentId);
    $quizStmt->execute();
    $quizResult = $quizStmt->get_result();

    if ($quizResult->num_rows > 0) {
        $nextQuiz = $quizResult->fetch_assoc();
        $quizCourse = $course;
        break; // Stop at the first course with an unanswered quiz
    }
}

if (!$nextQuiz) {
    echo "<div class='alert alert-info'>You have completed all quizzes in all enrolled courses.</div>";
    exit;
}

$quizId = $nextQuiz['id'];
$quizTitle = htmlspecialchars($nextQuiz['title']);
$quizNumber = $nextQuiz['quiz_number'];
$courseTitle = htmlspecialchars($quizCourse['course_title']);

// Step 3: Fetch questions
$questionsQuery = "SELECT id, question_text, option_a, option_b, option_c, option_d 
                   FROM quiz_questions 
                   WHERE quiz_id = ?";
$questionsStmt = $conn->prepare($questionsQuery);
$questionsStmt->bind_param("i", $quizId);
$questionsStmt->execute();
$questionsResult = $questionsStmt->get_result();

$questions = [];
while ($q = $questionsResult->fetch_assoc()) {
    $questions[] = $q;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($quizTitle) ?> | Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .quiz-card { max-width: 750px; margin: 60px auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .quiz-header { background-color: #0d6efd; color: white; padding: 20px 25px; font-size: 1.2rem; font-weight: bold; display: flex; justify-content: space-between; }
        .question-block { padding: 30px; background-color: white; }
        .form-check { background-color: #f8f9fa; padding: 10px 15px; border-radius: 8px; margin-top: 12px; transition: all 0.3s ease; }
        .form-check:hover { background-color: #e9ecef; }
        .quiz-footer { display: flex; justify-content: space-between; padding: 20px 30px; border-top: 1px solid #e5e5e5; background-color: #f8f9fa; }
        #timer { font-size: 1.1rem; font-weight: 500; }
    </style>
</head>
<body>

<div class="card quiz-card">
    <div class="quiz-header">
        <div><?= htmlspecialchars($quizTitle) ?></div>
        <div id="timer">00:15</div>
    </div>
    <div class="question-block">
        <form id="quizForm">
            <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
            <input type="hidden" name="course_id" value="<?= $courseId ?>">
            <input type="hidden" name="student_id" value="<?= $studentId ?>">
            <div id="questionContainer"></div>
        </form>
    </div>
    <div class="quiz-footer">
        <button type="button" class="btn btn-outline-primary" id="nextBtn">Next</button>
        <button type="submit" form="quizForm" class="btn btn-success" id="submitBtn" style="display:none;">Submit</button>
    </div>
</div>

<script>
    const questions = <?= json_encode($questions) ?>;
    let currentQuestion = 0;
    let timer = 15;
    let interval;
    let allAnswers = {};

    const questionContainer = document.getElementById('questionContainer');
    const timerDisplay = document.getElementById('timer');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    const renderQuestion = () => {
        const q = questions[currentQuestion];
        const selected = allAnswers[q.id] || "";

        questionContainer.innerHTML = `
            <h5 class="mb-4">Q${currentQuestion + 1}. ${q.question_text}</h5>
            ${['A','B','C','D'].map(opt => `
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question_temp" value="${opt}" ${selected === opt ? 'checked' : ''}>
                    <label class="form-check-label">${q['option_' + opt.toLowerCase()]}</label>
                </div>`).join('')}
        `;

        timer = 15;
        updateTimer();
        clearInterval(interval);
        interval = setInterval(countdown, 1000);

        nextBtn.style.display = currentQuestion < questions.length - 1 ? 'inline-block' : 'none';
        submitBtn.style.display = currentQuestion === questions.length - 1 ? 'inline-block' : 'none';
    };

    questionContainer.addEventListener('change', e => {
        if (e.target.name === 'question_temp') {
            allAnswers[questions[currentQuestion].id] = e.target.value;
        }
    });

    const updateTimer = () => {
        timerDisplay.textContent = `00:${timer < 10 ? '0' + timer : timer}`;
    };

    const countdown = () => {
        timer--;
        updateTimer();
        if (timer <= 0) {
            clearInterval(interval);
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                renderQuestion();
            } else {
                document.getElementById('quizForm').requestSubmit();
            }
        }
    };

    nextBtn.addEventListener('click', () => {
        clearInterval(interval);
        currentQuestion++;
        renderQuestion();
    });

    document.getElementById('quizForm').addEventListener('submit', function(e) {
        e.preventDefault();
        clearInterval(interval);
        window.onbeforeunload = null;

        document.querySelectorAll('.dynamic-answer').forEach(el => el.remove());

        for (let qid in allAnswers) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = `answers[${qid}]`;
            input.value = allAnswers[qid];
            input.classList.add('dynamic-answer');
            this.appendChild(input);
        }

        const formData = new FormData(this);
        fetch('submit_quiz.php', {
            method: 'POST',
            body: formData
        }).then(res => res.json()).then(data => {
            Swal.fire({
                title: `Quiz Submitted!`,
                html: `<strong>${data.name}</strong>, you scored <strong>${data.score}</strong>/${data.total}.`,
                icon: 'success',
                confirmButtonText: 'Go to Result Page'
            }).then(() => {
                window.location.href = `quiz_result.php?quiz_id=${data.quiz_id}&student_id=${data.student_id}`;
            });
        }).catch(err => {
            Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
        });
    });

    renderQuestion();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include_once 'footer.php' ?>
</html>
