<?php
require_once "navbar.php";
date_default_timezone_set('Asia/Kolkata');
$role = $_GET['role'] ?? 'student'; // Default to student if role is not passed
$roleTitle = ucfirst($role);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $roleTitle; ?> Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(to bottom right, rgba(0, 78, 146, 0.9), rgba(0, 4, 40, 0.9)),
                    url('https://www.transparenttextures.com/patterns/cubes.png');
        background-size: cover;
        background-repeat: repeat;
        color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
    }

    .card h3 {
        color: #004e92;
    }

    a {
        color: #004e92;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="text-center mb-4"><?php echo $roleTitle; ?> Login</h3>

            <?php if (isset($_SESSION['error'])): ?>
              <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="db_login.php" method="POST">
              <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <small>Don't have an account? <a href="register.php">Sign up here</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
