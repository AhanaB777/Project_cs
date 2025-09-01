<?php
session_start();
include "connect.php"; // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // ✅ SUCCESS
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_username"] = $user["username"];
            $_SESSION["admin_id"] = $user["id"];

            header("Location: ../dashboard/dashboard.php");
            exit;
        } else {
            $_SESSION['login_error'] = "❌ Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "❌ Admin not found.";
    }

    $stmt->close();
    $conn->close();
    header("Location: login_page.php");
    exit;
} else {
    header("Location: login_page.php");
    exit;
}
