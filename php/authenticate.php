<?php
require_once('php/constants.php');

// Check to see if the required data was submitted
if (!isset($_POST['email'], $_POST['password'])) {
  // Could not get the data that should have been sent.
  $_SESSION['error'] = 'Failed to retrieve form data';
  header('Location: login.php');
}

//connect to database
try {
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to the User Database';
  header('Location: error.php');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare('SELECT `user_id`, `password`, `username` FROM users WHERE `email` = ?'); 

// Bind parameters (s for string)
$stmt->bind_param('s', $_POST['email']);

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

//store to use data
$stmt->store_result();

//Check if account was found in database
if ($stmt->num_rows > 0) {
  $stmt->bind_result($id, $password, $username);
  $stmt->fetch();
  // Account exists, now we verify the password.
  if (password_verify($_POST['password'], $password)) {
    session_regenerate_id();
    $_SESSION['logged-in'] = TRUE;
    $_SESSION['username'] = $username;
    $_SESSION['user-id'] = $id;
    $_SESSION['email'] = $_POST['email'];
    header('Location: home.php');
  } else {
    //password was incorrect
    $_SESSION['error'] = 'Password or Email is incorrect';

  }
} else {
  //email does not exist 
  $_SESSION['error'] = 'Password or Email is incorrect';
}

//close connections
$stmt->close();
$connection->close();
?>