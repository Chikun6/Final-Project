<?php 
session_start();
include('db_connect.php');
date_default_timezone_set("Asia/Calcutta");

// Capture payment details
$paymentid = $_POST['payment_id'];
$courseid = $_POST['course_id']; 
$studentid = $_SESSION['user_id']; 
$enrolledAt = date('Y-m-d H:i:s');

// Insert into enrollments table
$sql = "INSERT INTO enrollments ( student_id,course_id, payment_id, enrolled_at) 
        VALUES ( '$studentid', '$courseid', '$paymentid', '$enrolledAt')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo 'done';
    $_SESSION['payment_id'] = $paymentid;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
