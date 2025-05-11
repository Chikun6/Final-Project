<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Count users with role = 'student'
$studentsQuery = $conn->query("SELECT COUNT(*) AS total_students FROM users WHERE role = 'student'");
$students = $studentsQuery->fetch_assoc()['total_students'] ?? 0;

// Total Courses
$coursesQuery = $conn->query("SELECT COUNT(*) AS total_courses FROM courses");
$courses = $coursesQuery->fetch_assoc()['total_courses'] ?? 0;

// Total Lectures
$lecturesQuery = $conn->query("SELECT COUNT(*) AS total_lectures FROM lectures");
$lectures = $lecturesQuery->fetch_assoc()['total_lectures'] ?? 0;
?>

<div class="container">
  <h2 class="mb-4">Admin Dashboard</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Students Enrolled</h5>
          <p class="card-text fs-2"><?= $students ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Courses</h5>
          <p class="card-text fs-2"><?= $courses ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-danger mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Lectures</h5>
          <p class="card-text fs-2"><?= $lectures ?></p>
        </div>
      </div>
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
            <button class="btn btn-sm btn-primary me-1">Approve</button>
            <button class="btn btn-sm btn-danger">Reject</button>
          </td>
        </tr>
        <!-- Dynamic PHP rows go here -->
      </tbody>
    </table>
  </div>
</div>

