<?php
$conn = new mysqli("localhost", "root", "", "sweetbook");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "MySQLi is working!";
?>
