<?php 
require_once('php/classes.php');
require_once('php/constants.php');
$user_Ranking= [];

//connect to database
try {
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to the users Movies Database';
  header('Location: error.php');
  exit;
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
$stmt = $connection->prepare('SELECT movies.movie_id, movies.title, movies.date, movies.poster
                              FROM ranking
                              JOIN movies ON ranking.movie_id = movies.movie_id
                              WHERE ranking.user_id = ?
                              ORDER BY ranking.position'); 

$stmt->bind_param('s', $_SESSION['user-id']);

//check for errors
if (!$stmt) {
    $_SESSION['error'] = "Error preparing sql statement: " . mysqli_error($connection);
    header('Location: error.php');
    exit;
}

// Execute statement
$stmt->execute();

//check for execution errors
if ($stmt->errno) {
  $_SESSION['error'] = "SQL Execution Error: " . $stmt->error;
  header('Location: error.php');
  exit;
}

//store to use data
$stmt->store_result();

// Set results to an array
$stmt->bind_result($movieid, $title, $date, $poster);
while ($stmt->fetch()) {
  $user_Ranking[] = new Movie($movieid, $title, $date, $poster);
}

//Add to session data
$_SESSION['user-movies'] = $user_Ranking;

//close connections 
$stmt->close();
$connection->close();
?>