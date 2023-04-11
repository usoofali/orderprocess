

<?php
// Connect to the database
// Start session
// Include database connection file
include('dbconnect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: login.php');
	exit();
}

// Handle adding or removing items from the cart
if (isset($_POST['add_to_cart'])) {
	// Get the quantity and product ID from the form
	$quantity = $_POST['quantity'];
	$product_id = $_POST['product_id'];
	
	// Insert the order into the orders table
	$user_id = $_SESSION['user_id'];
	$sql = "INSERT INTO orders (user_id, status) VALUES ('$user_id', 'incomplete')";
	if ($conn->query($sql) === TRUE) {
		$order_id = $conn->insert_id;
		
		// Insert the item into the order_items table
		$sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
		if ($conn->query($sql) === TRUE) {
			echo "Item added to cart successfully.";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} elseif (isset($_POST['remove_from_cart'])) {
	// Get the order item ID from the form
	$order_item_id = $_POST['order_item_id'];
	
	// Delete the order item from the order_items table
	$sql = "DELETE FROM order_items WHERE id='$order_item_id'";
	if ($conn->query($sql) === TRUE) {
		echo "Item removed from cart successfully.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

// Select all items from the product table
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="dashboard.php">Home</a></li>
			<li><a href="product.php">Products</a></li>
			<li><a href="orders.php">Orders</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="contact.php">Contact Us</a></li>
		</ul>
	</nav>
	
	<h1>Products</h1>
	
	<?php
	if ($result->num_rows > 0) {
		// Display each product in a scrollable list
		echo '<div style="overflow-y: scroll; height: 500px;">';
		while ($row = $result->fetch_assoc()) {
			echo '<div style="border: 1px solid black; padding: 10px; margin-bottom: 10px;">';
			echo '<h3>' . $row['name'] . '</h3>';
			echo '<p>Price: ' . $row['price']

