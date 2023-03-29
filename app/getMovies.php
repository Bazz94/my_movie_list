<?php 
require_once('../app/classes.php');
require_once('../app/constants.php');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . mysqli_connect_error();
  exit();
}

$community_Ranking = [];

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT movieid, title, _date FROM movies ORDER BY _weight DESC LIMIT 10')) {
  $stmt->execute();
  // Store the result so we can check if the account exists in the database.
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    //records do exist
    $stmt->bind_result($movieid, $title, $date);
    while ($stmt->fetch()) {
      $community_Ranking[] = new Movie($movieid, $title, $date);
    }
  } else {
    $_SESSION['error'] = 'There are no movies available';
  }
  $stmt->close();
} else {
  $_SESSION['error'] = 'Error preparing SQL statement: ' . mysqli_error($con);
}

define('COMMUNITY_RANKING', $community_Ranking);

?>