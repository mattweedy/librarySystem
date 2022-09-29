<!DOCTYPE html>
<?php include_once("../scripts/test_connection.php") ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Library - Register</title>
</head>
<body>
    <header>
        <h1>Welcome to Tweedy's Library</h1>
    </header>
    <div class="form-center">
        <form method="POST" action="../scripts/register.php">
            <h1>Register</h1><br>
            <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error'];?></p>
            <?php }
            ?>
            <label>Username:</label><br>
            <input type="text" name="Username" placeholder="username123" required/><br>
            <label>Password:</label><br>
            <input type="password" name="Password" placeholder="******" required/><br>
            <label>Confirm Password:</label><br>
            <input type="password" name="PwordConfirm" placeholder="******" required/><br>
            <label>First Name:</label><br>
            <input type="text" name="FirstName" placeholder="John" required/><br>
            <label>Surname:</label><br>
            <input type="text" name="Surname" placeholder="Doe" required/><br>
            <label>Address Line 1:</label><br>
            <input type="text" name="AddressLine1" placeholder="12 Beach Road" required/><br>
            <label>Address Line 2:</label><br>
            <input type="text" name="AddressLine2" required/><br>
            <label>City:</label><br>
            <input type="text" name="City"required/><br>
            <label>Telephone:</label><br>
            <input type="text" name="Telephone" placeholder="" required/><br>
            <label>Mobile:</label><br>
            <input type="text" name="Mobile" placeholder="" required/><br><br>
            <input type="submit" value="Submit"/>
        </form>
        <h2>Existing user?</h2>
        <a href="index.php">Login here</a>
    </div>
    <footer>
        <p>&#169;2021 Matthew Tweedy</p>
    </footer>
</body>
</html>