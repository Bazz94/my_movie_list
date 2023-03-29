<?php
// Get constants
require('../app/constants.php');
// Try and connect using the info above.
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  $_SESSION['error'] = 'Failed to connect to MySQL: ' . mysqli_connect_error();
  exit();
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['email'], $_POST['password'])) {
  // Could not get the data that should have been sent.
  $_SESSION['error'] = 'Failed to retrieve email or password: ' . mysqli_connect_error();
  exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT userid, _password, username FROM users WHERE email = ?')) {
  // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
  $stmt->bind_param('s', $_POST['email']);
  $stmt->execute();
  // Store the result so we can check if the account exists in the database.
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password, $username);
    $stmt->fetch();
    // Account exists, now we verify the password.
    // Note: remember to use password_hash in your registration file to store the hashed passwords.
    if (password_verify($_POST['password'], $password)) {
      // Verification success! User has logged-in!
      // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
      session_regenerate_id();
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['username'] = $username;
      $_SESSION['userid'] = $id;
      $_SESSION['email'] = $_POST['email'];
      header('Location: home.php');
    } else {
      $_SESSION['error'] = '(Password) or Email is incorrect';
    }
  } else {
    $_SESSION['error'] = 'Password or (Email) is incorrect';
  }

  $stmt->close();
}

//crypt('12345678','2394a9661a9089208c1c9c65ccac85a91da6a859')
?>