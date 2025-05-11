<?php
session_start();
include 'db_connect.php';


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM study_plan WHERE id=? AND student_id=?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
}

header("Location: study_plan.php");
exit;
?>