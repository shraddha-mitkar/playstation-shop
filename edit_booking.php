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

// Fetch booking details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM bookings WHERE id = $id");
    if ($result->num_rows == 1) {
        $booking = $result->fetch_assoc();
    } else {
        die("Booking not found.");
    }
} else {
    die("Invalid request.");
}

// Update booking details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $console = $_POST['console'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $duration = intval($_POST['duration']);
    $players = intval($_POST['players']);
    $payment_method = $_POST['payment_method'];
    $total_price = floatval($_POST['total_price']);

    $update_query = "UPDATE bookings SET user_name='$user_name', console='$console', booking_date='$booking_date', start_time='$start_time', duration=$duration, players=$players, payment_method='$payment_method', total_price=$total_price WHERE id=$id";
    
    if ($conn->query($update_query)) {
        header("Location: manage_bookings.php");
        exit();
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
        form {
            max-width: 500px;
            margin: auto;
            background-color: #1A1A1D;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            background-color: #4E4E50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #950740;
        }
    </style>
</head>
<body>
    <h1>Edit Booking</h1>
    <form method="POST">
        <label>User Name:</label>
        <input type="text" name="user_name" value="<?php echo htmlspecialchars($booking['user_name']); ?>" required>
        
        <label>Console:</label>
        <input type="text" name="console" value="<?php echo htmlspecialchars($booking['console']); ?>" required>
        
        <label>Booking Date:</label>
        <input type="date" name="booking_date" value="<?php echo $booking['booking_date']; ?>" required>
        
        <label>Start Time:</label>
        <input type="time" name="start_time" value="<?php echo $booking['start_time']; ?>" required>
        
        <label>Duration (hours):</label>
        <input type="number" name="duration" value="<?php echo $booking['duration']; ?>" required>
        
        <label>Players:</label>
        <input type="number" name="players" value="<?php echo $booking['players']; ?>" required>
        
        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="cash" <?php if ($booking['payment_method'] == 'cash') echo 'selected'; ?>>Cash</option>
            <option value="card" <?php if ($booking['payment_method'] == 'card') echo 'selected'; ?>>Card</option>
        </select>
        
        <label>Total Price (₹):</label>
        <input type="number" step="0.01" name="total_price" value="<?php echo $booking['total_price']; ?>" required>
        
        <button type="submit">Update Booking</button>
    </form>
</body>
</html>
