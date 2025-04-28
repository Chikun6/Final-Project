// Search courses functionality
$(document).ready(function () {
    $('#searchInput').on('keyup', function () {
        var searchTerm = $(this).val().toLowerCase();
        $('#courseContainer .course-card').each(function () {
            var title = $(this).data('title');
            if (title.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

// Toggle chapter visibility
function toggleChapter(button) {
    var chapterList = $(button).closest('.course-card').find('.chapter-list');
    chapterList.toggle();
}

// Open the modal to add a chapter
function openChapterModals(courseId) {
    $('#courseId').val(courseId);
    $('#chapterModal').modal('show');
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

// Show toast notifications
function showToast(message, type = 'success') {
    var toastClass = type === 'danger' ? 'bg-danger' : 'bg-success';
    var toast = $('#toastContainer');
    toast.removeClass('bg-success bg-danger').addClass(toastClass);
    toast.find('.toast-body').text(message);
    var toastInstance = new bootstrap.Toast(toast[0]);
    toastInstance.show();
}

// Open the lecture modal to add a new lecture
function openLectureModal(chapterId, chapterName) {
    $('#currentChapterId').val(chapterId);
    $('#lectureTitle1').val('');
    $('#lectureDuration1').val('');
    $('#lectureVideo1').val('');
    $('#lecturePreview1').prop('checked', false);
    $('#lectureModalLabel').text('Add Lecture to ' + chapterName);
    $('#lectureModal').modal('show');
}

// Submit lecture details
function submitLecture(chapterId) {
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

    $.ajax({
        url: './includes/upload_lecture.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let result;
            try {
                result = typeof res === "string" ? JSON.parse(res) : res;
            } catch (e) {
                alert("Unexpected server response.");
                console.error("Parse error:", res);
                return;
            }

            if (result.status === "success") {
                alert(result.message);
                $('#lectureModal').modal('hide');
                $('#lectureTitle1, #lectureDuration1').val('');
                $('#lectureVideo1').val('');
                $('#lecturePreview1').prop('checked', false);
                refreshLectures(chapterId); // ✅ Refresh lecture list
            } else {
                alert(result.message);
            }
        },
        error: function () {
            alert("AJAX error. Try again.");
        }
    });
}


// Edit chapter name
function updateChapterName(chapterId, element) {
    var newName = $(element).text();
    $.ajax({
        url: 'updateChapterName.php', // Adjust to the PHP file for updating chapter names
        type: 'POST',
        data: {
            chapterId: chapterId,
            newName: newName
        },
        success: function (response) {
            if (response.success) {
                showToast('Chapter name updated successfully!');
            } else {
                showToast('Error updating chapter name.', 'danger');
            }
        },
        error: function () {
            showToast('An error occurred while updating chapter name.', 'danger');
        }
    });
}

// Edit lecture title or duration
function updateLectureField(lectureId, field, element) {
    var newValue = $(element).text();
    $.ajax({
        url: 'updateLectureField.php', // Adjust to the PHP file for updating lecture fields
        type: 'POST',
        data: {
            lectureId: lectureId,
            field: field,
            newValue: newValue
        },
        success: function (response) {
            if (response.success) {
                showToast('Lecture field updated successfully!');
            } else {
                showToast('Error updating lecture field.', 'danger');
            }
        },
        error: function () {
            showToast('An error occurred while updating lecture field.', 'danger');
        }
    });
}

// Delete chapter
function deleteChapterBackend(chapterId) {
    $.ajax({
        url: './includes/delete_chapter.php', // Adjust to the PHP file for deleting chapters
        type: 'POST',
        data: { chapterId: chapterId },
        success: function (response) {
            if (response.success) {
                $('#chapter_' + chapterId).remove();
                showToast('Chapter deleted successfully!');
            } else {
                showToast('Error deleting chapter.', 'danger');
            }
        },
        error: function () {
            showToast('An error occurred while deleting chapter.', 'danger');
        }
    });
}

// Delete lecture
function deleteLectureBackend(lectureId) {
    $.ajax({
        url: '.includes/delete_lecture.php', // Adjust to the PHP file for deleting lectures
        type: 'POST',
        data: { lectureId: lectureId },
        success: function (response) {
            if (response.success) {
                $('#lecture_' + lectureId).remove();
                showToast('Lecture deleted successfully!');
            } else {
                showToast('Error deleting lecture.', 'danger');
            }
        },
        error: function () {
            showToast('An error occurred while deleting lecture.', 'danger');
        }
    });
}
