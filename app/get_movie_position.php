<?php
require_once('constants.php');

//check that the required variables are assigned 
if (!isset($movie_id, $user_id)) {
  $_SESSION['error'] = 'Required variables not set get_movie_position.php';
  header('Location: error.php');
}

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to User Database';
  // $e->getMessage();
  header('Location: error.php');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("SELECT `position` FROM ranking WHERE `user_id` = ? AND `movie_id` = ?");

// Bind parameters (s for string)
$stmt->bind_param('ss', $user_id, $movie_id);

//check for prepare statement errors
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

// Check to see if records were found
if ($stmt->num_rows < 1){
  $_SESSION['error'] = "No rows were found";
  header('Location: error.php');
}

//Set position to variable
$stmt->bind_result($position);
$stmt->fetch();

//close connections 
$stmt->close();
$connection->close();
?>