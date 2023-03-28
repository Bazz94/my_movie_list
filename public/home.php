<?php   
// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>


<!DOCTYPE html>
<html>

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/home.css">
</head>

<body class="column">
  <header>
    <nav class="row" id="navbar">
      <a id="nav-title" href="home.php">My Movie List</a>
      <div class="nav-space1"></div>
      <?php 
      //check to see if user is logged in
        if(!isset($_SESSION['loggedin'])) {
          echo "
          <button onclick=\"window.location.href='login.php';\">
            Login
          </button>
          <button id='last-nav-button' onclick=\"window.location.href='signup.php';\">
            Sign Up
          </button>
          ";
        } else {
        echo "
          <button id='last-nav-button' onclick=\"window.location.href='user.php';\">
            My Ranking
          </button>
          ";
        }
      ?>
    </nav>
  </header>
  <main>
    <div class="center-title-background">
      <h1>Community Ranking:</h1>
    </div>
    <div class="center" id="image-center-container">
      <div class="grid-container">
        <!-- php prints 9 grids -->
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
        <div class="image-container">
          <h3>1</h3>
          <img class="image" src="imgs/movie_poster.png" alt="">
          <p class="image-text">All Quiet on the western front (2022)</p>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <label class="footer-label">Created by Bernard Olivier</label>
  </footer>
</body>

</html>