<?php
session_start();
include 'includes/db_connect.php';

// Validate required params
if (!isset($_GET['lecture_id'])) {
    http_response_code(400);
    exit('Lecture ID is required');
}

$lecture_id = intval($_GET['lecture_id']);

// Get lecture info
$lecture_query = $conn->prepare("SELECT video_url, chapter_id FROM lectures WHERE id = ?");
$lecture_query->bind_param("i", $lecture_id);
$lecture_query->execute();
$lecture_result = $lecture_query->get_result();
$lecture = $lecture_result->fetch_assoc();

if (!$lecture) {
    http_response_code(404);
    exit('Lecture not found');
}

$chapter_id = $lecture['chapter_id'];

// Get course ID from chapter
$course_query = $conn->prepare("SELECT course_id FROM chapters WHERE id = ?");
$course_query->bind_param("i", $chapter_id);
$course_query->execute();
$course_result = $course_query->get_result();
$course = $course_result->fetch_assoc();

if (!$course) {
    http_response_code(404);
    exit('Course not found');
}

$course_id = $course['course_id'];

// Check if user is enrolled
if (!isset($_SESSION['student_id'])) {
    http_response_code(401);
    exit('Unauthorized access');
}

$student_id = $_SESSION['student_id'];
$enroll_query = $conn->prepare("SELECT * FROM enrollments WHERE course_id = ? AND student_id = ?");
$enroll_query->bind_param("ii", $course_id, $student_id);
$enroll_query->execute();
$enroll_result = $enroll_query->get_result();

if ($enroll_result->num_rows === 0) {
    http_response_code(403);
    exit('Access denied');
}

// File path
$video_file = 'educator/' . basename($lecture['video_url']);

// Check if file exists
if (!file_exists($video_file)) {
    http_response_code(404);
    exit('Video file not found');
}

// Stream video with proper headers
$size = filesize($video_file);
$length = $size;
$start = 0;
$end = $size - 1;
$headers = getallheaders();

if (isset($headers['Range'])) {
    $range = $headers['Range'];
    $range = str_replace('bytes=', '', $range);
    $range = explode('-', $range);
    $start = intval($range[0]);
    if (isset($range[1]) && is_numeric($range[1])) {
        $end = intval($range[1]);
    }
    $length = $end - $start + 1;
    header("HTTP/1.1 206 Partial Content");
} else {
    header("HTTP/1.1 200 OK");
}

header("Content-Type: video/mp4");
header("Accept-Ranges: bytes");
header("Content-Length: $length");
header("Content-Range: bytes $start-$end/$size");

$fp = fopen($video_file, 'rb');
fseek($fp, $start);
$buffer_size = 8192;
while (!feof($fp) && ($pos = ftell($fp)) <= $end) {
    if ($pos + $buffer_size > $end) {
        $buffer_size = $end - $pos + 1;
    }
    echo fread($fp, $buffer_size);
    flush();
}
fclose($fp);
exit();
?>
