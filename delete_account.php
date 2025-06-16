<?php
// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Delete the user's account from the database
$delete_query = "DELETE FROM users WHERE id = $user_id";
if ($conn->query($delete_query)) {
    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to login page with a message
    header('Location: login.php?message=account_deleted');
    exit;
} else {
    echo "Error: Unable to delete your account. Please try again.";
}
?>
