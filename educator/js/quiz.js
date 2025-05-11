


function createNewQuiz(courseId) {
    fetch('includes/create-quiz.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'course_id=' + courseId
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === 'success') {
            loadCourseQuizzes(courseId);
        } else {
            alert('Error creating quiz');
        }
    });
}

function loadCourseQuizzes(courseId) {
    fetch('get-question.php?course_id=' + courseId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-list').innerHTML = data;
        });
}

function loadQuizQuestions(quizId) {
    fetch('includes/quiz-questions.php?quiz_id=' + quizId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-management-area').innerHTML = data;
        });
}


function editQuiz(quizId) {
    alert('Editing quiz: ' + quizId);
}

function deleteQuiz(quizId) {
    if (confirm('Are you sure you want to delete this quiz?')) {
        fetch('delete-quiz.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'quiz_id=' + quizId
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim() === 'success') {
                const urlParams = new URLSearchParams(window.location.search);
                loadCourseQuizzes(urlParams.get('course_id'));
            } else {
                alert('Error deleting quiz');
            }
        });
    }
}

function loadQuizQuestions(quizId) {
    fetch('includes/quiz-questions.php?quiz_id=' + quizId)
      .then(res => res.text())
      .then(html => {
        document.getElementById('quiz-management-area').innerHTML = html;
      });
  }
  
  function openAddQuestionModal(quizId) {
    document.getElementById('quiz_id').value = quizId;
    document.getElementById('question_id').value = ''; // Reset in case of edit
    document.getElementById('questionForm').reset();   // Clear form
    const modal = new bootstrap.Modal(document.getElementById('questionModal'));
    modal.show();
  }
  


  function deleteQuestion(id, quizId) {
    if (confirm('Delete this question?')) {
      fetch('includes/delete-question.php?id=' + id)
        .then(res => res.text())
        .then(data => {
          if (data.trim() === 'success') {
            loadQuizQuestions(quizId);
          } else {
            alert('Failed to delete.');
          }
        });
    }
  }
  
  function editQuestion(id) {
    fetch('includes/get-question.php?id=' + id)
      .then(res => res.json())
      .then(data => {
        for (const key in data) {
          if (document.getElementsByName(key)[0]) {
            document.getElementsByName(key)[0].value = data[key];
          }
        }
        new bootstrap.Modal(document.getElementById('questionModal')).show();
      });
  }


  