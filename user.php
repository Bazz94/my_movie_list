<?php
require_once('php/classes.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check to see if the community movies are set
if (!isset($_SESSION['community-movies'])) {
  $_SESSION['error'] = 'Failed to connect to Movies Database';
  header('Location: error.php');
  exit;
}

// Check to see if the user is logged in
if (!isset($_SESSION['logged-in'])) {
  header('Location: home.php');
  exit;
}

// Check to see if a movie should be removed
if(isset($_GET['remove-movie'])){
  $movie_id = $_GET['remove-movie'];
  require('php/remove_movie.php');
  header('Location: user.php');
}

// Check to see if a movie should be added
if (isset($_POST['newMovie'])) {
  require('php/get_user_movies.php');
  $new_position = count($_SESSION['user-movies']) + 1;
  require_once('php/add_movie.php');
}

if (isset($_GET['new'],$_GET['old'])) {
  $old = $_GET['new'];
  $new = $_GET['old'];
  require('php/handleDragAndDrop.php');
  header('Location: user.php');
}

// Get the user movie list
require('php/get_user_movies.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="imgs/favicon.png">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/user.css">
  <script id="DragDropTouch" src="https://bernardo-castilho.github.io/DragDropTouch/DragDropTouch.js"></script>
  <script src="js/popups.js" defer></script>
  <script src="js/dragAndDrop.js" data="<?php echo $_SESSION['user-id'];?>" defer></script>
  <script src="js/removeButton.js" data="<?php echo $_SESSION['user-id'];?>" defer></script>
</head>

<body class="column">
  <header>
    <nav class="navbar">
      <a class="nav-title" href="home.php">My Movie List</a>
      <ul class="nav-list">
        <li><a class="nav-link" href="home.php?logout=true">Logout</a></li>
        <li><a class="nav-link" href="home.php">Home</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="center-title-background">
      <h1><?= $_SESSION['username']?>'s Ranking</h1>
    </div>
    <div class="center" id="image-center-container">
      <div class="grid-container">
        <?php 
        require_once('php/classes.php');
        require_once('php/get_user_movies.php');
        $count = 0;
        for ($i = 0; $i < count($_SESSION['user-movies']); $i++) {
          $count = $i;
          if ($i < 30) { //limits output
            echo "
              <div draggable=\"true\" class=\"image-container\">
                <h3>". $i+1 ."</h3>
                <img class=\"image\" src=\"".$_SESSION['user-movies'][$i]->getPoster()."\" alt=\"\">
                <p class=\"image-text\">".$_SESSION['user-movies'][$i]->to_string()."</p>
                <button id=\"".$_SESSION['user-movies'][$i]->id."\" class=\"remove-btn\">Remove</button>
              </div>
              ";
          }
        }
        if ($count < 30) {
          echo "
            <div id=\"add-button\" class=\"image-container\">
              <h4> </h4>
              <button id=\"add-new-btn\">Add New</button>
            </div>
          ";
        }
        ?>
      </div>
    </div>
    <footer>
      <label class="footer-label">Designed by Bernard Olivier</label>
    </footer>
  </main>
  <div id="popup-background">
    <form id="popup-container" method="post" action="user.php">
      <h2>Pick a Movie</h2>
      <label class="labels" for="new-movie"><b>Movies</b></label>
      <select class="select" name="newMovie">
        <?php 
        require_once('php/classes.php');
        for ($i = 0; $i < count($_SESSION['community-movies']); $i++) {
          $alreadyAdded = false;
          for ($j = 0; $j < count($_SESSION['user-movies']); $j++) {
            if ($_SESSION['community-movies'][$i]->id == $_SESSION['user-movies'][$j]->id) {
              $alreadyAdded = true;
            }
          }
          if (!$alreadyAdded) {
            echo "
              <option value=\"". $_SESSION['community-movies'][$i]->id ."\">".$_SESSION['community-movies'][$i]->to_string()."</option>
              ";
          }
        }
        ?>
      </select>
      <button type="submit" id="ok-btn">Ok</button>
      <button type="button" id="close-btn">Close</button>
    </form>
  </div>
</body>

</html>