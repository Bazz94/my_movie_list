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

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("UPDATE movies SET `weight` = ROUND(`weight` + ?,2) WHERE `movie_id` = ?");

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('ds',$change ,$movie_id);

//check for prepare statement errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement";
    // Get error with mysqli_error($connection)
    header('Location: error.php');
    exit;
}

// Execute statement
$stmt->execute();

// Check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error";
  // Get error with $stmt->error
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