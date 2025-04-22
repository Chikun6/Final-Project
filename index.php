<?php
    session_start();
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'student') {
        include 'student_navbar.php';
    } else {
        include 'navbar.php';
    }

    include "db_connect.php"; // your DB connection file

    $query = "SELECT * FROM courses ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <style>
        body {
            background: linear-gradient(to bottom, #e3f2fd, #ffffff);
            font-family: Arial, sans-serif;
        }
        .logo {
            height: 50px;
        }
        .navbar {
            background-color: #cee9fc;
        }
        .hero-section {
            text-align: center;
            padding: 50px 20px;
        }
        .hero-section h1,h2{
            font-weight: bold;
        }
        .hero-section .highlight {
            color: blue;
            text-decoration: underline;
        }
        .search-box {
            max-width: 500px;
            margin: 20px auto;
        }
        .trusted-logos {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }
        .trusted-logos img {
            width: 100px;
        }
        a{
            text-decoration: none;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(47, 112, 252, 0.2);
        }

        .feedback-section {
            text-align: center;
            margin-bottom: 40px;
            color: #ffffff;
        }
        .feedback-card {
            background-color: rgba(255, 255, 255, 0.34); opacity: 0.7;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
        }
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .profile-pic {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 10px;
        }
        .student-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .student-role {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 15px;
        }
        .feedback-text {
            font-size: 16px;
            color: #343a40;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .quote-mark {
            position: absolute;
            top: -15px;
            left: 20px;
            font-size: 40px;
            color: #007bff;
            font-family: serif;
            opacity: 0.2;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to <span class="highlight">SmartLearning</span></h1>
        <h2>Empower your future with the courses designed to <span class="highlight">fit your choice.</span></h2>
        <p>We bring together world-class instructors, interactive content, and a supportive community to help you achieve your personal and professional goals.</p>
        
        <div class="search-box d-flex flex-row">
            <input type="text" class="form-control" id="searchInput" placeholder="Search for courses">
            <button class="btn btn-primary" onclick="#">Search</button>
        </div>
    </div>

    <!-- Course Cards Section -->
    <div class="container mt-5">
        <h2 class="mb-4">Available Courses</h2>
        <div class="row">
            <?php while ($course = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                <img src="./educator/<?= $course['thumbnail'] ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                    <p class="card-text text-muted small"><?= substr(htmlspecialchars($course['description']), 0, 100) ?>...</p>
                    <p class="mt-auto"><strong>Price:</strong> ₹<?= $course['price'] ?></p>
                    <a href="course-details.php?id=<?= $course['id'] ?>" class="btn btn-primary w-100 mt-2">View Course</a>
                </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <div class="d-flex align-item-center mb-5 d-none" id="closebutton"><button onclick="closecourses()" class="btn btn-primary ">Show Less</button></div>
    </div>

    

<div class="container mb-5">
    <h2 class="feedback-section text-dark">Student's Feedback</h2>

    <!-- Bootstrap Carousel -->
    <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row">
                    <!-- Feedback Card 1 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://i0.wp.com/studiolorier.com/wp-content/uploads/2018/10/Profile-Round-Sander-Lorier.jpg?ssl=1" alt="Dinesh Nayak" class="profile-pic" />
                            <div class="student-name">Dinesh Nayak</div>
                            <div class="student-role">Web Designer</div>
                            <p class="feedback-text">
                                My life at SmartLearning made me stronger and took me a step ahead for being independent. 
                                I'm very thankful for the opportunities!
                            </p>
                        </div>
                    </div>

                    <!-- Feedback Card 2 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://www.ashoka.edu.in/wp-content/uploads/2022/08/Profile-67.png" alt="Diptimayee" class="profile-pic" />
                            <div class="student-name">Diptimayee</div>
                            <div class="student-role">Web Developer</div>
                            <p class="feedback-text">
                                I'm grateful to SmartLearning for the faculty and placement support. 
                                I was able to secure a job in the second company!
                            </p>
                        </div>
                    </div>

                    <!-- Feedback Card 3 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://img.freepik.com/free-photo/closeup-young-hispanic-man-casuals-studio_662251-600.jpg" alt="Mr. Ankit Sahoo" class="profile-pic" />
                            <div class="student-name">Mr. Ankit Sahoo</div>
                            <div class="student-role">Web Developer</div>
                            <p class="feedback-text">
                                SmartLearning is a place of learning, fun, culture, and creativity. 
                                It added significant value to my life.took me a step ahead for being independent
                                
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row">
                    <!-- Feedback Card 4 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://img.freepik.com/free-photo/smiley-man-posing-medium-shot_23-2149915893.jpg" alt="Sanjay Mohanta" class="profile-pic" />
                            <div class="student-name">Sanjay Mohanta</div>
                            <div class="student-role">Software Engineer</div>
                            <p class="feedback-text">
                                The training and support from SmartLearning helped me secure my dream job and growth in carrier. 
                                Thank you SmartLearning!
                            </p>
                        </div>
                    </div>

                    <!-- Feedback Card 5 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://img.freepik.com/free-photo/smiley-man-posing-medium-shot_23-2149915893.jpg" alt="New Student" class="profile-pic" />
                            <div class="student-name">New Student</div>
                            <div class="student-role">Software Engineer</div>
                            <p class="feedback-text">
                                I gained a lot of practical experience from SmartLearning. 
                                It really shaped my career.Thank you SmartLearning!
                                
                            </p>
                        </div>
                    </div>

                    <!-- Feedback Card 6 -->
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <span class="quote-mark">“</span>
                            <img src="https://img.freepik.com/free-photo/portrait-smiling-young-man_23-2148261341.jpg" alt="Another Student" class="profile-pic" />
                            <div class="student-name">Another Student</div>
                            <div class="student-role">Data Scientist</div>
                            <p class="feedback-text">
                                The hands-on training was exceptional. 
                                I highly recommend SmartLearning to everyone.
                                Thank you SmartLearning!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


<?php
require_once 'footer.php';
?>
    <!-- JavaScript for Search -->
    <script>
        // function searchCourses() {
        //     let query = document.getElementById("searchInput").value;
        //     if (query) {
        //         alert("Searching for: " + query);
        //     } else {
        //         alert("Please enter a course name.");
        //     }
        // }
        function viewcourses() {
            document.getElementById("viewcourses").classList.remove("d-none");
            document.getElementById("viewbutton").classList.add("d-none");
            document.getElementById("closebutton").classList.remove("d-none");
        }
        function closecourses() {
            document.getElementById("viewcourses").classList.add("d-none");
            document.getElementById("viewbutton").classList.remove("d-none");
            document.getElementById("closebutton").classList.add("d-none");
        }
      
            const card = document.getElementById('card1');
            card.addEventListener('click', () => {
                window.location.href = "cources.php";
            });
    
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
