<?php   
// May have been called during index
require_once('php/classes.php');
session_start();

require_once('php/get_movies.php'); //retrieve movies 
?>


<!DOCTYPE html>
<html>

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/home.css">
</head>

<body class="column">
  <header>
    <nav class="navbar">
      <a class="nav-title" href="home.php">My Movie List</a>
      <ul class="nav-list">
        <?php 
      //check to see if user is logged in
        if(!isset($_SESSION['logged-in'])) {
          echo "
          <li><a class=\"nav-link\" href=\"login.php\">Login</a></li>
          ";
        } else {
        echo "
          <li><a class=\"nav-link\" href=\"user.php\">My List</a></li>
          ";
        }
      ?>
      </ul>
    </nav>
  </header>
  <main>
    <div class="center-title-background">
      <h1>Community Ranking</h1>
    </div>
    <div class="center" id="image-center-container">
      <div class="grid-container">
        <?php 
        require_once('php/classes.php');
        for ($i = 0; $i < count($_SESSION['community-movies']); $i++) {
          if ($i < 30) { //limits output
            echo "
              <div class=\"image-container\">
              <h3></h3>
              <img class=\"image\" src=\"" . $_SESSION['community-movies'][$i]->getPoster() . "\" alt=\"\">
              <p class=\"image-text\">" . $_SESSION['community-movies'][$i]->to_string() ."</p>
              </div>
              ";
          }
        }
        ?>
      </div>
    </div>  
    <footer>
      <label class="footer-label">Designed by Bernard Olivier</label>
    </footer>
  </main>
</body>

</html>