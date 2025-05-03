<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./jquery-3.7.1.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', san-serif;
        }

        body {
            background: #000428;
            background: -webkit-linear-gradient(to right,
                    #004e92,
                    #000428);
            background: linear-gradient(to right,
                    #004e92,
                    #000428);
        }

        .button {
            width: 15%;
            padding: 6px 10px;
            background-color: aqua;
            border-radius: 5px;
        }

        .register-form {
            border: 1px solid black;
            background-color: white;
            color: #000428;
            border-radius: 6px;
            background: rgba(245, 245, 245, 0.85);
            box-shadow: 0 26px 42px rgba(0, 0, 0, 0.7)
        }

        .input-group {
            width: 70%;
            margin: auto;
        }

        .form-head {
            /* color: white; */
            font-size: xx-large;
        }

        .input-button {
            color: white;
            background: #4070f4d9;
            border: none;
            padding: 5px 0px;
            border-radius: 5px;
            width: 50%;
            cursor: pointer;
        }

        .input-button:hover {
            background: #0e4bf1de;
        }

        a {
            text-decoration: none;
        }

        .form-container {
            margin-top: 20%;
        }
    </style>
</head>

<body>
    <div class="mx-auto my-5 form-container">
        <div class="row">
            <div class="col-md-6 mx-auto my-5 register-form" id="form">
                <form action="db_verify.php" method="post" class="mx-auto form">
                    <div class="input-group mb-4 mt-3 form-head">
                        <label class="mx-auto">Verify OTP</label>
                    </div>
                    <div class="input-group mb-4">
                    <input type="text" name="otp" id="otp" placeholder="Enter OTP" required>
                    </div>
                    
    
                    <div class="input-group text-start mb-1" id="error"></div>
                    <div class="input-group mb-2">
                        <input type="submit" name="submit" value="Sign In" class="mx-auto input-button">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#form').submit(function (e) {
                e.preventDefault();
                $('#error').text('').removeClass('text-danger');

                let otp = $('#otp').val();

                let error = false;
                let errMsg = '';
                if (error) {
                    $('#error').text(errMsg).addClass('text-danger');
                    return;
                }
                $.ajax({
                    url: 'db_verify.php',
                    method: 'POST',
                    data: { otp: otp },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 'error') {
                            $('#error').text('OTP does not match').addClass('text-danger');
                        } else {
                            alert('Verification Successful');
                            window.location.href = 'login.php';
                        }
                    }
                });
            })
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>




