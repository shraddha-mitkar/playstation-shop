<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1A1A1D;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }
        .dashboard-container {
            background: #4E4E50;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            width: 50%;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: white;
        }
        .nav-links {
            margin-top: 20px;
        }
        .nav-links a {
            display: inline-block;
            text-decoration: none;
            background-color: red;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            font-size: 16px;
        }
        .nav-links a:hover {
            background-color: #C3073F;
        }
.logout-btn {
    display: inline-block;
    background-color: red;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
}

.logout-btn:hover {
    background-color: #950740;
}

    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome, Admin!</h1>
        <div class="nav-links">
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_bookings.php">Manage Bookings</a>
            <a href="manage_consoles.php">Manage Consoles</a>
            <a href="manage_games.php">Manage games</a>
             <a href="manage_accessories.php">Manage accessories</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>

        </div>
    </div>

</body>
</html>
