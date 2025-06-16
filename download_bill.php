<?php
require('tcpdf/tcpdf.php');
$conn = new mysqli('localhost', 'root', '', 'playstation_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['order_id'])) {
    die("Invalid Order ID.");
}

$order_id = $_GET['order_id'];
$sql = "SELECT * FROM orders WHERE id = '$order_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Order not found.");
}

$order = $result->fetch_assoc();

// Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 14);
$pdf->Cell(0, 10, "Invoice - Order #$order_id", 0, 1, 'C');
$pdf->Ln(10);

$pdf->Cell(50, 10, "Product", 1);
$pdf->Cell(30, 10, "Price (₹)", 1);
$pdf->Cell(20, 10, "Qty", 1);
$pdf->Cell(40, 10, "Total (₹)", 1);
$pdf->Ln();
$pdf->Cell(50, 10, $order['product_name'], 1);
$pdf->Cell(30, 10, $order['price'], 1);
$pdf->Cell(20, 10, $order['quantity'], 1);
$pdf->Cell(40, 10, $order['total_price'], 1);

$pdf->Output("invoice_$order_id.pdf", "D"); // "D" forces download
?>
