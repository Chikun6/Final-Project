<?php
require_once '../../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $quiz_id = intval($_POST['quiz_id']);

    $stmt = $conn->prepare("
        SELECT u.name, qr.score, qr.submitted_at
        FROM quiz_submissions qr
        JOIN users u ON qr.student_id = u.id
        WHERE qr.quiz_id = ?
        ORDER BY qr.score DESC, qr.submitted_at ASC
    ");
    $stmt->bind_param('i', $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h5>Leaderboard</h5>";
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>Rank</th><th>Name</th><th>Score</th><th>Date</th></tr></thead><tbody>';
        $rank = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$rank}</td>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>{$row['score']} / 10</td>
                    <td>{$row['submitted_at']}</td>
                </tr>";
            $rank++;
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info">No results found for this quiz.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
?>
