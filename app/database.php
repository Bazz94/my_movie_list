<?php
//Constants
require('../app/constants.php');

//Create connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection->connect_error) {
    die('Connecting Error' . $connection->connect_error);
}

$query = "SELECT * FROM movies";

$response = @mysqli_query($connection, $query);

$movieid; $title; $date; $production; $director;

if ($response) {
    while ($row = mysqli_fetch_array($response)) {
        $movieid = $row['movieid'];
        $title = $row['title'];
        $date = $row['date'];
        $production = $row['production company'];
        $director = $row['director'];
    }
} else {
    
}

mysqli_close($connection);



?>