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
                    <button class="btn btn-sm btn-primary" onclick="openChapterModal(<?= $course['id'] ?>)">+ Add Chapter</button>
                    <button class="btn btn-sm btn-secondary" onclick="toggleChapters(this)">Toggle</button>
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

<!-- Modal for adding lecture -->
<div id="lectureModal" class="modal" tabindex="-1" aria-labelledby="lectureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lectureModalLabel">Add Lecture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="lectureTitle" class="form-label">Lecture Title</label>
                        <input type="text" class="form-control" id="lectureTitle">
                    </div>
                    <div class="mb-3">
                        <label for="lectureDuration" class="form-label">Lecture Duration (mins)</label>
                        <input type="number" class="form-control" id="lectureDuration">
                    </div>
                    <div class="mb-3">
                        <label for="lectureVideo" class="form-label">Lecture Video</label>
                        <input type="file" class="form-control" id="lectureVideo">
                    </div>
                    <div class="mb-3">
                        <label for="lecturePreview" class="form-check-label">Preview Lecture</label>
                        <input type="checkbox" class="form-check-input" id="lecturePreview">
                    </div>
                    <input type="hidden" id="chapterId"> <!-- To store the chapter ID -->
                    <button type="button" class="btn btn-primary" onclick="addLecture()">Save Lecture</button>
                </form>
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

<!-- Modal for Adding Chapters and Lectures -->
<div class="modal-backdrop" id="chapterModal" style="display: none;">
    <div class="p-4 bg-white rounded shadow" style="max-width: 700px; width: 100%; overflow-y: auto; max-height: 90vh;">
        <h5 class="mb-3">Add Chapter and Lectures</h5>
        <input type="hidden" id="courseId">
        <input type="text" id="chapterName" class="form-control mb-2" placeholder="Chapter Name">

        <ul id="chapterList" class="mb-3"></ul>

        <div id="lectureForm" class="mb-3">
            <input type="text" id="lectureTitle" class="form-control mb-1" placeholder="Lecture Title">
            <input type="text" id="lectureDuration" class="form-control mb-1" placeholder="Duration (mins)">
            <input type="file" id="lectureVideo" class="form-control mb-1" accept="video/*">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="lecturePreview">
                <label class="form-check-label" for="lecturePreview">Preview</label>
            </div>
            <button class="btn btn-secondary mt-2" onclick="addLecture()">+ Add Lecture</button>
        </div>

        <div class="text-end">
            <button class="btn btn-success" onclick="saveChapter()">Save</button>
            <button class="btn btn-danger" onclick="closeChapterModal()">Cancel</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

function toggleChapters(button) {
    const container = button.closest('.course-card');
    const list = container.querySelector('.chapter-list');
    list.style.display = list.style.display === 'none' ? 'block' : 'none';
}

function showToast(message, isSuccess = true) {
    const toastEl = document.getElementById('toastContainer');
    toastEl.classList.remove('bg-success', 'bg-danger');
    toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger');
    toastEl.querySelector('.toast-body').textContent = message;
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

function openLectureModal(chapterId, chapterName) {
    console.log("Opening lecture modal for chapter:", chapterId, chapterName);
    // Set dynamic chapter name in the modal
    $('#dynamicChapterName').text(chapterName);
    $('#chapterId').val(chapterId); // Pass the chapter ID
    $('#lectureTitle, #lectureDuration, #lectureVideo').val(''); // Clear previous input values
    $('#lectureModal').modal('show'); // Display the modal
}

// Close the lecture modal
function closeLectureModal() {
    $('#lectureModal').hide(); // Hide the modal
}

function updateLectureField(id, field, element) {
    const value = element.textContent.trim();
    fetch('./includes/update_lecture.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, field, value })
    })
    .then(res => res.json())
    .then(data => showToast(data.message, data.success))
    .catch(() => showToast("Failed to update lecture", false));
}

