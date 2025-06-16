<?php
session_start(); // Start session at the top of the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Yuva Enterprises</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* General Styles */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', Arial, sans-serif;
            color: white;
            background: url('ex2.jpg') no-repeat center center fixed;
            background-size: cover;
        }
/* Main Content Area */
main {
    flex: 1; /* Allows main content to take up the remaining space */
    padding-bottom: 10px; /* Optional: Ensures space between content and footer */
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
    flex: 1; /* Ensures the search bar adjusts size dynamically */
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
        /* Main Section */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
#dashboard-btn{
color:white;
background-color:black;
}

        /* Transparent Footer */
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
    z-index: 2000; /* Ensure it appears above content */
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
/* Contact Us Page Background */
.contact-us {
    background-image: url('bg3.jpg'); 
    background-size: cover;
    background-position: center;  
    background-attachment: fixed; 
    padding: 60px 20px;  
    color: white; 
    min-height: 80vh; 
}

/* Contact Form Styling */
.contact-us .content {
    margin-left:100px;
    background: rgba(0, 0, 0, 0.8);    padding: 30px;
    border-radius: 20px;  
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4); 
    backdrop-filter: blur(5px); 
}

/* Title of Contact Form */
.contact-us h1 {
    text-align: center;
    font-size: 2rem;
color: red;

    margin-bottom: 20px;
}

/* Contact Form Fields */
.contact-us form {
    display: flex;
    flex-direction: column;
width:350px;
}

.contact-us form label {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.contact-us form input,
.contact-us form textarea {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;  
    border: 1px solid #C3073F;
color:white;
    font-size: 1rem;
    background: rgba(0, 0,0, 0.5); }

/* Submit Button Styling */
.contact-us form button {
    padding: 12px;
    background-color:red;
    color: white;
    font-size: 1.1rem;
    border: none;
    border-radius: 8px;  
    cursor: pointer;
    transition: background-color 0.3s;
}

.contact-us form button:hover {
    background-color: #950740;
}
.contact-details{
width:400px;
height:230px;
background-color:rgba(0, 0, 0, 0.8);
border-radius:8px;
 }
.contact-details h2{
color: red;
}

/* Footer Styling */
footer {
    text-align: center;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.3); 
    font-size: 14px;
    color: white;
    width: 100%;
}    




</style>
</head>
<body>
    <!-- Sidebar -->
    <aside id="sidebar" class="hidden">
        <ul>
            <li><a href="games.php"><i class="fa-solid fa-gamepad"></i>    Games</a></li>
            <li><a href="accessories.php"><i class="fa-solid fa-headphones-simple"></i>  Accessories</a></li>
            <li><a href="consoles.php"><i class="fa-brands fa-playstation"></i>    Consoles</a></li>
            <li><a href="booking.php"><i class="fa-regular fa-calendar-check"></i>   Book a Session</a></li>
            <li><a href="support.php"><i class="fa-regular fa-circle-question"></i>  Support & Help</a></li>
            <li><a href="account.php"><i class="fa-regular fa-user"></i>  My Account</a></li>
        </ul>
    </aside>

    <!-- Header Section -->
    <header>
        <button id="dashboard-btn">☰</button>
        <div class="logo">YUVA</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php" class="active">Contact Us</a></li>
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

    <!-- Contact Form Section -->
    <main class="contact-us">
        <section class="content">
            <h1>Contact Us</h1>

            <?php
            $message = '';

            // Database Connection
            $host = "localhost";
            $username = "root";
            $password = ""; 
            $database = "playstation_shop";

            // Connect to the database
            $conn = new mysqli($host, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize input to prevent SQL injection
                $name = $conn->real_escape_string($_POST['name']);
                $email = $conn->real_escape_string($_POST['email']);
                $user_message = $conn->real_escape_string($_POST['message']);

                // Insert data into the contact table
                $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$user_message')";

                if ($conn->query($sql) === TRUE) {
                    $message = "Thank you for contacting us!";
                } else {
                    $message = "Error: " . $conn->error;
                }
            }

            // Close connection
            $conn->close();
            ?>

            <!-- Display Success/Failure Message -->
            <?php if ($message): ?>
                <p class="notification"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
 

            <!-- Contact Form -->
            <form action="contact.php" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
<main class="contact-us">
        <section class="contact-details">
            <h2>Our Contact Details</h2>
            <p><strong>Phone:</strong> +91 9730953024</p>
            <p><strong>Email:</strong> yuvagamezone30@gmail.com</p>
            <p><strong>Address:</strong> Shop No. 24,Tulsi Arcade,Cannought Place,CIDCO,Chhtrapati Sambhajinagar.</p>
        </section>

    </main>
        </main>
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
