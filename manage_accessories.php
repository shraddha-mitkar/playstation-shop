<?php
// Start session
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

// Handle accessory deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM accessories WHERE id = $id");
    header("Location: manage_accessories.php");
    exit();
}

// Fetch accessories
$sql = "SELECT * FROM accessories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accessories</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: black; color: white; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid white; }
        a { color: red; text-decoration: none; }
        a:hover { color: #950740; }
        .btn { padding: 5px 10px; border: none; cursor: pointer; color: white; }
        .edit { background-color: red; }
        .delete { background-color: red; }
    </style>
</head>
<body>
    <h1>Manage Accessories</h1>
    <a href="add_accessory.php" class="btn edit">Add New Accessory</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Purchase Price</th>
            <th>Rent Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹<?= $row['purchase_price'] ?></td>
                <td>₹<?= $row['rent_price'] ?>/day</td>
                <td><img src="<?= htmlspecialchars($row['image']) ?>" width="50"></td>
                <td>
                    <a href="edit_accessory.php?id=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="manage_accessories.php?delete=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
