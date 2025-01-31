<?php
// Start the session
session_start();

// Include the database connection
include('connection.php');

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch the cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "
    SELECT c.cart_id, c.quantity, c.product_id, c.size_id, p.product_name, p.price, p.image, s.size
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    JOIN sizes s ON c.size_id = s.size_id
    WHERE c.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

// Calculate the total price and prepare cart items
$total_price = 0;
$cart_items = [];
while ($row = $cart_result->fetch_assoc()) {
    $row['total_price'] = $row['price'] * $row['quantity'];
    $total_price += $row['total_price'];
    $cart_items[] = $row;
}

// Fetch payment methods for the dropdown
$query_payment_methods = "SELECT payment_id, method_name FROM payment_method";
$result_payment_methods = $conn->query($query_payment_methods);
if (!$result_payment_methods) {
    die("Query failed: " . $conn->error);
}

// Handle the form submission when placing an order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_id = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 1;
    $transaction_date = date('Y-m-d H:i:s');
    $status = 'Pending';

    // Insert into the transactions table
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, total_amount, payment_id, status, transaction_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $total_price, $payment_id, $status, $transaction_date);
    $stmt->execute();
    $transaction_id = $stmt->insert_id;

    // Insert each item into the transaction_items table (with size_id)
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO transaction_items (transaction_id, product_id, size_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiii", $transaction_id, $item['product_id'], $item['size_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Clear the cart after the order is placed
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect to a confirmation page
    echo "<script>alert('Purchase Successfully! Thank you.'); window.location.href='index.php'</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/design.css">
    <style>
        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }
        .cart-header {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .cart-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .order-summary {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }
        .order-summary h5 {
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .btn-custom {
            background-color: #28a745;
            color: #fff;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <header class="py-5 bg-dark text-white text-center">
        <h1 class="display-4 fw-bold">Shopping Cart</h1>
        <p class="lead">Review your selected items and proceed to checkout.</p>
    </header>

    <section class="py-5">
        <div class="container cart-container">
            <!-- Cart Items -->
            <div>
                <h2 class="cart-header">Your Cart</h2>
                <?php if (count($cart_items) > 0): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image">
                            <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                <small>Size: <?php echo htmlspecialchars($item['size']); ?> | Price: ₱<?php echo number_format($item['price'], 2); ?></small>
                                <p class="mb-0">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            </div>
                            <div class="ms-auto d-flex align-items-center">
    <p class="mb-0 fw-bold me-3">₱<?php echo number_format($item['total_price'], 2); ?></p>
    <form action="remove_from_cart.php" method="POST" class="d-inline">
        <input type="hidden" name="transaction_item_id" value="<?php echo $item['cart_id']; ?>">
        <button type="submit" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Your cart is empty. Add items to your cart to proceed to checkout.</p>
                <?php endif; ?>
            </div>

            <!-- Order Summary -->
            <div class="order-summary shadow-sm">
                <h5>Order Summary</h5>
                <p>Total Amount: <span class="float-end">₱<?php echo number_format($total_price, 2); ?></span></p>
                <form method="POST">
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select id="paymentMethod" name="paymentMethod" class="form-select">
                            <?php while ($payment_method = $result_payment_methods->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($payment_method['payment_id']); ?>">
                                    <?php echo htmlspecialchars($payment_method['method_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Place Order</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white text-center">
        <p class="mb-0">&copy; 2025 ShoeMart. All Rights Reserved.</p>
    </footer>

    <script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
