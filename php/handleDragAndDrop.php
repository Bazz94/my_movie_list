<?php
// Check that the required variables are assigned 
if (!isset($old, $new)) {
  $_SESSION['error'] = 'Required variables not set handleDragAndDrop.php';
  header('Location: error.php');
  exit;
}

$user_id = $_SESSION['user-id'];

// Get movie positions
$movie_id = $old;
require('get_movie_position.php');
if (!isset($position)) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
  exit;
}
$old_movie_position = $position;

$movie_id = $new;
require('get_movie_position.php');
if (!isset($position) || $old_movie_position == $position) {
  $_SESSION['error'] = 'Get movie position failed';
  header('Location: error.php');
  exit;
}
$new_movie_position = $position;

// Update positions in db
require('swap_movie_positions.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie position failed';
  header('Location: error.php');
  exit;
}
$successful = null;

// Update weight in movies
$movie_id = $old;
$new_position = $new_movie_position;
$old_position = $old_movie_position;
require('update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
  exit;
}
$successful = null;

// Update weight in movies
$movie_id = $new;
$new_position = $old_movie_position;
$old_position = $new_movie_position;
require('update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  header('Location: error.php');
  exit;
}
$successful = null;

// Executed correctly
$successful = true;
?>