<?php
session_start();
require_once "db_connect.php";

header('Content-Type: application/json');
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    try {
        $qry = "SELECT name FROM users WHERE email=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($user);
        }
    } catch (Exception $e) {
        echo "error";
    } finally {
        $conn->close();
    }
} else {
    echo "error";
}
?>


