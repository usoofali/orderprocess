<?php
// Check if order ID and status are set in the query string
if(isset($_GET['order_id']) && isset($_GET['status'])) {
	$order_id = $_GET['order_id'];
	$status = $_GET['status'];
	
	// Update the order status in the database
	$sql = "UPDATE orders SET status='$status' WHERE id='$order_id'";
	
	if ($conn->query($sql) === TRUE) {
		echo "<p>Order status updated successfully</p>";
	} else {
		echo "<p>Error updating order status: " . $conn->error . "</p>";
	}
	
	// Redirect back to the admin_orders.php page
	header("Location: admin_orders.php");
	exit();
} else {
	echo "<p>Invalid order ID or status</p>";
}
?>
