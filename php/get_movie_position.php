<?php
require_once('php/constants.php');

//check that the required variables are assigned 
if (!isset($movie_id, $user_id)) {
  $_SESSION['error'] = 'Required variables not set get_movie_position.php';
  header('Location: error.php');
  exit;
}

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  header('Location: error.php');
  exit;
}

// Get position of movie
try {
  $stmt = $connection->prepare("SELECT `position` FROM ranking WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('ss', $user_id, $movie_id);
  $stmt->execute();
  $stmt->store_result();
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to executer get position';
  header('Location: error.php');
  exit;
}

// Check to see if records were found
if ($stmt->num_rows < 1){
  $_SESSION['error'] = "No rows were found";
  header('Location: error.php');
  exit;
}

//Set position to variable
$stmt->bind_result($position);
$stmt->fetch();

//close connections 
$stmt->close();
$connection->close();
?>