<?php
session_start();
include "connect.php";

// Session check
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../index.php"); // Redirect if not logged in
    exit;
}

$username = $_SESSION['admin_username'];

$query = $conn->prepare("SELECT username FROM users WHERE username=?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result(); // ✅ Fix: Get result from query

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Hello  
            <?php 
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "Welcome " . $row["username"];
            } else {
                echo "User not found"; 
            }
            ?> 
        </p>
        <a href="..index.php">Logout</a>
    </div>
</body>
</html>