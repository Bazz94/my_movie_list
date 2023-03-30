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
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/user.css">
</head>

<body class="column">
  <header>
    <nav class="row" id="navbar">
      <a id="nav-title" href="home.php">My Movie List</a>
      <div class="nav-space1">
      </div>
      <button class="nav-buttons" id="middle-button" onclick="window.location.href='home.php';">
        Community Ranking
      </button>
      <form id="form-noui" id="last-nav-button" method="post" action="user.php">
        <input class="nav-buttons" type="submit" name="logout" value="Logout">
      </form>
    </nav>
  </header>
  <main>
    <div class="center-title-background">
      <h1><?= $_SESSION['username']?>'s Ranking:</h1>
    </div>
    <div class="row">
      <aside class="aside">
        <div class="column" id="buttons-column">
          <div class="col-space1"></div>
          <!-- if Add has been pressed
                        <input type="text" placeholder="Search a movie..." name="search" id="search" required>
                    end -->
          <button onclick="window.location.href='';">
            Add
          </button>
          <button onclick="window.location.href='';">
            Edit
          </button>
          <button onclick="window.location.href='';">
            Remove
          </button>
          <div class="col-space1"></div>
        </div>
      </aside>
      <section class="center">
        <div class="grid-container">
          <?php 
            require_once '../app/classes.php';
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
      </section>
    </div>
  </main>
  <footer>
    <label class="footer-label">Created by Bernard Olivier</label>
  </footer>
</body>

</html>