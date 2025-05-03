<?php
session_start();
require_once "db_connect.php";
global $conn;

if (isset($_POST['otp'])) {
    if (!isset($_SESSION['email'])) {
        echo json_encode(["status" => "error", "debug" => "Session expired, login again"]);
        exit();
    }

    $email = $_SESSION['email'];
    $otp = $_POST['otp'];

    // Debugging
    error_log("Email from session: " . $email);
    error_log("OTP entered: " . $otp);

    // Check OTP
    $stmt = $conn->prepare("SELECT otp, otp_expires_at FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Fetch single row

    if ($user && $otp == $user['otp'] && strtotime($user['otp_expires_at']) > time()) {
        error_log("OTP Matched!");

        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, otp = NULL, otp_expires_at = NULL WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        session_destroy();
        echo json_encode(["status" => "ok"]);
    } else {
        error_log("OTP Mismatch or Expired!");
        echo json_encode(["status" => "error", "debug" => "OTP not found or expired"]);
    }
}
?>
