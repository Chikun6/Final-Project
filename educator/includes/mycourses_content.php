

<?php
session_start();
require_once './../../db_connect.php';

$educator_id = $_SESSION['user_id'];
$query = "SELECT id, title FROM courses WHERE educator_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $educator_id);
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
        <button type="button" class="btn btn-primary" onclick="submitLecture()">Save Lecture</button>
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

<script>

function toggleChapter(button) {
    const container = button.closest('.course-card');
    const list = container.querySelector('.chapter-list');
    list.style.display = list.style.display === 'none' ? 'block' : 'none';
}

function openChapterModals(courseId) {
    document.getElementById("courseId").value = courseId;
    const chapterModal = new bootstrap.Modal(document.getElementById("chapterModal"));
    chapterModal.show();
}

function closeChapterModal() {
    const chapterModal = new bootstrap.Modal(document.getElementById("chapterModal"));
    chapterModal.hide();
}

function saveChapter() {
    const lectures = []; // Array to hold lecture objects
    const courseId = $("#courseId").val().trim();
    const chapterName = $("#chapterName").val().trim();
    const lectureTitle = $("#lectureTitle").val().trim();
    const lectureDuration = $("#lectureDuration").val().trim();
    const lectureVideo = $("#lectureVideo")[0].files[0]; // Video file
    const preview = $("#lecturePreview").is(":checked"); // Preview checkbox

    console.log("courseId:", courseId);
    console.log("chapterName:", chapterName);
    console.log("lectureTitle:", lectureTitle);
    console.log("lectureDuration:", lectureDuration);
    console.log("lectureVideo:", lectureVideo);
    console.log("preview:", preview);

    // Validation
    if (!chapterName || !lectureTitle || !lectureDuration || !lectureVideo) {
        showToast("All fields are required!", "danger");
        return;
    }

    // Push lecture details
    lectures.push({
        title: lectureTitle,
        duration: lectureDuration,
        is_preview: preview
    });

    const formData = new FormData();
    formData.append("course_id", courseId);
    formData.append("chapter_name", chapterName);
    formData.append("lectures", JSON.stringify(lectures));

    if (lectureVideo) {
        formData.append("video_file", lectureVideo);
    }

    $.ajax({
        url: "./includes/save_chapter_backend.php",
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting content type
        dataType: "json",   // Expect JSON response
        success: function(response) {
            console.log(response);
            if (response.success) {
                showToast(response.message, "success");
            } else {
                showToast(response.message, "danger");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            showToast("An error occurred. Please try again.", "danger");
        }
    });
}


function showToast(message, type = "success") {
    const toast = document.getElementById("toastContainer");
    toast.querySelector(".toast-body").innerText = message;
    toast.classList.remove("bg-success", "bg-danger");
    toast.classList.add(`bg-${type}`);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

function editChapterName() {
    const newName = prompt("Edit chapter name:", chapters[0].name);
    if (newName) {
        chapters[0].name = newName;
        renderChapters();
    }
}

function deleteChapterLocal() {
    if (confirm("Are you sure you want to delete the chapter?")) {
        chapters = [];
        $('#chapterName').val('');
        $('#chapterList').html('');
    }
}

function editLectureLocal(index) {
    const lecture = chapters[0].lectures[index];
    const newTitle = prompt("Edit Lecture Title:", lecture.title);
    const newDuration = prompt("Edit Duration (mins):", lecture.duration);
    const newUrl = prompt("Edit Video URL:", lecture.url);
    const newPreview = confirm("Mark as preview? (OK = Yes, Cancel = No)");

    if (newTitle && newDuration && newUrl) {
        chapters[0].lectures[index] = { title: newTitle, duration: newDuration, url: newUrl, preview: newPreview };
        renderChapters();
    }
}

function deleteLectureLocal(index) {
    if (!chapters[0] || !chapters[0].lectures || !chapters[0].lectures[index]) {
        alert("Lecture not found.");
        return;
    }

    if (confirm("Are you sure you want to delete this lecture?")) {
        chapters[0].lectures.splice(index, 1);

        if (chapters[0].lectures.length === 0) {
            chapters = [];
        }

        renderChapters();
    }
}


function editLecture(id) {
    alert("Editing saved lecture is not implemented. Please delete and re-add.");
}

function deleteLectureBackend(id) {
    if (confirm("Are you sure you want to delete this lecture?")) {
        $.post('./includes/delete_lecture.php', { lecture_id: id }, function(response) {
            alert(response);
            $('#mainContent').load('../dashboard.php?' + new Date().getTime());
        });
    }
}

function deleteChapterBackend(id) {
    if (confirm("Are you sure you want to delete this chapter?")) {
        $.post('./includes/delete_chapter.php', { chapter_id: id }, function(response) {
            alert(response);
            $('#mainContent').load('../dashboard.php?' + new Date().getTime());
        });
    }
}


function openLectureModal(chapterId, chapterName) {
    $('#currentChapterId').val(chapterId); // Save chapter ID in hidden field
    $('#lectureTitle1, #lectureDuration1').val('');
    $('#lectureVideo1').val('');
    $('#lecturePreview1').prop('checked', false);
    $('#lectureModalLabel').text("Add Lecture to " + chapterName);
    $('#lectureModal').modal('show');
}

// Close the lecture modal
function closeLectureModal() {
    $('#lectureModal').hide(); // Hide the modal
}

function submitLecture() {
    const chapterId = $('#currentChapterId').val();
    addLecture(chapterId); // Call your existing upload function
}

function addLecture(chapterId) {
    const title = $('#lectureTitle1').val().trim();
    const duration = $('#lectureDuration1').val().trim();
    const videoFile = $('#lectureVideo1')[0].files[0];
    const preview = $('#lecturePreview1').is(':checked') ? 1 : 0;

    if (!title || !duration || !videoFile) {
        alert("Please fill all fields and select a video.");
        return;
    }

    const formData = new FormData();
    formData.append("title", title);
    formData.append("duration", duration);
    formData.append("video_file", videoFile); // Correct key for PHP $_FILES
    formData.append("preview", preview);
    formData.append("chapter_id", chapterId);

    console.log("Chapter ID:", chapterId);
    console.log("Title:", title);
    console.log("Video File:", videoFile);

    $.ajax({
        url: './includes/upload_lecture.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log("Raw response:", res);
            let result;
            try {
                result = typeof res === "string" ? JSON.parse(res) : res;
            } catch (e) {
                alert("Unexpected server response (invalid JSON).");
                console.error("JSON parse error:", res);
                return;
            }

            if (result.status === "success") {
                alert(result.message);
                $('#lectureModal').modal('hide');
                $('#lectureTitle1, #lectureDuration1').val('');
                $('#lectureVideo1').val('');
                $('#lecturePreview1').prop('checked', false);
                refreshLectures(chapterId);
            } else {
                alert(result.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText || error);
            alert("AJAX error. Server says: " + (xhr.responseText || error));
        }
    });
}


function refreshLectures(chapterId) {
    $.ajax({
        url: './includes/get_lectures.php',
        type: 'GET',
        data: { chapter_id: chapterId },
        success: function (html) {
            $('#lecture-list-' + chapterId).html(html);
        },
        error: function () {
            console.error("Failed to refresh lecture list.");
        }
    });
}
   


</script>

<style>
.modal-backdrop {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}
</style>
