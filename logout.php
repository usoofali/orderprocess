<?php
// Start session
session_start();

// Clear session data
session_unset();

// Destroy session
session_destroy();

// Redirect to login page
header('Location: index.php');
exit();
?>
