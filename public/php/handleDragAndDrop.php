<?php
//error check???
if (!isset($_POST['new'],$_POST['old'],$_POST['userid'])) {
  exit();
}

//get old movie position
$movie_id = $_POST['old'];
$user_id = $_POST['userid'];
include '../../app/get_movie_position.php';
if (!isset($position)) {
  exit();
}
$old_Movie_Position = $position;

//get new movie position
$movie_id = $_POST['new'];
$user_id = $_POST['userid'];
include '../../app/get_movie_position.php';
if (!isset($position) || $old_Movie_Position == $position) {
  exit();
}
$new_Movie_Position = $position;

//update position in db
$movie_id = $_POST['old'];
$movie_position = $new_Movie_Position;
$user_id = $_POST['userid'];
include '../../app/update_movie_position.php';
if (!isset($successful)) {
  exit();
}
$successful = null;

$movie_id = $_POST['new'];
$movie_position = $old_Movie_Position;
$user_id = $_POST['userid'];
include '../../app/update_movie_position.php';
if (!isset($successful)) {
  exit();
}
?>