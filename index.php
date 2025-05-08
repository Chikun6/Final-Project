<?php
    session_start();
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'student') {
        include 'student_navbar.php';
    } else {
        include 'navbar.php';
    }

    include "db_connect.php"; // your DB connection file


    $query = "SELECT * FROM courses LIMIT 6";
    $result = mysqli_query($conn, $query);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/index.css">
    
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to <span class="highlight">SmartLearning</span></h1>
        <h2>Empower your future with the courses designed to <span class="highlight">fit your choice.</span></h2>
        <p>We bring together world-class instructors, interactive content, and a supportive community to help you achieve your personal and professional goals.</p>
        
        <div class="search-wrapper text-center my-4">
            <input type="text" id="searchInput" class="form-control d-inline-block w-auto" placeholder="Search courses">
            <button class="btn btn-primary" onclick="searchCourses()">Search</button>

            <!-- Result info (initially hidden) -->
            <div id="searchInfo" class="mt-2 d-none">
                <span>Results for '<strong id="searchQueryText"></strong>'</span>
                <button class="btn btn-sm btn-outline-secondary ms-2" onclick="clearSearch()">×</button>
            </div>
        </div>
 
    </div>

    <!-- Course Cards Section -->
    <div class="container mt-5">
    <h2 class="mb-4 text-center">Featured Courses</h2>
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
                            <span class="price-tag">₹<?= $discounted ?></span>
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

    <!-- View All Button -->
    <div class="text-center mt-4">
        <a href="courses.php" class="btn btn-outline-primary">View All Courses</a>
    </div>
</div>

    

<div class="container mt-5">
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

<button class="chat-button" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">
    <i class="fas fa-comment-alt"></i>
</button>

  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="chat-container">
          <div class="chat-header">
            <span>S M A R T I E</span>
          </div>
          <div id="chat-box" class="chat-box">
          </div>
          <div class="input-container">
            <input type="text" id="userInput" placeholder="Type a message..." />
            <button onclick="sendMessage()">
              <span class="send-icon">➤</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php
require_once 'footer.php';
?>
    <!-- JavaScript for Search -->
    <script>
        function searchCourses() {
        const input = document.getElementById("searchInput");
        const query = input.value.trim().toLowerCase();
        const courses = document.querySelectorAll('.course-card');
        const info = document.getElementById("searchInfo");
        const queryText = document.getElementById("searchQueryText");

        if (!query) {
            alert("Please enter a course name.");
            return;
        }

        let found = false;
        courses.forEach(course => {
            const title = course.getAttribute('data-title');
            if (title.includes(query)) {
                course.style.display = 'block';
                found = true;
            } else {
                course.style.display = 'none';
            }
        });

        if (!found) {
            alert("No matching courses found.");
        }

        // Show search result info
        queryText.textContent = query;
        info.classList.remove("d-none");
    }

    function clearSearch() {
        const input = document.getElementById("searchInput");
        const courses = document.querySelectorAll('.course-card');
        const info = document.getElementById("searchInfo");

        input.value = '';
        info.classList.add("d-none");

        // Show all courses
        courses.forEach(course => {
            course.style.display = 'block';
        });
    }

    </script>


        
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>
