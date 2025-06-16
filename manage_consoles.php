<?php
// Start session and check admin authentication
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Database Connection
$host = "localhost"; // Change if needed
$user = "root"; // Your database username
$password = ""; // Your database password
$database = "playstation_shop"; // Your database name

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Handle console deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM consoles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Console deleted successfully.";
    } else {
        $message = "Error deleting console.";
    }
}

// Fetch all consoles from the database
$sql = "SELECT * FROM consoles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Consoles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1A1A1D;
            color: white;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: red;
        }
        .btn {
            padding: 8px 15px;
            background-color:red;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #950740;
        }
    </style>
</head>
<body>
    <h2>Manage Consoles</h2>
    <a href="add_console.php" class="btn">Add New Console</a>
    
    <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Purchase Price</th>
            <th>Rent Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><img src="images/<?= htmlspecialchars($row['image']); ?>" width="80"></td>
                <td>₹<?= htmlspecialchars($row['purchase_price']); ?></td>
                <td>₹<?= htmlspecialchars($row['rent_price']); ?>/day</td>
                <td>
                    <a href="edit_console.php?id=<?= $row['id']; ?>" class="btn">Edit</a>
                    <a href="manage_consoles.php?delete_id=<?= $row['id']; ?>" class="btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
