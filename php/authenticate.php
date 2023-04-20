<?php
require_once('php/constants.php');

// Check to see if the required data was submitted
if (!isset($_POST['email'], $_POST['password'])) {
  // Could not get the data that should have been sent.
  $_SESSION['error'] = 'Failed to retrieve form data';
  header('Location: login.php');
  exit;
}

// Connect to database
try {
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to the User Database';
  header('Location: error.php');
  exit;
}

// Look for email in database
try {
  $stmt = $connection->prepare('SELECT `user_id`, `password`, `username` FROM users WHERE `email` = ?'); 
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  $stmt->store_result();
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to execute authenticate user';
  header('Location: error.php');
  exit;
}

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