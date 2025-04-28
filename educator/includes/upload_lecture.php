<?php
ob_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './../../db_connect.php';

$title = $_POST['title'];
$duration = $_POST['duration'];
$preview = isset($_POST['preview']) ? 1 : 0;
$chapter_id = $_POST['chapter_id'];
$uploadDir = "../uploads/videos/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["video_file"])) {
    echo json_encode(["status" => "error", "message" => "No video file received."]);
    exit;
}

$videoName = basename($_FILES["video_file"]["name"]);
$targetPath = $uploadDir . time() . "_" . $videoName;

if (!move_uploaded_file($_FILES["video_file"]["tmp_name"], $targetPath)) {
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
    echo json_encode(["status" => "error", "message" => "Chapter does not exist."]);
    exit;
}

$sql = "INSERT INTO lectures (chapter_id, title, duration, video_url, is_preview) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $chapter_id, $title, $duration, $videoPath, $preview);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Lecture uploaded successfully!", "chapter_id" => $chapter_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Database insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
