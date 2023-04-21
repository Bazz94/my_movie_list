<?php
require_once('php/constants.php');

// Check that the required variables are assigned 
if (!isset($movie_id, $movie_position, $user_id)) {
  $_SESSION['error'] = 'Required variables not set update_movie_position.php';
  header('Location: error.php');
  exit;
}

// Connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
  exit;
}

// Update the position of a movie in the user movie list
try {
  $stmt = $connection->prepare("UPDATE ranking SET `position` = ? WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('sss',$movie_position ,$user_id, $movie_id);
  $stmt->execute();
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
  exit;
}

// Check to see if records were removed
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were removed";
  header('Location: error.php');
  exit;
}

// Close connections
$stmt->close();
$connection->close();

// Used to check if this script executed successfully
$successful = true;
?>