<?php

$connect = mysql_connect(
    'db',
    'user',
    'password',
    'my_movie_list'
);

$query = 'SELECT * FROM a_table';
$result = mysql_query($connect, $query);

echo '<h1>MySQL Content:</h1>';

while($record = mysql_fetch_assoc($result)) {
    echo '<h2>'.$record['title'].'</h2>';
    echo '<p>'.$record['title'].'</p>';
    echo 'List: ' .$record['title'];
    echo '<hr>';
}

//Database table still needs to be created