<?php
if (!isset($_SESSION['userid'], $_POST['newMovie'], $new_position)) {
  echo 'In add_movie.php on error line 2';
  exit();
}
$user_id = $_SESSION['userid'];
$movie_id= $_POST['newMovie'];

//update weight in movies
//uses $new_position
$old_position = 101;  //this makes the weight 0;
include '../app/update_movie_weight.php';
if (!isset($successful)) {
  echo 'In add_movie.php on error line 21';
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
$stmt = $connection->prepare("INSERT INTO ranking (`user`, movie, position) 
  Select ?, ?, (SELECT COUNT(*) + 1 FROM ranking WHERE user = ?)");

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('sss', $user_id, $movie_id, $user_id);

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