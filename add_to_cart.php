<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID and user ID
$product_id = intval($_POST['product_id']);
$user_id = $_SESSION['user_id'] ?? 0; // Replace with a session-based user ID

// Check if the product is already in the cart
$sql = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update quantity if the product exists
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
} else {
    // Insert new cart entry
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
}

if ($conn->query($sql) === TRUE) {
    header("Location: cart.php"); // Redirect to cart page
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
