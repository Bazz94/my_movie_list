<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/my_movie_list/php/constants.php';

if (!isset($new_movie_position, $old_movie_position)) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
  exit;
}

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

$connection->begin_transaction();

try {
  $temp = 101;
  // Set old to temp
  $stmt = $connection->prepare("UPDATE ranking SET `position` = ? WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('sss',$temp ,$user_id, $old);
  $stmt->execute();
  // Set new to old
  $stmt = $connection->prepare("UPDATE ranking SET `position` = ? WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('sss',$old_movie_position ,$user_id, $new);
  $stmt->execute();
  // Set old to new
  $stmt = $connection->prepare("UPDATE ranking SET `position` = ? WHERE `user_id` = ? AND `movie_id` = ?");
  $stmt->bind_param('sss',$new_movie_position ,$user_id, $old);
  $stmt->execute();

  $connection->commit();
} catch (mysqli_sql_exception $e) {
  $connection->rollback();
  $_SESSION['error'] = "Error executing swap movie positions";
  // Get error with mysqli_error($connection)
  header('Location: error.php');
  exit;
}

// Check to see if records were removed
if ($stmt->affected_rows < 1){
  $_SESSION['error'] = "No rows were removed";
  header('Location: error.php');
  exit;
}

// Close connections
$stmt->close();
$connection->close();

// Used to check if this script executed successfully
$successful = true;
?>