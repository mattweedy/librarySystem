<?php
session_start();
require_once "test_connection.php";

$isbn = $_GET['isbn'];
$un = $_SESSION['Username'];

$sql = "DELETE FROM reservations WHERE ISBN = '$isbn'";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    echo "<pre>\n$sql\n</pre>\n";

    $sql = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$isbn'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        echo "<pre>\n$sql\n</pre>\n";
        header("location: ../html/reservedBooks.php");
        return;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    return;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>