<?php
ob_start();
require_once('php/constants.php');

// Check that the required variables are assigned 
if (!isset($_SESSION['user-id'], $_POST['newMovie'], $new_position)) {
  $_SESSION['error'] = 'Required variables not set add_movie.php';
  header('Location: error.php');
}

$user_id = $_SESSION['user-id'];
$movie_id = $_POST['newMovie'];

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
}

// See if movie already exists in databasess
$stmt = $connection->prepare('SELECT `movie_id` FROM ranking WHERE `movie_id` = ? AND `user_id` = ?');

// Bind parameters (s for string)
$stmt->bind_param('ss', $movie_id, $user_id);

//check for errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement: " . mysqli_error($connection);
    header('Location: error.php');
}

// Execute statement
$stmt->execute();

//check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error: " . $stmt->error;
  header('Location: error.php');
}

//store to use data
$stmt->store_result();

//Check to see if the movie already exists
if ($stmt->num_rows != 0) {
  $_SESSION['error'] = 'Movie already exists in list';
  header('Location: user.php');
}

//update weight in movies
$old_position = 101;  //this makes the weight 0;
require('php/update_movie_weight.php'); //requres $new_position to be set
if (!isset($successful)) {
  $_SESSION['error'] = 'Movie weight updated failed';
  header('Location: error.php');
}

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // Get error with $e->getMessage();
  header('Location: error.php');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("INSERT INTO ranking (`user_id`, `movie_id`, `position`) 
  Select ?, ?, (SELECT COUNT(*) + 1 FROM ranking WHERE `user_id` = ?)");

// Bind parameters (s for string)
$stmt->bind_param('sss', $user_id, $movie_id, $user_id);

//check for prepare statement errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement";
    // Get error with mysqli_error($connection)
    header('Location: error.php');
}

// Execute statement
$stmt->execute();

//check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error";
  // Get error with $stmt->error
  header('Location: error.php');
}

// Check to see if records were updated
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were updated";
  header('Location: error.php');
}

// Close connections
$stmt->close();
$connection->close();
ob_end_flush();
?>