<?php
// Start the session
session_start();

// Include the database connection
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the cart item ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_item_id'])) {
    $cart_id = intval($_POST['transaction_item_id']); // Ensure it's an integer
    $user_id = $_SESSION['user_id'];

    // Prepare the query to delete the item
    $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the cart page with a success message
        echo "<script>alert('Item removed from cart successfully!'); window.location.href='cart.php';</script>";
    } else {
        // Display an error message
        echo "<script>alert('Failed to remove item from cart.'); window.location.href='cart.php';</script>";
    }

    $stmt->close();
} else {
    // Redirect back to cart if no item ID is provided
    header("Location: cart.php");
    exit;
}
?>
