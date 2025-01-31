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

// Check if the transaction_item_id is set in the POST request
if (isset($_POST['transaction_item_id'])) {
    $transaction_item_id = $_POST['transaction_item_id'];

    // Prepare the DELETE query to remove the item from the transaction_items table
    $query = "DELETE FROM transaction_items WHERE transaction_item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transaction_item_id);
    
    // Execute the query
    if ($stmt->execute()) {
        // If the deletion is successful, redirect back to the order history page
        echo "<script>alert('Transaction removed successfully!');</script>";
        echo"<script>window.location.href='order_history.php';</script>";
        exit;
    } else {
        // If there's an error, redirect back with an error message
        header("Location: order_history.php?message=Error removing item");
        exit;
    }
}

?>
