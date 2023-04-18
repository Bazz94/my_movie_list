<?php
// We need to use sessions, so you should always start sessions using the below code.
require_once('php/classes.php');
session_start();

if (!isset($_SESSION['community-movies'])) {
  $_SESSION['error'] = 'Failed to connect to Movies Database';
  header('Location: error.php');
  exit;
}

// not logged in
if (!isset($_SESSION['logged-in'])) {
  header('Location: home.php');
  exit;
}
// if pressed logout
if(isset($_POST['logout'])){
  require('php/logout.php'); // goes to home page
}

for ($i = 0; $i < count($_SESSION['community-movies']); $i++) {
  $movie_id = $_SESSION['community-movies'][$i]->id;
  if(isset($_POST[$movie_id])){
    require('php/remove_movie.php');
    //get movies from user
  }
}

if (isset($_POST['newMovie'])) {
  require('php/get_user_movies.php');
  $new_position = count($_SESSION['user-movies']) + 1;
  require_once('php/add_movie.php');
}

require('php/get_user_movies.php');

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
  <script id="DragDropTouch" src="https://bernardo-castilho.github.io/DragDropTouch/DragDropTouch.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var script = document.createElement("script");
    script.src = "js/script.js";
    var dragAndDrop = document.createElement("script");
    dragAndDrop.src = "js/dragAndDrop.js";
    dragAndDrop.setAttribute("data", '<?php echo $_SESSION['user-id'];?>');
    // Append the script element to the document
    document.body.appendChild(script);
    document.body.appendChild(dragAndDrop);
  }, false);
  </script>
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
      <h1><?= $_SESSION['username']?>'s Ranking</h1>
    </div>
    <div class="center" id="image-center-container">
      <div class="grid-container">
        <?php 
        require_once('php/classes.php');
        require_once('php/get_user_movies.php');
        for ($i = 0; $i < count($_SESSION['user-movies']); $i++) {
          if ($i < 20) { //limits output
            echo "
              <form draggable=\"true\" class=\"image-container\" method=\"post\" action=\"user.php\">
              <h3></h3>
              <img class=\"image\" src=\"" . $_SESSION['user-movies'][$i]->getPoster() . "\" alt=\"\">
              <p class=\"image-text\">" . $_SESSION['user-movies'][$i]->to_string() ."</p>
              <input class=\"remove-btn\" type=\"submit\" name=\"".$_SESSION['user-movies'][$i]->id."\" value=\"Remove\">
              </form>
              ";
          }
        }
        ?>
        <div id="add-button" class="image-container">
          <h4> </h4>
          <button id="add-new-btn">Add New</button>
        </div>
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