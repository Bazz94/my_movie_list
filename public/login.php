<?php
require_once '../app/classes.php';
session_start();
//is logged in
if (isset($_SESSION['loggedin'])) {
  header('Location: user.php');
}

// Check if data is in SESSION movies
if (!isset($_SESSION['community-movies'])) {
  header('Location: index.php');
}
// first visit
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="js/script.js"></script>
</head>

<body>
  <main class="row" id="content">
    <section class="column" id="left-section">
      <section class="center-title-background">
        <h1 id="title1">My Movie</h1>
        <h1 id="title2">List</h1>
      </section>
      <section id="login-form">
        <form action="login.php" method="post">
          <div class="column" id="form-column">
            <label class="labels" for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>
            <label class="labels" for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>
            <button type="submit">Login</button>
            <a id="ref" href="#">Forgot password?</a>
            <a id="ref" href="signup.php">Sign UP</a>
          </div>
        </form>
      </section>
    </section>
    <section class="column">
      <section class="center" id="center-grid">
        <div class="grid-container">
          <?php 
            require_once '../app/classes.php';
            for ($i = 0; $i < count($_SESSION['community-movies']); $i++) {
              if ($i < 9) { //limits output
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
      </section>
    </section>

  </main>
  <?php 
    // is not logged in
    if (isset($_POST['email'], $_POST['password'])) {
      include('../app/authenticate.php'); //will go to home.php if completed successfully
      if (!isset($_SESSION['loggedin'])) {
        echo "
        <div id=\"popup-background\">
          <div id=\"popup-container\">
            <h2>Error</h2>
            <p>
              ".$_SESSION['error']."
            </p>
            <button id=\"close-btn\">Close</button>
          </div>
        </div>
        ";
      }
    }
  ?>
</body>

</html>