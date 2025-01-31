<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Check if the admin ID is passed in the URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch the admin details from the database
    $sql = "SELECT * FROM users WHERE user_id = '$admin_id' AND account_type = 1";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    if (!$admin) {
        echo "<script>alert('Admin not found.'); window.location.href='admin_account.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No admin selected.'); window.location.href='admin_account.php';</script>";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // If password is provided, hash it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_sql = ", password = '$hashed_password'";
    } else {
        $password_sql = "";
    }

    // Update admin details
    $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', contact = '$contact', address = '$address', email = '$email' $password_sql WHERE user_id = '$admin_id' AND account_type = 1";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Admin details updated successfully'); window.location.href='admin_account.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ShoeMart - Edit Admin</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
      body{
        background: #3C2A21;
      }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" style="background: #3C2A21;">

       <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background: #D6C0B3;">

            <!-- Main Content -->
            <div id="content">

               <?php include('navbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                          <div class="card shadow mb-4">
                            <div class="card-body">
                                <h3 class="mb-4">Edit Admin</h3>
                                <form action="edit_admin.php?id=<?php echo $admin_id; ?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $admin['first_name']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $admin['last_name']; ?>" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact">Contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $admin['contact']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $admin['address']; ?>" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password (Leave blank to keep current password)</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                       <button type="submit" class="btn btn-success mt-5">Update Admin</button> 
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