function updateChapterName(id, element) {
    const name = element.textContent.trim();
    fetch('./includes/update_chapter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, name })
    })
    .then(res => res.json())
    .then(data => showToast(data.message, data.success))
    .catch(() => showToast("Failed to update chapter name", false));
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    const val = this.value.toLowerCase();
    document.querySelectorAll('.course-card').forEach(card => {
        const title = card.getAttribute('data-title');
        card.style.display = title.includes(val) ? '' : 'none';
    });
});

let chapters = [];

function openChapterModal(courseId) {
    chapters = [];
    $('#courseId').val(courseId);
    $('#chapterName').val('');
    $('#lectureTitle, #lectureDuration, #lectureUrl').val('');
    $('#lecturePreview').prop('checked', false);
    $('#chapterList').html('');
    $('#chapterModal').show();
}

function closeChapterModal() {
    $('#chapterModal').hide();
}

function addLecture() {
    const title = $('#lectureTitle').val();
    const duration = $('#lectureDuration').val();
    const videoFile = $('#lectureVideo')[0].files[0]; // Get video file
    const preview = $('#lecturePreview').is(':checked');

    

    if (chapters.length === 0) {
        const name = $('#chapterName').val();
        if (!name) return alert("Enter chapter name first.");
        chapters.push({ id: Date.now(), name, lectures: [] });
    }

    if (!title || !duration || !videoFile) return alert("All lecture fields are required!");
    // Prepare lecture data including video file
    const lectureData = { title, duration, videoFile, preview };

    chapters[0].lectures.push(lectureData);
    renderChapters();

    $('#lectureTitle, #lectureDuration').val('');
    $('#lectureVideo').val('');  // Clear file input
    $('#lecturePreview').prop('checked', false);
}


function renderChapters() {
    const chapter = chapters[0];
    let html = `<li><b>${chapter.name}</b>
        <button class="btn btn-sm btn-warning ms-2" onclick="editChapterName()">Edit</button>
        <button class="btn btn-sm btn-danger ms-2" onclick="deleteChapterLocal()">Delete</button>
        <ul>`;
    chapter.lectures.forEach((lec, idx) => {
        html += `<li>
            ${lec.title} (${lec.duration} mins)
            <button class="btn btn-sm btn-warning ms-2" onclick="editLectureLocal(${idx})">Edit</button>
            <button class="btn btn-sm btn-danger ms-2" onclick="deleteLectureLocal(${idx})">Delete</button>
        </li>`;
    });
    html += '</ul></li>';

    $('#chapterList').html(html);
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

function saveChapter() {
    const courseId = $('#courseId').val();

    if (chapters.length === 0 || chapters[0].lectures.length === 0) {
        alert("Please add at least one lecture.");
        return;
    }

    const data = {
        course_id: courseId,
        chapter_name: chapters[0].name,
        lectures: chapters[0].lectures
    };

    $.ajax({
        url: './includes/save_chapter_backend.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            try {
                const jsonResponse = JSON.parse(response);
                alert(jsonResponse.message);
                if (jsonResponse.success) {
                    $('#mainContent').load('./includes/my-courses_content.php?' + new Date().getTime());
                    closeChapterModal();
                }
            } catch (error) {
                console.error("Error parsing JSON:", error);
                alert("An error occurred while processing the response.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            alert("An error occurred while saving.");
        }
    });
}

function editLecture(id) {
    alert("Editing saved lecture is not implemented. Please delete and re-add.");
}

function deleteLectureBackend(id) {
    if (confirm("Are you sure you want to delete this lecture?")) {
        $.post('./includes/delete_lecture.php', { lecture_id: id }, function(response) {
            alert(response);
            $('#mainContent').load('./includes/my-courses_content.php?' + new Date().getTime());
        });
    }
}

function deleteChapterBackend(id) {
    if (confirm("Are you sure you want to delete this chapter?")) {
        $.post('./includes/delete_chapter.php', { chapter_id: id }, function(response) {
            alert(response);
            $('#mainContent').load('./includes/my-courses_content.php?' + new Date().getTime());
        });
    }
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