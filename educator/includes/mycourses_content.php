<?php
session_start();
$educatorId = $_SESSION['user_id']; // Adjust as necessary

require_once './../../db_connect.php';

$query = "SELECT * FROM courses WHERE educator_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $educatorId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- UI: Search Courses -->
<div class="container mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search courses...">
</div>

<!-- Display Course Titles with Add Chapter Button -->
<div class="container" id="courseContainer">
    <?php while ($course = $result->fetch_assoc()): ?>
        <div class="course-card border p-2 mb-2" data-title="<?= strtolower(htmlspecialchars($course['title'])) ?>">
            <div class="d-flex justify-content-between align-items-center">
                <strong><?= htmlspecialchars($course['title']) ?></strong>
                <div>
                <button class="btn btn-sm btn-primary" onclick="openChapterModals(<?= json_encode($course['id']) ?>)">+ Add Chapter</button>

                    <button class="btn btn-sm btn-secondary" onclick="toggleChapter(this)">Toggle</button>
                </div>
            </div>

            <!-- View Chapters and Lectures -->
            <div class="chapter-list mt-2" style="display:none">
                <?php
                $courseId = $course['id'];
                $chapterQuery = "SELECT * FROM chapters WHERE course_id = ?";
                $chapterStmt = $conn->prepare($chapterQuery);
                $chapterStmt->bind_param("i", $courseId);
                $chapterStmt->execute();
                $chapterResult = $chapterStmt->get_result();
                while ($chapter = $chapterResult->fetch_assoc()):
                ?>
                    <div class="chapter-card border rounded p-2 mb-2" id="chapter_<?= $chapter['id'] ?>">
                        <div class="d-flex justify-content-between">
                            <strong contenteditable="true" onblur="updateChapterName(<?= $chapter['id'] ?>, this)"><?= htmlspecialchars($chapter['chapter_name']) ?></strong>
                            <div>
                                <button class="btn btn-sm btn-warning" onclick="editChapter(<?= $chapter['id'] ?>)">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteChapterBackend(<?= $chapter['id'] ?>)">Delete</button>
                                <button class="btn btn-sm btn-primary" onclick="openLectureModal(<?= $chapter['id'] ?>, '<?= htmlspecialchars($chapter['chapter_name']) ?>')">+ Add Lecture</button>
                            </div>
                        </div>
                        <ul class="mt-2">
                            <?php
                            $lectureQuery = "SELECT * FROM lectures WHERE chapter_id = ?";
                            $lectureStmt = $conn->prepare($lectureQuery);
                            $lectureStmt->bind_param("i", $chapter['id']);
                            $lectureStmt->execute();
                            $lectureResult = $lectureStmt->get_result();
                            while ($lecture = $lectureResult->fetch_assoc()):
                            ?>
                                <li>
                                    <span contenteditable="true" onblur="updateLectureField(<?= $lecture['id'] ?>, 'title', this)"><?= htmlspecialchars($lecture['title']) ?></span>
                                    (<span contenteditable="true" onblur="updateLectureField(<?= $lecture['id'] ?>, 'duration', this)"><?= htmlspecialchars($lecture['duration']) ?></span> mins)
                                    <button class="btn btn-sm btn-warning ms-2" onclick="editLecture(<?= $lecture['id'] ?>)">Edit</button>
                                    <button class="btn btn-sm btn-danger ms-2" onclick="deleteLectureBackend(<?= $lecture['id'] ?>)">Delete</button>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php $course = $result->fetch_assoc(); ?>
<!-- modal for lecture  -->
<!-- Add Lecture Modal -->
<div class="modal fade" id="lectureModal" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lectureModalLabel">Add Lecture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="currentChapterId">
        <div class="mb-3">
          <label for="lectureTitle" class="form-label">Title</label>
          <input type="text" class="form-control" id="lectureTitle1">
        </div>
        <div class="mb-3">
          <label for="lectureDuration" class="form-label">Duration</label>
          <input type="text" class="form-control" id="lectureDuration1">
        </div>
        <div class="mb-3">
          <label for="lectureVideo" class="form-label">Video File</label>
          <input type="file" class="form-control" id="lectureVideo1">
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="lecturePreview1">
          <label class="form-check-label" for="lecturePreview">Mark as Preview</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitLecture(<?= htmlspecialchars($course['id'], ENT_QUOTES, 'UTF-8') ?>)">Save Lecture</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for adding chapter and lecture -->
<div id="chapterModal" class="modal fade" tabindex="-1" aria-labelledby="chapterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chapterModalLabel">Add Chapter and Lectures</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="chapterForm">
                    <input type="hidden" id="courseId">
                    <input type="text" id="chapterName" class="form-control mb-2" placeholder="Chapter Name">

                    <ul id="chapterList" class="mb-3"></ul>

                    <div id="lectureForm" class="mb-3">
                        <input type="text" id="lectureTitle" class="form-control mb-1" placeholder="Lecture Title">
                        <input type="number" id="lectureDuration" class="form-control mb-1" placeholder="Duration (mins)">
                        <input type="file" id="lectureVideo" class="form-control mb-1" accept="video/*">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="lecturePreview">
                            <label class="form-check-label" for="lecturePreview">Preview</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="saveChapter()">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="toastContainer" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src = "./includes/course.js"></script>