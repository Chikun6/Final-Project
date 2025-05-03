<?php
session_start();
require_once './../../db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$courseId = $data['courseId'];
$chapterName = $data['chapterName'];
$lectures = $data['lectures'];

// Insert Chapter
$stmt = $conn->prepare("INSERT INTO chapters (course_id, chapter_name) VALUES (?, ?)");
$stmt->bind_param("is", $courseId, $chapterName);
if (!$stmt->execute()) {
    http_response_code(500);
    echo "Chapter insert failed: " . $stmt->error;
    exit();
}
$chapterId = $stmt->insert_id;

// Insert Lectures
foreach ($lectures as $lecture) {
    $title = $lecture['title'];
    $duration = $lecture['duration'];
    $url = $lecture['url'];
    $preview = $lecture['preview'] ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO lectures (chapter_id, title, duration, video_url, is_preview) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isisi", $chapterId, $title, $duration, $url, $preview);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo "Lecture insert failed: " . $stmt->error;
        exit();
    }
}

echo "Success";
?>
