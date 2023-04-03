<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once '../app/classes.php';
session_start();

// not logged in
if (!isset($_SESSION['loggedin'])) {
  header('Location: home.php');
}
// if pressed logout
if(isset($_POST['logout'])){
  echo "please log out";
  include('../app/logout.php'); // goes to home page
}
// Check if data is in SESSION movies
if (!isset($_SESSION['movies'])) {
  header('Location: index.php');
}
// first visit
?>

<!DOCTYPE html>
<html>

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/user.css">
</head>

<body class="column">
  <header>
    <nav class="navbar">
      <a class="nav-title" href="home.php">My Movie List</a>
      <ul class="nav-list">
        <li>
          <form id="form-noui" id="last-nav-button" method="post" action="user.php">
            <input class="nav-buttons" type="submit" name="logout" value="Logout">
          </form>
        </li>
        <li><a class="nav-link" href="home.php">Home</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="center-title-background">
      <h1><?= $_SESSION['username']?>'s Ranking:</h1>
    </div>
    <div class="center" id="image-center-container">
      <div class="grid-container">
        <?php 
        require_once('../app/classes.php');
        for ($i = 0; $i < count($_SESSION['movies']); $i++) {
          if ($i < 20) { //limits output
            echo "
              <div class=\"image-container\">
              <h3></h3>
              <img class=\"image\" src=\"" . $_SESSION['movies'][$i]->getPoster() . "\" alt=\"\">
              <p class=\"image-text\">" . $_SESSION['movies'][$i]->to_string() ."</p>
              </div>
              ";
          }
        }
        ?>
      </div>
  </main>
  <footer>
    <label class="footer-label">Designed by Bernard Olivier</label>
  </footer>
</body>

</html>