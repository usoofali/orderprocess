<!DOCTYPE html>
<html>
<head>
	<title>Payment Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<<nav>
		<ul>
			<li><a href="dashboard.php">Home</a></li>
			<li><a href="product.php">Products</a></li>
			<li><a href="orders.php">Orders</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="contact.php">Contact Us</a></li>
		</ul>
	</nav>

	<div class="container">
		<h1>Payment</h1>
		<?php
			session_start();
			// Connect to the database
			include('dbconnect.php');
			if (!$conn) {
			    die("Connection failed: " . mysqli_connect_error());
			}

			// Insert the order information into the orders table
			$user_id = $_SESSION['user_id'];; // replace with the actual user id
			$sql = "INSERT INTO orders (user_id, status) VALUES ($user_id, 'paid')";
			if (mysqli_query($conn, $sql)) {
			    $order_id = mysqli_insert_id($conn);

			    // Insert the order items into the order_items table
			    foreach ($_POST['selected_product'] as $product_id) {
			    	$quantity = $_POST['quantity'][$product_id];
				$price = 
			    	$sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $product_id, $quantity)";
			    	mysqli_query($conn, $sql);
			    }

			    // Update the order status to "complete"
// 			    $sql = "UPDATE orders SET status='complete' WHERE id=$order_id";
// 			    mysqli_query($conn, $sql);

			    // Display a message to the user confirming the purchase
			    echo '<p>Thank you for making the order!</p>';
			} else {
			    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			// Close the database connection
			mysqli_close($conn);
		?>
	</div>
</body>
</html>
