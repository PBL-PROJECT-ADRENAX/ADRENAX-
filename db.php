<?php
$conn = new mysqli("localhost", "root", "", "adrenax-db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>