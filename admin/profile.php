<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
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
        $alert_message = "Information updated successfully!";
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
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ShoeMart - Admin Panel</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
      body{
        background: #F4F4F4;
      }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" style="background: #F4F4F4;">

       <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background: #F4F4F4;">

            <!-- Main Content -->
            <div id="content">

               <?php include('navbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
            </div>
            <div class="card-body">
                <?php
                if (isset($alert_message)) {
                    echo "<div class='alert alert-info'>$alert_message</div>";
                }
                ?>
                <form method="POST" action="profile.php">
                    <div class="form-row">
                        <!-- First Name and Last Name in one row -->
                        <div class="form-group col-md-6">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $user['first_name']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $user['last_name']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Contact Number and Address in one row -->
                        <div class="form-group col-md-6">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?= $user['contact']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= $user['address']; ?>" >
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Email, Password, and Confirm Password in one row -->
                        <div class="form-group col-md-4">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn" style="background: #0056b3; color: white;">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
