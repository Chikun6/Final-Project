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
  <h2 class="mb-4">My Enrolled Courses</h2>
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
              <div class="progress mb-1" style="height: 8px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="small text-muted">Progress: <?= $progress ?>%</p>
            </div>
            <div class="card-footer text-end bg-light">
              <a href="watch-course.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary">Go to Course</a>
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
</body>
</html>
