<?php
// Get constants
require('../app/constants.php');
// Try and connect using the info above.
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_error) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . $connection->connect_error;
  exit();
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passwordCheck'])) {
  // Could not get the data that should have been sent.
  $_SESSION['error'] = 'Failed to retrieve form data: ';
  exit();
}

$password = crypt($_POST['password'],'2394a9661a9089208c1c9c65ccac85a91da6a859');

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("INSERT INTO `users` (`userid`, `username`, `_password`, `email`) 
  VALUES (UUID_SHORT(), ?, ?, ?) ");

if (!$stmt) {
    $_SESSION['error'] = "Error: " . mysqli_error($connection);
    exit();
}

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);

// Execute statement
$stmt->execute();

if ($stmt->errno) {
    $_SESSION['error'] = "Error: " . $stmt->error;
    exit();
}

// Get number of affected rows
$num_rows = $stmt->affected_rows;
if ($num_rows != 1){
  $_SESSION['error'] = "Error: affected rows incorrect " . $num_rows;
  exit();
} 

$stmt->close();
$connection->close();

// Login
include('../app/authenticate.php');
?>