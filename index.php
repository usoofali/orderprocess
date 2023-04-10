<?php
session_start();
if(isset($_SESSION['user_id'])){
  header('Location: dashboard.php');
}

if(isset($_SESSION['admin_id'])){
  header('Location: admin_dashboard.php');
}

$errors = [];

// Connect to database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// User login
if(isset($_POST['user_login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

  if(mysqli_num_rows($result) == 1){
    $_SESSION['user_id'] = $user['id'];
    header('Location: dashboard.php');
  } else {
    array_push($errors, "Wrong email/password combination");
  }
}

// Admin login
if(isset($_POST['admin_login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $query);
  $admin = mysqli_fetch_assoc($result);

  if(mysqli_num_rows($result) == 1){
    $_SESSION['admin_id'] = $admin['id'];
    header('Location: admin_dashboard.php');
  } else {
    array_push($errors, "Wrong email/password combination");
  }
}

// User sign up
if(isset($_POST['user_signup'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];

  // Validate form data
  if(empty($name)) { array_push($errors, "Name is required"); }
  if(empty($email)) { array_push($errors, "Email is required"); }
  if(empty($password_1)) { array_push($errors, "Password is required"); }
  if($password_1 != $password_2) { array_push($errors, "Passwords do not match"); }

  // Check if email is already taken
  $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $email_check_query);
  $user = mysqli_fetch_assoc($result);

  if($user){
    array_push($errors, "Email already exists");
  }

  // Insert user into database
  if(count($errors) == 0){
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password_1')";
    mysqli_query($conn, $query);

    $_SESSION['user_id'] = mysqli_insert_id($conn);
    header('Location: dashboard.php');
  }
}

// Forget password
if(isset($_POST['forget_password'])){
  $email = $_POST['email'];

  // Check if email exists in database
  $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $email_check_query);
  $user = mysqli_fetch_assoc($result);

  if(!$user){
    array_push($errors, "Email does not exist");
  }

  // Send password reset email to user
  if(count($errors) == 0){
// Code to send password reset email
// ...
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Authentication</title>
</head>
<body>
	<h1>User Authentication</h1>
  <?php if(count($errors) > 0): ?>
	<div>
		<?php foreach($errors as $error): ?>
			<p><?php echo $error ?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>

<form method="post" action="index.php">
	<h2>User Login</h2>
	<label>Email:</label>
	<input type="email" name="email" required><br><br>
	<label>Password:</label>
	<input type="password" name="password" required><br><br>
	<button type="submit" name="user_login">Login</button>
</form>

<form method="post" action="index.php">
	<h2>Admin Login</h2>
	<label>Email:</label>
	<input type="email" name="email" required><br><br>
	<label>Password:</label>
	<input type="password" name="password" required><br><br>
	<button type="submit" name="admin_login">Login</button>
</form>

<form method="post" action="index.php">
	<h2>User Sign up</h2>
	<label>Name:</label>
	<input type="text" name="name" required><br><br>
	<label>Email:</label>
	<input type="email" name="email" required><br><br>
	<label>Password:</label>
	<input type="password" name="password_1" required><br><br>
	<label>Confirm Password:</label>
	<input type="password" name="password_2" required><br><br>
	<button type="submit" name="user_signup">Sign up</button>
</form>

<form method="post" action="index.php">
	<h2>Forget Password</h2>
	<label>Email:</label>
	<input type="email" name="email" required><br><br>
	<button type="submit" name="forget_password">Reset Password</button>
</form>
</body>
</html>
