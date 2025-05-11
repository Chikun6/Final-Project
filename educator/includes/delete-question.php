<?php
include './../../db_connect.php';
$id = $_GET['id'];
$conn->query("DELETE FROM quiz_questions WHERE id = $id");
echo 'success';
?>