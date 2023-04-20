<?php
require_once('php/constants.php');

// Check that the required variables are assigned 
if (!isset($movie_id, $_SESSION['user-id'])) {
  $_SESSION['error'] = 'Required variables not set remove_movie.php';
  header('Location: error.php');
  exit;
}

// Get position
$user_id = $_SESSION['user-id'];
require('php/get_movie_position.php');
if (!isset($position)) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
  exit;
}
$old_movie_position = $position;

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

// Remove movie from user list
try {
  $stmt = $connection->prepare("DELETE FROM ranking WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('ss', $user_id, $movie_id);
  $stmt->execute();
} catch (mysqli_sql_exception $e) {
  $_SESSION['error'] = 'Failed to executer remove movie';
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

// Update weight in movies
$new_position = 101;  //this makes the weight 0;
$old_position = $old_movie_position; 
require('php/update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
  exit;
}
?>