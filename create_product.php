<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = $_POST["price"];
  $available = $_POST["available"];
  $image = $_FILES["image"]["name"];

  // Connect to the MySQL database
  include("dbconnect.php");

  // Check if the connection was successful
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare and execute the SQL statement to insert the new product
  $sql = "INSERT INTO product (name, description, price, available, image) VALUES ('$name', '$description', $price, $available, '$image')";
  if ($conn->query($sql) === TRUE) {
    echo "Product created successfully";
  } else {
    echo "Error creating product: " . $conn->error;
  }

  // Close the database connection
  $conn->close();
}
?>
