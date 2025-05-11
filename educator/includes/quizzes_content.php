<?php
session_start();
include './../../db_connect.php';
$educator_id = $_SESSION['user_id']; 

$sql = "SELECT id, title FROM courses WHERE educator_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $educator_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h4 class="mb-4">Your Courses</h4>

<div class="row g-4">
<?php
if ($result->num_rows === 0) {
    echo "<div class='alert alert-warning'>No courses found.</div>";
} else {
    while ($row = $result->fetch_assoc()) {
?>
    <div class="col-md-4">
        <div class="card text-white shadow h-100 border-0" style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                <button class="btn btn-light mt-3" onclick="loadCourseQuizzes(<?= $row['id'] ?>, '<?= addslashes($row['title']) ?>')">Manage Quizzes</button>
            </div>
        </div>
    </div>
<?php
    }
}
?>
</div>

<hr class="my-5">
<div id="quiz-management-area"></div>

<script>
function loadCourseQuizzes(courseId, courseTitle) {
    fetch('includes/manage-course-quizzes.php?course_id=' + courseId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-management-area').innerHTML = `
                <h4>Quiz Management for: ${courseTitle}</h4>
                ${data}
            `;
        });
}
</script>