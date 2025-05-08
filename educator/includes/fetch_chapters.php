<?php
include './../../db.php';
$course_id = $_GET['course_id'];
$chapters = mysqli_query($conn, "SELECT * FROM chapters WHERE course_id = $course_id");
echo "<option value=''>-- Select Chapter --</option>";
while($ch = mysqli_fetch_assoc($chapters)) {
  echo "<option value='{$ch['id']}'>{$ch['chapter_name']}</option>";
}
?>