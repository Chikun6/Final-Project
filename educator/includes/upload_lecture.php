<?php
// Start output buffering and set correct headers
ob_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

require_once './../../db_connect.php';

// Get POST data
$title = $_POST['title'] ?? '';
$duration = $_POST['duration'] ?? '';
$preview = isset($_POST['preview']) ? 1 : 0;
$chapter_id = $_POST['chapter_id'] ?? null;

$uploadDir = "uploads/videos/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check for video file
if (!isset($_FILES["video_file"])) {
    ob_end_clean();
    echo json_encode(["status" => "error", "message" => "No video file received."]);
    exit;
}

// Prepare file path
$videoName = basename($_FILES["video_file"]["name"]);
$targetPath = $uploadDir . time() . "_" . $videoName;

// Move uploaded file
if (!move_uploaded_file($_FILES["video_file"]["tmp_name"], $targetPath)) {
    ob_end_clean();
    echo json_encode(["status" => "error", "message" => "Video upload failed."]);
    exit;
}

$videoPath = $conn->real_escape_string($targetPath);

// Check if chapter exists
$checkStmt = $conn->prepare("SELECT id FROM chapters WHERE id = ?");
$checkStmt->bind_param("i", $chapter_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    ob_end_clean();
    echo json_encode(["status" => "error", "message" => "Chapter does not exist."]);
    exit;
}
$checkStmt->close();

// Insert lecture into database
$sql = "INSERT INTO lectures (chapter_id, title, duration, video_url, is_preview) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $chapter_id, $title, $duration, $videoPath, $preview);

if ($stmt->execute()) {
    ob_end_clean();
    echo json_encode(["status" => "success", "message" => "Lecture uploaded successfully!", "chapter_id" => $chapter_id]);
} else {
    ob_end_clean();
    echo json_encode(["status" => "error", "message" => "Database insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>