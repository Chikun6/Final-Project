<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Test with Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo {
            height: 50px;
        }
        .navbar {
            background-color: #cee9fc;
        }
        .modal-content {
            width: 480px;
        }
        .modal-header, h4 {
            color: black;
            font-size: 20px;
            font-weight: bold;
        }
        .other p {
            margin: 20px 88px;
        }
        form .btn {
            width: 100%;
            background-color: black;
            color: white;
        }
        #google {
            width: 100%;
            color: black;
            font-weight: bold;
        }
        a {
            color: black;
            font-weight: bold;
        }
        .modal-footer {
            justify-content: center;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="./images/logoupdate.png" alt="Logo" class="img-fluid" style="height: 55px;">SmartLearning
            </a>
            <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#signInModal">Create Account</button>
        </div>
</nav>

<!-- ✅ Sign In Modal -->
<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-light">
                <h4 class="modal-title">Sign in to LMS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail2" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail2" name="email" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword2" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-dark" name="signin" value="signin">Continue</button>
                </form>
                <div>
                    <p class = "text-center" id = "error"></p>
                </div>
                <div class="other">
                    <p>----------------- or -----------------</p>
                    <button id="google" class="btn btn-light bg-light" name="signin" value="google">Continue with Google</button>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <p>Don't have an account? 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal" data-bs-dismiss="modal">Sign Up</a>
                </p>
            </div>

        </div>
    </div>
</div>

<!-- ✅ Sign Up Modal -->
<!-- <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create an Account</h4>
                <a href="home.php" class="btn-close" aria-label="Close"></a>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form action="signup-data.php" method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                        <label id = "name-error" class = "text-danger"></label>

                    </div>

                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="signupEmail" name="email" required>
                        <label id = "email-error" class = "text-danger"></label>
                    </div>

                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="password" required>
                        <label id = "password-error" class = "text-danger"></label>
                    </div>

                    <button type="submit" class="btn btn-dark" name="signup" value="signup">Sign Up</button>
                </form>

                <div class="other">
                    <p>----------------- or -----------------</p>
                    <button id="google" class="btn btn-light bg-light" name="google" value="google">Continue with Google</button>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <p>Already have an account? 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal" data-bs-dismiss="modal">Sign In</a>
                </p>
            </div>

        </div>
    </div>
</div> -->


<?php

if(isset($_POST['signin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    require_once "authentication.php";

    $res = login($email,$password);

    if($res){
        $_SESSION['name'] = $res['name'];
        $_SESSION['id'] = $res['id'];
        header("location:cloud.php");

    }
    else{
    ?>
        <script>
            let error = document.querySelector("#error")
            error.innerHTML = "Don't Have An Account Please Sign UP"
            error.style.color = 'red'
        </script>
        <?php
    }
}
?>

<!-- ✅ Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></>

</body>
</html>
