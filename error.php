<?php 
session_start();
?>

<!DOCTYPE html>
<html land="en">

<head>
  <title>My Movie List</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/error.css">
</head>

<body>
  <h2><?php echo $_SESSION['error']; ?></h1>
  <a href="index.php">Go to Home Page</a>
  <p> </p>
</body>