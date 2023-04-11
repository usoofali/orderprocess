<!DOCTYPE html>
<html>
<head>
	<title>Product Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
	<div class="container">
		<h1>Products</h1>
		<form method="post" action="payment.php">
			<?php
				// Connect to the database
				include('dbconnect.php');
				if (!$conn) {
				    die("Connection failed: " . mysqli_connect_error());
				}

				// Select all products from the products table
				$sql = "SELECT * FROM products";
				$result = mysqli_query($conn, $sql);

				// Display all products in a scrollable list
				while($row = mysqli_fetch_assoc($result)) {
					echo '<div class="product">';
					echo '<img src="' . $row['picture'] . '">';
					echo '<h2>' . $row['name'] . '</h2>';
					echo '<p>' . $row['description'] . '</p>';
					echo '<p>$' . $row['price'] . '</p>';
					echo '<input type="number" min="1" name="quantity[' . $row['id'] . ']" value="1">';
					echo '<input type="radio" name="selected_product" value="' . $row['id'] . '">';
					echo '</div>';
				}

				// Close the database connection
				mysqli_close($conn);
			?>

			<button type="submit" name="submit">Proceed to Payment</button>
		</form>
	</div>
</body>
</html>
