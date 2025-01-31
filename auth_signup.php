<?php
// Include the database connection
include 'connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Redirect to the signup page with an error message
        header('Location: signup.php?error=Email already exists');
        exit;
    }

    // Define the insert query
    $insert_query = "INSERT INTO users (first_name, last_name, contact, address, email, password, account_type) 
                     VALUES ('$first_name', '$last_name', '$contact_number', '$address', '$email', '$hashed_password', 2)";
    
    // Insert the new user into the database
    if ($conn->query($insert_query)) {
        // Show an alert before redirecting to login
        echo "
            <script>
                alert('Account created successfully. Please login to continue.');
                window.location.href = 'login.php';
            </script>
        ";
        exit;
    } else {
        // Redirect to signup page with an error message
        header('Location: signup.php?error=Failed to create account');
        exit;
    }
}

// Close the database connection
$conn->close();
?>
