<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Movie List</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="center">
        <h1>My Movie List</h1>
        <form action="services/authenticate.php" method="post">
            <div class="flex-container">
                <label class="labels" for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="email" required>

                <label class="labels" for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <button type="submit">Login</button>

                <a id="ref" href="#">Forgot password?</a>
            </div>
        </form>
    </div>
</body>

</html>