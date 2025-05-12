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

<div id="dashboard-content">
    <!-- Section for courses -->
    <div id="courses-section">
        <h4 class="mb-4">Your Courses</h4>
        <div class="row g-4" id="courses-list">
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
    </div>
    
    <!-- Section for quiz management (initially hidden) -->
    <div id="quiz-management-section" style="display:none;">
        <div id="quiz-management-area">
            <!-- Quiz management content will load here -->
        </div>
        <br>
        <button class="btn btn-secondary" onclick="goBackToCourses()">Back to Courses</button>
    </div>
</div>

<script>
function loadCourseQuizzes(courseId, courseTitle) {
    // Hide the courses section and show the quiz management section
    document.getElementById('courses-section').style.display = 'none';
    document.getElementById('quiz-management-section').style.display = 'block';

    // Fetch the quiz management content for the selected course
    fetch('includes/manage-course-quizzes.php?course_id=' + courseId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-management-area').innerHTML = `
                <h4>Quiz Management for: ${courseTitle}</h4>
                ${data}
            `;
        });
}

function goBackToCourses() {
    // Hide the quiz management section and show the courses section
    document.getElementById('quiz-management-section').style.display = 'none';
    document.getElementById('courses-section').style.display = 'block';
}
</script>
