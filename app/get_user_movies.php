<?php 
require_once('../app/classes.php');
require_once('../app/constants.php');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . mysqli_connect_error();
  exit();
}

$user_Ranking= [];

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT movies.movieid, movies.title, movies._date, movies.poster
                          FROM ranking
                          JOIN movies ON ranking.movie = movies.movieid
                          WHERE ranking.user = ?
                          ORDER BY ranking.position'
)) {
  $stmt->bind_param('s', $_SESSION['userid']);
  $stmt->execute();
  // Store the result so we can check if the account exists in the database.
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    //records do exist
    $stmt->bind_result($movieid, $title, $date, $poster);
    while ($stmt->fetch()) {
      $user_Ranking[] = new Movie($movieid, $title, $date, $poster);
    }
  }
} else {
  $_SESSION['error'] = 'Error preparing SQL statement: ' . mysqli_error($con);
}
$stmt->close();
$_SESSION['user-movies'] = $user_Ranking;
?>