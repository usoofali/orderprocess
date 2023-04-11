<?php
// Include database connection
include 'db_config.php';

// Select all products from the product table
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

// Check if any products were found
if (mysqli_num_rows($result) > 0) {
	// Display the products in a scrollable list
	echo '<div style="overflow-y: scroll; height: 400px;">';
	while ($row = mysqli_fetch_assoc($result)) {
		echo '<div>';
		echo '<h3>' . $row['name'] . '</h3>';
		echo '<p>Description: ' . $row['description'] . '</p>';
		echo '<p>Price: $' . $row['price'] . '</p>';
		echo '<form method="post" action="add_to_cart.php">';
		echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
		echo '<label for="quantity">Quantity:</label>';
		echo '<select name="quantity" id="quantity">';
		for ($i = 1; $i <= 10; $i++) {
			echo '<option value="' . $i . '">' . $i . '</option>';
		}
		echo '</select>';
		echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
		echo '</form>';
		echo '</div>';
	}
	echo '</div>';
} else {
	// If no products were found, display an error message
	echo '<p>No products found.</p>';
}
?>

