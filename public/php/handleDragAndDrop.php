<?php
if (!isset($_POST['new'],$_POST['old'],$_POST['userid'])) {
  echo 'In handleDragAndDrop.php on error line 2';
  exit();
}

//get movie positions
$movie_id = $_POST['old'];
$user_id = $_POST['userid'];
include '../../app/get_movie_position.php';
if (!isset($position)) {
  echo 'In handleDragAndDrop.php on error line 11';
  exit();
}
$old_movie_position = $position;

$movie_id = $_POST['new'];
$user_id = $_POST['userid'];
include '../../app/get_movie_position.php';
if (!isset($position) || $old_movie_position == $position) {
  echo 'In handleDragAndDrop.php on error line 20';
  exit();
}
$new_movie_position = $position;

//old movie
//update positions in db
$movie_id = $_POST['old'];
$movie_position = $new_movie_position;
$user_id = $_POST['userid'];
include '../../app/update_movie_position.php';
if (!isset($successful)) {
  echo 'In handleDragAndDrop.php on error line 32';
  exit();
}
$successful = null;

//update weight in movies
$new_position = $new_movie_position;
$old_position = $old_movie_position;
include '../../app/update_movie_weight.php';
if (!isset($successful)) {
  echo 'In handleDragAndDrop.php on error line 42';
  exit();
}
$successful = null;

//new movie
//update positions in db
$movie_id = $_POST['new'];
$movie_position = $old_movie_position;
$user_id = $_POST['userid'];
include '../../app/update_movie_position.php';
if (!isset($successful)) {
  echo 'In handleDragAndDrop.php on error line 54';
  exit();
}
$successful = null;

//update weight in movies
$old_position = $new_movie_position;
$new_position = $old_movie_position;
include '../../app/update_movie_weight.php';
if (!isset($successful)) {
  echo 'In handleDragAndDrop.php on error line 64';
  exit();
}
$successful = null;
?>