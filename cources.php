<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Computing Essentials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
        }
        .container {
            max-width: 1200px;
        }
        .course-card, .price-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="./images/logoupdate.png" alt="Logo" class="img-fluid" style="height: 55px;">SmartLearning
            </a>
            <button class="btn btn-primary">Create Account</button>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="course-card">
                    <h2>Cloud Computing Essentials</h2>
                    <p><strong>Master Cloud Fundamentals</strong></p>
                    <p>Learn the foundations of cloud computing and explore popular cloud platforms like AWS, Azure, and Google Cloud.</p>
                    <p><strong>5</strong> ⭐⭐⭐⭐⭐ (1 rating) </p>
                    <p>Course by <a href="#" >SmartLearning</a></p>
                    <hr>
                    <h4>Course Structure</h4>
                    <div class="accordion" id="courseAccordion" class="mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Cloud Fundamentals - 2 lectures (22 hours)
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    Introduction to Cloud Computing, Benefits, and Case Studies.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mt-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Exploring Cloud Platforms - 2 lectures (27 hours, 30 minutes)
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                                <div class="accordion-body">
                                    AWS, Azure, Google Cloud: Features and Hands-on Experience.
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-3">Course Description</h4>
                    <div class="mt-3">
                        <h3 class="mb-3 text-decoration-underline">Master Cloud Computing</h3>
                        <p class="p-4">Cloud Fundamentals introduces you to the essential principles of cloud computing, focusing on how businesses and individuals leverage cloud technologies to improve efficiency and scalability. This course covers the basics of cloud services, including Infrastructure as a Service (IaaS), Platform as a Service (PaaS), and Software as a Service (SaaS). Additionally, you will explore the differences between public, private, hybrid, and multi-cloud deployment models, helping you understand which solutions best suit various needs. With hands-on insights into leading platforms like AWS, Azure, and Google Cloud, you will gain a solid foundation to navigate the rapidly evolving world of cloud computing.<br><br>

                            Beyond technical understanding, this course delves into critical aspects such as cloud security, compliance, and cost management. You’ll explore concepts like virtual machines, serverless computing, and containerization, ensuring a well-rounded perspective of modern cloud technologies. Designed for beginners, it’s an ideal starting point for aspiring IT professionals, business decision-makers, or anyone curious about the transformative power of the cloud. By the end, you'll not only grasp the fundamentals but also feel prepared to pursue advanced topics or certifications in the cloud domain.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="price-card">
                    <img src="./images/cloudcomputing.png" alt="Course Image"class="card-img-top ">
                    <h4 class="text-primary mt-3">$55.99 <del>$69.99</del> <span class="text-success">20% off</span></h4>
                    <p>⏳ 10 hours, 30 minutes | 📚 4 lessons</p>
                    <button class="btn btn-primary w-100">Enroll Now</button>
                    <hr>
                    <h5>What's in the course?</h5>
                    <ul>
                        <li>Lifetime access with free updates.</li>
                        <li>Step-by-step, hands-on project guidance.</li>
                        <li>Downloadable resources and source code.</li>
                        <li>Quizzes to test your knowledge.</li>
                        <li>Certificate of completion.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
