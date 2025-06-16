<?php
session_start();
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "playstation_shop";
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding an accessory
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $purchase_price = $_POST['purchase_price'];
    $rent_price = $_POST['rent_price'];
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($image_tmp, $target_file)) {
            $image = $target_file;
        }
    }
    
    $sql = "INSERT INTO accessories (name, purchase_price, rent_price, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdds", $name, $purchase_price, $rent_price, $image);
    if ($stmt->execute()) {
        $message = "Accessory added successfully!";
    } else {
        $message = "Error adding accessory: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Accessory</title>
    <style>
        body { background-color: black; color: white; font-family: Arial, sans-serif; }
        .container { max-width: 500px; margin: auto; padding: 20px; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        button { background-color: #C3073F; color: white; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Accessory</h2>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Accessory Name" required>
            <input type="number" name="purchase_price" placeholder="Purchase Price" step="0.01" required>
            <input type="number" name="rent_price" placeholder="Rent Price per day" step="0.01" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Accessory</button>
        </form>
    </div>
</body>
</html>
