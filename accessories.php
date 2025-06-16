<?php
// Start session
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
$conn = new mysqli("localhost", "root", "", "playstation_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart count
$cart_count = count($_SESSION['cart']);

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_type = $_POST['add_to_cart']; // Rent or Purchase
    $item_price = 0;

    // Get prices from DB
    $stmt = $conn->prepare("SELECT rent_price, purchase_price FROM accessories WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($rent_price, $purchase_price);
    $stmt->fetch();
    $stmt->close();

    $item_price = ($item_type == "rent") ? $rent_price : $purchase_price;

    // Add to cart
    $_SESSION['cart'][] = [
        'id' => $item_id,
        'name' => $item_name,
        'price' => $item_price,
        'type' => $item_type
    ];

    $_SESSION['message'] = "$item_name added to your cart!";
    header("Location: accessories.php");
    exit();
}

// Fetch success message
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Handle Search Query
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$highlight_name = isset($_GET['highlight']) ? urldecode($_GET['highlight']) : '';

// Fetch Accessories from DB
$accessories = [];
$sql = "SELECT id, name, rent_price, purchase_price, image FROM accessories";

if (!empty($search_query)) {
    $sql .= " WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accessories[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accessories - Yuva Enterprises</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: black; color: white; margin: 0; padding: 0; }
        header { display: flex; align-items: center; justify-content: space-between; background-color: black; padding: 10px 20px; }
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
        .card h3 { font-size: 24px; color: red; }
        .card p { font-size: 18px; color: #C3073F; }
        .card button { background-color: red; color: white; border: none; padding: 15px 20px; cursor: pointer; border-radius: 10px; font-size: 16px; margin: 5px; }
        .card button:hover { background-color: #6F2232; }
        #cart-count { font-weight: bold; color: red; }
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
        
        /* Highlight effect */
        .highlight { 
            background: linear-gradient(90deg, rgb(255, 59, 59), #ff9800); 
            color: black; 
            padding: 8px 12px; 
            border-radius: 10px; 
            font-weight: bold; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
            animation: glow 1.5s infinite alternate ease-in-out; 
        }
        @keyframes glow { 
            from { box-shadow: 0 0 10px rgba(255, 59, 59, 0.8); } 
            to { box-shadow: 0 0 20px rgba(255, 152, 0, 0.8); } 
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
                <li><a href="consoles.php">Consoles</a></li>
                <li><a href="cart.php">Cart (<span id="cart-count"><?php echo $cart_count; ?></span>)</a></li>
            </ul>
        </nav>
    </header>

    <?php if (!empty($message)): ?>
        <p class="confirmation-message"> <?php echo htmlspecialchars($message); ?> </p>
    <?php endif; ?>

    <div class="container">
        <h1>Available Accessories</h1>

        <div class="grid">
            <?php foreach ($accessories as $accessory): 
                $is_highlighted = (!empty($highlight_name) && stripos($accessory['name'], $highlight_name) !== false);
            ?>
                <div class="card">
                    <img src="<?php echo $accessory['image']; ?>" alt="<?php echo $accessory['name']; ?>">
                    <h3 class="<?php echo $is_highlighted ? 'highlight' : ''; ?>">
                        <?php echo htmlspecialchars($accessory['name']); ?>
                    </h3>
                    <p>Rent Price: ₹<?php echo $accessory['rent_price']; ?></p>
                    <p>Purchase Price: ₹<?php echo $accessory['purchase_price']; ?></p>
                    <form method="POST">
                        <input type="hidden" name="item_id" value="<?php echo $accessory['id']; ?>">
                        <input type="hidden" name="item_name" value="<?php echo $accessory['name']; ?>">
                        <button type="submit" name="add_to_cart" value="rent">Rent</button>
                        <button type="submit" name="add_to_cart" value="purchase">Purchase</button>
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

