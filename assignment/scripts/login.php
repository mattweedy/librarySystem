<?php
session_start();
require_once "test_connection.php";

if (isset($_POST['Username']) && isset($_POST['Password'])) {
    $un = $_POST['Username'];
    $p = $_POST['Password'];
    
    function validate_input($user_input) {
        $user_input = trim($user_input);
        $user_input = htmlspecialchars($user_input);
        $user_input = htmlentities($user_input);
        $user_input = stripslashes($user_input);
        
        return $user_input;
    }
}

$un = validate_input($un);
$p = validate_input($p);

if (empty($un)) {
    $_SESSION['error'] = $error;
    header("Location: ../html/index.php?error=*you must enter a username*");
    die();
} else if (empty($p)) {
    $_SESSION['error'] = $error;
    header("Location: ../html/index.php?error=*you must enter a password*");
    die();
}

$sql = "SELECT * FROM users WHERE Username='$un' AND Password='$p'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['Username'] === $un && $row['Password'] === $p) {
        $_SESSION['uid'] = $row['uid'];
        $uid = $_SESSION['uid'];
        header("location: ../html/library.php");
        die();
    }
} else {
    header("location: ../html/index.php?error=*username or password is incorrect*");
    die();
}
?>