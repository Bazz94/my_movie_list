<?php
if (!isset($movie_id,$movie_position,$user_id)) {
  exit();
}

//replace position in db

// Get constants
require_once('constants.php');
// Try and connect using the info above.
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_error) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . $connection->connect_error;
  exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare("UPDATE `ranking` SET `position`= ? WHERE user = ? AND movie = ?");

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('sss',$movie_position ,$user_id, $movie_id);

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
$successful = true;
?>