<?php
// Start session and check if the user is authenticated as admin
session_start();
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Connect to the database
include('dbconnect.php');

// Get the user ID from the URL parameter
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: admin_users.php');
    exit();
}

// Fetch the user data from the database
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: admin_users.php');
    exit();
}

$row = mysqli_fetch_assoc($result);

// If the form was submitted, update the user data in the database
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error updating user: " . mysqli_error($conn);
    } else {
        header('Location: admin_users.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
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
	
	<h1>Edit User</h1>
	
	<form method="post">
		<label>Name:</label>
		<input type="text" name="name" value="<?php echo $row['name']; ?>">
		<br>
		
		<label>Email:</label>
		<input type="email" name="email" value="<?php echo $row['email']; ?>">
		<br>
		
		<label>Role:</label>
		<select name="role">
			<option value="user" <?php if ($row['role'] == 'user') { echo 'selected'; } ?>>User</option>
			<option value="admin" <?php if ($row['role'] == 'admin') { echo 'selected'; } ?>>Admin</option>
		</select>
		<br>
		
		<input type="submit" name="submit" value="Save">
	</form>
	
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
