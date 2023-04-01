<?php 
require_once('../app/get_movies.php');
session_start();
$_SESSION['movies'] = COMMUNITY_RANKING;
require('home.php'); 
?>