<?php
$servername = "localhost"; // XAMPP server
$username = "root";         // default username
$password = "";             // default password
$database = "pyq_db";       // your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>