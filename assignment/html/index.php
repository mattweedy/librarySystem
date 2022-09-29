<!DOCTYPE html>
<?php include_once("../scripts/test_connection.php") ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Library - Login</title>
</head>
<body>
    <header>
        <h1>Welcome to Tweedy's Library</h1>
    </header>
    <div class="form-center">
        <form method="POST" action="../scripts/login.php">
            <h1>Login</h1><br>
            <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error'];?></p>
            <?php }
            ?>
            <label>Username:</label><br>
            <input type="text" name="Username" placeholder="username123"/><br>
            <label>Password:</label><br>
            <input type="password" name="Password" placeholder="******"/><br><br>
            <input type="submit" value="Submit"/>
        </form>
        <h2>New user?</h2>
        <a href="regPage.php">Register here</a>
    </div>
    <footer>
        <p>&#169;2021 Matthew Tweedy</p>
    </footer>
</body>
</html>