<?php
require_once './../../db_connect.php';

$response = [];

// Get the incoming data
$data = json_decode(file_get_contents("php://input"), true);

$course_id = $data['course_id'];
$chapter_name = $data['chapter_name'];
$lectures = $data['lectures']; // This should be an array of lectures

// Insert chapter into the database
$stmt = $conn->prepare("INSERT INTO chapters (course_id, chapter_name) VALUES (?, ?)");
$stmt->bind_param("is", $course_id, $chapter_name);

if ($stmt->execute()) {
    $chapter_id = $stmt->insert_id; // Get the ID of the inserted chapter

    // Insert lectures associated with the chapter
    $lectureStmt = $conn->prepare("INSERT INTO lectures (chapter_id, title, duration, video_url, is_preview) VALUES (?, ?, ?, ?, ?)");

    foreach ($lectures as $lecture) {
        // Check if video file is uploaded
        if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] == 0) {
            $targetDir = 'uploads/'; // Set the target directory for uploads
            $fileName = basename($_FILES['video_file']['name']);
            $targetFilePath = $targetDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $targetFilePath)) {
                // If video upload is successful, store the file path in the database
                $video_url = $targetFilePath;
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to upload video file.';
                echo json_encode($response);
                exit;
            }
        } else {
            // If no file was uploaded, use a default or empty value for video_url
            $video_url = '';
        }

        // Bind parameters and execute query
        $lectureStmt->bind_param("isiss", $chapter_id, $lecture['title'], $lecture['duration'], $video_url, $lecture['is_preview']);
        
        if (!$lectureStmt->execute()) {
            $response['success'] = false;
            $response['message'] = 'Failed to insert some lectures. Error: ' . $conn->error;
            echo json_encode($response);
            exit;
        }
    }

    $response['success'] = true;
    $response['message'] = 'Chapter and lectures saved successfully.';
} else {
    $response['success'] = false;
    $response['message'] = 'Failed to insert chapter.';
}

// Return the response as JSON
echo json_encode($response);
?>
