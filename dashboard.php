<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edemy Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .sidebar { height: 100vh; background-color: #f8f9fa; padding-top: 20px; }
        .sidebar a { display: block; padding: 10px 20px; color: #000; text-decoration: none; }
        .sidebar a:hover { background-color: #e9ecef; }
        .main-content { padding: 20px; }
        .stat-box { border: 1px solid #e9ecef; border-radius: 5px; padding: 20px; text-align: center; }
        .stat-box img { width: 50px; height: 50px; }
        .enrolments-table { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <h2>Edemy</h2>
                <a href="#">Dashboard</a>
                <a href="#">Add Course</a>
                <a href="#">My Courses</a>
                <a href="#">Student Enrolled</a>
            </div>
            <div class="col-md-10 main-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <img src="https://via.placeholder.com/50" alt="Enrolments">
                            <h3>2</h3>
                            <p>Total Enrolments</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <img src="https://via.placeholder.com/50" alt="Courses">
                            <h3>1</h3>
                            <p>Total Courses</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <img src="https://via.placeholder.com/50" alt="Earnings">
                            <h3>$101</h3>
                            <p>Total Earnings</p>
                        </div>
                    </div>
                </div>
                <div class="enrolments-table">
                    <h4>Latest Enrolments</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Course Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>GreatStack</td>
                                <td>Introduction to Cybersecurity</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Great Stack</td>
                                <td>Introduction to Cybersecurity</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #e3f2fd, #ffffff);
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 270px;
            height: 100vh;
            background: linear-gradient(to bottom, #98c8ffd0, #ffffff);
            padding: 20px;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            margin-bottom: 10px;
        }
        .sidebar a:hover {
            background: #007bff;
            color: white;
            border-radius: 5px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-primary fw-bold">SmartLearning</h2>
        <a href="#dashboard" onclick="showSection('dashboard')"><i class="fas fa-tachometer-alt nav-link active"></i> Dashboard</a>
        <a href="#add-course" onclick="showSection('add-course')"><i class="fas fa-plus-circle"></i> Add Course</a>
        <a href="#my-courses" onclick="showSection('my-courses')"><i class="fas fa-book"></i> My Courses</a>
        <a href="#students" onclick="showSection('students')"><i class="fas fa-users"></i> Student Enrolled</a>
    </div>
    <div class="content">
        <div id="dashboard">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Total Enrollments</h5>
                        <h2>2</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Total Courses</h5>
                        <h2>1</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Total Earnings</h5>
                        <h2>$2098</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="my-courses" style="display: none;">
            <h4>My Courses</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>All Courses</th>
                        <th>Earnings</th>
                        <th>Students</th>
                        <th>Published On</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Introduction to Cybersecurity</td>
                        <td>$1099</td>
                        <td>2</td>
                        <td>01/03/2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="add-course" style="display: none;">
            <h4>Add Course</h4>
            <form class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Course Title</label>
                    <input type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Course Description</label>
                    <textarea class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Course Price</label>
                    <input type="number" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Discount %</label>
                    <input type="number" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
        
        <div id="students" style="display: none;">
            <h4>Student Enrolled</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course Title</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Manash Mohanta</td>
                        <td>Introduction to Cybersecurity</td>
                        <td>20/03/2025</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sourav Sahoo</td>
                        <td>Introduction to Cybersecurity</td>
                        <td>20/03/2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function showSection(sectionId) {
            document.getElementById('dashboard').style.display = 'none';
            document.getElementById('my-courses').style.display = 'none';
            document.getElementById('add-course').style.display = 'none';
            document.getElementById('students').style.display = 'none';
            
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>

