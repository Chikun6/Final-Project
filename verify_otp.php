
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./jquery-3.7.1.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,800&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to right, #004e92, #000428);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 26px 42px rgba(0, 0, 0, 0.4);
        }

        .form-head {
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            color: #003e7e;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .input-button {
            background-color: #4070f4;
            color: white;
            font-weight: 500;
            padding: 10px;
            border: none;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }

        .input-button:hover {
            background-color: #0e4bf1;
        }

        #error {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="register-form">
        <form id="form" action="db_verify.php" method="post">
            <div class="mb-4 form-head">Verify OTP</div>
            <div class="mb-3">
                <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP" required>
            </div>
            <div id="error" class="text-danger mb-3 text-center"></div>
            <div class="d-grid">
                <button type="submit" name="submit" class="input-button">Verify & Sign In</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#form').submit(function (e) {
                e.preventDefault();
                $('#error').text('').removeClass('text-danger');

                let otp = $('#otp').val();

                $.ajax({
                    url: 'db_verify.php',
                    method: 'POST',
                    data: { otp: otp },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 'error') {
                            $('#error').text('OTP does not match. Please try again.').addClass('text-danger');
                        } else {
                            alert('Verification Successful');
                            window.location.href = 'login.php';
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

