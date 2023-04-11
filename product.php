<?php
// Start session
session_start();

// Include database connection file
include('dbconnect.php');

// Query to select all products from the products table
$sql = "SELECT * FROM products";

// Execute the query and store the result set
$result = mysqli_query($conn, $sql);

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
	// Products are available, display them in a scrollable list
	echo '<h1>Products</h1>';
	echo '<div style="max-height: 400px; overflow-y: scroll;">';
	echo '<table>';
	echo '<thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Action</th></tr></thead>';
	echo '<tbody>';
	while ($row = mysqli_fetch_assoc($result)) {
		// Display each product in a row of the table
		echo '<tr>';
		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['name'] . '</td>';
		echo '<td>' . $row['description'] . '</td>';
		echo '<td>' . $row['price'] . '</td>';
		echo '<td>';
		echo '<select name="quantity">';
		for ($i = 1; $i <= $row['quantity']; $i++) {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
		echo '</select>';
		echo '</td>';
		echo '<td><button onclick="addToCart(' . $row['id'] . ')">Add to Cart</button></td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
} else {
	// No products available
	echo '<p>No products available.</p>';
}

// Close database connection
mysqli_close($conn);
?>

<script>
// Function to add item to cart
function addToCart(productId) {
	// Send AJAX request to add item to cart
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'add_to_cart.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		if (this.status == 200) {
			alert('Item added to cart.');
		}
	};
	xhr.send('productId=' + productId + '&quantity=' + document.getElementsByName('quantity')[productId - 1].value);
}
</script>

<!-- Navigation bar for dashboard.php -->
<nav>
	<ul>
		<li><a href="dashboard.php">Home</a></li>
		<li><a href="product.php">Products</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="about.php">About</a></li>
		<li><a href="contact.php">Contact Us</a></li>
	</ul>
</nav>
