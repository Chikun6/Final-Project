<?php
require_once './../../db_connect.php';
session_start();

$educator_id = $_SESSION['user_id'];

// Total Enrollments
$enrollments_query = $conn->query("SELECT COUNT(*) AS total FROM enrollments 
                                   INNER JOIN courses ON enrollments.course_id = courses.id 
                                   WHERE courses.educator_id = $educator_id");
$total_enrollments = $enrollments_query->fetch_assoc()['total'] ?? 0;

// Total Courses
$courses_query = $conn->query("SELECT COUNT(*) AS total FROM courses WHERE educator_id = $educator_id");
$total_courses = $courses_query->fetch_assoc()['total'] ?? 0;

// Total Earnings (Assuming course price * enrollments)
$earnings_query = $conn->query("
    SELECT 
        SUM(c.price - (c.price * IFNULL(c.discount, 0) / 100)) AS total 
    FROM enrollments e 
    INNER JOIN courses c ON e.course_id = c.id 
    WHERE c.educator_id = $educator_id
");

$total_earnings = $earnings_query->fetch_assoc()['total'] ?? 0;

// Round to 2 decimal places for better clarity
$total_earnings = round($total_earnings, 2);



// Recent Enrollments
$recent_query = $conn->query("SELECT u.name, c.title, e.enrolled_at FROM enrollments e 
                              JOIN users u ON e.student_id = u.id 
                              JOIN courses c ON e.course_id = c.id 
                              WHERE c.educator_id = $educator_id 
                              ORDER BY e.enrolled_at DESC LIMIT 5");
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5>Total Enrollments</h5>
                <h3><?= $total_enrollments ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5>Total Courses</h5>
                <h3><?= $total_courses ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 text-center shadow-sm">
                <h5>Total Earnings</h5>
                <h3>₹<?= $total_earnings ?: 0 ?></h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Recent Enrollments</h5>
        </div>
        <div class="card-body">
            <?php if ($recent_query->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Enroll Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $recent_query->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= date("d M Y", strtotime($row['enrolled_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No recent enrollments found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
