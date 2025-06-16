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

// Fetch games from the database
$sql = "SELECT * FROM games";
$result = $conn->query($sql);

// Handle game deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM games WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_games.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Games</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1A1A1D;
            color: white;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid white;
        }
        th {
            background-color: red;
        }
        a {
            color:red;
            text-decoration: none;
        }
        .btn {
            padding: 5px 10px;
            background-color:red;
            border: none;
            color: white;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #C3073F;
        }
    </style>
</head>
<body>
    <h1>Manage Games</h1>
    <a href="add_game.php" class="btn">Add New Game</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Rent Price</th>
            <th>Purchase Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>₹<?php echo $row['rent_price']; ?></td>
                <td>₹<?php echo $row['purchase_price']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" width="50"></td>
                <td>
                    <a href="edit_game.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    <a href="manage_games.php?delete=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
