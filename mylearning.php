<?php
include_once 'student_navbar.php';
require_once 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch enrolled courses with progress
$sql = "
    SELECT 
        c.*, 
        e.enrolled_at,
        u.name AS educator_name,
        IFNULL(lp.completed_lectures, 0) AS completed_lectures,
        IFNULL(tl.total_lectures, 0) AS total_lectures,
        ROUND(IFNULL(lp.completed_lectures / tl.total_lectures, 0) * 100, 0) AS progress_percent
    FROM enrollments e
    JOIN courses c ON e.course_id = c.id
    JOIN users u ON c.educator_id = u.id
    LEFT JOIN (
        SELECT ch.course_id, COUNT(l.id) AS total_lectures
        FROM lectures l
        JOIN chapters ch ON l.chapter_id = ch.id
        GROUP BY ch.course_id
    ) tl ON tl.course_id = c.id
    LEFT JOIN (
        SELECT ch.course_id, lp.student_id, COUNT(lp.lecture_id) AS completed_lectures
        FROM lecture_progress lp
        JOIN lectures l ON lp.lecture_id = l.id
        JOIN chapters ch ON l.chapter_id = ch.id
        WHERE lp.progress_percent = 100
        GROUP BY ch.course_id, lp.student_id
    ) lp ON lp.course_id = c.id AND lp.student_id = e.student_id
    WHERE e.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Learning | SmartLearning</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .course-card { transition: transform 0.2s ease; }
    .course-card:hover { transform: scale(1.02); }
    .rating { color: gold; }
    .progress-bar { transition: width 0.6s ease; }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">My Enrolled Courses</h2>
    <a href="index.php" class="btn btn-outline-secondary">← Back to Home</a>
  </div>
  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($course = $result->fetch_assoc()): 
        $progress = (int)$course['progress_percent'];
        $status = ($course['total_lectures'] > 0 && $progress == 100) ? 'Completed' : 'Ongoing';
      ?>
        <div class="col-md-4 mb-4">
          <div class="card course-card shadow-sm h-100">
            <img src="./educator/includes/<?= htmlspecialchars($course['thumbnail']) ?>" class="card-img-top" alt="Course Image" style="height: 180px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
              <p class="mb-1"><strong>Created By:</strong> <?= htmlspecialchars($course['educator_name']) ?></p>
              <p class="mb-1"><strong>Enrolled At:</strong> <?= date('d M Y', strtotime($course['enrolled_at'])) ?></p>
              <p class="mb-1">
                <strong>Status:</strong> 
                <span class="badge <?= $status === 'Completed' ? 'bg-success' : 'bg-warning text-dark' ?>">
                  <?= $status ?>
                </span>
              </p>
              <p class="mb-2"><strong>Rating:</strong> 
                <span class="rating">★ ★ ★ ★ ☆</span> <small>(4.5)</small>
              </p>
              <div class="progress mt-3">
                <div class="progress-bar <?= $progress === 100 ? 'bg-success' : 'bg-info' ?>" 
                    role="progressbar" 
                    style="width: <?= $progress ?>%;" 
                    aria-valuenow="<?= $progress ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                  <?= $progress ?>%
                </div>
              </div>

              <!-- Quiz Buttons -->
              <?php
                $quiz_stmt = $conn->prepare("
                    SELECT id, title, quiz_number 
                    FROM quizzes 
                    WHERE course_id = ?
                    ORDER BY quiz_number ASC
                ");
                $quiz_stmt->bind_param('i', $course['id']);
                $quiz_stmt->execute();
                $quiz_result = $quiz_stmt->get_result();

                if ($quiz_result->num_rows > 0):
                    $canShowNextQuiz = true;

                    while ($quiz = $quiz_result->fetch_assoc()):
                        $quizNumber = (int)$quiz['quiz_number'];
                        $requiredProgress = $quizNumber * 20;

                        // Check if current quiz is already submitted
                        $submission_stmt = $conn->prepare("
                            SELECT id, score 
                            FROM quiz_submissions 
                            WHERE quiz_id = ? AND student_id = ?
                        ");
                        $submission_stmt->bind_param('ii', $quiz['id'], $userId);
                        $submission_stmt->execute();
                        $submission_result = $submission_stmt->get_result();
                        $submission_data = $submission_result->fetch_assoc();
                        $alreadySubmitted = $submission_data ? true : false;
                        $submission_stmt->close();

                        // Show completed quiz with result
                        if ($alreadySubmitted):
                        ?>
                            <div class="mt-2">
                                <span class="badge bg-success">✅ <?= htmlspecialchars($quiz['title']) ?> - Scored: <?= $submission_data['score'] ?> / 10</span><br>
                                <a href="quiz_result.php?quiz_id=<?= $quiz['id'] ?>&student_id=<?= $userId ?>" class="btn btn-sm btn-outline-secondary mt-1">
                                    View Result
                                </a>
                            </div>
                        <?php
                        // Show quiz button if eligible and not yet submitted
                        elseif ($canShowNextQuiz && $progress >= $requiredProgress):
                        ?>
                            <div class="mt-2">
                                <span class="badge bg-primary"><?= htmlspecialchars($quiz['title']) ?> (Available)</span><br>
                                <a href="quiz.php?quiz_id=<?= $quiz['id'] ?>" class="btn btn-sm btn-success mt-1">Take Quiz</a>
                            </div>
                        <?php
                            // 🚫 Prevent showing further quizzes until this one is done
                            $canShowNextQuiz = false;
                        endif;
                    endwhile;
                endif;
                $quiz_stmt->close();

              ?>

              
              <!-- Certificate Button -->
              <?php if ($progress == 100): ?>
                <a href="generate_certificate.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-success mt-2">🎓 Get Certificate</a>
              <?php endif; ?>

            </div>
            <div class="card-footer text-end bg-light">
              <a href="watch-course.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary">Watch Now</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info">You haven't enrolled in any courses yet.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function () {
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  })
});
</scrip>

</body>
</html>
