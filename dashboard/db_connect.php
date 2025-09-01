<?php
$servername = "localhost";
$username = "root";          // Change if needed
$password = "";              // Change if you use a password
$database = "college_portal"; // Replace with your actual DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
