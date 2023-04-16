<?php 
require_once('php/classes.php');
require_once('php/constants.php');
$community_Ranking = [];

//connect to database
try {
  $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to Movies Database';
  // $e->getMessage();
  header('Location: error.php');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare('SELECT `movie_id`, `title`, `date`, `poster` FROM movies ORDER BY `weight` DESC, `title` ASC LIMIT 100');

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

//Check to see if any rows were affected
if ($stmt->num_rows < 1) {
  $_SESSION['error'] = 'There are no movies available';
  header('Location: error.php');
}

// Set results to an array
$stmt->bind_result($movieid, $title, $date, $poster);
while ($stmt->fetch()) {
  $community_Ranking[] = new Movie($movieid, $title, $date, $poster);
}

//Add to session data
$_SESSION['community-movies'] = $community_Ranking;

//close connections 
$stmt->close();
$connection->close();
?>