<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $teacher_id = intval($_POST['teacher_id']);
  $action = $_POST['action'];

  if (!in_array($action, ['approve', 'reject'])) {
    echo "invalid";
    exit;
  }

  $new_status = $action === 'approve' ? 'approved' : 'rejected';

  $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'educator'");
  $stmt->bind_param("si", $new_status, $teacher_id);

  echo $stmt->execute() ? "success" : "error";
}
?>
