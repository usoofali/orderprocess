<?php
// Start session
session_start();

// Include database connection file
include('dbconnect.php');

// Get product ID and quantity from AJAX request
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];

// Get user ID from session
$userId = $_SESSION['user_id'];

// Get product information from database
$sql = "SELECT * FROM products WHERE id = $productId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Calculate total cost of order items
$totalCost = $row['price'] * $quantity;

// Insert order into orders table
$sql = "INSERT INTO orders (user_id, total_cost, order_date, order_status) VALUES ($userId, $totalCost, NOW(), 'Incomplete')";
mysqli_query($conn, $sql);

// Get order ID of inserted order
$orderId = mysqli_insert_id($conn);

// Insert order item into order_items table
$sql = "INSERT INTO order_items (order_id, product_id, quantity, item_cost) VALUES ($orderId, $productId, $quantity, $totalCost)";
mysqli_query($conn, $sql);

// Close database connection
mysqli_close($conn);
?>
