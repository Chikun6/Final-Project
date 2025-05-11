<?php
include './../../db_connect.php';
$id = $_GET['id'];
$q = $conn->query("SELECT * FROM quiz_questions WHERE id = $id")->fetch_assoc();
echo json_encode($q);
?>