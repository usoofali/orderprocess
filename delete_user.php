<?php
// Start session and check if the user is authenticated as admin
session_start();
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: index.php');
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

// Delete the user from the database
$query = "DELETE FROM users WHERE id = $id AND role='user'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error deleting user: " . mysqli_error($conn);
} else {
    header('Location: admin_users.php');
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
