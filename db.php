<?php
$servername = "localhost";
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$database = "capstone"; // Ganti dengan nama database Anda

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
