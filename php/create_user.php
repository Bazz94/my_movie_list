<?php
require_once('php/constants.php');

// Check to see if the required data was submitted
if (!isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password-Check'])) {
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
  exit;
}

// See if email already exists
try {
  $stmt = $connection->prepare('SELECT `email` FROM users WHERE `email` = ?'); 
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  $stmt->store_result();
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to execute find email';
  // $e->getMessage();
  header('Location: error.php');
  exit;
}

// Check to see if email already exist 
if ($stmt->num_rows > 0) {
  $_SESSION['error'] = 'An account for this email already exists';
} else {
  //Hash password
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  try {
    $stmt = $connection->prepare("INSERT INTO users (`user_id`, `username`, `password`, `email`) 
      VALUES (UUID_SHORT(), ?, ?, ?) ");
    $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
    $stmt->execute();
  } catch (mysqli_sql_exception $e) {
    // If there is an error with the connection, stop the script and display the error.
    $_SESSION['error'] = 'Failed to execute create user';
    // $e->getMessage();
    header('Location: error.php');
    exit;
  }

  // Check to see if records were added
  if ($stmt->affected_rows < 1){
    $_SESSION['error'] = "No rows were added";
    header('Location: error.php');
    exit;
  } 

  // Login the created user
  require('php/authenticate.php');
}

$stmt->close();
$connection->close();
?>