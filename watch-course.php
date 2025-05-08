<?php
include_once 'student_navbar.php';
require_once 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$courseId = $_GET['course_id'] ?? 0;
$lectureId = $_GET['lecture_id'] ?? null;

// Enrollment check
$check = $conn->prepare("SELECT * FROM enrollments WHERE course_id = ? AND student_id = ?");
$check->bind_param('ii', $courseId, $userId);
$check->execute();
if ($check->get_result()->num_rows === 0) {
    echo "You are not enrolled in this course.";
    exit;
}

// Course info with educator name
$courseStmt = $conn->prepare("
    SELECT c.title AS title, u.name AS educator_name
    FROM courses c
    JOIN users u ON c.educator_id = u.id
    WHERE c.id = ?
");
$courseStmt->bind_param('i', $courseId);
$courseStmt->execute();
$course = $courseStmt->get_result()->fetch_assoc();

// Chapters
$chapterQuery = $conn->prepare("SELECT id, chapter_name FROM chapters WHERE course_id = ?");
$chapterQuery->bind_param('i', $courseId);
$chapterQuery->execute();
$chapters = $chapterQuery->get_result();

// Initial lecture
$selectedLecture = null;
$selectedLectureId = null;
if ($lectureId) {
    $lectureStmt = $conn->prepare("SELECT id, title, video_url FROM lectures WHERE id = ?");
    $lectureStmt->bind_param('i', $lectureId);
    $lectureStmt->execute();
    $selectedLecture = $lectureStmt->get_result()->fetch_assoc();
    $selectedLectureId = $lectureId;
}

// Watched lectures
$progressQuery = $conn->prepare("SELECT lecture_id FROM lecture_progress WHERE student_id = ? AND progress_percent >= 100");
$progressQuery->bind_param('i', $userId);
$progressQuery->execute();
$watchedResult = $progressQuery->get_result();
$watchedLectures = [];
while ($row = $watchedResult->fetch_assoc()) {
    $watchedLectures[] = $row['lecture_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Watch Course - <?= htmlspecialchars($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .lecture-link {
            cursor: pointer;
            padding: 10px 10px;
            display: block;
            color: #000;
            border-radius: 5px;
            transition: 0.2s;
        }
        .lecture-link:hover, .lecture-link.active {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .video-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .watched-status {
            font-size: 0.9em;
            font-weight: bold;
            margin-left : 8px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Sidebar -->
        <div class="col-md-4 p-4 bg-white border-end">
            <h4 class="mb-3"><?= htmlspecialchars($course['title']) ?></h4>
            <div class="accordion" id="chapterAccordion">
                <?php
                $chapterIndex = 0;
                while ($chapter = $chapters->fetch_assoc()):
                    $chapterIndex++;
                    $chapterId = $chapter['id'];
                    $lectureQuery = $conn->prepare("SELECT id, title, video_url FROM lectures WHERE chapter_id = ?");
                    $lectureQuery->bind_param('i', $chapterId);
                    $lectureQuery->execute();
                    $lectures = $lectureQuery->get_result();
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $chapterIndex ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?= $chapterIndex ?>" aria-expanded="false"
                            aria-controls="collapse<?= $chapterIndex ?>">
                            <?= htmlspecialchars($chapter['chapter_name']) ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $chapterIndex ?>" class="accordion-collapse collapse"
                         aria-labelledby="heading<?= $chapterIndex ?>" data-bs-parent="#chapterAccordion">
                        <div class="accordion-body">
                            <?php while ($lec = $lectures->fetch_assoc()): ?>
                            <span class="lecture-link <?= ($lec['id'] == $selectedLectureId ? 'active' : '') ?>"
                                  data-title="<?= htmlspecialchars($lec['title']) ?>"
                                  data-video="<?= htmlspecialchars($lec['video_url']) ?>"
                                  data-id="<?= $lec['id'] ?>">
                                📹 <?= htmlspecialchars($lec['title']) ?>
                                <span class="watched-status text-success">
                                <?= in_array($lec['id'], $watchedLectures) ? 'Watched' : '' ?>
                                </span>
                            </span>
                            
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Video Player -->
        <div class="col-md-8 p-4">
            <div class="video-container">
                <h5 id="video-title"><?= $selectedLecture ? htmlspecialchars($selectedLecture['title']) : "Select a Lecture" ?></h5>
                <video id="video-player" width="100%" height="400" controls <?= $selectedLecture ? '' : 'style="display:none;"' ?>>
                    <source id="video-source" src="<?= $selectedLecture ? 'educator/includes/' . htmlspecialchars($selectedLecture['video_url']) : '' ?>" type="video/mp4">
                </video>
                <input type="hidden" id="current-lecture-id" value="<?= $selectedLectureId ?? '' ?>">
                <?php if (!$selectedLecture): ?>
                    <p class="text-muted mt-3">Choose a lecture from the left panel to watch.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const videoPlayer = document.getElementById('video-player');
const videoTitle = document.getElementById('video-title');
const lectureLinks = document.querySelectorAll('.lecture-link');
const lectureIdInput = document.getElementById('current-lecture-id');

let lastReportedPercent = 0;

lectureLinks.forEach(link => {
    link.addEventListener('click', function () {
        // Reset active styling
        lectureLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');

        // Load new video
        const title = this.dataset.title;
        const videoPath = 'educator/includes/' + this.dataset.video.replace(/^\/+/, '');
        const lectureId = this.dataset.id;

        videoTitle.textContent = title;
        document.getElementById('video-source').src = videoPath;
        lectureIdInput.value = lectureId;
        videoPlayer.load();
        videoPlayer.style.display = 'block';
        videoPlayer.play().catch(console.error);

        lastReportedPercent = 0;
    });
});

videoPlayer.addEventListener('timeupdate', () => {
    const currentTime = videoPlayer.currentTime;
    const duration = videoPlayer.duration;
    const percentWatched = Math.floor((currentTime / duration) * 100);

    if (percentWatched - lastReportedPercent >= 10) {
        lastReportedPercent = percentWatched;
        const lectureId = lectureIdInput.value;

        if (lectureId) {
            fetch('update_progress.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ lecture_id: lectureId, progress_percent: percentWatched })
            }).then(res => res.json())
              .then(data => console.log('Progress updated:', data))
              .catch(err => console.error('Error:', err));
        }
    }
});

videoPlayer.addEventListener('ended', () => {
    const lectureId = lectureIdInput.value;
    if (lectureId) {
        fetch('update_progress.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ lecture_id: lectureId, progress_percent: 100 })
        }).then(res => res.json())
          .then(data => {
              console.log('Marked complete');
              const statusSpan = document.querySelector(`.lecture-link[data-id="${lectureId}"] + .watched-status`);
              if (statusSpan) statusSpan.textContent = 'Watched';
          })
          .catch(err => console.error('Error marking complete:', err));
    }
});
</script>

<?php include_once 'footer.php'; ?>
</body>
</html>
