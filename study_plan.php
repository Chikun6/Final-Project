<?php
include_once 'student_navbar.php';
include 'db_connect.php';

$student_id = $_SESSION['user_id'];
$plans = $conn->query("SELECT * FROM study_plan WHERE student_id = $student_id ORDER BY datetime DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Plan Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h3 class="mb-3">Add Study Task</h3>
  <form action="add_study_plan.php" method="post" class="mb-4">
    <div class="row">
      <div class="col-md-3"><input type="text" name="subject" class="form-control" placeholder="Subject" required></div>
      <div class="col-md-4"><input type="text" name="task" class="form-control" placeholder="Task Description" required></div>
      <div class="col-md-3"><input type="datetime-local" name="datetime" class="form-control" required></div>
      <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Add</button></div>
    </div>
  </form>
    <h3>My Study Plan</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Task</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plans as $row): ?>
            <tr class="<?= $row['completed'] ? 'table-success' : '' ?>">
                <td><?= htmlspecialchars($row['subject']) ?></td>
                <td><?= htmlspecialchars($row['task']) ?></td>
                <td><?= date('M d, Y h:i A', strtotime($row['datetime'])) ?></td>
                <td><?= $row['completed'] ? '<i class="bi bi-check-circle-fill text-success"></i> Completed' : 'Pending' ?></td>
                <td>
                    <?php if (!$row['completed']): ?>
                    <a href="mark_done.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Mark Done</a>
                    <?php endif; ?>
                    <!-- Edit Button that triggers the modal -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                    <!-- Delete Button -->
                    <form action="delete_study_plan.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Modal for Edit -->
            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Study Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="edit_study_plan.php?id=<?= $row['id'] ?>" method="post">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control" value="<?= htmlspecialchars($row['subject']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="task" class="form-label">Task</label>
                                    <input type="text" name="task" class="form-control" value="<?= htmlspecialchars($row['task']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="datetime" class="form-label">Time</label>
                                    <input type="datetime-local" name="datetime" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($row['datetime'])) ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
