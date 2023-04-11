<?php
// Start session and check if the user is authenticated as admin
session_start();
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database
$conn = mysqli_connect('localhost', 'username', 'password', 'order');

// Fetch all records from the users table
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Users</title>
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
	
	<h1>Manage Users</h1>
	
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Role</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_assoc($result)) { ?>
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['role']; ?></td>
					<td>
						<a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
						<a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<a href="add_user.php">Add User</a>
	
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
