<?php
include 'db_connect.php';
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$start = $data['start'];
$end = $data['end'];

mysqli_query($conn, "UPDATE study_calendar SET start='$start', end='$end' WHERE id=$id");
?>
