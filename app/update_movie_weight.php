<?php
if (!isset($new_position, $old_position, $movie_id)) {
  echo 'In update_movie_weight.php on error line 2';
  exit();
}

//calculate weight change
$change = 0;
$new_position_weight = ($new_position / -100) + 1.01;
$old_position_weight = ($old_position / -100) + 1.01;
$change = $new_position_weight - $old_position_weight;

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
$stmt = $connection->prepare("UPDATE `movies` SET `_weight` = ROUND(_weight + ?,2) WHERE movieid = ?");

// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
$stmt->bind_param('ds',$change ,$movie_id);

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