<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
    // Insert the new category into the database
    if (!empty($category_name)) {
        $sql = "INSERT INTO category (category_name, created_at, updated_at) VALUES ('$category_name', NOW(), NOW())";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Category added successfully!'); </script>";
            echo "<script>window.location.href='category.php';</script>";
            exit;
        } else {
            $_SESSION['message'] = "Error adding category. Please try again.";
        }
    } else {
        $_SESSION['message'] = "Category name cannot be empty.";
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
    <title>ShoeMart - Admin Panel</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
      body {
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

                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Display any session message -->
                                    <?php if (isset($_SESSION['message'])): ?>
                                        <div class="alert alert-info">
                                            <?php
                                            echo $_SESSION['message'];
                                            unset($_SESSION['message']);
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Add Category Form -->
                                    <form action="add_category.php" method="POST">
                                        <div class="form-group">
                                            <label for="category_name">Category Name</label>
                                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Category</button>
                                        <a href="category.php" class="btn btn-secondary">Back to Categories</a>
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
