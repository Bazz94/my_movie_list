<?php
error_log("flag \n", 3, $_SERVER['DOCUMENT_ROOT'].'/my_movie_list/log.log');
session_start();
// Check that the required variables are assigned 
if (!isset($_POST['new'],$_POST['old'],$_POST['user-id'])) {
  $_SESSION['error'] = 'Required variables not set handleDragAndDrop.php';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}

// Js vars that are undefined are not caught by isset
if ($_POST['new'] == '' || $_POST['old'] == '' || $_POST['user-id'] == '') {
  $_SESSION['error'] = 'Required variables not set handleDragAndDrop.php';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}

$user_id = $_POST['user-id'];

// Get movie positions
$movie_id = $_POST['old'];
require('get_movie_position.php');
if (!isset($position)) {
  $_SESSION['error'] = 'Get movie position failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}
$old_movie_position = $position;

$movie_id = $_POST['new'];
require('get_movie_position.php');
if (!isset($position) || $old_movie_position == $position) {
  $_SESSION['error'] = 'Get movie position failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}
$new_movie_position = $position;

// Old movie
// Update positions in db
$movie_id = $_POST['old'];
$movie_position = $new_movie_position;
require('update_movie_position.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie position failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}
$successful = null;

// Update weight in movies
$new_position = $new_movie_position;
$old_position = $old_movie_position;
require('update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}
$successful = null;

// New movie
// Update positions in db
$movie_id = $_POST['new'];
$movie_position = $old_movie_position;
require('update_movie_position.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie position failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}
$successful = null;

// Update weight in movies
$old_position = $new_movie_position;
$new_position = $old_movie_position;
require('update_movie_weight.php');
if (!isset($successful)) {
  $_SESSION['error'] = 'Update movie weight failed';
  $responseData = array("status" => "error", "message" => $_SESSION['error']);
  echo json_encode($responseData);
  exit;
}

// Write response for the fetch statement that called this file
$responseData = array("status" => "success");
echo json_encode($responseData);
?>