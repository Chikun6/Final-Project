<?php
session_start();
require_once "db_connect.php";  // Database connection
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $otp = rand(100000, 999999);
    $otp_expires_at = date("Y-m-d H:i:s", strtotime("+30 minutes"));
    $profile_pic = 'uploads/default.png';

    // Optional: Handle profile picture
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $profile_pic = $target_file;
        }
    }

    // Check if user already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR name = ?");
    $check->bind_param("ss", $email, $name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "exists";
        exit;
    }

    // Insert new user
    $insert = $conn->prepare("INSERT INTO users (name, email, password, role, image, otp, otp_expires_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssssss", $name, $email, $password, $role, $profile_pic, $otp, $otp_expires_at);

    if ($insert->execute()) {
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'danielsahh691@gmail.com';
            $mail->Password = 'gdwt arhu yuoj ecyq'; // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('smartlearning@gmail.com', 'LMS System');
            $mail->addAddress($email);
            $mail->Subject = 'OTP Verification';
            $mail->Body = "Your OTP is: $otp. It is valid for 30 minutes.";

            $mail->send();
            echo "success";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "error";
    }

    $conn->close();
}
?>
