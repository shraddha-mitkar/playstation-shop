<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to homepage or another page
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Store error messages

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Prevent SQL injection
        $email = $conn->real_escape_string($email);

        // Fetch user from the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];

                header("Location: index.php"); // Redirect
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<!-- HTML part for the login form (same as before) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <title>Login</title>
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
/* Main Content Area */
main {
    flex: 1; 
    padding-bottom: 10px; }



        /* Transparent Header */
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
    align-items: center; }

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
/* Login Page Background */
.login-page {
    background-image: url('ex2.jpg'); 
    background-size: cover;  
    background-position: center;  
    background-attachment: fixed; 
    padding: 50px 20px;  
    color: white; 
    min-height: 100vh; 
}


/* Login Form Styling */
.login-page .content {
    max-width: 400px;
       background: rgba(0, 0, 0, 0.8); 
    padding: 30px;
margin:0 auto;;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
    backdrop-filter: blur(5px); 
}

.login-page h1 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 20px;
color: red;

}

/* Login Form Fields */
.login-page form {
    display: flex;
    flex-direction: column;
width:350px;
}

.login-page form label {
    font-size: 1rem;
    margin-bottom: 5px;
}

.login-page form input {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
border: 1px solid red;
    font-size: 1rem;
color:white;
   background: rgba(0, 0,0, 0.5); 
}

.login-page form button {
    padding: 10px;
    background-color:red;
    color: white;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-page form button:hover {
    background-color: #950740;
}

/* Signup Link */
.signup-link {
    text-align: center;
    margin-top: 20px;
    font-size: 1rem;
}

.signup-link a {
    color: red;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;
}
 .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
</style>
<script>
        function validateForm() {
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let errorDiv = document.getElementById("error-message");

            // Reset error messages
            errorDiv.innerHTML = "";

            if (email === "" || password === "") {
                errorDiv.innerHTML = "Both fields are required.";
                return false;
            }

            // Email validation
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                errorDiv.innerHTML = "Invalid email format.";
                return false;
            }

            return true;
        }
    </script>



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
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
        <div class="search-container">
            <input type="text" placeholder="Search games, accessories..." class="search-bar">
            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>

        </div>
    </header>


    <!-- Login Form Section -->
    <main class="login-page">
        <section class="content">
            <h1>Login</h1>

            <!-- Display error message -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="post" onsubmit="return validateForm()">
                <div id="error-message" class="error-message"></div> <!-- JS error message -->

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>

            <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </section>
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