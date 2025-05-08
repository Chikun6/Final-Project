<?php


session_start();
require_once './../../db_connect.php';

$educator_id = $_SESSION['user_id'];

// Fetch courses created by the logged-in educator
$sql = "SELECT c.id AS course_id, c.title AS course_title, e.student_id, u.name AS student_name, u.email, e.enrolled_at 
        FROM courses c
        JOIN enrollments e ON c.id = e.course_id
        JOIN users u ON e.student_id = u.id
        WHERE c.educator_id = ?
        ORDER BY c.title, e.enrolled_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $educator_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h3 class="mb-3">Enrolled Students</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Course Title</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Enrolled On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['course_title']}</td>
                            <td>{$row['student_name']}</td>
                            <td>{$row['email']}</td>
                            <td>" . date("d M Y", strtotime($row['enrolled_at'])) . "</td>
                          </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No students enrolled yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
