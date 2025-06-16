<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("Please log in to access the cart.");
}

$user_id = $_SESSION['user_id'];

// Fetch user details from users table
$user_query = $conn->query("SELECT first_name, phone_number FROM users WHERE id = '$user_id'");
$user_data = $user_query->fetch_assoc();
$user_name = $user_data['first_name'];
$phone_number = $user_data['phone_number'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkout'])) {
        if (!empty($_SESSION['cart'])) {
            $payment_method = $_POST['payment_method'];

            $order_items = [];

            foreach ($_SESSION['cart'] as $item) {
$product_name = mysqli_real_escape_string($conn, $item['name']);
                $price = $item['price'];
                $quantity = 1;
                $total_price = $price * $quantity;

                // Insert into orders table (FIXED: Added missing variable names)
                $conn->query("INSERT INTO orders (user_id, user_name, phone_number, product_name, price, quantity, total_price, payment_method) 
                             VALUES ('$user_id', '$user_name', '$phone_number', '$product_name', '$price', '$quantity', '$total_price', '$payment_method')");

                $order_items[] = [
                    'product_name' => $product_name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total_price' => $total_price
                ];
            }

            $_SESSION['bill_items'] = $order_items; // Store for bill page
            $_SESSION['cart'] = []; // Clear cart after checkout

            // Redirect to bill.php after successful order placement
            header("Location: bill.php");
            exit();
        } else {
            $message = "Your cart is empty!";
        }
    }

    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = []; // Clear cart
        $message = "Cart cleared successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1A1A1D;
            color: white;
        }

        /* Header Styling */
        header {
            background: transparent;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
            color: red;
        }

        header nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        header nav ul li {
            margin: 0 15px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        header nav ul li a:hover {
            color: red;
        }

        /* Main Container */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: red;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: white;
        }

        table th {
            background-color: red;
        }

        .payment-method {
            margin: 20px 0;
            font-size: 18px;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            background: white;
            font-size: 16px;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            background-color: red;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        button:hover {
            background-color: #950740;
        }

       .message {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">YUVA</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="games.php">Games</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="consoles.php">Consoles</a></li>
            </ul>
        </nav>
    </header>

    <!-- Shopping Cart Section -->
    <div class="container">
        <h2>Your Shopping Cart</h2>

        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Payment Method Selection -->
            <form method="POST">
                <div class="payment-method">
                    <label>Payment Method:</label>
                    <select name="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="UPI">UPI</option>
                        <option value="offline">offline</option>

                    </select>

                </div>

                <div class="actions">

                    <button type="submit" name="checkout">Checkout</button>
<button type="submit" name="clear_cart" style="background-color: white; color: red; border: 1px solid red;">Clear Cart</button>

                </div>
            </form>
        <?php else: ?>
            <p>Your cart is empty. <a href="accessories.php" style="color: red;">Browse Accessories</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
