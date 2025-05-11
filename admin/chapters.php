<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_chapter'])) {
    $id = $conn->real_escape_string($_POST['delete_chapter']);
    $conn->query("DELETE FROM chapters WHERE id=$id");
    exit;
}

$chapters = $conn->query("SELECT chapters.id, chapters.chapter_name, courses.title AS course FROM chapters LEFT JOIN courses ON chapters.course_id = courses.id");
?>

<h3>Chapters</h3>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Chapter Name</th><th>Course</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $chapters->fetch_assoc()): ?>
      <tr id="chapter-<?php echo $row['id']; ?>">
        <td><?= $row['id'] ?></td>
        <td><?= $row['chapter_name'] ?></td>
        <td><?= $row['course'] ?></td>
        <td>
          <button class="btn btn-danger btn-sm" onclick="deleteChapter(<?= $row['id']; ?>)">Delete</button>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<script>
function deleteChapter(id) {
  if (confirm("Delete this chapter?")) {
    fetch('chapters.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'delete_chapter=' + id
    }).then(() => document.getElementById('chapter-' + id).remove());
  }
}
</script>
