<?php
// Connect to the database
include('dbconnect.php');
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Fetch all records from the orders table
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Orders</title>
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
	
	<h1>Manage Orders</h1>
	
	<?php
	// Check if there are any orders to display
	if ($result->num_rows > 0) {
		// Output a list of orders with details and action links
		echo "<ul>";
		while($row = $result->fetch_assoc()) {
			$order_id = $row["id"];
			$date_created = $row["date_created"];
			$user_id = $row["user_id"];
			$order_status = $row["status"];
			$total_price = $row["total_price"];
			  
			// Fetch the username of the user who made the order
			$user_sql = "SELECT name FROM users WHERE id='$user_id'";
			$user_result = $conn->query($user_sql);
			$user_row = $user_result->fetch_assoc();
			$username = $user_row["name"];
			  
			// Output the order details and action links
			echo "<li>Order #$order_id created on $date_created by $username for a total of $$total_price with status being $order_status";
			echo "<ul><li><a href='change_order_status.php?order_id=$order_id&status=Completed'>Mark as Completed</a></li>";
			echo "<li><a href='change_order_status.php?order_id=$order_id&status=Cancelled'>Cancel Order</a></li></ul></li>";
		}
		echo "</ul>";
	} else {
		// Output a message if there are no orders to display
		echo "<p>No orders to display.</p>";
	}
	
	// Close the database connection
	$conn->close();
	?>
  

	<!-- Your code for the rest of the admin orders page goes here -->
  <!-- Search orders by user -->
<h2>Search Orders by User</h2>
<form method="POST" action="admin_orders.php">
	<label for="user_id">User:</label>
	<select name="user_id" id="user_id">
		<option value="">--Select User--</option>
		<?php
		// Fetch a list of all users
		$user_sql = "SELECT id, name FROM users";
		$user_result = $conn->query($user_sql);
		
		// Output a dropdown list of users to search by
		if ($user_result->num_rows > 0) {
			while($user_row = $user_result->fetch_assoc()) {
				$user_id = $user_row["id"];
				$username = $user_row["name"];
				echo "<option value='$user_id'>$username</option>";
			}
		}
		?>
	</select>
	<input type="submit" name="search_user" value="Search">
</form>

<?php
// Handle search by user form submission
if(isset($_POST['search_user'])) {
	$user_id = $_POST['user_id'];
	
	if(!empty($user_id)) {
		// Fetch orders for the selected user
		$search_sql = "SELECT * FROM orders WHERE user_id='$user_id'";
		$search_result = $conn->query($search_sql);
		
		// Output the search results
		if ($search_result->num_rows > 0) {
			echo "<h2>Orders by User: $user_id</h2>";
			echo "<ul>";
			while($row = $search_result->fetch_assoc()) {
				$order_id = $row["id"];
				$date_created = $row["date_created"];
				$user_id = $row["user_id"];
				$order_status = $row["status"];
				$total_price = $row["total_price"];
				
				// Fetch the username of the user who made the order
				$user_sql = "SELECT name FROM users WHERE id='$user_id'";
				$user_result = $conn->query($user_sql);
				$user_row = $user_result->fetch_assoc();
				$username = $user_row["name"];
				
				// Output the order details and action links
				echo "<li>Order #$order_id created on $date_created by $username for a total of $$total_price with status being $order_status";
				echo "<ul><li><a href='change_order_status.php?order_id=$order_id&status=Completed'>Mark as Completed</a></li>";
				echo "<li><a href='change_order_status.php?order_id=$order_id&status=Cancelled'>Cancel Order</a></li></ul></li>";
			}
			echo "</ul>";
		} else {
			echo "<p>No orders found for user #$user_id</p>";
		}
	} else {
		echo "<p>Please select a user to search by.</p>";
	}
}
?>

<!-- Filter orders by status -->
<h2>Filter Orders by Status</h2>
<form method="POST" action="admin_orders.php">
	<label for="status">Status:</label>
	<select name="status" id="status">
		<option value="">--Select Status--</option>
		<option value="pending">Pending</option>
		<option value="completed">Completed</option>
		<option value="cancelled">Cancelled</option>
	</select>
	<input type="submit" name="filter_status" value="Filter">
</form>
<?php
// Handle filter by status form submission
if(isset($_POST['filter_status'])) {
	$status = $_POST['status'];
	
	if(!empty($status)) {
		// Fetch orders with the selected status
		$filter_sql = "SELECT * FROM orders WHERE status='$status'";
		$filter_result = $conn->query($filter_sql);
		
		// Output the filter results
		if ($filter_result->num_rows > 0) {
			echo "<h2>Orders with Status: $status</h2>";
			echo "<ul>";
			while($row = $filter_result->fetch_assoc()) {
				$order_id = $row["id"];
				$date_created = $row["date_created"];
				$user_id = $row["user_id"];
				$order_status = $row["status"];
				$total_price = $row["total_price"];
				
				// Fetch the username of the user who made the order
				$user_sql = "SELECT username FROM users WHERE id='$user_id'";
				$user_result = $conn->query($user_sql);
				$user_row = $user_result->fetch_assoc();
				$username = $user_row["username"];
				
				// Output the order details and action links
				echo "<li>Order #$order_id created on $date_created by $username for a total of $$total_price with status being $order_status";
				echo "<ul><li><a href='change_order_status.php?order_id=$order_id&status=Completed'>Mark as Completed</a></li>";
				echo "<li><a href='change_order_status.php?order_id=$order_id&status=Cancelled'>Cancel Order</a></li></ul></li>";
			}
			echo "</ul>";
			} else {
			echo "<p>No orders found with status '$status'</p>";
			}
	} else {
		echo "<p>Please select a status to filter by.</p>";
	}
}
?>

<!-- List all orders -->
<h2>All Orders</h2>
<?php
// Fetch all orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Output the list of orders
if ($result->num_rows > 0) {
	echo "<ul>";
	while($row = $result->fetch_assoc()) {
		$order_id = $row["id"];
		$date_created = $row["date_created"];
		$user_id = $row["user_id"];
		$total_price = $row["total_price"];
		$status = $row["status"];
		
		// Fetch the username of the user who made the order
		$user_sql = "SELECT username FROM users WHERE id='$user_id'";
		$user_result = $conn->query($user_sql);
		$user_row = $user_result->fetch_assoc();
		$username = $user_row["username"];
		
		// Output the order details and action links
		echo "<li>Order #$order_id created on $date_created by $username for a total of $$total_price  with status being $order_status";
		echo "<ul><li><a href='change_order_status.php?order_id=$order_id&status=completed'>Mark as Completed</a></li>";
		echo "<li><a href='change_order_status.php?order_id=$order_id&status=cancelled'>Cancel Order</a></li></ul></li>";
	}
	echo "</ul>";
} else {
	echo "<p>No orders found.</p>";
}
?>


	
</body>
</html>
