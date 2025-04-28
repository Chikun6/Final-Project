<?php
if (!isset($_SESSION)) session_start();

$studentName = $_SESSION['name'] ?? 'Student';
$studentProfilePic = $_SESSION['image'] ?? './images/faculty.jpeg'; // Path to default image
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap Icons (required for icons in dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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
    
    .dropdown-toggle::after {
    display: none !important;
  }
  </style>

</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand fw-bold" href="#">
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

          <!-- Profile Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" id="studentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= $studentProfilePic ?>" alt="Profile" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow rounded-4 border-0 mt-2" aria-labelledby="studentDropdown" style="min-width: 200px;">
              <li><h6 class="dropdown-header text-muted"><?= $studentName ?? 'Student' ?></h6></li>
              <li><a class="dropdown-item" href="profile.php" id="viewProfile"><i class="bi bi-person me-2"></i>View Profile</a></li>
              <li><a class="dropdown-item" href="edit_profile" id="editProfile"><i class="bi bi-pencil me-2"></i>Edit Profile</a></li>
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

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>