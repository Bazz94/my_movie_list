<?php
require_once('php/constants.php');

// Check that the required variables are assigned 
if (!isset($_SESSION['user-id'], $movie_id, $new_position)) {
  $_SESSION['error'] = 'Required variables not set add_movie.php';
  header('Location: error.php');
  exit;
}

$user_id = $_SESSION['user-id'];

error_log($movie_id);

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
  exit;
}

// Check to see if movie already exists in database
try {
  $stmt = $connection->prepare('SELECT `movie_id` FROM ranking WHERE `movie_id` = ? AND `user_id` = ?');
  $stmt->bind_param('ss', $movie_id, $user_id);
  $stmt->execute();
  $stmt->store_result();
} catch (mysqli_sql_exception $e) {
  $_SESSION['error'] = 'Failed to execute add movies';
  header('Location: error.php');
  exit;
}

// Check result
if ($stmt->num_rows != 0) {
  $_SESSION['error'] = 'Movie already exists in list';
  header('Location: user.php');
  exit;
}

// Prepare and execute
try {
  $stmt = $connection->prepare("INSERT INTO ranking (`user_id`, `movie_id`, `position`) 
                                Select ?, ?, (SELECT COUNT(*) + 1 FROM ranking WHERE `user_id` = ?)");
  $stmt->bind_param('sss', $user_id, $movie_id, $user_id);
  $stmt->execute();
} catch (mysqli_sql_exception $e) {
  $_SESSION['error'] = 'Failed to execute add movies';
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

//update weight in movies
$old_position = 101;  //this makes the weight 0;
require('php/update_movie_weight.php'); //requires $new_position to be set
if (!isset($successful)) {
  $_SESSION['error'] = 'Movie weight updated failed';
  header('Location: error.php');
  exit;
}
?>