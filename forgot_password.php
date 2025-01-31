<?php
session_start();

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Display an alert
    echo "<script>alert('Your new password will be sent to your email.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Forgot Password - Shop</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>

    <!-- Header -->
    <header class="py-5" style="background: #361500;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Forgot Your Password?</h1>
                <p class="lead fw-normal text-white-50 mb-0">Enter your email address to reset your password</p>
            </div>
        </div>
    </header>

    <!-- Forgot Password Form Section -->
    <section class="py-5" style="background-color: #1C0A00;">
        <div class="container px-8 px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header text-center bg-dark text-white">
                            <h3>Reset Password</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="forgot_password.php">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" required />
                                    </div>
                                </div>

                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
