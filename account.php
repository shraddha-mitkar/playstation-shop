<?php
// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = "SELECT first_name, last_name, email, phone_number FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    die('User not found.');
}

// Fetch order history
$order_query = "SELECT product_name, price, quantity, total_price, payment_method, order_date FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$order_result = $conn->query($order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
        }
        .account-header {
            background: transparent;
            color: red;
            padding: 20px;
            text-align: center;
        }
        .account-container {
            max-width: 800px;
            margin: 30px auto;
            background: black;
            padding: 30px;
            padding-top:10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
        }
        .profile-section {
            padding: 20px;
            background-color: red;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .profile-section h2 {
            color: black;
        }
        .edit-btn, .logout-btn, .delete-account-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .edit-btn {
            background-color: black;
            color: white;
        }
        .logout-btn {
            background-color: black;
            color: white;
        }
        .delete-account-btn {
            background-color:black ;
            color: white;
            border: none;
            cursor: pointer;
        }
        .order-history {
            padding: 20px;
            background-color: red;
            border-radius: 10px;
        }
        .order-history h2 {
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #C3073F;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: red;
            color: black;
        }
        .no-orders {
            text-align: center;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="account-header">
        <h1>Welcome, <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h1>
    </header>

    <!-- Main Content -->
    <main class="account-container">
        
        <!-- Profile Section -->
        <section class="profile-section">
            <h2>Your Profile</h2>
            <p>First Name: <?= htmlspecialchars($user['first_name']) ?></p>
            <p>Last Name: <?= htmlspecialchars($user['last_name']) ?></p>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
            <p>Phone Number: <?= htmlspecialchars($user['phone_number']) ?></p>
            <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
            <a href="logout.php" class="logout-btn">Logout</a>

            <!-- Delete Account Form -->
            <form method="POST" action="delete_account.php" style="display:inline;">
                <button type="submit" class="delete-account-btn" onclick="return confirm('Are you sure you want to delete your account?');">
                    Delete Account
                </button>
            </form>
        </section>

        <!-- Order History Section -->
        <section class="order-history">
            <h2>Order History</h2>
            <?php if ($order_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price (₹)</th>
                            <th>Quantity</th>
                            <th>Total (₹)</th>
                            <th>Payment Method</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $order_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['product_name']) ?></td>
                                <td><?= htmlspecialchars($order['price']) ?></td>
                                <td><?= htmlspecialchars($order['quantity']) ?></td>
                                <td><?= htmlspecialchars($order['total_price']) ?></td>
                                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-orders">No orders found.</p>
            <?php endif; ?>
        </section>

    </main>

</body>
</html>

