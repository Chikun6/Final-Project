<?php
include './../../db_connect.php';

$quiz_id = $_GET['quiz_id'];
$quiz = $conn->query("SELECT title FROM quizzes WHERE id = $quiz_id")->fetch_assoc();
$questions = $conn->query("SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id");
?>

<h5 class="mb-3">Questions for <?= htmlspecialchars($quiz['title']) ?></h5>
<button class="btn btn-success mb-3" onclick="openAddQuestionModal(<?= $quiz_id ?>)">Add Question</button>

<?php if ($questions->num_rows > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Correct</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $questions->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['question_text']) ?></td>
                <td><?= $row['correct_option'] ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editQuestion(<?= $row['id'] ?>)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteQuestion(<?= $row['id'] ?>, <?= $quiz_id ?>)">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No questions yet.</div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="questionForm" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add/Edit Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="quiz_id" id="quiz_id">
          <input type="hidden" name="question_id" id="question_id">
          <div class="mb-2"><label>Question</label><textarea name="question_text" class="form-control" required></textarea></div>
          <div class="mb-2"><label>Option A</label><input name="option_a" class="form-control" required></div>
          <div class="mb-2"><label>Option B</label><input name="option_b" class="form-control" required></div>
          <div class="mb-2"><label>Option C</label><input name="option_c" class="form-control" required></div>
          <div class="mb-2"><label>Option D</label><input name="option_d" class="form-control" required></div>
          <div class="mb-2"><label>Correct Option</label>
            <select name="correct_option" class="form-control" required>
              <option value="">Select</option>
              <option>A</option><option>B</option><option>C</option><option>D</option>
            </select>
          </div>
          <div class="mb-2"><label>Explanation</label><textarea name="explanation" class="form-control"></textarea></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="submitQuestion()">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Load script AFTER the modal/form -->
<script src="../../js/quiz.js">

</script>
