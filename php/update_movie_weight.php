<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/my_movie_list/php/constants.php';

// Check that the required variables are assigned 
if (!isset($new_position, $old_position, $movie_id)) {
  $_SESSION['error'] = 'Required variables not set update_movie_weight.php';
  header('Location: error.php');
  exit;
}

// Calculate weight change
$change = 0;
$new_position_weight = ($new_position / -100) + 1.01;
$old_position_weight = ($old_position / -100) + 1.01;
$change = $new_position_weight - $old_position_weight;

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

// Update movie weight in movies database
try {
  $stmt = $connection->prepare("UPDATE movies SET `weight` = ROUND(`weight` + ?,2) WHERE `movie_id` = ?");
  $stmt->bind_param('ds',$change ,$movie_id);
  $stmt->execute();  
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to execute update movie database';
  // Get error with $e->getMessage();
  header('Location: error.php');
  exit;
}

// Check to see if records were updated
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were updated";
  header('Location: error.php');
  exit;
} 

// Close connections
$stmt->close();
$connection->close();

// Used to check if this script executed successfully
$successful = true;
?>