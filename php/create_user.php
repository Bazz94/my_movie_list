<?php
require('php/constants.php');

// Check to see if the required data was submitted
if (!isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passwordCheck'])) {
  // Could not get the data that should have been sent.
  $_SESSION['error'] = 'Failed to retrieve form data';
  header('Location: signup.php');
}

// Connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // $e->getMessage();
  header('Location: error.php');
}

//Hash password
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("INSERT INTO users (`user_id`, `username`, `password`, `email`) 
  VALUES (UUID_SHORT(), ?, ?, ?) ");

// Bind parameters (s for string)
$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);

//check for prepare statement errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement";
    // mysqli_error($connection)
    header('Location: error.php');
}

// Execute statement
$stmt->execute();

//check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error";
  // $stmt->error
  header('Location: error.php');
}

// Check to see if records were added
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were added";
  header('Location: error.php');
} 

$stmt->close();
$connection->close();

// Login the created user
include('php/authenticate.php');
?>