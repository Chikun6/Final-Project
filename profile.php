<?php
session_start();
include 'db_connect.php';


$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    .profile-container{
        width : 600px;
        margin: 0 auto;
    }
        
    </style>
</head>
<?php include_once 'student_navbar.php'; ?>
<div class="container my-5">
    <div class="profile-container">
    <div class="card shadow p-4">
        <div class="text-center">
            <img src="<?php echo $user['image'] ?? 'default-profile.png'; ?>" class="rounded-circle" width="150" height="150" alt="Profile Picture">
            <h3 class="mt-3"><?php echo htmlspecialchars($user['name']); ?></h3>
        </div>

        <form class="mt-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" disabled>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="edit.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </form>
    </div>
    </div>
</div>


<div style="margin-top: 100px;"></div>
<?php include_once 'footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



