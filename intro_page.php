<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Yuva Enterprises</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* ATTRACTIVE HEADER */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: linear-gradient(90deg, red, #6F2232);
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.5);
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        nav ul li a:hover {
            color: #FFD700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }

        /* MAIN CONTENT */
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #1A1A1D;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        h1 {
            color: red;
        }
        .bold-text {
            font-weight: bold;
            font-size: 18px;
        }
        .members {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
}

.member {
    background-color: black;
    padding: 15px;
    border-radius: 10px;
    width: 80%;
    text-align: center; /* Centering text */
    border: 2px solid red;
}

.member h2 {
    color:white;
    font-size: 16px; /* Small text */
   
}

       
    </style>
</head>
<body>

    <header>
        <div class="logo">YUVA Enterprises</div>
        <nav>
            <ul>
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="admin_login.php">🔑 Admin Page</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>About Our Project</h1>
        <p class="bold-text">
            Welcome to YUVA Enterprises, a platform for PlayStation rentals and gaming accessories.  
            Our project aims to make gaming more accessible and affordable for all gamers.
        </p>

        <h2>Team Members</h2>
        <div class="members">
            <div class="member">
                <h2>🎮 Shravani Avinash Paralkar: 46</h2>
            </div>
            <div class="member">
                <h2>🎮 Shraddha Kishor Mitkar: 41</h2>
            </div>
        </div>

        
    </div>

</body>
</html>

