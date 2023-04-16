<?php
// Check that the required variables are assigned 
if (!isset($_POST['new'],$_POST['old'],$_POST['user-id'])) {
  $_SESSION['error'] = 'Required variables not set handleDragAndDrop.php';
  header('Location: user.php');
}

$user_id = $_POST['user-id'];

//get movie positions
$movie_id = $_POST['old'];
include('../php/get_movie_position.php');
if (!isset($position)) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
}
$old_movie_position = $position;

$movie_id = $_POST['new'];
include('../php/get_movie_position.php');
if (!isset($position) || $old_movie_position == $position) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
}
$new_movie_position = $position;

//old movie
//update positions in db
$movie_id = $_POST['old'];
$movie_position = $new_movie_position;
include('../php/update_movie_position.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie position failed';
  header('Location: error.php');
}
$successful = null;

//update weight in movies
$new_position = $new_movie_position;
$old_position = $old_movie_position;
include('../php/update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
}
$successful = null;

//new movie
//update positions in db
$movie_id = $_POST['new'];
$movie_position = $old_movie_position;
include('../php/update_movie_position.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie position failed';
  header('Location: error.php');
}
$successful = null;

//update weight in movies
$old_position = $new_movie_position;
$new_position = $old_movie_position;
include('../php/update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
}
$successful = null;
?>