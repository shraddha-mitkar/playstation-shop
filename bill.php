<?php
session_start();

// Debugging: Check if session contains bill data
if (!isset($_SESSION['bill_items']) || empty($_SESSION['bill_items'])) {
    die("<p style='color: red; text-align: center;'>⚠️ No order found. Please checkout first.</p>");
}

$bill_items = $_SESSION['bill_items']; // Retrieve bill data
unset($_SESSION['bill_items']); // Clear session after generating bill
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧾 Your Bill - Yuva PlayStation Shop</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0B0C10;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .bill-container {
            max-width: 650px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.2);
        }
        .bill-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid red;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .bill-header .logo {
            font-size: 24px;
            font-weight: bold;
            color: red;
            font-family: 'Orbitron', sans-serif;
        }
        .bill-header .date {
            font-size: 14px;
            color: #bbb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        th {
            background-color: red;
            font-weight: 600;
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            color: red;
            margin-top: 20px;
        }
        .print-btn {
            margin-top: 20px;
            background-color:red;
            color: white;
            padding: 12px 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }
        .print-btn:hover {
            background-color: #950740;
            transform: scale(1.05);
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: white;
                color: black;
            }
            .bill-container {
                box-shadow: none;
                background: white;
                color: black;
            }
            th {
                background-color: #000;
                color: white;
            }
        }
    </style>
    <script>
        function printBill() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <div class="logo">🎮 YUVA Enterprises</div>
            <div class="date"><?php echo date("d M Y, h:i A"); ?></div>
        </div>

        <h2>🧾 Order Receipt</h2>
        
        <table>
            <tr>
                <th>Product</th>
                <th>Price (₹)</th>
                <th>Quantity</th>
                <th>Total (₹)</th>
            </tr>
            <?php
            $grand_total = 0;
            foreach ($bill_items as $item):
                $grand_total += $item['total_price'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td>₹<?php echo htmlspecialchars($item['total_price']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p class="total">Grand Total: ₹<?php echo number_format($grand_total, 2); ?></p>

        <button class="print-btn" onclick="printBill()">🖨️ Print Bill</button>
    </div>
</body>
</html>





