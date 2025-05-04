<?php
$course_id = 11; // Replace with dynamic course ID
$student_id = 19; // Replace with session-based student ID

// DB connection
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get average rating
$result = $conn->query("SELECT AVG(rating) AS avg_rating FROM ratings WHERE course_id = $course_id");
$avg = $result->fetch_assoc();
$avg_rating = round($avg['avg_rating'], 1);
?>

<h2>Course Rating</h2>
<p>Average Rating: <?= $avg_rating ?> / 5</p>

<form id="ratingForm" method="POST" action="submit_rating.php">
  <input type="hidden" name="course_id" value="<?= $course_id ?>">
  <input type="hidden" name="student_id" value="<?= $student_id ?>">
  <input type="hidden" name="rating" id="ratingValue">

  <div class="star-rating">
    <span data-value="5">&#9733;</span>
    <span data-value="4">&#9733;</span>
    <span data-value="3">&#9733;</span>
    <span data-value="2">&#9733;</span>
    <span data-value="1">&#9733;</span>
  </div>

  <button type="submit">Submit Rating</button>
</form>

<style>
.star-rating span {
  font-size: 2em;
  color: gray;
  cursor: pointer;
}
.star-rating span.selected {
  color: gold;
}
</style>

<script>
const stars = document.querySelectorAll('.star-rating span');
const ratingInput = document.getElementById('ratingValue');
stars.forEach(star => {
  star.addEventListener('click', () => {
    const val = star.getAttribute('data-value');
    ratingInput.value = val;
    stars.forEach(s => s.classList.remove('selected'));
    stars.forEach(s => {
      if (s.getAttribute('data-value') <= val) s.classList.add('selected');
    });
  });
});
</script>
