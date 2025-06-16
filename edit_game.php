<?php
session_start();


if (!isset($_GET['id'])) {
    header("Location: manage_games.php");
    exit();
}
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "playstation_shop";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$id = $_GET['id'];

// Fetch existing game details
$sql = "SELECT * FROM games WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    $_SESSION['message'] = "Game not found!";
    header("Location: manage_games.php");
    exit();
}

// Update game details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $rent_price = $_POST['rent_price'];
    $purchase_price = $_POST['purchase_price'];
    $image = $_POST['image'];

    $update_sql = "UPDATE games SET name=?, rent_price=?, purchase_price=?, image=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sddsi", $name, $rent_price, $purchase_price, $image, $id);

    if ($update_stmt->execute()) {
        $_SESSION['message'] = "Game updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating game.";
    }

    header("Location: manage_games.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Game</title>
</head>
<body>
    <h2>Edit Game</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Game Name:</label>
        <input type="text" name="name" value="<?php echo $game['name']; ?>" required><br>

        <label>Rent Price:</label>
        <input type="number" name="rent_price" value="<?php echo $game['rent_price']; ?>" required><br>

        <label>Purchase Price:</label>
        <input type="number" name="purchase_price" value="<?php echo $game['purchase_price']; ?>" required><br>

        <label>Image Filename:</label>
        <input type="text" name="image" value="<?php echo $game['image']; ?>" required><br>

        <button type="submit">Update Game</button>
    </form>
</body>
</html>
