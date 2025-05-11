<?php
$conn = new mysqli("localhost", "root", "", "smart_learning");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
include_once 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SmartLearning Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      background-color: #343a40;
      color: white;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      width: 220px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 15px;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #0d6efd;
      color: white;
    }
    .content-area {
      margin-left: 220px;
      padding: 20px;
    }
  </style>
</head>
<body>

<div class="row g-0">
  <!-- Sidebar -->
  <div class="col-md-2 sidebar">
    <a href="#" class="nav-link active" onclick="loadContent('dashboard_home.php', this)">Dashboard</a>
    <a href="#" class="nav-link" onclick="loadContent('users.php', this)">Users</a>
    <a href="#" class="nav-link" onclick="loadContent('courses.php', this)">Courses</a>
    <a href="#" class="nav-link" onclick="loadContent('chapters.php', this)">Chapters</a>
    <a href="#" class="nav-link" onclick="loadContent('lectures.php', this)">Lectures</a>
  </div>

  <!-- Content Area -->
  <div class="col-md-10 content-area" id="content-area">
    <?php include 'dashboard_home.php'; ?> <!-- Default content -->
  </div>
</div>

<script>
function loadContent(page, el) {
  const links = document.querySelectorAll('.sidebar .nav-link');
  links.forEach(link => link.classList.remove('active'));
  el.classList.add('active');

  fetch(page)
    .then(res => res.text())
    .then(data => {
      document.getElementById('content-area').innerHTML = data;

      // Attach delete logic only if it's users.php
      if (page === 'users.php') attachUserDeleteHandlers();
    })
    .catch(err => {
      document.getElementById('content-area').innerHTML = "<p class='text-danger'>Error loading content.</p>";
      console.error(err);
    });
}

function attachUserDeleteHandlers() {
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      if (confirm("Are you sure you want to delete this user?")) {
        fetch("users.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams({ action: "delete_user", id })
        })
        .then(res => res.text())
        .then(response => {
          if (response.trim() === "success") {
            document.getElementById("row-" + id)?.remove();
          } else {
            alert("Delete failed.");
          }
        });
      }
    });
  });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
