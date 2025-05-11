<?php
include 'db_connect.php';
session_start(); // make sure this is at the top

$course_id = $_GET['id'] ?? 0;  // ✅ Move this up
$student_id = $_SESSION['user_id'] ?? 0;
$enrolled = false;

// Navigation based on session
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
  include_once 'navbar.php';
} else {
  include_once 'student_navbar.php';

  // ✅ Enrollment check AFTER $course_id is defined
  $enroll_check = $conn->prepare("SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?");
  $enroll_check->bind_param("ii", $student_id, $course_id);
  $enroll_check->execute();
  $enrolled = $enroll_check->get_result()->num_rows > 0;
}

// ✅ Course and chapter queries
$course_query = $conn->prepare("
  SELECT courses.*, users.name AS instructor_name 
  FROM courses 
  JOIN users ON courses.educator_id = users.id 
  WHERE courses.id = ?
");
$course_query->bind_param("i", $course_id);
$course_query->execute();
$course_result = $course_query->get_result();
$course = $course_result->fetch_assoc();

$chapters_query = $conn->prepare("SELECT * FROM chapters WHERE course_id = ?");
$chapters_query->bind_param("i", $course_id);
$chapters_query->execute();
$chapters_result = $chapters_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($course['title']) ?> | Course Detail</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .course-detail-container {
      padding: 40px 20px;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .video-player {
      width: 100%;
      border-radius: 10px;
      height : 400px;
    }

    .lecture-item {
      padding: 8px 12px;
      background: #f8f9fa;
      border: 1px solid #ddd;
      margin: 5px 0;
      border-radius: 6px;
      cursor: pointer;
    }

    .lecture-item:hover {
      background: #e2e6ea;
    }

    .course-title {
      font-size: 28px;
      font-weight: 600;
    }

    .price-tag {
      font-size: 20px;
      color: green;
    }

    .old-price {
      text-decoration: line-through;
      color: red;
    }

    .desc {
      font-size: 15px;
      font-weight : bold;
      margin-top : 4px;
    }

    .enroll-btn {
      margin-top: 20px;
    }

    .accordion-button:focus {
      box-shadow: none;
    }
  </style>
</head>
<body>

<div class="container course-detail-container">
  <a href="courses.php" class="btn btn-sm btn-outline-secondary mb-3">← Back to Courses</a>

  <div class="row g-4">
    <!-- Left Panel -->
    <div class="col-md-5">
      <div class="card p-4">
        <h2 class="course-title"><?= htmlspecialchars($course['title']) ?></h2>

        <p class="desc mt-2"><?= nl2br(htmlspecialchars($course['description'])) ?></p>

        <!-- Topics Toggle Button -->
        <?php if (!empty($course['topics'])): 
        $topics = explode(',', $course['topics']);
        $half = ceil(count($topics) / 2);
        $left = array_slice($topics, 0, $half);
        $right = array_slice($topics, $half);
        ?>
        <button class="btn btn-outline-info mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#topicsCollapse" aria-expanded="false" aria-controls="topicsCollapse">
        Show What You’ll Learn
        </button>

        <div class="collapse" id="topicsCollapse">
        <div class="row">
            <div class="col-6">
            <h6>What You’ll Learn</h6>
            <ul class="list-group list-group-flush">
                <?php foreach ($left as $t): ?>
                <li class="list-group-item"><?= htmlspecialchars(trim($t)) ?></li>
                <?php endforeach; ?>
            </ul>
            </div>
            <div class="col-6">
            <h6 class="invisible">What You’ll Learn</h6>
            <ul class="list-group list-group-flush">
                <?php foreach ($right as $t): ?>
                <li class="list-group-item"><?= htmlspecialchars(trim($t)) ?></li>
                <?php endforeach; ?>
            </ul>
            </div>
        </div>
        </div>
        <?php endif; ?>


        
        <p><strong>Category:</strong> <?= htmlspecialchars($course['category'] ?? 'N/A') ?></p>
        <p><strong>Level:</strong> <?= htmlspecialchars($course['level'] ?? 'All Levels') ?></p>
        <p><strong>Created On:</strong> <?= date('d M Y', strtotime($course['created_at'])) ?></p>
        <p><strong>Created By :</strong> <?= htmlspecialchars($course['instructor_name']) ?></p>

        <div class="mt-2">
          <strong>Price:</strong>
          <?php if (!empty($course['discount']) && $course['discount'] > 0): 
              $discounted = $course['price'] - ($course['price'] * $course['discount'] / 100);
          ?>
            <span class="price-tag">₹<?= $discounted ?></span>
            <span class="old-price">₹<?= $course['price'] ?></span>
          <?php else: ?>
            <span class="price-tag">₹<?= $course['price'] ?></span>
          <?php endif; ?>
        </div>
        

        <!-- Enrollment Section -->
        <?php if (!$enrolled): ?>
          <button id="enroll-btn" class="btn btn-primary w-100" data-course-id="<?= $course_id ?>" data-amount="<?= $price ?>">Enroll Now</button>
        <?php else: ?>
          <button class="btn btn-outline-success w-100" disabled>Already Enrolled - Watch Now</button>
        <?php endif; ?>

    </div>

    <!-- Right Panel: Video Player + Chapters & Lectures -->
    <div class="col-md-7">
      <div class="card p-4 mb-3">
        <h5 class="mb-3">🎬 Lecture Viewer</h5>
        <video id="videoPlayer" class="video-player" controls>
          <source src="videos/5495890-hd_1080_1920_30fps.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>

      <div class="card p-3">
        <h5>📚 Course Content</h5>
        <div class="accordion" id="courseContent">
          <?php 
          $chapterIndex = 0;
          while($chapter = $chapters_result->fetch_assoc()): 
              $chapter_id = $chapter['id'];
              $lectures_query = $conn->prepare("SELECT * FROM lectures WHERE chapter_id = ?");
              $lectures_query->bind_param("i", $chapter_id);
              $lectures_query->execute();
              $lectures_result = $lectures_query->get_result();
          ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?= $chapterIndex ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $chapterIndex ?>">
                  <?= htmlspecialchars($chapter['chapter_name']) ?>
                </button>
              </h2>
              <div id="collapse<?= $chapterIndex ?>" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                <div class="accordion-body">
                  <ul class="list-group mt-1">
                    <?php while ($lecture = $lectures_result->fetch_assoc()): ?>
                      <li class="list-group-item lecture-item d-flex justify-content-between align-items-center">
                        <?= htmlspecialchars($lecture['title']) ?>
                        <button 
                          class="btn btn-sm <?= $enrolled ? 'btn-outline-success' : 'btn-outline-secondary' ?>"
                          <?= $enrolled ? "onclick=\"playLecture('".htmlspecialchars($lecture['video_url'])."')\"" : '' ?>>
                          <?= $enrolled ? 'Watch' : '🔒 Locked' ?>
                        </button>
                      </li>
                    <?php endwhile; ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php 
            $chapterIndex++;
          endwhile; 
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
  <div id="enrollToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        🎉 Successfully enrolled in the course!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script>
function playLecture(videoPath) {
    const player = document.getElementById("videoPlayer");
    player.src = "educator/includes/" + videoPath;
    player.load();
    player.play();
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
