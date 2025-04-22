<?php
session_start();
require_once './../../db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'educator') {
    header("Location: ../index.php");
    exit();
}
// Ensure form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get form data
    $courseTitle = $_POST['courseTitle'];
    $courseDescription = $_POST['courseDescription'];
    $courseTopics = $_POST['courseTopics'];
    $courseCategory = $_POST['courseCategory'];
    $courseLevel = $_POST['courseLevel'];
    $courseTags = $_POST['courseTags'];
    $coursePrice = $_POST['coursePrice'];
    $courseDiscount = $_POST['courseDiscount'] ?? 0; // Default to 0 if no discount

    // Handle file upload for course thumbnail
    if (isset($_FILES['courseThumbnail'])) {
        $fileTmpPath = $_FILES['courseThumbnail']['tmp_name'];
        $fileName = $_FILES['courseThumbnail']['name'];
        $fileSize = $_FILES['courseThumbnail']['size'];
        $fileType = $_FILES['courseThumbnail']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define the upload directory
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . uniqid() . '.' . $fileExtension;

        // Validate file type (only images allowed)
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExts)) {
            // Move the uploaded file to the destination folder
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $thumbnailPath = $dest_path; // Path for the thumbnail
            } else {
                echo 'Error uploading file!';
                exit;
            }
        } else {
            echo 'Invalid file type. Only images are allowed.';
            exit;
        }
    } else {
        echo 'No thumbnail uploaded.';
        exit;
    }

    // Get the instructor ID from session
    $instructor_id = $_SESSION['user_id'];

    // Prepare and execute the database query
    $query = "INSERT INTO courses (educator_id,title, description, topics, category, level, thumbnail , price, discount,tags )
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("issssssiis", $instructor_id,$courseTitle, $courseDescription, $courseTopics, $courseCategory, $courseLevel, $thumbnailPath,$coursePrice, $courseDiscount, $courseTags);

        // Execute query
        if ($stmt->execute()) {
            echo 'Course added successfully!';
            header('Location: course-list.php'); // Redirect to course list or course detail page
        } else {
            echo 'Error adding course: ' . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo 'Error preparing query: ' . $conn->error;
    }
}

// Close DB connection
$conn->close();
?>
