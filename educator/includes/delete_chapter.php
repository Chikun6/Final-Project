<?php
require_once './../../db_connect.php';

$chapter_id = $_POST['chapter_id'];

// Delete lectures first
$conn->query("DELETE FROM lectures WHERE chapter_id = $chapter_id");

// Then delete chapter
$delete = $conn->query("DELETE FROM chapters WHERE id = $chapter_id");

echo $delete ? 'Chapter deleted successfully.' : 'Failed to delete chapter.';
?>
