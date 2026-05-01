<?php
$host = "artwave-db";
$username = "root";
$password = "root";
$dbname = "music_db";

$conn = new mysqli($host, $username, $password, $dbname, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>