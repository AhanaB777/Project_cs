<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "admin_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = "admin"; // change to your preferred username
$password = "yourSecurePassword"; // change to your secure password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin already exists
$check = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "Admin user already exists.";
} else {
    $stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "✅ Admin user inserted successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}
$check->close();
$conn->close();
?>
