<?php
require_once('../app/constants.php');

// Check that the required variables are assigned 
if (!isset($movie_id, $_SESSION['user-id'])) {
  $_SESSION['error'] = 'Required variables not set remove_movie.php';
  header('Location: error.php');
}

// Get position
$user_id = $_SESSION['user-id'];
include('../app/get_movie_position.php');
if (!isset($position)) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
}
$old_movie_position = $position;

// Update weight in movies
$new_position = 101;  //this makes the weight 0;
$old_position = $old_movie_position; 
include('../app/update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
}

// Connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("DELETE FROM ranking WHERE `user_id` = ? AND `movie_id` = ?");

// Bind parameters (s for string)
$stmt->bind_param('ss', $user_id, $movie_id);

// Check for prepare statement errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement";
    // Get error with mysqli_error($connection)
    header('Location: error.php');
}

// Execute statement
$stmt->execute();

// Check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error";
  // Get error with $stmt->error
  header('Location: error.php');
}

// Check to see if records were removed
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were removed";
  header('Location: error.php');
}

// Close connections
$stmt->close();
$connection->close();
?>