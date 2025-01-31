<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Check if a product ID is passed in the URL
if (!isset($_GET['product_id'])) {
    echo "Product ID is missing!";
    exit;
}

$product_id = $_GET['product_id'];

// Retrieve the product details to populate the form
$sql = "SELECT * FROM products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form and sanitize
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Handle image upload (optional, only if the image is being changed)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $allowedExtensions)) {
            die("Invalid file type. Please upload an image file.");
        }

        $imageUrl = 'uploads/products/' . uniqid() . '.' . $imageExtension;
        if (!move_uploaded_file($imageTmp, $imageUrl)) {
            die("Failed to upload image.");
        }
    } else {
        // Keep the existing image if no new image is uploaded
        $imageUrl = $product['image'];
    }

    // Update product in the database
    $sql = "UPDATE products SET 
            category_id = '$category_id', 
            product_name = '$product_name', 
            description = '$description', 
            price = '$price', 
            stock = '$stock', 
            image = '$imageUrl', 
            updated_at = NOW() 
            WHERE product_id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product updated successfully!'); </script>";
        echo "<script>window.location.href='products.php';</script>";
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
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
    <title>Julie's Bakeshop - Admin Panel</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background: #3C2A21;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper" style="background: #3C2A21;">
        <?php include('sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column" style="background: #D6C0B3;">
            <div id="content">
                <?php include('navbar.php'); ?>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
                                </div>
                                <div class="card-body"> 
                                    <form action="edit_product.php?product_id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                                      <div class="d-flex justify-content-center mb-3">
                                        <img src="<?php echo $product['image']; ?>" alt="Current Image" width="150" height="150">
                                      </div>
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option value="" disabled>Select a category</option>
                                                <?php
                                                $sql = "SELECT * FROM category";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $selected = ($row['category_id'] == $product['category_id']) ? 'selected' : '';
                                                    echo "<option value='" . $row['category_id'] . "' $selected>" . $row['category_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" required><?php echo $product['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
