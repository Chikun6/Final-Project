<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SmartLearning Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
  .fixed-top {
    background-color: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  .navbar {
    background-color: #cee9fc;
  }
  .navbar-brand img {
    height: 55px;
  }
  /* ✅ Stronger selector to hide dropdown arrow */
  .navbar .dropdown-toggle::after {
    display: none !important;
  }
</style>

</head>

<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <img src="./images/logoupdate.png" alt="Logo"> SmartLearning
      </a>

      <!-- Toggler for mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="btn btn-outline-primary dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Login
                </a>
                <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                  <li><a class="dropdown-item" href="login.php?role=student">Student Login</a></li>
                  <li><a class="dropdown-item" href="login.php?role=educator">Educator Login</a></li>
                  <li><a class="dropdown-item" href="login.php?role=admin">Admin Login</a></li>
                </ul>
              </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Push content below navbar -->
<div style="margin-top: 130px;"></div>

<!-- Bootstrap Bundle JS (for dropdown functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
