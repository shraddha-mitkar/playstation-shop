<?php
// Start session and check admin login
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
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

// Get accessory ID from URL
if (!isset($_GET['id'])) {
    die("Accessory ID not provided.");
}

$accessory_id = $_GET['id'];

// Fetch existing details
$sql = "SELECT * FROM accessories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $accessory_id);
$stmt->execute();
$result = $stmt->get_result();
$accessory = $result->fetch_assoc();
$stmt->close();

if (!$accessory) {
    die("Accessory not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $purchase_price = $_POST['purchase_price'];
    $rent_price = $_POST['rent_price'];
    $image = $accessory['image']; // Default to existing image

    // Check if a new image is uploaded
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $image = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
            // Success
        } else {
            echo "<p style='color:red;'>Error uploading image.</p>";
        }
    }

    // Update accessory in database
    $update_sql = "UPDATE accessories SET name=?, purchase_price=?, rent_price=?, image=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sddsi", $name, $purchase_price, $rent_price, $image, $accessory_id);
    
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Accessory updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error updating accessory.</p>";
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Accessory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            text-align: center;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: #1A1A1D;
            padding: 20px;
            border-radius: 10px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
        }
        input {
            background: #4E4E50;
            color: white;
        }
        button {
            background: #C3073F;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #950740;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Accessory</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($accessory['name']); ?>" required>

            <label>Purchase Price:</label>
            <input type="number" name="purchase_price" value="<?= htmlspecialchars($accessory['purchase_price']); ?>" required>

            <label>Rent Price:</label>
            <input type="number" name="rent_price" value="<?= htmlspecialchars($accessory['rent_price']); ?>" required>

            <label>Image:</label>
            <input type="file" name="image">
            <p>Current Image:</p>
            <img src="<?= htmlspecialchars($accessory['image']); ?>" width="100" alt="Accessory Image">

            <button type="submit">Update Accessory</button>
        </form>
    </div>
</body>
</html>
