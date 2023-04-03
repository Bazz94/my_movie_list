<?php
require_once '../app/classes.php';
session_start();

if (!isset($_SESSION['movies'])) {
  header('Location: index.php');
}

if (isset($_POST['email'], $_POST['password'])) {
  $create_user = true;
  if (strlen($_POST['password']) < 8){
    $_SESSION['error'] = "Error: Your password is invalid";
    $create_user = false;
  } 
  if (!($_POST['password'] == $_POST['passwordCheck'])) {
    $_SESSION['error'] = "Error: Your passwords do not match";
    $create_user = false;
  }
  if ($create_user) {
    include('../app/create_user.php');  //will go to home.php if completed successfully
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/signup.css">
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
        <form action="signup.php" method="post">
          <div class="column" id="form-column">
            <label class="labels" for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="username" required>
            <label class="labels" for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" id="email" required>
            <label class="labels" for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>
            <label class="labels" for="passwordCheck"><b>Password</b></label>
            <input type="password" placeholder="Enter Password again" name="passwordCheck" id="passwordCheck" required>
            <button type="submit">Sign Up</button>
            <a id="ref" href="login.html">login</a>
          </div>
        </form>
      </section>
    </section>
    <section class="column">
      <section class="center" id="center-grid">
        <div class="grid-container">
          <?php 
            require_once '../app/classes.php';
            for ($i = 0; $i < count($_SESSION['movies']); $i++) {
              if ($i < 9) { //limits output
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
    </section>
  </main>

  <?php
    if (isset($_POST['email'], $_POST['password'])) {
      if (!isset($_SESSION['loggedin'])) {
        echo "
        <div id=\"popup-background\">
          <div id=\"popup-container\">
            <h2>Error</h2>
            <p>
              ". $_SESSION['error'] ."
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