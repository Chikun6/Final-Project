<?php
include_once 'student_navbar.php';
require_once 'db_connect.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$studentName = $_SESSION['name'];
$studentProfilePic = $_SESSION['image'];

// Get filter
$status = $_POST['status'] ?? '';

// Base query
$sql = "SELECT c.*, e.enrolled_at, u.name AS educator_name, 
               p.completed_percent, p.is_completed
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        JOIN users u ON c.educator_id = u.id
        LEFT JOIN progress p ON p.course_id = c.id AND p.user_id = e.student_id
        WHERE e.student_id = ?";


// Add filter
if ($status === 'completed') {
    $sql .= " AND p.is_completed = 1";
} elseif ($status === 'ongoing') {
    $sql .= " AND (p.is_completed = 0 OR p.is_completed IS NULL)";
}

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
    .course-card {
      transition: transform 0.3s ease;
    }
    .course-card:hover {
      transform: scale(1.02);
    }
    .fixed-top {
      background-color: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
   .navbar {
      background-color: #cee9fc;
    }
    .navbar-brand img {
      height: 55px;
    }
    
    .dropdown-toggle::after {
    display: none !important;
  }
  </style>
</head>
<body>

<!-- Push content below navbar -->
<div style="margin-top: 50px;"></div>

  <div class="container py-5">
    <h2 class="mb-4">My Learning</h2>

    <!-- Filter -->
    <form method="POST" class="mb-4 d-flex align-items-center gap-3">
      <label for="status" class="fw-semibold">Filter by Status:</label>
      <select name="status" id="status" class="form-select w-auto" onchange="this.form.submit()">
        <option value="">All</option>
        <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
        <option value="ongoing" <?= $status === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
      </select>
    </form>

    <!-- Courses -->
    <div class="row">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($course = $result->fetch_assoc()): ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm course-card">
              <img src="./educator/<?= $course['thumbnail'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                <p class="card-text text-muted mb-1">Educator: <?= htmlspecialchars($course['educator_name']) ?></p>
                <p class="card-text small text-muted">Enrolled on: <?= date('d M Y', strtotime($course['enrolled_at'])) ?></p>

                <!-- Progress bar -->
                <div class="progress my-2" style="height: 8px;">
                  <div class="progress-bar bg-success" role="progressbar"
                       style="width: <?= (int) $course['completed_percent'] ?>%;"
                       aria-valuenow="<?= (int) $course['completed_percent'] ?>"
                       aria-valuemin="0" aria-valuemax="100">
                  </div>
                </div>
                <p class="small text-muted mb-1">Progress: <?= (int) $course['completed_percent'] ?>%</p>

                <?php if ($course['is_completed']): ?>
                  <span class="badge bg-success">Completed</span>
                <?php endif; ?>
              </div>
              <div class="card-footer text-end">
                <a href="watch-course.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-primary">Resume</a>
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

  <?php
  require_once 'footer.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
