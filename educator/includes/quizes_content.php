<?php

session_start();
include './../../db_connect.php'; 

// Fetch teacher's courses
$teacher_id = $_SESSION['user_id'];
$courses = mysqli_query($conn, "SELECT * FROM courses WHERE educator_id = $teacher_id");
?>

<div class="container mt-4">
  <h3>Quiz Section</h3>
  <div class="form-group">
    <label>Select Course</label>
    <select id="courseSelect" class="form-control">
      <option value="">-- Select Course --</option>
      <?php while($course = mysqli_fetch_assoc($courses)) { ?>
        <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group mt-2">
    <label>Select Chapter</label>
    <select id="chapterSelect" class="form-control">
      
    </select>
  </div>

  <div id="quizFormContainer" class="mt-4"></div>
</div>

<script>
document.getElementById("courseSelect").addEventListener("change", function () {
  let courseId = this.value;
  fetch("includes/fetch_chapters.php?course_id=" + courseId)
    .then(res => res.text())
    .then(data => {
      document.getElementById("chapterSelect").innerHTML = data;
    });
});

document.getElementById("chapterSelect").addEventListener("change", function () {
  let html = '';
  for (let i = 1; i <= 10; i++) {
    html += `
    <div class="card mb-3 p-3">
      <h5>Question ${i}</h5>
      <input name="question_${i}" class="form-control mb-2" placeholder="Enter question">
      <input name="option_a_${i}" class="form-control mb-2" placeholder="Option A">
      <input name="option_b_${i}" class="form-control mb-2" placeholder="Option B">
      <input name="option_c_${i}" class="form-control mb-2" placeholder="Option C">
      <input name="option_d_${i}" class="form-control mb-2" placeholder="Option D">
      <select name="correct_option_${i}" class="form-control">
        <option value="">Correct Option</option>
        <option value="A">A</option><option value="B">B</option>
        <option value="C">C</option><option value="D">D</option>
      </select>
    </div>`;
  }

  html += `<button onclick="submitQuiz()" class="btn btn-success">Save & Host Quiz</button>`;
  document.getElementById("quizFormContainer").innerHTML = html;
});

function submitQuiz() {
  const courseId = document.getElementById("courseSelect").value;
  const chapterId = document.getElementById("chapterSelect").value;
  const formData = new FormData();
  formData.append("course_id", courseId);
  formData.append("chapter_id", chapterId);

  for (let i = 1; i <= 10; i++) {
    formData.append("question_" + i, document.querySelector(`[name=question_${i}]`).value);
    formData.append("option_a_" + i, document.querySelector(`[name=option_a_${i}]`).value);
    formData.append("option_b_" + i, document.querySelector(`[name=option_b_${i}]`).value);
    formData.append("option_c_" + i, document.querySelector(`[name=option_c_${i}]`).value);
    formData.append("option_d_" + i, document.querySelector(`[name=option_d_${i}]`).value);
    formData.append("correct_option_" + i, document.querySelector(`[name=correct_option_${i}]`).value);
  }

  fetch("save_quiz.php", { method: "POST", body: formData })
    .then(res => res.text())
    .then(data => alert(data));
}
</script>
