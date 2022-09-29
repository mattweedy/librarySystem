<?php
session_start();
require_once "test_connection.php";

if (isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['FirstName']) && isset($_POST['Surname']) && isset($_POST['AddressLine1']) && isset($_POST['AddressLine2']) && isset($_POST['City']) && isset($_POST['Telephone']) && isset($_POST['Mobile'])) {
    $un = $_POST['Username'];
    $p = $_POST['Password'];
    $pcfrm = $_POST['PwordConfirm'];
    $fn = $_POST['FirstName'];
    $sn = $_POST['Surname'];
    $al1 = $_POST['AddressLine1'];
    $al2 = $_POST['AddressLine2'];
    $cty = $_POST['City'];
    $tp = $_POST['Telephone'];
    $mbl = $_POST['Mobile'];

    function validate_input($user_input) {
        $user_input = trim($user_input);
        $user_input = htmlspecialchars($user_input);
        $user_input = htmlentities($user_input);
        $user_input = stripslashes($user_input);
        
        return $user_input;
    }

    function validate_password_match($user_input, $validate) {
        if ($user_input === $validate) {
            return $user_input;
        } else {
            header("location: ../html/regPage.php?error=*passwords do not match*");
            die();
        }
    }

    function validate_is_not_empty($user_input, $value) {
        if(empty($user_input)){
            array_push($Errors, "%value cannot be empty");
        } else {
            return $user_input;
        }
    }

    function valdiate_is_num ($user_input, $value) {
        if (!is_numeric($user_input)) {
            header("location: ../html/regPage.php?error=*$value must only contain numbers*");
            die();
        } else {
            return $user_input;
        }
    }
    
    function validate_correct_length($user_input, $length, $value) {
        $num_len = strlen((string)$user_input);
        if ($num_len === $length) {
            return $user_input;
        } else {
            header("location: ../html/regPage.php?error=*$value must have length of $length*");
            die();
        }
    }

    // validating input
    $un = validate_input($un);
    $p = validate_input($p);
    $pcfrm = validate_input($pcfrm);
    $fn = validate_input($fn);
    $sn = validate_input($sn);
    $al1 = validate_input($al1);
    $al2 = validate_input($al2);
    $cty = validate_input($cty);
    $tp = validate_input($tp);
    $mbl = validate_input($mbl);

    // checking password and confirm password are a match
    $p = validate_password_match($p, $pcfrm);

    // checking password and mobile are correct lengths
    $p = validate_correct_length($p, 6, "password");
    $mbl = validate_correct_length($mbl, 10, "mobile");

    // checking telephone and mobile only contain numbers
    $tp = valdiate_is_num($tp, "telephone");
    $mbl = valdiate_is_num($mbl, "mobile");

    // checking username doesn't already exist
    $sql = "SELECT * FROM users WHERE Username='$un'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['Username'] === $un) {
            header("location: ../html/regPage.php?error=*username is already taken*");
        }
    }

    $sql = "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$un', '$p', '$fn', '$sn', '$al1', '$al2', '$cty', '$tp', '$mbl')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['Username'] = $un;
        header("location: ../html/library.php");
        die();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>