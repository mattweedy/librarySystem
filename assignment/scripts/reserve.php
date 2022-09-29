<?php
session_start();
require_once "test_connection.php";

$isbn = $_GET['isbn'];
$un = $_SESSION['Username'];
$rflag = $_GET['rflag'];
$page_num = $_SESSION['page_num'];

if ($rflag === 'Y') {
    header("Location: ../html/library.php?error=*book is already reserved*");
} else {
    $sql = "INSERT INTO reservations (ISBN, Username, ReservedDate) VALUES ('$isbn', '$un', now())";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "<pre>\n$sql\n</pre>\n";

        $sql = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$isbn'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            echo "<pre>\n$sql\n</pre>\n";
            header("location: ../html/library.php?page_num=$page_num");
            return;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        return;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>