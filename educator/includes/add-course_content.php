<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter</title>
</head>
<body>
<div class="form-container">
    <h4 class="mb-4 text-center">Add Course</h4>
    <form action="./includes/upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label>Course Title</label>
            <input type="text" name="courseTitle" id="courseTitle" class="form-control" />
            <div class="error-message text-danger small"></div>
        </div>

        <div class="form-group mb-3">
            <label>Course Description</label>
            <textarea name="courseDescription" id ="courseDescription" class="form-control" rows="3"></textarea>
            <div class="error-message text-danger small"></div>
        </div>

        <div class="form-group mb-3">
            <label>Topics (comma-separated)</label>
            <input type="text" name="courseTopics" class="form-control" placeholder="e.g., HTML, CSS, JavaScript" />
        </div>

        <div class="form-group mb-3">
            <label>Course Category</label>
            <select name="courseCategory" class="form-control">
                <option value="Web Development">Web Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Design">Design</option>
                <option value="Programming">Programming</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Course Level</label>
            <select name="courseLevel" class="form-control">
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Course Thumbnail</label>
            <input type="file" name="courseThumbnail" id ="courseThumbnail" class="form-control" />
            <div class="error-message text-danger small"></div>
        </div>

        <div class="form-group mb-3">
            <label>Course Price</label>
            <input type="number" name="coursePrice" id ="coursePrice" class="form-control" />
            <div class="error-message text-danger small"></div>
        </div>

        <div class="form-group mb-3">
            <label>Discount (%)</label>
            <input type="number" name="courseDiscount" id= "courseDiscount" class="form-control" />
            <div class="error-message text-danger small"></div>
        </div>

        <div class="form-group mb-3">
            <label>Tags (optional)</label>
            <input type="text" name="courseTags" class="form-control" placeholder="e.g., frontend, backend, fullstack" />
        </div>

        <!-- Instructor ID (auto-filled if user logged in) -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <input type="hidden" name="instructor_id" value="<?= $_SESSION['user_id'] ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-primary w-100">Add Course</button>
    </form>
</div>


<script>
document.querySelector("form").addEventListener("submit", function (e) {
  let valid = true;

  const title = document.getElementById("courseTitle");
  const description = document.getElementById("courseDescription");
  const price = document.getElementById("coursePrice");
  const thumbnail = document.getElementById("courseThumbnail");

  const showError = (input, message) => {
    const errorDiv = input.nextElementSibling;
    errorDiv.textContent = message;
    valid = false;
  };

  const clearError = (input) => {
    const errorDiv = input.nextElementSibling;
    errorDiv.textContent = "";
  };

  // Clear old messages
  [title, description, price, thumbnail].forEach(clearError);

  // Validate fields
  if (!title.value.trim()) showError(title, "Course title is required.");
  if (!description.value.trim()) showError(description, "Description is required.");
  if (!price.value.trim() || price.value < 0) showError(price, "Valid price is required.");
  if (!thumbnail.files.length) showError(thumbnail, "Thumbnail is required.");

  if (!valid) e.preventDefault();
});
</script>
</body>
</html>




