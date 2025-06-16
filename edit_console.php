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

// Fetch console data
if (isset($_GET['id'])) {
    $console_id = $_GET['id'];
    $sql = "SELECT * FROM consoles WHERE id = $console_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $console = $result->fetch_assoc();
    } else {
        die("Console not found.");
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $purchase_price = $_POST['purchase_price'];
    $rent_price = $_POST['rent_price'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "UPDATE consoles SET name='$name', purchase_price='$purchase_price', rent_price='$rent_price', image='$image' WHERE id=$console_id";
    } else {
        $sql = "UPDATE consoles SET name='$name', purchase_price='$purchase_price', rent_price='$rent_price' WHERE id=$console_id";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "Console updated successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Console</title>
</head>
<body>
    <h2>Edit Console</h2>
    
    <?php if ($message): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($console['name']); ?>" required><br>

        <label>Purchase Price:</label>
        <input type="number" name="purchase_price" value="<?= htmlspecialchars($console['purchase_price']); ?>" required><br>

        <label>Rent Price (per day):</label>
        <input type="number" name="rent_price" value="<?= htmlspecialchars($console['rent_price']); ?>" required><br>

        <label>Image (leave empty to keep existing):</label>
        <input type="file" name="image"><br>

        <button type="submit">Update Console</button>
    </form>
</body>
</html>
