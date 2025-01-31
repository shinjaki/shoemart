<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Handle the form submission when adding a new order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
    $payment_id = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 1;
    $total_amount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : 0;
    $transaction_date = date('Y-m-d H:i:s');
    $status = 'Pending';

    // Insert into the transactions table
    $stmt = $conn->prepare("INSERT INTO transactions (user_id, total_amount, payment_id, status, transaction_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $total_amount, $payment_id, $status, $transaction_date);
    $stmt->execute();
    $transaction_id = $stmt->insert_id;

    // Insert each item into the transaction_items table
    if (isset($_POST['items'])) {
        foreach ($_POST['items'] as $item) {
            $product_id = $item['product_id'];
            $size_id = $item['size_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $stmt = $conn->prepare("INSERT INTO transaction_items (transaction_id, product_id, size_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiii", $transaction_id, $product_id, $size_id, $quantity, $price);
            $stmt->execute();
        }
    }

    // Redirect to the pending orders page after successful insertion
    echo "<script>alert('Added New Order'); window.location.href='pending_orders.php';</script>";
    exit;
}

$query_users = "SELECT user_id, first_name, last_name FROM users";
$result_users = $conn->query($query_users);

// Fetch payment methods for the dropdown
$query_payment_methods = "SELECT payment_id, method_name FROM payment_method";
$result_payment_methods = $conn->query($query_payment_methods);

// Fetch available products for the items section
$query_products = "SELECT p.product_id, p.product_name, p.price, s.size_id, s.size 
                   FROM products p 
                   JOIN sizes s ON p.product_id = s.size_id";

$result_products = $conn->query($query_products);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/b931534883.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('navbar.php'); ?>

    <header class="py-5 bg-dark text-white text-center">
        <h1 class="display-4 fw-bold">Add New Order</h1>
        <p class="lead">Add a new order for the customer.</p>
    </header>

    <section class="py-5">
        <div class="container">
            <form method="POST" action="add_order.php">
                <!-- User ID -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">User ID</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        <?php while ($user = $result_users->fetch_assoc()): ?>
                            <option value="<?php echo $user['user_id']; ?>">
                                <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="paymentMethod" class="form-label">Payment Method</label>
                    <select id="paymentMethod" name="paymentMethod" class="form-select" required>
                        <?php while ($payment_method = $result_payment_methods->fetch_assoc()): ?>
                            <option value="<?php echo $payment_method['payment_id']; ?>">
                                <?php echo $payment_method['method_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Items Section -->
                <h4 class="mb-3">Order Items</h4>
                <div id="order-items">
                    <div class="item mb-3">
                        <div class="row">
                            <div class="col-6">
                                <select name="items[0][product_id]" class="form-select product-select" required>
                                    <?php while ($product = $result_products->fetch_assoc()): ?>
                                        <option value="<?php echo $product['product_id']; ?>" data-price="<?php echo $product['price']; ?>">
                                            <?php echo $product['product_name']; ?> - ₱<?php echo number_format($product['price'], 2); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <select name="items[0][size_id]" class="form-select" required>
                                    <?php foreach ($result_products as $product): ?>
                                        <option value="<?php echo $product['size_id']; ?>">
                                            <?php echo $product['size']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required>
                            </div>
                            <div class="col-1">
                                <input type="hidden" name="items[0][price]" class="price" value="0"> <!-- Default price, update on change -->
                                <button type="button" class="btn btn-danger remove-item">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Amount (calculated after adding items) -->
                <div class="mb-3">
                    <label for="totalAmount" class="form-label">Total Amount</label>
                    <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly required>
                </div>

                <button type="submit" class="btn btn-primary">Add Order</button>
            </form>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white text-center">
        <p class="mb-0">&copy; 2025 Your Company. All Rights Reserved.</p>
    </footer>

    <script>
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.item').remove();
                calculateTotalAmount();
            });
        });

        function calculateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.item').forEach(item => {
                const quantity = item.querySelector('input[name$="[quantity]"]').value;
                const price = item.querySelector('input[name$="[price]"]').value;
                totalAmount += quantity * price;
            });
            document.getElementById('totalAmount').value = totalAmount.toFixed(2);
        }

        document.querySelector('form').addEventListener('submit', () => {
            // Set the prices in the hidden input field before submitting
            document.querySelectorAll('.item').forEach((item, index) => {
                const price = item.querySelector('select[name$="[product_id]"]').selectedOptions[0].dataset.price;
                item.querySelector('input[name$="[price]"]').value = price;
            });
        });

        document.querySelectorAll('.product-select').forEach(select => {
            select.addEventListener('change', () => {
                const price = select.selectedOptions[0].dataset.price;
                const quantity = select.closest('.item').querySelector('.quantity').value;
                select.closest('.item').querySelector('.price').value = price;
                calculateTotalAmount();
            });
        });

        document.querySelectorAll('.quantity').forEach(input => {
            input.addEventListener('input', () => {
                const price = input.closest('.item').querySelector('.product-select').selectedOptions[0].dataset.price;
                const quantity = input.value;
                input.closest('.item').querySelector('.price').value = price;
                calculateTotalAmount();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>