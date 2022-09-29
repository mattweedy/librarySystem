<?php
session_start();

$sql = "SELECT * FROM category";
$result = $conn->query($sql);
?>