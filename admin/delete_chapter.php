<?php
include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM chapters WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: chapters.php");
exit();
?>
