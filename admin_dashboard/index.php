<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch counts
$courseCount = $conn->query("SELECT COUNT(*) FROM courses")->fetch_row()[0];
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$quizCount = $conn->query("SELECT COUNT(*) FROM quiz_questions")->fetch_row()[0];
$enrollCount = $conn->query("SELECT COUNT(*) FROM enrollments")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SmartLearning Admin Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
  body {
    background: linear-gradient(to right,rgb(234, 238, 241),rgb(220, 214, 214));
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
  }
</style>

</head>
<body>

<div class="container py-4">
  <h2 class="text-center mb-4">SmartLearning Admin Dashboard</h2>
  <div class="row g-4">
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

  
  <?php
$mysqli = new mysqli("localhost", "root", "", "smart_learning");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$tables = ['users', 'courses', 'chapters', 'lectures', 'enrollments', 'progress', 'quiz_questions', 'contact'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SmartLearning </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Details of SmartLearning</h2>

    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <?php foreach ($tables as $index => $table): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="<?= $table ?>-tab" data-bs-toggle="tab"
                        data-bs-target="#<?= $table ?>" type="button" role="tab">
                    <?= ucfirst($table) ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content mt-3" id="adminTabContent">
        <?php foreach ($tables as $index => $table): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="<?= $table ?>" role="tabpanel">
                <div class="table-container">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-dark">
                        <tr>
                            <?php
                            $result = $mysqli->query("DESCRIBE $table");
                            $columns = [];
                            while ($row = $result->fetch_assoc()) {
                                $columns[] = $row['Field'];
                                echo "<th>" . htmlspecialchars($row['Field']) . "</th>";
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $mysqli->query("SELECT * FROM $table");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($columns as $col) {
                                    echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='" . count($columns) . "' class='text-center'>No data</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


  <!-- Section List -->
  <div class="mt-5">
    <h4>Manage Sections</h4>
    <ul class="list-group">
      <li class="list-group-item"><a href="users.php" class="text-decoration-none">Manage Users</a></li>
      <li class="list-group-item"><a href="courses.php" class="text-decoration-none">Manage Courses</a></li>
      <li class="list-group-item"><a href="chapters.php" class="text-decoration-none">Manage Chapters</a></li>
      <li class="list-group-item"><a href="lectures.php" class="text-decoration-none">Manage Lectures</a></li>
      <li class="list-group-item"><a href="quiz.php" class="text-decoration-none">Manage Quizzes</a></li>
      <li class="list-group-item"><a href="contact.php" class="text-decoration-none">View Contact Messages</a></li>
    </ul>
  </div>
</div>

</body>
</html>
