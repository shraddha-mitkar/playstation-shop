<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM bookings WHERE id = $id");
    header("Location: manage_bookings.php");
    exit();
}

// Fetch bookings
$result = $conn->query("SELECT * FROM bookings");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1A1A1D;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid white;
        }
        th {
            background-color: red;
        }
        .edit-btn, .delete-btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }
        .edit-btn {
            background-color: #4E4E50;
        }
        .delete-btn {
            background-color: red;
        }
        .delete-btn:hover {
            background-color: #950740;
        }
    </style>
</head>
<body>
    <h1>Manage Bookings</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Console</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>Duration</th>
            <th>Players</th>
            <th>Payment</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['console']); ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['duration']; ?> hours</td>
                <td><?php echo $row['players']; ?></td>
                <td><?php echo ucfirst($row['payment_method']); ?></td>
                <td>₹<?php echo $row['total_price']; ?></td>
                <td>
                    <a href="edit_booking.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                    <a href="manage_bookings.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
