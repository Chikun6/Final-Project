<?php
include_once 'student_navbar.php';
require_once 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .roadmap-img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="text-center mb-4">Career Guide for IT Campus Exams</h1>

    <!-- Search Form -->
    <form method="GET" class="d-flex mb-5">
        <input type="text" name="company" class="form-control me-2" placeholder="Enter Company Name (e.g., TCS)" required>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    if (isset($_GET['company'])) {
        $company = trim($_GET['company']);

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM companies WHERE name LIKE ?");
        $searchTerm = "%" . $company . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>

    <!-- Company Info Card -->
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title text-center mb-4"><?php echo htmlspecialchars($row['name']); ?></h2>

            <!-- About Company -->
            <h4>About <?php echo htmlspecialchars($row['name']); ?>:</h4>
            <p class="mb-4">
                <?php echo htmlspecialchars($row['name']); ?> is one of India's top IT services and consulting companies.
                They recruit freshers via campus drives, requiring strong aptitude, coding, and communication skills.
            </p>

            <!-- Exam Pattern -->
            <h4>Exam Pattern:</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Section</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pattern_parts = explode(',', $row['exam_pattern']);
                        foreach ($pattern_parts as $part) {
                            echo "<tr><td>Section</td><td>" . htmlspecialchars(trim($part)) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Syllabus -->
            <h4>Syllabus:</h4>
            <p><?php echo nl2br(htmlspecialchars($row['syllabus'])); ?></p>

            <!-- Preparation Roadmap -->
            <h4>Preparation Roadmap:</h4>
            <p><?php echo nl2br(htmlspecialchars($row['preparation_roadmap'])); ?></p>

            <!-- Roadmap Image -->
            <img src="https://img.freepik.com/free-vector/gradient-roadmap-infographic-template_23-2149020524.jpg?semt=ais_hybrid&w=740" 
                 alt="Preparation Roadmap" class="roadmap-img img-fluid my-4">

            <!-- Reference Videos -->
            <h4 class="mt-5">Reference Videos:</h4>
            <div class="row">
    <?php 
    if (!empty($row['youtube_links'])) {
        $videos = explode(',', $row['youtube_links']);
        foreach ($videos as $video) {
            $video = trim($video);
            $videoId = '';

            // Handle both full and short YouTube URLs
            if (strpos($video, 'youtu.be/') !== false) {
                // Short link: https://youtu.be/VIDEO_ID
                $parts = explode('youtu.be/', $video);
                $videoId = $parts[1] ?? '';
            } elseif (strpos($video, 'youtube.com') !== false) {
                // Full link: https://www.youtube.com/watch?v=VIDEO_ID
                parse_str(parse_url($video, PHP_URL_QUERY), $queryVars);
                $videoId = $queryVars['v'] ?? '';
            }

            if (!empty($videoId)) {
    ?>
    <div class="col-md-6 mb-3">
        <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                    frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <?php 
            }
        }
    } else {
        echo '<p class="text-muted">No YouTube videos available.</p>';
    }
    ?>
</div>

        </div>
    </div>

    <?php
        } else {
            echo "<div class='alert alert-danger'>No company found with the name '" . htmlspecialchars($company) . "'.</div>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
