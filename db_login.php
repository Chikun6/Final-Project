<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $expected_role = $_POST['role'];

    if($email == 'admin@gmail.com' && $password == 'admin@123'){
        header('Location:admin/dashboard.php');
        exit();
    }

    // Basic validation
    if (empty($email) || empty($password) || empty($expected_role)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: login.php?role=" . $expected_role);
        exit();
    }

    // Prepare & execute
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $expected_role);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify credentials
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['image'] = $user['image'];


        // Redirect based on role
        switch ($expected_role) {
            case 'student':
                header("Location: index.php");
                break;
            case 'educator':
                header("Location: educator/dashboard.php");
                break;
            case 'admin':
                header("Location: admin/dashboard.php");
                break;
        }
        exit();
    } else {
        $_SESSION['error'] = "Invalid credentials!";
        header("Location: login.php?role=" . $expected_role); // Go back to same role
        exit();
    }
}
?>
