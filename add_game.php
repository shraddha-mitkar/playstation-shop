<?php
session_start();
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "playstation_shop";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $rent_price = $_POST['rent_price'];
    $purchase_price = $_POST['purchase_price'];
    $image = $_POST['image']; // Image filename

    $sql = "INSERT INTO games (name, rent_price, purchase_price, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdds", $name, $rent_price, $purchase_price, $image);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Game added successfully!";
    } else {
        $_SESSION['message'] = "Error adding game.";
    }

    header("Location: manage_games.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Game</title>
</head>
<body>
    <h2>Add New Game</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Game Name:</label>
        <input type="text" name="name" required><br>
        
        <label>Rent Price:</label>
        <input type="number" name="rent_price" required><br>
        
        <label>Purchase Price:</label>
        <input type="number" name="purchase_price" required><br>

        <label>Image Filename:</label>
        <input type="text" name="image" required><br>

        <button type="submit">Add Game</button>
    </form>
</body>
</html>
