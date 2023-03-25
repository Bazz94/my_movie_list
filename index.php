<!DOCTYPE html>
<html land="en">

<head>
    <title>My Movie List</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <center>
        <h1>My Movie List</h1>
        <form action=" "></form>
        <form action="action_page.php" method="post">

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <button type="submit">Login</button>
                <label id="rememberme">
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>
            <span class="psw"> <a href="#">Forgot password?</a></span>
            </div>
        </form>
    </center>
</body>

</html>