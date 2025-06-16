<?php
session_start(); // Start session at the top of the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yuva Enterprises - Home</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
       
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', Arial, sans-serif;
            color: white;
            background: url('ex2.jpg') no-repeat center center fixed;
           background-size: cover;
        }

                header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: transparent;
        }

        header .logo {
            font-size: 28px;
            font-weight: bold;
            color: red;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        header nav ul li a {
            text-decoration: none;
          ;  color: white;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        header nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
.search-container {
    display: flex;
    gap: 8px;
    align-items: center; 
}

.search-bar {
    padding: 8px 15px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    flex: 1; }

.search-btn {
    background-color: red;
    color: white;
    border: none;
    margin-right:35px;
    padding: 7px 13px;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-btn:hover {
    background-color: #950740;
}
        /* Main Section */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .content h1 {
            font-size: 40px;
            color: red;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 30px;
        }

        .content .btn {
            background: none;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border: 2px solid red;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
            transition: color 0.3s;
        }

        .content .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: red;
            z-index: -1;
            transition: left 0.3s ease-in-out;
        }

        .content .btn:hover {
            color: white;
        }

        .content .btn:hover::before {
            left: 0;
        }
#dashboard-btn{
color:white;
background-color:black;
}

                footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 15px;
            background: transparent;
            font-size: 14px;
            color: white;
            z-index: 1000;
        }

        /* Sidebar */
        aside#sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 220px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s;
        }

        aside#sidebar ul {
            list-style: none;
            padding-top: 14px;
padding-left: 4px;
        }

        aside#sidebar ul li a {
            text-decoration: none;
            color: white;
            padding: 10px;
            display: block;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        aside#sidebar ul li a:hover {
            background-color: red;
        }

        aside#sidebar.open {
            transform: translateX(250px);
        }
        .product-showcase {
    text-align: center;
    padding: 50px 20px;
    background: rgba(0, 0, 0, 0.8);
}
/* Example of a media query for mobile devices */
@media (max-width: 768px) {
    header nav ul {
        display: none;
    }

    .content {
        padding: 20px;
    }

    .search-container {
        flex-direction: column;
        gap: 10px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    header nav ul {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .content {
        padding: 30px;
    }

    .search-container {
        flex-direction: row;
    }
}


.product-showcase h2 {
    color: red;
    font-size: 32px;
    margin-bottom: 30px;
}

.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.product {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 200px;
    transition: transform 0.3s ease;
}

.product img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}

.product h3 {
    margin-top: 10px;
    font-size: 18px;
}

.product:hover {
    transform: scale(1.05);
}
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <button id="dashboard-btn">☰</button>
        <div class="logo">YUVA</div>
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
<?php if (isset($_SESSION['user_id'])): ?>
                <!-- If user is logged in, show Logout -->
                <li><a href="logout.php" style="color: red;">Logout</a></li>
            <?php else: ?>
                <!-- If user is NOT logged in, show Login -->
                <li><a href="login.php" style="color: green;">Login</a></li>
            <?php endif; ?>

            </ul>
        </nav>
        

        <form action="search.php" method="GET" class="search-container">
    <input type="text" name="query" class="search-bar" placeholder="Search games, accessories..." required>
    <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>

</header>

    <!-- Sidebar -->
    <aside id="sidebar">
        <ul>
            <li><a href="games.php"><i class="fa-solid fa-gamepad"></i>    Games</a></li>
            <li><a href="accessories.php"><i class="fa-solid fa-headphones-simple"></i>  Accessories</a></li>
            <li><a href="consoles.php"><i class="fa-brands fa-playstation"></i>    Consoles</a></li>
            <li><a href="booking.php"><i class="fa-regular fa-calendar-check"></i>   Book a Session</a></li>
            <li><a href="support.php"><i class="fa-regular fa-circle-question"></i>  Support & Help</a></li>
            <li><a href="account.php"><i class="fa-regular fa-user"></i>  My Account</a></li>
            

        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="content">

            <h1>Welcome to Yuva Enterprises</h1>
            <p>Your ultimate destination for PlayStations, games, and accessories. Rent, buy, and enjoy the best gaming experience!</p>
            <a href="about.php" class="btn">Learn More</a>
        </div>
    </main>
    <!-- Product Showcase Section -->
<section class="product-showcase">
    <h2>Explore Our Products</h2>
    <div class="product-container">
        <div class="product">
            <img src="psimag.png" alt="PlayStation 5">
            <h3>PlayStation 5</h3>
        </div>
        <div class="product">
            <img src="portal.jpg" alt="PlayStation Portal">
            <h3>PlayStation Portal</h3>
        </div>
        <div class="product">
            <img src="ps5_controller.jpg" alt="PS5 Controller">
            <h3>DualSense Controller</h3>
        </div>
        <div class="product">
            <img src="wirelessheadset.jpg" alt="Gaming Headset">
            <h3>Gaming Headset</h3>
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer>
        &copy; 2025 Yuva Enterprises. All rights reserved.
    </footer>

    <!-- JavaScript for Sidebar -->
    <script>
        const dashboardBtn = document.getElementById('dashboard-btn');
        const sidebar = document.getElementById('sidebar');

        dashboardBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent event from bubbling to body
            sidebar.classList.toggle('open');
        });

        document.body.addEventListener('click', () => {
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });

        sidebar.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    </script>

</body>
</html>
