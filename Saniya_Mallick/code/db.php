<?php
$conn = new mysqli("db", "root", "root", "music_db", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>