<?php
session_start();
include('connection.php');

// If the user is not logged in or is not an admin, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Get current page number, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;  // Calculate the offset

// Fetch transactions with 'Completed' status, join with necessary tables to fetch customer name and product details
$sql = "SELECT t.transaction_id, 
               CONCAT(u.first_name, ' ', u.last_name) AS customer_name, 
               GROUP_CONCAT(CONCAT(p.product_name, ' (Qty: ', ti.quantity, ')') SEPARATOR '<br>') AS product_details, 
               t.total_amount, t.status, t.transaction_date 
        FROM transactions t
        INNER JOIN users u ON t.user_id = u.user_id
        INNER JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
        INNER JOIN products p ON ti.product_id = p.product_id
        WHERE t.status = 'Completed'
        GROUP BY t.transaction_id
        LIMIT $limit OFFSET $offset";


$result = mysqli_query($conn, $sql);

// Get the total number of records for pagination
$sql_total = "SELECT COUNT(*) AS total FROM transactions t
              INNER JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
              WHERE t.status = 'Completed'";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total'];
$total_pages = ceil($total_records / $limit);
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
        .pagination {
            display: inline-block;
            text-align: center;
        }
        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
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
                    <!-- Add New Order Button -->
                    <div class="row mb-4">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <a href="add_order.php" class="btn btn-primary">Add New Order</a>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="row">
                        <div class="col-lg-12">
                          <div class="card shadow mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class='text-center'>Transaction ID</th>
                                            <th class='text-center'>Customer Name</th>
                                            <th class='text-center'>Product Details</th>
                                            <th class='text-center'>Amount</th>
                                            <th class='text-center'>Status</th>
                                            <th class='text-center'>Date Ordered</th>
                                            <th class='text-center'>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $row['transaction_id'] . "</td>";
                                            echo "<td class='text-center'>" . $row['customer_name'] . "</td>";
                                            echo "<td class='text-center'>" . $row['product_details'] . "</td>";
                                            echo "<td class='text-center'>" . $row['total_amount'] . "</td>";
                                            echo "<td class='text-center'>" . $row['status'] . "</td>";
                                            echo "<td class='text-center'>" . $row['transaction_date'] . "</td>";
                                            echo "<td class='text-center'>
                                                    <a href='edit_transaction.php?id=" . $row['transaction_id'] . "' class='btn btn-sm btn-primary'>
                                                        <i class='fas fa-edit'></i> Edit
                                                    </a>
                                                    <a href='remove_transaction.php?id=" . $row['transaction_id'] . "' class='btn btn-sm btn-danger'>
                                                        <i class='fas fa-trash'></i> Remove
                                                    </a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- Pagination -->
                                <div class="pagination">
                                    <?php
                                    // Display previous page link
                                    if ($page > 1) {
                                        echo "<a href='completed_orders.php?page=" . ($page - 1) . "'>&laquo; Previous</a>";
                                    }

                                    // Display page numbers
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? "active" : "";
                                        echo "<a href='completed_orders.php?page=$i' class='$active'>$i</a>";
                                    }

                                    // Display next page link
                                    if ($page < $total_pages) {
                                        echo "<a href='completed_orders.php?page=" . ($page + 1) . "'>Next &raquo;</a>";
                                    }
                                    ?>
                                </div>
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
