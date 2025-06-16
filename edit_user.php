<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'playstation_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);

    $conn->query("UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number' WHERE id=$user_id");

    header("Location: manage_users.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

    <h2>Edit User</h2>
    <form method="POST">
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
        <button type="submit">Update</button>
    </form>

</body>
</html>
