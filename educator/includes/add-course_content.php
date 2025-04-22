<div class="form-container">
    <h4 class="mb-4 text-center">Add Course</h4>
    <form action="./includes/upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label>Course Title</label>
            <input type="text" name="courseTitle" class="form-control" required />
        </div>

        <div class="form-group mb-3">
            <label>Course Description</label>
            <textarea name="courseDescription" class="form-control" rows="3" required></textarea>
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
            <input type="file" name="courseThumbnail" class="form-control" required />
        </div>

        <div class="form-group mb-3">
            <label>Course Price</label>
            <input type="number" name="coursePrice" class="form-control" required />
        </div>

        <div class="form-group mb-3">
            <label>Discount (%)</label>
            <input type="number" name="courseDiscount" class="form-control" />
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
