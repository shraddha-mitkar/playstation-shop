<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, show a message and links to login/signup
    echo '<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied</title>
        <style>
           body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: rgba(0, 0, 0, 0.9);
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .message-container {
                text-align: center;
                max-width: 400px;
                padding: 20px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #C3073F;
            }
            p {
                margin: 15px 0;
                font-size: 18px;
            }
            a {
                display: inline-block;
                margin: 10px;
                padding: 10px 15px;
                text-decoration: none;
                color: white;
                background-color: #C3073F;
                border-radius: 5px;
            }
            a:hover {
                background-color: #950740;
            }

       </style>
    </head>
    <body>
        <div class="message-container">
            <h1>Access Denied</h1>
            <p>You must log in or sign up to book a gaming session.</p>
            <a href="login.php">Log In</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </body>
    </html>';
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT first_name, last_name, phone_number FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    die('User not found. Please check the users table.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $console = $conn->real_escape_string($_POST['console']);
$date = $conn->real_escape_string($_POST['date']);

    $start_time = $conn->real_escape_string($_POST['start_time']);
    $duration = (int)$_POST['duration'];
    $players = (int)$_POST['players'];
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $payment_option = isset($_POST['payment_option']) ? $conn->real_escape_string($_POST['payment_option']) : null;
    $user_name = $conn->real_escape_string($user['first_name'] . ' ' . $user['last_name']);
    $phone_number = $conn->real_escape_string($user['phone_number']);

    // Pricing logic
    $prices = [
        'ps1' => 50,
        'ps2' => 50,
        'ps3' => 60,
        'ps4_single' => 70,
        'ps4_multi' => 60,
        'ps5_single' => 100,
        'ps5_multi' => 80
    ];

    $price_per_hour = 0;
    if ($console === 'ps4') {
        $price_per_hour = ($players > 1) ? $prices['ps4_multi'] : $prices['ps4_single'];
    } elseif ($console === 'ps5') {
        $price_per_hour = ($players > 1) ? $prices['ps5_multi'] : $prices['ps5_single'];
    } else {
        $price_per_hour = $prices[$console];
    }

    $total_price = $price_per_hour * $duration * $players;

    // Insert booking into database
    $insert_query = "INSERT INTO bookings (user_id, user_name, phone_number, console, booking_date, start_time, duration, players, payment_method, total_price)

                     VALUES ('$user_id', '$user_name', '$phone_number', '$console', '$date', '$start_time', '$duration', '$players', '$payment_method', '$total_price')";
    if ($conn->query($insert_query)) {
        $booking_id = $conn->insert_id; // Get the last inserted booking ID
        echo "<script>
            alert('Booking successful! Redirecting to bill...');
            window.location.href='booking_bill.php?booking_id=$booking_id';
        </script>";
        exit;
    } else {
        echo "<p style='color:red;'>ERROR: " . $conn->error . "</p>";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Gaming Session</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: black;
    color: #fff;
}

.booking-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 50px;
    padding-top:5px;
    background: black;
    border-radius: 14px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: red;
    margin-bottom: 20px;
}

/* Improved spacing */
.form-group-container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px; /* Increased gap between items */
}

.form-group {
    flex: 1 1 calc(50% - 15px); /* Two columns with more space */
    min-width: 320px;
    color: white;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input, select {
    width: 100%;
    background-color: #fff;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

/* Increase spacing for button */
button {
    width: 100%;
    background-color: red;
    color: #fff;
    border: none;
    cursor: pointer;
    padding: 14px;
    font-size: 18px;
    margin-top: 20px; /* Increased margin */
}

button:hover {
    background-color: #950740;
}

/* Better spacing for payment options */
.payment-options {
    display: none;
    margin-top: 15px;
}

/* Text readability improvement */
.info-text {
    font-size: 15px;
    color: #bbb;
    margin-top: 5px;
}

/* Improve spacing between fields */
.form-group input,
.form-group select {
    margin-top: 5px;
}
header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: black; 
            color: white;
            padding: 10px 20px;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;color: red;

        }
        header nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        header nav ul li {
            margin: 0 10px;
        }
        header nav ul li a {
            color: white;
            text-decoration: none;
        }


    </style>
    <script>
        function togglePaymentOptions() {
            const paymentMethod = document.getElementById('payment_method').value;
            const paymentOptions = document.getElementById('payment-options');
            if (paymentMethod === 'online') {
                paymentOptions.style.display = 'block';
            } else {
                paymentOptions.style.display = 'none';
            }
        }
    </script>

            </head>
<body>
<!-- Header -->
    <header>
        <div class="logo">YUVA</div>
        <nav>
            <ul>
            <li><a href="games.php"><i class="fa-solid fa-gamepad"></i>    Games</a></li>
            <li><a href="accessories.php"><i class="fa-solid fa-headphones-simple"></i>  Accessories</a></li>
            <li><a href="consoles.php"><i class="fa-brands fa-playstation"></i>    Consoles</a></li>
                
     </ul>
        </nav>
    </header>
    <div class="booking-container">
    <h1>Book a Gaming Session</h1>
    <form method="POST">
        <div class="form-group-container">
            <div class="form-group">
                <label for="console">Choose Console:</label>
                <select name="console" id="console" required>
                    <option value="ps1">PlayStation 1 - ₹50/hour</option>
                    <option value="ps2">PlayStation 2 - ₹50/hour</option>
                    <option value="ps3">PlayStation 3 - ₹60/hour</option>
                    <option value="ps4">PlayStation 4 - ₹70/hour (Single) or ₹60/hour (Multi)</option>
                    <option value="ps5">PlayStation 5 - ₹100/hour (Single) or ₹80/hour (Multi)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="time" name="start_time" id="start_time" min="10:00" max="21:00" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration (Hours):</label>
                <input type="number" name="duration" id="duration" min="1" max="4" required>
                <span class="info-text">Min: 1 hour | Max: 4 hours</span>
            </div>

            <div class="form-group">
                <label for="players">Number of Players:</label>
                <input type="number" name="players" id="players" min="1" max="4" required>
                <span class="info-text">1 to 4 players per console</span>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method" onchange="togglePaymentOptions()" required>
                    <option value="offline">Offline</option>
                    <option value="online">Online</option>
                </select>
            </div>
        </div>

        <div class="form-group payment-options" id="payment-options">
            <label for="payment_option">Choose Payment Option:</label>
            <select name="payment_option" id="payment_option">
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="upi">UPI</option>
                <option value="net_banking">Net Banking</option>
            </select>
        </div>

        <button type="submit">Book Now</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let dateInput = document.getElementById("date");
        if (dateInput) {
            let today = new Date();
            let year = today.getFullYear();
            let month = (today.getMonth() + 1).toString().padStart(2, "0"); // Ensure 2 digits
            let day = today.getDate().toString().padStart(2, "0"); // Ensure 2 digits
            let minDate = `${year}-${month}-${day}`;

            dateInput.setAttribute("min", minDate);
        }
    });
</script>

</body>
</html>
