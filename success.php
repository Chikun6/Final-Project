<?php
session_start();

// Check if the user has a valid session and payment was completed
if (!isset($_SESSION['payment_id'])) {
    // Redirect to home or error page if accessed directly
    header("Location: index.php");
    exit();
}

$payment_id = $_SESSION['payment_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h3 class="mb-3">🎉 Enrollment Successful!</h3>
        <p>Your payment has been received and you're now enrolled in the course.</p>
        <p><strong>Payment ID:</strong> <?= htmlspecialchars($payment_id) ?></p>
        <a href="student-dashboard.php" class="btn btn-primary mt-3">Go to Dashboard</a>
    </div>
</div>
</body>
</html>

<?php
// Optional: unset the session variable after displaying success
unset($_SESSION['payment_id']);
?>
