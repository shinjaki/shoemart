<?php
session_start();
include('connection.php');

// If the user is not logged in or is not an admin, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];

    // Fetch the transaction details with customer and product information
    $sql = "SELECT t.transaction_id, CONCAT(u.first_name, ' ', u.last_name) AS customer_name, 
                   p.product_name, ti.quantity, t.total_amount, t.status, t.transaction_date 
            FROM transactions t
            INNER JOIN users u ON t.user_id = u.user_id
            INNER JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
            INNER JOIN products p ON ti.product_id = p.product_id
            WHERE t.transaction_id = '$transaction_id'";
    $result = mysqli_query($conn, $sql);
    $transaction = mysqli_fetch_assoc($result);

    // If transaction not found, redirect back
    if (!$transaction) {
        header("Location: completed_orders.php");
        exit;
    }

    // Fetch payment methods for the dropdown
    $payment_method_sql = "SELECT * FROM payment_method";
    $payment_method_result = mysqli_query($conn, $payment_method_sql);
    $payment_methods = [];
    while ($row = mysqli_fetch_assoc($payment_method_result)) {
        $payment_methods[] = $row;
    }

    // Handle form submission to update the transaction
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];
        $total_amount = $_POST['total_amount'];
        $payment_id = $_POST['payment_id'];

        // Update the transaction details in the database
        $update_sql = "UPDATE transactions SET 
                        status = '$status', 
                        total_amount = '$total_amount', 
                        payment_id = '$payment_id' 
                        WHERE transaction_id = '$transaction_id'";

        if (mysqli_query($conn, $update_sql)) {
            // Redirect to the pending orders page after successful update
            echo "<script>alert('Transaction updated successfully!'); window.location.href='completed_orders.php';</script>";
            exit;
        } else {
            echo "Error updating transaction: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ShoeMart - Edit Transaction</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { background: #3C2A21; }
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

                    <!-- Edit Transaction Form -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <h4 class="mb-4">Edit Transaction Details</h4>

                                    <!-- Display the transaction details -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Product</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Date Ordered</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><?php echo $transaction['customer_name']; ?></td>
                                                <td class="text-center"><?php echo $transaction['product_name']; ?></td>
                                                <td class="text-center"><?php echo $transaction['quantity']; ?></td>
                                                <td class="text-center"><?php echo $transaction['total_amount']; ?></td>
                                                <td class="text-center"><?php echo $transaction['status']; ?></td>
                                                <td class="text-center"><?php echo $transaction['transaction_date']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Update Transaction Form -->
                                    <form method="POST" action="edit_transaction.php?id=<?php echo $transaction_id; ?>">

                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Pending" <?php echo ($transaction['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Completed" <?php echo ($transaction['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo ($transaction['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="payment_id">Payment Method</label>
                                            <select class="form-control" id="payment_id" name="payment_id" required>
                                                <?php
                                                foreach ($payment_methods as $payment_method) {
                                                    $selected = ($transaction['payment_id'] == $payment_method['payment_id']) ? 'selected' : '';
                                                    echo "<option value='{$payment_method['payment_id']}' {$selected}>{$payment_method['method_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Add the Total Amount field -->
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo $transaction['total_amount']; ?>" readonly>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                           <button type="submit" class="btn btn-primary">Update Transaction</button>
                                           &nbsp;
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