<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$user_id = $_SESSION['user_id'];
$events = [];

$query = "SELECT * FROM study_calendar WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Format created_at to a human-readable format
    $created_at = date('Y-m-d H:i:s', strtotime($row['created_at'])); // or change the format as needed

    // Add event to the array, including created_at field
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end'],
        'created_at' => $created_at, // Include created_at
        'color' => $row['color']
    ];
}

echo json_encode($events);
?>
