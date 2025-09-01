<?php
// Database credentials
$servername = "localhost";  // usually "localhost" for local development
$username = "root";         // default MySQL username (replace if different)
$password = "";             // default MySQL password (replace if different)
$dbname = "book_db";        // New database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>