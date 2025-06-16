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

// Fetch current user details
$user_query = "SELECT first_name, last_name, email, phone_number FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    die('User not found. Please check the users table.');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);

    $update_query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone_number = '$phone_number' WHERE id = $user_id";

    if ($conn->query($update_query)) {
        // Redirect back to account page after successful update
        header('Location: account.php');
        exit;
    } else {
        $error_message = 'Failed to update profile. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: #333;
        }
        .edit-profile-header {
            background-color:red;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .edit-profile-container {
            display: flex;
            justify-content: center;
            padding: 60px 20px; 
        }
        .edit-profile-form {
            width: 40%;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .save-btn {
            padding: 12px 25px;
            background-color: red;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .save-btn:hover {
            background-color: #0056b3;
        }
        .cancel-btn {
            padding: 12px 25px;
            background-color: #ccc;
            text-decoration: none;
            border-radius: 5px;
            color: #333;
            font-size: 16px;
        }
        .cancel-btn:hover {
            background-color: #bbb;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="edit-profile-header">
        <h1>Edit Your Profile</h1>
    </header>

    <!-- Main Content -->
    <main class="edit-profile-container">
        <form method="POST" class="edit-profile-form">
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" name="phone_number" id="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="save-btn">Save Changes</button>
                <a href="account.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Yuva Enterprises. All rights reserved.</p>
    </footer>
</body>
</html>
