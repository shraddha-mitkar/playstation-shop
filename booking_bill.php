<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from URL
if (!isset($_GET['booking_id'])) {
    die("Booking ID missing.");
}

$booking_id = (int) $_GET['booking_id'];

// Fetch booking details
$query = "SELECT * FROM bookings WHERE id = $booking_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    die("Booking not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Session Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            padding: 20px;
            background-color: #000;
            color: white;
        }
        .bill-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: black;
            border: 2px solid red;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: red;
            font-family: 'Orbitron', sans-serif;
        }
        h1 {
            color: red;
        }
        .details {
            margin-top: 20px;
            text-align: left;
        }
        .details p {
            font-size: 18px;
            margin: 10px 0;
        }
        .total {
            font-size: 22px;
            font-weight: bold;
            color: red;
            margin-top: 20px;
        }
        button {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #950740;
        }
    </style>
</head>
<body>
    <div class="bill-container">
    <div class="logo">🎮 YUVA Enterprises</div>
        <h1>Gaming Session Bill</h1>
        <div class="details">
            <p><strong>Name:</strong> <?php echo $booking['user_name']; ?></p>
            <p><strong>Phone:</strong> <?php echo $booking['phone_number']; ?></p>
            <p><strong>Console:</strong> <?php echo strtoupper($booking['console']); ?></p>
            <p><strong>Date:</strong> <?php echo $booking['booking_date']; ?></p>
            <p><strong>Start Time:</strong> <?php echo $booking['start_time']; ?></p>
            <p><strong>Duration:</strong> <?php echo $booking['duration']; ?> hours</p>
            <p><strong>Players:</strong> <?php echo $booking['players']; ?></p>
            <p><strong>Payment Method:</strong> <?php echo strtoupper($booking['payment_method']); ?></p>
            <p class="total">Total Price: ₹<?php echo $booking['total_price']; ?></p>
        </div>
        <button onclick="window.print()">Print Bill</button>
    </div>
</body>
</html>
