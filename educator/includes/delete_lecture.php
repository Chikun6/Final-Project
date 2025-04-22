<?php
require_once './../../db_connect.php';

$lecture_id = $_POST['lecture_id'];
$delete = $conn->query("DELETE FROM lectures WHERE id = $lecture_id");

echo $delete ? 'Lecture deleted successfully.' : 'Failed to delete lecture.';
?>
