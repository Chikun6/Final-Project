// Function to create a new quiz
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

function submitQuestion() {
    const quizId = document.getElementById('quiz_id').value.trim();
    const questionText = document.getElementById('question_text').value.trim();
    const optionA = document.getElementById('option_a').value.trim();
    const optionB = document.getElementById('option_b').value.trim();
    const optionC = document.getElementById('option_c').value.trim();
    const optionD = document.getElementById('option_d').value.trim();
    const correctOption = document.getElementById('correct_option').value.trim();
    const explanation = document.getElementById('explanation').value.trim();

    // Basic validation
    if (!quizId || !questionText || !optionA || !optionB || !optionC || !optionD || !correctOption) {
        alert("Please fill all required fields.");
        return;
    }

    const formData = new FormData();
    formData.append('quiz_id', quizId);
    formData.append('question_text', questionText);
    formData.append('option_a', optionA);
    formData.append('option_b', optionB);
    formData.append('option_c', optionC);
    formData.append('option_d', optionD);
    formData.append('correct_option', correctOption);
    formData.append('explanation', explanation);

    fetch('includes/save-question.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json()) // Change this to parse as JSON
    .then(response => {
        if (response.success) {
            alert("Question saved successfully!");
            document.getElementById("questionForm").reset();  // Reset form
        } else {
            alert("Error: " + response.message);  // Show error message
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert("Something went wrong.");
    });
}


// Function to load quizzes for a specific course
function loadCourseQuizzes(courseId) {
    fetch('get-question.php?course_id=' + courseId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-list').innerHTML = data;
        });
}

// Function to load quiz questions for a specific quiz
function loadQuizQuestions(quizId) {
    fetch('includes/quiz-questions.php?quiz_id=' + quizId)
        .then(res => res.text())
        .then(data => {
            document.getElementById('quiz-management-area').innerHTML = data;
        });
}

// Function to edit a quiz (currently just alerts for now)
function editQuiz(quizId) {
    alert('Editing quiz: ' + quizId);
}

// Function to delete a quiz with confirmation
function deleteQuiz(quizId) {
    if (confirm('Are you sure you want to delete this quiz?')) {
        fetch('includes/delete-quiz.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'quiz_id=' + quizId
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim() === 'success') {
                window.location.reload(); // Reloads the entire dashboard
            } else {
                alert('Error deleting quiz');
            }
        });
    }
}


// Function to show the results of a quiz
function showResults(quizId) {
    $.ajax({
        url: 'includes/quiz_results.php',
        method: 'POST',
        data: { quiz_id: quizId },
        success: function(response) {
            $('#main-content').html(response); // Show leaderboard inside dashboard
        },
        error: function() {
            alert('Failed to load leaderboard.');
        }
    });
}

// Function to open the add question modal
function openAddQuestionModal(quizId) {
    document.getElementById('quiz_id').value = quizId;
    document.getElementById('question_id').value = ''; // Reset in case of edit
    document.getElementById('questionForm').reset();   // Clear form
    const modal = new bootstrap.Modal(document.getElementById('questionModal'));
    modal.show();
}

// Function to delete a question
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

// Function to edit a question
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

// Event delegation to handle dynamically created elements (like buttons)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('show-results-btn')) {
        const quizId = e.target.dataset.quizId;
        showResults(quizId);
    }

    if (e.target.classList.contains('delete-quiz-btn')) {
        const quizId = e.target.dataset.quizId;
        deleteQuiz(quizId);
    }

    if (e.target.classList.contains('edit-quiz-btn')) {
        const quizId = e.target.dataset.quizId;
        editQuiz(quizId);
    }

    if (e.target.classList.contains('load-questions-btn')) {
        const quizId = e.target.dataset.quizId;
        loadQuizQuestions(quizId);
    }
});
