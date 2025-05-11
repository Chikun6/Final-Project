<?php
session_start();
require_once '../db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'educator') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Educator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    height: 100vh;
    margin: 0;
}

.sidebar {
    width: 250px;
    background-color: #007bff;
    color: white;
    height: 100vh;
    padding: 20px;
    position: fixed;  /* Ensure the sidebar stays fixed on the left */
    top: 0;
    left: 0;
    z-index: 1000;
}

.sidebar h2 {
    font-size: 22px;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    padding: 12px;
    text-decoration: none;
    color: white;
    margin-bottom: 10px;
    border-radius: 6px;
    cursor: pointer;
}

.sidebar a:hover, .sidebar a.active {
    background-color: #0056b3;
}

.main-content {
    margin-left: 250px; /* Space for sidebar */
    flex-grow: 1;
    padding: 20px;
    overflow-y: auto;  /* Allows scrolling if content overflows */
}

.navbar {
    background-color: white;
    padding: 15px 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.dashboard-content {
    padding: 30px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

    </style>
</head>
<body>

<div class="sidebar">
    <h2>SmartLearning</h2>
    <a data-page="dashboard" class="nav-link active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
    <a data-page="add-course" class="nav-link"><i class="fas fa-plus-circle me-2"></i> Add Course</a>
    <a data-page="mycourses" class="nav-link"><i class="fas fa-book me-2"></i> My Courses</a>
    <a data-page="quizzes" class="nav-link"><i class="fas fa-users me-2"></i>Manage Quizzes</a>
    <a data-page="enrollments" class="nav-link"><i class="fas fa-users me-2"></i> Enrollments</a>
</div>

<div class="main-content">
    <div class="navbar d-flex justify-content-between align-items-center">
        <h4 class="m-0">Educator Panel</h4>
        <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>

    <div class="dashboard-content" id="main-content">
        <!-- Dynamic content will be loaded here -->
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script>
    function loadPage(page) {
        $('.nav-link').removeClass('active');
        $(`[data-page="${page}"]`).addClass('active');

        $.ajax({
            url: `includes/${page}_content.php`,
            method: 'GET',
            success: function(data) {
                $('#main-content').html(data);
            },
            error: function() {
                $('#main-content').html('<div class="alert alert-danger">Failed to load content.</div>');
            }
        });
    }

    // Initial load
    $(document).ready(function() {
        loadPage('dashboard');

        $('.nav-link').click(function() {
            const page = $(this).data('page');
            loadPage(page);
        });
    });
    function submitQuestions() {
  const form = document.getElementById('questionForm');

  if (!form || form.tagName !== 'FORM') {
    alert('Form not found or not a FORM element');
    return;
  }

  const formData = new FormData(form);

  fetch('includes/save-question.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    if (data.trim() === 'success') {
      const quizId = document.getElementById('quiz_id').value;
      bootstrap.Modal.getInstance(document.getElementById('questionModal')).hide();
      loadQuizQuestions(quizId);
    } else {
      alert("Error saving question: " + data);
    }
  });
}

</script>
<script src = "js/quiz.js"></script>
</body>
</html>
