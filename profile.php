<?php
session_start();
include('connection.php');

// Check if user is logged in and if the correct account type is present
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Handle the form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch the form data
    $first_name = $conn->real_escape_string($_POST['firstName']);
    $last_name = $conn->real_escape_string($_POST['lastName']);
    $contact_number = $conn->real_escape_string($_POST['contactNumber']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Password is optional for updating

    // If the password is provided, hash it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_query = ", password = '$hashed_password'";
    } else {
        $password_query = '';
    }

    // Prepare and execute the update query
    $update_query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', contact = '$contact_number', address = '$address', email = '$email' $password_query WHERE user_id = '$user_id'";

    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Information updated successfully!');</script>";
    } else {
        $alert_message = "Error updating information. Please try again.";
    }
}

// Query to fetch user data from the database based on the user_id
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($query);

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header('Location: login.php');
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<s>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Profile - ShoeMart</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/design.css">
  <style>
    body{
      background: white;
    }
  </style>
</s>

<body>

  <?php include('navbar.php'); ?>

  <!-- Header-->
  <header class="py-5" style="background: #F4F4F4;">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-dark">
        <h1 class="display-4 fw-bolder">Your Profile</h1>
        <p class="lead fw-normal text-dark-50 mb-0">Update your information below</p>
      </div>
    </div>
  </header>

  <!-- Profile Form Section -->
  <section class="py-5" style="background: #F4F4F4;">
    <div class="container px-8 px-lg-5">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card shadow-lg rounded-lg">
            <div class="card-header text-center text-dark" style="background: #F4F4F4;">
              <h3 class="text-dark">Update Your Information</h3>
            </div>
            <div class="card-body text-dark" style="background: #F4F4F4;">
              <form method="POST" action="profile.php">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="firstName" class="form-label text-dark">First Name</label>
                    <input type="text" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['first_name']); ?>" />
                  </div>
                  <div class="col-md-6">
                    <label for="lastName" class="form-label text-dark">Last Name</label>
                    <input type="text" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['last_name']); ?>" />
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="contactNumber" class="form-label text-dark">Contact Number</label>
                    <input type="text" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="contactNumber" name="contactNumber" value="<?php echo htmlspecialchars($user['contact']); ?>" />
                  </div>
                  <div class="col-md-6">
                    <label for="address" class="form-label text-dark">Address</label>
                    <input type="text" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" />
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="email" class="form-label text-dark">Email Address</label>
                    <input type="email" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" />
                  </div>
                  <div class="col-md-6">
                    <label for="password" class="form-label text-dark">Password</label>
                    <input type="password" class="form-control" style="background: transparent; color: black; border: 1px solid black;" id="password" name="password"/>
                  </div>
                </div>

                <div class="text-center mt-5">
                  <button type="submit" class="btn btn-success">Update</button>
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
