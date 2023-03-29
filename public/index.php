<?php 
require_once('../app/getMovies.php');
session_start();
$_SESSION['movies'] = COMMUNITY_RANKING;
require('home.php'); 
?>