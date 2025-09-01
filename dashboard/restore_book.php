<?php
include(__DIR__ . "/../config/db_connect3.php");
 
session_start(); 
//session check
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../login/login_page.php");
    exit;
}
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Restore the book by setting is_deleted = 0
    $sql = "UPDATE books SET is_deleted = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "<script>alert('Book restored successfully!'); window.location.href='manage_books.php';</script>";
    } else {
        echo "<script>alert('Failed to restore book.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
