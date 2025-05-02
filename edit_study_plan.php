<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$id = $_GET['id'];  // Get the study plan id from the URL

// Fetch the study plan for editing
$result = $conn->query("SELECT * FROM study_plan WHERE id = $id AND student_id = $student_id");
$row = $result->fetch_assoc();

if (!$row) {
    echo "Study plan not found for this student.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $task = $_POST['task'];
    $datetime = $_POST['datetime'];

    // Update the record
    $stmt = $conn->prepare("UPDATE study_plan SET subject = ?, task = ?, datetime = ? WHERE id = ? AND student_id = ?");
    $stmt->bind_param("sssii", $subject, $task, $datetime, $id, $student_id);
    
    if ($stmt->execute()) {
        header("Location: st_dashboard.php");
        exit;
    } else {
        echo "Error updating study plan: " . $stmt->error;
    }
}
?>

<!-- Your HTML form for editing -->
<form action="edit_study_plan.php?id=<?= $row['id'] ?>" method="post">
    <input type="text" name="subject" value="<?= $row['subject'] ?>" required>
    <input type="text" name="task" value="<?= $row['task'] ?>" required>
    <input type="datetime-local" name="datetime" value="<?= $row['datetime'] ?>" required>
    <button type="submit">Save Changes</button>
</form>
