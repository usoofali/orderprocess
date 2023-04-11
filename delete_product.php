<?php
// Connect to the database
include("dbconnect.php");

// Check for errors
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product ID from the URL
$id = $_GET['id'];

// Delete the product from the database
$sql = "DELETE FROM product WHERE id=$id";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
	die("Error: " . mysqli_error($conn));
}

// Redirect back to the product page
header("Location: admin_product.php");
exit;

// Close the database connection
mysqli_close($conn);
?>
