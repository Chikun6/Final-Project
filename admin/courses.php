<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_course'])) {
    $id = $conn->real_escape_string($_POST['delete_course']);
    $conn->query("DELETE FROM courses WHERE id=$id");
    exit; // prevent further HTML output
}

$courses = $conn->query("SELECT * FROM courses");
?>

<h3>Courses</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Title</th><th>Category</th><th>Price</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $courses->fetch_assoc()): ?>
      <tr id="course-<?php echo $row['id']; ?>">
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><?= $row['price'] ?></td>
        <td>
          <button class="btn btn-danger btn-sm" onclick="deleteCourse(<?= $row['id']; ?>)">Delete</button>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<script>
function deleteCourse(id) {
  if (confirm("Delete this course?")) {
    fetch('courses.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'delete_course=' + id
    }).then(() => document.getElementById('course-' + id).remove());
  }
}
</script>
