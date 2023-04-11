<!DOCTYPE html>
<html>
<head>
	<title>Orders</title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="dashboard.php">Home</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="orders.php">Orders</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="contact.php">Contact Us</a></li>
		</ul>
	</nav>
	
	<h1>My Orders</h1>
	
	<?php
		// Connect to the database
		include(dbconnect.php);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		// Get the user's orders
		session_start();
		$user_id = $_SESSION["user_id"];
		$sql = "SELECT * FROM orders WHERE user_id='$user_id'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			// Display each order in a table
			while ($row = mysqli_fetch_assoc($result)) {
				$order_id = $row["order_id"];
				$order_date = $row["order_date"];
				$total_price = $row["total_price"];
				
				echo "<h2>Order #$order_id</h2>";
				echo "<p>Order Date: $order_date</p>";
				echo "<p>Total Price: $total_price</p>";
				
				// Get the items ordered in this order
				$sql2 = "SELECT * FROM order_items WHERE order_id='$order_id'";
				$result2 = mysqli_query($conn, $sql2);
				
				if (mysqli_num_rows($result2) > 0) {
					// Display each item in a table
					echo "<table>";
					echo "<tr><th>Product</th><th>Quantity</th><th>Price</th></tr>";
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$product_id = $row2["product_id"];
						$quantity = $row2["quantity"];
						$price = $row2["price"];
						
						// Get the product name
						$sql3 = "SELECT name FROM products WHERE product_id='$product_id'";
						$result3 = mysqli_query($conn, $sql3);
						$row3 = mysqli_fetch_assoc($result3);
						$product_name = $row3["name"];
						
						echo "<tr><td>$product_name</td><td>$quantity</td><td>$price</td></tr>";
					}
					echo "</table>";
				} else {
					echo "<p>No items found for this order.</p>";
				}
			}
		} else {
			echo "<p>No orders found for this user.</p>";
		}
		
		// Close the database connection
		mysqli_close($conn);
	?>
	
	<!-- Your code for the rest of the orders page goes here -->
	
</body>
</html>
