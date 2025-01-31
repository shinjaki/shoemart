<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Pagination logic
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch total count
$count_query = "
    SELECT COUNT(*) as total 
    FROM transaction_items ti
    INNER JOIN transactions t ON ti.transaction_id = t.transaction_id
    WHERE t.user_id = ?
";
$count_stmt = $conn->prepare($count_query);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result()->fetch_assoc();
$total_items = $count_result['total'];
$count_stmt->close();

// Fetch transactions with pagination
$query = "
    SELECT ti.transaction_item_id, ti.transaction_id, ti.product_id, ti.quantity, 
           (ti.quantity * ti.price) AS item_amount, 
           t.payment_id, t.status, t.transaction_date,
           p.product_name, p.image, s.size
    FROM transaction_items ti
    INNER JOIN transactions t ON ti.transaction_id = t.transaction_id
    INNER JOIN products p ON ti.product_id = p.product_id
    LEFT JOIN sizes s ON ti.size_id = s.size_id
    WHERE t.user_id = ?
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $user_id, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

$stmt->close();
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .table tbody tr td, .table thead th {
            vertical-align: middle;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .pagination {
            justify-content: center;
        }
        .header {
            background: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <header class="header">
        <h1 class="display-6">Order History</h1>
        <p class="lead">Track your past purchases.</p>
    </header>

    <section class="py-5">
        <div class="container">
            <?php if (!empty($transactions)) : ?>
                <table class="table table-hover shadow-sm rounded bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">Product Image</th>
                            <th scope="col" class="text-center">Product</th>
                            <th scope="col" class="text-center">Size</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-center">Amount</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Date Ordered</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction) : ?>
                            <tr>
                                <td class="text-center">
                                    <img src="<?= htmlspecialchars($transaction['image']) ?>" alt="Product Image" class="product-image">
                                </td>
                                <td class="text-center"><?= htmlspecialchars($transaction['product_name']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($transaction['size'] ?? 'N/A') ?></td>
                                <td class="text-center"><?= htmlspecialchars($transaction['quantity']) ?></td>
                                <td class="text-center">&#8369;<?= number_format($transaction['item_amount'], 2) ?></td>
                                <td class="text-center"><?= htmlspecialchars($transaction['status']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($transaction['transaction_date']) ?></td>
                                <td class="text-center">
                                    <form method="POST" action="remove_item.php">
                                        <input type="hidden" name="transaction_item_id" value="<?= htmlspecialchars($transaction['transaction_item_id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else : ?>
                <div class="alert alert-warning text-center">No order history found.</div>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
