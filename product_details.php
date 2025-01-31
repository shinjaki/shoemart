<?php
session_start();

include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

// If no product ID is passed, redirect to the homepage or display an error
if ($product_id === null) {
    header("Location: index.php");
    exit;
}

// Fetch sizes from the sizes table
$sizeQuery = "SELECT size_id, size FROM sizes";
$sizeStmt = $conn->prepare($sizeQuery);
$sizeStmt->execute();
$sizeResult = $sizeStmt->get_result();

// Fetch the product details from the database
$query = "SELECT p.product_name, p.description, p.price, p.image, c.category_name 
          FROM products p
          JOIN category c ON p.category_id = c.category_id
          WHERE p.product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id); // Bind the product_id parameter
$stmt->execute();
$result = $stmt->get_result();

// If product not found, redirect to homepage
if ($result->num_rows == 0) {
    header("Location: index.php");
    exit;
}

// Fetch the product data
$product = $result->fetch_assoc();

// Handle the "Add to Cart" action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity']) && isset($_POST['size_id'])) {
    $quantity = (int)$_POST['quantity'];
    $size_id = (int)$_POST['size_id']; // Get the selected size_id

    // Insert into the cart table, including the size_id
    $insertQuery = "INSERT INTO cart (user_id, product_id, size_id, quantity, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, NOW(), NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iiii", $user_id, $product_id, $size_id, $quantity);
    
    if ($insertStmt->execute()) {
        // Redirect to the cart page or show a success message
        header("Location: cart.php");
        exit;
    } else {
        // Handle insert error
        echo "Error adding to cart. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Product Details - <?php echo htmlspecialchars($product['product_name']); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/design.css">
    <style>
        body {
            background: #F4F4F4;
            color: black;
        }

        .product-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 3px 4px 5px 5px rgba(0, 0, 0, 0.5);
        }

        .btn-custom {
            background-color: #007BFF;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #2B2525;
        }

        h1, .small {
            color: #3B3030;
        }

        .form-control {
            border-color: #3B3030;
        }
    </style>
</head>

<body>

<?php include('navbar.php'); ?>

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5 product-container">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <!-- Product Image -->
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0" src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="height: 400px; object-fit: cover;" />
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="small mb-1">Category: <?php echo htmlspecialchars($product['category_name']); ?></div>
                <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <div class="fs-5 mb-5">
                    <p class="lead"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>           

                <form action="product_details.php?id=<?php echo $product_id; ?>" method="POST">
                    <div class="d-flex flex-column">
                        <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="number" value="1" style="max-width: 3rem" />
                        <br>
<div class="mb-3">
    <label class="form-label"><strong>Available Sizes:</strong></label>
    <div class="row">
        <?php
        $sizeResult->data_seek(0); // Reset the result pointer
        $count = 0;
        while ($row = $sizeResult->fetch_assoc()):
            $count++;
        ?>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="size_id" id="size<?php echo $row['size_id']; ?>" value="<?php echo $row['size_id']; ?>" required>
                    <label class="form-check-label" for="size<?php echo $row['size_id']; ?>">
                        <?php echo htmlspecialchars($row['size']); ?>
                    </label>
                </div>
            </div>
            <?php if ($count % 5 == 0): ?>
                </div><div class="row">
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
</div>

                        <span>$<?php echo number_format($product['price'], 2); ?></span>  
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-custom text-white flex-shrink-0 col-md-6" type="submit">
                                <i class="bi bi-cart-fill me-1"></i> Add to cart
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
