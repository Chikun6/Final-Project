<?php
    require_once "navbar.php";
    date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./jquery-3.7.1.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #004e92, #000428);
        }

        .register-form {
            border: 1px solid black;
            background-color: white;
            color: #000428;
            border-radius: 6px;
            background: rgba(245, 245, 245, 0.85);
            box-shadow: 0 26px 42px rgba(0, 0, 0, 0.7);
            padding: 20px;
        }

        .input-group {
            width: 72%;
            margin: auto;
        }

        .form-head {
            font-size: xx-large;
        }

        .input-button {
            color: white;
            background: #4070f4d9;
            border: none;
            padding: 8px 0;
            border-radius: 5px;
            width: 50%;
            cursor: pointer;
        }

        .input-button:hover {
            background: #0e4bf1de;
        }

        .form-container {
            margin-top: 10%;
        }
    </style>
</head>

<body>
    <div class="mx-auto my-5 form-container">
        <div class="row">
            <div class="col-md-6 mx-auto my-5 register-form">
                <!-- FORM ACTION ADDED -->
                <form id="form" action="db_register.php" method="post">
                    <div class="input-group mb-4 mt-3 form-head">
                        <label class="mx-auto">Registration</label>
                    </div>
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" placeholder="Username" id="name" name="name">
                    </div>
                    <div class="input-group mb-4">
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="confpassword">
                    </div>
                    <div class="input-group mb-4">
                        <label class="form-label">Sign Up As</label>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="student" value="student" required>
                                    <label class="form-check-label" for="student">Student</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="educator" value="educator" required>
                                <label class="form-check-label" for="educator">Educator</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-4">
                        <p>select pic <span>*</span></p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="input-group text-start mb-1">
                        <span id="error" class="text-danger"></span>
                    </div>
                    <div class="input-group mb-2">
                        <input type="submit" name="submit" value="Register" class="mx-auto input-button">
                    </div>
                    <div class="input-group mb-4">
                        <label class="mx-auto">Already have an account? <a href="login.php">Log In</a></label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
    $('#form').submit(function (e) {
        e.preventDefault();

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();
        let confpassword = $('#confpassword').val().trim();
        let role = $('input[name="role"]:checked').val();
        let image = $('input[name="image"]')[0].files[0];

        let error = false;
        let errMsg = '';

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Basic validation
        if (name.length < 3) {
            errMsg = 'Username must be at least 3 characters long.';
            error = true;
        } else if (!email.match(emailPattern)) {
            errMsg = 'Invalid email format.';
            error = true;
        }else if (password === "") {
            errMsg += "Password is required.\n";
            error = true;
        }
        else if (!password.match(/[a-z]/)) {
            errMsg += "At least one lowercase letter.\n";
            error = true;
        }
        else if (!password.match(/[A-Z]/)) {
            errMsg += "At least one uppercase letter.\n";
            error = true;
        }
        else if (!password.match(/[0-9]/)) {
            errMsg += "At least one digit.\n";
            error = true;
        }
        else if (!password.match(/[!@#$%^&*]/)) {
            errMsg += "At least one special character.\n";
            error = true;
        }
        else if (password.length < 6 || password.length > 15) {
            errMsg += "Password must be 6 to 15 characters long.\n";
            error = true;
        }
        else if (password !== confpassword) {
            errMsg = 'Passwords do not match.';
            error = true;
        }

    
        if (error) {
            $('#error').text(errMsg).addClass('text-danger');
            return;
        }

        // ✅ Using FormData to send files
        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('role', role);
        formData.append('image', image);

        $.ajax({
            url: 'db_register.php',
            method: 'POST',
            data: formData,
            contentType: false, // important
            processData: false, // important
            success: function (response) {
                if (response.trim() === "exists") {
                    $('#error').text('Email or Username already registered').addClass('text-danger');
                } else if (response.trim() === "success") {
                    alert('Registration successful!');
                    window.location.replace('verify_otp.php');
                } else {
                    $('#error').text('Something went wrong. Please try again.').addClass('text-danger');
                }
            }
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
