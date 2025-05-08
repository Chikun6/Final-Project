<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === 'student') {
    include 'student_navbar.php';
} else {
    include 'navbar.php';
}
include 'db_connect.php'; // For DB connection

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM courses WHERE title LIKE '%$searchTerm%'";
} else {
    $query = "SELECT * FROM courses";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    
<div class="container mt-5">
    <!-- Top Row with Back Button and Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">All Courses</h2>
        <a href="index.php" class="btn btn-outline-secondary">← Back to Home</a>
    </div>

    <!-- Search Bar -->
    <form method="GET" class="input-group mb-4" style="max-width: 400px;">
        <input type="text" class="form-control" name="search" placeholder="Search courses..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <!-- Course List -->
    <div class="row">
        <?php while ($course = mysqli_fetch_assoc($result)) : ?>
        <div class="col-md-4 mb-4 course-card" data-title="<?= strtolower($course['title']) ?>">
            <div class="card h-100 shadow-sm">
                <img src="./educator/includes/<?= $course['thumbnail'] ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                    <p class="card-text text-muted small"><?= substr(htmlspecialchars($course['description']), 0, 150) ?>...</p>
                    
                    <div class="mt-2">
                        <strong>Price:</strong>
                        <?php if (!empty($course['discount']) && $course['discount'] > 0): 
                            $discounted = $course['price'] - ($course['price'] * $course['discount'] / 100);
                        ?>
                            <span class="price-tag ">₹<?= $discounted ?></span>
                            <span class="old-price text-muted text-decoration-line-through">₹<?= $course['price'] ?></span>
                        <?php else: ?>
                            <span class="price-tag">₹<?= $course['price'] ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="course-details.php?id=<?= $course['id'] ?>" class="btn btn-primary w-100 mt-2">View Course</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>


