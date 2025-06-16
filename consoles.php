<?php
// Start session
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "playstation_shop";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart count
$cart_count = count($_SESSION['cart']);

// Handle Add to Cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $console_id = $_POST['console_id'];
    $console_name = $_POST['console_name'];
    $console_type = $_POST['add_to_cart']; // Rent or Purchase
    $console_price = 0;

    // Fetch price from database
    $stmt = $conn->prepare("SELECT rent_price, purchase_price FROM consoles WHERE id = ?");
    $stmt->bind_param("i", $console_id);
    $stmt->execute();
    $stmt->bind_result($rent_price, $purchase_price);
    $stmt->fetch();
    $stmt->close();

    if ($console_type == "rent") {
        $console_price = $rent_price;
    } elseif ($console_type == "purchase") {
        $console_price = $purchase_price;
    }

    // Add to cart
    $_SESSION['cart'][] = [
        'id' => $console_id,
        'name' => $console_name,
        'price' => $console_price,
        'type' => $console_type
    ];

    $_SESSION['message'] = "$console_name added to your cart!";
    header("Location: consoles.php");
    exit();
}

// Fetch message
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Handle Search Query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
}

// Fetch consoles from database
$consoles = [];
$sql = "SELECT id, name, rent_price, purchase_price, image FROM consoles";
if (!empty($search_query)) {
    $sql .= " WHERE name LIKE ?";
}

$stmt = $conn->prepare($sql);
if (!empty($search_query)) {
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $consoles[] = $row;
    }
}
$stmt->close();
$conn->close();

// Function to highlight search results
function highlightText($text, $query) {
    if (empty($query)) return htmlspecialchars($text);
    return preg_replace('/(' . preg_quote($query, '/') . ')/i', '<span class="highlight">$1</span>', htmlspecialchars($text));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consoles - Yuva Enterprises</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: black; color: white; margin: 0; padding: 0; }
        header { display: flex; align-items: center; justify-content: space-between; background-color: black; color: white; padding: 10px 20px; }
        .logo { font-size: 24px; font-weight: bold; color: red; }
        nav ul { list-style: none; display: flex; margin: 0; padding: 0; }
        nav ul li { margin: 0 10px; }
        nav ul li a { color: white; text-decoration: none; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        h1 { color: red; text-align: center; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; }
        .card { background-color: black; border-radius: 15px; padding: 30px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-10px); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); }
        .card img { max-width: 100%; height: 250px; object-fit: contain; margin-bottom: 20px; border-radius: 10px; }
        .card h3 { font-size: 24px; color:red; }
        .card p { font-size: 18px; color: #C3073F; }
        .card button { background-color: red; color: white; border: none; padding: 15px 20px; cursor: pointer; border-radius: 10px; font-size: 16px; }
        .card button:hover { background-color: #6F2232; }
        #cart-count { font-weight: bold; color: red; }
        .highlight { 
    background: linear-gradient(90deg,rgb(255, 59, 59), #ff9800); /* Gradient effect */
    color: black; 
    padding: 8px 12px; 
    border-radius: 10px; 
    font-weight: bold; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Text glow effect */
    animation: glow 1.5s infinite alternate ease-in-out;
}
.confirmation-message {
            margin: 10px 0;
            padding: 10px;
            background-color: red; 
            color: white;
            border: 1px solid #C3073F; 
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        


/* Glow animation */
@keyframes glow {
    from {
        box-shadow: 0 0 10px rgba(56, 19, 19, 0.8); /* Yellow glow */
    }
    to {
        box-shadow: 0 0 20px rgba(56, 19, 19, 0.8);; /* Orange glow */
    }
}
        
    </style>
</head>
<body>
    <header>
        <div class="logo">YUVA</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="games.php">Games</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="cart.php">Cart (<span id="cart-count"><?php echo $cart_count; ?></span>)</a></li>
            </ul>
        </nav>
    </header>
<?php if (!empty($message)): ?>
        <p class="confirmation-message"> <?php echo htmlspecialchars($message); ?> </p>
    <?php endif; ?>


    <div class="container">
    <h1>Available Consoles</h1>
    <div class="grid">
        <?php 
        $highlight_name = isset($_GET['highlight']) ? urldecode($_GET['highlight']) : '';

        foreach ($consoles as $console): 
            $is_highlighted = (!empty($highlight_name) && strcasecmp($console['name'], $highlight_name) == 0);
        ?>
            <div class="card">
                <img src="images/<?php echo $console['image']; ?>" alt="<?php echo $console['name']; ?>">
                <h3 class="<?php echo $is_highlighted ? 'highlight' : ''; ?>">
                    <?php echo htmlspecialchars($console['name']); ?>
                </h3>
                <p>Rent Price: ₹<?php echo $console['rent_price']; ?></p>
                <p>Purchase Price: ₹<?php echo $console['purchase_price']; ?></p>
                <form method="POST" action="consoles.php">
                    <input type="hidden" name="console_id" value="<?php echo $console['id']; ?>">
                    <input type="hidden" name="console_name" value="<?php echo $console['name']; ?>">
                    <button type="submit" name="add_to_cart" value="rent">Rent for ₹<?php echo $console['rent_price']; ?></button>
                    <button type="submit" name="add_to_cart" value="purchase">Buy for ₹<?php echo $console['purchase_price']; ?></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Find the highlighted game
        let highlightedGame = document.querySelector(".highlight");

        if (highlightedGame) {
            // Scroll smoothly to the highlighted game
            highlightedGame.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    });
</script>
</body>
</html>

