<?php
if (!isset($movie_id, $_SESSION['userid'])) {
  echo 'In remove_movie.php on error line 3';
  exit();
}

//get position
$user_id = $_SESSION['userid'];
include '../app/get_movie_position.php';
if (!isset($position)) {
  echo 'In remove_movie.php on error line 10';
  exit();
}
$old_movie_position = $position;

//update weight in movies
$new_position = 101;  //this makes the weight 0;
$old_position = $old_movie_position; 
include '../app/update_movie_weight.php';
if (!isset($successful)) {
  echo 'In remove_movie.php on error line 21';
  exit();
}


// Get constants
require_once('../app/constants.php');
// Try and connect using the info above.
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_error) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . $connection->connect_error;
  exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("DELETE FROM `ranking` WHERE user = ? AND movie = ?");

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('ss', $user_id, $movie_id);

if (!$stmt) {
    $_SESSION['error'] = "Error: " . mysqli_error($connection);
    exit();
}

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
?>