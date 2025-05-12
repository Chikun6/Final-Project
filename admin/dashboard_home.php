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

// Pending Teachers
$pendingTeachers = $conn->query("SELECT id, name, email FROM users WHERE role = 'educator' AND status = 'pending'");
?>

<!-- Dashboard Cards -->
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

<!-- Teacher Approval Section -->
<div class="container mt-5">
  <h3 class="text-center text-success fw-bold mb-4">Teacher Approval Section</h3>
  <div class="table-responsive shadow p-3 bg-white rounded">
    <table class="table table-bordered table-striped align-middle text-center" id="teacherTable">
      <thead class="table-success">
        <tr>
          <th>#</th>
          <th>Educator Name</th>
          <th>Email ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $serial = 1;
        while ($row = $pendingTeachers->fetch_assoc()):
        ?>
        <tr id="row-<?= $row['id'] ?>">
          <td><?= $serial++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td>
            <button class="btn btn-sm btn-primary me-1 action-btn" data-id="<?= $row['id'] ?>" data-action="approve">Approve</button>
            <button class="btn btn-sm btn-danger action-btn" data-id="<?= $row['id'] ?>" data-action="reject">Reject</button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.action-btn', function() {
  const teacherId = $(this).data('id');
  const action = $(this).data('action');

  $.ajax({
    url: 'approve_teacher.php',
    method: 'POST',
    data: { teacher_id: teacherId, action: action },
    success: function(response) {
      if (response.trim() === 'success') {
        $('#row-' + teacherId).fadeOut(500, function() {
          $(this).remove();
        });
      } else {
        alert('Error: ' + response);
      }
    }
  });
});
</script>
