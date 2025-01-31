<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Handle product removal
if (isset($_GET['remove_id'])) {
    $product_id = $_GET['remove_id'];
    $sql = "DELETE FROM products WHERE product_id = '$product_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product removed successfully!');</script>";
        echo "<script>window.location.href='products.php';</script>";
    } else {
        $_SESSION['message'] = "Error removing product. Please try again.";
    }
    header("Location: products.php");
    exit;
}

// Pagination settings
$limit = 3; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total products count
$total_sql = "SELECT COUNT(*) as total FROM products";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products with pagination
$sql = "SELECT p.product_id, p.product_name, p.description, p.price, p.stock, p.image, p.created_at, c.category_name 
        FROM products p
        JOIN category c ON p.category_id = c.category_id
        ORDER BY p.created_at DESC
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ShoeMart - Admin Panel</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('navbar.php'); ?>
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <a href="add_product.php" class="btn btn-primary">Add New Product</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Product Name</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Stock</th> 
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>";
                                                        echo "<td class='d-flex justify-content-center'><img src='../" . htmlspecialchars($row['image']) . "' alt='Product Image' class='img-thumbnail' style='width: 100px; height: 100px; object-fit: cover;'></td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['product_name']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['category_name']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['description']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['price']) . "</td>";
                                                        echo "<td class='text-center'>" . htmlspecialchars($row['stock']) . "</td>";                  
                                                        echo "<td class='text-center'><a href='edit_product.php?product_id=" . $row['product_id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a> &nbsp; ";
                                                        echo "<a href='?remove_id=" . $row['product_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\");'><i class='fas fa-trash'></i> Delete</a>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center'>No products found</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                $active = ($i == $page) ? 'active' : '';
                                                echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
                                            }
                                            ?>
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
