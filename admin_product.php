<!DOCTYPE html>
<html>
<head>
	<title>Admin Products</title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="admin_dashboard.php">Home</a></li>
			<li><a href="admin_products.php">Products</a></li>
			<li><a href="admin_orders.php">Manage Orders</a></li>
			<li><a href="admin_users.php">Manage Users</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</nav>
	
	<h1>Manage Products</h1>

	<!-- Section 1: Create new product -->
	<h2>Create New Product</h2>
	<form action="create_product.php" method="POST">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required><br>

		<label for="description">Description:</label>
		<textarea id="description" name="description" required></textarea><br>

		<label for="price">Price:</label>
		<input type="number" id="price" name="price" min="0" step="0.01" required><br>
		
		<label for="available">Available:</label>
		<input type="number" id="available" name="available" min="0" step="0.01" required><br>
		
		<label for="image">Available:</label>
		<input type="file" id="image" name="image" min="0" step="0.01" required><br>

		<input type="submit" value="Create Product">
	</form>

	<!-- Section 3: List of product details -->
	<h2>List of Products</h2>
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Description</th>
			<th>Price</th>
			<th>Available</th>
			<th>Actions</th>
		</tr>
		<!-- Your PHP code to retrieve and display product details goes here -->
    <?php
// Connect to the database
include("dbconnect.php");
// Check for errors
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Query the database for products
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
	die("Error: " . mysqli_error($conn));
}

// Loop through the results and display each product in a table row
while ($row = mysqli_fetch_assoc($result)) {
	echo "<tr>";
	echo "<td>" . $row['id'] . "</td>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['description'] . "</td>";
	echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['available'] . "</td>";
	echo "<td><a href='edit_product.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_product.php?id=" . $row['id'] . "'>Delete</a></td>";
	echo "</tr>";
}

// Close the database connection
mysqli_close($conn);
?>

	</table>
	
</body>
</html>
