<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Connect to DB
require_once './../../db_connect.php';

if (
    !isset($_POST['course_id'], $_POST['chapter_name'], $_POST['lectures']) ||
    empty($_FILES['video_file']['name'])
) {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

$courseId = intval($_POST['course_id']);
$chapterName = $conn->real_escape_string(trim($_POST['chapter_name']));
$lectures = json_decode($_POST['lectures'], true);

// Insert chapter
$insertChapter = $conn->prepare("INSERT INTO chapters (course_id, chapter_name) VALUES (?, ?)");
$insertChapter->bind_param("is", $courseId, $chapterName);

if (!$insertChapter->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to insert chapter."]);
    exit;
}

$chapterId = $insertChapter->insert_id;

// Handle file upload
$uploadDir = "../uploads/videos/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$videoName = basename($_FILES["video_file"]["name"]);
$targetPath = $uploadDir . time() . "_" . $videoName;

if (!move_uploaded_file($_FILES["video_file"]["tmp_name"], $targetPath)) {
    echo json_encode(["success" => false, "message" => "Video upload failed."]);
    exit;
}

// Insert lecture (only handling first lecture for now)
if (count($lectures) > 0) {
    $lecture = $lectures[0];
    $title = $conn->real_escape_string($lecture['title']);
    $duration = $conn->real_escape_string($lecture['duration']);
    $isPreview = $lecture['is_preview'] ? 1 : 0;
    $videoPath = $conn->real_escape_string($targetPath);

    $insertLecture = $conn->prepare("INSERT INTO lectures (chapter_id, title, duration, video_url, is_preview) VALUES (?, ?, ?, ?, ?)");
    $insertLecture->bind_param("isssi", $chapterId, $title, $duration, $videoPath, $isPreview);

    if (!$insertLecture->execute()) {
        echo json_encode(["success" => false, "message" => "Failed to insert lecture."]);
        exit;
    }
}

echo json_encode(["success" => true, "message" => "Chapter and lecture saved successfully."]);
?>
