<?php
require_once 'php/classes.php';
session_start();

// Retrieve movies 
require_once('php/get_movies.php'); 

// Check if logged in
if (isset($_SESSION['logged-in'])) {
  header('Location: index.php');
  exit;
}

if (isset($_POST['email'], $_POST['password'])) {
  require('php/authenticate.php'); //will go to home.php if completed successfully
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="js/popups.js" defer></script>
  <script src="js/mobileClickImage.js" defer></script>
</head>

<body>
  <main class="row" id="content">
    <section class="column" id="left-section">
      <section class="center-title-background">
        <a id="title-link" class="title" href="home.php">My Movie List</a>
      </section>
      <section class="login-form">
        <form action="login.php" method="post">
          <div class="column" id="form-column">
            <label class="labels" for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>
            <label class="labels" for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>
            <button type="submit">Login</button>
            <a id="ref" href="#">Forgot password?</a>
            <a id="ref" href="signup.php">Sign up</a>
          </div>
        </form>
      </section>
    </section>
    <section class="column">
      <section class="center">
        <div class="grid-container">
          <?php 
            require_once 'php/classes.php';
            for ($i = 0; $i < count($_SESSION['community-movies']); $i++) {
              if ($i < 9) { //limits output
                echo "
                  <div class=\"image-container\">
                  <h3>". $i+1 ."</h3>
                  <img class=\"image\" src=\"" . $_SESSION['community-movies'][$i]->getPoster() . "\" alt=\"\">
                  <p class=\"image-text\">" . $_SESSION['community-movies'][$i]->to_string() ."</p>
                  </div>
                  ";
              }
            }
          ?>
        </div>
      </section>
    </section>
  </main>

  <?php 
    // is not logged in
    if (isset($_POST['email'], $_POST['password'])) {
      if (!isset($_SESSION['logged-in'])) {
        echo "
        <div id=\"popup-background\">
          <div id=\"popup-container\">
            <h2>".$_SESSION['error']."</h2>
            <button id=\"close-btn\">Close</button>
          </div>
        </div>
        ";
      }
    }
  ?>
</body>

</html>