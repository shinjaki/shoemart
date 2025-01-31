<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Sign Up - ShoeMart</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS for ShoeMart theme -->
  <style>
    /* Custom ShoeMart theme */
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    h1,
    h2 {
      font-family: 'Roboto', sans-serif;
      color: #1c1c1c;
    }

    .form-control {
      border-radius: 8px;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #3498db;
    }

    .form-outline {
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #3498db;
      border-radius: 8px;
      font-size: 1.2rem;
      padding: 10px 20px;
      border: none;
      width: 100%;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .form-check-label {
      color: #1c1c1c;
    }

    .form-check-input {
      border-radius: 50%;
    }

    .login-form-container {
      border-radius: 15px;
      box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.1);
      margin: 0 15px;
      background: white;
      padding: 30px;
      width: 100%;
      max-width: 500px;
    }

    .nike-logo {
      width: 150px;
      margin-bottom: 20px;
    }

    .forgot-password-link {
      color: #3498db;
    }

    .forgot-password-link:hover {
      text-decoration: underline;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>

<body>

  <!-- Sign Up Form -->
  <div class="container d-flex justify-content-center">
    <div class="login-form-container col-12">
      <div class="text-center">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg" alt="Nike Logo" class="nike-logo" />
      </div>
      <h1 class="text-center">Sign Up for ShoeMart</h1>
      <br>
      <div class="col text-center">
        Already have an account? <a href="login.php" class="forgot-password-link">Log In</a>
      </div>
      <br>
      <form action="auth_signup.php" method="POST" novalidate>
        <!-- First Name and Last Name in one row -->
        <div class="row">
          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" required />
          </div>

          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" required />
          </div>
        </div>

        <!-- Contact Number and Address in one row -->
        <div class="row">
          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="contact_number">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" class="form-control" required />
          </div>

          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" required />
          </div>
        </div>

        <!-- Email and Password in one row -->
        <div class="row">
          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" name="email" class="form-control" required />
          </div>

          <div class="col-12 col-md-6 form-outline">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
        </div>

        <!-- Server-side Error Handling -->
        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger text-center mt-3">
            <?= htmlspecialchars($_GET['error']) ?>
          </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success text-center mt-3">
            <?= htmlspecialchars($_GET['success']) ?>
          </div>
        <?php endif; ?>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Sign Up</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>