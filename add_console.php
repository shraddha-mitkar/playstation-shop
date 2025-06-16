<?php
// Start session
session_start();

// Ensure only the admin can access
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "playstation_shop";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $purchase_price = $_POST['purchase_price'];
    $rent_price = $_POST['rent_price'];
    $image = $_FILES['image']['name'];

    // Upload image
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert console into database
    $sql = "INSERT INTO consoles (name, purchase_price, rent_price, image) VALUES ('$name', '$purchase_price', '$rent_price', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Console added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Console</title>
</head>
<body>
    <h2>Add Console</h2>
    
    <?php if ($message): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Purchase Price:</label>
        <input type="number" name="purchase_price" required><br>

        <label>Rent Price (per day):</label>
        <input type="number" name="rent_price" required><br>

        <label>Image:</label>
        <input type="file" name="image" required><br>

        <button type="submit">Add Console</button>
    </form>
</body>
</html>
