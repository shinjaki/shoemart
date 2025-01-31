<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Fetch users with account_type = 1 (admins)
$sql = "SELECT * FROM users WHERE account_type = 1";
$result = mysqli_query($conn, $sql);
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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

                    <!-- Add New Admin Button (Conditionally displayed for super admin) -->
                    <?php if ($_SESSION['account_type'] == 0): ?>
                    <div class="row mb-4">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <a href="add_admin.php" class="btn btn-primary">Add New Admin</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Admin Table -->
                    <div class="row">
                        <div class="col-lg-12">
                          <div class="card shadow mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['user_id'] . "</td>";
                                            echo "<td>" . $row['first_name'] . "</td>";
                                            echo "<td>" . $row['last_name'] . "</td>";
                                            echo "<td>" . $row['contact'] . "</td>";
                                            echo "<td>" . $row['address'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "<td>";
                                                    if ($_SESSION['account_type'] == 0) {
                                                        echo "<a href='edit_admin.php?id=" . $row['user_id'] . "' class='btn btn-sm btn-primary'>
                                                                <i class='fas fa-edit'></i> Edit
                                                              </a>
                                                              <a href='remove_admin.php?id=" . $row['user_id'] . "' class='btn btn-sm btn-danger'>
                                                                <i class='fas fa-trash'></i> Remove
                                                              </a>";
                                                    } else {
                                                        echo "<span>Only Super Admin can edit or delete.</span>";
                                                    }
                                                    echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
