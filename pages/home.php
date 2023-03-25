<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>

<html>

<head>
	<meta charset="utf-8">
	<title>My Movie List</title>
	<link href="../styles/home.css" rel="stylesheet" type="text/css">

</head>

<body class="loggedin">
	<nav class="navtop">
		<div>
			<h1>My Movie List</h1>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
		</div>
	</nav>
</body>

</html>