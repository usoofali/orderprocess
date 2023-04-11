<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
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
	
	<h1>Welcome to the Admin Dashboard!</h1>
	<?php
// Connect to the database
include("dbconnect.php");

// Check for errors
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
	// Retrieve the product details from the form
	$id = $_POST['id'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$available = $_POST['available'];

	// Update the product in the database
	$sql = "UPDATE product SET name='$name', description='$description', price='$price', available='$available' WHERE id=$id";
	$result = mysqli_query($conn, $sql);

	// Check for errors
	if (!$result) {
		die("Error: " . mysqli_error($conn));
	}

	// Redirect back to the product page
	header("Location: admin_product.php");
	exit;
}

// Retrieve the product ID from the URL
$id = $_GET['id'];

// Query the database for the product with the specified ID
$sql = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
	die("Error: " . mysqli_error($conn));
}

// Retrieve the product details from the database
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$description = $row['description'];
$price = $row['price'];
$available = $row['available'];

// Close the database connection
mysqli_close($conn);
?>

<!-- Display the form for editing the product details -->
<form method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<label>Name:</label>
	<input type="text" name="name" value="<?php echo $name; ?>">
	<label>Description:</label>
	<textarea name="description"><?php echo $description; ?></textarea>
	<label>Price:</label>
	<input type="number" name="price" value="<?php echo $price; ?>">
	<label>Available:</label>
	<input type="number" name="available" value="<?php echo $available; ?>">
	<input type="submit" name="submit" value="Save Changes">
</form>

	
</body>
</html>
