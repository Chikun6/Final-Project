<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_lecture'])) {
    $id = $conn->real_escape_string($_POST['delete_lecture']);
    $conn->query("DELETE FROM lectures WHERE id=$id");
    exit;
}

$lectures = $conn->query("SELECT lectures.id, lectures.title, lectures.duration, chapters.chapter_name FROM lectures LEFT JOIN chapters ON lectures.chapter_id = chapters.id");
?>

<h3>Lectures</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Title</th><th>Duration</th><th>Chapter</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $lectures->fetch_assoc()): ?>
      <tr id="lecture-<?php echo $row['id']; ?>">
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['duration'] ?> mins</td>
        <td><?= $row['chapter_name'] ?></td>
        <td>
          <button class="btn btn-danger btn-sm" onclick="deleteLecture(<?= $row['id']; ?>)">Delete</button>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<script>
function deleteLecture(id) {
  if (confirm("Delete this lecture?")) {
    fetch('lectures.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'delete_lecture=' + id
    }).then(() => document.getElementById('lecture-' + id).remove());
  }
}
</script>
