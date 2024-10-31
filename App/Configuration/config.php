<?php
$servername = "localhost";
$port = '3306';
$username = "root";
$password = "";
$dbname = "e-commerce-sql";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
