<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch counts
$courseCount = $conn->query("SELECT COUNT(*) FROM courses")->fetch_row()[0];
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$quizCount = $conn->query("SELECT COUNT(*) FROM quiz_questions")->fetch_row()[0];
$enrollCount = $conn->query("SELECT COUNT(*) FROM enrollments")->fetch_row()[0];

$tables = ['users', 'courses', 'chapters', 'lectures', 'enrollments', 'progress', 'quiz_questions', 'contact'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SmartLearning Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, rgb(234, 238, 241), rgb(220, 214, 214));
      font-family: 'Segoe UI', sans-serif;
    }
    h2 {
      color: #0d6efd;
      font-weight: 600;
    }
    .card {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .list-group-item a {
      font-weight: 500;
      color: #0d6efd;
    }
    .nav-tabs .nav-link.active {
      background-color: #0d6efd !important;
      color: white !important;
      font-weight: bold;
    }
    .table-container {
      background-color: white;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      overflow-x: auto;
      max-height: 500px;
    }
  </style>
</head>
<body>

<div class="container py-4">
  <h2 class="text-center mb-4">SmartLearning Admin Dashboard</h2>
  
  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-primary h-100">
        <div class="card-body">
          <h5 class="card-title">Courses</h5>
          <p class="card-text fs-4"><?= $courseCount ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success h-100">
        <div class="card-body">
          <h5 class="card-title">Users</h5>
          <p class="card-text fs-4"><?= $userCount ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning h-100">
        <div class="card-body">
          <h5 class="card-title">Quiz Questions</h5>
          <p class="card-text fs-4"><?= $quizCount ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-danger h-100">
        <div class="card-body">
          <h5 class="card-title">Enrollments</h5>
          <p class="card-text fs-4"><?= $enrollCount ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5">
  <h3 class="mb-4 text-center text-primary fw-bold">Details of SmartLearning</h3>
  <div class="row g-3 justify-content-center">
    <div class="col-md-3">
      <a href="users.php" class="btn btn-primary btn-lg w-100 shadow">👤 Users</a>
    </div>
    <div class="col-md-3">
      <a href="courses.php" class="btn btn-success btn-lg w-100 shadow">📚 Courses</a>
    </div>
    <div class="col-md-3">
      <a href="chapters.php" class="btn btn-info btn-lg w-100 shadow">📖 Chapters</a>
    </div>
    <div class="col-md-3">
      <a href="lectures.php" class="btn btn-warning btn-lg w-100 shadow">🎥 Lectures</a>
    </div>
    <div class="col-md-3">
      <a href="quiz.php" class="btn btn-danger btn-lg w-100 shadow">📝 Quiz</a>
    </div>
    <div class="col-md-3">
      <a href="result.php" class="btn btn-dark btn-lg w-100 shadow">🏆 Results</a>
    </div>
    <div class="col-md-3">
      <a href="contact.php" class="btn btn-secondary btn-lg w-100 shadow">✉ Contact</a>
    </div>
  </div>
</div>


<div class="container mt-5">
  <h3 class="text-center text-success fw-bold mb-4">Teacher Approval Section</h3>
  <div class="table-responsive shadow p-3 bg-white rounded">
    <table class="table table-bordered table-striped align-middle text-center">
      <thead class="table-success">
        <tr>
          <th>#</th>
          <th>Educator Name</th>
          <th>Email ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Example row (remove this in dynamic version) -->
        <tr>
          <td>1</td>
          <td>John Doe</td>
          <td>john@example.com</td>
          <td>
            <button class="btn btn-sm btn-primary">Approve</button>
          </td>
        </tr>
        <!-- Dynamic PHP rows go here -->
      </tbody>
    </table>
  </div>
</div>




  <!-- Manage Sections -->
  <div class="container mt-5">
  <h4 class="text-center text-primary mb-4">Manage Sections</h4>
  
 
  <div class="d-flex justify-content-center gap-4 mb-4">
    <!-- Manage Users Button -->
    <a href="users.php" class="btn btn-primary btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-person-fill me-2"></i> Manage Users
    </a>

    <!-- Manage Courses Button -->
    <a href="courses.php" class="btn btn-success btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-book-fill me-2"></i> Manage Courses
    </a>

    <!-- Manage Chapters Button -->
    <a href="chapters.php" class="btn btn-info btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-journal-bookmark-fill me-2"></i> Manage Chapters
    </a>
  </div>


  <div class="d-flex justify-content-center gap-4">
    <!-- Manage Lectures Button -->
    <a href="lectures.php" class="btn btn-warning btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-camera-video-fill me-2"></i> Manage Lectures
    </a>

    <!-- Manage Quizzes Button -->
    <a href="quiz.php" class="btn btn-danger btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-pencil-fill me-2"></i> Manage Quizzes
    </a>

    <!-- View Contact Messages Button -->
    <a href="contact.php" class="btn btn-secondary btn-lg d-flex align-items-center px-4 py-2 shadow-sm rounded">
      <i class="bi bi-envelope-fill me-2"></i> View Contact Messages
    </a>
  </div>
</div>

<!-- Include Bootstrap Icons library -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
