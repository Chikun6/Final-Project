<?php
session_start();
include_once 'db_connect.php';


$studentId = $_SESSION['user_id'] ?? 0;
$studentName = $_SESSION['name'] ?? 'Student';
$studentProfilePic = $_SESSION['image'] ?? './images/faculty.jpeg'; // Path to default image


// Fetch notifications
$notifQuery = $conn->prepare("SELECT * FROM notifications WHERE student_id = ? ORDER BY created_at DESC LIMIT 10");
$notifQuery->bind_param("i", $studentId);
$notifQuery->execute();
$result = $notifQuery->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);

// Count new notifications
$newCount = 0;
foreach ($notifications as $notif) {
    if ($notif['status'] === 'new') $newCount++;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap Icons (required for icons in dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
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
    /* ✅ Stronger selector to hide dropdown arrow */
    .navbar .dropdown-toggle::after {
      display: none !important;
    }
    .badge-notify {
      position: absolute;
      top: 0;
      right: 0;
      transform: translate(50%, -50%);
    }
    </style>

</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand fw-bold" href="index.php">
        <img src="./images/logoupdate.png" alt="Logo" style="height: 40px;" class="me-2">
        SmartLearning
      </a>

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar items -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-center">

          <!-- My Learning Button -->
          <li class="nav-item me-3">
            <a class="btn btn-outline-primary" href="mylearning.php">My Learning</a>
          </li>

          <!-- Study Plan Button -->
          <li class="nav-item me-3">
            <a class="btn btn-outline-primary" href="study_plan.php">Study Plan</a>
          </li>

          <!-- Career Guide Button -->
          <li class="nav-item me-3">
            <a class="btn btn-outline-primary" href="career_guide.php">Career Guide</a>
          </li>

          <!-- Notification Icon with Badge -->
          <li class="nav-item me-3 position-relative">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
              <i class="bi bi-bell-fill fs-5 text-dark"></i>
              <?php if ($newCount > 0): ?>
                <span class="badge-notify badge bg-danger text-white"><?= $newCount ?></span>
              <?php endif; ?>
            </a>
          </li>

          <!-- Profile Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" id="studentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= $studentProfilePic ?>" alt="Profile" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 border-0 mt-2" aria-labelledby="studentDropdown" style="min-width: 200px;">
              <li><h6 class="dropdown-header text-muted"><?= $studentName ?? 'Student' ?></h6></li>
              <li><a class="dropdown-item" href="profile.php" id="viewProfile"><i class="bi bi-person me-2"></i>View Profile</a></li>
              <li><a class="dropdown-item" href="edit.php" id="editProfile"><i class="bi bi-pencil me-2"></i>Edit Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Push content below navbar -->
<div style="margin-top: 100px;"></div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if (count($notifications) > 0): ?>
        <ul class="list-group">
          <?php foreach ($notifications as $notif): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($notif['message']) ?>
              <?php if ($notif['status'] == 'new'): ?>
                <span class="badge bg-primary rounded-pill">New</span>
              <?php elseif ($notif['type'] == 'update'): ?>
                <span class="badge bg-success rounded-pill">Seen</span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
          <p class="text-muted">No notifications found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>



</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('notificationsModal').addEventListener('shown.bs.modal', function () {
  fetch('mark_notifications.php', { method: 'POST' })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        document.querySelector('.badge-notify').style.display = 'none'; // hide red badge
      }
    });
});
</script>

</html>
