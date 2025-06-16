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
    min-height: 100%;
    font-family: 'Poppins', Arial, sans-serif;
    color: white;
    background: url('ex2.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    flex-direction: column; 
}

/* Main Content Area */
main {
    flex: 1; 
    padding-bottom: 10px; 
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
    flex: 1; 
}

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
      .about-us {
    max-width: 800px; 
    margin: 50px auto; 
    padding: 30px; 
    padding-top:12px;
    background-color: rgba(0, 0, 0, 0.5); 
    border-radius: 15px; 
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4); 
    text-align: center; 
    color: white; 
}

.about-us h1 {
    font-size: 3rem; 
    color: red;
    margin-bottom: 20px; 
}

.about-us h2 {
    font-size: 2rem; 
    color: red; 
    margin-bottom: 15px; 
}

.about-us p, 
.about-us ul li {
    font-size: 1.2rem;
    line-height: 1.7; 
    margin-bottom: 20px; 
}

.about-us ul {
    list-style: none; 
    padding: 0; 
    margin: 20px 0; 
}

.about-us ul li {
    display: flex; 
    align-items: center;
    justify-content: center;
    gap: 10px; 
}

.about-us ul li::before {
    content: "•"; 
    color: red; 
    font-size: 1.4rem; 
}

        /* Footer Styling 
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background: transparent;
            font-size: 14px;
            color: white;
            z-index: 1000;
        }*/

#dashboard-btn{
color:white;
background-color:black;
}

        
        /* Sidebar */
        aside#sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 220px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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
a{
color:red;}

/* Footer Styling */
footer {
    text-align: center;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.3); 
    font-size: 14px;
    color: white;
    width: 100%;
}    
/* Responsive Design for About Us Page */
@media (max-width: 768px) {
    .about-us {
        padding: 20px;
    }

    .about-us h1 {
        font-size: 1.8rem;
    }

    .about-us h2 {
        font-size: 1.4rem;
    }

    .about-us p {
        font-size: 0.9rem;
    }
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
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php"class="active">About Us</a></li>
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
    </aside><main>
        <section class="content about-us">
    <h1>About Us</h1>
    <div class="section-intro">
        <p>Welcome to <strong>Yuva Enterprises</strong>, your one-stop gaming shop. We provide everything a gamer needs to level up their experience—be it renting the latest consoles or purchasing top-tier games and accessories.</p>
    </div>
    <div class="section-details">
        <h2>Our Story</h2>
        <p>Since 2008, Yuva Enterprises has been at the forefront of the gaming world. Founded with a passion for gaming and a drive to make it more accessible to everyone, we've built a strong reputation for offering quality, affordability, and great service.</p>
    </div>
    <div class="section-offer">
        <h2>What We Offer</h2>
        <ul>
            <li>PlayStations and other consoles available for rent.</li>
            <li>A variety of games and accessories for purchase.</li>
            <li>A secure and user-friendly website to manage rentals and purchase history.</li>
        </ul>
    </div>
    <div class="section-tradition">
        <h2>Our Tradition</h2>
        <p>Every December 21, in honor of our founder’s birthday, we treat the first customer of the day to free access to any console of their choice. This special tradition allows us to celebrate with the community that has supported us since day one.</p>
    </div>
    <div class="cta">
        <p>Join us and celebrate gaming! <a href="signup.php">Sign up now</a> and start your gaming adventure.</p>
    </div>
</section>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Yuva Enterprises. All rights reserved.</p>
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
