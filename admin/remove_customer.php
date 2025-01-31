<?php
session_start();
include('connection.php');

// Check if the user is logged in and has the correct account type
if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 1) {
    header("Location: login.php");
    exit;
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the SQL query to delete the customer
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the user_id parameter to the query
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the customer list page with a success message
        echo "<script>alert('Removed successfully!'); window.location.href='customer_account.php'</script>";
    } else {
        // In case of an error, set an error message
        $_SESSION['message'] = "Error removing customer. Please try again.";
        header("Location: customer_list.php");
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // If no user_id is provided, redirect back to the customer list page
    header("Location: customer_list.php");
}

mysqli_close($conn);
?>
