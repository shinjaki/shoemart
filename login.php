<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Login - ShoeMart</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS for a business theme -->
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #F4F4F4;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      color: black;
    }

    h1 {
      font-family: 'Roboto', sans-serif;
      color: #333;
      font-size: 2.5rem;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 8px;
      padding: 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      background-color: #fff;
      color: #333;
    }

    .form-outline {
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #007BFF;
      border-radius: 8px;
      font-size: 1.2rem;
      padding: 12px 20px;
      border: none;
      width: 100%;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .login-form-container {
      border-radius: 15px;
      box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
      margin: 0 15px;
      background: #fff;
      padding: 30px;
      width: 100%;
      max-width: 500px;
    }

    .form-label {
      color: #007BFF;
    }

    .forgot-password-link {
      color: #007BFF;
    }

    .forgot-password-link:hover {
      text-decoration: underline;
    }

    .nike-logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .nike-logo img {
      width: 120px;
    }
  </style>
</head>

<body>

  <!-- Login Form -->
  <div class="login-form-container">
    <div class="nike-logo">
      <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" alt="Nike Logo">
    </div>
    <h1 class="text-center">Welcome to ShoeMart</h1>
    <br>
    <div class="col text-center">
      Don't have an account? <a href="signup.php" class="forgot-password-link">Sign Up</a>
    </div>
    <br>
    <form action="auth_login.php" method="POST">
      <!-- Email input -->
      <div class="form-outline">
        <label class="form-label" for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>

      <!-- Password input -->
      <div class="form-outline">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required />
      </div>

      <!-- Forgot password link -->
      <div class="row mb-4">
        <div class="col d-flex justify-content-start">
          <div class="form-check">
            <a href="forgot_password.php" class="forgot-password-link">Forgot password?</a>
          </div>
        </div>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>